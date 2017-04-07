<?php
require('_/modules/welcome/controllers/block.php');
class Trading extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
		//print_r('vao start nhe');exit;
	//	$this->data->starthomes = $this->table->getStartHome();
		//echo "<pre>";print_r($this->data->starthome);exit;
		 $block = new Block();
        $this->data->dashboard_stat = $block->dashboard_stat();
		//$this->data->chart = $block->flotchart('500px');
		//$this->data->bottom_chart = $block->bottom_chart();
		$this->data->dashboard_future_trading = $block->dashboard_future_trading();
		$this->data->specs = $block->table_specifications($_SESSION['array_other_product']['dsymbol']);
		$this->data->finance = $block->table_finance();
		$this->data->dashboard_option_contract = $block->dashboard_option_contract();
		$this->data->account = $block->table_account();
		$this->data->portfolio = $block->table_portfolio();
		$this->data->trading = $block->table_trading($_SESSION['array_other_product']['dsymbol']);
		
		
		//echo "<pre>";print_r($this->data->row_future);exit;
		
		
		
		$this->template->write_view('content', 'trading', $this->data);
		$this->template->render();
    }
    
}