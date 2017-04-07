<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Translate_model extends CI_Model {

    public $table = 'translate';
	
    function __construct() {
        parent::__construct();
		$this->db3 = $this->load->database('database3', TRUE);
    }

    public function find($name) {
        $this->db->where('word', $name);
        $query = $this->db->get($this->table);
        $input = $query->result_array();
        $word = '';
        foreach ($input as $key => $item) {
            if ($word != $item['word']) {
                if ($word != '') {
                    $list[] = $temp;
                }
                $temp['word'] = $item['word'];
                $word = $item['word'];
            }
            $temp['translate'][$item['lang_code']] = $item['translate'];
        }
        $list = $temp;
        return $list;
    }

    public function list_translate() {
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        $input = $query->result_array();
        $list = array();
        foreach ($input as $item) {
            $list[$item['word']]['word'] = $item['word'];
            $list[$item['word']]['translate'][$item['lang_code']] = $item['translate'];
        }
        $list = array_values($list);
        $file = json_encode($list);
        file_put_contents('assets/translate/translate.json', $file);
        return $list;
    }

    public function add_translate($data) {
        $this->db->insert($this->table, $data);
    }

    public function check_word($word, $code, $self = '') {
        $this->db->select('COUNT(id) as c');
        if ($self != '') {
            $this->db->where('word !=', $self);
        }
        $this->db->where('word', $word);
        $this->db->where('lang_code', $code);
        $query = $this->db->get($this->table);
        $count = $query->result_array();
        $count = $count[0]['c'];
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function update_translate($data, $word, $code) {
        $this->db->where('word', $word);
        $this->db->where('lang_code', $code);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $this->db->where('word', $word);
            $this->db->where('lang_code', $code);
            $this->db->update($this->table, $data);
        } else {
            $this->db->insert($this->table, $data);
        }
    }

    public function del_translate($word) {
        $this->db->where('word', $word);
        return $this->db->delete($this->table);
    }
	public function get_lang($lang,$code){
			$get_lang = $this->db3->query("select $lang , name  from vdm_contracts_specification_field where code = '$code'")->row_array();
		
			if(isset($get_lang['name'])){
				if($get_lang[$lang] == ''){
					$result =  $get_lang['name'];
				}else{
					$result = $get_lang[$lang];
				}
			}else{
				$result = $code;	
			}
			
			return $result;
	}
	

    public function get($word) {
        $lang_code = $this->session->userdata('curent_language');
		if(isset($_SESSION['curent_language']))
			$lang_code = $_SESSION['curent_language'];
			
        $lang_code_default = $this->session->userdata('default_language');
        $lang_code_default = $lang_code_default['code'];
        
        $lang_code = $lang_code['code'];
        $this->db->where('word', $word);
        $query = $this->db->get($this->table);
        $translate = $query->result();
        $t = array();
        if ($translate) {
			//echo "<pre>";print_r($translate);exit;
            foreach ($translate as $key => $value) {
                $t[$value->lang_code] = $value->translate;
            }
            if (isset($t[$lang_code]) == TRUE && $t[$lang_code] != '') {
                return $t[$lang_code];
            } elseif (isset($t[$lang_code_default]) == TRUE && $t[$lang_code_default] != '') {
                return $t[$lang_code_default];
            } else {
                return $word;
            }
        }
        return $word;
    }
	public function get_tran_col($word) {
        $lang_code = $this->session->userdata('curent_language');
		if(isset($_SESSION['curent_language']))
			$lang_code = $_SESSION['curent_language'];
			
        $lang_code_default = $this->session->userdata('default_language');
        $lang_code_default = $lang_code_default['code'];
        
        $lang_code = $lang_code['code'];
        $this->db->where('word', $word);
        $query = $this->db->get($this->table);
        $translate = $query->row_array();
		if(isset($translate[$lang_code]) && $translate[$lang_code] != ''){
			$word = $translate[$lang_code];
		}
		else if(isset($translate['name']) && $translate['name'] != ''){
			$word = $translate['name'];	
		}
		else{
			$word = $word;	
		}
		
        return $word;
    }
	
	public function get_trans($word,$lang) {
        $lang_code = $lang;
        $lang_code_default = $this->session->userdata('default_language');
        $lang_code_default = $lang_code_default['code'];
        $this->db->where('word', $word);
        $query = $this->db->get($this->table);
        $translate = $query->result();
        $t = array();
        if ($translate) {
            foreach ($translate as $key => $value) {
                $t[$value->lang_code] = $value->translate;
            }
            if (isset($t[$lang_code]) == TRUE && $t[$lang_code] != '') {
                return $t[$lang_code];
            } elseif (isset($t[$lang_code_default]) == TRUE && $t[$lang_code_default] != '') {
                return $t[$lang_code_default];
            } else {
                return $word;
            }
        }
        return $word;
    }

}
