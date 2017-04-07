<?php

class Useronline extends Welcome{

    public function __construct() {
        parent::__construct();
		$this->db3 = $this->load->database('database3', TRUE);
    }
    
    public function index() {
      
            if($this->session->userdata('user_level') && $this->session->userdata('user_level') >= 8){
    	    if(isset($_REQUEST['actexport'])&&($_REQUEST['actexport']=='exportCsv'||$_REQUEST['actexport']=='exportTxt')){
    			$this->exportUJQ();
    		}
    		else if(isset($_REQUEST['actexport'])&&($_REQUEST['actexport']=='exportXls')){
    			$this->exportXlsUJQ();
    		}
		   // JQ
		   $tables = 'useronline';
		   $this->data->table = $tables;
				
				
				$this->load->model('jq_loadtable_model');
				$column = $this->jq_loadtable_model->js_sys_format($tables);
				$jq_table = "SELECT lu.*,vus.*,lpf.label,lp.profile_value
                    FROM login_users lu 
                    LEFT JOIN vdm_user_summary vus ON vus.id_user = lu.user_id 
                    LEFT JOIN login_profiles lp ON lu.user_id = lp.user_id 
                    LEFT JOIN login_profile_fields lpf ON lp.pfield_id = lpf.id
                    WHERE lu.last_login > ".strtotime('-2 hour', time())."";
				$data = $this->db3->query($jq_table)->result_array();
			//echo "<pre>";print_r($column);exit;
			$dupme = array();
			if(!empty($data)){
				foreach($data as $k=>$dupma){
					$dupme[$dupma['user_id']]['user_id'] = $dupma['user_id'];
					$dupme[$dupma['user_id']]['avatar'] = $dupma['avatar'];
					$dupme[$dupma['user_id']]['email'] = $dupma['email'];
					
					$dupme[$dupma['user_id']][$dupma['label']] = $dupma['profile_value'];	
				}
			

				//$dupme = array_unique($dupme, SORT_REGULAR);
				// function super_unique dung de xoa phan tu trung, 'firstname la key can xoa'
				$dupme = $this->super_unique($dupme,'firstname');
			}
				foreach($column as $k=>$val_column){
					if($val_column['searchoptions'] == 'select'){
						$column[$k]['stype'] = "select";
						//get select
						//$this->db->select($val_column['name']);
						//$this->db->distinct();
						//$this->db->order_by($val_column['name'],"ASC");
					
						//$query = $this->db->get($val_column['tables']);
						//$data = $query->result_array();
						$result='';
						
						foreach($dupme as $key=>$v){
							if($v[$val_column['name']] == ''){
								unset($data[$key]);
							}else{
								
								$result.= $v[$val_column['name']].":".$v[$val_column['name']].";";
								
							}
							
						}
						$column[$k]['selectlist'] = json_encode($result);
						//end get select
						
					}
					if($val_column['hidden'] == 'false'){
						unset($column[$k]['hidden']);	
					}
					$column[$k]['headertitles'] = '';
					$column[$k]['format_notedit']='';
					$column[$k]['editable']='false';
					$column[$k]['cellattr'] = "" ;
					
				}
				//echo "<pre>";print_r($column);exit;
				 $this->data->column =json_encode($column);
				 // get list neu searchoptions =1 
		
				if(isset($_GET))
					$this->data->filter_get_all = json_encode($_GET);
				$this->data->summary_des = $this->jq_loadtable_model->get_summary_des($tables);
				
				$this->template->write_view('content', 'useronline',$this->data);
				$this->template->render();

        }else {
            $this->template->write_view('content', 'product/error', $this->data);
            $this->template->render();
            
        }
    }
	function super_unique($array,$key)
	{
	
	   $temp_array = array();
	
	   foreach ($array as &$v) {
	
		   if (!isset($temp_array[$v[$key]]))
	
		   $temp_array[$v[$key]] =& $v;
	
	   }
	
	   $array = array_values($temp_array);
	
	   return $array;
	
	
	
	}
    
    	function exportUJQ() {
	 //  print_R('111111111111');
		$tables = 'useronline';
	//	//print_r($table);exit;
//		$arr_table_sys = $this->table->get_tab($table);
//		
//		$table_sys = isset($arr_table_sys["tables"]) ? $arr_table_sys["tables"] : $table;
//		$headers = $this->table->gets_headers($table_sys);
//		
    	$this->load->model('jq_loadtable_model');
		$column = $this->jq_loadtable_model->js_sys_format($tables);
		$jq_table = "SELECT lu.*,vus.*,lpf.label,lp.profile_value
                    FROM login_users lu 
                    LEFT JOIN vdm_user_summary vus ON vus.id_user = lu.user_id 
                    LEFT JOIN login_profiles lp ON lu.user_id = lp.user_id 
                    LEFT JOIN login_profile_fields lpf ON lp.pfield_id = lpf.id
                    WHERE lu.last_login > ".strtotime('-2 hour', time())."";
		$data = $this->db3->query($jq_table)->result_array();
//echo "<pre>";print_r($data);exit;
		foreach($data as $k=>$dupma){
			$dupme[$dupma['user_id']]['user_id'] = $dupma['user_id'];
			$dupme[$dupma['user_id']]['avatar'] = $dupma['avatar'];
			$dupme[$dupma['user_id']]['email'] = $dupma['email'];
			$dupme[$dupma['user_id']][$dupma['label']] = $dupma['profile_value'];	
		}
	
		//echo "<pre>";print_r($dupme);exit;
		//$dupme = array_unique($dupme, SORT_REGULAR);
		// function super_unique dung de xoa phan tu trung, 'firstname la key can xoa'
		$dupme = $this->super_unique($dupme,'firstname');
        // select columns
       // $where = "where 1=1";
     
        $aColumns = array();
		$aColumnsHeader = array();
		foreach ($dupme[0] as $key=>$item) {
			$aColumnsHeader[]=$key;
			$aColumns[] = $key;
		}
      //  echo "<pre>";print_r($aColumnsHeader);exit;
    //    unset($dupme);
      //  print_R($dupme);
        
	//	$sTable = $tables; //$category == 'all' ? "efrc_".$table : "(SELECT * FROM efrc_".$table." where category = '".$category."') as sTable " ;
//		
//		
//		
//		 //$order_by = (($arr_table_sys['order']!='') && (!is_null($arr_table_sys['order'])))?('order by '.$arr_table_sys['order']):'';
//		if(is_null($arr_table_sys['limit_export'])){
//			$sql = "select sql_calc_found_rows " . str_replace(' , ', ' ', implode(', ', $aColumns)) . "
//    					from {$sTable} {$where};"; 
//						
//			
//		}
//		else {
//			
//			//$level = 0;
//		//$arrlimit = explode(";",$arr_table_sys['limit_export']);
//		//$limit = isset($arrlimit[$level]) ? $arrlimit[$level] :10;
//		/*$sql = "select sql_calc_found_rows " . str_replace(' , ', ' ', implode(', ', $aColumns)) . "
//                from {$sTable} {$where} {$order_by} limit {$limit};";*/
//		$sql = "select sql_calc_found_rows " . str_replace(' , ', ' ', implode(', ', $aColumns)) . "
//                from {$sTable} {$where};";
//		}
        $this->load->dbutil();
       // $query = $this->db->query($sql)->result_array();
	
		if(isset($_REQUEST['actexport'])&&($_REQUEST['actexport']=='exportCsv')){
		$this->dbutil->export_to_csv("{$tables}", $dupme, $aColumnsHeader, null,",", true);
		}
		else if(isset($_REQUEST['actexport'])&&($_REQUEST['actexport']=='exportTxt')){
			
		$this->dbutil->export_to_txt("{$tables}", $dupme, $aColumnsHeader, null,chr(9), true);
		}		
		die();
		
    }
    public function exportXlsUJQ(){
		$table = 'useronline';
		$content = file_get_contents(base_url().'assets/download/tab_xls.php');
		$content = $this->bodyReportUJQ($content,$table);
		header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
		header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
		header ( "Pragma: no-cache" );
		header ( "Content-type: application/msexcel");
		header ( "Content-Disposition: inline; filename=\"{$table}_".date("dmYhi").".xls\"");
		print($content);
		die();
	}
    function bodyReportUJQ($content,$tab_name){
	//	$tab = $this->table->get_tab($tab_name);	
//		$table_sys = isset($tab["table_name"]) ? $tab["table_name"] : $tab_name;
//		$headers = $this->table->gets_headers($tab['table_name'],$tab['query']);
		
		$table_sys = 'useronline';
		$this->load->dbutil();
		$arrBody = $this->dbutil->PartitionString('<!--s_heading-->', '<!--e_heading-->', $content);
		$rowInfo = '';
        
        $this->load->model('jq_loadtable_model');
		$column = $this->jq_loadtable_model->js_sys_format($table_sys);
		$jq_table = "SELECT lu.*,vus.*,lpf.label,lp.profile_value
                    FROM login_users lu 
                    LEFT JOIN vdm_user_summary vus ON vus.id_user = lu.user_id 
                    LEFT JOIN login_profiles lp ON lu.user_id = lp.user_id 
                    LEFT JOIN login_profile_fields lpf ON lp.pfield_id = lpf.id
                    WHERE lu.last_login > ".strtotime('-2 hour', time())."";
		$data = $this->db3->query($jq_table)->result_array();
//echo "<pre>";print_r($data);exit;
		foreach($data as $k=>$dupma){
			$dupme[$dupma['user_id']]['user_id'] = $dupma['user_id'];
			$dupme[$dupma['user_id']]['avatar'] = $dupma['avatar'];
			$dupme[$dupma['user_id']]['email'] = $dupma['email'];
			$dupme[$dupma['user_id']][$dupma['label']] = $dupma['profile_value'];	
		}
	
		//echo "<pre>";print_r($dupme);exit;
		//$dupme = array_unique($dupme, SORT_REGULAR);
		// function super_unique dung de xoa phan tu trung, 'firstname la key can xoa'
		$dupme = $this->super_unique($dupme,'firstname');
        // select columns
       // $where = "where 1=1";
     
        $aColumns = array();
		$aColumnsHeader = array();
		foreach ($dupme[0] as $key=>$item) {
			$aColumnsHeader[]=$key;
			$aColumns[] = $key;
		}
        
        foreach ($dupme[0] as $item) {
			$rowInfo .=$arrBody[1];
			$rowInfo = str_replace('{width}', $item['width'], $rowInfo);
			$rowInfo = str_replace('{align}', $item['align'], $rowInfo);
			$rowInfo = str_replace('{title}', $item['label'], $rowInfo);
		}
		$content = $arrBody[0].$rowInfo.$arrBody[2];
		
		//$where = "where 1=1";
//		foreach ($headers as $item) {
//			$aColumns[] = $item['name'];
//		}
        
		$sTable = $table_sys; 
		
		// $order_by = (($tab['order']!='') && (!is_null($tab['order'])))?('order by '.$tab['order']):'';
		 
	//	if(is_null($tab['limit_export'])){
//        	$sql = "select sql_calc_found_rows " . str_replace(' , ', ' ', implode(', ', $aColumns)) . "
//                from {$sTable} {$where};";
//		}	
//		else {
//			
//		//$arrlimit = explode(";",$tab['limit_export']);
//		//$limit = isset($arrlimit[$level]) ? $arrlimit[$level] :10;
//		/*$sql = "select sql_calc_found_rows " . str_replace(' , ', ' ', implode(', ', $aColumns)) . "
//                from {$sTable} {$where} {$order_by} limit {$limit};";*/
//		$sql = "select sql_calc_found_rows " . str_replace(' , ', ' ', implode(', ', $aColumns)) . "
//                from {$sTable} {$where};";
//		}
     //   $data = $this->db->query($sql)->result_array();
		
		$arrBody = $this->dbutil->PartitionString('<!--s_body-->', '<!--e_body-->', $content);
		$rowInfo = '';
		$i= 0;
		foreach ($dupme as $key => $value) {
			$rowInfo .='<tr>';
            foreach($value as $item) {
               
				$rowInfo .=$arrBody[1];
				if ($i % 2) 
				$rowInfo = str_replace('{color}', '#f7f7f7', $rowInfo);
				else
				$rowInfo = str_replace('{color}', '#fffff', $rowInfo);
				
				$rowInfo = str_replace('{body}', '<div'.$item['align'].'>'.$value[strtolower($item['name'])].'</div>', $rowInfo);
				$i ++;
            }
			$rowInfo .='</tr>';
        }
		$content = $arrBody[0].$rowInfo.$arrBody[2];
		return $content;
	}
}