<?php
require('_/modules/welcome/controllers/block.php');

class Analytics extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $block = new Block();
        $this->data->dashboard_stat = $block->dashboard_stat();
		$this->data->chart = $block->echart();
		$this->data->bottom_chart = $block->bottom_chart();
       	$this->data->trading = $block->table_trading($_SESSION['array_other_product']['dsymbol']);
		$this->data->account = $block->table_account();
        $this->data->strategies = $block->table_strategies();
        
		$this->template->write_view('content', 'analytics', $this->data);
		$this->template->render();
    }
    
}