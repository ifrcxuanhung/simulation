<?php
class Jq_loadtable_vndmi_model extends CI_Model{
    protected $_lang;
    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->db3 = $this->load->database('database3', TRUE);
        $this->load->library('session');
		if(isset($_SESSION['curent_language'])){
        $this->_lang = $_SESSION['curent_language'];
		}else{
			$this->_lang = 'en';	
		}
    }
	

	public function getTable($page,$limit,$sord, $sidx, $filter,$filter_get ='',$jq_table){
		
		$array_get = array();
		$where = "where 1=1";
		$sql_count = "SELECT COUNT(*) AS count FROM $jq_table $where "; 
		//count filter
	
		// get field từ sysformat theo table
		$mother_jq = $this->db->select('mother_jq')->where('table_name',$jq_table)->get('efrc_summary')->row_array();
		if(isset($mother_jq['mother_jq']) && $mother_jq['mother_jq'] != ''){
			$table_sys = $this->js_sys_format($mother_jq['mother_jq']);
		}else{
			$table_sys = $this->js_sys_format($jq_table);	
		}
		foreach($table_sys as $val){
			if(isset($filter[$val['name']])){
				$val_filter_count = $filter[$val['name']];
				if($val['searchoptions'] == 'select'){
					$sql_count.=" and $val[name] = '$val_filter_count' ";
				}else{
					$sql_count.=" and $val[name] LIKE '%$val_filter_count%' ";
				}
			}
		}
		
	
		//count filter get tren url
		foreach($table_sys as $val){
			if(isset($filter_get->$val['name'])){
				$val_filter_url = $filter_get->$val['name'];
				if($val['searchoptions'] == 'select'){
					$sql_count.=" and $val[name] = '$val_filter_url' ";
				}else{
					$sql_count.=" and $val[name] LIKE '%$val_filter_url%' ";
				}
			}
		}
		
		$row = $this->db3->query($sql_count)->row_array();
		$count = $row['count'];
		
		// calculate the total pages for the query 
		
		if( $count > 0 && $limit > 0) { 
					  $total_pages = ceil($count/$limit); 
		} else { 
					  $total_pages = 0; 
		} 
		 if($count != 0){
			// if for some reasons the requested page is greater than the total 
			// set the requested page to total page 
			if ($page > $total_pages) $page=$total_pages;
			 
			// calculate the starting position of the rows 
			$start = $limit*$page - $limit;
			
			
		$sql = "SELECT * FROM $jq_table $where ";
		
		//filter
		foreach($table_sys as $val){
			if(isset($filter[$val['name']])){
				$val_filter = $filter[$val['name']];
				if($val['searchoptions'] == 'select'){
					$sql.=" and $val[name] = '$val_filter' ";
				}else{
					$sql.=" and $val[name] LIKE '%$val_filter%' ";
				}
			}
		}
		//filter get tu trên url xuong
		//count filter get tren url
		foreach($table_sys as $val){
			if(isset($filter_get->$val['name'])){
				$val_filter_url_2 = $filter_get->$val['name'];
				if($val['searchoptions'] == 'select'){
					$sql.=" and $val[name] = '$val_filter_url_2' ";
				}else{
					$sql.=" and $val[name] LIKE '%$val_filter_url_2%' ";
				}
			}
		}
		
		$sql.="ORDER BY $sidx $sord LIMIT $start , $limit";

		$data = array('records'=>$count,'page'=>$page,'total'=>$total_pages,'rows'=>$this->db3->query($sql)->result_array());
		  
				
	
			  return $data;
		 }
		 else{
			 $data = array('records'=> 0 ,'page'=> 0 ,'total'=> 0 ,'rows'=> 0);
			return $data; 
		}
	}
	
	
	public function get_summary_des($tables){
	
		$this->db->select('description,order_by,user_level,vndmi');
		$this->db->where('table_name', $tables); 
		$query = $this->db->get('efrc_summary');
		$result = $query->row_array();
		return $result;
	}
	
	public function js_sys_format($tables){
		
		$this->db->select('*');
		$this->db->where('tables', $tables);
		$this->db->where('active', 1); 
		$this->db->order_by('order', 'asc'); 
		$query = $this->db->get('jq_sys_format');
		$result = $query->result_array();
		return $result;
	}
	public function js_sys_format_active_short($tables){
		
		$this->db->select('*');
		$this->db->where('tables', $tables);
		$this->db->where('active', 1);
		$this->db->where('active_short', 1); 
		$this->db->order_by('order', 'asc'); 
		$query = $this->db->get('jq_sys_format');
		$result = $query->result_array();
		return $result;
	}
	public function get_tab($tab='') {
		$sql = "select *
                from efrc_summary 
				where table_name = '$tab'";
                //where tab = '$tab' and user_level <=".$this->session->userdata_vnefrc('user_level');
		 return $this->db->query($sql)->row_array();       
    }
	function gets_headers($table='',$field='') {
        $ids = array($table);
        $sql = "select *
                from jq_sys_format 
                where `tables` ='".$table."' order by `order` asc ";
       // print_R($sql);exit;
         return $this->db->query($sql)->result_array();
    }
	function gets_headersActive($table='',$field='') {
        $ids = array($table);
        $sql = "select *
                from jq_sys_format 
                where `tables` ='".$table."' AND `active` = 1 order by `order` asc ";
       // print_R($sql);exit;
         return $this->db->query($sql)->result_array();
    }
	function gets_headersActiveShort($table='',$field='') {
	
        $ids = array($table);
        $sql = "select *
                from jq_sys_format 
                where `tables` ='".$table."' and `active_short` = 1 order by `order` asc ";
         return $this->db->query($sql)->result_array();
    }
	function getSummary($table){
		$this->db->where('table_name',$table);
		$query = $this->db->get('efrc_summary');
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}	
	}

}

