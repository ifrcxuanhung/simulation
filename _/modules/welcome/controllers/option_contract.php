<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Option_contract extends Welcome {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
	
        $this->template->write_view('content', 'option_contract', $this->data);
        $this->template->render();
    }

}