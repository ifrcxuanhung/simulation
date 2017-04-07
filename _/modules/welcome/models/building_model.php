<?php
if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Building_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    public function getSysLayout($module){
        $sql = "SELECT * FROM portfolio_sys_layout WHERE module='$module'";
        $result = $this->db->query($sql)->row_array();
        return $result;
    }
}
