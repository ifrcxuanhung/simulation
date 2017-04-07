<?php
require('_/modules/welcome/controllers/class.phpmailer.php');
require('_/modules/welcome/controllers/class.smtp.php');
require('_/modules/welcome/controllers/class.pop3.php');
class Building extends MY_Controller{

    protected $data;

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('building_model','building');
        $this->db3 = $this->load->database('database3', TRUE);
        $this->data = new stdClass();
    }
    public function underlying_setting () {
        /*underlying setting*/


        //$underlying_setting_r = $this->db3->where("dsymbol",$_SESSION['array_other_product']['dsymbol'])->get('vdm_underlying_setting')->result_array();
        /*$get_codeint = $this->db3->select('codeint,format')->where("dsymbol",$_SESSION['array_other_product']['dsymbol'])->get('vdm_contracts_ref')->row_array();
        $underlying_setting_r = $this->db3->where("codeint",$get_codeint['codeint'])->get('vdm_underlying_setting')->result_array();*/
        $underlying_setting_r = $this->db3->query("select  vcr.format, vus.* from vdm_contracts_ref vcr left join vdm_underlying_setting vus on vcr.codeint = vus.codeint
 where vcr.dsymbol = '".$_SESSION['array_other_product']['dsymbol']."'")->result_array();
        //last
        //echo "<pre>";print_r($underlying_setting_r);exit;
        //get format any value
        $find_format = strpos($underlying_setting_r[0]['format'],'.');
        $find_comma = strpos($underlying_setting_r[0]['format'],',');
        if(isset($find_format) && $find_format){
            $explode = explode(".",$underlying_setting_r[0]['format']);
            $get_decimal = strlen($explode[1]);
            if(isset($find_comma) && $find_comma) {
                $get_comma = ',';
            }else{
                $get_comma = '';
            }
        }
        else if(isset($find_comma) && $find_comma){
            $get_comma = ',';
            $get_decimal = 0;
        }
        else{
            $get_decimal = 0;
            $get_comma = '';
        }
        //end get format any value
        $underlying_setting =array();
        if(isset($underlying_setting_r['0']['last'])) {
            $underlying_setting['last'] = number_format($underlying_setting_r['0']['last'],$get_decimal,'.',$get_comma);
            //change
            if($underlying_setting['last']=='0.00'){
                $underlying_setting['change'] ='-';
                $underlying_setting['var'] ='-';
                $underlying_setting['last'] ='-';
            }
            else {
                if($underlying_setting_r['0']['change'] >=0)
                    $underlying_setting['change'] = '<span class="po">+'.number_format($underlying_setting_r['0']['change'],$get_decimal,'.',$get_comma).'</span>';
                else
                    $underlying_setting['change'] = '<span class="di">'.number_format($underlying_setting_r['0']['change'],$get_decimal,'.',$get_comma).'</span>';
                //var
                if($underlying_setting_r['0']['var'] >=0)
                    $underlying_setting['var'] = '<span class="po">+'.number_format($underlying_setting_r['0']['var'],2,'.',',').'%</span>';
                else
                    $underlying_setting['var'] = '<span class="di">'.number_format($underlying_setting_r['0']['var'],2,'.',',').'%</span>';
            }
        }
        else {
            $underlying_setting['change'] ='-';
            $underlying_setting['var'] ='-';
            $underlying_setting['last'] ='-';
        }
        //var
        if(isset($underlying_setting_r['0']['time']) && $underlying_setting_r['0']['time']!='') {
            if(date('Y-m-d',strtotime($underlying_setting_r['0']['time'])) == date('Y-m-d') )
                $underlying_setting['time'] = date('H:i:s',strtotime($underlying_setting_r['0']['time']));
            else
                $underlying_setting['time'] = date('Y-m-d',strtotime($underlying_setting_r['0']['time']));
        }
        else {
            $underlying_setting['time'] ='';
        }
        if($underlying_setting['time']=='00:00:00') $underlying_setting['time']='-';
        $underlying_setting['format'] = $underlying_setting_r[0]['format'];

        return $underlying_setting;
    }
    public function dashboard_future() {

        $dashboard_future_r = $this->db3->query("select df.dsymbol, df.last, df.`change`, df.var, df.time, vcr.format from dashboard_future df left join vdm_contracts_ref vcr on df.dsymbol = vcr.dsymbol WHERE df.dsymbol='".$_SESSION['array_other_product']['dsymbol']."' and df.expiry = '{$_SESSION['session_expiry_date']}' ORDER BY df.expiry asc LIMIT 1")->result_array();
        //last

        //get format any value
        if(isset($dashboard_future_r[0]['format']))	{
            $find_format = strpos($dashboard_future_r[0]['format'],'.');
            $find_comma = strpos($dashboard_future_r[0]['format'],',');
            if(isset($find_format) && $find_format){
                $explode = explode(".",$dashboard_future_r[0]['format']);
                $get_decimal = strlen($explode[1]);
                if(isset($find_comma) && $find_comma) {
                    $get_comma = ',';
                }else{
                    $get_comma = '';
                }
            }
            else if(isset($find_comma) && $find_comma){
                $get_comma = ',';
                $get_decimal = 0;
            }
            else{
                $get_decimal = 0;
                $get_comma = '';
            }
        }
        //end get format any value

        $dashboard_future =array();
        if(isset($dashboard_future_r['0'])) {
            $dashboard_future['last'] = number_format($dashboard_future_r['0']['last'],$get_decimal,'.',$get_comma);
            //change
            if($dashboard_future['last']=='0.00') {
                $dashboard_future['change'] ='-';
                $dashboard_future['var'] ='-';
                $dashboard_future['last'] ='-';
            }
            else {

                if($dashboard_future_r['0']['change'] >=0)
                    $dashboard_future['change'] = '<span class="po">+'.number_format($dashboard_future_r['0']['change'],$get_decimal,'.',$get_comma).'</span>';
                else
                    $dashboard_future['change'] = '<span class="di">'.number_format($dashboard_future_r['0']['change'],$get_decimal,'.',$get_comma).'</span>';
                //var
                if($dashboard_future_r['0']['var'] >=0)
                    $dashboard_future['var'] = '<span class="po">+'.number_format($dashboard_future_r['0']['var'],2,'.',',').'%</span>';
                else
                    $dashboard_future['var'] = '<span class="di">'.number_format($dashboard_future_r['0']['var'],2,'.',',').'%</span>';
            }
            if($dashboard_future_r['0']['time']!='') {
                if(date('Y-m-d',strtotime($dashboard_future_r['0']['time'])) == date('Y-m-d') )
                    $dashboard_future['time'] = date('H:i:s',strtotime($dashboard_future_r['0']['time']));
                else
                    $dashboard_future['time'] = date('Y-m-d',strtotime($dashboard_future_r['0']['time']));
            }else {
                $dashboard_future['time'] = '';
            }
            $dashboard_future['oi'] = (isset($dashboard_future_r[0]['oi']) && $dashboard_future_r[0]['oi'] != NULL) ? number_format($dashboard_future_r[0]['oi'],0,'.',','):'' ;
        }
        else {
            $dashboard_future['change'] ='-';
            $dashboard_future['var'] ='-';
            $dashboard_future['last'] ='-';
            $dashboard_future['time'] ='-';
            $dashboard_future['oi'] ='';
        }
        return $dashboard_future;
    }

    public function dashboard_stat(){

        $this->data->dashboard_future = $this->dashboard_future();
        $this->data->underlying_setting =  $this->underlying_setting();
        return $this->load->view('block/dashboard_stat', $this->data, true);
    }

    public function getResult($dsymbol){
        $result['underlying'] = $this->db3->select('*')->where('dsymbol',$dsymbol)->get('vdm_underlying_setting')->row_array();
        if(isset($result)){
            $result['contacts'] = $this->db3->select('*')->where('dsymbol',$dsymbol)->where('mm',date('m'))->where('active',1)->where('product','FUTURES')->get('vdm_contracts_setting_exc')->row_array();

        }
        return $result;
    }

    public function table_specifications($dsymbol = 'FVNX25',$height){

        $this->data->height = $height;
        /*$dsymbol = 'F'.$symbol;
        $sql_spe = "select data, value  from simul_specifications where dsymbol = '$dsymbol' order by `order` asc";
        $this->data->list_spe = $this->db->query($sql_spe)->result_array();*/
        $sql_spe = "select *  from vdm_contracts_specification_field  order by `order` asc";
        $list_spes = $this->db3->query($sql_spe)->result_array();
        $codse_setting = array();
        $arr_field = array();
        foreach($list_spes as $ls){

            if($ls['code_setting'] != NULL || $ls['code_setting'] != ''){
                $codse_setting[] = $ls['code_setting']. " as ".$ls['code'];
                //$code[$ls['order']] = $ls['code'];
            }
            $arr_field[$ls['code']] =$ls;
        }

        $select = implode(',',$codse_setting);
        $vdm_contracts_ref = $this->db3->query("select $select  from vdm_contracts_ref where dsymbol = '$dsymbol'")->row_array();
        //print_r("select $select  from vdm_contracts_ref where dsymbol = '$dsymbol'");

        $vdm_data = $this->db3->query("select *  from vdm_contracts_specification_data where dsymbol = '$dsymbol'")->result_array();
        //print_r("select *  from vdm_contracts_specification_data where dsymbol = '$dsymbol'");
        //
        $vdm_contracts_specification_data = array();

        foreach($vdm_data as $vcsd){
            if(isset($_SESSION['curent_language']['code']) && $_SESSION['curent_language']['code'] =='en'){

                if($vcsd['en'] != '' && $vcsd['en'] != NULL){
                    $vdm_contracts_specification_data[$vcsd['field_code']] = $vcsd['en'];
                }else{
                    $vdm_contracts_specification_data[$vcsd['field_code']] = $vcsd['info'];
                }
            }
            if(isset($_SESSION['curent_language']['code']) && $_SESSION['curent_language']['code'] =='fr'){

                if($vcsd['fr'] != '' && $vcsd['fr'] != NULL){
                    $vdm_contracts_specification_data[$vcsd['field_code']] = $vcsd['fr'];
                }else{
                    $vdm_contracts_specification_data[$vcsd['field_code']] = $vcsd['info'];
                }
            }
            if(isset($_SESSION['curent_language']['code']) && $_SESSION['curent_language']['code'] =='vn'){

                if($vcsd['vn'] != '' && $vcsd['vn'] != NULL){
                    $vdm_contracts_specification_data[$vcsd['field_code']] = $vcsd['vn'];
                }else{
                    $vdm_contracts_specification_data[$vcsd['field_code']] = $vcsd['info'];
                }
            }
        }
        //echo "<pre>";print_r($vdm_contracts_ref);
        //echo "<pre>";print_r($vdm_contracts_specification_data);
        if(!empty($vdm_contracts_ref) && !empty($vdm_contracts_specification_data)){
            $list_result = array_merge($vdm_contracts_ref,$vdm_contracts_specification_data);
        }else{
            $list_result = array();
        }

        foreach($list_spes as $ls){
            if (!array_key_exists($ls['code'],$list_result)){
                $list_result[$ls['code']] = '-';
            }
        }
        $arr_result = array();
        foreach($arr_field as $key =>$value) {
            if($value["active"] == 1){
                $arr_result[$value["order"]]["code"] = $value["code"];
                $arr_result[$value["order"]]["format"] = $value["format"];
                $arr_result[$value["order"]]["name"] = $value["name"];
                $arr_result[$value["order"]]["value"] = $list_result[$value["code"]];// mc
            }


        }

        //echo "<pre>";print_r($arr_result);exit();
        $this->data->list_spe = $arr_result;


        return $this->load->view('building/table_specifications', $this->data, true);
    }
    public function dashboard_future_trading($dsymbol = '',$height){
        $this->data->height = $height;
        $this->data->dashboard_future_trading =  $this->db3->query("
        SELECT vcr.format,vcr.`name`, vcr.utype, vus.last as underlying, df.expiry, df.type, df.dsymbol, df.bid, df.ask, df.last, df.qbid, df.qask, df.var
            FROM (SELECT * FROM dashboard_future ORDER BY expiry ASC) df
            LEFT JOIN vdm_contracts_ref vcr ON vcr.dsymbol = df.dsymbol LEFT JOIN vdm_underlying_setting vus
            ON vcr.codeint = vus.codeint
            WHERE df.type = 'FUTURES' AND vus.active = 1 AND vcr.active = 1
            GROUP BY df.dsymbol order by vcr.`order` ASC")->result_array();
        //echo "<pre>";print_r($this->data->dashboard_future_trading );exit;
        return $this->load->view('building/dashboard_future', $this->data, true);
    }
    public function dashboard_option_contract($dsymbol = '',$height){
        $this->data->height = $height;
        $this->data->dashboard_option_contract =  $this->db3->query("select df.type, df.expiry, df.strike, df.bid, df.ask, df.var, vcr.utype, vcr.`name`, vus.last as underlying, df.last, df.nr, vcr.format
  from dashboard df left join vdm_contracts_ref vcr on df.dsymbol = vcr.dsymbol
left join vdm_underlying_setting vus on vcr.codeint = vus.codeint
WHERE df.dsymbol 
IN (select dsymbol from vdm_contracts_ref vcr where active = 1 and dtype = 'OPTIONS')  

group by df.type ORDER BY vcr.`name` asc")->result_array();

        return $this->load->view('building/option_contract', $this->data, true);
    }
    public function table_finance($dsymbol = '',$height)
    {
        $this->data->height = $height;

        $sql = "select *  from simul_fut_finances";
        $this->data->list_finances = $this->db->query($sql)->result_array();
        return $this->load->view('building/table_finance', $this->data, true);
    }
    public function table_trading($dsymbol = 'FVNX25',$height)
    {
        $this->data->height = $height;
        $this->data->dashboard_future = $this->dashboard_future();

        $row_future = $this->db3->query("select df.bid, df.ask, df.qbid, df.qask, vcr.format from dashboard_future df left join vdm_contracts_ref vcr on df.dsymbol = vcr.dsymbol where type = 'FUTURES' AND df.dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' AND df.expiry = '{$_SESSION['session_expiry_date']}'")->row_array();
        $this->data->row_future = $row_future;


        $this->data->sum_b = $this->db3->query("select sum(quantity) as b from vdm_order_futures_daily where dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and `b/s` = 'B' and expiry = '{$_SESSION['session_expiry_date']}'")->row_array();
        $this->data->sum_s = $this->db3->query("select sum(quantity) as s from vdm_order_futures_daily where dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and `b/s` = 'S' and expiry = '{$_SESSION['session_expiry_date']}' ")->row_array();
        if(isset($row_future['bid']) && $row_future['bid'] != '-' && $row_future['bid'] != 0  )
            $this->data->avg_b = $this->db3->query("select avg(vofd.price) as b, vcr.format
from vdm_order_futures_daily vofd left join vdm_contracts_ref vcr on vofd.dsymbol = vcr.dsymbol
where vofd.dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and vofd.`b/s` = 'B' and vofd.expiry = '{$_SESSION['session_expiry_date']}' and vofd.price <= $row_future[bid]")->row_array();
        else
            $this->data->avg_b = array("b"=>'-');


        //print_r("select avg(price) as b from vdm_order_futures_daily where dsymbol = '$_SESSION['array_other_product']['dsymbol']' and `b/s` = 'B' and expiry = '{$_SESSION['session_expiry_date']}' and price <= $row_future[bid]");
        if(isset($row_future['ask']) && $row_future['ask'] != '-' && $row_future['ask'] != 0 )
            $this->data->avg_s = $this->db3->query("select avg(vofd.price) as s , vcr.format from vdm_order_futures_daily vofd left join vdm_contracts_ref vcr on vofd.dsymbol = vcr.dsymbol where vofd.dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and vofd.`b/s` = 'S' and vofd.expiry = '{$_SESSION['session_expiry_date']}' and vofd.price >= $row_future[ask]")->row_array();
        else
            $this->data->avg_s= array("s"=>'-');


        $this->data->maxspd = $this->db3->query("select maxspd,tick, r, dividend_vl from vdm_contracts_setting_exc where product = 'FUTURES' AND dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and expiry = '{$_SESSION['session_expiry_date']}'")->row_array();
        //print_r("select maxspd,tick from vdm_contracts_setting_exc where product = 'FUTURES' AND dsymbol = '".$_SESSION['array_other_product']['dsymbol']."' and expiry = '{$_SESSION['session_expiry_date']}'");
        //echo "<pre>";print_r($this->data->maxspd);exit;
        if(isset($row_future['bid']) && $row_future['bid'] != '-' && $row_future['bid'] != 0 && isset($row_future['ask']) && $row_future['ask'] != '-' && $row_future['ask'] != 0){
            $this->data->price_futures = ($row_future['bid'] + $row_future['ask'])/2;
            $this->data->order_maxspd = number_format(($row_future["ask"]-$row_future["bid"])*100/$row_future["bid"],2,'.',',').'%';
        }
        else if(isset($row_future['bid']) && $row_future['bid'] == '-' && $row_future['bid'] == 0 && $row_future['bid'] == '-'){
            $this->data->price_futures = $row_future['ask'];
            $this->data->order_maxspd = '-';
        }
        else if(isset($row_future['ask']) && $row_future['ask'] == '-' && $row_future['ask'] == 0 && $row_future['ask'] == '-'){
            $this->data->price_futures = $row_future['bid'];
            $this->data->order_maxspd = '-';
        }
        else{
            $this->data->price_futures = '-';
            $this->data->order_maxspd = '-';
        }
        $this->data->future_format = $row_future;
        //

        return $this->load->view('building/table_trading', $this->data, true);
    }
    public function table_account($dsymbol = '',$height){
        $this->data->height = $height;
        $this->load->model('Futures_model', 'part_account');
        $this->data->sim_account= $this->part_account->getSim_Account();
        return $this->load->view('building/table_account', $this->data, true);
    }
    public function table_portfolio($dsysbol = '',$height){
        $this->data->height  = $height;
        return $this->load->view('building/table_portfolio', $this->data, true);
    }
    public function flotchart($dsysbol = '',$height)
    {
        $this->data->height  = $height;
        return $this->load->view('building/flotchart', $this->data, true);
    }
    public function table_stat($dsysbol = '',$height)
    {
        $this->data->height = $height;
        return $this->load->view('building/table_stat', $this->data, true);
    }
    public function table_specs($dsymbol = 'FVNX25',$height)
    {
        $this->data->height = $height;
        $sql = "select df.*, vcr.format  from dashboard_future df left join vdm_contracts_ref vcr on df.dsymbol = vcr.dsymbol where df.dsymbol = '{$dsymbol}' ORDER BY df.expiry asc";
        $this->data->dashboard_future = $this->db3->query($sql)->result_array();

        return $this->load->view('building/table_specs', $this->data, true);
    }
    public function table_trades($dsymbol = 'FVNX25',$height)
    {
        $this->data->height = $height;
        $sql = "select df.*, vcr.format  from dashboard_future df left join vdm_contracts_ref vcr on df.dsymbol = vcr.dsymbol where df.dsymbol = '{$dsymbol}' ORDER BY df.expiry asc";
        $this->data->dashboard_future = $this->db3->query($sql)->result_array();

        return $this->load->view('building/table_trades', $this->data, true);
    }
    public function table_market($dsymbol = '',$height){
        $this->data->height = $height;
        $sql = "select name, last, var  from vdm_underlying_setting where undtype = 'I' and active > 0 order by vdm_market asc";
        $this->data->simul_markets = $this->db3->query($sql)->result_array();
        //
        return $this->load->view('building/table_market', $this->data, true);
    }
    public function table_by_underlying($dsymbol = '',$height){
        $this->data->height = $height;
        $query = "SELECT vcr.`name`, df.expiry, df.type, df.dsymbol, df.bid, df.ask, df.last, df.qbid, df.qask, df.var, vcr.format
        FROM vdm_contracts_ref vcr LEFT JOIN dashboard_future df ON vcr.dsymbol = df.dsymbol 
        WHERE 
        vcr.active > 0 AND vcr.dsymbol <>'' AND df.type = 'FUTURES' 
        GROUP BY df.dsymbol ORDER BY vcr.order ASC ";
        $this->data->by_underlying =  $this->db3->query($query)->result_array();
        return $this->load->view('building/table_by_underlying', $this->data, true);

    }
    public function table_news($dsymbol = '',$height){
        $this->data->height = $height;
        $sql_simul = "select *  from simul_news where type = 'news' ORDER BY datetime DESC LIMIT 0,5";
        $this->data->simul_news = $this->db->query($sql_simul)->result_array();
        return $this->load->view('building/table_news', $this->data, true);
    }
    public function table_calendar($dsymbol = '',$height){
        $this->data->height = $height;
        $sql_simul_calendar = "select *  from simul_news where type = 'calendar' ORDER BY datetime DESC LIMIT 0,5";
        $this->data->simul_calendar = $this->db->query($sql_simul_calendar)->result_array();
        return $this->load->view('building/table_calendar', $this->data, true);
    }
    public function table_strategies($dsysbol = '',$height){
        $this->data->height = $height;
        $sql_analytics=" select * from simul_article where clean_cat = 'menu' AND clean_scat='analytics' order by `clean_order` asc; ";
        $this->data->analytics = $this->db->query($sql_analytics)->result_array();

        $sql_portfolio=" select * from simul_article where clean_cat = 'menu' AND clean_scat='portfolio' order by `clean_order` asc; ";
        $this->data->portfolio = $this->db->query($sql_portfolio)->result_array();
        //echo "<pre>";print_r($this->data->analytics);exit;
        return $this->load->view('building/table_strategies', $this->data, true);
    }
    public function table_risks($dsysbol = '',$height){
        $this->data->height = $height;
        $sql_analytics=" select * from simul_article where clean_cat = 'menu' AND clean_scat='analytics' order by `clean_order` asc; ";
        $this->data->analytics = $this->db->query($sql_analytics)->result_array();

        $sql_portfolio=" select * from simul_article where clean_cat = 'menu' AND clean_scat='portfolio' order by `clean_order` asc; ";
        $this->data->portfolio = $this->db->query($sql_portfolio)->result_array();
        //echo "<pre>";print_r($this->data->analytics);exit;
        return $this->load->view('building/table_risks', $this->data, true);
    }
    public function table_echart($dsysbol = '',$height){
        $this->data->height = $height;
        return $this->load->view('building/table_echart', $this->data, true);
    }
    public function table_composition($dsysbol = '',$height){
        $this->data->height = $height;
        $db4 = $this->load->database('database4', TRUE);
        $idx_code = substr($_SESSION['array_other_product']['codeint'],3);
        // echo "<pre>";print_r($idx_code);exit;
        $sql = "select date, `stk_name`,`stk_price`, `stk_mcap_idx`, `stk_wgt` from idx_composition_rt where idx_code = '".$idx_code."' ORDER BY `stk_wgt` desc";
        @$this->data->simul_markets = $db4->query($sql)->result_array();
        return $this->load->view('building/table_composition', $this->data, true);
    }
    public function table_pricing($dsysbol = '',$height){
        $this->data->height = $height;
        //$dsymbol = $this->session->userdata('FVNX25');
        $dsymbol = $_SESSION['array_other_product']['dsymbol'];
        $utype = $this->db3->select('vdm_model')->where('dsymbol',$dsymbol)->get('vdm_contracts_ref')->row_array();

        if(!empty($utype)){
            $this->data->name_vdm_model = $this->db3->select('*')->where($utype['vdm_model'],1)->where('product','FUTURES')->get('vdm_model')->result_array();
        }
        //echo "<pre>";print_r($name_vdm_model);exit;
        $this->data->rs = $this->getResult($dsymbol);
        $this->data->vdm_model = $this->db3->select('*')->where('id',3)->get('vdm_model')->row_array();
        //echo "<pre>";print_r($this->data->vdm_model);exit;
        return $this->load->view('building/table_pricing', $this->data, true);
    }
    public function table_seminars($dsysbol = '',$height){
        $this->data->height = $height;
        $sql_news_seminar="select date_format(`datetime`, '%Y-%m-%d') as datetime,title,location from simul_news where type like '%seminar%'; ";
        $this->data->simul_news = $this->db->query($sql_news_seminar)->result_array();

        return $this->load->view('building/table_seminars', $this->data, true);
    }
    public function table_courses($dsysbol = '',$height){
        $this->data->height = $height;

        $sql_news_course="select date_format(`datetime`, '%Y-%m-%d') as datetime,title,location from simul_news where type like '%program%' limit 5; ";
        $this->data->course_news = $this->db->query($sql_news_course)->result_array();

        return $this->load->view('building/table_courses', $this->data, true);
    }
    public function table_events($dsysbol = '',$height){
        $this->data->height = $height;

        $sql_news_event="select date_format(`datetime`, '%Y-%m-%d') as datetime,title,location from simul_news where type like '%event%' limit 5; ";
        $this->data->event_news = $this->db->query($sql_news_event)->result_array();

        return $this->load->view('building/table_events', $this->data, true);
    }
    public function table_glossarys($dsysbol = '',$height){
        $this->data->height = $height;
        $sql_glossary="select * from simul_article where clean_cat='glossary' and lang_code='en'  order by title asc ; ";
        $this->data->glossary = $this->db->query($sql_glossary)->result_array();

        return $this->load->view('building/table_glossarys', $this->data, true);
    }
    public function table_materials($dsysbol = '',$height){
        $this->data->height = $height;
        $sql_material="select clean_scat,title,description,`by`, url from simul_article 
where lang_code='en' and clean_scat in ('books','video','media') order by date_update desc;";
        $this->data->material = $this->db->query($sql_material)->result_array();
        return $this->load->view('building/table_materials', $this->data, true);
    }
    public function table_quizzes($dsysbol = '',$height){
        $this->data->height = $height;
        $sql_quiz=" select * from simul_article where clean_cat='education' AND clean_scat='quiz' order by `clean_order` asc; ";
        $this->data->quiz = $this->db->query($sql_quiz)->result_array();
        return $this->load->view('building/table_quizzes', $this->data, true);
    }
    public function table_futures_strategies($dsysbol = '',$height){
        $this->data->height = $height;
        $array = array();
        $sql = "SELECT `tab`, `name`, `opt_fut` FROM vdm_strategy_setting Order by id;";
        $data = $this->db->query($sql)->result_array();
        foreach($data as $value){
            $array[$value['opt_fut']][] = $value;
        }
        $this->data->array = $array;
        return $this->load->view('building/table_futures_strategies', $this->data, true);
    }
    public function table_options_strategies($dsysbol = '',$height){
        $this->data->height = $height;
        $array = array();
        $sql = "SELECT `tab`, `name`, `opt_fut` FROM vdm_strategy_setting Order by id;";
        $data = $this->db->query($sql)->result_array();
        foreach($data as $value){
            $array[$value['opt_fut']][] = $value;
        }
        $this->data->array = $array;
        return $this->load->view('building/table_options_strategies', $this->data, true);
    }

    public function table_module1($dsysbol = '',$height){
        $this->data->height = $height;
        return $this->load->view('building/table_module1', $this->data, true);
    }
    public function table_module2($dsysbol = '',$height){
        $this->data->height = $height;
        return $this->load->view('building/table_module2', $this->data, true);
    }
    public function table_module3($dsysbol = '',$height){
        $this->data->height = $height;
        return $this->load->view('building/table_module3', $this->data, true);
    }
    public function table_module4($dsysbol = '',$height){
        $this->data->height = $height;
        return $this->load->view('building/table_module4', $this->data, true);
    }
    public function table_available_modules($dsysbol = '',$height){
        $this->data->height = $height;
        return $this->load->view('building/table_avaitable_modules', $this->data, true);
    }
    public function table_answer_questions($dsysbol = '',$height){
        $this->data->height = $height;
        $sql_faq="select * from simul_article where clean_cat = 'education' AND clean_scat='faq' order by `clean_order` asc;";
        $this->data->questions = $this->db->query($sql_faq)->result_array();
        return $this->load->view('building/table_answer_questions', $this->data, true);
    }
    public function table_contacts($dsysbol = '',$height){
        $this->data->height = $height;
        //captcha
        $this->load->helper('captcha');
        $random_number = substr(number_format(time() * rand(),0,'',''),0,6);
        // setting up captcha config
        $vals = array(
            'word' => $random_number,
            'img_path' => './capcha/',
            'img_url' => base_url().'capcha/',
            'img_width' => 200,
            'img_height' => 46,
            'expiration' => 7200
        );
        $this->data->captcha = create_captcha($vals);
        //echo "<pre>";print_r($this->session->all_userdata());exit;
        $this->session->set_userdata('captchaWord',$this->data->captcha['word']);
        $this->data->captcha_image = $this->session->userdata('captchaWord');

        //send mail
        if ($this->input->post())
        {
            //echo "<pre>";print_r($this->input->post());exit;
            $this->data->input = $this->input->post();

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');

            $to = 'xuanhung1606@gmail.com';
            $subject = "Email contact of {$name} ({$email})";
            $message = $message;
            $send = $this->sendmail($to, $to, $name, $subject, $message, $to, $to);
            /*echo $send == 1 ? '<script>alert("Send message successfull"); window.location.href="' . base_url().'futures_help' . '"</script>' : '';*/


        }


        return $this->load->view('building/table_contacts', $this->data, true);
    }
    public function sendmail($mailto, $nameto, $namefrom, $subject, $noidung, $namereplay, $emailreplay)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = "mail.ifrc.vn"; // specify main and backup server
        $mail->Port = 465; // set the port to use
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPSecure = "ssl";
        $mail->Username = "news@upmd.fr"; // your SMTP username or your gmail username// Email gui thu
        $mail->Password = "DmPuswen"; // your SMTP password or your gmail password
        //$from = $mailfrom; // Reply to this email// Email khi reply
        $mail->CharSet = "utf-8";
        $from = $emailreplay; // Reply to this email// Email khi reply
        $to = $mailto; // Recipients email ID // Email nguoi nhan
        $name = $nameto; // Recipient's name // Ten cua nguoi nhan
        $mail->From = $from;
        $mail->FromName = $namefrom; // Name to indicate where the email came from when the recepient received// Ten nguoi gui
        $mail->AddAddress($to, $name);
        $mail->AddReplyTo($from, $namereplay); // Ten trong tieu de khi tra loi
        $mail->WordWrap = 50; // set word wrap
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = $subject;
        $mail->Body = $noidung; //HTML Body
        $mail->AltBody = ""; //Text Body

        if (!$mail->Send())
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

}