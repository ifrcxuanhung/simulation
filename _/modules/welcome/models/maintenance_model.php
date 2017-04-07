<?php
class Maintenance_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function getdata()
    {
        $sql="select * from vdm_maintenance order by id asc";
        $data = $this->db->query($sql)->result_array();
       // print_R($data);exit;
        return $data;  
    }
    

}