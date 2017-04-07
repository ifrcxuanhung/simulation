<?php
class Test extends Welcome{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
       $this->template->write_view('content','test',$this->data);
       $this->template->render();
    }
}