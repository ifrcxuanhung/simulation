<?php
require('_/modules/welcome/controllers/block.php');

class Live extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $block = new Block();
        $this->data->dashboard_stat = $block->dashboard_stat();
        $this->data->chart = $block->flotchart('400px');
        $this->data->stats = $block->table_stat();
        $this->data->specs = $block->table_specs($_SESSION['array_other_product']['dsymbol']);
		
        $this->data->trading = $block->table_trading($_SESSION['array_other_product']['dsymbol']);

		$this->template->write_view('content', 'live', $this->data);
		$this->template->render();
    }
    
}