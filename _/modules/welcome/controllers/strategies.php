<?php
require('_/modules/welcome/controllers/block.php');

class Strategies extends Welcome{
    public function __construct() {
        parent::__construct();
		$this->load->model('strategies_model', 'strategies');
    }
    
    public function index() {
		$tab = isset($_REQUEST["tab"]) ? $_REQUEST['tab'] : "";
        $block = new Block;
        $type = $this->db->select('opt_fut')->where('`tab`',trim(strtolower($tab)))->get('vdm_strategy_setting')->row_array();
        @$this->data->education_news = $block->table_education_news();
        $trategy =  $this->strategies->get_data($tab);
        $this->data->data = $trategy;
        $this->data->description = $this->strategies->getGlossary_description($trategy["article_id"]);
       // print_R($this->data->description);exit;
        //declare lang default
        $trategy_desc = $this->strategies->get_data_desc($tab);
        //get default article by cate
        $trategy_desc_default = $this->strategies->get_data_desc($tab, 'en');
        //replace all value null with languae default
        $trategy_desc = replaceValueNull($trategy_desc, $trategy_desc_default);
        //set list_article = $list_article to show on view list
        $this->data->trategy_desc = $trategy_desc;
        if(trim(strtolower($type['opt_fut']))=='options'){
    		$this->template->write_view('content', 'strategies_'.$trategy["class"].'_', $this->data);
            $this->template->render();
        }else if (trim(strtolower($type['opt_fut']))=='futures'){
			//echo "<pre>";print_r('strategies_f'.$trategy["class"].'_');exit;
            $this->template->write_view('content', 'strategies_f'.$trategy["class"].'_', $this->data);
            $this->template->render();
        }
    }
   
}
