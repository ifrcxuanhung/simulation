<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Management extends Welcome {
    function __construct() {
        parent::__construct(); 
    }
    
    function index() {
		//$this->data->block_management = $this->db->query("SELECT * FROM simul_settings ss WHERE ss.type='menu' AND ss.stype = 'management' AND ss.active = 1 ORDER BY ss.`order`")->result_array();
		$this->data->blockmanagement = $this->db->query("SELECT * FROM simul_settings ss WHERE ss.type='menu' AND ss.stype = 'management' AND ss.active = 1 ORDER BY ss.`order`")->result_array();
		//echo "<pre>";print_r($this->data->block_management);exit;
        $this->template->write_view('content', 'management/index', $this->data);
        $this->template->render();
    }

}