<?php
require('_/modules/welcome/controllers/block.php');
class News extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
		//print_r('vao start nhe');exit;
	//	$this->data->starthomes = $this->table->getStartHome();
		//echo "<pre>";print_r($this->data->starthome);exit;
		 $block = new Block();
		
		  //echo "<pre>";print_r($dashboard_future);exit;
        $this->data->dashboard_stat = $block->dashboard_stat();
		//$this->data->chart = $block->flotchart('400px');
		$this->data->market = $block->table_market();
		$this->data->news = $block->table_news();
		$this->data->calendar = $block->table_calendar();
		$this->data->by_underlying = $block->table_by_underlying();
		$this->data->trading = $block->table_trading($_SESSION['array_other_product']['dsymbol']);
		$this->template->write_view('content', 'news', $this->data);
		$this->template->render();
    }
    
}