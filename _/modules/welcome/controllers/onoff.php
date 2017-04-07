<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Onoff extends Welcome {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
	
		$this->data->value = $this->db3->get_where('setting', array('group' => 'setting','key'=>'market_making_seconds'))->row_array();
		$this->data->value2 = $this->db3->get_where('setting', array('group' => 'setting','key'=>'market_making_futures'))->row_array();
        $this->template->write_view('content', 'onoff/index', $this->data);
        $this->template->render();
    }

}