<?php
class Verification_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function getdata()
    {
        $sql="select * from simul_verification order by id asc";
        $data = $this->db->query($sql)->result_array();
       // print_R($data);exit;
        return $data;  
    }
    public function getquery()
    {
        $sql="select * from simul_query where active=1 order by id asc";
        $data = $this->db->query($sql)->result_array();
       // print_R($data);exit;
        return $data;  
    }
    

}