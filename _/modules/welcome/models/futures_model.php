<?php
class Futures_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function getSim_Account()
    {
        $sql="select `data`, `value`, cur from simul_account order by `order` asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
       // print_R($data);exit;
        return $data;  
    }
    

}