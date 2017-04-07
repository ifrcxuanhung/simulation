<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Marketmaking extends Welcome {
    function __construct() {
        parent::__construct();
		$this->load->model('jq_loadtable_model');
		$this->load->model('jq_loadtable_vndmi_model');
		 $this->load->model('dashboard_model','dashboard');
    }
    
    function index() {
	
		$this->data->value2 = $this->db3->get_where('setting', array('group' => 'setting','key'=>'market_making_futures'))->row_array();
		
		
		// JQ GRID
		$tables = 'vdm_contracts_ref';
		$tables2 = 'vdm_contracts_setting';
		$check_summary = $this->jq_loadtable_model->getSummary($tables);
		$check_summary2 = $this->jq_loadtable_model->getSummary($tables2);
			$check_summary_vndmi = $this->jq_loadtable_vndmi_model->get_summary_des($tables);
			$check_summary_vndmi2 = $this->jq_loadtable_vndmi_model->get_summary_des($tables2);
          
                $get_summary = $this->db->select('`user_level`')->where('table_name',$tables)->get('efrc_summary')->row_array();
				 $get_summary2 = $this->db->select('`user_level`')->where('table_name',$tables2)->get('efrc_summary')->row_array();
            
        	//	echo "<pre>";print_r($check_summary);exit;
			//if ($this->db->table_exists($tables) && $this->session->userdata('user_level') >= $get_summary['user_level'])
			if($check_summary_vndmi['vndmi'] == 1){
				
					// export theo tung dinh dang file
        				/*if(isset($_REQUEST['actexport'])&&($_REQUEST['actexport']=='exportCsv'||$_REQUEST['actexport']=='exportTxt')){
        					$this->export();
        				}
        				else if(isset($_REQUEST['actexport'])&&($_REQUEST['actexport']=='exportXls')){
        					$this->exportXls();
        				}*/
        				//end export theo tung dinh dang file
        				
        				$this->data->table = $tables;
        				 $this->load->model('jq_loadtable_vndmi_model');
        				 //Kiem tra neu co mother_jq trong summary thi lay format theo cot nay, nguoc lai lay theo cot table name
        				$mother_jq = $this->db->select('mother_jq')->where('table_name',$tables)->get('efrc_summary')->row_array();
                        //print_R($mother_jq);exit;
        				if(isset($mother_jq['mother_jq']) && $mother_jq['mother_jq'] != ''){
        					$column = $this->jq_loadtable_vndmi_model->js_sys_format($mother_jq['mother_jq']);
        				}else{
        					$column = $this->jq_loadtable_vndmi_model->js_sys_format($tables);	
        				}
					
        				//kiem tra cot trong sys co trong table hay khong
        				$select_column = $this->db3->list_fields($tables);
						
        				// Bien nay kiem tra xem cac cot trong sys co trong table ko, neu khong thi tra ra loi
        				$error = array();
        				foreach($column as $k=>$val_column){
        					if($val_column['searchoptions'] == 'select'){
        						$column[$k]['stype'] = "select";	
        						//get select
        						if(in_array($val_column['name'], $select_column)){
        							$this->db3->select($val_column['name']);
        							$this->db3->distinct();
        							$this->db3->order_by($val_column['name'],"ASC");
        						
        							$query = $this->db3->get($tables);
        							$data = $query->result_array();
        						}
        						else{
        							$data = array();
        							$error[] = 	$val_column['name'];
        						}
        						$result='';
        						
        						foreach($data as $key=>$v){
        							if($v[$val_column['name']] == '' || $v[$val_column['name']] == ' '){
        								unset($data[$key]);
        							}else{
        								
        								$result.= $v[$val_column['name']].":".$v[$val_column['name']].";";
        								
        							}
        							
        						}
        						//
        						$column[$k]['selectlist'] = json_encode($result);
        						
        						
        					}
        					if($val_column['hidden'] == 'false'){
        						unset($column[$k]['hidden']);	
        					}
        					$column[$k]['headertitles'] = "";
        					$column[$k]['editable']='false';
        					
        				}
        				
        				$this->data->column =json_encode($column);
        				$this->data->error =json_encode($error);
        				 
        				 // get list neu searchoptions =1 
        		
        			
        				
        				if(isset($_GET))
        					$this->data->filter_get_all = json_encode($_GET);
        				
        				
        				$this->data->summary_des = $this->jq_loadtable_vndmi_model->get_summary_des($tables);
        				
        				
        			
						
				}
				
				if($check_summary_vndmi2['vndmi'] == 1){
				
        				$this->data->table2 = $tables2;
        				 $this->load->model('jq_loadtable_vndmi_model');
        				 //Kiem tra neu co mother_jq trong summary thi lay format theo cot nay, nguoc lai lay theo cot table name
        				$mother_jq = $this->db->select('mother_jq')->where('table_name',$tables2)->get('efrc_summary')->row_array();
						
						
                        //print_R($mother_jq);exit;
        				if(isset($mother_jq['mother_jq']) && $mother_jq['mother_jq'] != ''){
        					$column2 = $this->jq_loadtable_vndmi_model->js_sys_format($mother_jq['mother_jq']);
        				}else{
        					$column2 = $this->jq_loadtable_vndmi_model->js_sys_format($tables2);	
							
        				}
					
        				//kiem tra cot trong sys co trong table hay khong
        				$select_column2 = $this->db3->list_fields($tables2);
						
        				// Bien nay kiem tra xem cac cot trong sys co trong table ko, neu khong thi tra ra loi
        				$error2 = array();
        				foreach($column2 as $k2=>$val_column2){
        					if($val_column2['searchoptions'] == 'select'){
        						$column2[$k2]['stype'] = "select";	
        						//get select
        						if(in_array($val_column2['name'], $select_column2)){
        							$this->db3->select($val_column2['name']);
        							$this->db3->distinct();
        							$this->db3->order_by($val_column2['name'],"ASC");
        						
        							$query2 = $this->db3->get($tables2);
        							$data2 = $query2->result_array();
        						}
        						else{
        							$data2 = array();
        							$error2[] = $val_column2['name'];
        						}
        						$result2='';
        						
        						foreach($data2 as $key2=>$v2){
        							if($v2[$val_column2['name']] == '' || $v2[$val_column2['name']] == ' '){
        								unset($data2[$key2]);
        							}else{
        								
        								$result2.= $v2[$val_column2['name']].":".$v2[$val_column2['name']].";";
        								
        							}
        							
        						}
        						//
        						$column2[$k2]['selectlist'] = json_encode($result2);
        						
        						
        					}
        					if($val_column2['hidden'] == 'false'){
        						unset($column2[$k2]['hidden']);	
        					}
        					$column2[$k2]['headertitles'] = "";
        					$column2[$k2]['editable']='false';
        					
        				}
        				
        				$this->data->column2 =json_encode($column2);
						
        				$this->data->error2 =json_encode($error2);
        				 // get list neu searchoptions =1 
        		
        			
        				
        				if(isset($_GET))
        					$this->data->filter_get_all = json_encode($_GET);
        				
        				
        				$this->data->summary_des2 = $this->jq_loadtable_vndmi_model->get_summary_des($tables2);		
				}
        		
				$this->template->write_view('content', 'marketmaking', $this->data);
				$this->template->render();
		
		
       
    }
	
	function order_by_contract_setting(){
        $array = $this->db3->query("Select a.* FROM (SELECT * FROM market_temp WHERE `user_id` = 1 ORDER BY expiry ASC) a GROUP BY dsymbol")->result_array();
       
        foreach($array as $value){
                $today = date('Y-m-d');
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
          $bid = $value['mid'];
			$ask = $value['mid'];
			
			$this->dashboard->insert_daily_futures($user_id,$micro_date,$dsymbol,$order_type,$method_type,$expiry,'B',$bid,$value['qbid'],$type_theo,$R, $divident, $dead);
			$this->dashboard->insert_daily_futures($user_id,$micro_date,$dsymbol,$order_type,$method_type,$expiry,'S',$ask,$value['qask'],$type_theo,$R, $divident, $dead);
                  
                
            
        }
        echo true;
    }
	
	public function bid_ask_order(){
        $array = $this->db3->query("Select a.* FROM (SELECT * FROM market_temp WHERE `user_id` = 1 ORDER BY expiry ASC) a GROUP BY dsymbol")->result_array();
       
        foreach($array as $value){
                $today = date('Y-m-d');
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
			
			$this->dashboard->insert_daily_futures($user_id,$micro_date,$dsymbol,$order_type,$method_type,$expiry,'B',$bid,$value['qbid'],$type_theo,$R, $divident, $dead);
			$this->dashboard->insert_daily_futures($user_id,$micro_date,$dsymbol,$order_type,$method_type,$expiry,'S',$ask,$value['qask'],$type_theo,$R, $divident, $dead);
                  
                
            
        }
        echo true;
    }

}