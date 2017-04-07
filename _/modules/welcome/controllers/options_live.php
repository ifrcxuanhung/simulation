<?php
require('_/modules/welcome/controllers/block.php');

class Options_live extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $block = new Block();
        $this->data->dashboard_options = $block->dashboard_options();
        $this->data->chart = $block->flotchart('400px');
        $this->data->stats = $block->table_stat();
       // print_R($_SESSION);exit;
        $this->data->bestlimits = $block->options_bestlimits($_SESSION['option_product']['dsymbol']);
        $this->data->options_order = $block->options_order($_SESSION['option_product']['dsymbol']);
		
		$this->template->write_view('content', 'options_live', $this->data);
		$this->template->render();
    }
    
}