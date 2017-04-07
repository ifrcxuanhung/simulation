<?php
require('_/modules/welcome/controllers/block.php');

class Education extends Welcome{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $block = new Block();
        $this->data->dashboard_stat = $block->dashboard_stat();
        $this->data->chart = $block->flotchart('400px');
        $this->data->stat = $block->table_stat();
        $this->data->specs = $block->table_specs($_SESSION['array_other_product']['dsymbol']);
        $this->data->trading = $block->table_trading($_SESSION['array_other_product']['dsymbol']);
        $this->data->education_news = $block->table_education_news();
        $this->data->education_glossary = $block->table_education_glossary();
		$this->data->type_strategies = $block->table_typestrategies();
		$this->template->write_view('content', 'education', $this->data);
		$this->template->render();
    }
    
}