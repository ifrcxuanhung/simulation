<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Verification extends Welcome {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('database3', true);
    }
    
    function index() {

        $this->load->model('verification_model', 'verification');
		$this->data->verification_list = $this->verification->getdata();
        $this->data->query_list = $this->verification->getquery();

        $this->template->write_view('content', 'verification/index', $this->data);
        $this->template->render();
    }
    function verification_check(){
        
        $id = $_POST['id']; 
        //$id = '2'; 
        $list_code = $this->db->query("select * from simul_verification where id='".$id."';")->result_array();
        foreach ($list_code as $data)
            {            
            $comment = $this->db2->query("select group_concat(distinct dsymbol  order by dsymbol asc separator ' , ') dsymbol
             from ".$data['table_name']."  where  ".$data['colume_name']." =0 or  ".$data['colume_name']." is null;")->row_array();
             $sql="update simul_verification set `comment`='".$comment['dsymbol']."' where id='".$id."';";
            $this->db->query($sql);
        }   
        $sql="update simul_verification set status= if(length(comment)>0, 'NOT OK','OK') where id='".$id."';";
        $this->db->query($sql);  
    }
     function verification_query_old(){
        
        $id = $_POST['id']; 
        $list_query = $this->db->query("select * from simul_query where id='".$id."';")->result_array();
        foreach ($list_query as $data)
            {            
             $sql=$data['query'];
             $this->db2->query($sql);
        }   
        echo $sql;
    }
     function verification_query(){
            
            $id = $_POST['id']; 
            $list_query = $this->db->query("select query from simul_query where id='".$id."';")->row_array();
            $cut=explode(";",$list_query['query']);
            foreach ($cut as $data)
                { 
                 $this->db2->simple_query($data);
            }   
           echo $data;
        }

}