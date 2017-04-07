<?php
require('_/modules/welcome/controllers/building.php');

class Module extends Welcome{

    public function __construct(){
        parent::__construct();
        $this->load->model('Layout_model','layout');
    }
    public function index($controller){
        $building = new Building();

        $this->data->dashboard_stat = $building->dashboard_stat($height=0);

        $this->data->layouts = $this->layout->getTotalLayout($controller,2);
        // Use to loop module
        $this->data->column1 = $this->layout->getLayout($controller,1,2);
        $this->data->column2 = $this->layout->getLayout($controller,2,2);
        $this->data->column3 = $this->layout->getLayout($controller,3,2);
        // Use to show col-md-
        $this->data->column1_top = $this->layout->getLayoutPosition($controller,1,2,'top');
        $this->data->column2_top = $this->layout->getLayoutPosition($controller,2,2,'top');
        $this->data->column3_top = $this->layout->getLayoutPosition($controller,3,2,'top');

        $this->data->column1_content = $this->layout->getLayoutPosition($controller,1,2,'content');
        $this->data->column2_content = $this->layout->getLayoutPosition($controller,2,2,'content');
        $this->data->column3_content = $this->layout->getLayoutPosition($controller,3,2,'content');

        $this->data->column1_bottom = $this->layout->getLayoutPosition($controller,1,2,'bottom');
        $this->data->column2_bottom = $this->layout->getLayoutPosition($controller,2,2,'bottom');
        $this->data->column3_bottom = $this->layout->getLayoutPosition($controller,3,2,'bottom');
        // END Use to show col-md-
        // if name =! '' then remove module
       // echo "<pre>";print_r($this->data->column1);exit;
        foreach($this->data->column1 as $k=>$layout){
            if($layout['name'] != ''){
                $get['temp1'] = $this->data->column1[$k];
                unset($this->data->column1[$k]);
            }

        }
        if(isset($get['temp1'])){
            $this->data->column1[] = $get['temp1'];
        }

        foreach($this->data->column2 as $k=>$layout){
            if($layout['name'] != ''){
                $get['temp2'] = $this->data->column2[$k];
                unset($this->data->column2[$k]);
            }

        }
        if(isset($get['temp2'])){
            $this->data->column2[] = $get['temp2'];
        }

        foreach($this->data->column3 as $k=>$layout){
            if($layout['name'] != ''){
                $get['temp3'] = $this->data->column3[$k];
                unset($this->data->column3[$k]);
            }

        }
        if(isset($get['temp3'])){
            $this->data->column3[] = $get['temp3'];
        }

        foreach($this->data->layouts as $k=>$layout){
            if($layout['name'] != ''){
                $get['temp'] = 	$this->data->layouts[$k];
                unset($this->data->layouts[$k]);
            }

        }
        if(isset($get['temp'])) {
            $this->data->layouts[] = $get['temp'];
        }
        foreach($this->data->layouts as $layout){
            $this->data->$layout['module'] = $building->$layout['module']($_SESSION['array_other_product']['dsymbol'],$layout['height']);

        }
        $this->template->write_view('content', 'module_position', $this->data);
        $this->template->render();

    }
}