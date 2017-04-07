<?php
require('_/modules/welcome/controllers/block.php');

class Customise extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $block = new Block();
		$this->data->dashboard_stat = $block->dashboard_stat();
		$this->template->write_view('content', 'customise', $this->data);
		$this->template->render();
    }
    
}