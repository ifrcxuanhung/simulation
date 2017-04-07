<?php
require('_/modules/welcome/controllers/block.php');

class Pricers extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $block = new Block();
		$this->data->dashboard_stat = $block->dashboard_stat();
        $this->data->composition = $block->table_composition();

		$this->data->model = $block->table_model();
		$this->template->write_view('content', 'pricers', $this->data);
		$this->template->render();
    }
    
}