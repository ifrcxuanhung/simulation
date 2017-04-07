<?php
require('_/modules/welcome/controllers/block.php');
class Ajax extends Welcome{
	
	protected $var_image ='';
	protected $var_files ='';

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->model('Table_model', 'table');
		$this->load->model('dashboard_model','dashboard');
        $this->load->database();
		$this->db4 = $this->load->database('database4', TRUE);
		$this->db3 = $this->load->database('database3', TRUE);
		
    }
    
    public function index() {
        //echo "test test";
    }
    
    public function create_session_menu() {
        $id_menu = $_POST['id_menu'];	
        $this->session->set_userdata('id_menu', $id_menu);
        exit();
    }
    
    public function change_language()
    {
        $langcode = $_POST['langcode'];
        $sql = "SELECT * FROM `language` WHERE `code` = '".$langcode."'";
        $data = $this->db->query($sql)->result_array();
        $_SESSION['curent_language']=$data[0];
    }
    public function save_session_underlying(){
        $_SESSION['session_underlying'] = trim($_POST['underlying']);
    }
	public function save_session_array(){
		/*$name = trim($_POST['name']);
		 $sql = "SELECT * FROM `simul_settings` WHERE `name` = '".$name."'";
        $data = $this->db->query($sql)->row_array();*/
		
        $_SESSION['array_other_product']['dsymbol'] = $_POST['dsymbol'];
		
		$get_vus = $this->db3->where('dsymbol',$_POST['dsymbol'])->get('vdm_contracts_ref')->row_array();
			//echo "<pre>";print_r($get_vus);exit;
			$_SESSION['array_other_product']['usymbol'] = $get_vus['usymbol'];
			$_SESSION['array_other_product']['dtype'] = $get_vus['dtype'];
			$_SESSION['array_other_product']['codeint'] = $get_vus['codeint'];	
			$_SESSION['array_other_product']['utype'] = $get_vus['utype'];	
			
        	$_SESSION['option_product']['dsymbol'] = $_POST['o_dsymbol'];
			
		$get_vus_o = $this->db3->where('dsymbol',$_POST['o_dsymbol'])->get('vdm_contracts_ref')->row_array();
		
		$_SESSION['option_product']['usymbol'] = $get_vus_o['usymbol'];
		$_SESSION['option_product']['dtype'] = $get_vus_o['dtype'];
		$_SESSION['option_product']['codeint'] = $get_vus_o['codeint'];
		$expiry = $this->db3->where('product','FUTURES')->where('dsymbol',$_SESSION['array_other_product']['dsymbol'])->where('active','1')->order_by('expiry','asc')->get('vdm_contracts_setting_exc')->result_array();
		$i = 0;
		foreach($expiry as $item) {
			if ($_SESSION['session_expiry'] == date('M-y',strtotime($item['expiry']))){
				$_SESSION['session_expiry_date'] = $item["expiry"];		
				break;		
			}
			$i ++;
		}
		if ($i==count($expiry)) {
			$_SESSION['session_expiry_date'] = $expiry[0]["expiry"];
			$_SESSION['session_expiry'] =  date('M-y',strtotime($expiry[0]['expiry']));
		}		
            
    }
	public function save_session_expiry(){
        $_SESSION['session_expiry'] = trim($_POST['name']);
		$_SESSION['session_expiry_date'] = trim($_POST['expiry']);
    }
    public function save_session_live(){
        $_SESSION['session_live'] = trim($_POST['param']);

    }
    public function delete_session_price(){
        unset($_SESSION['session_price']);

    }
	public function save_session_price(){
        $_SESSION['session_data_default_price'] = trim($_POST['data_default']);
		$_SESSION['session_price'] = trim($_POST['value']);
    }
	public function save_session_lots(){
		$_SESSION['session_lots'] = trim($_POST['value']);
    }
	public function save_session_strike(){
        $_SESSION['session_strike'] = trim($_POST['name']);
		echo $_SESSION['session_strike'];
    }
	public function save_session_call_put(){
        $_SESSION['session_call_put'] = trim($_POST['name']);
		echo $_SESSION['session_call_put'];
    }
	public function save_session_duration(){
        $_SESSION['session_duration'] = trim($_POST['name']);
		echo $_SESSION['session_duration'];
    }
	public function save_session_order_type(){
        $_SESSION['session_order_type'] = trim($_POST['name']);
		echo $_SESSION['session_order_type'];
    }
	public function save_session_menu_model(){
		// get dividend
		$dsymbol = $_SESSION['array_other_product']['dsymbol'];
		$name_vdm_model = trim($_POST['name']);
		//echo "<pre>";print_r($_REQUEST);exit;
		//save session
        $_SESSION['session_menu_model'] = trim($_POST['name']);
 		$rs = $this->getResult($dsymbol);
		$arr = array();
		if($name_vdm_model == 'Discrete model with discrete dividend'){
			$arr['SFORMAT'] = number_format($rs['underlying']['last'],2);
			$arr['S'] = $rs['underlying']['last'];
			$arr['R'] = $rs['contacts']['r'];
			$arr['TFORMAT'] = date('M-y',strtotime($rs['contacts']['expiry']));
			$arr['T'] = (date('d',strtotime($rs['contacts']['expiry'])) - date('d'))+1;
			$arr['Q'] = $rs['contacts']['dividend_vl'];
		}
		if($name_vdm_model == 'Discrete model with proportional dividend'){
			$arr['SFORMAT'] = number_format($rs['underlying']['last'],2);
			$arr['S'] = $rs['underlying']['last'];
			$arr['R'] = $rs['contacts']['r'];
			$arr['TFORMAT'] = date('M-y',strtotime($rs['contacts']['expiry']));
			$arr['T'] = (date('d',strtotime($rs['contacts']['expiry'])) - date('d'))+1;
			$arr['Q'] = $rs['contacts']['dividend'];
		}
		if($name_vdm_model == 'Continuous model with discrete dividend'){
			$arr['SFORMAT'] = number_format($rs['underlying']['last'],2);
			$arr['S'] = $rs['underlying']['last'];
			$arr['R'] = $rs['contacts']['r'];
			$arr['TFORMAT'] = date('M-y',strtotime($rs['contacts']['expiry']));
			$arr['T'] = (date('d',strtotime($rs['contacts']['expiry'])) - date('d'))+1;
			$arr['Q'] = $rs['contacts']['dividend_vl'];	
		}
		if($name_vdm_model == 'Continuous model with proportional dividend'){
			$arr['SFORMAT'] = number_format($rs['underlying']['last'],2);
			$arr['S'] = $rs['underlying']['last'];
			$arr['R'] = $rs['contacts']['r'];
			$arr['TFORMAT'] = date('M-y',strtotime($rs['contacts']['expiry']));
			$arr['T'] = (date('d',strtotime($rs['contacts']['expiry'])) - date('d'))+1;
			$arr['Q'] = $rs['contacts']['dividend'];	
		}
		echo json_encode($arr);
		//echo $_SESSION['session_menu_model'];
    }
	
	public function caculate_dmwdd(){
		//echo "<pre>";print_r($_REQUEST);exit;
		$R = $_REQUEST['r'];
		$S = (float)str_replace(',','',$_REQUEST['s']);
		$T = $_REQUEST['t'];
		$Q = $_REQUEST['q'];
		
		 $RR = $R / 100;
         $QQ = $Q;
		$theorique = $S * (1 + ($RR) * ($T / 360)) - $QQ;
		echo json_encode($theorique);
	}
	public function caculate_dmwpd(){
		$R = $_REQUEST['r'];
		$S = (float)str_replace(',','',$_REQUEST['s']);
		$T = $_REQUEST['t'];
		$Q = $_REQUEST['q'];
		
		$RR = $R / 100;
        $QQ = $Q / 100;
		$theorique = $S * (1 + ($RR - $QQ) * ($T / 360));
		echo json_encode($theorique);
	}
	public function caculate_cmwdd(){
		$R = $_REQUEST['r'];
		$S = (float)str_replace(',','',$_REQUEST['s']);
		$T = $_REQUEST['t'];
		$Q = $_REQUEST['q'];
		
		  $RR = $R / 100;
          $QQ = $Q;
		 $theorique = $S * exp((($RR * $T) / 360) - ($QQ/$S));
		echo json_encode($theorique);
	}
	public function caculate_cmwpd(){
		$R = $_REQUEST['r'];
		$S = (float)str_replace(',','',$_REQUEST['s']);
		$T = $_REQUEST['t'];
		$Q = $_REQUEST['q'];
		
		 $RR = $R / 100;
         $QQ = $Q / 100;
		$theorique = $S * exp(($RR - $QQ) * ($T / 360));
		echo json_encode($theorique);
	}
	
	public function getResult($dsymbol){
        $result['underlying'] = $this->db3->select('*')->where('dsymbol',$dsymbol)->get('vdm_underlying_setting')->row_array();
        if(isset($result)){
            $result['contacts'] = $this->db3->select('*')->where('dsymbol',$dsymbol)->where('mm',date('m'))->where('active',1)->where('product','FUTURES')->get('vdm_contracts_setting_exc')->row_array();
            
        }
        return $result;
    }
	
	
    public function jq_loadtable(){
		//echo "<pre>";print_r($_REQUEST);exit;
		$jq_table = $_REQUEST['jq_table'];
		$page = $_REQUEST['page']; 
 
		// get how many rows we want to have into the grid - rowNum parameter in the grid 
		$limit = $_REQUEST['rows']; 
		$sidx = $_REQUEST['sidx'];
		$filter_get = array(); 
		
		if(isset($_REQUEST['filter_get_all'])){
			$filter_get = json_decode($_REQUEST['filter_get_all']);
		}
		// get index row - i.e. user click to sort. At first time sortname parameter -
		// after that the index from colModel 
		// sorting order - at first time sortorder 
	
		if(!$sidx) $sidx =1; 
		//echo "hung";exit;
		 $this->load->model('jq_loadtable_model');
		 $sord = $_REQUEST['sord'];

		$filter = $_REQUEST;
		
		$result = $this->jq_loadtable_model->getTable($page,$limit,$sord,$sidx,$filter,$filter_get,$jq_table);
		//var_export($result);exit;
		echo json_encode($result);
	}
	public function edit_del_add_jq_loadtable(){
		//echo "<pre>";print_r($_REQUEST['jq_table']);exit;
		 $this->load->model('article_model');
		 
		$data = array();
		
		if($_POST['oper'] == 'del'){
			$this->db->delete($_REQUEST['jq_table'], array('id' => $_POST['id'])); 
			echo "true";
		}
		if($_POST['oper'] == 'add'){
			foreach($_POST as $k=>$v){
				if($k!= 'oper' && $k!= 'id')
					$data[$k] = $v;	
			}
			$this->db->insert($_REQUEST['jq_table'], $data); 
			echo "true";
			
		}
		 if($_POST['oper'] == 'edit'){
			foreach($_POST as $k=>$v){
				if($k!= 'oper' && $k!= 'id')
					$data[$k] = $v;	
			}

			$this->db->where('id', $_POST['id']);
			$this->db->update($_REQUEST['jq_table'], $data);
			echo "true";
			
		 }
	}
	
	public function edit_del_add_vndmi_jq_loadtable(){
		//echo "<pre>";print_r($_REQUEST['jq_table']);exit;
		 $this->load->model('article_model');
		 
		$data = array();
		
		if($_POST['oper'] == 'del'){
			$this->db3->delete($_REQUEST['jq_table'], array('id' => $_POST['id'])); 
			echo "true";
		}
		if($_POST['oper'] == 'add'){
			foreach($_POST as $k=>$v){
				if($k!= 'oper' && $k!= 'id')
					$data[$k] = $v;	
			}exit;
			$this->db3->insert($_REQUEST['jq_table'], $data); 
			echo "true";
			
		}
		 if($_POST['oper'] == 'edit'){
			foreach($_POST as $k=>$v){
				if($k!= 'oper' && $k!= 'id')
					$data[$k] = $v;	
			}

			$this->db3->where('id', $_POST['id']);
			$this->db3->update($_REQUEST['jq_table'], $data);
			echo "true";
			
		 }
	}
	
	
	public function jq_loadtable_vndmi(){
		//echo "<pre>";print_r($_REQUEST);exit;
		$jq_table = $_REQUEST['jq_table'];
		$page = $_REQUEST['page']; 
 
		// get how many rows we want to have into the grid - rowNum parameter in the grid 
		$limit = $_REQUEST['rows']; 
		$sidx = $_REQUEST['sidx'];
		$filter_get = array(); 
		
		if(isset($_REQUEST['filter_get_all'])){
			$filter_get = json_decode($_REQUEST['filter_get_all']);
		}
		// get index row - i.e. user click to sort. At first time sortname parameter -
		// after that the index from colModel 
		// sorting order - at first time sortorder 
	
		if(!$sidx) $sidx =1; 
		//echo "hung";exit;
		 $this->load->model('jq_loadtable_vndmi_model');
		 $sord = $_REQUEST['sord'];

		$filter = $_REQUEST;
		
		$result = $this->jq_loadtable_vndmi_model->getTable($page,$limit,$sord,$sidx,$filter,$filter_get,$jq_table);
		//var_export($result);exit;
		echo json_encode($result);
	}
	
	
    public function loadtable(){
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
		$table = isset($_REQUEST['name_table'])? $_REQUEST['name_table'] :'';
		
		$category = isset($_POST['category'])? strtoupper($_POST['category']) :'';
		$arr_table_sys = $this->table->get_summary($table);
		
		$table_sys = isset($arr_table_sys["tab"]) ? $arr_table_sys["tab"] : 'int_'.$table;
		// select columns
		$where = "where 1=1 ";
       
		$headers = $this->table->get_headers($table_sys);
		$aColumns = array();
		foreach ($headers as $item) {
	        if($item['format_n'] == 'group'){
	              $aColumns[] = '`'.strtolower($item['field'].'_frt').'`,`'.strtolower($item['field'].'_bcd').'`,`'.strtolower($item['field'].'_hst').'`';
	        }else{  
			     $aColumns[] = '`'.strtolower($item['field']).'`';
            }
			$field_post = $this->input->post(strtolower($item['field']));
			$field_post_html = $this->input->post(strtolower("html_".$item['field']));
			if(($field_post!='') || ($field_post_html!='')) {
				$field_post = $field_post !='empty' ? $field_post :'';
				if((strpos(strtolower($item['type']),'list')!==false)){
					if($field_post != 'all') {
							$where .= " and `{$item['field']}` = '".$field_post."'";    
						}
				}
				else {
					switch(strtolower($item['type'])) {
						case 'varchar':
						case 'longtext':
						case 'int':
						case 'link':
							$where .= " and `{$item['field']}` like '%".$field_post."%'";
							break;
						case 'html':
						case 'info':
							$where .= " and `{$item['field']}` like '%".$field_post_html."%'";
							break;
						case 'list':
							if($field_post != 'all') {
								$where .= " and `{$item['field']}` = '".$field_post."'";    
							}
							break;
						default:
							break;
					}
				}
			}else if($this->input->post(strtolower($item['field'].'_start')) and strtotime($this->input->post(strtolower($item['field'].'_start')))) {
				$where .= " and `{$item['field']}` >= '".real_escape_string($this->input->post(strtolower($item['field'].'_start')))."'";
			} 
			 else if($this->input->post(strtolower($item['field'].'_from'))) {
				$where .= " and `{$item['field']}` >= ".(int)($this->input->post(strtolower($item['field'].'_from')))."";
			}
			if($this->input->post(strtolower($item['field'].'_end')) and strtotime($this->input->post(strtolower($item['field'].'_end')))){
				 $where .= " and `{$item['field']}` <= '".real_escape_string($this->input->post(strtolower($item['field'].'_end')))."'";
			}
			if($this->input->post(strtolower($item['field'].'_to'))) {
				$where .= " and `{$item['field']}` <= ".(int)($this->input->post(strtolower($item['field'].'_to')))."";
			}
             
		}
		if($category != 'ALL' && $category != '') $where .= " and `category` = '".$category."'";
		
		$sTable = $table_sys; //$category == 'all' ? "int_".$table : "(SELECT * FROM int_".$table." where category = '".$category."') as sTable " ;		
		$sqlColumn = "SHOW COLUMNS FROM {$sTable};";  
		$arrColumn = $this->db->query($sqlColumn)->result_array(); 
		foreach ($arrColumn as $item){		 	
			if(!$this->input->post(strtolower($item['Field'])) && isset($_GET[$item['Field']]) && ($_GET[$item['Field']]!='all') && (strtolower($item['Field']!='tab'))){
				 $where .= " and `{$item['Field']}` = '".$_GET[$item['Field']]."'";
				 
			}
		 }
		// order
		$order_by ='';	
		if (isset($_REQUEST['order'][0]['column'])) {
			if(($table =='data_report')|| ($table =='simul_query')){
				$iSortCol_0 = $_REQUEST['order'][0]['column']-1;
				$sSortDir_0 = $_REQUEST['order'][0]['dir'];
			}
			else {
				$iSortCol_0 = $_REQUEST['order'][0]['column'];
				$sSortDir_0 = $_REQUEST['order'][0]['dir'];
			}
			foreach($aColumns as $key => $value) {
				if($iSortCol_0 == $key) {                    
					$order_by = " order by $value ".$sSortDir_0;
					break;
				}
			}
		}
		$order_by .= (($arr_table_sys['order_by']!='') && (!is_null($arr_table_sys['order_by'])))?($order_by =='' ? ('order by '.$arr_table_sys['order_by']):(','.$arr_table_sys['order_by'])):'';
        
        $sqlkey = "SELECT `keys`, `user_level` FROM int_summary WHERE `tab` = '{$table_sys}'";
		$keyARR = $this->db->query($sqlkey)->row_array();
		
        if(isset($keyARR)){
            if(isset($keyARR['keys'])&&$keyARR['keys'] != ''){
        		$keyARR = isset($keyARR) ? $keyARR: array();
        		$arr = explode(',',$keyARR['keys']);
        		foreach($arr as $v){ 
        			$aa[] = '`'.TRIM($v).'`';
        		}   
        		$rs = in_array($aa, $aColumns, TRUE) ?  $aColumns : array_merge((array)$aa, (array)$aColumns);
                $ke = explode(',',$keyARR['keys']);	
            }else{
                $rs = $aColumns;
            }  
        }
        $sql = "select sql_calc_found_rows *
    					from {$sTable} {$where} {$order_by};";    
	//	print_R($order_by);exit;			
		$data = $this->db->query($sql)->result_array();
		
		//$data = $this->db->query($sql)->result_array();  
		$arr_data = array();
		$i =0;
		foreach ($data as $key => $value) {
			$arr_data[$i] = $value;	
			$i++;		
		}
		//var_export($arr_data);
		$iFilteredTotal = $i;
		$iTotalRecords = $iFilteredTotal;
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
           //print_R()
		   
		//$data = $this->db->query($sql)->result_array();   
		$records = array();
		$records["data"] = array();
        //PRINT_r($data);EXIT;
		$key = 0;
		for ($x = $iDisplayStart; $x < $iDisplayStart + $iDisplayLength; $x++) {
			if(isset($arr_data[$x])) {
				$path = base_url().'assets/upload/intranet';
				if(isset($arr_data[$x]['group']) && $arr_data[$x]['group']!='') $path .='/'.strtolower($arr_data[$x]['group']);
				if(isset($arr_data[$x]['owner']) && $arr_data[$x]['owner']!='') $path .='/'.strtolower($arr_data[$x]['owner']);
				if(isset($arr_data[$x]['category']) && $arr_data[$x]['category']!='') $path .='/'.strtolower($arr_data[$x]['category']);
				if(isset($arr_data[$x]['subcat']) && $arr_data[$x]['subcat']!='') $path .='/'.strtolower($arr_data[$x]['subcat']);
                if($table == 'query' || $table == 'data_report'){
			         $records["data"][$key][] = '<input type="checkbox" class="checkboxes" value="'.$arr_data[$x]['id'].'">';	// check s
                }
				
				foreach($headers as $item) {
					if($table == 'data_report' && $item['url']!=''){
						$arr_url = explode("|",$item['url']);			 
						foreach($arr_url as $item_url) {
							$url_task = str_replace(" ","",$item_url);
							$pos_conn = strpos($url_task,$arr_data[$x]["connection"]);
							if ($pos_conn !== false) {
								$pos_inside = strpos($url_task,"INLIST");
								if ($pos_inside !== false) {
									$url_task = substr($url_task,0, $pos_inside);
								}
								break;	
							}
							else {
								$pos_inside = strpos($url_task,"INLIST");
								if ($pos_inside !== false) {
									$url_task = "";
								}
							}
						} 
						if($url_task!='')
						{
							if (strpos($url_task,'http')!==FALSE||strpos($url_task,'https')!==FALSE) {
								$url_task = $url_task;
							}
							else {
								$url_task = base_url().$url_task;
							}
							foreach($headers as $column_task) {
								$url_task = str_replace('@'.strtolower($column_task["field"]).'@',$arr_data[$x][$column_task["field"]],$url_task);
															
							}
							$title_blue = "title-blue";
							$start_href_1 ="<a href='{$url_task}' target='_blank' ";
							$end_href =" </a>";
							$link_url =$start_href_1." >";
							$end_link_url = " </a>";
						}
						else {
							$url_task ='';
							$title_blue='';
							$start_href_1 ="<div ";
							$end_href =" </div>";
							$link_url ="";
							$end_link_url = "";
						}
						
					}
					else if($item['url']!=''){
						if (strpos($item['url'],'http')!==FALSE||strpos($item['url'],'https')!==FALSE) {
							$url_task = $item['url'];
						}
						else {
							$url_task = base_url().$item['url'];
						}
						foreach($headers as $column_task) {
							$url_task = str_replace('@'.strtolower($column_task["field"]).'@',$arr_data[$x][$column_task["field"]],$url_task);
														
						} 
						$title_blue = "title-blue";
						$start_href_1 ="<a href='{$url_task}' ";
						$end_href =" </a>";
						$link_url =$start_href_1." >";
						$end_link_url = " </a>";
						
					}
					else {
						$url_task ='';
						$title_blue='';
						$start_href_1 ="<div ";
						$end_href =" </div>";
						$link_url ="";
						$end_link_url = "";
					}
					switch($item['align']) {
						case 'L':
							$start_href = $start_href_1.'class="align-left '.$title_blue.' " >';
							$align = ' class="align-left"';
							break;
						case 'R';
							$start_href = $start_href_1.'class="align-right '.$title_blue.' " >';
							$align = ' class="align-right"';
							break;
						default:
							$start_href = $start_href_1.'class="align-center '.$title_blue.'" >';
							$align = ' class="align-center"';
							break;
					}
					if(($table =='data_report') && (strtolower($item['field'])=='update') && (date('Y-m-d',strtotime("now")) == date('Y-m-d',strtotime($arr_data[$x][strtolower($item['field'])])))){
						$records["data"][$key][] = $start_href.date('H:i:s',strtotime($arr_data[$x][strtolower($item['field'])])) .$end_href;
					}
					else if(($item['hidden']==1)){
						$pattern = '/[\S]/';
						$replacement = '*';
						$records["data"][$key][] = $start_href. preg_replace($pattern, $replacement,  $arr_data[$x][strtolower($item['field'])]).$start_href;
						$length = strlen($arr_data[$x][strtolower($item['field'])]);
					}
					else if($item['format_n'] == 'group'){	
						if(strpos($arr_data[$x][strtolower($item['field']).'_frt'],'http') !== false){
							$url = 	$arr_data[$x][strtolower($item['field']).'_frt'];
						}
						else{
							$url = 	'http://'.$arr_data[$x][strtolower($item['field']).'_frt'];	
						}
						if(strpos($arr_data[$x][strtolower($item['field']).'_bcd'],'http') !== false){
							$url2 = $arr_data[$x][strtolower($item['field']).'_bcd'];
						}
						else{
							$url2 = 'http://'.$arr_data[$x][strtolower($item['field']).'_bcd'];	
						}
							$records["data"][$key][] ='<div'.$align.'>
							
							<a href="'.$url.'" '.($arr_data[$x][strtolower($item['field']).'_frt'] != '' ? '' : 'disabled') .' target="_blank" class="btn btn-sm default btn-'.(isset($arr_data[$x][strtolower($item['field']).'_hst']) ? strtolower(str_replace(' ','',$arr_data[$x][strtolower($item['field']).'_hst'])) :"local.itvn.fr").' '.($arr_data[$x][strtolower($item['field']).'_frt'] != '' ? '' : 'hide' ).'" >F</a>
								
								<a href="'.$url2.'"'.($arr_data[$x][strtolower($item['field']).'_bcd'] == '#' ? 'disabled' : '' ).' target="_blank" class="btn btn-sm blue '.($arr_data[$x][strtolower($item['field']).'_bcd'] != '' ? '' : 'hide' ).'">B </a></div>';
						
					
					}else if($item['format_n'] == 'image'){
						$imgsize = @getimagesize(base_url().'assets/upload/images/'.$arr_data[$x][strtolower($item['field'])]);
						if (!is_array($imgsize)){ 
							$records["data"][$key][] = '';
						}else{
							$start = strpos(strtolower($item['type']),'(') +1;
							$end = strpos(strtolower($item['type']),')');
							$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
							$arrHeight = explode(',', $str);
							$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
							$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;
							$image = $arr_data[$x][strtolower($item['field'])]!=''? '<img height="'.$height.'" src="'.base_url().'assets/upload/images/'.$arr_data[$x][strtolower($item['field'])].'" class="thumb" data-height="'.$heightMax.'" >' :'';
							$records["data"][$key][] = $start_href.$image.$end_href;
						}
					}else if($item['format_n'] == 'button'){
						$records["data"][$key][] = '<div'.$align.'><a href="'.base_url().'table/'.$arr_data[$x][strtolower($item['field'])].'" class="text-uppercase">'.$arr_data[$x][strtolower($item['field'])].'</a></div>';   
					}else if($item['format_n'] == 'popup'){
						 if((strpos(strtolower($item['type']),'image')!==false)){
							$start = strpos(strtolower($item['type']),'(') +1;
							$end = strpos(strtolower($item['type']),')');
							$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
							$arrHeight = explode(',', $str);
							$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
							$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;							
						}
                         if(strtolower($arr_data[$x][strtolower($item['field'])]) == 'x'){
                            $records["data"][$key][]= '<a  class="mix-link" href="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" download="'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'">
										<i class="fa fa-link"></i> </a>
													<a data-fancybox-group="'.$category.'_'.strtolower($item['field']).'" title="'.$arr_data[$x]['file'].'" href="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" class="mix-preview fancybox-button">
													<i class="fa fa-search thumb" src="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" data-height="'.$heightMax.'"></i>';
                         }
						  else if(is_file($arr_data[$x][strtolower($item['field'])])){
							 if($arr_data[$x][strtolower($item['field'])] == 'assets/images/no-image.jpg'){
								$records["data"][$key][]= '';
							 }
							 else{
								 
								 $records["data"][$key][]= '<a  class="mix-link" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" download="'.$arr_data[$x][strtolower($item['field'])].'">
											<i class="fa fa-link"></i> </a>
														<a data-fancybox-group="'.$category.'_'.strtolower($item['field']).'" title="'.$arr_data[$x][strtolower($item['field'])].'" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" class="mix-preview fancybox-button">
														<i class="fa fa-search thumb" src="'.base_url().$arr_data[$x][strtolower($item['field'])].'" data-height="'.$heightMax.'"></i>';
									 
							}
                         }else{
                            $records["data"][$key][] = $arr_data[$x][strtolower($item['field'])];
                         }
                    }else if((strtolower($item['format_n'])=='info')&& $arr_data[$x][strtolower($item['field'])]!=''){
						$records["data"][$key][] = "<div".$align."><a data-toggle='tooltip' data-placement='top' data-trigger='hover' data-html='true' data-container='body' data-original-title='".html_entity_decode($arr_data[$x][strtolower($item['field'])])."' title='".html_entity_decode($arr_data[$x][strtolower($item['field'])])."' class='btn btn-icon-only blue tooltips'  href='#'>
									<i class='fa fa-question'></i></a></div>";
						
					}
					else if((strpos(strtolower($item['format_n']),'decimal')!==false)&&$arr_data[$x][strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['format_n']),'(') +1;
						$end = strpos(strtolower($item['format_n']),')');
						$str = ($start!==false && $end!==false) ? intval(substr($item['format_n'],$start,  $end - $start)) : 0;
						$records["data"][$key][] = $start_href.number_format((float)$arr_data[$x][strtolower($item['field'])], intval($str), '.', ',').$end_href;
					}
					else if($item['format_n'] == 'download'){
                         if(strtolower($arr_data[$x][strtolower($item['field'])]) == 'x'){
							 
                            $records["data"][$key][]= '<a title="'.$arr_data[$x]['file'].'" href="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" download="'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" >
            				   							<i class="fa fa-download"></i>
            											</a>';
                         }else if(is_file($arr_data[$x][strtolower($item['field'])])){
                            $records["data"][$key][]= '<a title="'.$arr_data[$x][strtolower($item['field'])].'" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" download="'.$arr_data[$x][strtolower($item['field'])].'" >
            				   							<i class="fa fa-download"></i>
            											</a>';
                         }else{
                            $records["data"][$key][] = $arr_data[$x][strtolower($item['field'])];
                         }
                    }
					else if((strpos(strtolower($item['type']),'image')!==false)){
						$start = strpos(strtolower($item['type']),'(') +1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
						$arrHeight = explode(',', $str);
						$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
						$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;
						$image =$arr_data[$x][strtolower($item['field'])]!=''? '<img height="'.$height.'" src="'.base_url().$arr_data[$x][strtolower($item['field'])].'" class="thumb" data-height="'.$heightMax.'" >' :'';
						
						$records["data"][$key][] = '<div'.$align.'><a data-fancybox-group="'.$category.'" title="'.$arr_data[$x][strtolower($item['field'])].'" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" class="mix-preview fancybox-button">'.$image.'</a></div>';
						
					}
					else if((strtolower($item['type'])=='file')&& $arr_data[$x][strtolower($item['field'])]!=''){
						
						if(strpos($arr_data[$x][strtolower($item['field'])], 'http')===false && strpos($arr_data[$x][strtolower($item['field'])], 'https')===false)
						$records["data"][$key][] = '<div'.$align.'><a class="btn btn-icon-only blue"  href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" download="'.$arr_data[$x][strtolower($item['field'])].'">
									<i class="fa fa-file-pdf-o"></i></a></div>';
						else {
							
							$records["data"][$key][] = '<div'.$align.'><a class="btn btn-icon-only blue" href="'.$arr_data[$x][strtolower($item['field'])].'" download="'.$arr_data[$x][strtolower($item['field'])].'">
									<i class="fa fa-file-pdf-o"></i></a></div>';
							
						}
						
					}
                    else if((strtolower($item['type'])=='info')&& $arr_data[$x][strtolower($item['field'])]!=''){
						$records["data"][$key][] = '<div'.$align.'><span  style = "position:relative;" class="tooltips" data-toggle="tooltip" data-placement="top" title="'.$arr_data[$x][strtolower($item['field'])].'"><a style = "position:absolute; top:10px; left:20px; height:27px; width:27px; padding:3px;" class="btn btn-icon-only blue"  href="#">
									<i class="fa fa-question"></i></a></span></div>';
						
					}
					else if((strpos(strtolower($item['type']),'link')!==false)&&$arr_data[$x][strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['type']),'(') +1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : 'Link';
						if(strpos($arr_data[$x][strtolower($item['field'])], 'http')===false && strpos($arr_data[$x][strtolower($item['field'])], 'https')===false)
						$records["data"][$key][] = '<div'.$align.'><a class="btn btn-icon-only green" href="http://'.$arr_data[$x][strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';							
						
						else {
							
							$records["data"][$key][] = '<div'.$align.'><a class="btn btn-icon-only green" href="'.$arr_data[$x][strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';
							
						}
					}
					else{// xử lý tô màu background cho report_task
					 		$sql_st = "SELECT `value` FROM setting WHERE `key` = 'color_red'";
							$row_st = $this->db->query($sql_st)->row_array();
						if($sTable == 'report_task'){
							if($arr_data[$x][strtolower($item['field'])] < 3 && $item['field'] =='total'){
								$records["data"][$key][] = '<div'.$align.' style="background: '.$row_st['value'].'; border-radius: 3px;color: #fff; padding: 7px;">'.$link_url.$arr_data[$x][strtolower($item['field'])] .$end_link_url.'</div>';
							}
							elseif($arr_data[$x][strtolower($item['field'])] > 0 && $item['field'] == 'priority0'){
								$records["data"][$key][] = '<div'.$align.' style="background: '.$row_st['value'].'; border-radius: 3px;color: #fff; padding: 7px;">'.$link_url.$arr_data[$x][strtolower($item['field'])] .$end_link_url.'</div>';
							}
							
							elseif($arr_data[$x][strtolower($item['field'])] == 0 && $item['field'] == 'current'){
								$records["data"][$key][] = '<div'.$align.' style="background: '.$row_st['value'].'; border-radius: 3px;color: #fff; padding: 7px;">'.$link_url.$arr_data[$x][strtolower($item['field'])] .$end_link_url.'</div>';
							}
							elseif($arr_data[$x][strtolower($item['field'])] > 3 && $item['field'] == 'done'){
								$records["data"][$key][] = '<div'.$align.' style="background: '.$row_st['value'].'; border-radius: 3px;color: #fff; padding: 7px;">'.$link_url.$arr_data[$x][strtolower($item['field'])] .$end_link_url.'</div>';
							}
							else{
								$records["data"][$key][] = $start_href.$arr_data[$x][strtolower($item['field'])] .$end_href;	
							}
						}
						else{
							$records["data"][$key][] = $start_href.$arr_data[$x][strtolower($item['field'])] .$end_href;		
						}
					}
					
	
				}
				
                if(isset($keyARR['keys'])&&$keyARR['keys'] != ''){
                    $keys = array();
				
    				foreach($ke as $val){
    				   $keys[] = "'".$arr_data[$x][strtolower($val)]."' ";
    			   
    				}
    				//print_r($keys);
    				$k = implode(',',$keys);
                    
    				
                    if($keyARR['user_level']>$this->session->userdata('user_level')){
    					$records["data"][$key][] .='';
						
						 /*  $records["data"][$key][] .= '<center><div class="align-center">'
											.'<a class="btn btn-icon-only green show-modal" type-modal="update" keys_value="'.$k.'" table_name="'.$table.'"  data-target="#modal" data-toggle="modal">
											<i class="fa fa-edit"></i></a>'
											.'<a class="btn btn-icon-only red deleteField" keys_value="'.$k.'" table_name="'.$table.'" href="#">
											<i class="fa fa-trash-o"></i></a>'
											.'</div></center>';*/
    				}else{
						if($table == 'ifrc_articles'){
							 $records["data"][$key][] .= '<center><div class="align-center">'
												.'<a href="'.base_url().'ajax/update_modal_intranet/'.str_replace(" ","",str_replace("'","",$k)).'" class="btn btn-icon-only green show-modal" type-modal="update" keys_value="'.$k.'" table_name="'.$table.'">
											<i class="fa fa-edit"></i></a>'
												.'<a class="btn btn-icon-only red deleteField" keys_value="'.$k.'" table_name="'.$table.'" href="#">
												<i class="fa fa-trash-o"></i></a>'
												
												.'</div></center>';
												
							
						}else{
						 $records["data"][$key][] .= '<center><div class="align-center">'
												.'<a class="btn btn-icon-only green show-modal" type-modal="update" keys_value="'.$k.'" table_name="'.$table.'"  data-target="#modal" data-toggle="modal">
												<i class="fa fa-edit"></i></a>'
												.'<a class="btn btn-icon-only red deleteField" keys_value="'.$k.'" table_name="'.$table.'" href="#">
												<i class="fa fa-trash-o"></i></a>'
												.'<a class="btn btn-icon-only yellow duplicateField" keys_value="'.$k.'" table_name="'.$table.'" href="#">
												<i class="fa fa-copy"></i></a>'
												.'</div></center>';
						}
    				}
                }else
                {
                    $records["data"][$key][] .= '';
                }
			}
			$key ++;
		
		}

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iFilteredTotal;
          
        $this->output->set_output(json_encode($records));
    }
	 public function loadtable_vnxindex(){
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
		$table = isset($_REQUEST['name_table'])? $_REQUEST['name_table'] :'';
		
		$category = isset($_POST['category'])? strtoupper($_POST['category']) :'';
		$arr_table_sys = $this->table->get_summary($table);
		
		$table_sys = isset($arr_table_sys["tab"]) ? $arr_table_sys["tab"] : 'int_'.$table;
		// select columns
		$where = "where 1=1 ";
       
		$headers = $this->table->get_headers($table_sys);
		$aColumns = array();
		$arrPost = "";
		foreach ($headers as $item) {
	        if($item['format_n'] == 'group'){
	              $aColumns[] = '`'.strtolower($item['field'].'_frt').'`,`'.strtolower($item['field'].'_bcd').'`,`'.strtolower($item['field'].'_hst').'`';
	        }else{  
			     $aColumns[] = '`'.strtolower($item['field']).'`';
            }
			$field_post = $this->input->post(strtolower($item['field']));
			$arrPost .=isset($_REQUEST[strtolower($item['field'])]) ? "&{$item['field']}=".$_REQUEST[strtolower($item['field'])]:'';
			$field_post_html = $this->input->post(strtolower("html_".$item['field']));
			if(($field_post!='') || ($field_post_html!='')) {
				$field_post = $field_post !='empty' ? $field_post :'';
				if((strpos(strtolower($item['type']),'list')!==false)){
					if($field_post != 'all') {
							$where .= " and `{$item['field']}` = '".$field_post."'";    
						}
						$arrPost .="&{$item['field']}=".$field_post;
				}
				else {
					switch(strtolower($item['type'])) {
						case 'varchar':
						case 'longtext':
						case 'int':
						case 'link':
							$where .= " and `{$item['field']}` like '%".$field_post."%'";
							$arrPost .="&{$item['field']}=".$field_post;
							
							break;
						case 'html':
						case 'info':
							$where .= " and `{$item['field']}` like '%".$field_post_html."%'";
							$arrPost .="&{$item['field']}=".$field_post_html;
							break;
						case 'list':
							if($field_post != 'all') {
								$where .= " and `{$item['field']}` = '".$field_post."'";    
							}
							break;
						default:
							break;
					}
				}
			}else if($this->input->post(strtolower($item['field'].'_start')) and strtotime($this->input->post(strtolower($item['field'].'_start')))) {
				$where .= " and `{$item['field']}` >= '".real_escape_string($this->input->post(strtolower($item['field'].'_start')))."'";
				//$arrPost .="&{$item['field']}_start=".real_escape_string($this->input->post(strtolower($item['field'].'_start')));
				$arrPost .=isset($_REQUEST[strtolower($item['field'].'_start')]) ? "&{$item['field']}_start=".$_REQUEST[strtolower($item['field'].'_start')]:"";
			} 
			 else if($this->input->post(strtolower($item['field'].'_from'))) {
				$where .= " and `{$item['field']}` >= ".(int)($this->input->post(strtolower($item['field'].'_from')))."";
				//$arrPost .="&{$item['field']}_from=".(int)($this->input->post(strtolower($item['field'].'_from')));
				$arrPost .=isset($_REQUEST[strtolower($item['field'].'_from')]) ? "&{$item['field']}_from=".$_REQUEST[strtolower($item['field'].'_from')]:"";
				
			}
			if($this->input->post(strtolower($item['field'].'_end')) and strtotime($this->input->post(strtolower($item['field'].'_end')))){
				 $where .= " and `{$item['field']}` <= '".real_escape_string($this->input->post(strtolower($item['field'].'_end')))."'";
				 //$arrPost .="&{$item['field']}_end=".real_escape_string($this->input->post(strtolower($item['field'].'_end')));
				 $arrPost .=isset($_REQUEST[strtolower($item['field'].'_end')]) ? "&{$item['field']}_end=".$_REQUEST[strtolower($item['field'].'_end')]:"";
				 
			}
			if($this->input->post(strtolower($item['field'].'_to'))) {
				$where .= " and `{$item['field']}` <= ".(int)($this->input->post(strtolower($item['field'].'_to')))."";
				//$arrPost .="&{$item['field']}_to=".(int)($this->input->post(strtolower($item['field'].'_to')));
				$arrPost .=isset($_REQUEST[strtolower($item['field'].'_to')]) ? "&{$item['field']}_to=".$_REQUEST[strtolower($item['field'].'_to')]:"";
			}
             
		}
		if($category != 'ALL' && $category != '') $where .= " and `category` = '".$category."'";
		
		$sTable = $table_sys; //$category == 'all' ? "int_".$table : "(SELECT * FROM int_".$table." where category = '".$category."') as sTable " ;
		
		$sqlColumn = "SHOW COLUMNS FROM {$sTable};";  
		$arrColumn = $this->db->query($sqlColumn)->result_array();
			
		
		foreach ($arrColumn as $item){		 	
			if(!$this->input->post(strtolower($item['Field'])) && isset($_GET[$item['Field']]) && ($_GET[$item['Field']]!='all') && (strtolower($item['Field']!='tab'))){
				 $where .= " and `{$item['Field']}` = '".$_GET[$item['Field']]."'";
				 
			}
		 }
		// order
		$order_by ='';	
		if (isset($_REQUEST['order'][0]['column'])) {
			$iSortCol_0 = $_REQUEST['order'][0]['column'];
			$sSortDir_0 = $_REQUEST['order'][0]['dir'];
			foreach($aColumns as $key => $value) {
				if($iSortCol_0 == $key) {                    
					$order_by = " order by $value ".$sSortDir_0;
					break;
				}
			}
		}
		$order_by .= (($arr_table_sys['order_by']!='') && (!is_null($arr_table_sys['order_by'])))?($order_by =='' ? ('order by '.$arr_table_sys['order_by']):(','.$arr_table_sys['order_by'])):'';
        
        $sqlkey = "SELECT `keys`, `user_level` FROM int_summary WHERE `tab` = '{$table_sys}'";
		$keyARR = $this->db->query($sqlkey)->row_array();
			
        if(isset($keyARR)){
            if(isset($keyARR['keys'])&&$keyARR['keys'] != ''){
        		$keyARR = isset($keyARR) ? $keyARR: array();
        		$arr = explode(',',$keyARR['keys']);
        		foreach($arr as $v){ 
        			$aa[] = '`'.TRIM($v).'`';
        		}   
        		$rs = in_array($aa, $aColumns, TRUE) ?  $aColumns : array_merge((array)$aa, (array)$aColumns);
                $ke = explode(',',$keyARR['keys']);	
            }else{
                $rs = $aColumns;
            }  
        }
        $sql = "select sql_calc_found_rows *
    					from {$sTable} {$where} {$order_by};";    
		$data = $this->db->query($sql)->result_array();
	
		//$data = $this->db->query($sql)->result_array();  
		$arr_data = array();
		$i =0;
		foreach ($data as $key => $value) {
			$arr_data[$i] = $value;	
			$i++;		
		}
		//var_export($arr_data);
		$iFilteredTotal = $i;
		$iTotalRecords = $iFilteredTotal;
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
           //     print_R()
		   
		//$data = $this->db->query($sql)->result_array();   
		$records = array();
		$records["data"] = array();
        //PRINT_r($data);EXIT;
		$key = 0;
		for ($x = $iDisplayStart; $x < $iDisplayStart + $iDisplayLength; $x++) {
			if(isset($arr_data[$x])) {
				$path = base_url().'assets/upload/intranet';
				if(isset($arr_data[$x]['group']) && $arr_data[$x]['group']!='') $path .='/'.strtolower($arr_data[$x]['group']);
				if(isset($arr_data[$x]['owner']) && $arr_data[$x]['owner']!='') $path .='/'.strtolower($arr_data[$x]['owner']);
				if(isset($arr_data[$x]['category']) && $arr_data[$x]['category']!='') $path .='/'.strtolower($arr_data[$x]['category']);
				if(isset($arr_data[$x]['subcat']) && $arr_data[$x]['subcat']!='') $path .='/'.strtolower($arr_data[$x]['subcat']);
                if($table == 'query' || $table == 'data_report'){
			         $records["data"][$key][] = '<input type="checkbox" class="checkboxes" value="'.$arr_data[$x]['id'].'">';	// check s
                }
				foreach($headers as $item) {
					switch($item['align']) {
						case 'L':
							$align = ' class="align-left"';
							break;
						case 'R';
							$align = ' class="align-right"';
							break;
						default:
							$align = ' class="align-center"';
							break;
					}
					if(($item['hidden']==1)){
						$length = strlen($arr_data[$x][strtolower($item['field'])]);
						$records["data"][$key][] = '<div'.$align.'>'.substr(str_repeat('*',$length),0,16).'</div>';
					}
					else if($item['format_n'] == 'group'){	
						$records["data"][$key][] = '<div'.$align.'><a href="http://'.$arr_data[$x][strtolower($item['field']).'_frt'].'" '.($arr_data[$x][strtolower($item['field']).'_frt'] != '' ? '' : 'disabled') .' target="_blank" class="btn btn-sm default btn-'.(isset($arr_data[$x][strtolower($item['field']).'_hst']) ? strtolower(str_replace(' ','',$arr_data[$x][strtolower($item['field']).'_hst'])) :"local.itvn.fr").' '.($arr_data[$x][strtolower($item['field']).'_frt'] != '' ? '' : 'hide' ).'">Front </i><a href="http://'.$arr_data[$x][strtolower($item['field']).'_bcd'].'"'.($arr_data[$x][strtolower($item['field']).'_bcd'] == '#' ? 'disabled' : '' ).' target="_blank" class="btn btn-sm blue '.($arr_data[$x][strtolower($item['field']).'_bcd'] != '' ? '' : 'hide' ).'">Back </div>';
					}else if($item['format_n'] == 'image'){
						$imgsize = @getimagesize(base_url().'assets/upload/images/'.$arr_data[$x][strtolower($item['field'])]);
						if (!is_array($imgsize)){ 
							$records["data"][$key][] = '';
						}else{
							$start = strpos(strtolower($item['type']),'(') +1;
							$end = strpos(strtolower($item['type']),')');
							$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
							$arrHeight = explode(',', $str);
							$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
							$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;
							$image = $arr_data[$x][strtolower($item['field'])]!=''? '<img height="'.$height.'" src="'.base_url().'assets/upload/images/'.$arr_data[$x][strtolower($item['field'])].'" class="thumb" data-height="'.$heightMax.'" >' :'';
							$records["data"][$key][] = '<div'.$align.'>'.$image.'</div>';
						}
					}else if($item['format_n'] == 'button'){
						$records["data"][$key][] = '<div'.$align.'><a href="'.base_url().'table/'.$arr_data[$x][strtolower($item['field'])].'" class="text-uppercase">'.$arr_data[$x][strtolower($item['field'])].'</a></div>';   
					}else if($item['format_n'] == 'popup'){
						 if((strpos(strtolower($item['type']),'image')!==false)){
							$start = strpos(strtolower($item['type']),'(') +1;
							$end = strpos(strtolower($item['type']),')');
							$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
							$arrHeight = explode(',', $str);
							$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
							$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;							
						}
                         if(strtolower($arr_data[$x][strtolower($item['field'])]) == 'x'){
                            $records["data"][$key][]= '<a  class="mix-link" href="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" download="'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'">
										<i class="fa fa-link"></i> </a>
													<a data-fancybox-group="'.$category.'_'.strtolower($item['field']).'" title="'.$arr_data[$x]['file'].'" href="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" class="mix-preview fancybox-button">
													<i class="fa fa-search thumb" src="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" data-height="'.$heightMax.'"></i>';
                         }
						  else if(is_file($arr_data[$x][strtolower($item['field'])])){
                            $records["data"][$key][]= '<a  class="mix-link" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" download="'.$arr_data[$x][strtolower($item['field'])].'">
										<i class="fa fa-link"></i> </a>
													<a data-fancybox-group="'.$category.'_'.strtolower($item['field']).'" title="'.$arr_data[$x][strtolower($item['field'])].'" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" class="mix-preview fancybox-button">
													<i class="fa fa-search thumb" src="'.base_url().$arr_data[$x][strtolower($item['field'])].'" data-height="'.$heightMax.'"></i>';
                         }else{
                            $records["data"][$key][] = $arr_data[$x][strtolower($item['field'])];
                         }
                    }else if((strtolower($item['format_n'])=='info')&& $arr_data[$x][strtolower($item['field'])]!=''){
						$records["data"][$key][] = "<div".$align."><a data-toggle='tooltip' data-placement='top' data-trigger='hover' data-html='true' data-container='body' data-original-title='".$arr_data[$x][strtolower($item['field'])]."' title='".$arr_data[$x][strtolower($item['field'])]."' class='btn btn-icon-only blue tooltips'  href='#'>
									<i class='fa fa-question'></i></a></div>";
						
					}else if($item['format_n'] == 'download'){
                         if(strtolower($arr_data[$x][strtolower($item['field'])]) == 'x'){
							 
                            $records["data"][$key][]= '<a title="'.$arr_data[$x]['file'].'" href="'.$path.'/'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" download="'.$arr_data[$x]['file'].'.'.strtolower($item['field']).'" >
            				   							<i class="fa fa-download"></i>
            											</a>';
                         }else if(is_file($arr_data[$x][strtolower($item['field'])])){
                            $records["data"][$key][]= '<a title="'.$arr_data[$x][strtolower($item['field'])].'" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" download="'.$arr_data[$x][strtolower($item['field'])].'" >
            				   							<i class="fa fa-download"></i>
            											</a>';
                         }else{
                            $records["data"][$key][] = $arr_data[$x][strtolower($item['field'])];
                         }
                    }
					else if((strpos(strtolower($item['type']),'image')!==false)){
						$start = strpos(strtolower($item['type']),'(') +1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : '';
						$arrHeight = explode(',', $str);
						$height = (isset($arrHeight[0]) && $arrHeight[0] >0) ?  $arrHeight[0]: 20;
						$heightMax = (isset($arrHeight[1]) && $arrHeight[1] >0 ) ?  $arrHeight[1]: 200;
						$image =$arr_data[$x][strtolower($item['field'])]!=''? '<img height="'.$height.'" src="'.PATH_IFRC_ARTICLE.$arr_data[$x][strtolower($item['field'])].'" class="thumb" data-height="'.$heightMax.'" >' :'';
						
						$records["data"][$key][] = '<div'.$align.'><a data-fancybox-group="'.$category.'" title="'.$arr_data[$x][strtolower($item['field'])].'" href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" class="mix-preview fancybox-button">'.$image.'</a></div>';
						
					}
					else if((strtolower($item['type'])=='file')&& $arr_data[$x][strtolower($item['field'])]!=''){
						$records["data"][$key][] = '<div'.$align.'><a class="btn btn-icon-only blue"  href="'.base_url().$arr_data[$x][strtolower($item['field'])].'" download="'.$arr_data[$x][strtolower($item['field'])].'">
									<i class="fa fa-file-pdf-o"></i></a></div>';
						
					}
                    else if((strtolower($item['type'])=='info')&& $arr_data[$x][strtolower($item['field'])]!=''){
						$records["data"][$key][] = '<div'.$align.'><span style = "position:relative;" class="tooltips" data-toggle="tooltip" data-placement="top" title="'.$arr_data[$x][strtolower($item['field'])].'"><a style = "position:absolute; top:10px; left:20px; height:27px; width:27px; padding:3px;" class="btn btn-icon-only blue"  href="#">
									<i class="fa fa-question"></i></a></span></div>';
						
					}
					else if((strpos(strtolower($item['type']),'link')!==false)&&$arr_data[$x][strtolower($item['field'])]!=''){
						$start = strpos(strtolower($item['type']),'(') +1;
						$end = strpos(strtolower($item['type']),')');
						$str = ($start!==false && $end!==false) ? substr($item['type'],$start,  $end - $start) : 'Link';
						if(strpos($arr_data[$x][strtolower($item['field'])], 'http')===false && strpos($arr_data[$x][strtolower($item['field'])], 'https')===false)
						$records["data"][$key][] = '<div'.$align.'><a class="btn btn-icon-only green" href="http://'.$arr_data[$x][strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';							
						
						else {
							
							$records["data"][$key][] = '<div'.$align.'><a class="btn btn-icon-only green" href="'.$arr_data[$x][strtolower($item['field'])].'" target="_blank">
									<i class="fa fa-globe"></i> '.trim($str).' </a></div>';
							
						}
					}
					else{
						$records["data"][$key][] = '<div'.$align.'>'.$arr_data[$x][strtolower($item['field'])] .'</div>';
					}
					
	
				}
				
                if(isset($keyARR['keys'])&&$keyARR['keys'] != ''){
                    $keys = array();
				
    				foreach($ke as $val){
    				   $keys[] = "'".$arr_data[$x][strtolower($val)]."' ";
    			   
    				}
    				//print_r($keys);
    				$k = implode(',',$keys);
                    
    				
                    if($keyARR['user_level']>$this->session->userdata('user_level')){
    					$records["data"][$key][] .='';
						
						 /*  $records["data"][$key][] .= '<center><div class="align-center">'
											.'<a class="btn btn-icon-only green show-modal" type-modal="update" keys_value="'.$k.'" table_name="'.$table.'"  data-target="#modal" data-toggle="modal">
											<i class="fa fa-edit"></i></a>'
											.'<a class="btn btn-icon-only red deleteField" keys_value="'.$k.'" table_name="'.$table.'" href="#">
											<i class="fa fa-trash-o"></i></a>'
											.'</div></center>';*/
    				}else{
						$xq='';
						if(!empty($arrPost)) $xq = "/?";	
				     $records["data"][$key][] .= '<center><div class="align-center">'
											.'<a href="'.base_url().'ajax/update_modal_vnxindex/'.str_replace(" ","",str_replace("'","",$k)).$xq.$arrPost.'" class="btn btn-icon-only green show-modal" type-modal="update" keys_value="'.$k.'" table_name="'.$table.'">
											<i class="fa fa-edit"></i></a>'
											
											.'<a class="btn btn-icon-only red deleteField" keys_value="'.$k.'" table_name="'.$table.'" href="#">
											<i class="fa fa-trash-o"></i></a>'
											.'</div></center>';
    				}
                }else
                {
                    $records["data"][$key][] .= '';
                }
			}
			$key ++;
		
		}
		
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iFilteredTotal;
          
        $this->output->set_output(json_encode($records));
    }
    function show_modal() {
        
        $table_name = isset($_REQUEST['table_name']) ? $_REQUEST['table_name']: '';		
        $table = $this->table->get_tab($table_name);
	
        $keys = isset($_POST['keys_value']) ? strtolower(TRIM($_POST['keys_value'])) : "";
        $headers = $this->table->tab_type($table['tab']);
       //print_r($headers);exit;
	    $sqlkey = "SELECT `keys`,`article` FROM int_summary WHERE table_name = '{$table['table_name']}'";
        $keyARR = $this->db->query($sqlkey)->row_array();
        $where = '1 = 1';
        if($keys != ''){
            $eql = explode(' ,',$keys);
            foreach($eql as $vl){ 
                $eq[] = TRIM($vl);
            }
           // print_r($eq);
            $arr = explode(',',$keyARR['keys']);
    		$aa = array();
            foreach($arr as $v){ 
                $aa[] = TRIM(strtolower($v));
            }
            $wh = array_combine($aa,$eq);  
            foreach($wh as $key=>$value){  
            $where .= " and `$key` = {$value}";
            }
        }
        $sql = "Select * FROM {$table['tab']} WHERE {$where} ;";
        $data = isset($key) ? $this->db->query($sql)->row_array() : "";
		//type in sys_format
		$sqlType = "SELECT `type`,`field` FROM sys_format WHERE `table` = '{$table['tab']}'";
        $typeArr = $this->db->query($sqlType)->result_array();
		$strTypeArr= array();
		foreach ($typeArr as $item=> $value) {
			$strTypeArr[$value['field']] = $value['type'];
		}
      
        foreach ($headers as $key => $value) {
            $readonly = '0';
            $primary = '0';
            if($keys != ''){
				$readonly = isset($data[$value['Field']]) && in_array(strtolower($value['Field']), $aa ) ? '1' : '0' ;
				$primary = in_array(strtolower($value['Field']), $aa ) ? '1' : '0' ;
				$value_field = isset($data[$value['Field']]) ? $data[$value['Field']] : '';					
			}
			else if($keyARR['article']==1 && $value['Field']=='lang_code'){
				$value_field = 'en';		
			}
			else if ($value['Field']=='date_added') {
				$value_field = date('Y-m-d H:i:s');
			} 
			else if(strtolower($value['Field'])=='id'){
				$readonly = '1' ;
				$primary =  '1' ;
				$value_field = isset($data[$value['Field']]) ? $data[$value['Field']] : '';	
			}
			else {
				$value_field ='';
			}
			
			if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'list') !== FALSE)){
				$start = strpos(strtolower($strTypeArr[$value['Field']]),'(') +1;
				$end = strpos(strtolower($strTypeArr[$value['Field']]),')');
				$str = ($start!==false && $end!==false) ? substr($strTypeArr[$value['Field']],$start,  $end - $start) : '';
				if(trim($str)!=''){
					$headers[$key]['filter'] = $this->table->append_list_editon(strtolower($value['Field']),$str,$value_field , $readonly, $primary);
				}
				else{
					$headers[$key]['filter'] = $this->table->append_select_editon(strtolower($value['Field']),$table['tab'],$value_field, $readonly, $primary);
				}

			}
			else if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'image') !== FALSE)){
				$headers[$key]['filter'] = '<div class="col-md-9">';
				$headers[$key]['filter'] .= $this->table->append_image_editon($value_field,strtolower($value['Field']));
				$headers[$key]['filter'] .= '</div>';

			}
			else if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'html') !== FALSE)){
				$headers[$key]['filter'] = '<div class="col-md-9">';
				$headers[$key]['filter'] .= $this->table->append_html_editon(strtolower($value['Field']),$value_field);
				$headers[$key]['filter'] .= '</div>';

			}
			else if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'file') !== FALSE)){
				$headers[$key]['filter'] = '<div class="col-md-9">';
				$headers[$key]['filter'] .= $this->table->append_file_editon($value_field,strtolower($value['Field']));
				$headers[$key]['filter'] .= '</div>';

			}
			
			else {
				$headers[$key]['filter'] = '<div class="col-md-9">';
				if(($value['Field']=='date_update')){
					$headers[$key]['filter'] .= $this->table->append_date_editon(strtolower($value['Field']),  date('Y-m-d H:i:s'), '1');
				}else if(strtolower($value['Field'])=='password'){
					$headers[$key]['filter'] .= $this->table->append_input_editon(strtolower($value['Field']),$value_field, $readonly, $primary, 'password');
				}
				else if ((strpos(strtolower($value['Type']), 'text') !== FALSE)|| (strpos(strtolower($value['Type']), 'longtext') !== FALSE)){
					$headers[$key]['filter'] .= $this->table->append_textarea_editon(strtolower($value['Field']),$value_field);
				}				
				else if((strpos(strtolower($value['Type']), 'varchar') !== FALSE) || (strpos(strtolower($value['Type']), 'int') !== FALSE)||(strpos(strtolower($value['Type']), 'double') !== FALSE)||(strpos(strtolower($value['Type']), 'interger') !== FALSE) ){
					$headers[$key]['filter'] .= $this->table->append_input_editon(strtolower($value['Field']),$value_field, $readonly,$primary);
				}
				else if((strpos(strtolower($value['Type']), 'date') !== FALSE)){
					/*$headers[$key]['filter'] .= $this->table->append_date_editon(strtolower($value['Field']), $value_field, $readonly,$primary);*/
					$headers[$key]['filter'] .= $this->table->append_date_editon(strtolower($value['Field']),  date('Y-m-d H:i:s'), '1');
				}
				else{
					$headers[$key]['filter'] .= $this->table->append_input_editon(strtolower($value['Field']),$value_field, $readonly, $primary);
				}
				$headers[$key]['filter'] .= '</div>';
			}
			
        }
        $this->data->headers = $headers;
        $this->data->name_table = $table['table_name'];
        $this->data->name_desc = $table['description'];
		$this->data->keys = $keys;
       
        $this->load->view('table/modal', $this->data);
    }


	 function show_modal_vnxindex() {
		 
        $table_name = isset($_REQUEST['table_name']) ? $_REQUEST['table_name']: '';		
        $table = $this->table->get_tab($table_name);
	
        $keys = isset($_POST['keys_value']) ? strtolower(TRIM($_POST['keys_value'])) : "";
        $headers = $this->table->tab_type($table['tab']);
       //print_r($headers);exit;
	    $sqlkey = "SELECT `keys`,`article` FROM int_summary WHERE table_name = '{$table['table_name']}'";
        $keyARR = $this->db->query($sqlkey)->row_array();
        $where = '1 = 1';
        if($keys != ''){
            $eql = explode(' ,',$keys);
            foreach($eql as $vl){ 
                $eq[] = TRIM($vl);
            }
           // print_r($eq);
            $arr = explode(',',$keyARR['keys']);
    		$aa = array();
            foreach($arr as $v){ 
                $aa[] = TRIM(strtolower($v));
            }
            $wh = array_combine($aa,$eq);  
            foreach($wh as $key=>$value){  
            $where .= " and `$key` = {$value}";
            }
        }
        $sql = "Select * FROM {$table['tab']} WHERE {$where} ;";
        $data = isset($key) ? $this->db->query($sql)->row_array() : "";
		//type in sys_format
		$sqlType = "SELECT `type`,`field` FROM sys_format WHERE `table` = '{$table['tab']}'";
        $typeArr = $this->db->query($sqlType)->result_array();
		$strTypeArr= array();
		foreach ($typeArr as $item=> $value) {
			$strTypeArr[$value['field']] = $value['type'];
		}
       // print_R($headers);exit;
        foreach ($headers as $key => $value) {
            $readonly = '0';
            $primary = '0';
            if($keys != ''){
				$readonly = isset($data[$value['Field']]) && in_array(strtolower($value['Field']), $aa ) ? '1' : '0' ;
				$primary = in_array(strtolower($value['Field']), $aa ) ? '1' : '0' ;
				$value_field = isset($data[$value['Field']]) ? $data[$value['Field']] : '';					
			}
			else if($keyARR['article']==1 && $value['Field']=='lang_code'){
				$value_field = 'en';		
			}
			else if ($value['Field']=='date_added') {
				$value_field = date('Y-m-d H:i:s');
			} 
			else if(strtolower($value['Field'])=='id'){
				$readonly = '1' ;
				$primary =  '1' ;
				$value_field = isset($data[$value['Field']]) ? $data[$value['Field']] : '';	
			}
			else {
				$value_field ='';
			}
			
			if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'list') !== FALSE)){
				$start = strpos(strtolower($strTypeArr[$value['Field']]),'(') +1;
				$end = strpos(strtolower($strTypeArr[$value['Field']]),')');
				$str = ($start!==false && $end!==false) ? substr($strTypeArr[$value['Field']],$start,  $end - $start) : '';
				if(trim($str)!=''){
					$headers[$key]['filter'] = $this->table->append_list_editon(strtolower($value['Field']),$str,$value_field , $readonly, $primary);
				}
				else{
					$headers[$key]['filter'] = $this->table->append_select_editon(strtolower($value['Field']),$table['tab'],$value_field, $readonly, $primary);
				}

			}
			else if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'image') !== FALSE)){
				$headers[$key]['filter'] = '<div class="col-md-9">';
				$headers[$key]['filter'] .= $this->table->append_image_editon($value_field,strtolower($value['Field']));
				$headers[$key]['filter'] .= '</div>';

			}
			else if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'html') !== FALSE)){
				$headers[$key]['filter'] = '<div class="col-md-9">';
				$headers[$key]['filter'] .= $this->table->append_html_editon(strtolower($value['Field']),$value_field);
				$headers[$key]['filter'] .= '</div>';

			}
			else if (isset($strTypeArr[$value['Field']]) && (strpos(strtolower($strTypeArr[$value['Field']]), 'file') !== FALSE)){
				$headers[$key]['filter'] = '<div class="col-md-9">';
				$headers[$key]['filter'] .= $this->table->append_file_editon($value_field,strtolower($value['Field']));
				$headers[$key]['filter'] .= '</div>';

			}
			
			else {
				$headers[$key]['filter'] = '<div class="col-md-9">';
				if(($value['Field']=='date_update')){
					$headers[$key]['filter'] .= $this->table->append_date_editon(strtolower($value['Field']),  date('Y-m-d H:i:s'), '1');
				}else if(strtolower($value['Field'])=='password'){
					$headers[$key]['filter'] .= $this->table->append_input_editon(strtolower($value['Field']),$value_field, $readonly, $primary, 'password');
				}
				else if ((strpos(strtolower($value['Type']), 'text') !== FALSE)|| (strpos(strtolower($value['Type']), 'longtext') !== FALSE)){
					$headers[$key]['filter'] .= $this->table->append_textarea_editon(strtolower($value['Field']),$value_field);
				}				
				else if((strpos(strtolower($value['Type']), 'varchar') !== FALSE) || (strpos(strtolower($value['Type']), 'int') !== FALSE)||(strpos(strtolower($value['Type']), 'double') !== FALSE)||(strpos(strtolower($value['Type']), 'interger') !== FALSE) ){
					$headers[$key]['filter'] .= $this->table->append_input_editon(strtolower($value['Field']),$value_field, $readonly,$primary);
				}
				else if((strpos(strtolower($value['Type']), 'date') !== FALSE)){
					$headers[$key]['filter'] .= $this->table->append_date_editon(strtolower($value['Field']), $value_field, $readonly,$primary);
				}
				else{
					$headers[$key]['filter'] .= $this->table->append_input_editon(strtolower($value['Field']),$value_field, $readonly, $primary);
				}
				$headers[$key]['filter'] .= '</div>';
			}
			
        }
        $this->data->headers = $headers;
        $this->data->name_table = $table['table_name'];
        $this->data->name_desc = $table['description'];
		$this->data->keys = $keys;
        $this->load->view('vnxindex/modal', $this->data);
    }    
    function update_modal() {
		ini_set('post_max_size', '200M');
		ini_set('upload_max_filesize', '200M');
		$table = $_POST['table_name_parent'];
        $keys = TRIM($_POST['keys_value']);
		$arr_table_sys = $this->table->get_summary($table);
		$table_name = isset($arr_table_sys["tab"]) ? $arr_table_sys["tab"] : 'int_'.$table;
        $headers = $this->table->tab_type($table_name);
		$sqlkey = "SELECT `keys` FROM int_summary WHERE table_name = '{$table}'";
		$keyARR = $this->db->query($sqlkey)->row_array();
		$eq = array();
		$respone['error'] = '';
        $respone['success'] = '';
		$respone['status'] = '';
		$allowext = array("jpg","png","jpeg");
		if($keys==''){			
			$column ='';
			$value_column='';
			foreach ($headers as $item) {
				if(isset($_FILES[$item['Field']])){
					if ($_FILES[$item['Field']]["error"] > 0) {
							$respone['error'] = $_FILES[$item['Field']]["error"];
						} else {
							$path ='assets/upload/intranet';
							
							if(isset($_POST['group']) && trim($_POST['group'])!='') $path .='/'.strtolower($_POST['group']);
							if(isset($_POST['owner']) && trim($_POST['owner'])!='') $path .='/'.strtolower($_POST['owner']);
							if(isset($_POST['category']) && trim($_POST['category'])!='') $path .='/'.strtolower($_POST['category']);
							if(isset($_POST['subcat']) && trim($_POST['subcat'])!='') $path .='/'.strtolower($_POST['subcat']);
							if (!file_exists($path)) {
								mkdir($path, 0777, true);
							}
							
							if(move_uploaded_file($_FILES[$item['Field']]["tmp_name"], $path.'/'.basename($_FILES[$item['Field']]["name"]))) {
								$ext = substr($_FILES[$item['Field']]["name"], strrpos($_FILES[$item['Field']]["name"], '.') + 1);
								if(in_array($ext, $allowext)) {
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),65);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),145);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),175);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),255);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),450);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),600);
								}
								$column .= $column==''? "`{$item['Field']}`" : " , `{$item['Field']}`";
								$value_column .=$value_column==''? "'".$path.'/'.$_FILES[$item['Field']]["name"]."'" : " , '".$path.'/'.$_FILES[$item['Field']]["name"]."'";
							} else {
								$respone['error'] = "Can not upload file";
							}
						}
				}
				else if($item['Field']=='password'){
                        $salt_2 = substr(md5(uniqid(rand(), true)), 0, 10);
    					$new_password_db = $salt_2 . substr(sha1($salt_2 . $_POST[$item['Field']]), 0, -10);
    					$count = strlen($_POST[$item['Field']]);
    				//	$data = array(
//    						'count_pass'=>$count,
//    						'password' => $new_password_db,
//    						'remember_code' => NULL,
//    					);
    					// Count number password
    					
    				//	$this->db->where('id', $this->session->userdata('user_id'))
//    						->update('user', $data);
		               $column .= $column==''? "`{$item['Field']}`" : " , `{$item['Field']}`";
					   $value_column .=$value_column==''? "'".real_escape_string($new_password_db)."'" : " , '".real_escape_string($new_password_db)."'";
                }
				else if(isset($_POST[$item['Field']])){
					$column .= $column==''? "`{$item['Field']}`" : " , `{$item['Field']}`";
					$value_column .=$value_column==''? "'".real_escape_string($_POST[$item['Field']])."'" : " , '".real_escape_string($_POST[$item['Field']])."'";
				}
			} 
			$sql = "INSERT  INTO {$table_name} ($column) VALUES ({$value_column});";
			//echo "<pre>"; print_r($sql);exit;
			$respone['status']  = $this->db->query($sql);
		}
		else{
			$eql = explode(' ,',$keys);
			foreach($eql as $vl){ 
				$eq[] = TRIM($vl);
			}
			$arr = explode(',',$keyARR['keys']);
			foreach($arr as $v){ 
				$aa[] = TRIM($v);
			}
			$wh = array_combine($aa,$eq);  
			
			$where = '1 = 1';
			foreach($wh as $key=>$value){  
				$where .= " and `$key` = {$value}";
			}
			$update = '';
			foreach ($headers as $item) {
				if(isset($_FILES[$item['Field']])){
					if ($_FILES[$item['Field']]["error"] > 0) {
							$respone['error'] = $_FILES[$item['Field']]["error"];
						} else {
							$path ='assets/upload/intranet';
							if(isset($_POST['group']) && trim($_POST['group'])!='') $path .='/'.strtolower($_POST['group']);
							if(isset($_POST['owner']) && trim($_POST['owner'])!='') $path .='/'.strtolower($_POST['owner']);
							if(isset($_POST['category']) && trim($_POST['category'])!='') $path .='/'.strtolower($_POST['category']);
							if(isset($_POST['subcat']) && trim($_POST['subcat'])!='') $path .='/'.strtolower($_POST['subcat']);
							if (!file_exists($path)) {
								mkdir($path, 0777, true);
							}
							if(move_uploaded_file($_FILES[$item['Field']]["tmp_name"], $path.'/'.basename($_FILES[$item['Field']]["name"]))) {
								$ext = substr($_FILES[$item['Field']]["name"], strrpos($_FILES[$item['Field']]["name"], '.') + 1);
								if(in_array($ext, $allowext)) {
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),65);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),145);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),175);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),255);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),450);
									image_thumb_w($path.'/'.basename($_FILES[$item['Field']]["name"]),600);
								}
								
								$update .= $update==''? "`{$item['Field']}` = '".$path.'/'.$_FILES[$item['Field']]["name"]."'" : " , `{$item['Field']}` = '".$path.'/'.$_FILES[$item['Field']]["name"]."'";
							} else {
								$respone['error'] = "Can not upload file";
							}
						}
				}
				else if(isset($_POST[$item['Field']]))
				$update .= $update==''? "`{$item['Field']}` = '".real_escape_string($_POST[$item['Field']])."'" : " , `{$item['Field']}` = '".real_escape_string($_POST[$item['Field']])."'";
				if($item['Field']=='password'){
                        $salt_2 = substr(md5(uniqid(rand(), true)), 0, 10);
    					$new_password_db = $salt_2 . substr(sha1($salt_2 . $_POST[$item['Field']]), 0, -10);
    					$count = strlen($_POST[$item['Field']]);
		                $update .= $update==''? "`{$item['Field']}` = '".real_escape_string($new_password_db)."'" : " , `{$item['Field']}` = '".real_escape_string($new_password_db)."'";
                    }
				//else if ()
			}  			
        	$sql = "UPDATE {$table_name} SET {$update} WHERE {$where} ;";
			//echo "<pre>"; print_r($sql);exit;
			$respone['status']  = $this->db->query($sql);
		}    
        $this->output->set_output(json_encode($respone));
    }
	
	
	function delete_row() {   
        $table = $_POST['table_name'];
        $keys = TRIM($_POST['keys_value']);		
        $arr_table_sys = $this->table->get_summary($table);
		$table_name = isset($arr_table_sys["tab"]) ? $arr_table_sys["tab"] : 'int_'.$table;
        $headers = $this->table->tab_type($table_name);
		$sqlkey = "SELECT `keys` FROM int_summary WHERE table_name = '{$table}'";
		$keyARR = $this->db->query($sqlkey)->row_array();
		$eql = explode(' ,',$keys);
		foreach($eql as $vl){ 
			$eq[] = TRIM($vl);
		}
		$arr = explode(',',$keyARR['keys']);
		foreach($arr as $v){ 
			$aa[] = TRIM($v);
		}
		$wh = array_combine($aa,$eq);  
		
		$where = '1 = 1';
		foreach($wh as $key=>$value){  
			$where .= " and `$key` = {$value}";
		}
        //$respone ='false';
		$sql = "DELETE FROM {$table_name} WHERE {$where}";
        
        $respone = $this->db->query($sql);        
        $this->output->set_output(json_encode($respone));
    }
	function insert_row() {   
        $table = $_POST['table_name'];
        $keys = TRIM($_POST['keys_value']);		
        $arr_table_sys = $this->table->get_summary($table);
		$table_name = isset($arr_table_sys["tab"]) ? $arr_table_sys["tab"] : 'int_'.$table;
        $headers = $this->table->tab_type($table_name);
		$sqlkey = "SELECT `keys` FROM int_summary WHERE table_name = '{$table}'";
		$keyARR = $this->db->query($sqlkey)->row_array();
		$eql = explode(' ,',$keys);
		foreach($eql as $vl){ 
			$eq[] = TRIM($vl);
		}
		$arr = explode(',',$keyARR['keys']);
		foreach($arr as $v){ 
			$aa[] = TRIM($v);
		}
		$wh = array_combine($aa,$eq);  
		
		$where = '1 = 1';
		$arr_tempt = array();
		foreach($wh as $key=>$value){  
			$where .= " and `$key` = {$value}";
			$arr_tempt[$key]=Null;
			
		}
		$sql = "SELECT * FROM {$table_name} WHERE {$where}";
		$valueARR = $this->db->query($sql)->row_array();
		
		$this->db->insert($table_name, $arr_tempt);
        $id = $this->db->insert_id();
		$value_insert ='';
		$i = 0;
		foreach($wh as $key=>$value){  
		$value_insert .= $i==0 ? "{$key}={$id}" : ",{$key}={$id}";
			$i ++;
		}
		$query = "UPDATE {$table_name} SET ";
		  foreach ($valueARR as $key => $value) {
			if (!in_array($key, $keyARR)){
				$query .= '`'.$key.'` = "'.str_replace('"','\"',$value).'", ';
			}
		  }
		  $query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
		  $query .= " WHERE {$value_insert}";
		  $respone = $this->db->query($query);  
	
		/*$sql = "INSERT  INTO {$table_name} ($column) VALUES ({$value_column});";
		$respone = $this->db->query($sql);  
        //$respone ='false';
		$sql = "DELETE FROM {$table_name} WHERE {$where}";
        
        $respone = $this->db->query($sql);        */
        $this->output->set_output(json_encode($respone));
    }
	
	function delete_row_vnxindex() {   
        $keys = TRIM($_POST['keys_value']);		
        //$respone ='false';
		$sql = "DELETE FROM ifrc_articles WHERE id = $keys";
        $respone = $this->db->query($sql);        
        $this->output->set_output(json_encode($respone));
    }
    
    function checkupdate(){
        $this->db->from('user_log');
//        $this->db->where('user_log.user_id =', $this->session->userdata('user_id'));
        $query = $this->db->get();
        $data = $query->result_array();
        foreach($data as $row) {
          if($row['user_id'] == $this->session->userdata('user_id')){
                $sql = "UPDATE user_log
            			SET `status`=1,
                         lastactive=NOW()   
            			WHERE user_id='".$row['user_id']."' LIMIT 1";
                $this->db->query($sql);
          }else{
        //print_R(date('Y-m-d H:i:s',strtotime("+30 minutes", strtotime($row['lastactive']))));
              if(date('Y-m-d H:i:s',strtotime("+30 minutes", strtotime($row['lastactive']))) < date('Y-m-d H:i:s',strtotime("now"))) { // if lastActivity plus five minutes was longer ago then now
                $sql = "UPDATE user_log
            			SET `status`=0  
            			WHERE user_id='".$row['user_id']."'";
                $this->db->query($sql);
                // Green light
              }else {
                $sql = "UPDATE user_log
            			SET `status`=1 
            			WHERE user_id='".$row['user_id']."'";
                $this->db->query($sql);
              }
          }
        }
        $this->db->from('user_log');
        $this->db->join('user', 'user_log.user_id = user.id');
        $this->db->where('user_log.user_id !=', $this->session->userdata('user_id'));
        $query = $this->db->get();
        $data = $query->result_array();
        $html = $this->setListUser($data);
        $this->output->set_output(json_encode($html));
    }
    function setListUser($data){
        $html='';
        foreach($data as $value){
             $html.='<li class="media">';
			 $html.='<div class="media-status">';
			 $html.='<span class="badge badge-'.($value['status'] == 1 ? "success" : "danger").'">'.($value['status'] == 1 ? "online" : "offline").'</span>';
			 $html.='</div>';
			 $html.='<img class="media-object" height="45px" src="'.base_url().$value['avatar'].'" alt="..."/>';
			 $html.='<div class="media-body">';
			 $html.='<h4 class="media-heading">'.$value['last_name'].' '.$value['first_name'].'</h4>';
			 $html.='<div class="media-heading-sub">';
			 $html.=$value['services']; 
			 $html.='</div>';
			 $html.='</div>';
			 $html.='</li>';
        }
        return $html;
    }
      //log the user out
    function logout() {
        $sql = "UPDATE user_log
    			SET `status`=0  
    			WHERE user_id='".$this->session->userdata('user_id')."'";
        $this->db->query($sql);
        $this->ion_auth->logout();
		if (isset($_SESSION['simulation']['username'])) :
			session_unset();
			session_destroy();
		endif;
        echo (true);
    }
    
 

	
	public function add_intranet_article($param) {
		
		$this->load->model('Vnxindex_model','vnxindexmodel');
		//image
		$id = $this->vnxindexmodel->getArticleFinal_intranet();
		$clean_artid = $this->vnxindexmodel->getCleanartidFinal_intranet();
		
		//echo $id."-".$clean_artid;exit;
		 //add article_clean
		$arr_lang = array($id=>"en",$id+1=>"vn",$id+2=>"fr");
		//echo "<pre>";print_r($param);exit;
	$param['date_update'] = date("Y-m-d H:i:s");
	 $data_article_clean = array(
		  // 'category_id' => $param['category_id'],
		   'status' => $param['status'],
		   'sort_order' => $param['sort_order'],
		   'image' => $this->var_image,
		    'file' => $this->var_files,
		   'url' => $param['url'],
		   //'url_second' => $param['url_second'],
		   //'url_third' => $param['url_third'],
		   'website' => $param['website'],
		   //'par_cat_id' => $param['par_cat_id'],
			'clean_cat' => $param['clean_cat'],
			'clean_scat' => $param['clean_scat'],
		   //'date_creation' => date("Y-m-d H:m:s",now()),
		    'date_creation' => $param['date_add'],
			'date_update' => $param['date_update'],
			'name_user'	=> $this->session->userdata('username'),
		   
	  );
	  /*if(isset($_POST['get_filter'])){
			$count_arr = 11;  
	  }
	  else{
		$count_arr = 10;  		
	  }*/
	 // $cut_array = array_slice($param,-10,9);
	   $cut_array = $param;
	  foreach($cut_array as $k=>$va){
			if(substr($k,0,-3) != 'title' && substr($k,0,-3) != 'description' && substr($k,0,-3) != 'long_description'){
				unset($cut_array[$k]); 
			}
				
		}
		
		for($i=0;$i<3; $i++){
			  $a = $i*3;
			 $b = array_keys(array_slice($cut_array,$a,1));
			 $cut_array_lang[$b[0]][] = array_slice($cut_array,$a,3); 
		}
		
		foreach($arr_lang as $key=>$lang_val){
			$this->vnxindexmodel->add_ifrc_articles_intranet($data_article_clean,$key,$clean_artid,$lang_val,$cut_array_lang['title_'.$lang_val]);	
		}
		
			
			// add_article_desc_clean
			
			
			//$this->vnxindexmodel->addArticleDescClean($cut_array_lang,$param,$id); 
	}
	
	
	function add_vnxindex_article($param) {
		
		$this->load->model('Vnxindex_model','vnxindexmodel');
		//image
		$id = $this->vnxindexmodel->getArticleFinal();
		$clean_artid = $this->vnxindexmodel->getCleanartidFinal();
		
		//echo $id."-".$clean_artid;exit;
		 //add article_clean
		$arr_lang = array($id=>"en",$id+1=>"vn",$id+2=>"fr");
		//
	$param['date_update'] = date("Y-m-d H:i:s");
	 $data_article_clean = array(
		  // 'category_id' => $param['category_id'],
		   'status' => $param['status'],
		   'sort_order' => $param['sort_order'],
		   'image' => $this->var_image,
		   'file' => $this->var_files,
		   'url' => $param['url'],
		   //'url_second' => $param['url_second'],
		   //'url_third' => $param['url_third'],
		   'website' => $param['website'],
		   //'par_cat_id' => $param['par_cat_id'],
			'clean_cat' => $param['clean_cat'],
			'clean_scat' => $param['clean_scat'],
		   //'date_creation' => date("Y-m-d H:m:s",now()),
		    'date_creation' => $param['date_add'],
			'date_update' => $param['date_update'],
			'name_user'	=> $this->session->userdata('username'),
		   
	  );
	  
	 /* if(isset($_POST['get_filter'])){
			$count_arr = 10;  
	  }
	  else{
		$count_arr = 9;  		
	  }*/
	  //$cut_array = array_slice($param,-10,9);
	  $cut_array = $param;
	  foreach($cut_array as $k=>$va){
			if(substr($k,0,-3) != 'title' && substr($k,0,-3) != 'description' && substr($k,0,-3) != 'long_description'){
				unset($cut_array[$k]); 
			}
				
		}
		//echo "<pre>";print_r($cut_array);exit;
		for($i=0;$i<3; $i++){
			  $a = $i*3;
			 $b = array_keys(array_slice($cut_array,$a,1));
			 $cut_array_lang[$b[0]][] = array_slice($cut_array,$a,3); 
		}
		
		foreach($arr_lang as $key=>$lang_val){
			$this->vnxindexmodel->add_ifrc_articles($data_article_clean,$key,$clean_artid,$lang_val,$cut_array_lang['title_'.$lang_val]);	
		}
		
			
			// add_article_desc_clean
			
			
			//$this->vnxindexmodel->addArticleDescClean($cut_array_lang,$param,$id); 
	}
	
	
	
	// DUNG CHO IFRC_ARTICLE
	 public function add_modal_vnxindex() {
		 //xu ly filter
		 if(isset($_POST['dataArr'])){
			 
			 $this->session->set_userdata('clean_artid',$_POST['dataArr'][0]);
			 $this->session->set_userdata('lang_code',$_POST['dataArr'][1]);
			 $this->session->set_userdata('clean_cat',$_POST['dataArr'][2]);
			 $this->session->set_userdata('clean_scat',$_POST['dataArr'][3]);
			 $this->session->set_userdata('title',$_POST['dataArr'][4]);
			 $this->session->set_userdata('website',$_POST['dataArr'][5]);
			 $this->session->set_userdata('clean_order',$_POST['dataArr'][6]);
			 $this->session->set_userdata('status',$_POST['dataArr'][7]);
			 $this->session->set_userdata('html_description',$_POST['dataArr'][8]);
			 $this->session->set_userdata('html_long_description',$_POST['dataArr'][9]);
			 $this->session->set_userdata('date_creation_start',$_POST['dataArr'][10]);
			 $this->session->set_userdata('date_creation_end',$_POST['dataArr'][11]);
		 }
		//end xu ly filter
		 $this->load->model('Vnxindex_model','modelvnxindex');
		
		   //form validate
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title_en', 'Title English', 'required');
			$this->form_validation->set_rules('title_fr', 'Title France', 'required');
			$this->form_validation->set_rules('title_vn', 'Title VN', 'required');
			
			 $list_website = $this->modelvnxindex->list_website();
			
			 $this->data->list_website = isset($list_website) ? $list_website : array();
			 
			 $list_cat = $this->modelvnxindex->list_cat();
		
			$this->data->list_cat = isset($list_cat) ? $list_cat : array();
			
			 $list_scat = $this->modelvnxindex->list_scat();
			
			$this->data->list_scat = isset($list_scat) ? $list_scat : array();
			
			$this->data->int_article_websites = $this->modelvnxindex->get_int_article_website();
			//echo "<pre>";print_r($this->data->int_article_websites);exit;
			// Dung cho khi add xong trở về list vẫn giữ filter
			$str_filter = '';
			
			foreach($_GET as $k=>$v){
				if($v != ''){
					$str_filter .= $k."=".$v."&";
				}
			}
			$this->data->get_filter = $str_filter;
		 	if ($this->form_validation->run() == FALSE)
			{
				
				
				 $this->template->write_view('content', 'vnxindex/add',$this->data);
				 $this->template->render();
			
			}else{
			
			  if (isset($_POST['ok'])) {
				
				//call function insert data 
					  if($_FILES['image']['name'] != NULL){ // Đã chọn file
					// Tiến hành code upload file
					if($_FILES['image']['type'] == "image/jpeg" ||$_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/gif"){
					// là file ảnh
					// Tiến hành code upload    
						if($_FILES['image']['size'] > 1048576){
							echo "File not larger 1mb";
						}else{
							$uploaddir = 'assets/upload/images/';
							$uploadfile = $uploaddir . $_FILES['image']['name'];
							if (!file_exists($uploaddir)) {
								mkdir($uploaddir, 0777, true);
							}
							$tmp_name = $_FILES['image']['tmp_name'];
							
							// Upload file
							if(move_uploaded_file($tmp_name, $uploadfile)) {
								$this->var_image = $uploadfile;
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),65);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),145);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),175);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),255);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),450);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),600);
							} else {
								echo 'Upload directory is not writable, or does not exist.';
							}
							
						
					   }
					}
				  }
				  if($_FILES['files']['name'] != NULL){
							$uploaddir_files = 'assets/upload/images/';
							$uploadfile_files = $uploaddir_files . $_FILES['files']['name'];
							if (!file_exists($uploaddir_files)) {
								mkdir($uploaddir_files, 0777, true);
							}
							$tmp_name_file = $_FILES['files']['tmp_name'];
							
							// Upload file
							if(move_uploaded_file($tmp_name_file, $uploadfile_files)) {
								$this->var_files = $uploadfile_files;
							} else {
								echo 'Upload directory is not writable, or does not exist.';
							}	  
				  }
			  
				
				$this->add_vnxindex_article($_POST,$this->var_image,$this->var_files);
				
				redirect(base_url()."vnxindex/ifrc_articles");
			}
	
				
				//$this->data->info = $_POST['param'];
				 $this->template->write_view('content', 'vnxindex/add',$this->data);
				$this->template->render();
		}
    }
	
	
	public function add_modal_intranet() {
		 //xu ly filter
		 if(isset($_POST['dataArr'])){
			 
			 $this->session->set_userdata('clean_artid',$_POST['dataArr'][0]);
			 $this->session->set_userdata('lang_code',$_POST['dataArr'][1]);
			 $this->session->set_userdata('clean_cat',$_POST['dataArr'][2]);
			 $this->session->set_userdata('clean_scat',$_POST['dataArr'][3]);
			 $this->session->set_userdata('title',$_POST['dataArr'][4]);
			 $this->session->set_userdata('website',$_POST['dataArr'][5]);
			 $this->session->set_userdata('clean_order',$_POST['dataArr'][6]);
			 $this->session->set_userdata('status',$_POST['dataArr'][7]);
			 $this->session->set_userdata('html_description',$_POST['dataArr'][8]);
			 $this->session->set_userdata('html_long_description',$_POST['dataArr'][9]);
			 $this->session->set_userdata('date_creation_start',$_POST['dataArr'][10]);
			 $this->session->set_userdata('date_creation_end',$_POST['dataArr'][11]);
		 }
		//end xu ly filter
		 $this->load->model('Vnxindex_model','modelvnxindex');
		
		   //form validate
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title_en', 'Title English', 'required');
			$this->form_validation->set_rules('title_fr', 'Title France', 'required');
			$this->form_validation->set_rules('title_vn', 'Title VN', 'required');
			
			 $list_website = $this->modelvnxindex->list_website_intranet();
			
			 $this->data->list_website = isset($list_website) ? $list_website : array();
			 
			 $list_cat = $this->modelvnxindex->list_cat_intranet();
		
			$this->data->list_cat = isset($list_cat) ? $list_cat : array();
			
			 $list_scat = $this->modelvnxindex->list_scat_intranet();
			 
			 $this->data->int_article_websites = $this->modelvnxindex->get_int_article_website();
			
			$this->data->list_scat = isset($list_scat) ? $list_scat : array();
			// Dung cho khi add xong trở về list vẫn giữ filter
			$str_filter = '';
			
			foreach($_GET as $k=>$v){
				if($v != ''){
					$str_filter .= $k."=".$v."&";
				}
			}
			$this->data->get_filter = $str_filter;
		 	if ($this->form_validation->run() == FALSE)
			{
				
				
				 $this->template->write_view('content', 'table/add',$this->data);
				 $this->template->render();
			
			}else{
			
			  if (isset($_POST['ok'])) {
				  
				//call function insert data 
					  if($_FILES['image']['name'] != NULL){ // Đã chọn file
					// Tiến hành code upload file
					if($_FILES['image']['type'] == "image/jpeg" ||$_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/gif"){
					// là file ảnh
					// Tiến hành code upload    
						if($_FILES['image']['size'] > 1048576){
							echo "File not larger 1mb";
						}else{
							$uploaddir = 'assets/upload/images/';
							$uploadfile = $uploaddir . $_FILES['image']['name'];
							if (!file_exists($uploaddir)) {
								mkdir($uploaddir, 0777, true);
							}
							$tmp_name = $_FILES['image']['tmp_name'];
							
							// Upload file
							if(move_uploaded_file($tmp_name, $uploadfile)) {
								$this->var_image = $uploadfile;
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),65);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),145);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),175);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),255);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),450);
								image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),600);
							} else {
								echo 'Upload directory is not writable, or does not exist.';
							}
							
						
					   }
					}
				  }
				  
				   if($_FILES['files']['name'] != NULL){
							$uploaddir_files = 'assets/upload/images/';
							$uploadfile_files = $uploaddir_files . $_FILES['files']['name'];
							if (!file_exists($uploaddir_files)) {
								mkdir($uploaddir_files, 0777, true);
							}
							$tmp_name_file = $_FILES['files']['tmp_name'];
							
							// Upload file
							if(move_uploaded_file($tmp_name_file, $uploadfile_files)) {
								$this->var_files = $uploadfile_files;
							} else {
								echo 'Upload directory is not writable, or does not exist.';
							}	  
				  }
			  
				
				$this->add_intranet_article($_POST,$this->var_image,$this->var_files);
				
				redirect(base_url()."table/ifrc_articles");
			}
	
				
				//$this->data->info = $_POST['param'];
				 $this->template->write_view('content', 'table/add',$this->data);
				$this->template->render();
		}
    }
	
	public function update_modal_vnxindex() {
		 
		$image = '';
		$files = '';
		
		// Dung cho khi add xong trở về list vẫn giữ filter
		$str_filter = '';
		foreach($_GET as $k=>$v){
			if($v != ''){
				$str_filter .= $k."=".$v."&";
			}
		}
		$this->data->get_filter = $str_filter;
		
		  if (isset($_POST['ok'])) {
			  //image
				//print_r($_FILES);exit;
				$image = '';
			  if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != NULL){ // Đã chọn file
			
				// Tiến hành code upload file
				if($_FILES['image']['type'] == "image/jpeg" ||$_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/gif"){
				// là file ảnh
				// Tiến hành code upload    
					if($_FILES['image']['size'] > 1048576){
						echo "File not larger 1mb";
					}else{
						$uploaddir = 'assets/upload/images/';
						
						$uploadfile = $uploaddir . $_FILES['image']['name'];
						if (!file_exists($uploaddir)) {
							mkdir($uploaddir, 0777, true);
						}
						$tmp_name = $_FILES['image']['tmp_name'];
						
						// Upload file
						if(move_uploaded_file($tmp_name, $uploadfile)) {
							$image = $uploadfile;
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),65);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),145);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),175);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),255);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),450);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),600);
						} else {
							echo 'Upload directory is not writable, or does not exist.';
						}
						
					
				   }
				}
			  }
			   if(isset($_FILES['files']['name']) && $_FILES['files']['name'] != NULL){ // Đã chọn file
			  		 	$uploaddir_files = 'assets/upload/images/';
						
						$uploadfile_files = $uploaddir_files . $_FILES['files']['name'];
						if (!file_exists($uploaddir_files)) {
							mkdir($uploaddir_files, 0777, true);
						}
						$tmp_name_files = $_FILES['files']['tmp_name'];
						
						// Upload file
						if(move_uploaded_file($tmp_name_files, $uploadfile_files)) {
							$files = $uploadfile_files;
						} else {
							echo 'Upload directory is not writable, or does not exist.';
						}
			  
			   }
			 
            //call function insert data 
			 $this->data->id = $_POST["id"];
			
			
            $this->update_article_vnxindex($_POST,$image, $files);
			if($_POST['get_filter'] !=''){
				redirect(base_url().'vnxindex/ifrc_articles?'.$_POST['get_filter']);
			}else{
				redirect(base_url().'vnxindex/ifrc_articles');	
			}

            //$this->update_article_desc_clean($_POST);
			//redirect(base_url().'cleanarticle');

        }
		else{
			 $id =$this->uri->segment(3);
			 $this->data->hiden = $id;
		}
		 
 		$this->load->model('Vnxindex_model','modelvnxindex');		
        $categories = NULL;
       
        //get all category
       
        // data for dropdown list parent category
		
		 $list_website = $this->modelvnxindex->list_website();
		
		$this->data->list_website = isset($list_website) ? $list_website : array();
		
		 $list_cat = $this->modelvnxindex->list_cat();
		
		$this->data->list_cat = isset($list_cat) ? $list_cat : array();
		
		 $list_scat = $this->modelvnxindex->list_scat();
		
		$this->data->list_scat = isset($list_scat) ? $list_scat : array();
		
		$this->data->int_article_websites = $this->modelvnxindex->get_int_article_website();
	
		 $info = $this->modelvnxindex->show_article_clean_id($id);
		 $result =array();
		 if(count($info) > 0){
		 foreach($info as $val){
			 if($val['lang_code'] == 'en')
				$result['a'] = $val;
			 elseif($val['lang_code'] == 'vn')
				$result['b'] = $val;
			 else $result['c'] = $val;
		}
		
		ksort($result);
		 }
		
		
		
		  if ($result != FALSE) {
            $this->data->input = $result;
			
			//echo "<pre>";print_r($this->data->input);exit;
           
           // $this->data->input['thumb'] = $this->_thumb($result[0]['images']); 
            //  var_export($input['thumb'].'_______________');exit;
          
        }
		
		//$this->data->info = $_POST['param'];
		 $this->template->write_view('content', 'vnxindex/update', $this->data);
        $this->template->render();
     
    }
	
	
	
	public function update_modal_intranet() {
		 
		$image = '';
		$files = '';
		
		// Dung cho khi add xong trở về list vẫn giữ filter
		$str_filter = '';
		foreach($_GET as $k=>$v){
			if($v != ''){
				$str_filter .= $k."=".$v."&";
			}
		}
		$this->data->get_filter = $str_filter;
		
		  if (isset($_POST['ok'])) {
			  //image
				//print_r($_FILES);exit;
				$image = '';
			  if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != NULL){ // Đã chọn file
			
				// Tiến hành code upload file
				if($_FILES['image']['type'] == "image/jpeg" ||$_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/gif"){
				// là file ảnh
				// Tiến hành code upload    
					if($_FILES['image']['size'] > 1048576){
						echo "File not larger 1mb";
					}else{
						$uploaddir = 'assets/upload/images/';
						
						$uploadfile = $uploaddir . $_FILES['image']['name'];
						if (!file_exists($uploaddir)) {
							mkdir($uploaddir, 0777, true);
						}
						$tmp_name = $_FILES['image']['tmp_name'];
						
						// Upload file
						if(move_uploaded_file($tmp_name, $uploadfile)) {
							$image = $uploadfile;
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),65);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),145);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),175);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),255);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),450);
							image_thumb_w($uploaddir.'/'.basename($_FILES['image']['name']),600);
						} else {
							echo 'Upload directory is not writable, or does not exist.';
						}
						
					
				   }
				}
			  }
			  
			  if(isset($_FILES['files']['name']) && $_FILES['files']['name'] != NULL){ // Đã chọn file
			  		 	$uploaddir_files = 'assets/upload/images/';
						
						$uploadfile_files = $uploaddir_files . $_FILES['files']['name'];
						if (!file_exists($uploaddir_files)) {
							mkdir($uploaddir_files, 0777, true);
						}
						$tmp_name_files = $_FILES['files']['tmp_name'];
						
						// Upload file
						if(move_uploaded_file($tmp_name_files, $uploadfile_files)) {
							$files = $uploadfile_files;
						} else {
							echo 'Upload directory is not writable, or does not exist.';
						}
			  
			   }
			
            //call function insert data 
			 $this->data->id = $_POST["id"];
			
			
            $this->update_article_itnranet($_POST,$image, $files);
			if($_POST['get_filter'] !=''){
				redirect(base_url().'table/ifrc_articles?'.$_POST['get_filter']);
			}else{
				redirect(base_url().'table/ifrc_articles');	
			}

            //$this->update_article_desc_clean($_POST);
			//redirect(base_url().'cleanarticle');

        }
		else{
			 $id =$this->uri->segment(3);
			 $this->data->hiden = $id;
		}
		 
 		$this->load->model('Vnxindex_model','modelvnxindex');		
        $categories = NULL;
       
        //get all category
       
        // data for dropdown list parent category
		
		 $list_website = $this->modelvnxindex->list_website_intranet();
		
		$this->data->list_website = isset($list_website) ? $list_website : array();
		
		 $list_cat = $this->modelvnxindex->list_cat_intranet();
		
		$this->data->list_cat = isset($list_cat) ? $list_cat : array();
		
		 $list_scat = $this->modelvnxindex->list_scat_intranet();
		
		$this->data->list_scat = isset($list_scat) ? $list_scat : array();
		
		$this->data->int_article_websites = $this->modelvnxindex->get_int_article_website();
	
		 $info = $this->modelvnxindex->show_article_clean_id_intranet($id);
		 foreach($info as $val){
			 if($val['lang_code'] == 'en')
				$result['a'] = $val;
			 elseif($val['lang_code'] == 'vn')
				$result['b'] = $val;
			 else $result['c'] = $val;
		}
		ksort($result);
		
		
		
		  if ($result != FALSE) {
            $this->data->input = $result;
			
			
			
			//echo "<pre>";print_r($this->data->input);exit;
           
           // $this->data->input['thumb'] = $this->_thumb($result[0]['images']); 
            //  var_export($input['thumb'].'_______________');exit;
          
        }
		
		//$this->data->info = $_POST['param'];
		 $this->template->write_view('content', 'table/update', $this->data);
        $this->template->render();
     
    }
	
	function update_article_vnxindex($param, $image, $files) {
		//echo "<pre>";print_r($this->session->userdata('username'));exit;
		$this->load->model('Vnxindex_model','modelvnxindex');	
	 
			
		$param['date_update'] = date("Y-m-d H:i:s");
		 //add article_clean
		
		 $data_article_vnxindex = array(
			'status' => $param['status'],
            'clean_order' => $param['sort_order'],
            'url' => $param['url'],
			 'website' => $param['website'],
			 'clean_cat' => $param['clean_cat'],
			 'clean_scat' => $param['clean_scat'],
			 'date_creation' => $param['date_add'],
			'date_update' => $param['date_update'],
			'name_user'	=> $this->session->userdata('username'),
            );
			
			if($image != ''){
				$data_article_vnxindex['images']= $image;
			}
			if($files != ''){
				$data_article_vnxindex['file']= $files;
			}
			// add article_desc_clean
		$cut_array = $param;
	  foreach($cut_array as $k=>$va){
			if(substr($k,0,-3) != 'title' && substr($k,0,-3) != 'description' && substr($k,0,-3) != 'long_description'){
				unset($cut_array[$k]); 
			}
				
		}
			//echo "<pre>";print_r($param);exit;
		  $countlangbyid = $this->modelvnxindex->countLangById($param['id']);
		  $clean_artid = $this->modelvnxindex->getCleanArtidById($param['id']);
		  for($i=0;$i<$countlangbyid; $i++){
			  $a = $i*3;
			 $b = array_keys(array_slice ($cut_array,$a,1));
			
			  $cut_array_lang[$b[0]][] = array_slice ($cut_array,$a,3); 
			}
			foreach($cut_array_lang as $key => $val_lang){
					$lang = explode("_",$key);
					$this->modelvnxindex->updateArticleVnxindex($data_article_vnxindex, $val_lang[0], $clean_artid, $lang[1]);
			}
		  			
			
		 
	}
	
	
	function update_article_itnranet($param, $image, $files) {
		//echo "<pre>";print_r($this->session->userdata('username'));exit;
		$this->load->model('Vnxindex_model','modelvnxindex');	
	
		$param['date_update'] = date("Y-m-d H:i:s");
		 //add article_clean
		
		 $data_article_vnxindex = array(
			'status' => $param['status'],
            'clean_order' => $param['sort_order'],
            'url' => $param['url'],
			 'website' => $param['website'],
			 'clean_cat' => $param['clean_cat'],
			 'clean_scat' => $param['clean_scat'],
			 'date_creation' => $param['date_add'],
			'date_update' => $param['date_update'],
			'name_user'	=> $this->session->userdata('username'),
            );
			
			if($image != ''){
				$data_article_vnxindex['images']= $image;
			}
			if($files != ''){
				$data_article_vnxindex['file']= $files;
			}
			// add article_desc_clean
			//  exit;
		  //$cut_array = array_slice($param,$count_arr,-1); 
		  $cut_array = $param;
		  foreach($cut_array as $k=>$va){
				if(substr($k,0,-3) != 'title' && substr($k,0,-3) != 'description' && substr($k,0,-3) != 'long_description'){
					unset($cut_array[$k]); 
				}
					
			}
		 
			  //echo "<pre>";print_r($cut_array);	
		
		  $countlangbyid = $this->modelvnxindex->countLangById_intranet($param['id']);
		  $clean_artid = $this->modelvnxindex->getCleanArtidById_intranet($param['id']);
		  for($i=0;$i<$countlangbyid; $i++){
			  $a = $i*3;
			 $b = array_keys(array_slice ($cut_array,$a,1));
			
			  $cut_array_lang[$b[0]][] = array_slice ($cut_array,$a,3); 
			}
			foreach($cut_array_lang as $key => $val_lang){
					$lang = explode("_",$key);
					$this->modelvnxindex->updateArticleVnxindex_intranet($data_article_vnxindex, $val_lang[0], $clean_artid, $lang[1]);
			}
		  			
			
		 
	}
	
	public function deleteImage(){
		//print_r($_REQUEST);exit;
		$url = $_POST['attr'];
		$url_image = explode('assets',$url);
		$url_cut_image = "assets".$url_image[1]; 
		$data = array(
               'images' => ''
            );

		$this->db->where('images', $url_cut_image);
		$this->db->update('ifrc_articles', $data);
		$result = true;
		$this->output->set_output(json_encode($result));
	}
	
	public function deleteImage_intranet(){
		//print_r($_REQUEST);exit;
		$url = $_POST['attr'];
		$url_image = explode('assets',$url);
		$url_cut_image = "assets".$url_image[1]; 
		$data = array(
               'images' => ''
            );

		$this->db->where('images', $url_cut_image);
		$this->db->update('ifrc_articles', $data);
		$result = true;
		$this->output->set_output(json_encode($result));
	}
	public function deleteFile(){
		//print_r($_REQUEST);exit;
		$url = $_POST['attr'];
		$url_file = explode('assets',$url);
		$url_cut_file = "assets".$url_file[1]; 
		$data = array(
               'file' => ''
            );

		$this->db->where('file', $url_cut_file);
		$this->db->update('ifrc_articles', $data);
		$result = true;
		$this->output->set_output(json_encode($result));
	}
	public function deleteFile_intranet(){
		//print_r($_REQUEST);exit;
		$url = $_POST['attr'];
		$url_file = explode('assets',$url);
		$url_cut_file = "assets".$url_file[1]; 
		$data = array(
               'file' => ''
            );

		$this->db->where('file', $url_cut_file);
		$this->db->update('ifrc_articles', $data);
		$result = true;
		$this->output->set_output(json_encode($result));
	}
	
	public function remove_images(){
		//print_r($_REQUEST);exit;
		$id = $_REQUEST['id_document'];
		$type = $_REQUEST['type'];
		$data = array(
               $type => ''
            );

		$this->db->where('id', $id);
		$this->db->update('int_documents', $data);
		$result = true;
		$this->output->set_output(json_encode($result));
	}
	public function getSimul(){
		$stype = $_REQUEST['id'];
		$result = $this->db->where('type','tooltips')->where('active','1')->where('stype',$stype)->get('simul_settings')->row_array();
		 echo json_encode($result);
	}
    
    public function getChart4(){
        $DB2 = $this->load->database('database2', TRUE);
        $code = isset($_REQUEST['code'])&&$_REQUEST['code']!='' ? $_REQUEST['code'] : $_SESSION['array_other_product']['dsymbol'];
        $data = $DB2->select('close')->where('code',$code)->order_by("date", "asc")->get('idx_day')->result_array();
        foreach($data as $key=>$val){
            foreach($val as $k=>$va){
                $result[] = $va;
            }
        }  
        echo json_encode($result);
    }
	 function getSpectIntraday(){
		 
		 $get_setting = $this->db3->select('minlow, chart_startend')->where("codeint",$_POST['codeint'])->get('vdm_underlying_setting')->row_array();
		
		
		$where = "where 1=1 AND codeint = '$_POST[codeint]' ";
		if(isset($get_setting['chart_startend']) && $get_setting['chart_startend'] != NULL && $get_setting['chart_startend'] !=''){	
			$where .="AND codeint = '$_POST[codeint]' AND idx_last > $get_setting[minlow] ";
			$cut_time = explode('-',$get_setting['chart_startend']);
			$where .= "AND time BETWEEN '$cut_time[0]:00' AND '$cut_time[1]:00' ORDER BY time asc";
		}
		
		$sql = "SELECT dsymbol, idx_last, time FROM vdm_underlying_intraday $where ";
		$result = $this->db3->query($sql)->result_array();
         echo json_encode($result);
    }
	function getSpectIntraday_last(){
		
		 $get_setting = $this->db3->select('minlow, chart_startend')->where("codeint",$_POST['codeint'])->get('vdm_underlying_setting')->row_array();
		
		$where = "where 1=1 AND codeint = '$_POST[codeint]' ";
		if(isset($get_setting['chart_startend']) && $get_setting['chart_startend'] != NULL && $get_setting['chart_startend'] !=''){
			$where .="AND codeint = '$_POST[codeint]' AND idx_last > $get_setting[minlow] ";
			$cut_time = explode('-',$get_setting['chart_startend']);
			$where .= "AND time BETWEEN '$cut_time[0]:00' AND '$cut_time[1]:00' ORDER BY time desc LIMIT 1";
		}
		
		$sql = "SELECT dsymbol, idx_last, time FROM vdm_underlying_intraday $where ";
		
		$result = $this->db3->query($sql)->row_array();
         echo json_encode($result);
    }
	
	public function index_last(){
		$block = new Block();
		$status_market = $this->db3->query("SELECT value FROM setting  WHERE `key` = 'market_making_seconds'")->row_array();
		if((int)$status_market["value"]==-1)
			$status_market["status"] = translate('header_close',true);
		else {
			$status_market["status"] = translate('header_open',true);
		}
		$result["status_market"] = $status_market;
       //block underlying setting
		$result["underlying_setting"] = $block->underlying_setting();
		
		
		
		// future_contract
		$dashboard_future_trading =  $this->db3->query("SELECT vcr.format,vcr.`name`, vcr.utype, vus.last as underlying, df.expiry, df.type, df.dsymbol, df.bid, df.ask, df.last, df.qbid, df.qask, df.var 
FROM (SELECT * FROM dashboard_future ORDER BY expiry ASC) df 
LEFT JOIN vdm_contracts_ref vcr ON vcr.dsymbol = df.dsymbol LEFT JOIN vdm_underlying_setting vus 
ON vcr.codeint = vus.codeint
WHERE df.type = 'FUTURES' AND vus.active = 1 AND vcr.active = 1
GROUP BY df.dsymbol order by vcr.`order` ASC")->result_array();
		//echo "<pre>";print_r($dashboard_future_trading);exit;
		$futures_contracts = array();
		
		 foreach($dashboard_future_trading as $key=>$val_dft){
                          $mmm = substr(strftime('%B',strtotime($val_dft['expiry'])),0,3);
           				 $yy = strftime('%y',strtotime($val_dft['expiry']));
							 //get format any value
							$find_format = strpos($val_dft['format'],'.');
							$find_comma = strpos($val_dft['format'],',');
							if(isset($find_format) && $find_format){
								$explode = explode(".",$val_dft['format']);
								$get_decimal = strlen($explode[1]);
								if(isset($find_comma) && $find_comma) {
									$get_comma = ',';	
								}else{
									$get_comma = '';	
								}
							}
							else if(isset($find_comma) && $find_comma){
								$get_comma = ',';
								$get_decimal = 0;
							}
							else{
								$get_decimal = 0;
								$get_comma = '';	
							}
			 
			 $futures_contracts[$key]['utype'] = substr($val_dft['utype'],0,3);
			 $futures_contracts[$key]['name'] = $val_dft['name'];
			 $futures_contracts[$key]['expiry'] =  strtoupper($mmm.'-'.$yy);
			 $futures_contracts[$key]['underlying'] = ($val_dft['underlying'] != NULL && $val_dft['underlying'] !='-' && $val_dft['underlying'] !=0.00)? number_format($val_dft['underlying'],$get_decimal,'.',$get_comma):'-';
			$futures_contracts[$key]['bid'] = ($val_dft['bid'] != NULL && $val_dft['bid'] !='-' && $val_dft['bid'] !=0) ? number_format($val_dft['bid'],$get_decimal,'.',$get_comma):'';
			$futures_contracts[$key]['ask'] = ($val_dft['ask'] != NULL && $val_dft['ask'] !='-' && $val_dft['ask'] !=0) ? number_format($val_dft['ask'],$get_decimal,'.',$get_comma):'';
			$futures_contracts[$key]['last'] = ($val_dft['last'] != NULL && $val_dft['last'] !='-' && $val_dft['last'] !=0.00)? number_format($val_dft['last'],$get_decimal,'.',$get_comma):'-';
			
			if($val_dft['var'] >= 0){
				$futures_contracts[$key]['var'] = ($val_dft['var'] != NULL) ? '<span class="po">+'.number_format($val_dft['var'],2,'.',',').'%</span>':'';
			}else{
				$futures_contracts[$key]['var'] = ($val_dft['var'] != NULL) ? '<span class="di">'.number_format($val_dft['var'],2,'.',',').'%</span>':'';	
			}
			 
			
		}
		
		$result["futures_contracts"] = $futures_contracts;
		
		
		
		// option contract
		
		$dashboard_option_contract =  $this->db3->query("select df.type, df.expiry, df.strike, df.bid, df.ask, df.var, vcr.utype, vcr.`name`, vus.last as underlying, df.last, df.nr, vcr.format
  from dashboard df left join vdm_contracts_ref vcr on df.dsymbol = vcr.dsymbol
left join vdm_underlying_setting vus on vcr.codeint = vus.codeint
WHERE df.dsymbol 
IN (select dsymbol from vdm_contracts_ref vcr where active = 1 and dtype = 'OPTIONS')  

group by df.type ORDER BY vcr.`name` asc")->result_array();


		//echo "<pre>";print_r($dashboard_option_contract);exit;
		$option_contracts = array();
		
		foreach($dashboard_option_contract as $key=>$market){
			 $mmm = substr(strftime('%B',strtotime($market['expiry'])),0,3);
           	 $yy = strftime('%y',strtotime($market['expiry']));
			 //get format any value
							$find_format = strpos($market['format'],'.');
							$find_comma = strpos($market['format'],',');
							if(isset($find_format) && $find_format){
								$explode = explode(".",$market['format']);
								$get_decimal = strlen($explode[1]);
								if(isset($find_comma) && $find_comma) {
									$get_comma = ',';	
								}else{
									$get_comma = '';	
								}
							}
							else if(isset($find_comma) && $find_comma){
								$get_comma = ',';
								$get_decimal = 0;
							}
							else{
								$get_decimal = 0;
								$get_comma = '';	
							}
			 
			 $option_contracts[$key]['utype'] = substr($market['utype'],0,3);
			 $option_contracts[$key]['name'] = $market['name'];
			 $option_contracts[$key]['expiry'] =  strtoupper($mmm.'-'.$yy);
			 $option_contracts[$key]['underlying'] = ($market['underlying'] != NULL && $market['underlying'] !='-' && $market['underlying'] !=0.00)? number_format($val_dft['underlying'],$get_decimal,'.',$get_comma):'-';
			$option_contracts[$key]['bid'] = ($market['bid'] != NULL && $market['bid'] !='-') ? number_format($market['bid'],$get_decimal,'.',$get_comma):'';
			$option_contracts[$key]['ask'] = ($market['ask'] != NULL && $market['ask'] !='-') ? number_format($market['ask'],$get_decimal,'.',$get_comma):'';
			$option_contracts[$key]['last'] = ($market['last'] != NULL && $market['last'] !='-' && $market['last'] !=0.00)? number_format($val_dft['last'],$get_decimal,'.',$get_comma):'-';
			
			if($val_dft['var'] >= 0){
				$option_contracts[$key]['var'] = ($market['var'] != NULL) ? '<span class="po">+'.number_format($market['var'],2,'.',',').'%</span>':'';
			}else{
				$option_contracts[$key]['var'] = ($market['var'] != NULL) ? '<span class="di">'.number_format($market['var'],2,'.',',').'%</span>':'';	
			}
			 
			
		}
		
		$result["option_contracts"] = $option_contracts;
		
		
		
		



		
		
		/* dashboar_futures for box futures */
		$dashboard_future_r = $this->db3->query('select df.*, vcr.format from dashboard_future df left join vdm_contracts_ref vcr on df.dsymbol = vcr.dsymbol WHERE df.dsymbol="'.$_SESSION['array_other_product']['dsymbol'].'" ORDER BY df.expiry asc')->result_array();
		
		//last
		$dashboard_future =array();
		//best limit
		$best_limit = array();
		foreach($dashboard_future_r as $key => $finances){
			 $mmm = substr(strftime('%B',strtotime($finances['expiry'])),0,3);
           	 $yy = strftime('%y',strtotime($finances['expiry']));
			  //get format any value
							$find_format = strpos($finances['format'],'.');
							$find_comma = strpos($finances['format'],',');
							if(isset($find_format) && $find_format){
								$explode = explode(".",$finances['format']);
								$get_decimal = strlen($explode[1]);
								if(isset($find_comma) && $find_comma) {
									$get_comma = ',';	
								}else{
									$get_comma = '';	
								}
							}
							else if(isset($find_comma) && $find_comma){
								$get_comma = ',';
								$get_decimal = 0;
							}
							else{
								$get_decimal = 0;
								$get_comma = '';	
							}
			 if($finances['expiry'] ==$_SESSION['session_expiry_date']) {
				 $dashboard_future = $finances;				 
			 }
			$best_limit[$key]['expiry']=  strtoupper($mmm.'-'.$yy);
			$best_limit[$key]['qbid']=  ($finances['qbid'] != NULL && $finances['qbid'] !='-')? number_format($finances['qbid'],0,'.',','):'';
			$best_limit[$key]['bid']=  ($finances['bid'] != NULL && $finances['bid'] !='-' && $finances['bid'] !=0) ? number_format($finances['bid'],$get_decimal,'.',$get_comma):'';
			$best_limit[$key]['ask']=  ($finances['ask'] != NULL && $finances['ask'] !='-' && $finances['ask'] !=0) ? number_format($finances['ask'],$get_decimal,'.',$get_comma):'';
			$best_limit[$key]['qask']=  ($finances['qask'] != NULL && $finances['qask'] !='-') ? number_format($finances['qask'],0,'.',','):'';
			$best_limit[$key]['last']=  ($finances['last'] != NULL) ? number_format($finances['last'],$get_decimal,'.',$get_comma):'';
			$best_limit[$key]['time']=  (($finances['time']!=NULL) && date("Y-m-d") > date("Y-m-d",strtotime($finances['time']))) ?  date("Y-m-d",strtotime($finances['time'])):(($finances['time']!=NULL) ? date("H:i:s",strtotime($finances['time'])):''); 
			$best_limit[$key]['theo']=  ($finances['theo'] != NULL) ? number_format($finances['theo'],$get_decimal,'.',$get_comma):'';
			//trades
			if($finances['change'] >= 0){
				$best_limit[$key]['change']= ($finances['change'] != NULL) ? '<span class="po">+'.number_format($finances['change'],$get_decimal,'.',$get_comma).'</span>':'';
			}else{
				$best_limit[$key]['change'] = ($finances['change'] != NULL) ? '<span class="di">'.number_format($finances['change'],$get_decimal,'.',$get_comma).'</span>':'';	
			}
			if($finances['var'] >= 0){
				$best_limit[$key]['var'] = ($finances['var'] != NULL) ? '<span class="po">+'.number_format($finances['var'],2,'.',',').'%</span>':'';
			}else{
				$best_limit[$key]['var'] = ($finances['var'] != NULL) ? '<span class="di">'.number_format($finances['var'],2,'.',',').'%</span>':'';	
			}
			$best_limit[$key]['volume']=  ($finances['volume'] != NULL) ? number_format($finances['volume'],0,'.',','):'';
			$best_limit[$key]['dvolume']=  ($finances['dvolume'] != NULL) ? number_format($finances['dvolume'],0,'.',','):'';
			$best_limit[$key]['oi']=  ($finances['oi'] != NULL) ? number_format($finances['oi'],0,'.',','):'';
			$best_limit[$key]['settle']=  ($finances['settle'] != NULL) ? number_format($finances['settle'],$get_decimal,'.',$get_comma):'';
			$best_limit[$key]['psettle']=  ($finances['psettle'] != NULL) ? number_format($finances['psettle'],$get_decimal,'.',$get_comma):'';
		}
		$dashboard_future['last'] = number_format($dashboard_future['last'],$get_decimal,'.',$get_comma);
		//change
		if($dashboard_future['last']=='0.00') {
			$dashboard_future['change'] ='-';
			$dashboard_future['var'] ='-';
			$dashboard_future['last'] ='-';
		}
		else {
			if($dashboard_future['change'] >=0)
				$dashboard_future['change'] = '<span class="po">+'.number_format($dashboard_future['change'],$get_decimal,'.',$get_comma).'</span>';
			else 
				$dashboard_future['change'] = '<span class="di">'.number_format($dashboard_future['change'],$get_decimal,'.',$get_comma).'</span>';
			//var
			if($dashboard_future['var'] >=0)
				$dashboard_future['var'] = '<span class="po">+'.number_format($dashboard_future['var'],2,'.',',').'%</span>';
			else 
				$dashboard_future['var'] = '<span class="di">'.number_format($dashboard_future['var'],2,'.',',').'%</span>';
		}
		$dashboard_future['oi'] = (isset($dashboard_future['oi']) && $dashboard_future['oi'] != NULL) ? number_format($dashboard_future['oi'],0,'.',','):'' ;
		if($dashboard_future['time']!='') {
			if(date('Y-m-d',strtotime($dashboard_future['time'])) == date('Y-m-d') )
				$dashboard_future['time'] = date('H:i:s',strtotime($dashboard_future['time']));
			else 
				$dashboard_future['time'] = date('Y-m-d',strtotime($dashboard_future['time']));
			}
		else {
			$dashboard_future['time'] ='';
		}
		
		$result["best_limit"] = $best_limit;
		if(isset($dashboard_future['bid']) && $dashboard_future['bid'] != '-' && $dashboard_future['bid'] != 0  ){
			$avg_b = $this->db3->query("select avg(vofd.price) as b, vcr.format from vdm_order_futures_daily vofd left join vdm_contracts_ref vcr on vofd.dsymbol = vcr.dsymbol where vofd.dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and vofd.`b/s` = 'B' and vofd.expiry = '{$_SESSION['session_expiry_date']}' and vofd.price <= ".$dashboard_future['bid'])->row_array();
				$find_format = strpos($avg_b['format'],'.');
				$find_comma = strpos($avg_b['format'],',');
				if(isset($find_format) && $find_format){
					$explode = explode(".",$avg_b['format']);
					$get_decimal = strlen($explode[1]);
					if(isset($find_comma) && $find_comma) {
						$get_comma = ',';	
					}else{
						$get_comma = '';	
					}
				}
				else if(isset($find_comma) && $find_comma){
					$get_comma = ',';
					$get_decimal = 0;
				}
				else{
					$get_decimal = 0;
					$get_comma = '';	
				}
			
			}
		else 
			$avg_b= array("b"=>'-');
		
		$result["avg_buy"] = $avg_b['b']!='-' ? number_format($avg_b['b'],$get_decimal,'.',$get_comma):'-';
		if(isset($dashboard_future['ask']) && $dashboard_future['ask'] != '-' && $dashboard_future['ask'] != 0 ){
			$avg_s = $this->db3->query("select avg(vofd.price) as s, vcr.format  from vdm_order_futures_daily vofd left join vdm_contracts_ref vcr on vofd.dsymbol = vcr.dsymbol  where vofd.dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and vofd.`b/s` = 'S' and vofd.expiry = '{$_SESSION['session_expiry_date']}' and vofd.price >= ".$dashboard_future['ask'])->row_array();
			
			$find_format = strpos($avg_s['format'],'.');
			$find_comma = strpos($avg_s['format'],',');
			if(isset($find_format) && $find_format){
				$explode = explode(".",$avg_s['format']);
				$get_decimal = strlen($explode[1]);
				if(isset($find_comma) && $find_comma) {
					$get_comma = ',';	
				}else{
					$get_comma = '';	
				}
			}
			else if(isset($find_comma) && $find_comma){
				$get_comma = ',';
				$get_decimal = 0;
			}
			else{
				$get_decimal = 0;
				$get_comma = '';	
			}	
		}
		else 
			$avg_s= array("s"=>'-');
		$result["avg_sell"] = $avg_s['s'] !='-' ? number_format($avg_s['s'],$get_decimal,'.',$get_comma) :'-';
		if(isset($dashboard_future['bid']) && $dashboard_future['bid'] != '-' && $dashboard_future['bid'] != 0 && $dashboard_future['ask'] != 0 && isset($dashboard_future['ask']) && $dashboard_future['ask'] != '-'){
		$result["order_maxspd"] = number_format(($dashboard_future['ask']-$dashboard_future['bid'])*100/$dashboard_future['bid'],2,'.',',').'%';
		}
		else {
			$result["order_maxspd"] = '-';
		}
		
		$find_format = strpos($dashboard_future['format'],'.');
			$find_comma = strpos($dashboard_future['format'],',');
			if(isset($find_format) && $find_format){
				$explode = explode(".",$dashboard_future['format']);
				$get_decimal = strlen($explode[1]);
				if(isset($find_comma) && $find_comma) {
					$get_comma = ',';	
				}else{
					$get_comma = '';	
				}
			}
			else if(isset($find_comma) && $find_comma){
				$get_comma = ',';
				$get_decimal = 0;
			}
			else{
				$get_decimal = 0;
				$get_comma = '';	
			}	
		$dashboard_future['qbid']=  ($dashboard_future['qbid'] != '' && $dashboard_future['qbid'] != NULL && $dashboard_future['qbid'] !='-' && $dashboard_future['qbid'] !=0)? number_format($dashboard_future['qbid'],0,'.',','):'-';
		$dashboard_future['bid']=  ($dashboard_future['bid'] != '' && $dashboard_future['bid'] != NULL && $dashboard_future['bid'] !='-' && $dashboard_future['bid'] !=0) ? number_format($dashboard_future['bid'],$get_decimal,'.',$get_comma):'-';
		$dashboard_future['ask']=  ($dashboard_future['ask'] != '' && $dashboard_future['ask'] != NULL && $dashboard_future['ask'] !='-' && $dashboard_future['ask'] !=0) ? number_format($dashboard_future['ask'],$get_decimal,'.',$get_comma):'-';
		$dashboard_future['qask']=  ($dashboard_future['qask'] != '' && $dashboard_future['qask'] != NULL && $dashboard_future['qask'] !='-' && $dashboard_future['qask'] !=0) ? number_format($dashboard_future['qask'],0,'.',','):'-';
		$result["dashboard_future"] = $dashboard_future;	
		if(strpos($_SERVER["HTTP_REFERER"], 'options')!==FALSE)	{
		//option best limit
			$sql = "SELECT * ";
						$sql.= "FROM dashboard ";
						$sql.= "WHERE type = 'Call' and (nr BETWEEN -2 AND 2) and expiry = '{$_SESSION['session_expiry_date']}' and  dsymbol = '".$_SESSION['option_product']['dsymbol']."' order by nr LIMIT 0,5  ";
			$dashboard_option = $this->db3->query($sql)->result_array();
			//echo "<pre>";print_r($dashboard_option);exit;
			$option_best_limit = array();
			foreach($dashboard_option as $key => $options){
							$mmm = substr(strftime('%B',strtotime($options['expiry'])),0,3);
							 $yy = strftime('%y',strtotime($options['expiry']));
							$option_best_limit[$key]['expiry'] =strtoupper($mmm.'-'.$yy);
							$option_best_limit[$key]['strike'] =($options['strike'] != NULL && $options['strike'] !='-')? number_format($options['strike'],0,'.',','):'';
							$option_best_limit[$key]['qbid'] =($options['qbid'] != NULL && $options['qbid'] !='-')? number_format($options['qbid'],0,'.',','):'';
							$option_best_limit[$key]['bid'] =($options['bid'] != NULL && $options['bid'] !='-') ? number_format($options['bid'],2,'.',','):'';
							$option_best_limit[$key]['ask'] =($options['ask'] != NULL && $options['ask'] !='-') ? number_format($options['ask'],2,'.',','):'';
							$option_best_limit[$key]['qask'] = ($options['qask'] != NULL && $options['qask'] !='-') ? number_format($options['qask'],0,'.',','):'';
							$option_best_limit[$key]['last'] = ($options['last'] != NULL) ? number_format($options['last'],2,'.',','):'';
							if(!empty($options['time'])){
								if(date("Y-m-d") > date("Y-m-d",strtotime($options['time'])))
									$option_best_limit[$key]['time'] = date("Y-m-d",strtotime($options['time']));
									else $option_best_limit[$key]['time'] = date("H:i:s",strtotime($options['time']));
							   }
							else {
								$option_best_limit[$key]['time'] = '';
							}
							
							$option_best_limit[$key]['implied'] =  ($options['implied'] != NULL) ? number_format($options['implied'],2,'.',','):'';
							if($options['change'] >= 0){
								$option_best_limit[$key]['change']= ($options['change'] != NULL) ? '<span class="po">+'.number_format($options['change'],2,'.',',').'</span>':'';
							}else{
								$option_best_limit[$key]['change'] = ($options['change'] != NULL) ? '<span class="di">'.number_format($options['change'],2,'.',',').'</span>':'';	
							}
							if($options['var'] >= 0){
								$option_best_limit[$key]['var'] = ($options['var'] != NULL) ? '<span class="po">+'.number_format($options['var'],2,'.',',').'%</span>':'';
							}else{
								$option_best_limit[$key]['var'] = ($options['var'] != NULL) ? '<span class="di">'.number_format($options['var'],2,'.',',').'%</span>':'';	
							}
							$option_best_limit[$key]['volume'] = ($options['volume'] != NULL) ? number_format($options['volume'],0,'.',','):'';
							$option_best_limit[$key]['dvolume'] = ($options['dvolume'] != NULL) ? number_format($options['dvolume'],0,'.',','):'';
							$option_best_limit[$key]['oi'] = ($options['oi'] != NULL) ? number_format($options['oi'],0,'.',','):'';
							$option_best_limit[$key]['settle'] = ($options['settle'] != NULL) ? number_format($options['settle'],2,'.',','):'';
							$option_best_limit[$key]['theo'] = ($options['theo'] != NULL) ? number_format($options['theo'],2,'.',','):'';
			}             
			$result["option_best_limit"] = $option_best_limit;
			//option order
			$row_option = $this->db3->query("select bid, ask, qbid, qask from dashboard where type = 'Call' AND dsymbol = '".$_SESSION['option_product']['dsymbol']."' AND expiry = '{$_SESSION['session_expiry_date']}' and nr=0")->row_array();
			
			//echo "<pre>";print_r($row_option);exit; 
			
			$option_order["qbid"] = (isset($row_option['qbid'])) ? $row_option['qbid']: '-';
			$option_order["bid"] = (isset($row_option['bid'])) ? number_format($row_option['bid'],2,'.',','):'-';
			$option_order["ask"] = (isset($row_option['ask'])) ? number_format($row_option['ask'],2,'.',','):'-';
			$option_order["qask"] = (isset($row_option['qask'])) ? $row_option['qask']:'-';
			
			$sum_b_option = $this->db3->query("select sum(quantity) as b from vdm_order_options_daily where dsymbol = '".$_SESSION['option_product']['dsymbol']."' and `b/s` = 'B' and expiry = '{$_SESSION['session_expiry_date']}' and type ='C'")->row_array();
			$sum_s_option = $this->db3->query("select sum(quantity) as s from vdm_order_options_daily where dsymbol = '".$_SESSION['option_product']['dsymbol']."' and `b/s` = 'S' and expiry = '{$_SESSION['session_expiry_date']}' and type ='C'")->row_array();
			
			$avg_b_option = $this->db3->query("select avg(price) as b from vdm_order_options_daily where dsymbol = '".$_SESSION['option_product']['dsymbol']."' and `b/s` = 'B' and expiry = '{$_SESSION['session_expiry_date']}' and type ='C'")->row_array();
			$avg_s_option = $this->db3->query("select avg(price) as s from vdm_order_options_daily where dsymbol = '".$_SESSION['option_product']['dsymbol']."' and `b/s` = 'S' and expiry = '{$_SESSION['session_expiry_date']}' and type ='C'")->row_array();
			
			//$maxspd_option = $this->db3->query("select maxspd from vdm_contracts_setting_exc where product = 'OPTIONS' AND code = '$_SESSION['array_other_product']['dsymbol']' and expiry = '{$_SESSION['session_expiry_date']}' and type ='C'")->row_array();
			if($row_option["bid"]!= 0){
				$options_maxspd = number_format(($row_option["ask"]-$row_option["bid"])*100/$row_option["bid"],2,'.',',').'%';
			}
			
			if(isset($row_option['bid']) && $row_option['bid'] != '-' && $row_option['bid'] != 0 && isset($row_option['ask']) && $row_option['ask'] != '-' && $row_option['ask']!=0){
				$option_order["options_maxspd"]= number_format(($row_option["ask"]-$row_option["bid"])*100/$row_option["bid"],2,'.',',').'%';
			}
			else{
				$option_order["options_maxspd"] = '-';	
			}
			$option_order["sum_b_option"] =  (isset($sum_b_option['b'])) ? $sum_b_option['b']:'-';;
			$option_order["avg_b_option"] = (isset($avg_b_option['b'])) ? number_format($avg_b_option['b'],2,'.',','):'-';
			$option_order["options_maxspd"] = (isset($options_maxspd)) ? $options_maxspd:'-';
			$option_order["avg_s_option"] = (isset($avg_s_option['s'])) ? number_format($avg_s_option['s'],2,'.',','):'-';
			$option_order["sum_s_option"] = ($sum_s_option['s'] !='') ? $sum_s_option['s']:'-';
			$result["option_order"] = $option_order;
			$result["page_options"] = 1;
		}
		else 
		$result["page_options"] = 0;
		$this->output->set_output(json_encode($result));
	}
    
    function view_modal() {
		$html_code ='';
        $type = isset($_POST['type']) ? $_POST['type'] : "";
        $field = isset($_POST['field']) ? $_POST['field'] : "";
        $value = isset($_POST['value']) ? $_POST['value'] : "";
		$value = str_replace(",","",$value);
		//echo "<pre>";print_r($value);exit; 
		$data_default = isset($_POST['data_default']) ? $_POST['data_default'] : "";
        if($type == 'input'){
            $html_code = '<input type="text" id="'.strtolower($field).'" name="'.strtolower($field).'" value="'.$value.'" data_default="'.$data_default.'" class="input form-control key_down" />';	   
        }else if ($type == 'choose'){
            $this->load->model('strategies_model', 'strategies');
            $type = $this->db->select('opt_fut')->where('`tab`',trim(strtolower($value)))->get('vdm_strategy_setting')->row_array();
            $menu_array = $this->strategies->list_data($type['opt_fut']);
            $html_code = '<div class="table-responsive" style="max-height: 250px"><table class="table table-bordered table-hover table_modal"><tbody>';
            foreach($menu_array as $product){
                $html_code .= '<tr><td class="td_custom cus_pri ma_cat"><a style="display:flex;" href="'.base_url().DIR_SIMULATION.'strategies?tab='.$product["tab"].'">'.$product['name'].'</a></td></tr>';        
            }
            $html_code .= '</tbody></table></div>';
        }
        @$this->data->html_code = $html_code;
        $this->data->type = $type;
        $this->data->field = $field;
        $this->load->view('modal', $this->data);
    }
	public function update_vndmi_setting(){
		//echo "<pre>";print_r($_REQUEST);exit;
		if($_REQUEST['open_close'] == 'false'){
			$data = array('value' => -1);
			$this->db3->where('group', 'setting')->where('key','market_making_seconds')->update('setting', $data);	
		}else{
			$data = array('value' => $_REQUEST['freqm']);
			$this->db3->where('group', 'setting')->where('key','market_making_seconds')->update('setting', $data);
		}
		
	}
	public function closeMarket(){
		$this->dashboard->close_market();
        /*$output = $this->dashboard->close_market();
        echo json_encode($output);*/
    }
    public function openMarket(){
       // $output = $this->dashboard->open_market();
		$this->dashboard->open_market();
      //echo json_encode($output);
    }
	public function market_making_futures_close(){

		$sql = "UPDATE setting SET value = 0 WHERE `key` ='market_making_futures';";
        $this->db3->query($sql);
        return true;
    }
	public function market_making_futures_open(){

		$sql = "UPDATE setting SET value = 1 WHERE `key` ='market_making_futures';";
        $this->db3->query($sql);
        return true;
    }
	/*public function insert_vdm_order_futures_daily_sell(){
		$id_user = 	$_REQUEST['input_id_user'];
		$date_time = $_REQUEST['input_datetime'];
		$order_type = $_REQUEST['input_order_type'];
		$order_method = $_REQUEST['input_order_method'];
		$model = $_REQUEST['input_model'];
		$expiry = $_REQUEST['input_expiry'];
		$buy_sell = "S";
		$interest = $_REQUEST['input_interest'];
		$dividend = $_REQUEST['input_dividend'];
		$price = str_replace(',','',$_REQUEST['input_price']);
		$quatity = $_REQUEST['input_quatity'];
		$deadline = $_REQUEST['input_deadline'];
		$dsymbol = $_REQUEST['input_dsymbol'];
		$sql = "INSERT  INTO vdm_order_futures_daily (`id_user`, `datetime`, `order_type`, `order_method`, `model`, `expiry`, `b/s`, `interest`, `dividend`, `price`, `quantity`, `status`, `deadline`, `dsymbol`) VALUES ($id_user,'$date_time', '$order_type', '$order_method', '$model', '$expiry', '$buy_sell', '$interest', '$dividend', $price, $quatity, $quatity, '$deadline', '$dsymbol');";
		$this->db3->query($sql);
        return true;
	}
	public function insert_vdm_order_futures_daily_buy(){
		$id_user = 	$_REQUEST['input_id_user'];
		$date_time = $_REQUEST['input_datetime'];
		$order_type = $_REQUEST['input_order_type'];
		$order_method = $_REQUEST['input_order_method'];
		$model = $_REQUEST['input_model'];
		$expiry = $_REQUEST['input_expiry'];
		$buy_sell = "B";
		$interest = $_REQUEST['input_interest'];
		$dividend = $_REQUEST['input_dividend'];
		$price = $_REQUEST['input_price'];
		$quatity = $_REQUEST['input_quatity'];
		$deadline = $_REQUEST['input_deadline'];
		$dsymbol = $_REQUEST['input_dsymbol'];
		$sql = "INSERT  INTO vdm_order_futures_daily (`id_user`, `datetime`, `order_type`, `order_method`, `model`, `expiry`, `b/s`, `interest`, `dividend`, `price`, `quantity`, `status`, `deadline`, `dsymbol`) VALUES ($id_user,'$date_time', '$order_type', '$order_method', '$model', '$expiry', '$buy_sell', '$interest', '$dividend', $price, $quatity, $quatity, '$deadline', '$dsymbol');";
		$this->db3->query($sql);
        return true;
	}*/
	
	
	function check_margin_order(){
		$margin = $this->db3->query("SELECT value FROM setting WHERE `key` = 'margin'")->row_array();
		$broker_ratio = $this->db3->query("SELECT value FROM setting WHERE `key` = 'broker_ratio'")->row_array();
		$user_id = $_SESSION['simulation']['user_id'];
		$available = $this->db3->query("SELECT available FROM vdm_user_summary WHERE `id_user` = $user_id")->row_array();
		//echo "<pre>";print_r($_SESSION['simulation']['user_id']);exit;
		$quantity = $_REQUEST['data_value'];
		if(isset($margin) && isset($broker_ratio)){
			$bro_ra = (-1)*$margin['value']*$quantity*$broker_ratio['value'];
		}
		//echo "<pre>";print_r(abs($bro_ra).'+'.$available['available']);
		if(abs($bro_ra) <= $available['available']){
			echo 1;	
		}else{
			echo 0;	
		}
		//echo "<pre>";print_r($bro_ra.'-'.$available['available']);exit;
		
	}
	
	function check_margin_order_option(){
		$margin = $this->db3->query("SELECT value FROM setting WHERE `key` = 'margin'")->row_array();
		$broker_ratio = $this->db3->query("SELECT value FROM setting WHERE `key` = 'broker_ratio'")->row_array();
		$user_id = $_SESSION['simulation']['user_id'];
		$available = $this->db3->query("SELECT available FROM vdm_user_summary WHERE `id_user` = $user_id")->row_array();
		//echo "<pre>";print_r($_SESSION['simulation']['user_id']);exit;
		$quantity = $_REQUEST['data_value'];
		if(isset($margin) && isset($broker_ratio)){
			$bro_ra = (-1)*$margin['value']*$quantity*$broker_ratio['value'];
		}
		//echo "<pre>";print_r(abs($bro_ra).'+'.$available['available']);
		if(abs($bro_ra) <= $available['available']){
			echo 1;	
		}else{
			echo 0;	
		}
		//echo "<pre>";print_r($bro_ra.'-'.$available['available']);exit;
		
	}
	
	
	function insert_daily_futures(){
		//echo "<pre>";print_r($_REQUEST);exit;
		$id_user = 	$_REQUEST['input_id_user'];
		$datetime = $_REQUEST['input_datetime'];
		$order_type = $_REQUEST['input_order_type'];
		$method_type = $_REQUEST['input_order_method'];
		$model = $_REQUEST['input_model'];
		$expiry = $_REQUEST['input_expiry'];
		$b_s =$_REQUEST['input_buy_sell'];
		$interest = $_REQUEST['input_interest'];
		$dividend = $_REQUEST['input_dividend'];
		$price = str_replace(',','',$_REQUEST['input_price']);
		$quantity_val = $_REQUEST['input_quatity'];
		$deadline = $_REQUEST['input_deadline'];
		$dsymbol = $_REQUEST['input_dsymbol'];
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
						  if($q_last['psettle'] >0 ) {
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
		   $id = $this->db3->insert_id();
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
						  if($q_last['psettle'] >0 ) {
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
						  if($q_last['psettle'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
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
		   $id = $this->db3->insert_id();
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
	
	function insert_daily_options(){
		
		//echo "<pre>";print_r($_REQUEST);exit; 
		
		$id_user = 	$_REQUEST['input_id_user'];
		$datetime = $_REQUEST['input_datetime'];
		$order_type = $_REQUEST['input_order_type'];
		$method_type = $_REQUEST['input_order_method'];
		$model = $_REQUEST['input_model'];
		$expiry = $_REQUEST['input_expiry'];
		$b_s =$_REQUEST['input_buy_sell'];
		$interest = $_REQUEST['input_interest'];
		$dividend = $_REQUEST['input_dividend'];
		$price = str_replace(',','',$_REQUEST['input_price']);
		$quantity_val = $_REQUEST['input_quatity'];
		$deadline = $_REQUEST['input_deadline'];
		$dsymbol = $_REQUEST['input_dsymbol'];
		$volatility = $_REQUEST['input_volatility'];
		$c_p = $_REQUEST['input_c_p'];
		$strike = str_replace(',','',$_REQUEST['input_strike']);
	   //var_export($price);die();
		
		
		//var_export($price);die();
	   $price=floatval(str_replace(',','',$price));
       
       if(str_replace(' ','',strtolower($method_type))=='goodtodate'){$method = 'GTD';}else if(str_replace(' ','',strtolower($method_type))=='goodtoexpiry'){$method = 'GTE';}else if(str_replace(' ','',strtolower($method_type))=='goodtillcancelled'){$method = 'GTC';}else{$method = 'LOD';};
	   $market_order = $order_type == 'Market order' ? "FOK" : $method;
	   $b_s = substr($b_s, 0, 1);
       $result1 = array();
	   //
       $sql = 'select * from order_book_options_best_limit where `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `c/p`="'.$c_p.'" and `strike`="'.$strike.'" Limit 1';
	   $best_limit = $this->db3->query($sql)->row_array();

	   
	   if($market_order !='FOK'){
	       if($price!=0){
		  
		
		   if(!isset($best_limit['id'])){
			   
			   $status = $quantity_val;
			   $status_limit = 1;
			   // Neu $b_s = B Thi bid = $price,qask = -, ask = -
			  
			  if($b_s=="B"){
				  $insert_best_limit = "INSERT INTO order_book_options_best_limit (
					   `expiry`,`qbid`,`bid`,`ask`,`qask`,`dsymbol`, `c/p`, `strike`)
					   VALUES ('".$expiry."','".$quantity_val."','".$price."','-', '-','".$dsymbol."','".$c_p."','".$strike."');";
					   
				  $status_best_limit = $this->db3->query($insert_best_limit);
				  $update_dashboard = "UPDATE dashboard Set `qbid` = '".$quantity_val."' , `bid`='".$price."' , `qask` = '-' , `ask` ='-', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
				  $status_dashboard = $this->db3->query($update_dashboard);
			   }
			    // Neu $b_s = - Thi bid = $price,qask = $quantity_val, ask = -
			   else {
				   $insert_best_limit = "INSERT INTO order_book_options_best_limit (
				   `expiry`,`qbid`,`bid`,`qask`,`ask`,`dsymbol`, `c/p`, `strike`)
				   VALUES ('".$expiry."','-','-','".$quantity_val."','".$price."','".$dsymbol."','".$c_p."','".$strike."');";
				   
				   $status_best_limit = $this->db3->query($insert_best_limit);
				   $update_dashboard = "UPDATE dashboard Set `qbid` = '-' , `bid`='-' , `qask` = '".$quantity_val."' , `ask` ='".$price."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
				  $status_dashboard = $this->db3->query($update_dashboard);
			   }
						   
		   }
		   else {
		   
			   if($b_s=="B"){
				    	
				   if(($best_limit['ask']>0) && (floatval(str_replace(',','',$best_limit['ask']))<=$price)){
					 				   
					   $sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'"  and `b/s`="S" and `p` <="'.$price.'" and `status` >0 Order by `p` ASC, `datetime` ASC';
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
						   $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep = $this->db3->query($update_deep);
						   $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
				  		   $status_update_deep = $this->db3->query($update_deep);
						   $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						  
						  $status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
						  //get last
						  $sql_last = 'select * from dashboard where `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'"  and `strike`="'.$best_limit_s['strike'].'"  and type = "'.$c_p.'" Limit 1';
		   				  $q_last = $this->db3->query($sql_last)->row_array();
						  if(isset($q_last['psettle']) && $q_last['psettle'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
						  }
		   				  else {
							  $var="`var`=NULL ";
							  $change="`change`=NULL ";	
						  }
						  $update_dashboard = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike = '".$best_limit_s['strike']."'  and type = '".$c_p."'";
				  		  $status_dashboard = $this->db3->query($update_dashboard);
						  $i += $best_limit_s["status"];
						 
                          $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);						
					   }				   													   
				   }
				   else {
					
					    $status = $quantity_val;
				   }
				    //echo "<pre>";print_r('tao teo ne!');exit; 
			   }
			   else {
				   // echo "<pre>";print_r('ti la tao!');exit; 
				  if(($best_limit['bid']!='-') && (floatval(str_replace(',','',$best_limit['bid']))>=$price)){					   
					   $sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `c/p`="'.$c_p.'" and `strike`="'.$strike.'" and `b/s`="B" and `p` >="'.$price.'" and `status` >0 Order by `p` DESC, `datetime` ASC';
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
						   $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep = $this->db3->query($update_deep);
						   $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep = $this->db3->query($update_deep);
						   $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						   
							$status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
							$sql_last = 'select * from dashboard where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and `strike`="'.$best_limit_s['strike'].'" and type = "'.$best_limit_s['c/p'].'" Limit 1';
		   				  $q_last = $this->db3->query($sql_last)->row_array();
						  if($q_last['psettle'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
						  }
		   				  else {
							  $var="`var`=NULL ";	
							  $change="`change`=NULL ";	
						  }
						  $update_dashboard = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike='".$best_limit_s['strike']."' and type = '".$best_limit_s['c/p']."'";
				  		  $status_dashboard = $this->db3->query($update_dashboard);
							$i += $best_limit_s["status"];	
							
                            $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);			
					   }				   													   
				   }
				   else {
					    $status = $quantity_val;
				   }
			   
				}	
		   }
		   
		   
			  $sql = "INSERT INTO vdm_order_options_daily( id_user, datetime, product, `type`, order_type, order_method, model, expiry, `b/s`, interest, dividend, price, quantity, status, volatility, strike, deadline,dsymbol, `c/p`)
				   VALUES ('{$id_user}','{$datetime}','{$dsymbol}','{$c_p}','{$order_type}','{$method_type}','{$model}','{$expiry}','{$b_s}','{$interest}','{$dividend}','{$price}','{$quantity_val}', '{$status}','{$volatility}','{$strike}','{$deadline}','{$dsymbol}','{$c_p}')";
		   $result = $this->db3->query($sql);
		   //echo "<pre>";print_r($sql);exit;
		   // insert order_book_option_deep
		   $id = $this->db->insert_id();
		  // echo "<pre>";print_r($id);exit;
		  // if($result == true){
				//$this->update_opt_summary($id_user,1,0,1);
		   //}
		   if($result>0){
				$sql1 = "INSERT INTO order_book_options_deep (
				   id, id_user, `datetime`, dsymbol, expiry, `b/s`, p, q, market_order,status, deadline, `c/p`, `strike` )
				   VALUES ('{$id}','{$id_user}','{$datetime}','{$dsymbol}', '{$expiry}','{$b_s}', '{$price}','{$quantity_val}','{$market_order}','{$status}','{$deadline}','{$c_p}','{$strike}');
				   ";
			   $result1 = $this->db3->query($sql1);
		   } 
	   
		  
		   $sql = 'select max(`p`) as max from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and status <>0';
		   $price_b = $this->db3->query($sql)->row_array();
		   if(isset($price_b["max"])){
			   $sql = 'select sum(`status`) as qbid from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and `p`="'.$price_b["max"].'" and status <>0';
			   $sum = $this->db3->query($sql)->row_array();
			   $qbid = $sum["qbid"];
			   $bid = $price_b["max"];
		   }
		   else {
				$qbid = "-";
				$bid = "-";				   
		   }
			$sql = 'select min(`p`) as min from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and status <>0';
			   $price_s = $this->db3->query($sql)->row_array();
			   if(isset($price_s["min"])){
				   $sql = 'select sum(`status`) as qask from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
				   $sum = $this->db3->query($sql)->row_array();
				   $qask = $sum["qask"];
				   $ask = $price_s["min"];
			   }
			   else {
					$qask = "-";
					$ask = "-";				   
			   }
			    $update_best_limit = "UPDATE order_book_options_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry."' AND `dsymbol`='".$dsymbol."' AND `strike`='".$strike."' AND `c/p`='".$c_p."'";
				$status_best_limit = $this->db3->query($update_best_limit);
				 $update_dashboard = "UPDATE dashboard Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
				 $status_dashboard = $this->db3->query($update_dashboard);
            }
		    
	   }
	   else {
		   
		   
		   
				if($b_s=="B"){
						//sell
					   $sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `c/p`="'.$c_p.'" and `strike`="'.$strike.'" and `b/s`="S" and `status` <> 0 Order by `p` ASC,`datetime` ASC';
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
						  $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						  $status_update_deep = $this->db3->query($update_deep);
						  $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						  $status_update_deep = $this->db3->query($update_deep);
						  $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						   
						  $status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
						  $sql_last = 'select * from dashboard where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and `strike`="'.$best_limit_s['strike'].'" and type = "'.$best_limit_s['c/p'].'" Limit 1';
							  $q_last = $this->db3->query($sql_last)->row_array();
							  if($q_last['psettle'] >0 ) {
								$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
								$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
							  }
							  else {
								  $var="`var`=NULL ";
								  $change = "`change`=NULL ";	
							  }
							  $update_dashboard_options = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ". $change. " ,`time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike='".$best_limit_s['strike']."' and type = '".$best_limit_s['c/p']."'";
							  $status_dashboard_options = $this->db3->query($update_dashboard_options);
						  $i += $best_limit_s["status"];
						  $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);
												
					   }
					   $sql = 'select min(`p`) as min from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and status <>0';
					   $price_s = $this->db3->query($sql)->row_array();
					   if(isset($price_s["min"])&&$price_s["min"]!=0){
						   $sql = 'select sum(`status`) as qask from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
						   $sum = $this->db3->query($sql)->row_array();
						   $qask = $sum["qask"];
						   $ask = $price_s["min"];
					   }
					   else {
							$qask = "-";
							$ask = "-";
					   }
					   $update_best_limit = "UPDATE order_book_options_best_limit Set `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry."' AND `strike`='".$strike."' AND `c/p`='".$c_p."' AND `dsymbol`='".$dsymbol."'";
					   $status_best_limit = $this->db3->query($update_best_limit);
					   $update_dashboard_options = "UPDATE dashboard Set `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
					  $status_dashboard_options = $this->db3->query($update_dashboard_options);
				   }
				else {
						$sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and `status` > 0 Order by `p` DESC ,`datetime` ASC';
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
						   $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						   $status_update_deep = $this->db3->query($update_deep);
						   $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						   $status_update_deep = $this->db3->query($update_deep);
						   $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						  
						  $status_excu_trade_s = $this->db3->query($insert_excu_trade_s);
						  $sql_last = 'select * from dashboard where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and `strike`="'.$best_limit_s['strike'].'" and type = "'.$best_limit_s['c/p'].'" Limit 1';
							  $q_last = $this->db3->query($sql_last)->row_array();
							  if($q_last['psettle'] >0 ) {
								$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
								$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
							  }
							  else {
								  $var="`var`=NULL ";	
								  $change = " `change`=NULL";
							  }
							  $update_dashboard_options = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike='".$best_limit_s['strike']."' and type = '".$best_limit_s['c/p']."'";
							  $status_dashboard_options = $this->db3->query($update_dashboard_options);
						  
						  $i += $best_limit_s["status"];
						  $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);											
					   }
					   $sql = 'select max(`p`) as max from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B"  and status <>0';
					   $price_b = $this->db3->query($sql)->row_array();
					   if(isset($price_b["max"])&&$price_b["max"]!=0){
						   $sql = 'select sum(`status`) as qbid from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and `p`="'.$price_b["max"].'"  and status <>0';
						   $sum = $this->db3->query($sql)->row_array();
						   $qbid = $sum["qbid"];
						   $bid = $price_b["max"];
					   }
					   else {
							$qbid = "-";
							$bid = "-";
						   
					   }
					   $update_best_limit = "UPDATE order_book_options_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."'  Where `expiry`='".$expiry."' AND `strike`='".$strike."' AND `c/p`='".$c_p."' AND `dsymbol`='".$dsymbol."'";
					   $status_best_limit = $this->db3->query($update_best_limit);
					   $update_dashboard_options = "UPDATE dashboard Set `qbid` = '".$qbid. "' , `bid` ='". $bid."', `time`='".$datetime."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
					   $status_dashboard_options = $this->db3->query($update_dashboard_options);
					}
			   
			   $sql = "INSERT INTO vdm_order_options_daily (
					   `id_user`, `datetime`, `dsymbol`, `product`, `order_type`, `order_method`, `model`, `expiry`, `b/s`, interest, dividend, price, quantity,status, deadline, strike, `c/p`, `type` )
					   VALUES ('{$id_user}','{$datetime}','{$dsymbol}','{$dsymbol}','{$order_type}','{$method_type}','{$model}','{$expiry}','{$b_s}','{$interest}','{$dividend}',NULL,'{$quantity_val}',0, '{$deadline}', '{$strike}', '{$c_p}','{$c_p}');";				   
			   $result = $this->db3->query($sql);
			   //print_r($status);exit;
			   $id = $this->db->insert_id();
			   if($result>0){
					$sql1 = "INSERT INTO order_book_options_deep(
					   id, id_user, `datetime`, dsymbol, expiry, `b/s`, p, q, market_order,status, deadline, strike, `c/p` )
					   VALUES ('{$id}','{$id_user}','{$datetime}','{$dsymbol}', '{$expiry}','{$b_s}', NULL,'{$quantity_val}','{$market_order}',0,'{$deadline}','{$strike}','{$c_p}');
					   ";
				   $result1 = $this->db3->query($sql1);
			   }  
		   
	   
		}
		$this->update_fut_summary($id_user,1,0,1);
       $this->insert_summary_actions_options();    

	   return $result1;
       
    }
	
	
	
	function insert_daily_options_backup(){
		
		//echo "<pre>";print_r($_REQUEST);exit; 
		
		$id_user = 	$_REQUEST['input_id_user'];
		$datetime = $_REQUEST['input_datetime'];
		$order_type = $_REQUEST['input_order_type'];
		$method_type = $_REQUEST['input_order_method'];
		$model = $_REQUEST['input_model'];
		$expiry = $_REQUEST['input_expiry'];
		$b_s =$_REQUEST['input_buy_sell'];
		$interest = $_REQUEST['input_interest'];
		$dividend = $_REQUEST['input_dividend'];
		$price = str_replace(',','',$_REQUEST['input_price']);
		$quantity_val = $_REQUEST['input_quatity'];
		$deadline = $_REQUEST['input_deadline'];
		$dsymbol = $_REQUEST['input_dsymbol'];
		$volatility = $_REQUEST['input_volatility'];
		$c_p = $_REQUEST['input_c_p'];
		$strike = $_REQUEST['strike'];
	   //var_export($price);die();
		
		
		//var_export($price);die();
	   $price=floatval(str_replace(',','',$price));
       
       if(str_replace(' ','',strtolower($method_type))=='goodtodate'){$method = 'GTD';}else if(str_replace(' ','',strtolower($method_type))=='goodtoexpiry'){$method = 'GTE';}else if(str_replace(' ','',strtolower($method_type))=='goodtillcancelled'){$method = 'GTC';}else{$method = 'LOD';};
	   $market_order = $order_type == 'Market order' ? "FOK" : $method;
	   $b_s = substr($b_s, 0, 1);
       $result1 = array();
	   //
       $sql = 'select * from order_book_options_best_limit where `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `c/p`="'.$c_p.'" and `strike`="'.$strike.'" Limit 1';
	   $best_limit = $this->db->query($sql)->row_array();

	   
	   if($market_order !='FOK'){
	       if($price!=0){
		  
		
		   if(!isset($best_limit['id'])){
			   
			   $status = $quantity_val;
			   $status_limit = 1;
			   // Neu $b_s = B Thi bid = $price,qask = -, ask = -
			  if($b_s=="B"){
				  $insert_best_limit = "INSERT INTO order_book_options_best_limit (
					   `expiry`,`qbid`,`bid`,`ask`,`qask`,`dsymbol`, `c/p`, `strike`)
					   VALUES ('".$expiry."','".$quantity_val."','".$price."','-', '-','".$dsymbol."','".$c_p."','".$strike."');";
					   
				  $status_best_limit = $this->db->query($insert_best_limit);
				  $update_dashboard = "UPDATE dashboard Set `qbid` = '".$quantity_val."' , `bid`='".$price."' , `qask` = '-' , `ask` ='-', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
				  $status_dashboard = $this->db->query($update_dashboard);
			   }
			    // Neu $b_s = - Thi bid = $price,qask = $quantity_val, ask = -
			   else {
				   $insert_best_limit = "INSERT INTO order_book_options_best_limit (
				   `expiry`,`qbid`,`bid`,`qask`,`ask`,`dsymbol`, `c/p`, `strike`)
				   VALUES ('".$expiry."','-','-','".$quantity_val."','".$price."','".$dsymbol."','".$c_p."','".$strike."');";
				   
				   $status_best_limit = $this->db->query($insert_best_limit);
				   $update_dashboard = "UPDATE dashboard Set `qbid` = '-' , `bid`='-' , `qask` = '".$quantity_val."' , `ask` ='".$price."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
				  $status_dashboard = $this->db->query($update_dashboard);
			   }
						   
		   }
		   else {
		   
			   if($b_s=="B"){
				    	
				   if(($best_limit['ask']>0) && (floatval(str_replace(',','',$best_limit['ask']))<=$price)){
					 				   
					   $sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'"  and `b/s`="S" and `p` <="'.$price.'" and `status` >0 Order by `p` ASC, `datetime` ASC';
					   $arr_limit_s = $this->db->query($sql_best_limit_s)->result_array();
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
						   $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep = $this->db->query($update_deep);
						   $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
				  		   $status_update_deep = $this->db->query($update_deep);
						   $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						  
						  $status_excu_trade_s = $this->db->query($insert_excu_trade_s);
						  //get last
						  $sql_last = 'select * from dashboard where `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'"  and `strike`="'.$best_limit_s['strike'].'"  and type = "'.$c_p.'" Limit 1';
		   				  $q_last = $this->db->query($sql_last)->row_array();
						  if(isset($q_last['psettle']) && $q_last['psettle'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
						  }
		   				  else {
							  $var="`var`=NULL ";
							  $change="`change`=NULL ";	
						  }
						  $update_dashboard = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike = '".$best_limit_s['strike']."'  and type = '".$c_p."'";
				  		  $status_dashboard = $this->db->query($update_dashboard);
						  $i += $best_limit_s["status"];
						 
                          $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);						
					   }				   													   
				   }
				   else {
					
					    $status = $quantity_val;
				   }
				    //echo "<pre>";print_r('tao teo ne!');exit; 
			   }
			   else {
				   // echo "<pre>";print_r('ti la tao!');exit; 
				  if(($best_limit['bid']!='-') && (floatval(str_replace(',','',$best_limit['bid']))>=$price)){					   
					   $sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `c/p`="'.$c_p.'" and `strike`="'.$strike.'" and `b/s`="B" and `p` >="'.$price.'" and `status` >0 Order by `p` DESC, `datetime` ASC';
					   $arr_limit_s = $this->db->query($sql_best_limit_s)->result_array();
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
						   $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep = $this->db->query($update_deep);
						   $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
					  	   $status_update_deep = $this->db->query($update_deep);
						   $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						   
							$status_excu_trade_s = $this->db->query($insert_excu_trade_s);
							$sql_last = 'select * from dashboard where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and `strike`="'.$best_limit_s['strike'].'" and type = "'.$best_limit_s['c/p'].'" Limit 1';
		   				  $q_last = $this->db->query($sql_last)->row_array();
						  if($q_last['psettle'] >0 ) {
						  	$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
							$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
						  }
		   				  else {
							  $var="`var`=NULL ";	
							  $change="`change`=NULL ";	
						  }
						  $update_dashboard = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike='".$best_limit_s['strike']."' and type = '".$best_limit_s['c/p']."'";
				  		  $status_dashboard = $this->db->query($update_dashboard);
							$i += $best_limit_s["status"];	
							
                            $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);			
					   }				   													   
				   }
				   else {
					    $status = $quantity_val;
				   }
			   
				}	
		   }
		   
		   
			  $sql = "INSERT INTO vdm_order_options_daily( id_user, datetime, product, `type`, order_type, order_method, model, expiry, `b/s`, interest, dividend, price, quantity, status, volatility, strike, deadline,dsymbol, `c/p`)
				   VALUES ('{$id_user}','{$datetime}','{$dsymbol}','{$c_p}','{$order_type}','{$method_type}','{$model}','{$expiry}','{$b_s}','{$interest}','{$dividend}','{$price}','{$quantity_val}', '{$status}','{$volatility}','{$strike}','{$deadline}','{$dsymbol}','{$c_p}')";
		   $result = $this->db->query($sql);
		   //echo "<pre>";print_r($sql);exit;
		   // insert order_book_option_deep
		   $id = $this->db->insert_id();
		  // echo "<pre>";print_r($id);exit;
		  // if($result == true){
				//$this->update_opt_summary($id_user,1,0,1);
		   //}
		   if($result>0){
				$sql1 = "INSERT INTO order_book_options_deep (
				   id, id_user, `datetime`, dsymbol, expiry, `b/s`, p, q, market_order,status, deadline, `c/p`, `strike` )
				   VALUES ('{$id}','{$id_user}','{$datetime}','{$dsymbol}', '{$expiry}','{$b_s}', '{$price}','{$quantity_val}','{$market_order}','{$status}','{$deadline}','{$c_p}','{$strike}');
				   ";
			   $result1 = $this->db->query($sql1);
		   } 
	   
		  
		   $sql = 'select max(`p`) as max from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and status <>0';
		   $price_b = $this->db->query($sql)->row_array();
		   if(isset($price_b["max"])){
			   $sql = 'select sum(`status`) as qbid from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and `p`="'.$price_b["max"].'" and status <>0';
			   $sum = $this->db->query($sql)->row_array();
			   $qbid = $sum["qbid"];
			   $bid = $price_b["max"];
		   }
		   else {
				$qbid = "-";
				$bid = "-";				   
		   }
			$sql = 'select min(`p`) as min from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and status <>0';
			   $price_s = $this->db->query($sql)->row_array();
			   if(isset($price_s["min"])){
				   $sql = 'select sum(`status`) as qask from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
				   $sum = $this->db->query($sql)->row_array();
				   $qask = $sum["qask"];
				   $ask = $price_s["min"];
			   }
			   else {
					$qask = "-";
					$ask = "-";				   
			   }
			    $update_best_limit = "UPDATE order_book_options_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry."' AND `dsymbol`='".$dsymbol."' AND `strike`='".$strike."' AND `c/p`='".$c_p."'";
				$status_best_limit = $this->db->query($update_best_limit);
				 $update_dashboard = "UPDATE dashboard Set `qbid` = '".$qbid."' , `bid`='".$bid."' , `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
				 $status_dashboard = $this->db->query($update_dashboard);
            }
		    
	   }
	   else {
		   
		   
		   
				if($b_s=="B"){
						//sell
					   $sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `c/p`="'.$c_p.'" and `strike`="'.$strike.'" and `b/s`="S" and `status` <> 0 Order by `p` ASC,`datetime` ASC';
					   $arr_limit_s = $this->db->query($sql_best_limit_s)->result_array();
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
						  $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						  $status_update_deep = $this->db->query($update_deep);
						  $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						  $status_update_deep = $this->db->query($update_deep);
						  $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						   
						  $status_excu_trade_s = $this->db->query($insert_excu_trade_s);
						  $sql_last = 'select * from dashboard where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and `strike`="'.$best_limit_s['strike'].'" and type = "'.$best_limit_s['c/p'].'" Limit 1';
							  $q_last = $this->db->query($sql_last)->row_array();
							  if($q_last['psettle'] >0 ) {
								$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
								$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
							  }
							  else {
								  $var="`var`=NULL ";
								  $change = "`change`=NULL ";	
							  }
							  $update_dashboard_options = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ". $change. " ,`time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike='".$best_limit_s['strike']."' and type = '".$best_limit_s['c/p']."'";
							  $status_dashboard_options = $this->db->query($update_dashboard_options);
						  $i += $best_limit_s["status"];
						  $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);
												
					   }
					   $sql = 'select min(`p`) as min from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and status <>0';
					   $price_s = $this->db->query($sql)->row_array();
					   if(isset($price_s["min"])&&$price_s["min"]!=0){
						   $sql = 'select sum(`status`) as qask from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="S" and `p`="'.$price_s["min"].'" and status <>0';
						   $sum = $this->db->query($sql)->row_array();
						   $qask = $sum["qask"];
						   $ask = $price_s["min"];
					   }
					   else {
							$qask = "-";
							$ask = "-";
					   }
					   $update_best_limit = "UPDATE order_book_options_best_limit Set `qask` = '".$qask. "' , `ask` ='". $ask."' Where `expiry`='".$expiry."' AND `strike`='".$strike."' AND `c/p`='".$c_p."' AND `dsymbol`='".$dsymbol."'";
					   $status_best_limit = $this->db->query($update_best_limit);
					   $update_dashboard_options = "UPDATE dashboard Set `qask` = '".$qask. "' , `ask` ='". $ask."', `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
					  $status_dashboard_options = $this->db->query($update_dashboard_options);
				   }
				else {
						$sql_best_limit_s = 'select * from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and `status` > 0 Order by `p` DESC ,`datetime` ASC';
						$arr_limit_s = $this->db->query($sql_best_limit_s)->result_array();
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
						   $update_deep = "UPDATE order_book_options_deep Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						   $status_update_deep = $this->db->query($update_deep);
						   $update_deep = "UPDATE vdm_order_options_daily Set `status` = ".($best_limit_s["status"]-$insert_q)." Where id=".$best_limit_s["id"];
						   $status_update_deep = $this->db->query($update_deep);
						   $insert_excu_trade_s = "INSERT INTO excution_traded_options (`user_buy`,`user_sell`,`expiry`,`p`,`q`,`datetime`,`dsymbol`,`type`,`specs`, `c/p`, `strike`) VALUES (".$id_user.",".$best_limit_s['id_user'].",'".$best_limit_s['expiry']."','".$best_limit_s["p"]."','".$insert_q."', '".$datetime."','".$best_limit_s['dsymbol']."','OPTIONS','".date('M-Y',strtotime($best_limit_s['expiry']))."','".$best_limit_s['c/p']."',".$best_limit_s['strike']."); ";
						  
						  $status_excu_trade_s = $this->db->query($insert_excu_trade_s);
						  $sql_last = 'select * from dashboard where  `expiry`="'.$best_limit_s['expiry'].'" and `dsymbol`="'.$best_limit_s['dsymbol'].'" and `strike`="'.$best_limit_s['strike'].'" and type = "'.$best_limit_s['c/p'].'" Limit 1';
							  $q_last = $this->db->query($sql_last)->row_array();
							  if($q_last['psettle'] >0 ) {
								$var = "`var`=".(100*($best_limit_s['p']-$q_last['psettle'])/$q_last['psettle']);
								$change = "`change`=".($best_limit_s['p']-$q_last['psettle']);
							  }
							  else {
								  $var="`var`=NULL ";	
								  $change = " `change`=NULL";
							  }
							  $update_dashboard_options = "UPDATE dashboard Set `last` = '".$best_limit_s['p']."', ".$var.", ".$change.", `time`='".date('Y-m-d H:i:s',strtotime($datetime))."' Where expiry='".$best_limit_s['expiry']."' and dsymbol='".$best_limit_s['dsymbol']."' and strike='".$best_limit_s['strike']."' and type = '".$best_limit_s['c/p']."'";
							  $status_dashboard_options = $this->db->query($update_dashboard_options);
						  
						  $i += $best_limit_s["status"];
						  $this->update_dashboard_options_table($best_limit_s['expiry'],$best_limit_s['dsymbol'],$c_p, $strike);											
					   }
					   $sql = 'select max(`p`) as max from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B"  and status <>0';
					   $price_b = $this->db->query($sql)->row_array();
					   if(isset($price_b["max"])&&$price_b["max"]!=0){
						   $sql = 'select sum(`status`) as qbid from order_book_options_deep where  `expiry`="'.$expiry.'" and `dsymbol`="'.$dsymbol.'" and `strike`="'.$strike.'" and `c/p`="'.$c_p.'" and `b/s`="B" and `p`="'.$price_b["max"].'"  and status <>0';
						   $sum = $this->db->query($sql)->row_array();
						   $qbid = $sum["qbid"];
						   $bid = $price_b["max"];
					   }
					   else {
							$qbid = "-";
							$bid = "-";
						   
					   }
					   $update_best_limit = "UPDATE order_book_options_best_limit Set `qbid` = '".$qbid."' , `bid`='".$bid."'  Where `expiry`='".$expiry."' AND `strike`='".$strike."' AND `c/p`='".$c_p."' AND `dsymbol`='".$dsymbol."'";
					   $status_best_limit = $this->db->query($update_best_limit);
					   $update_dashboard_options = "UPDATE dashboard Set `qbid` = '".$qbid. "' , `bid` ='". $bid."', `time`='".$datetime."' Where expiry='".$expiry."' and dsymbol='".$dsymbol."' and strike='".$strike."' and type = '".$c_p."'";
					   $status_dashboard_options = $this->db->query($update_dashboard_options);
					}
			   
			   $sql = "INSERT INTO vdm_order_options_daily (
					   `id_user`, `datetime`, `dsymbol`, `product`, `order_type`, `order_method`, `model`, `expiry`, `b/s`, interest, dividend, price, quantity,status, deadline, strike, `c/p`, `type` )
					   VALUES ('{$id_user}','{$datetime}','{$dsymbol}','{$dsymbol}','{$order_type}','{$method_type}','{$model}','{$expiry}','{$b_s}','{$interest}','{$dividend}',NULL,'{$quantity_val}',0, '{$deadline}', '{$strike}', '{$c_p}','{$c_p}');";				   
			   $result = $this->db->query($sql);
			   //print_r($status);exit;
			   $id = $this->db->insert_id();
			   if($result>0){
					$sql1 = "INSERT INTO order_book_options_deep(
					   id, id_user, `datetime`, dsymbol, expiry, `b/s`, p, q, market_order,status, deadline, strike, `c/p` )
					   VALUES ('{$id}','{$id_user}','{$datetime}','{$dsymbol}', '{$expiry}','{$b_s}', NULL,'{$quantity_val}','{$market_order}',0,'{$deadline}','{$strike}','{$c_p}');
					   ";
				   $result1 = $this->db->query($sql1);
			   }  
		   
	   
		}
		$this->update_fut_summary($id_user,1,0,1);
       $this->insert_summary_actions_options();    

	   return $result1;
       
    }
	
	
	
	
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
	
	
	function update_dashboard_options_table($expiry, $dsymbol, $c_p, $strike)
    {
        $sqlv= "SELECT sum(q) as dvolume FROM excution_traded_options WHERE `expiry`='$expiry' and `dsymbol`='$dsymbol' and `c/p` = '$c_p' and `strike` = '$strike' and DAY(`datetime`) ='".date('d')."'";
        $dvolume = $this->db3->query($sqlv)->row_array();
        $sqldv= "SELECT q as volume FROM excution_traded_options WHERE `expiry`='$expiry' and `dsymbol`='$dsymbol' and `c/p` = '$c_p' and `strike` = '$strike' and DAY(`datetime`) ='".date('d')."' ORDER BY `datetime` desc LIMIT 1";
		
        $volume = $this->db3->query($sqldv)->row_array();
        $update_df = "UPDATE dashboard Set `volume` = '".$volume['volume']."', `dvolume` = '".$dvolume['dvolume']."' Where `expiry`='".$expiry."' and `dsymbol`='".$dsymbol."' and `type` = '$c_p' and `strike` = '$strike'";
		$status_update_df = $this->db3->query($update_df);
        //$sql = "SELECT * FROM dashboard_future WHERE `expiry`='".$expiry."' and `product`='".$product."' and `type`='FUTURES'";
        
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
	
	
	
	
	function insert_summary_actions(){
      //  $sql_ ='TRUNCATE summary;';
	  //  $truncate = $this->db->query($sql_);
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
	function insert_summary_actions_options(){
      //  $sql_ ='TRUNCATE summary;';
	  //  $truncate = $this->db->query($sql_);
        $sql = 'select * from order_book_options_deep';
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
        $sql1 = 'select * from excution_traded_options';
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
	
	public function useronline(){
		$jq_table = "SELECT lu.*,vus.*,lpf.label,lp.profile_value
                    FROM login_users lu 
                    LEFT JOIN vdm_user_summary vus ON vus.id_user = lu.user_id 
                    LEFT JOIN login_profiles lp ON lu.user_id = lp.user_id 
                    LEFT JOIN login_profile_fields lpf ON lp.pfield_id = lpf.id
                    WHERE lu.last_login > ".strtotime('-2 hour', time())."";
		$page = $_REQUEST['page']; 
		
		$data = $this->db3->query($jq_table)->result_array();
		//echo "<pre>";print_r($data);exit;
		$dupme = array();
		if(!empty($data)){
			foreach($data as $k=>$dupma){
				$dupme[$dupma['user_id']]['user_id'] = $dupma['user_id'];
				if(isset($dupma['avatar']) && ($dupma['avatar'] == '' || $dupma['avatar'] == 'null' || !file_exists($dupma['avatar']))){
					$dupme[$dupma['user_id']]['avatar'] = 'assets/upload/avatar/no_avatar.jpg';
				}else{
					$dupme[$dupma['user_id']]['avatar'] = $dupma['avatar'];
				}
				$dupme[$dupma['user_id']]['email'] = $dupma['email'];
				$dupme[$dupma['user_id']]['perform'] = $dupma['perform'];
				$dupme[$dupma['user_id']]['initial'] = $dupma['initial'];
				$dupme[$dupma['user_id']]['cur_value'] = $dupma['cur_value'];
				$dupme[$dupma['user_id']]['opt_nb_ord'] = $dupma['opt_nb_ord'];
				$dupme[$dupma['user_id']]['opt_nb_trd'] = $dupma['opt_nb_trd'];
				$dupme[$dupma['user_id']]['opt_volume'] = $dupma['opt_volume'];
				$dupme[$dupma['user_id']]['fut_nb_ord'] = $dupma['fut_nb_ord'];
				$dupme[$dupma['user_id']]['fut_nb_trd'] = $dupma['fut_nb_trd'];
				$dupme[$dupma['user_id']]['fut_volume'] = $dupma['fut_volume'];
				
				$dupme[$dupma['user_id']][$dupma['label']] = $dupma['profile_value'];	
			}
		}
			//echo "<pre>";print_r($dupme);exit;
			// get how many rows we want to have into the grid - rowNum parameter in the grid 
			$limit = $_REQUEST['rows']; 
			$sidx = $_REQUEST['sidx'];
			$filter_get = array(); 
			if(isset($_REQUEST['filter_get_all'])){
				$filter_get = json_decode($_REQUEST['filter_get_all']);
			}
			// get index row - i.e. user click to sort. At first time sortname parameter -
			// after that the index from colModel 
			// sorting order - at first time sortorder 
		
			if(!$sidx) $sidx =1;
			 $this->load->model('jq_loadtable_model');
			 $sord = $_REQUEST['sord'];
			$filter = $_REQUEST;
			// Vong lap nay dung de filter
		
			foreach($dupme as $key=>$value){
				foreach($value as $k=>$v){
					if(isset($filter[$k]) && stristr($value[$k],$filter[$k]) == false){
						unset($dupme[$key]);	
					}	
				}
			}
			if(count($dupme) > 0){
				foreach($dupme as $val){
					$result[] = $val;
				}
			}
			else{
				$result	=array();
			}
			// khi lick sort tren header sort by array multi
			$sidx = 'email';	
			
			
			$this->aasort($result,$sidx,$sord);
			
			
		
		$data = $this->jq_loadtable_model->getTableUseronline($page,$limit,$sord,$sidx,$filter,$filter_get,$result);
		//echo "<pre>";print_r('hung');exit;
		echo json_encode($data);
		
	}
	public function aasort(&$array, $key, $sord) {
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		if($sord == 'desc'){
			arsort($sorter);
		}
		else{
			asort($sorter);	
		}
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
	}
    

      
}
