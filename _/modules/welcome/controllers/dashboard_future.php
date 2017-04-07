<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_future extends Welcome {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
	
        $this->template->write_view('content', 'dashboad_future', $this->data);
        $this->template->render();
    }

}