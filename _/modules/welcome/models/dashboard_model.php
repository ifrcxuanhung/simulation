<?php
class Dashboard_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
		$this->db3 = $this->load->database('database3', TRUE);
        $this->db4 = $this->load->database('database4', TRUE);
    }
	/*function close_market(){
        $this->calcu_abs_by_user_buysell();
        $this->updateOrder();
		$sql = "UPDATE setting SET value = -1 WHERE `key` ='market_making_seconds';";
        $this->db3->query($sql);
        return true;
    }*/
	function close_market(){
		
        $this->calcu_abs_by_user_buysell();
        $this->db3->query("TRUNCATE TABLE order_book_futures_best_limit;");
		
        $this->updateOrder();
        $sql = "UPDATE setting SET value = -1 WHERE `key` ='market_making_seconds';";
   
        $this->db3->query($sql);
        $this->db3->query("UPDATE dashboard_future df SET df.qbid=NULL, df.qask =NULL, df.`bid` =NULL, df.ask =NULL;");
        $this->db3->query("UPDATE dashboard df SET df.qbid=NULL, df.qask =NULL, df.`bid` =NULL, df.ask =NULL;");
        $data_list = $this->db3->query("select group_concat(distinct dsymbol  order by dsymbol asc separator ' , ') dsymbol
         from dashboard_future where settle =0 or settle is null;")->row_array();
        $this->db->query("update web_actions set `comment`='',status=null, `comment`='".$data_list['dsymbol']."' where id=2;");
        $this->db->query("update web_actions set status= if(length(comment)>0, 'NOT OK','OK') where id=2; ");
		
        return true;
    }
    function open_market(){
        // 1. check strike, expiry
        // 2. Chuyen Settle to Pre.Settle
        // 3. Xoa Settle, Last, Change, Var 
        $check = false;
        $query = $this->db3->query("SELECT dsymbol FROM dashboard_future WHERE psettle <=> NULL");
        $this->db3->query("delete from vdm_underlying_intraday where date <> curdate();");
        if($query->num_rows() >= 1){
            $sql = "UPDATE dashboard_future df SET df.psettle = df.settle, df.settle=NULL, df.last =NULL, df.`change` =NULL, df. var =NULL, df.time =NULL, volume =NULL, dvolume =NULL;";
            $this->db3->query($sql);
            $check = true;
        }
        $query = $this->db3->query("SELECT dsymbol FROM dashboard WHERE psettle <=> NULL");
        if($query->num_rows() >= 1){
            $sql = "UPDATE dashboard df SET df.psettle = df.settle, df.settle=NULL, df.last =NULL, df.`change` =NULL, df. var =NULL, df.time =NULL, volume =NULL, dvolume =NULL;";
            $this->db3->query($sql);
            $check = true;
        }
        $this->db3->query("update vdm_underlying_setting as a, vdm_underlying_close as b set a.pclose=b.`close`, a.pdate=b.`date` where a.codeint=b.`code`;");
		$this->db3->query("UPDATE vdm_underlying_setting as a, cmd_quotenet as b SET a.`pdate` = b.`date`, a.pclose=b.close where a.codeint = b.`code`;");
		$sql = "UPDATE setting as a, (select `value` from setting where `key`='market_making_seconds_default') as b SET a.`value` = b.`value` WHERE `key` ='market_making_seconds';";
        $this->db3->query($sql);
        $this->db3->truncate('excution_traded');
        $data_list = $this->db3->query("select group_concat(distinct dsymbol  order by dsymbol asc separator ' , ') dsymbol
         from dashboard_future where psettle =0 or psettle is null;")->row_array();
        $this->db->query("update web_actions set `comment`='',status=null, `comment`='".$data_list['dsymbol']."' where id=1;");
        $this->db->query("update web_actions set status= if(length(comment)>0, 'NOT OK','OK') where id=1; ");
        return $check;
    }
	public function calcu_abs_by_user_buysell(){
		
        $sqlD = 'INSERT INTO dashboard_future_history
                      SELECT * FROM dashboard_future;';
        $this->db3->query($sqlD);
        $sqlDF = 'INSERT INTO dashboard_history
                      SELECT * FROM dashboard;';
        $this->db3->query($sqlDF);
        $sqlET = 'INSERT INTO excution_traded_history (id, expiry, p, q, datetime, dsymbol, type, specs, user_buy, user_sell) SELECT 0,expiry, p, q, datetime, dsymbol, type, specs, user_buy, user_sell FROM excution_traded;';
        $this->db3->query($sqlET);
        $this->db3->truncate('excution_traded_temp');
        $sql = 'SELECT * FROM excution_traded GROUP BY dsymbol, expiry';
        $data = $this->db3->query($sql)->result_array();
        
        $sqlSettleF ='UPDATE dashboard_future SET settle = `theo`, psettle =NULL';
	
        $this->db3->query($sqlSettleF);
        $sqlSettle ='UPDATE dashboard SET settle = `theo`, psettle =NULL';
        $this->db3->query($sqlSettle);
       // print_r($sqlSettle);exit;
       // print_R($data);exit;
      //  $data = $this->db->get('excution_traded') //->where(array('product' => $product, 'expiry' => $expiry))
	  
        if(isset($data)){
           foreach($data as $value){
                if(strtotime($value['expiry']) >= strtotime(date('Y-m-d'))){ // expiry > today
                   $sqlU = 'SELECT user_buy as id FROM excution_traded WHERE dsymbol ="'.$value['dsymbol'].'" AND expiry="'.$value['expiry'].'" GROUP BY user_buy
                            UNION
                            SELECT user_sell as id FROM excution_traded WHERE dsymbol ="'.$value['dsymbol'].'" AND expiry="'.$value['expiry'].'" GROUP BY user_sell;';
                   $rsU = $this->db3->query($sqlU)->result_array();
                   
                   if(isset($rsU)){
					   
		
                       foreach($rsU as $va){
                            $sqlB = 'INSERT INTO excution_traded_temp (id, expiry, dsymbol, buy, sell, abs)
                            SELECT IFNULL(b.user_buy,c.user_sell), IFNULL(b.expiry,c.expiry),IFNULL(b.dsymbol,c.dsymbol),b,s,ABS(b-s) as abs FROM 
                        	(SELECT IFNULL(SUM(q),0) as b, expiry, dsymbol, user_buy FROM excution_traded WHERE user_buy = '.$va['id'].' AND dsymbol ="'.$value['dsymbol'].'" AND expiry="'.$value['expiry'].'") b,
                        	(SELECT IFNULL(SUM(q),0) as s, expiry, dsymbol, user_sell FROM excution_traded WHERE user_sell = '.$va['id'].' AND dsymbol ="'.$value['dsymbol'].'" AND expiry="'.$value['expiry'].'") c';
                           $rsB[] = $this->db3->query($sqlB); 
						 // echo $sqlB;exit;
                       }
					  
                   }
				   
                   if(isset($rsB)){
					   
                       $sqlOI = 'SELECT SUM(abs)/2 as OI FROM excution_traded_temp WHERE expiry="'.$value['expiry'].'" AND dsymbol="'.$value['dsymbol'].'"';     
                       $rsOI = $this->db3->query($sqlOI)->row_array();
					  
                       if($value['type'] == 'FUTURES'){
                            $sqlUOI ='UPDATE dashboard_future SET oi ="'.$rsOI['OI'].'" WHERE expiry="'.$value['expiry'].'" AND dsymbol="'.$value['dsymbol'].'"';
                            $this->db3->query($sqlUOI);
                       }else{
                            $sqlUOI ='UPDATE dashboard SET oi ="'.$rsOI['OI'].'" WHERE expiry="'.$value['expiry'].'" AND dsymbol="'.$value['dsymbol'].'"';
                            $this->db3->query($sqlUOI);
                       }
					  
                       
                   }                              
                }        
            }  
        }
		
        return true;
    }
	
	public function updateOrder(){
        $dfutures = $this->db3->get('vdm_order_futures_daily')->result_array();
		 
        if(isset($dfutures)){
           foreach($dfutures as $value){
                if($value['order_method']=='Daily' || $value['order_method']=='Good to date'){
                    if(strtotime($value['deadline'])<= strtotime(date('Y-m-d'))){
                          $sqlD = "UPDATE vdm_order_futures_daily SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlD);
                    }
                }else if ($value['order_method']=='Good to expiry' || $value['order_method']=='Good to cancel'){
                    if(strtotime($value['expiry'])<= strtotime(date('Y-m-d'))){
                          $sqlE = "UPDATE vdm_order_futures_daily SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlE);
                    }
                }
           }    
        }
		
        $dfuturesall = $this->db3->get('vdm_order_futures_all')->result_array();
		
        if(isset($dfuturesall)){
           foreach($dfuturesall as $value){
                if($value['order_method']=='Daily' || $value['order_method']=='Good to date'){
                    if(strtotime($value['deadline'])<= strtotime(date('Y-m-d'))){
                          $sqlDA = "UPDATE vdm_order_futures_all SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlDA); 
                    }
                }else if ($value['order_method']=='Good to expiry' || $value['order_method']=='Good to cancel'){
                    if(strtotime($value['expiry'])<= strtotime(date('Y-m-d'))){
                          $sqlEA = "UPDATE vdm_order_futures_all SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlEA);
                    }
                }
           }    
        }
		
        $doptions = $this->db3->get('vdm_order_options_daily')->result_array();
		
        if(isset($doptions)){
           foreach($doptions as $value){
                if($value['order_method']=='Daily' || $value['order_method']=='Good to date'){
                    if(strtotime($value['deadline'])<= strtotime(date('Y-m-d'))){
                          $sqlD = "UPDATE vdm_order_options_daily SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlD);
                    }
                }else if ($value['order_method']=='Good to expiry' || $value['order_method']=='Good to cancel'){
                    if(strtotime($value['expiry'])<= strtotime(date('Y-m-d'))){
                          $sqlE = "UPDATE vdm_order_options_daily SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlE);
                    }
                }
           }    
        }
        $doptionsall = $this->db3->get('vdm_order_options_all')->result_array();
		
        if(isset($doptionsall)){
           foreach($doptionsall as $value){
                if($value['order_method']=='Daily' || $value['order_method']=='Good to date'){
                    if(strtotime($value['deadline'])<= strtotime(date('Y-m-d'))){
                          $sqlDA = "UPDATE vdm_order_options_all SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlDA); 
                    }
                }else if ($value['order_method']=='Good to expiry' || $value['order_method']=='Good to cancel'){
                    if(strtotime($value['expiry'])<= strtotime(date('Y-m-d'))){
                          $sqlEA = "UPDATE vdm_order_options_all SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlEA);
                    }
                }
           }    
        }
        $dfuturesdeep = $this->db3->get('order_book_futures_deep1')->result_array();
		
        if(isset($dfuturesdeep)){
           foreach($dfuturesdeep as $value){
                if($value['market_order']=='LOD'||$value['market_order']=='GTD'){
                    if(strtotime($value['deadline'])<= strtotime(date('Y-m-d'))){
                          $sqlDA = "UPDATE order_book_futures_deep1 SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlDA); 
                    }
                }else if ($value['market_order']=='GTE'||$value['market_order']=='GTC'){
                    if(strtotime($value['expiry'])<= strtotime(date('Y-m-d'))){
                          $sqlEA = "UPDATE order_book_futures_deep1 SET `status` = 0 WHERE expiry='{$value['expiry']}' AND dsymbol='{$value['dsymbol']}' AND id ='{$value['id']}';";
                          $this->db3->query($sqlEA);
                    }
                }
           }    
        }
		
        return true;
    }
	
	
	
	
	function getListModel_Modal($product='',$dsymbol='FVNX25')
    {
        if($product == ''){
            return false;
        }else
        {
			$sql = "SELECT vdm_model FROM vdm_contracts_ref WHERE dsymbol = '$dsymbol'";
			$vdm_model = $this->db3->query($sql)->row_array();
			$data = $this->db->select('*')->where("product = '$product' AND $vdm_model[vdm_model] = 1")->get('vdm_model')->result_array();
            //$sql = "SELECT * FROM vdm_model WHERE product = '{$product}'";
        }
       // $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    public function get_result_test_purchased($user=null, $table, $dsymbol=null) {
        if(!is_null($user)) {
			$where_au = "(`user_buy` = '{$user}' OR `user_sell` = '{$user}')";
            $this->db->where($where_au);
        }
        if(!is_null($dsymbol)) {
			$where_ = "`dsymbol` = '{$dsymbol}' ";
            $this->db->where($where_);
        }
        if($table =='excution_traded'){
            $this->db->order_by('datetime', 'desc');
        }else if($table =='order_book_futures_best_limit'){
            $this->db->order_by('expiry', 'asc');
        }else {
            $this->db->order_by('id', 'asc');
        }
        return $this->db->get($table)
                        ->result_array();
                        
    }
   
    function checkCodeInt($code){
       $query = $this->db_vnefrc->query("SELECT * FROM efrc_ins_stat WHERE `code` = '{$code}'");
       $check = false;
       if($query->num_rows() >= 1){
            $check = true;
       }
       return $check;  
    }
   
    function create_table_markettemp($dsymbol=''){
		if($dsymbol==''){
			/*$data = $this->db3->query("SELECT * FROM vdm_contracts_setting WHERE (oblig = '1' OR `user` =1) 
AND active = 1 AND product LIKE '%FUTURES%' AND `dsymbol` IN 
(select abc.dsymbol from vdm_contracts_ref abc where abc.market_making_futures = 1  and abc.codeint in(SELECT vus.`codeint` FROM vdm_underlying_setting vus 
WHERE vus.active != 0));")->result_array();*/

			$data = $this->db3->query("SELECT * FROM vdm_contracts_setting WHERE (oblig = '1' and `user` <>1) 
AND active = 1 AND product LIKE '%FUTURES%' AND `dsymbol` IN 
(select abc.dsymbol from vdm_contracts_ref abc where abc.market_making_futures = 1  and abc.codeint in(SELECT vus.`codeint` FROM vdm_underlying_setting vus 
WHERE vus.active != 0))
UNION
SELECT * FROM vdm_contracts_setting WHERE (oblig = '1' and `user` =1) 
AND active = 1 AND product LIKE '%FUTURES%';")->result_array();

			$this->db3->query('CREATE TABLE IF NOT EXISTS market_temp(user_id int, dsymbol varchar(100), expiry date, bid double, mid DOUBLE,ask DOUBLE,underlying Double, r Double, dividend double, qbid int, qask int, `timestamp` varchar(100), status int);');
			$this->db3->query('TRUNCATE TABLE market_temp;');
		}
		else {
			$data = $this->db3->query("SELECT * FROM vdm_contracts_setting WHERE (oblig = '1' OR `user` =1) AND active = 1 AND product LIKE '%FUTURES%' AND `dsymbol`='{$dsymbol}';")->result_array();
			$this->db3->query('CREATE TABLE IF NOT EXISTS market_temp(user_id int, product varchar(100), expiry date, bid double, mid DOUBLE,ask DOUBLE,underlying Double, r Double, dividend double, qbid int, qask int, `timestamp` varchar(100), status int);');
			$this->db3->query("DELETE FROM market_temp WHERE dsymbol = '{$dsymbol}';");
		}
        $checked = $this->db3->query("SELECT user_id FROM login_users WHERE mm_active = 1")->result_array();
        foreach($checked as $v){
            $ar['user_id'][] = $v['user_id'];
        }
        //echo "<pre>";print_R($data);exit;
        foreach($data as $value){
            if(in_array($value['user'],$ar['user_id'])){
                $t = explode(" ",microtime());
                $micro_date = date("Y-m-d H:i:s",$t[1]).substr((string)$t[0],1,4);
                //$micro_date = date("Y-m-d H:i:s.u");
                $user_id = $value['user'];
                $dsymbol = $value['dsymbol'];
                $order_type = 'Limit order';
                $method_type = 'Daily';
                $expiry = $value['expiry'];
              //  $b_s = array('B','S');
//                $price_val = '';
//                $quantity_val ='';
                $type_theo = '3';
//                $interest = '';
//                $divident= '';
                $dead = date('Y-m-d');
                $l = $this->db3->query("SELECT `last` FROM vdm_underlying_setting vus where vus.codeint in (select codeint from vdm_contracts_ref WHERE `dsymbol` = '{$dsymbol}')")->row_array();
                $S = round($l['last'],2);
        		$R = $value['r'];
                $C = $value['c'];
        		$T = ((strtotime($value['expiry']) - strtotime(date('Y-m-d'))) / 86400) + 1;
                $TT = $T/360;
    			$Q = $value['dividend_vl'];
    			$RR = $R / 100;
    			$QQ = $Q;
                $CC = $C / 100;
    		//	$theo = $this->Ftheo($S, $RR, $T, $QQ,3);
          //  print_R($CC.'__'.$T.'_____________________');exit;
                $theo =  $S * exp($CC*$TT);
                $mid = 	ceiling($theo,$value['tick']);
				
				$maxspd = $value['maxspd']/(1+rand(0,10))/100;
				$chims_mid = rand(1,10)/10;
				$chims1 = $maxspd * $chims_mid;
				$chims2 = $maxspd * (1-$chims_mid);
        		$bid = ceiling($theo - ((($chims1)*$theo)),$value['tick']);
                $ask = ceiling($theo + ((($chims2)*$theo)),$value['tick']);
                
                $this->db3->query("INSERT INTO market_temp (user_id, expiry, bid, mid, ask, underlying, r, dividend, qbid, qask, `timestamp`, dsymbol,status) 
                                                   VALUES('{$value['user']}','{$value['expiry']}','{$bid}','{$mid}','{$ask}','{$S}','{$R}','{$Q}','{$value['qb']}','{$value['qa']}','{$micro_date}','{$value['dsymbol']}', 0)");
				/*echo "<pre>";print_r("INSERT INTO market_temp (user_id, expiry, bid, mid, ask, underlying, r, dividend, qbid, qask, `timestamp`, dsymbol) 
                                                   VALUES('{$value['user']}','{$value['expiry']}','{$bid}','{$mid}','{$ask}','{$S}','{$R}','{$Q}','{$value['qb']}','{$value['qa']}','{$micro_date}','{$value['dsymbol']}')");	*/							   
               // if (strtolower(trim($value['product'])) == 'futures'){
//                       $status[] = $this->dashboard->insert_daily_futures($user_id,$micro_date,$product,$order_type,$method_type,$expiry,'B',$bid,$value['qb'],$type_theo,$R, $Q, $dead); 
//                       $status[] = $this->dashboard->insert_daily_futures($user_id,$micro_date,$product,$order_type,$method_type,$expiry,'S',$ask,$value['qa'],$type_theo,$R, $Q, $dead);
//                }
                //else{
                   // $strike = isset($_POST['strike']) ? $_POST['strike'] : "";
//                    $type1 = isset($_POST['type1']) ? $_POST['type1'] : "";
//                    $volat = isset($_POST['volat']) ? $_POST['volat'] : "";
//                    $status[$k][] =  $this->dashboard->insert_daily_options($user_id,$micro_date,$product,$type1, $order_type,$method_type,$expiry,$b_s,$price_val,$quantity_val,$type_theo,$interest, $divident, $volat, $strike, $dead);
          //      }
            }
        }
        return TRUE;//json_encode($status);
    }
    
    function insert_order_auto($array = array()){
        //print_R($array);exit;
        foreach($array as $value){
            if($value['underlying'] != 0){
                if($value['user_id'] != 1){
                  
                $today = date('Y-m-d');
                $id = $this->db3->query("SELECT id FROM vdm_order_futures_daily vofd WHERE vofd.expiry = '{$value['expiry']}' AND vofd.id_user = {$value['user_id']} AND vofd.dsymbol = '{$value['dsymbol']}' AND vofd.deadline='{$today}'")->result_array();
               // print_r($this->db->last_query());exit;
                if(isset($id)){
                    foreach($id as $va){
                        $this->delete_order($va['id'].'_futures');
                    
                    }
                }
                //print_R($value);
                $micro_date = date("Y-m-d H:i:s");
                $user_id = $value['user_id'];
                $dsymbol = $value['dsymbol'];
                $order_type = 'Limit order';
                $method_type = 'Daily';
                $expiry = $value['expiry'];
              //  $b_s = array('B','S');
//                $price_val = '';
//                $quantity_val ='';
                $type_theo = '3';
//                $interest = '';
                $divident= $value['dividend'];
                $dead = date('Y-m-d');
        		$R = $value['r'];
        		$T = ((strtotime($value['expiry']) - strtotime(date('Y-m-d'))) / 86400) + 1;		
        		$bid = $value['bid'];
                $ask = $value['ask'];
                if($value['status'] != 1){
                    $this->insert_daily_futures($user_id,$micro_date,$dsymbol,$order_type,$method_type,$expiry,'B',$bid,$value['qbid'],$type_theo,$R, $divident, $dead); 
                    $this->insert_daily_futures($user_id,$micro_date,$dsymbol,$order_type,$method_type,$expiry,'S',$ask,$value['qask'],$type_theo,$R, $divident, $dead);
                    $this->db3->query("UPDATE market_temp SET status = 1 WHERE dsymbol = '{$dsymbol}' AND user_id = '{$user_id}' AND expiry = '{$expiry}' ");
                }
                //else{
                   // $strike = isset($_POST['strike']) ? $_POST['strike'] : "";
//                    $type1 = isset($_POST['type1']) ? $_POST['type1'] : "";
//                    $volat = isset($_POST['volat']) ? $_POST['volat'] : "";
//                    $status[$k][] =  $this->dashboard->insert_daily_options($user_id,$micro_date,$product,$type1, $order_type,$method_type,$expiry,$b_s,$price_val,$quantity_val,$type_theo,$interest, $divident, $volat, $strike, $dead);
          //      }
              }else if($value['user_id'] == 1){
                  $this->db3->query("UPDATE dashboard_future df SET df.theo = '{$value['mid']}' WHERE df.expiry = '{$value['expiry']}' AND df.dsymbol = '{$value['dsymbol']}'");
              }
          }
        }
       // print_R($status);
        return true;
    }
    
    function getlistvdm_order($order_type = ''){
        if($order_type == ''){
            $sql = "SELECT * FROM vdm_order Group By order_type";
        }else {
            $sql = "SELECT * FROM vdm_order WHERE order_type = '{$order_type}'";
        }
        $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    function getdashboardTable($type = '', $limit = null , $sort_by = '', $attrSort = '', $date, $dsymbol ='') {
        if($dsymbol !='') $pd_where = " AND dsymbol ='".$dsymbol."' ";
		else $pd_where ="";
        IF(strtoupper($type) == 'PUT' || strtoupper($type) == 'CALL')
        {
            if($date != ''){
                IF($limit == 7)
                {
                    $sql = "SELECT * ";
                    $sql.= "FROM dashboard tb ";
                    $sql.= "WHERE tb.type = '{$type}' and (tb.nr BETWEEN -3 AND 3) and tb.expiry = '$date' ";
					$sql .=$pd_where;
                    $sql.= "ORDER BY tb.{$sort_by} {$attrSort} LIMIT 0,{$limit}";
                }
                ELSE IF($limit == 5)
                {
                    $sql = "SELECT * ";
                    $sql.= "FROM dashboard tb ";
                    $sql.= "WHERE tb.type = '{$type}' and (tb.nr BETWEEN -2 AND 2) and tb.expiry = '$date' ";
					$sql .=$pd_where;
                    $sql.= "ORDER BY tb.{$sort_by} {$attrSort} LIMIT 0,{$limit}";
                }
            }else
            {
                return '';
            }
            
        }ELSE
        {
            $sql = "SELECT * ";
            $sql.= "FROM dashboard_future tb ";
            $sql.= "WHERE tb.type = '{$type}' and tb.expiry >= '". date('Y-m-d')."' ";
			$sql .=$pd_where;
            $sql.= "GROUP BY tb.expiry ";
            $sql.= "ORDER BY tb.{$sort_by} {$attrSort} LIMIT 0,{$limit}";
        }
               
        $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    function getDataPurchaseModal($type_modal = '', $key_modal = '',$attr_modal = '' ,$option_modal = '',$dsymbol=''){
        if($type_modal != ''){
            if(strtoupper($attr_modal) == 'FUTURES'){
               $sql ="SELECT tb.*,vcr.format FROM dashboard_future tb left join vdm_contracts_ref vcr on tb.dsymbol = vcr.dsymbol WHERE tb.type LIKE '%{$attr_modal}%' and tb.expiry = '{$key_modal}'";
            }else if (strtoupper($attr_modal) == 'OPTIONS'){
               $key_modal = explode(',',$key_modal);
               //print_R($key_modal);exit;
               $sql = "SELECT tb.*,vcr.format FROM dashboard_future tb left join vdm_contracts_ref vcr on tb.dsymbol = vcr.dsymbol WHERE tb.type LIKE '%{$option_modal}%' and tb.strike = '{$key_modal[0]}' and tb.expiry = '{$key_modal[1]}'";         
            }
        }
		if($dsymbol!='') $sql .=" and tb.dsymbol ='".$dsymbol."';";
       // print_R($sql);exit;
        $data = $this->db3->query($sql)->result_array();
		//echo "<pre>";print_r($data);exit;
        return $data;     
    }
    
    function getDataRefreshExpiry($expiry = '',$option_modal = '',$dsymbol='', $attr_modal=''){
        if(strtoupper($attr_modal) == 'FUTURES'){
           $sql ="SELECT * FROM dashboard_future tb WHERE tb.type LIKE '%{$attr_modal}%' and tb.expiry = '{$expiry}'";
        }else if (strtoupper($attr_modal) == 'OPTIONS'){
           $sql = "SELECT * FROM dashboard tb WHERE tb.type LIKE '%{$option_modal}%' and tb.expiry = '{$expiry}'";         
        }
		if($dsymbol!='') $sql .=" and dsymbol ='".$dsymbol."';";
        $data = $this->db3->query($sql)->result_array();
        return $data;     
    }
    
    function getDataPurchaseModal2($expiry = '', $product = '',$code=''){
        if($product != ''){
            //print_r($expiry);exit;
         //  if(!is_array($expiry)){
                $key = explode(',',$expiry);
        //   }
           if(count($key) > 1){
                $sql = "SELECT * FROM vdm_contracts_setting_exc cse WHERE cse.active = 1 and cse.product like '%".strtoupper($product)."%' and cse.expiry = '{$key[1]}'";         
           }else
           {
                $sql = "SELECT * FROM vdm_contracts_setting_exc cse WHERE cse.active = 1 and cse.product like '%".strtoupper($product)."%' and cse.expiry = '{$expiry}'";
           }
        }
		if($code!='') $sql .=" and dsymbol ='".$code."';";
       // print_R($sql);exit;
        $data = $this->db3->query($sql)->result_array();
        return $data;     
    }
    
    function getDecimal($expiry, $user, $product) {
        $decimal = 0;
        $sql = "SELECT tick ";
        $sql.= "FROM vdm_contracts_setting_exc mms ";
        $sql.= "WHERE mms.expiry = '{$expiry}' and mms.user = '{$user}' and mms.product = '{$product}' ";
        $data = $this->db3->query($sql)->row_array();
       // echo $sql;
        $number = isset($data) ? $data['tick'] :  '0.01' ;
       // print_r($data);
        if(sqrt($number*$number) >= 1)
        {
            $decimal = 0;
            
        }else{
            
            $decimal = strlen(sqrt($number*$number)) - 2;
        }  
        return $decimal;
    }
    
    function getcodeIndexTab($product='') {
        $sql = "SELECT * ";
        $sql.= "FROM vdm_underlying_setting ixs ";
		if($product=='') {
			 $sql.= "WHERE ixs.home = '1' and undtype='I' ";
		}
		else {
         $sql.= "WHERE ixs.active = '1' and dsymbol='".$product."' ";
		}
//        print_R($sql);exit;
        $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    function getcodeIndexByCodeInt($product='') {
        $sql = "SELECT vcr.format,ixs.* ";
        $sql.= "FROM vdm_underlying_setting ixs left join vdm_contracts_ref vcr ON ixs.dsymbol = vcr.dsymbol ";
		if($product=='') {
			 $sql.= "WHERE ixs.home = '1' and undtype='I' ";
		}
		else {
         $sql.= "WHERE (ixs.active = '1' OR ixs.active = '2') and ixs.codeint='".$product."' ";
		}
   
        $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    function getallcode($product='') {
        $sql = "SELECT * ";
        $sql.= "FROM vdm_contracts_setting_exc ixs ";
		if($product=='') {
			$sql.= "WHERE ixs.active = '1'";
		}
		else {
            $sql.= "WHERE ixs.active = '1' and code='".$product."' ";
		}
        $sql.=" GROUP BY code";
        $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    
    
     public function getSampleCode($where = array()) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->select(array('SHORTNAME', 'CODE'));
        $this->db->where('VNXI',1);
        $rows = $this->db->get('idx_sample')->result_array();
        $data = array();
        if (!empty($rows)) {
            foreach ($rows as $key => $row) {
                $data[$row['CODE']] = $row['SHORTNAME'];
                unset($rows[$key]);
            }
        }
        return $data;
    }

    public function getClose($code) {
        $this->db->where('CODE', $code);
        $this->db->select(array('CLOSE', 'DATE'));
        $this->db->order_by('DATE', 'ASC');
        $rows = $this->db->get('idx_month_chart')->result_array();
        $data = array();
        if (!empty($rows)) {
            foreach ($rows as $key => $item) {
                $data[$key][] = strtotime("+1 day", strtotime($item['DATE'])) * 1000;
                $data[$key][] = $item['CLOSE'] * 1;
            }
        }
        return $data;
    }
    
     public function getClose2($code,$frequency) {
        $this->db->where('CODE', $code);
        $this->db->select(array('CLOSE', 'DATE'));
        $this->db->order_by('DATE', 'ASC');
        $rows = $this->db->get('idx_'.$frequency)->result_array();
        $data = array();
        if (!empty($rows)) {
            foreach ($rows as $key => $item) {
                $data[$key]['date'] = strtotime("+1 day", strtotime($item['DATE'])) * 1000;
                $data[$key]['value'] = $item['CLOSE'] * 1;
            }
        }
        return $data;
    }
    
    
    
    //Edit by Tooltip
    public function list_article_cate($codeCate, $limit = null)
    {
        $lang = $this->session->userdata('curent_language');
        $lang = $lang['code'];

        $lang_default = $this->session->userdata('default_language');
        $lang_default = $lang_default['code'];
        $data = '';
        if ($limit)
        {
            $limit = "LIMIT $limit";
        }

        $sql = "select category_id from category where category_code = '$codeCate'";
        $rows = $this->db3->query($sql)->result_array();
        //print_r($rows);exit;
        if (!empty($rows))
        {
            $listcodeCate = $this->ds_code_cate_news($rows[0]['category_id']);
            $cate = $rows[0]['category_id'];
            foreach ($listcodeCate as $key => $value)
            {
                $cate .= "," . $value['category_id'];
            }
            $sql = 'SELECT d.article_id,d.title,d.description,d.long_description,n.date_added,n.article_id as newsid,n.category_id,n.image,n.date_added,n.url, REPLACE(n.url,"http://","") as url1, c.name as catename,
                    (SELECT category.category_code FROM category WHERE category.category_id = n.category_id LIMIT 1) category_code, d.meta_keyword
                    FROM article n, article_description d, category_description c
                    WHERE 
                        n.category_id in (' . $cate . ') 
                    AND 
                        n.article_id = d.article_id 
                    AND 
                        d.lang_code = "' . $lang . '"
                    AND 
                        c.lang_code = "' . $lang . '" 
                    AND 
                        c.category_id = n.category_id 
                    ORDER BY d.title ASC ' . $limit;
            $sqlDF = 'SELECT d.article_id,d.title,d.description,d.long_description,n.date_added,n.article_id as newsid,n.category_id,n.image,n.date_added,n.url, REPLACE(n.url,"http://","") as url1,c.name as catename,
                    (SELECT category.category_code FROM category WHERE category.category_id = n.category_id LIMIT 1) category_code, d.meta_keyword
                    FROM article n, article_description d, category_description c
                    WHERE 
                        n.category_id in (' . $cate . ') 
                    AND 
                        n.article_id = d.article_id 
                    AND 
                        d.lang_code = "' . $lang_default . '"
                    AND 
                        c.lang_code = "' . $lang_default . '" 
                    AND 
                        c.category_id = n.category_id 
                    ORDER BY d.title ASC ' . $limit;
            $data['curent'] = $this->db3->query($sql)->result_array();
            $data['default'] = $this->db3->query($sqlDF)->result_array();
            if ($data['curent'] || empty($data['curent']))
            {
                $data['curent'] = replaceValueNull($data['curent'], $data['default']);
            }
        }
        return $data;
    }
    
     public function ds_code_cate_news($parent_id = '', $data = NULL)
    {
            $lang = $this->session->userdata('curent_language');
            $lang = $lang['code'];
        
            $lang_default = $this->session->userdata('default_language');
            $lang_default = $lang_default['code'];
            
            if (!$data)
                $data = array();
    
            $sql = "select * from category where parent_id = '$parent_id' order by sort_order ASC";
            $row = $this->db3->query($sql)->result_array();
    
            if (count($row) > 0)
                foreach ($row as $key => $value)
                {
      
                    $sql = "select `name` from category_description where category_id = '{$value['category_id']}' and lang_code = '{$lang}'";
                    $name = $this->db3->query($sql)->result_array();
    
                    $data[] = array('category_id' => $value['category_id'], 'name' => $name[0]['name']);
                    $data = $this->ds_code_cate_news($value['category_id'], $data);
                }
            return $data;
    }
    
    //Edit by Tooltip End
    
    
     function getuseronlmarketmaker($PRODUCT){
        $sql = "SELECT vdcs.*";
        $sql .= "FROM vdm_contracts_setting vdcs, vdm_underlying_setting vdus ";
        $sql .= "WHERE vdcs.`user` <> 0 ";
        $sql .= "and vdcs.`code` = vdus.`code` "; 
        $sql .= "and vdus.active = 1 and vdcs.product = '{$PRODUCT}' ";
        $sql .= "GROUP BY vdcs.`user` ";
        $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    

	function compareFloats($a, $b){
		list($a_int, $a_dec) = explode('.', strval($a));
		list($b_int, $b_dec) = explode('.', strval($b));
	
		if(intval($a_int) == intval($b_int) && intval($a_dec) == intval($b_dec)){
			return 'same';

		}else{
			if((intval($a_int) < intval($b_int)) || (intval($a_int) === intval($b_int) && intval($a_dec) < intval($b_dec))){
				return 'smaller';
			}
			if((intval($a_int) > intval($b_int)) || (intval($a_int) === intval($b_int) && intval($a_dec) > intval($b_dec))){
				return 'bigger';
			}
			return 'error';
		}
	}


    
   function insert_daily_futures($id_user, $datetime, $dsymbol, $order_type, $method_type, $expiry, $b_s, $price=null, $quantity_val, $model, $interest, $dividend, $deadline = null){
	   //var_export($price);die();
	   $price=floatval(str_replace(',','',$price));
       
       if(str_replace(' ','',strtolower($method_type))=='goodtodate'){$method = 'GTD';}else if(str_replace(' ','',strtolower($method_type))=='goodtoexpiry'){$method = 'GTE';}else if(str_replace(' ','',strtolower($method_type))=='goodtillcancelled'){$method = 'GTC';}else{$method = 'LOD';};
	   $market_order = $order_type == 'Market order' ? "FOK" : $method;
	   $b_s = substr($b_s, 0, 1);
       $result1 = array();
	   //
       $sql = 'select * from order_book_futures_best_limit where `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" Limit 1';
	   $best_limit = $this->db3->query($sql)->row_array();
	  
	   if($market_order !='FOK'){
	       if($price!=0){
		   
		  
		   if(!isset($best_limit['id'])){
			   $status = $quantity_val;
			   $status_limit = 1;
			  if($b_s=="B"){
				  $insert_best_limit = "INSERT INTO order_book_futures_best_limit (
					   `expiry`,`qbid`,`bid`,`ask`,`qask`,`dsymbol`)
					   VALUES ('".$expiry."','".$quantity_val."','".$price."','-', '-','".$dsymbol."');
					   ";
				  $status_best_limit = $this->db3->query($insert_best_limit);
				  $update_dashboard_future = "UPDATE dashboard_future Set `qbid` = '".$quantity_val."' , `bid`='".$price."' , `qask` = '-' , `ask` ='-', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and type like '%FUTURES%'";
				  $status_dashboard_future = $this->db3->query($update_dashboard_future);
			   }
			   else {
				   $insert_best_limit = "INSERT INTO order_book_futures_best_limit (
				   `expiry`,`qbid`,`bid`,`qask`,`ask`,`dsymbol`)
				   VALUES ('".$expiry."','-','-','".$quantity_val."','".$price."','".$dsymbol."');
				   ";
				   $status_best_limit = $this->db3->query($insert_best_limit);
				   $update_dashboard_future = "UPDATE dashboard_future Set `qbid` = '-' , `bid`='-' , `qask` = '".$quantity_val."' , `ask` ='".$price."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and type like '%FUTURES%'";
				  $status_dashboard_future = $this->db3->query($update_dashboard_future);
			   }
						   
		   }
		   else {
		       
			   if($b_s=="B"){
				   
				   if(($best_limit['ask']>0) && (floatval(str_replace(',','',$best_limit['ask']))<=$price)){					   
					   $sql_best_limit_s = 'select * from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="S" and `p` <="'.$price.'" and `status` >0 Order by `p` ASC, `datetime` ASC';
					   
					   $arr_limit_s = $this->db3->query($sql_best_limit_s)->result_array();
					   $i =0;
					   $k = 0;
					   $status = $quantity_val;
					   foreach($arr_limit_s as $best_limit_s){
						     if($i>=$quantity_val) break;		
						   $k += $best_limit_s["status"];
                          
                         //  $dvolume += $best_limit_s['q'];				  						  
						   if($quantity_val>=$k){
							   $insert_q = $best_limit_s["status"];
						   }
						   else {
							   $insert_q = $quantity_val - $i;
						   }
						   $status -=$insert_q;
						   $update_deep1 = "UPDATE vdm_order_futures_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep1 = $this->db3->query($update_deep1);
						   $update_deep1 = "UPDATE order_book_futures_deep1 Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
				  		   $status_update_deep1 = $this->db3->query($update_deep1);
						   $insert_excu_trade_s = "INSERT INTO excution_traded (
									   `user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`)
									   VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s['p']."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','FUTURES','".date('M-Y',strtotime($best_limit_s['expiry']))."'); ";
						  $status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
						  //get last
						  $sql_last = 'select * from dashboard_future where `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and type like "%FUTURES%" Limit 1';
		   				  $q_last = $this->db3->query($sql_last)->row_array();
						  if(isset($q_last['psettle']) && $q_last['psettle'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
						  }
		   				  else {
							  $var="`var`=NULL ";
							  $change="`change`=NULL ";	
						  }
						  $update_dashboard_future = "UPDATE dashboard_future Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and type like '%FUTURES%'";
				  		  $status_dashboard_future = $this->db3->query($update_dashboard_future);
						  $i += $best_limit_s["status"];
                          $this->update_dashboard_futures_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],'FUTURES');						
					   }				   													   
				   }
				   else {
					    $status = $quantity_val;
				   }
				    
			   }
			   else {
				   
				  
				   
				  if(($best_limit['bid']!='-') && (floatval(str_replace(',','',$best_limit['bid']))>=$price)){					   
					   $sql_best_limit_s = 'select * from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="B" and `p` >="'.$price.'" and `status` >0 Order by `p` DESC, `datetime` ASC';
					   $arr_limit_s = $this->db3->query($sql_best_limit_s)->result_array();
					   $i =0;
					   $k = 0;
					   $status = $quantity_val;
					   foreach($arr_limit_s as $best_limit_s){
						    if($i>=$quantity_val) break;	
						   $k += $best_limit_s["status"];				  						  
						   if($quantity_val>=$k){
							   $insert_q = $best_limit_s["status"];
						   }
						   else {
							   $insert_q = $quantity_val - $i;
						   }
						   $status -=$insert_q;
						   $update_deep1 = "UPDATE vdm_order_futures_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep1 = $this->db3->query($update_deep1);
						   $update_deep1 = "UPDATE order_book_futures_deep1 Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep1 = $this->db3->query($update_deep1);
						   $insert_excu_trade_s = "INSERT INTO excution_traded (
									   `user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`)
									   VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','FUTURES','".date('M-Y',strtotime($best_limit_s['expiry']))."'); ";
							$status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
							$sql_last = 'select * from dashboard_future where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and type like "%FUTURES%" Limit 1';
							
		   				  $q_last = $this->db3->query($sql_last)->row_array();
						 
						  if(isset($q_last['psettle']) && $q_last['psettle'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
						  }
		   				  else {
							  $var="`var`=NULL ";	
							  $change="`change`=NULL ";	
						  }
						  $update_dashboard_future = "UPDATE dashboard_future Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and type like '%FUTURES%'";
				  		  $status_dashboard_future = $this->db3->query($update_dashboard_future);
							$i += $best_limit_s["status"];	
                            $this->update_dashboard_futures_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],'FUTURES');					
					   }				   													   
				   }
				   else {
					    $status = $quantity_val;
				   }
			   
				}	
		   }
		  $sql = "INSERT INTO vdm_order_futures_daily (
				   id_user, datetime, dsymbol, order_type, order_method, model, expiry, `b/s`, interest, dividend, price, quantity,status, deadline )
				   VALUES ('{$id_user}','{$datetime}','{$dsymbol}','{$order_type}','{$method_type}','{$model}','{$expiry}','{$b_s}','{$interest}','{$dividend}','{$price}','{$quantity_val}','{$status}', '{$deadline}');";
				  			   
		   $result = $this->db3->query($sql);
		    
		   //print_r($status);exit;
		   $id = $this->db->insert_id();
		   if($result>0){
				$sql1 = "INSERT INTO order_book_futures_deep1 (
				   id, id_user, `datetime`, dsymbol, expiry, `b/s`, p, q, market_order,status, deadline )
				   VALUES ('{$id}','{$id_user}','{$datetime}','{$dsymbol}', '{$expiry}','{$b_s}', '{$price}','{$quantity_val}','{$market_order}','{$status}','{$deadline}');
				   ";
			   $result1 = $this->db3->query($sql1);
		   } 
		  
		   $sql = 'select max(`p`) as max from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="B" and status <>0';
		   $price_b = $this->db3->query($sql)->row_array();
		   if(isset($price_b["max"])){
			   $sql = 'select sum(`status`) as qbid from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="B" and `p`="'.$price_b["max"].'" and status <>0';
			   $sum = $this->db3->query($sql)->row_array();
			   $qbid = $sum["qbid"];
			   $bid = $price_b["max"];
		   }
		   else {
				$qbid = "-";
				$bid = "-";				   
		   }
		  
			$sql = 'select min(`p`) as min from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="S" and status <>0';
			   $price_s = $this->db3->query($sql)->row_array();
			   if(isset($price_s["min"])){
				   $sql = 'select sum(`status`) as qask from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
				   $sum = $this->db3->query($sql)->row_array();
				   $qask = $sum["qask"];
				   $ask = $price_s["min"];
			   }
			   else {
					$qask = "-";
					$ask = "-";				   
			   }
			    
			    $update_best_limit = "UPDATE order_book_futures_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry."' AND `dsymbol`='".$dsymbol."'";
				$status_best_limit = $this->db3->query($update_best_limit);
				 $update_dashboard_future = "UPDATE dashboard_future Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and type like '%FUTURES%'";
				 $status_dashboard_future = $this->db3->query($update_dashboard_future);
				
            }
		    
	   }
	   else {
			if($b_s=="B"){
					//sell
				   $sql_best_limit_s = 'select * from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="S" and `status` <> 0 Order by `p` ASC,`datetime` ASC';
				   $arr_limit_s = $this->db3->query($sql_best_limit_s)->result_array();
				   $i =0;
				   $k = 0;
				   $total = 0;
				   foreach($arr_limit_s as $best_limit_s){
					   	
					   $k += $best_limit_s["status"];				  
					    if($i>=$quantity_val) break;	
					   if($quantity_val>=$k){
						   $insert_q = $best_limit_s["status"];
					   }
					   else {
						   $insert_q = $quantity_val - $i;
					   }
					  $update_deep1 = "UPDATE order_book_futures_deep1 Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  $status_update_deep1 = $this->db3->query($update_deep1);
					  $update_deep1 = "UPDATE vdm_order_futures_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  $status_update_deep1 = $this->db3->query($update_deep1);
					  $insert_excu_trade_s = "INSERT INTO excution_traded (
							   `user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`)
							   VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','FUTURES','".date('M-Y',strtotime($best_limit_s['expiry']))."'); ";
					  $status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
					  $sql_last = 'select * from dashboard_future where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and type like "%FUTURES%" Limit 1';
		   				  $q_last = $this->db3->query($sql_last)->row_array();
						  if(isset($q_last['psettle']) && $q_last['psettle'] >0) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
						  }
		   				  else {
							  $var="`var`=NULL ";
							  $change = "`change`=NULL ";	
						  }
						  $update_dashboard_future = "UPDATE dashboard_future Set `last` = '".$best_limit_s['p']."', ".$var.", ". $change. " ,`time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and type like '%FUTURES%'";
				  		  $status_dashboard_future = $this->db3->query($update_dashboard_future);
					  $i += $best_limit_s["status"];
                      $this->update_dashboard_futures_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],'FUTURES');
											
				   }
				   $sql = 'select min(`p`) as min from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="S" and status <>0';
				   $price_s = $this->db3->query($sql)->row_array();
				   if(isset($price_s["min"])&&$price_s["min"]!=0){
					   $sql = 'select sum(`status`) as qask from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
					   $sum = $this->db3->query($sql)->row_array();
					   $qask = $sum["qask"];
					   $ask = $price_s["min"];
				   }
				   else {
						$qask = "-";
						$ask = "-";
				   }
				   $update_best_limit = "UPDATE order_book_futures_best_limit Set `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry."' AND `dsymbol`='".$dsymbol."'";
				   $status_best_limit = $this->db3->query($update_best_limit);
				   $update_dashboard_future = "UPDATE dashboard_future Set `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and type like '%FUTURES%'";
				  $status_dashboard_future = $this->db3->query($update_dashboard_future);
			   }
			else {
					$sql_best_limit_s = 'select * from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="B" and `status` > 0 Order by `p` DESC ,`datetime` ASC';
					$arr_limit_s = $this->db3->query($sql_best_limit_s)->result_array();
				   $i =0;
				   $k = 0;
				   $total = 0;
				   foreach($arr_limit_s as $best_limit_s){	
					   $k += $best_limit_s["status"];				  
					  // $sl = ($quantity_val > $k) ? ($quantity_val -$k) : ($k - $quantity_val);
					   if($i>=$quantity_val) break;	
					   if($quantity_val>=$k){
						   $insert_q = $best_limit_s["status"];
					   }
					   else {
						   $insert_q = $quantity_val - $i;
					   }
					   $update_deep1 = "UPDATE order_book_futures_deep1 Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					   $status_update_deep1 = $this->db3->query($update_deep1);
					   $update_deep1 = "UPDATE vdm_order_futures_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					   $status_update_deep1 = $this->db3->query($update_deep1);
					   $insert_excu_trade_s = "INSERT INTO excution_traded (
							   `user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`)
							   VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','FUTURES','".date('M-Y',strtotime($best_limit_s['expiry']))."'); ";
					  $status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
					  $sql_last = 'select * from dashboard_future where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and type like "%FUTURES%" Limit 1';
		   				  $q_last = $this->db3->query($sql_last)->row_array();
						  if($q_last['last'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['last'])/$q_last['last']);
							$change = "`change`=".($best_limit_s['p']-$q_last['last']);
						  }
		   				  else {
							  $var="`var`=NULL ";	
							  $change = " `change`=NULL";
						  }
						  $update_dashboard_future = "UPDATE dashboard_future Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and type like '%FUTURES%'";
				  		  $status_dashboard_future = $this->db3->query($update_dashboard_future);
					  
					  $i += $best_limit_s["status"];
                      $this->update_dashboard_futures_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],'FUTURES');											
				   }
				   $sql = 'select max(`p`) as max from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="B"  and status <>0';
				   $price_b = $this->db3->query($sql)->row_array();
				   if(isset($price_b["max"])&&$price_b["max"]!=0){
					   $sql = 'select sum(`status`) as qbid from order_book_futures_deep1 where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `b/s`="B" and `p`="'.$price_b["max"].'"  and status <>0';
					   $sum = $this->db3->query($sql)->row_array();
					   $qbid = $sum["qbid"];
					   $bid = $price_b["max"];
				   }
				   else {
						$qbid = "-";
						$bid = "-";
					   
				   }
				   $update_best_limit = "UPDATE order_book_futures_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."'  Where `expiry`='".$expiry."' AND `dsymbol`='".$dsymbol."'";
				   $status_best_limit = $this->db3->query($update_best_limit);
				   $update_dashboard_future = "UPDATE dashboard_future Set `qbid` = '".$qbid. "' , `bid` ='". $bid."', `time`='".$datetime."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and type like '%FUTURES%'";
				   $status_dashboard_future = $this->db3->query($update_dashboard_future);
				}
		   
		   $sql = "INSERT INTO vdm_order_futures_daily (
				   id_user, datetime, dsymbol, order_type, order_method, model, expiry, `b/s`, interest, dividend, price, quantity,status, deadline )
				   VALUES ('{$id_user}','{$datetime}','{$dsymbol}','{$order_type}','{$method_type}','{$model}','{$expiry}','{$b_s}','{$interest}','{$dividend}',NULL,'{$quantity_val}',0, '{$deadline}');";				   
		   $result = $this->db3->query($sql);
		   //print_r($status);exit;
		   $id = $this->db->insert_id();
		   if($result>0){
				$sql1 = "INSERT INTO order_book_futures_deep1 (
				   id, id_user, `datetime`, dsymbol, expiry, `b/s`, p, q, market_order,status, deadline )
				   VALUES ('{$id}','{$id_user}','{$datetime}','{$dsymbol}', '{$expiry}','{$b_s}', NULL,'{$quantity_val}','{$market_order}',0,'{$deadline}');
				   ";
			   $result1 = $this->db3->query($sql1);
		   }  
		   
	   }
	    
       $this->update_fut_summary($id_user,1,0,1);
       $this->insert_summary_actions();        
       return $result1;

    }
    
    //volume, dvolume, 
    function update_dashboard_futures_table($expiry, $dsymbol, $type='FUTURES')
    {
        $sqlv= "SELECT sum(q) as dvolume FROM excution_traded WHERE `expiry`='$expiry' and `dsymbol`='$dsymbol' and `type` like '%$type%' and DAY(`datetime`) ='".date('d')."'";
        $dvolume = $this->db3->query($sqlv)->row_array();
        $sqldv= "SELECT q as volume FROM excution_traded WHERE `expiry`='$expiry' and `dsymbol`='$dsymbol' and `type` like '%$type%' and DAY(`datetime`) ='".date('d')."' ORDER BY `datetime` desc LIMIT 1";
        $volume = $this->db3->query($sqldv)->row_array();
        $update_df = "UPDATE dashboard_future Set `volume` = '".$volume['volume']."', `dvolume` = '".$dvolume['dvolume']."' Where `expiry`='".$expiry."' and `dsymbol`='".$dsymbol."' and `type` like '%FUTURES%'";
		$status_update_df = $this->db3->query($update_df);
        //$sql = "SELECT * FROM dashboard_future WHERE `expiry`='".$expiry."' and `product`='".$product."' and `type`='FUTURES'";
        
        return true;
    }
    
    function insert_daily_options($id_user, $datetime, $product, $c_p, $order_type, $method_type, $expiry, $b_s, $price, $quantity_val, $model, $interest, $dividend, $volatility, $strike,$deadline = null){
       $sql = "INSERT INTO vdm_order_options_daily(
               id_user, datetime, product, `type`, order_type, order_method, model, expiry, `b/s`, interest, dividend, price, quantity, volatility, strike, deadline)
               VALUES ('{$id_user}','{$datetime}','{$product}','{$c_p}','{$order_type}','{$method_type}','{$model}','{$expiry}','{$b_s}','{$interest}','{$dividend}','{$price}','{$quantity_val}','{$volatility}','{$strike}','{$deadline}')";
       $status = $this->db3->query($sql);
       if($status == true){
            $this->update_opt_summary($id_user,1,0,1);
       }
       return $status;
    }
	
    
    function insert_summary_actions(){
      //  $sql_ ='TRUNCATE summary;';
	  //  $truncate = $this->db3->query($sql_);
        $sql = 'select * from order_book_futures_deep1';
		
        $data_order = $this->db3->query($sql)->result_array();
        $count_order_B = 0;
        $count_order_S = 0;
        $sumB = 0;
        $sumS = 0;
        foreach($data_order as $item){
            if($item['b/s'] == 'B'){
                $sumB += $item['q'];
                $count_order_B++;
            }else if($item['b/s'] == 'S'){
                $sumS += $item['q'];
                $count_order_S++;
            } 
        }
		
        $status = $this->insert_summary('ORDER',$count_order_B,$count_order_S);
        $count_traded_B = 0;
        $count_traded_S = 0;
        $sumT = 0;
        $sql1 = 'select * from excution_traded';
        $data_traded = $this->db3->query($sql1)->result_array();
        foreach($data_traded as $item){
           $sumT += $item['q'];
		    $count_traded_B++;
			$count_traded_S++;
        }
		
        $status1 = $this->insert_summary('TRADES',$count_traded_B,$count_traded_S);
        $status2 = $this->insert_summary('VOLUME',$sumB,$sumS,$sumT);
        $status3 = $this->insert_summary('OPEN INTEREST',$sumB-($sumT/2),$sumS-($sumT/2)); 
		
        return $status2;   
    }
    
     function insert_summary($type, $b, $s, $t = '-'){
        $status = true;
        $sql1 = '';
        $sql = "select * from summary";
        $count = 0;
        $arr = $this->db3->query($sql)->result_array();
        if($arr != ''){
            foreach($arr as $item){  
                if($item != '' && (isset($item['type']) ? $item['type'] : '')  == $type){
                    $count++;
                }
            }
        }
        if($count >0){
            $sql1 = "UPDATE summary
                          SET b = '{$b}' , s = '{$s}', t = '{$t}'
                          WHERE type like '%{$type}%'";
        }else{
             $sql1 = "INSERT INTO summary (`type`,`b`,`s`,`t`)
                            VALUES ('{$type}','{$b}' ,'{$s}','{$t}');";
        }
        //var_export($sql1);exit;
        $status = $this->db3->query($sql1);   
        
        return $status;
    }
    // Insert or update Vdm Summary 
    
    function update_vdmsummary($id_user, $opt_order, $opt_trade, $opt_volume, $fut_order, $fut_trade, $fut_volume, $tt_order, $tt_trade, $tt_volume){
        //$ini, $cur_value,$perfom , SQL = `initial` = '{$ini}', `cur_value` = '{$cur_value}', `perform` = '{$perfom}',
        $sql="UPDATE vdm_user_summary SET  
            `opt_nb_ord` = '{$opt_order}', `opt_nb_trd` = '{$opt_trade}',`opt_volume`='{$opt_volume}' , 
            `fut_nb_ord` = '{$fut_order}', `fut_nb_trd`='{$fut_trade}', `fut_volume` ='{$fut_volume}',
            `tt_nb_ord` = '{$tt_order}', `tt_nb_trd` = '{$tt_trade}', `tt_volume` ='{$tt_volume}' WHERE `id_user` = '{$id_user}'";
        return $this->db3->query($sql);   
    }
    function update_opt_summary($id_user, $opt_order, $opt_trade, $opt_volume){
        $sql_opt = "SELECT * FROM vdm_user_summary WHERE `id_user` = '{$id_user}'";
        $opt = $this->db3->query($sql_opt)->row_array();
        $order = $opt['opt_nb_ord'] + $opt_order;
        $trade = $opt['opt_nb_trd'] + $opt_trade;
        $volume = $opt['opt_volume'] + $opt_volume;
        $sql="UPDATE vdm_user_summary SET  
            `opt_nb_ord` = '{$order}', `opt_nb_trd` = '{$trade}',`opt_volume`='{$volume}' 
            WHERE `id_user` = '{$id_user}'";
        $status = $this->db3->query($sql); 
        if($status == true){
            $this->update_tt_summary($id_user, $opt_order, $opt_trade, $opt_volume);
        }
        return true;  
    }
    function update_fut_summary($id_user, $fut_order, $fut_trade, $fut_volume){
        $sql_opt = "SELECT * FROM vdm_user_summary WHERE `id_user` = '{$id_user}'";
		
        $opt = $this->db3->query($sql_opt)->row_array();
        $order = $opt['fut_nb_ord'] + $fut_order;
        $trade = $opt['fut_nb_trd'] + $fut_trade;
        $volume = $opt['fut_volume'] + $fut_volume;
        $sql="UPDATE vdm_user_summary SET  
            `fut_nb_ord` = '{$order}', `fut_nb_trd`='{$trade}', `fut_volume` ='{$volume}' 
            WHERE `id_user` = '{$id_user}'";
        $status = $this->db3->query($sql);
		
        if($status == true){
            $this->update_tt_summary($id_user, $fut_order, $fut_trade, $fut_volume);
        }
        return true;  
    }
    function update_tt_summary($id_user, $tt_order, $tt_trade, $tt_volume){
        $sql_opt = "SELECT * FROM vdm_user_summary WHERE `id_user` = '{$id_user}'";
        $opt = $this->db3->query($sql_opt)->row_array();
        $order = $opt['tt_nb_ord'] + $tt_order;
        $trade = $opt['tt_nb_trd'] + $tt_trade;
        $volume = $opt['tt_volume'] + $tt_volume;
        $sql="UPDATE vdm_user_summary SET  
            `tt_nb_ord` = '{$order}', `tt_nb_trd` = '{$trade}', `tt_volume` ='{$volume}'
            WHERE `id_user` = '{$id_user}'";
			
        return $this->db3->query($sql);   
    }
    
    function getSummaryByUser($id_user){
        // ORDER d?m b?ng quantity thay vì status vì chua làm kh?p l?nh cho order
        $sqlORD = "SELECT count_ord_daily, count_ord_all, ord_opt_daily, ord_opt_all,count_fut_daily,count_fut_all, ord_fut_daily, ord_fut_all FROM
                        (SELECT sum(`quantity`) as ord_opt_daily, count(*) as count_ord_daily FROM vdm_order_options_daily WHERE id_user = '{$id_user}') opt_daily,
                        (SELECT sum(`quantity`) as ord_opt_all,count(*) as count_ord_all FROM vdm_order_options_all WHERE id_user = '{$id_user}') opt_all,
                        (SELECT sum(`status`) as ord_fut_daily, count(*) as count_fut_daily FROM vdm_order_futures_daily WHERE id_user = '{$id_user}') fut_daily,
                        (SELECT sum(`status`) as ord_fut_all,count(*) as count_fut_all FROM vdm_order_futures_all WHERE id_user = '{$id_user}') fut_all";
        $order = $this->db3->query($sqlORD)->row_array();
        $opt_nb_ord = (isset($order['count_ord_daily']) ? $order['count_ord_daily'] : 0) + (isset($order['count_ord_all'])? $order['count_ord_all'] :0) ;
        $fut_nb_ord = (isset($order['count_fut_daily']) ? $order['count_fut_daily'] : 0) + (isset($order['count_fut_all'])? $order['count_fut_all'] :0) ;
        //$sqlTRD = "SELECT SUM(OPT_BUY + OPT_SELL) AS OPT_TRD, SUM(FUT_BUY+FUT_SELL) AS FUT_TRD FROM
//                        (SELECT COUNT(*) AS OPT_BUY FROM excution_traded WHERE `type` = 'OPTIONS' AND user_buy = '{$id_user}') A,
//                        (SELECT COUNT(*) AS OPT_SELL FROM excution_traded WHERE `type` = 'OPTIONS' AND user_sell = '{$id_user}') B,
//                        (SELECT COUNT(*) AS FUT_BUY FROM excution_traded WHERE `type` = 'FUTURES' AND user_buy = '{$id_user}') C,
//                        (SELECT COUNT(*) AS FUT_SELL FROM excution_traded WHERE `type` = 'FUTURES' AND user_sell = '{$id_user}') D";
        $sqlTRD = "SELECT VOL_OPT AS VOLUME_OPT,VOL_FUT AS VOLUME_FUT, OPT AS OPT_TRD, FUT AS FUT_TRD FROM
                        (SELECT COUNT(*) AS OPT FROM excution_traded WHERE `type` = 'OPTIONS' AND (user_buy = '{$id_user}' OR user_sell = '{$id_user}')) A,
                        (SELECT COUNT(*) AS FUT FROM excution_traded WHERE `type` = 'FUTURES' AND (user_buy = '$id_user' OR user_sell = '{$id_user}')) C,
    					(SELECT SUM(`q`) AS VOL_OPT FROM excution_traded WHERE `type` = 'OPTIONS' AND (user_buy = '{$id_user}' OR user_sell = '{$id_user}')) B,
    					(SELECT SUM(`q`) AS VOL_FUT FROM excution_traded WHERE `type` = 'FUTURES' AND (user_buy = '{$id_user}' OR user_sell = '{$id_user}')) D";
        $trd = $this->db3->query($sqlTRD)->row_array(); 
        $opt_volume = (isset($trd['VOLUME_OPT']) ? $trd['VOLUME_OPT'] : 0) ;               
        $fut_volume = (isset($trd['VOLUME_FUT']) ? $trd['VOLUME_FUT'] : 0) ;
        $status = $this->update_vdmsummary($id_user,$opt_nb_ord,$trd['OPT_TRD'],$opt_volume,$fut_nb_ord,$trd['FUT_TRD'],$fut_volume,$opt_nb_ord+$fut_nb_ord,$trd['OPT_TRD']+$trd['FUT_TRD'],$fut_volume+$opt_volume);
        return $status;
    } 
   
    function truncate_data_order(){
        $result = array();
        $tables = array("vdm_order_futures_daily", "excution_traded", "vdm_order_futures_all", "vdm_order_options_daily", "vdm_order_options_all", "order_book_futures_deep1", "order_book_futures_best_limit");
       //$queries = explode(";", $queries);
       //$res = $this->db3->query($sql) or die($this->db->error());
        foreach($tables as $table) 
        {
         
            # truncate data from this table
            $sql = "TRUNCATE TABLE `".$table."`";
        
            # use the instantiated db connection object from the init.php, to process the query
            $result = $this->db3->query($sql);
        }
        return $result;  
       //
        
        
    }
    
    function mysql_multiquery($queries)
    {
        $queries = explode(";", $queries);
        foreach ($queries as $query)
            $query = $this->db3->query($query);
        return $query;
    }
    
    function checkDailyRemove(){
        $sql = "INSERT INTO vdm_order_futures_all
                SELECT * FROM vdm_order_futures_daily WHERE DATE_FORMAT(datetime,'%m-%d-%Y') < DATE_FORMAT(NOW(),'%m-%d-%Y');";
        $status = $this->db3->query($sql);        
        if($status>0){    
            $sql1= "DELETE obfd, obfbl,vdm_order FROM order_book_futures_deep1 obfd JOIN order_book_futures_best_limit obfbl ON obfd.expiry = obfbl.expiry
                JOIN vdm_order_futures_daily vdm_order on vdm_order.id = obfd.id and vdm_order.expiry = vdm_order.expiry and vdm_order.datetime = obfd.datetime
                WHERE DATE_FORMAT(obfd.datetime,'%m-%d-%Y') < DATE_FORMAT(NOW(),'%m-%d-%Y');";    
            $status1 = $this->db3->query($sql1);     
        }        
        return $status1;
    }
    function runDaily(){
        $sql = "INSERT INTO vdm_order_futures_all
                SELECT * FROM vdm_order_futures_daily WHERE (DATE_FORMAT(deadline,'%m-%d-%Y') = DATE_FORMAT(NOW(),'%m-%d-%Y') and status >0 ) OR (DATE_FORMAT(deadline,'%m-%d-%Y') > DATE_FORMAT(NOW(),'%m-%d-%Y') and status =0);";
        $status = $this->db3->query($sql);        
        if($status>0){  
			$sql1= "DELETE vdm_order_futures_daily 
                WHERE (DATE_FORMAT(deadline,'%m-%d-%Y') = DATE_FORMAT(NOW(),'%m-%d-%Y') and status >0 ) OR (DATE_FORMAT(deadline,'%m-%d-%Y') > DATE_FORMAT(NOW(),'%m-%d-%Y') and status =0);";    
				//print_r($sql1);
            $status1 = $this->db3->query($sql1);
			$sql2= "DELETE order_book_futures_deep1 
                WHERE (DATE_FORMAT(deadline,'%m-%d-%Y') = DATE_FORMAT(NOW(),'%m-%d-%Y') and status >0 ) OR (DATE_FORMAT(deadline,'%m-%d-%Y') > DATE_FORMAT(NOW(),'%m-%d-%Y') and status =0);";    
            $status2 = $this->db3->query($sql2); 
		  
                
        }
	   $sql = "select * from order_book_futures_deep1  group by expiry, product order by expiry";
	   $arr_expiry = $this->db3->query($sql)->result_array();
	   foreach($arr_expiry as $expiry){   
			//upate best limit
			 $sql = 'select max(`p`) as max from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `product`="'.$expiry["product"].'" and `b/s`="B" and status <>0';
			   $price_b = $this->db3->query($sql)->row_array();
			   if(isset($price_b["max"])){
				   $sql = 'select sum(`status`) as qbid from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `product`="'.$expiry["product"].'" and `b/s`="B" and `p`="'.$price_b["max"].'" and status <>0';
				   $sum = $this->db3->query($sql)->row_array();
				   $qbid = $sum["qbid"];
				   $bid = $price_b["max"];
			   }
			   else {
					$qbid = "-";
					$bid = "-";				   
			   }
				$sql = 'select min(`p`) as min from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `product`="'.$expiry["product"].'" and `b/s`="S" and status <>0';
				   $price_s = $this->db3->query($sql)->row_array();
				   if(isset($price_s["min"])){
					   $sql = 'select sum(`status`) as qask from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `product`="'.$expiry["product"].'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
					   $sum = $this->db3->query($sql)->row_array();
					   $qask = $sum["qask"];
					   $ask = $price_s["min"];
				   }
				   else {
						$qask = "-";
						$ask = "-";				   
				   }
				   $sql = 'select * from order_book_futures_best_limit where  `expiry`="'.$expiry["expiry"].'" and `product`="'.$expiry["product"].'" Limit 1';
		   			$best_limit = $this->db3->query($sql)->row_array();
					if(!isset($best_limit['id'])){
						$insert_best_limit = "INSERT INTO order_book_futures_best_limit (
					   `expiry`,`qbid`,`bid`,`ask`,`qask`,`product`)
					   VALUES ('".$expiry["expiry"]."','".$qbid."','".$bid."','".$ask."', '".$qask."','".$expiry["product"]."');
					   ";
				  		$status_best_limit = $this->db3->query($insert_best_limit);
						$update_dashboard_future = "UPDATE dashboard_future Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".$datetime."' Where expiry='".$expiry["expiry"]."' and product='".$expiry["product"]."' and type='FUTURES'";
				  		$status_dashboard_future = $this->db3->query($update_dashboard_future);
					}
					else {
					$update_best_limit = "UPDATE order_book_futures_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry["expiry"]."' AND `product`='".$expiry["product"]."'";
					$status_best_limit = $this->db3->query($update_best_limit); 
					$update_dashboard_future = "UPDATE dashboard_future Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".$datetime."' Where expiry='".$expiry["expiry"]."' and product='".$expiry["product"]."' and type='FUTURES'";
				  		$status_dashboard_future = $this->db3->query($update_dashboard_future);
					}
		}
        return $status1;
    }
	function getListStrikeDashboard($product = '', $type='', $expirty=''){
		$where =' Where (1=1) ';
		if($product!='') $where .=' AND product ="'.$product.'"';
		if(($type!='') && ($type!='all') ) $where .=' AND type ="'.$type.'"';
		if($expirty!='' && ($expirty!='all')) $where .=' AND expiry ="'.$expirty.'"';
		$sql = "SELECT * FROM dashboard ".$where." Group by strike";
        $data = $this->db3->query($sql)->result_array();
        return $data;
    }
    function addStrikeDashboardByProduct($product = ''){
		$table_To_Get_From = $this->db3->query("SELECT str.* FROM vdm_strike_list str, dashboard d WHERE d.product = str.`code` AND d.expiry = str.date AND d.strike <> str.strike AND str.`code` = '{$product}' GROUP BY str.strike")->result_array();
        if($table_To_Get_From){
            foreach($table_To_Get_From as $row){
                $time = date('h:i:s');
                $date_update = date('Y-m-d');
                $status = $this->db3->query("INSERT INTO dashboard (type, expiry, strike, time, date_update, product)  
                VALUES ('Call','{$row['date']}','{$row['strike']}','$time','$date_update','{$row['code']}'), ('Put','{$row['date']}','{$row['strike']}','$time','$date_update','{$row['code']}')");
				if($status==false){
					$result["message"] = 'Error in Expiry:' + $row['date'] + ' - Strike: '+ $row['strike'];
				}
				else {
					 $success ++;
				}
                $total += 1;
                
            }
            $result["total"] = $total;
    		$result["success"] = $success;
        }
        return $result;
    }
    function Ftheo($LS, $LR, $LT, $LQ, $type) {
		//var_export($LS.'_'.$LR.'_'.$LT.'_'.$LQ.'_'.$type);exit;
		if($type==4)
		$Theorique = $LS * (1 + ($LR - $LQ) * ($LT / 365));
		else if($type == 3)
		$Theorique = $LS * (1 + ($LR) * ($LT / 365)) - $LQ;
        else if($type == 135)
        $Theorique = $LS * (exp(($LR * $LT )/ 365 - ($LQ/$LS)));
        else if($type == 136)
        $Theorique = $LS * (exp((($LR-$LQ) * $LT )/ 365));
		return $Theorique;
	}    
    public function delete_order($keys=null) {
	   
       // $keys = isset($_POST['keys']) ? TRIM($_POST['keys']) : $keys;
		$arr_key = explode('_',$keys);
		
        //$respone ='false';
		if($arr_key[1]=='options'){
    		$sql = "select * from vdm_order_options_daily  where id =".$arr_key[0];
    	    $expiry = $this->db3->query($sql)->row_array();
    		$sql = "DELETE FROM vdm_order_options_daily WHERE id=".$arr_key[0];
    		$respone = $this->db3->query($sql);
		}
		else {
			$sql = "select * from vdm_order_futures_daily  where id =".$arr_key[0];
	    	$expiry = $this->db3->query($sql)->row_array();
			$sql = "DELETE FROM vdm_order_futures_daily WHERE id=".$arr_key[0];
			$respone = $this->db3->query($sql);
			if($respone>0){
				$sql1 = "DELETE FROM order_book_futures_deep1 WHERE id=".$arr_key[0];
           		$status1 = $this->db3->query($sql1);
       		} 
		   //upate best limit
			 $sql = 'select max(`p`) as max from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `dsymbol`="'.$expiry["dsymbol"].'" and `b/s`="B" and status <>0';
			   $price_b = $this->db3->query($sql)->row_array();
			   if(isset($price_b["max"])){
				   $sql = 'select sum(`status`) as qbid from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `dsymbol`="'.$expiry["dsymbol"].'" and `b/s`="B" and `p`="'.$price_b["max"].'" and status <>0';
				   $sum = $this->db3->query($sql)->row_array();
				   $qbid = $sum["qbid"];
				   $bid = $price_b["max"];
			   }
			   else {
					$qbid = "-";
					$bid = "-";				   
			   }
				$sql = 'select min(`p`) as min from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `dsymbol`="'.$expiry["dsymbol"].'" and `b/s`="S" and status <>0';
				   $price_s = $this->db3->query($sql)->row_array();
				   if(isset($price_s["min"])){
					   $sql = 'select sum(`status`) as qask from order_book_futures_deep1 where  `expiry`="'.$expiry["expiry"].'" and `dsymbol`="'.$expiry["dsymbol"].'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
					   $sum = $this->db3->query($sql)->row_array();
					   $qask = $sum["qask"];
					   $ask = $price_s["min"];
				   }
				   else {
						$qask = "-";
						$ask = "-";				   
				   }
				   $sql = 'select * from order_book_futures_best_limit where  `expiry`="'.$expiry["expiry"].'" and `dsymbol`="'.$expiry["dsymbol"].'" Limit 1';
					$best_limit = $this->db3->query($sql)->row_array();
					if(!isset($best_limit['id'])){
						$insert_best_limit = "INSERT INTO order_book_futures_best_limit (
					   `expiry`,`qbid`,`bid`,`ask`,`qask`,`dsymbol`)
					   VALUES ('".$expiry["expiry"]."','".$qbid."','".$bid."','".$ask."', '".$qask."','".$expiry["dsymbol"]."');
					   ";
					$status_best_limit = $this->db3->query($insert_best_limit);
					}
					else {
					$update_best_limit = "UPDATE order_book_futures_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry["expiry"]."' AND `dsymbol`='".$expiry["dsymbol"]."'";
					$status_best_limit = $this->db3->query($update_best_limit); 
					}	
		   $insert_summary = $this->dashboard->insert_summary_actions();  
		}    
        
        return $respone;
        //$this->output->set_output(json_encode($respone));
    }
  
	
	
}