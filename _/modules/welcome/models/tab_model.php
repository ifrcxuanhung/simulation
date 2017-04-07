<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tab_model extends CI_Model {

    var $table_sys_format = 'sys_format';
    var $table_sys_tab = 'vdm_summary';

    function __construct() {
        parent::__construct();
		$this->db3 = $this->load->database('database3', TRUE);
    }
    function get_headers ($table='',$field='') {
        $ids = array($table);
        $sql = "select *
                from {$this->table_sys_format} 
                where (`active` <= ".$this->session->userdata('user_level'). " or `active` =1) and (`active` !=0) and (`table` ='".$table."') order by `order` asc ";
         return $this->db3->query($sql)->result_array();
    }
	function get_tab ($tab='') {
		$sql = "select *
                from $this->table_sys_tab 
				where tab = '$tab' ";
                //where tab = '$tab' and user_level <=".$this->session->userdata('user_level');
		 return $this->db3->query($sql)->row_array();       
    }
	function get_config ($code='') {
		$sql = "select value
                from vdm_config 
                where code = '$code'";
		 return  $this->db3->query($sql)->row_array();
    }
    function append_input($field = '', $value_filter='') {
        if($field == '') {
            return '';
        } else {
			if($value_filter!='')
            return '<input type="text" id="'.strtolower($field).'" name="'.strtolower($field).'" placeholder="Search..." class="form-control form-filter input-sm" autocomplete="off" value="'.$value_filter.'"/>';
			else
			return '<input type="text" id="'.strtolower($field).'" name="'.strtolower($field).'" placeholder="Search..." class="form-control form-filter input-sm" autocomplete="off" />';
			
        }
    }
    public function tab_type($table){
        $sql = "SHOW COLUMNS FROM {$table};";  
        return $this->db3->query($sql)->result_array(); 
    }    
    
    function append_date($field = '') {
        if($field == '') {
            return '';
        } else {
            $html = '<div class="input-group date date-picker margin-bottom-5">';
            $html .= '<input type="text" id="'.strtolower($field).'_start" name="'.strtolower($field).'_start" placeholder="Choose..." class="form-control form-filter input-sm date-picker" data-date-format="yyyy-mm-dd" autocomplete="off">';
            $html .= '<span class="input-group-btn">';
            $html .= '<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>';
            $html .= '</span>';
            $html .= '</div>';
            $html .= '<div class="input-group date date-picker">';
            $html .= '<input type="text" id="'.strtolower($field).'_end" name="'.strtolower($field).'_end" placeholder="Choose..." class="form-control form-filter input-sm date-picker" data-date-format="yyyy-mm-dd" autocomplete="off">';
            $html .= '<span class="input-group-btn">';
            $html .= '<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>';
            $html .= '</span>';
            $html .= '</div>';
            return $html;
        }
    }
	 function append_range($field = '') {
        if($field == '') {
            return '';
        } else {
            $html = '<div class="margin-bottom-5">';
			$html .='<input type="text" placeholder="From" name="'.strtolower($field).'_from" class="form-control form-filter input-sm">';
            $html .= '</div>';
			$html .= '<input type="text" placeholder="To" name="'.strtolower($field).'_to" class="form-control form-filter input-sm">';
            return $html;
        }
    }

   /* function append_select($field = '',$arr ='', $value_filter='', $format_n='', $value_filter='') {
		//ini_set("memory_limit","200M");
        if($field == '') {
            return '';
        } else {
            $html = '<select id="'.$field.'" name="'.$field.'" class="form-control form-filter input-sm" autocomplete="off">';
            $html .= '<option value="all">All</option>';
            $list_data = $this->db3->query("select `$field` from $arr group by `$field` order by `$field` asc;")->result_array();
            foreach ($list_data as $item) {
                if((strpos(strtolower($format_n),'decimal')!==false)&&$item[$field]!=''){
					$start = strpos(strtolower($format_n),'(') +1;
					$end = strpos(strtolower($format_n),')');
					$str = ($start!==false && $end!==false) ? intval(substr($format_n,$start,  $end - $start)) : 0;
					$value = number_format(($value[strtolower($item['field'])]), $str, '.', ',');
				}
				else if (($format_n == 'M-Y')&&$item[$field]!='' ){
					$value = date($format_n,strtotime($item[$field]));
				}
				else 
				$value = $item[$field];
				if($value_filter!='' && ($item[$field]==$value_filter))
                $html .= '<option value="'.$item[$field].'" selected="selected">'.$value.'</option>';
				else 
				 $html .= '<option value="'.$item[$field].'">'.$value.'</option>';
            }
            $html .= '</select>';
            return $html;
        }
    }*/
    function append_select($field = '',$arr='', $format_n='', $value_filter='') {
        if($field == '') {
            return '';
        } else {
            $html = '<select id="'.$field.'" name="'.$field.'" class="form-control form-filter input-sm" autocomplete="off">';
            $html .= '<option value="all">All</option>';
            $list_data = $this->db3->query("select `$field` from $arr group by `$field` order by `$field` asc;")->result_array();
			//var_export($list_data);
            foreach ($list_data as $item) {
				if((strpos(strtolower($format_n),'decimal')!==false)&&$item[$field]!=''){
					$start = strpos(strtolower($format_n),'(') +1;
					$end = strpos(strtolower($format_n),')');
					$str = ($start!==false && $end!==false) ? intval(substr($format_n,$start,  $end - $start)) : 0;
					//var_export($value);
					$value = number_format((strtolower($item[$field])), $str, '.', ',');
				}
				else if ((strpos(strtolower($format_n),'date')!==false)&&$item[$field]!=''){
					$start = strpos(strtolower($format_n),'(') +1;
					$end = strpos(strtolower($format_n),')');
					$str = ($start!==false && $end!==false) ? substr($format_n,$start,  $end - $start) : 0;
					$value = date($str,strtotime($item[$field]));
				}
				else 
				$value = $item[$field];
				if($value_filter!='' && ($item[$field]==$value_filter))
                $html .= '<option value="'.$item[$field].'" selected="selected">'.$value.'</option>';
				else 
				 $html .= '<option value="'.$item[$field].'">'.$value.'</option>';
            }
            return $html;
        }
    }
    
    function append_input_number($field = '', $value = '', $readonly = '',$primary=0) {
        if($field == '') {
            return '';
        } else {
            $read = $readonly == '1' ? 'readonly="readonly"' : '' ;
			$strPrimary = $primary == '1' ? 'data-required="1" ' : '' ;
            return '<input type="text" id="'.strtolower($field).'" '.$read.$strPrimary.' name="'.strtolower($field).'" value="'.$value.'" class="form-control form-filter input-sm input_number" autocomplete="off"/>';
        }
    }
	function append_input_text($field = '', $value = '', $readonly = '',$primary=0) {
        if($field == '') {
            return '';
        } else {
            $read = $readonly == '1' ? 'readonly="readonly"' : '' ;
			$strPrimary = $primary == '1' ? 'data-required="1" ' : '' ;
            return '<input type="text" id="'.strtolower($field).'" '.$read.$strPrimary.' name="'.strtolower($field).'" value="'.$value.'" class="form-control form-filter input-sm" autocomplete="off"/>';
        }
    }
    
    
    // EDITON FORM 
    
    function append_input_editon($field = '' ,$value = '', $readonly = '',$primary=0, $type='text') {
        if($field == '') {
            return '';
        } else {
            $read = $readonly == '1' ? 'readonly="readonly"' : '' ;
			$strPrimary = $primary == '1' ? 'data-required="1" ' : '' ;
            return '<input type="'.$type.'" id="'.strtolower($field).'" '.$read.$strPrimary.' name="'.strtolower($field).'" value="'.$value.'" class="form-control"/>';
        }
    }
    function append_summernote_editon($field = '', $value = '', $readonly= '',$primary=0) {
        if($field == '') {
            return '';
        } else {
            $read = $readonly == '1' ? 'readonly="readonly"' : '' ;
			$strPrimary = $primary == '1' ? 'data-required="1" ' : '' ;
            //return '<div data-provide="markdown-editable">'.$value.'</div>';
            return '<textarea id="'.strtolower($field).'" '.$read.$strPrimary.' name="'.strtolower($field).'" class="summernote">'.$value.'</textarea>';
           // return '<div id="summernote_1" '.$read.$strPrimary.'  name="summernote_1" class="wysihtml5">'.$value.'</div>';
        }
    }
    
    function append_select_editon($field = '',$arr='', $value ='', $readonly = '',$primary=0) {
        if($field == '') {
            return '';
        } else {
            $read = $readonly == '1' ? ' disabled' : '' ;
			$strPrimary = $primary == '1' ? 'data-required="1" ': '' ;
            $html = '<select '.$read.' id="'.$field.'" name="'.$field.'" class="form-control select2me" autocomplete="off">';
            $html .= '<option value="other_value">Other</option>';
            $list_data = $this->db3->query("select `$field` from $arr group by `$field` order by `$field` asc;")->result_array();
            foreach ($list_data as $item) {
                $select = $item[$field] == $value ? ' selected="selected"' : '';
                $html .= '<option value="'.$item[$field].$select.'">'.$item[$field].'</option>';
            }
            $html .= '</select>';
            return $html;
        }
    }														
															
    function append_date_editon($field = '',$value ='') {
        if($field == '') {
            return '';
        } else {
            $html = '<div class="input-icon"><i class="fa fa-calendar"></i><input type="text" data-date-viewmode="years" id="'.strtolower($field).'" name="'.strtolower($field).'"  data-date-format="yyyy-mm-dd" data-date="'.$value.'" value="'.$value.'" size="16" class="form-control date-picker"></div>';
            return $html;
        }
    }
    
    function append_image_editon($image = '', $field='') {
        
        $base_url = base_url();
		$html ='<div data-provides="fileinput" class="fileinput fileinput-new">';
		$html .='<div class="fileinput-new thumbnail">';
		$html .='<img alt="" src="'. (isset($image)&&$image!="" ? $base_url.$image : $base_url."assets/images/no-image.jpg") .'" class="img_upload_'.$field.'" style="max-height: 100px;" >';
		$html .='</div>';
		$html .='<div style="max-width: 200px; max-height: 150px;" class="fileinput-preview fileinput-exists thumbnail" id="'.$field.'">';
		$html .='</div>';
		$html .='<div id="file">';
		$html .='<span class="btn default btn-file">';
		$html .='<span class="fileinput-new">';
		$html .='Select image </span>';
		$html .='<span class="fileinput-exists">';
		$html .='Change </span>';
		$html .='<input type="file" name="file" id="'.$field.'" class="file_upload" >';
		$html .='</span>';
		$html .='<a data-dismiss="fileinput" class="btn default fileinput-exists" href="#">';
		$html .='Remove </a>';
		$html .='</div>';
		$html .='</div>';
        return $html;
    }
    function append_textarea_editon($field = '',$value = '', $maxlenght = null){
       // print_r($value);exit;
        $html = '<textarea '. ($maxlenght == null ? '' :  'maxlength="'.$maxlenght.'"').' name="'.$field.'"  id="'.$field.'" rows="3" class="form-control' .($maxlenght == null  ? ' ' : ' maxlength-handler').' full">';
        $html .= $value; 
        $html .= '</textarea>';
		$html .= $maxlenght == null ? '' : '<span class="help-block"> max '.$maxlenght.' chars </span>';
        return $html;
    }
    function append_select2_editon($field = '', $options = array(), $selected , $primary = 0){
        if($field == '') {
            return '';
        } else {
            $read = $readonly == '1' ? 'disabled' : '' ;
			$strPrimary = $primary == '1' ? ' data-required="1" ': '' ;
            $selected = isset($selected) ? $selected :  '';
    		$html  ='<select class="form-control select2me" name="'.$field.'" id="'.$field.'" '.$read.$strPrimary.' >';
    		$html .='<option value="">Choose...</option>';                           
            foreach ($options as $key => $val)
    		{
    			$sel = $key == $selected ? ' selected="selected"' : '';
    			$html .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";    
    		}        
    		$html .='</select>'; 
        }  
    }
    
    function append_checkbox_editon($field = '', $options = array(), $checked , $primary = 0){
        if($field == '') {
            return '';
        } else {
            $read = $readonly == '1' ? 'disabled' : '' ;
			$strPrimary = $primary == '1' ? ' data-required="1" ': '' ;
            $check = isset($checked) ? $checked :  '';
    		$html  ='<div class="checkbox-list"> name="'.$field.'" id="'.$field.'" '.$read.$strPrimary.' >';                          
            foreach ($options as $key => $val)
    		{
    			$che = $key == $check ? ' checked' : '';
    			$html .= '<label><input type="checkbox" value="'.$key.'" name="'.$field.'" '.$sel.'/>'.(string) $val."</label>\n";    
    		}        
    		$html .='</div>';
        }  
    }
	function append_html($field = '', $value_filter='') {
        if($field == '') {
            return '';
        } else {
			if($value_filter!='')
            return '<input type="text" id="html_'.strtolower($field).'" name="html_'.strtolower($field).'" placeholder="Search..." class="form-control form-filter input-sm" autocomplete="off" value="'.$value_filter.'"/>';
			else
			return '<input type="text" id="html_'.strtolower($field).'" name="html_'.strtolower($field).'" placeholder="Search..." class="form-control form-filter input-sm" autocomplete="off" />';
			
        }
    }
	function append_html_editon($field = '',$value = '', $maxlenght = null){
		$html = '<textarea class="ckeditor form-control" name="'.$field.'" id="'.$field.'" >';
		$html .= $value; 
		$html .='</textarea>';
        return $html;
    }
    
    
 
    

}