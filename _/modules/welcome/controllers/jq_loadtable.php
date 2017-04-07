<?php
class Jq_loadtable extends Welcome{
	
	public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('jq_loadtable_model');
			$this->load->model('jq_loadtable_vndmi_model');
	
		}
	public function index($tables){
			$check_summary = $this->jq_loadtable_model->getSummary($tables);
			$check_summary_vndmi = $this->jq_loadtable_vndmi_model->get_summary_des($tables);
			if($check_summary == true){
					 $get_summary = $this->db->select('`user_level`')->where('table_name',$tables)->get('efrc_summary')->row_array();
					//echo"<pre>"; print_r($get_summary);exit;
			if($check_summary_vndmi['vndmi'] == 1){
				$this->data->table = $tables;
				$this->load->model('jq_loadtable_vndmi_model');
				 //Kiem tra neu co mother_jq trong summary thi lay format theo cot nay, nguoc lai lay theo cot table name
				$mother_jq = $this->db->select('mother_jq')->where('table_name',$tables)->get('efrc_summary')->row_array();
				//print_R($mother_jq);exit;
				if(isset('mother_jq')) && $mother_jq['mother_jq'] != "");
				}
				
			}
				
		}	
	
	} 	 
?>