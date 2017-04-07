<?php
class Setting_model extends CI_Model{
	var $table = 'setting';
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
		
    }
    
    
    
    public function listCode() {
        $sql = "SELECT code FROM index_setting GROUP BY code;";
        return $this->db->query($sql)->result_array();
    }
    public function listData(){
        $sql = "SELECT * FROM data_setting;";
        return $this->db->query($sql)->result_array();
    }
	public function get_group($name) {
        if ($name == NULL)
            return FALSE;
        $this->db->where('group', $name);
        $query = $this->db->get($this->table);
        $data = $query->result();
        $temp = FALSE;
        if (is_array($data) == TRUE && count($data) > 0) {
            foreach ($data as $value) {
                $temp[$value->key] = $value->value;
            }
        }
        unset($data);
        return $temp;
    }
}