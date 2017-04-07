<?php
class Layout_model extends CI_Model{
    protected $_lang;
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->_lang = $this->session->userdata('curent_language');
    }
    
    function loadSubcatbyCategory($cate){
        $sql ="SELECT int_a.subcat FROM int_article as int_a LEFT JOIN int_article_category as int_c ON int_c.category = int_a.category_code and int_c.subcat = int_a.subcat WHERE int_a.category_code ='".$cate."' GROUP BY int_a.subcat ORDER BY int_c.order";
        return $this->db->query($sql)->result_array();   
    }
    function loadArticleBySubCat($cate){
        $lang = $this->session->userdata('curent_language');
        $sql ="SELECT * FROM int_article WHERE category_code ='".$cate."' and lang_code='".$lang['code']."' ORDER BY sort_order";
        $data = $this->db->query($sql)->result_array();
        $array = array();
        foreach($data as $value){
            $array[str_replace(' ','',$value['subcat'])][] = $value;
        }
        return $array;
    }
    public function getLayout($route,$column){
        $data = $this->db->select('*')->where('route',$route)->where('active',1)->where('column',$column)->order_by('order','ASC')->get('portfolio_sys_layout')->result_array();
        return $data;
    }
    public function getTotalLayout($route){
        $data = $this->db->select('*')->where('route',$route)->where('active',1)->order_by('order','ASC')->get('portfolio_sys_layout')->result_array();
        return $data;
    }
    public function getLayoutPosition($route,$column,$layout,$position){
        $data = $this->db->select('*')->where('route', $route)->where('active', 1)->where('column', $column)->where('layout', $layout)->where('position', $position)->order_by('order', 'ASC')->get('portfolio_sys_layout')->result_array();
        return $data;
    }
}
