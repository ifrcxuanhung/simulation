<?php
require('_/modules/welcome/controllers/block.php');

class Finances extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $block = new Block();
        $this->data->dashboard_stat = $block->dashboard_stat();
		$this->data->chart = $block->flotchart('500px');
		$this->data->bottom_chart = $block->bottom_chart();
		$this->data->specs = $block->table_specifications($_SESSION['array_other_product']['usymbol']);
        $this->data->portfolio = $block->table_portfolio();
        
		$this->data->finance = $block->table_finance();
		$this->data->account = $block->table_account();


		
		$this->template->write_view('content', 'finances', $this->data);
		$this->template->render();
    }
    
}