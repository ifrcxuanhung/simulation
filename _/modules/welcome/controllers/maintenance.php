<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maintenance extends Welcome {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('database3', true);
        $this->db4 = $this->load->database('database4', true);
    }
    
    function index() {

        /*$this->load->model('maintenance_model', 'maintenance');
		$this->data->maintenance_list = $this->maintenance->getdata();*/
		$this->data->date1 = $this->db->query("SELECT value FROM setting WHERE `key` = 'CREATE_VDM_CONTRACTS_SETTING_EXC'")->row_array();
		$this->data->date2 = $this->db->query("SELECT value FROM setting WHERE `key` = 'UPDATE_VDM_CONTRACTS_SETTING_EXC'")->row_array();
		$this->data->date3 = $this->db->query("SELECT value FROM setting WHERE `key` = 'CLEAN_DASHBOARD_FUTURE'")->row_array();
		$this->data->date4 = $this->db->query("SELECT value FROM setting WHERE `key` = 'CLEAN_VDM_CONTRACTS_SETTING'")->row_array();
		$this->data->date5 = $this->db->query("SELECT value FROM setting WHERE `key` = 'CLEAN_DASHBOARD_OPTION'")->row_array();
		$this->data->date6 = $this->db->query("SELECT value FROM setting WHERE `key` = 'RESET_MARKET'")->row_array();

        $this->template->write_view('content', 'maintenance/index', $this->data);
        $this->template->render();
    }
    function create_contracts_setting(){
        
        $date = $_POST['date']; 
        $this->db2->query("truncate vdm_contracts_setting_phuong;");
        $list_code = $this->db2->query("select * from vdm_contracts_ref where ucode is not null  group by dsymbol;")->result_array();
        foreach ($list_code as $data)
            {
                if($data['expiry_m'] != '')
                {
                    //for ($i = 1; $i <= $data['expiry_m']; $i++){
                        $sql=" insert into vdm_contracts_setting_phuong (user,active,oblig,product,volat,a,b,type,expiry,mm,yyyy,`code`,dsymbol)
                            select  0 `user`, active,1 oblig, dtype products,option_imp,option_a,option_b,'M' type, cal.date expiry,cal.mm,cal.yyyy,ucode,dsymbol from vdm_contracts_ref as ref 
                            JOIN (select date,if(length(mm)=1,concat(0,mm),mm) mm ,yyyy from vdm_calendar_contracts where ".$data['expiry_lastday']." =1 and date>'".$date."' limit ".$data['expiry_m'].") as cal where ref.dsymbol='" .$data['dsymbol']."'";
                        $this->db2->query($sql);
                    //}
                }
               // echo $sql;
                if($data['expiry_q'] != '')
                {
                    $sql=" insert into vdm_contracts_setting_phuong (user,active,oblig,product,volat,a,b,type,expiry,mm,yyyy,`code`,dsymbol) 
                        select 0 `user`, active,1 oblig, dtype products,option_imp,option_a,option_b,'Q' type, cal.date expiry,cal.mm,cal.yyyy,ucode,dsymbol
                         from vdm_contracts_ref as ref JOIN (select date,if(length(mm)=1,concat(0,mm),mm) mm ,yyyy from vdm_calendar_contracts where ".$data['expiry_lastday']." =1 and date >(select max(expiry) date 
                         from vdm_contracts_setting_phuong where `dsymbol`='" .$data['dsymbol']."' and  `dsymbol`='" .$data['dsymbol']."' and product='" .$data['dtype']."') and mm in('03','06','09','12') limit ".$data['expiry_q'].") as cal where ref.dsymbol='" .$data['dsymbol']."'";
                    $this->db2->query($sql);
                }

                if($data['expiry_s'] != '')
                {
                    $sql=" insert into vdm_contracts_setting_phuong (user,active,oblig,product,volat,a,b,type,expiry,mm,yyyy,`code`,dsymbol) 
                        select 0 `user`, active,1 oblig, dtype products,option_imp,option_a,option_b,'S' type, cal.date expiry,cal.mm,cal.yyyy,ucode,dsymbol
                         from vdm_contracts_ref as ref JOIN (select date,if(length(mm)=1,concat(0,mm),mm) mm ,yyyy from vdm_calendar_contracts where ".$data['expiry_lastday']." =1 and date >(select max(expiry) date 
                         from vdm_contracts_setting_phuong where `dsymbol`='" .$data['dsymbol']."' and  `dsymbol`='" .$data['dsymbol']."' and product='" .$data['dtype']."') and mm in('06','12') limit ".$data['expiry_s'].") as cal where ref.dsymbol='" .$data['dsymbol']."'";
                    $this->db2->query($sql);
                }
                if($data['expiry_y'] != '')
                {
                    $sql=" insert into vdm_contracts_setting_phuong (user,active,oblig,product,volat,a,b,type,expiry,mm,yyyy,`code`,dsymbol) 
                        select 0 `user`, active,1 oblig, dtype products,option_imp,option_a,option_b,'Y' type, cal.date expiry,cal.mm,cal.yyyy,ucode,dsymbol
                         from vdm_contracts_ref as ref JOIN (select date,if(length(mm)=1,concat(0,mm),mm) mm  ,yyyy from vdm_calendar_contracts where ".$data['expiry_lastday']." =1 and date >(select max(expiry) date 
                         from vdm_contracts_setting_phuong where `code`='" .$data['ucode']."' and  `dsymbol`='" .$data['dsymbol']."' and product='" .$data['dtype']."') and mm in('12') limit ".$data['expiry_y'].") as cal where ref.dsymbol='" .$data['dsymbol']."' ";
                    $this->db2->query($sql);
                };
                
            }
            $list_update = $this->db2->query("select dtype,ucode,maxspd from vdm_contracts_ref where active>0 and LENGTH(maxspd) >0 group by ucode,dtype;")->result_array();
             
            $this->db2->query("update vdm_contracts_setting_phuong as a, vdm_contracts_ref as b set a.dsymbol=b.dsymbol, a.tick=b.tick, a.minquant=1 where a.`dsymbol`=b.dsymbol;");
            //$this->db2->query("update vdm_contracts_setting_phuong as a, vdm_contracts_ref as b set a.`interval`=b.`interval` where a.`dsymbol`=b.`dsymbol` and a.product=b.dtype;");
            $this->db2->query("update vdm_contracts_setting_phuong as a set r=5.22;");
            $this->db2->query("delete from vdm_contracts_setting_phuong where expiry < curdate();;");
            
            //echo $sql;
        
        }
        
    public function update_data_final() {
        $sqlkey = "SELECT ref.*, ph.expiry FROM vdm_contracts_ref as ref RIGHT JOIN vdm_contracts_setting_phuong as ph ON ph.dsymbol=ref.dsymbol ";
        $seconds = $this->db2->query($sqlkey)->result_array();
	    $expiry ='';

	   foreach($seconds as $key =>$item) {
		   if($expiry!=$item["expiry"]) {
			   $arr_maxspd = explode(";", $item["maxspd"]);	
               $arr_strike = explode(";", $item["nbstrike"]);		
               $arr_contract = explode(";", $item["nbcontract"]);	
               $arr_interval = explode(";", $item["interval"]);			   
			   if(count($arr_maxspd)>0 && $arr_maxspd[0] !=''){
				   $sql_ph = "SELECT * from vdm_contracts_setting_phuong where dsymbol='".$item["dsymbol"]."'";
				   $phuong = $this->db2->query($sql_ph)->result_array();
				   foreach ($phuong as $key1=>$value )
				   {
					   if($item["expiry"]==$value["expiry"]){
						   if(isset($arr_maxspd[$key1+1]) && $arr_maxspd[$key1+1]!=''){
						      $this->db2->query("update vdm_contracts_setting_phuong set maxspd=".$arr_maxspd[$key1+1]. " where  expiry='".$item["expiry"]."' 
                               and dsymbol='".$item["dsymbol"]."'; ");
						   }   
                        	else
							 $this->db2->query("update vdm_contracts_setting_phuong set maxspd=".$arr_maxspd[0]. " where expiry='".$item["expiry"]."' and dsymbol='".$item["dsymbol"]."'; ");
						   }						   
				   }
			   }               
			   $expiry=$item["expiry"];
               
               if(count($arr_strike)>0 && $arr_strike[0] !=''){
				   $sql_ph = "SELECT * from vdm_contracts_setting_phuong where dsymbol='".$item["dsymbol"]."'";
				   $phuong = $this->db2->query($sql_ph)->result_array();
				   foreach ($phuong as $key1=>$value )
				   {
					   if($item["expiry"]==$value["expiry"]){
						   if(isset($arr_strike[$key1+1]) && $arr_strike[$key1+1]!=''){
						      $this->db2->query("update vdm_contracts_setting_phuong set nbstrikes=".$arr_strike[$key1+1]. " where  expiry='".$item["expiry"]."' 
                               and dsymbol='".$item["dsymbol"]."'; ");
						   }   
                        	else
							 $this->db2->query("update vdm_contracts_setting_phuong set nbstrikes=".$arr_strike[0]. " where expiry='".$item["expiry"]."' and dsymbol='".$item["dsymbol"]."'; ");
						   }						   
				   }
			   }
               
                $expiry=$item["expiry"];
                if(count($arr_interval)>0 && $arr_interval[0] !=''){
				   $sql_ph = "SELECT * from vdm_contracts_setting_phuong where dsymbol='".$item["dsymbol"]."'";
				   $phuong = $this->db2->query($sql_ph)->result_array();
				   foreach ($phuong as $key1=>$value )
				   {
					   if($item["expiry"]==$value["expiry"]){
						   if(isset($arr_interval[$key1+1]) && $arr_interval[$key1+1]!=''){
						      $this->db2->query("update vdm_contracts_setting_phuong set `interval`=".$arr_interval[$key1+1]. " where  expiry='".$item["expiry"]."' and dsymbol='".$item["dsymbol"]."'; ");
						   }   
                        	else
							 $this->db2->query("update vdm_contracts_setting_phuong set `interval`=".$arr_interval[0]. " where expiry='".$item["expiry"]."' and dsymbol='".$item["dsymbol"]."'; ");
						   }						   
				   }
			   }
               
               $expiry=$item["expiry"];
               if(count($arr_contract)>0 && $arr_contract[0] !=''){
				   $sql_ph = "SELECT * from vdm_contracts_setting_phuong where dsymbol='".$item["dsymbol"]."'";
				   $phuong = $this->db2->query($sql_ph)->result_array();
				   foreach ($phuong as $key1=>$value )
				   {
					   if($item["expiry"]==$value["expiry"]){
						   if(isset($arr_contract[$key1+1]) && $arr_contract[$key1+1]!=''){
						      $this->db2->query("update vdm_contracts_setting_phuong set nbcontract=".$arr_contract[$key1+1]. " where  expiry='".$item["expiry"]."' 
                               and dsymbol='".$item["dsymbol"]."'; ");
						   }   
                        	else
							 $this->db2->query("update vdm_contracts_setting_phuong set nbcontract=".$arr_contract[0]. " where expiry='".$item["expiry"]."' and dsymbol='".$item["dsymbol"]."'; ");
						   }						   
				   }
			   }                      
			   $expiry=$item["expiry"];
               
		   }else {
			   continue;
		   }
	   
	   }
       $this->db2->query("insert into vdm_contracts_setting_exc(`user`,active,oblig,type,mm,yyyy,expiry,`interval`,tick,nbcontract,nbstrikes,maxspd,
minquant,r,r_base,volat,dividend_vl,dividend,a,b,product,`code`,dsymbol)
select `user`,active,oblig,type,mm,yyyy,expiry,`interval`,tick,nbcontract,nbstrikes,maxspd,
minquant,r,r_base,volat,dividend_vl,dividend,a,b,product,`code`,dsymbol from  vdm_contracts_setting_phuong as a
where concat(expiry,dsymbol) not in (select distinct concat(expiry,dsymbol) as aaaa from  vdm_contracts_setting_exc as b);");
       $this->db2->query("update vdm_contracts_setting_exc as a, vdm_contracts_setting_phuong as b
set a.active=b.active where concat(a.expiry,a.dsymbol)= concat(b.expiry,b.dsymbol);");
         $this->db2->query("update vdm_contracts_setting_exc as a, vdm_contracts_setting_phuong as b
set a.expiry=b.expiry where concat(a.dsymbol,date_format(a.`expiry`, '%Y%m'))= concat(b.dsymbol,date_format(b.`expiry`, '%Y%m'));");
       $this->db2->query("update vdm_contracts_setting_exc set active=0
where concat(expiry,dsymbol) not in (select distinct concat(expiry,dsymbol) as aaaa from  vdm_contracts_setting_phuong as b);");
$this->db2->query("update vdm_contracts_setting_exc as a, vdm_contracts_setting_phuong as b
set a.maxspd =b.maxspd where concat(a.expiry,a.dsymbol)= concat(b.expiry,b.dsymbol) and a.maxspd is null;");
$this->db2->query("update vdm_contracts_setting_exc as a, vdm_contracts_setting_phuong as b
set a.`interval` =b.`interval` where concat(a.expiry,a.dsymbol)= concat(b.expiry,b.dsymbol) and a.`interval` is null;");
 $this->db2->query("delete from vdm_contracts_setting_exc where expiry < curdate();");
	}
    
    public function clean_dashboard() {
        $this->db2->query("delete from dashboard_future where concat(dsymbol,date_format(`expiry`, '%Y%m')) 
not in ( select distinct concat(dsymbol,yyyy,mm) from vdm_contracts_setting_exc);");
        $this->db2->query("update dashboard_future as a,( select * from vdm_contracts_setting_exc where concat(dsymbol,yyyy,mm) 
in ( select distinct concat(dsymbol,date_format(`expiry`, '%Y%m')) from dashboard_future) and product like '%FUTURES%') as b
set a.expiry=b.expiry where concat(a.dsymbol,date_format(a.`expiry`, '%Y%m')) = concat(b.dsymbol,b.yyyy,b.mm);");
        $this->db2->query("insert into dashboard_future ( type, product,expiry,dsymbol) select product,`code`,expiry,dsymbol from vdm_contracts_setting_exc 
where concat(dsymbol,yyyy,mm) not in ( select concat(dsymbol,date_format(`expiry`, '%Y%m')) 
from dashboard_future where dsymbol is not null) and product like '%FUTURES%' and active=1;");
$this->db2->query("delete from dashboard_future where expiry < curdate();");
        
    }
    public function clean_contracts_setting() {
       $this->db2->query("delete from vdm_contracts_setting where concat(dsymbol,yyyy,mm) 
not in ( select distinct concat(a.dsymbol,a.yyyy,a.mm) from vdm_contracts_setting_exc as a)
and product like '%FUTURES%';");
        $this->db2->query("update vdm_contracts_setting as a,(select * from vdm_contracts_setting_exc where concat(dsymbol,yyyy,mm)
 in ( select distinct concat(dsymbol,yyyy,mm) from vdm_contracts_setting) and product like '%FUTURES%') as b
set a.`active`=b.`active`,a.expiry=b.expiry,a.tick=b.tick, a.oblig=b.oblig where concat(a.dsymbol,a.yyyy,a.mm) = concat(b.dsymbol,b.yyyy,b.mm);");

 $this->db2->query("update vdm_contracts_setting as a,(select * from vdm_contracts_setting_exc where concat(dsymbol,yyyy,mm)
 in ( select distinct concat(dsymbol,yyyy,mm) from vdm_contracts_setting) and product like '%FUTURES%') as b
set a.maxspd =b.maxspd where concat(a.dsymbol,a.yyyy,a.mm) = concat(b.dsymbol,b.yyyy,b.mm) and a.maxspd is null;");

    $this->db2->query("drop table if exists setting_check;");
    $this->db2->query("create table setting_check
select A.`user_id`,A.active,oblig,type,mm,yyyy,expiry,`interval`,tick,nbcontract,nbstrikes,maxspd,minquant,
r,r_base,volat,dividend_vl,dividend,a,b,B.product,code,B.dsymbol,B.c from ( select dsymbol,product,user_id,active from vdm_contracts_market_making where active =1) as A
JOIN
(select oblig,type,mm,yyyy,expiry,`interval`,tick,nbcontract,nbstrikes,maxspd,minquant,r,r_base,volat,
dividend_vl,dividend,a,b,product,`code`,dsymbol,c from vdm_contracts_setting_exc where active >0 ) as B on A.dsymbol=B.dsymbol;");
    $this->db2->query("insert into vdm_contracts_setting(`user`,active,oblig,type,mm,yyyy,expiry,`interval`,tick,nbcontract,nbstrikes,maxspd,minquant,
r,r_base,volat,dividend_vl,dividend,a,b,product,code,dsymbol,c)
select `user_id`,active,oblig,type,mm,yyyy,expiry,`interval`,tick,nbcontract,nbstrikes,maxspd,minquant,
r,r_base,volat,dividend_vl,dividend,a,b,product,code,dsymbol,c from setting_check where product like '%FUTURES%' and concat (user_id, expiry,dsymbol) not in 
( select concat (`user`, expiry,dsymbol) from vdm_contracts_setting);");
    $this->db2->query("update vdm_contracts_setting as a, setting_check as b set a.oblig=b.oblig, a.qa=2, a.qb=2 where concat (a.user,a.expiry,a.dsymbol) = concat (b.user_id,b.expiry,b.dsymbol);");
$this->db2->query("delete from vdm_contracts_setting where expiry < curdate();");
    }
    public function clean_dashboard_option() {
       
        $this->db2->query("truncate dashboard;");
        for ($i =-5; $i <=5; $i++){
        $this->db2->query("insert into dashboard (nr, type, product,expiry,dsymbol, spread,implied) select '".$i."' nr, 'call' type, `code` product,expiry,dsymbol, maxspd,20 implied from vdm_contracts_setting_exc 
    where concat(dsymbol,yyyy,mm) not in ( select concat(dsymbol,date_format(`expiry`, '%Y%m')) 
    from dashboard_future where dsymbol is not null) and product like '%OPTIONS%' and active=1;");
        }
        for ($i =-5; $i <=5; $i++){
        $this->db2->query("insert into dashboard (nr, type, product,expiry,dsymbol, spread,implied) select '".$i."' nr, 'put' type, `code` product,expiry,dsymbol, maxspd,20 implied from vdm_contracts_setting_exc 
    where concat(dsymbol,yyyy,mm) not in ( select concat(dsymbol,date_format(`expiry`, '%Y%m')) 
    from dashboard_future where dsymbol is not null) and product like '%OPTIONS%' and active=1;");
        }
        $this->db2->query("update dashboard a, vdm_underlying_setting  b set a.last=b.last where a.product=b.code and a.nr =0;");
        $this->db2->query("update dashboard a, vdm_contracts_setting_exc  b set a.bid=b.`interval` where a.dsymbol=b.dsymbol and a.expiry=b.expiry ;");
        $trike =$this->db2->query("select type,expiry, bid, last, product, dsymbol from dashboard where bid*last <>0 and nr =0;")->result_array();
        foreach ($trike as $data)
            {
                $value_trike=$this->roundToTheNearestAnything($data['last'],$data['bid']);
                $value_trike=round($value_trike, -1, PHP_ROUND_HALF_DOWN);
                 $sql="update dashboard set strike='".$value_trike."'
                 where expiry='".$data['expiry']."' and dsymbol= '".$data['dsymbol']."' and bid*last <>0 and nr =0 ;";
                  $this->db2->query($sql);
            }
       $this->db2->query("update dashboard a, (select type,expiry,strike,  product, dsymbol from dashboard where bid*last <>0) b
    set a.strike=(b.strike + (a.bid * nr)) where a.type=b.type and a.expiry=b.expiry and a.product=b.product and a.dsymbol=b.dsymbol and a.nr<> 0 and a.strike is null;");
        $this->db2->query("update dashboard set bid=null, last=null"); 
        
    }
    
    public function reset_market() {  
        $this->db2->query("truncate table vdm_order_futures_daily;");
        $this->db2->query("truncate table vdm_order_futures_all; ");
        $this->db2->query("truncate table vdm_order_options_daily; ");
        $this->db2->query("truncate table vdm_order_options_all;");
        $this->db2->query("truncate table order_book_futures_deep1; ");
        $this->db2->query("truncate table order_book_futures_best_limit; ");
        $this->db2->query("truncate table excution_traded;");
        $this->db2->query("update vdm_user_summary as a set a.initial = (select `value` from setting where `key`='deposit_initial') ,
cur_value=(select `value` from setting where `key`='deposit_initial') ,perform =null, opt_nb_ord=null, opt_nb_trd=null,
opt_volume=null, fut_nb_ord=null, fut_nb_trd=null, fut_volume=null, tt_nb_ord=null, tt_nb_trd=null, tt_volume=null;");
        $this->db2->query("update dashboard set bid=null, ask=null, last=null, time=null, qbid=null, qask=null, var=null, volume=null,
         dvolume=null, oi=null, `change`=null;");
        $this->db2->query("update dashboard_future set bid=null, ask=null, last=null, time=null, qbid=null, qask=null, var=null, volume=null,
         dvolume=null, oi=null, `change`=null;");
         echo "Done!";
    }
    
    public function update_intraday() {  
    echo "Done!";
    }
    
    
	function roundToTheNearestAnything($value, $roundTo)
	 {
	  $mod = $value%$roundTo;
	  return $value+($mod<($roundTo/2)?-$mod:$roundTo-$mod);
	 }
 	function update_date_setting(){
		$param = $_REQUEST['param'];
		$date = date('Y-m-d H:i:s');
		$this->db->query("update setting set `value` = '$date' WHERE `key` = '$param'");
		$date_common = $this->db->query("SELECT value FROM setting WHERE `key` = '$param'")->row_array();
		echo json_encode($date_common);
	}
	function reset_all(){
		$this->db->query("UPDATE setting SET `value` = '' WHERE `group` = 'maintenance'");	
		echo json_encode(1);
	}

}