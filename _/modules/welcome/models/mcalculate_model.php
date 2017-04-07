<?php
class Mcalculate_model extends CI_Model{
    protected $_lang;
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->_lang = $this->session->userdata('curent_language');
    }
    
    function normal($x){
        if($x<0){
            return 1-$this->normal(-$x);
            }
        if($x == 0)
        {
            return 0.5;
        }
            $k = 1.0 / (1.0 + 0.2316419 * $x);
            $y = 1.0 - exp(-$x * $x / 2) * $k * (0.31938153 +
                    $k * (-0.356563782 +
                      $k * (1.781477937 +
                        $k * (-1.821255978 +
                          $k * 1.330274429)))) / sqrt(6.28318530717958646);
        return $y;
    }
    function fnormal($x){ 
        $y = exp(-$x * $x / 2) /sqrt(2*PI());
        return $y;
    }
    /*--
    Hàm này tính buycal,buyput,Ventecall,Writeput
    Ðây là d?ng : 1 C hoac 1 P
    --*/
    function Calculate_1($S,$K,$R,$T,$Sigma,$Q,$II='100',$calls = 'c',$Achat=1, $Quantity_1=1){
        $RR = $R/100;
        $QQ=$Q/100;
        $Sigmaa = $Sigma/100;
        $Temps = $T/365;
        $d1= (log($S/$K)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2=$d1-$Sigmaa*sqrt($Temps);
        $call =  $S*exp(-$QQ*$Temps)* $this->normal($d1)-$K*exp(-$RR*$Temps)* $this->normal($d2);
        $put  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1)+$K*exp(-$RR*$Temps)* $this->normal(-$d2);
        $deltac = exp(-$QQ*$Temps)*$this->normal($d1);
        $deltap = exp(-$QQ*$Temps)*($this->normal($d1)-1);
        $gammac = $this->fnormal($d1)/($S*$Sigmaa*sqrt($Temps));
        $gammap = $gammac;
        $vegac=$S*sqrt($Temps)*$this->fnormal($d1)*exp(-$QQ*$Temps);
        $vegap=$vegac;
        $interval = $this->db->query("SELECT `interval` as I FROM  simul_interval WHERE {$K} BETWEEN smin and smax ORDER BY `interval` DESC limit 1")->row_array();
        $I = $interval['I'];
        //$thetac = -($S*exp(-$QQ*$Temps)*$Sigmaa*$this->fnormal($d1))/(2*sqrt($Temps)) + $QQ*$S*exp(-$QQ*$Temps)*$this->normal($d1) - $RR*$K*exp(-$RR*$Temps)*$this->normal($d2);
        //$thetap = -($S*exp(-$QQ*$Temps)*$Sigmaa*$this->fnormal($d1))/(2*sqrt($Temps)) - $QQ*$S*exp(-$QQ*$Temps)*$this->normal(-$d1) + $RR*$K*exp(-$RR*$Temps)*$this->normal(-$d2);
        $su = $K;
         //print_R($I);exit;
            $i = 1;
            for($i;$i<=4;$i++){
                $su = $su - $I;
                $support[] = $su;
                
            }
            $su = $K;
            $n = 1;
            for($n;$n<=4;$n++){
                $su = $su + $I;
                $support[] = $su;
            }
        $support[] = $K;
        sort($support);
        $v = 1;
        for($v;$v<=9;$v++){
            $t = $v -1;
            $vars[] = ((($support[$t]/$S) - 1)*100);
            if($calls == "c"){
                $max = max(0,($support[$t] - $K));
                $Option = $max - $call;
            }else if($calls == "p"){
                $max = max(0,(-$support[$t] + $K));
                $Option = $max - $put;   
            }
			else if ($calls== "s"){
				$Option = $support[$t] - $K;
			}
			$Options[] = $Achat * $Option * $Quantity_1;          
			if($calls == "p"){
				 @$Perf[] = ($Options[$t]/$put) * 100;
			}
			else if($calls == "c")
            @$Perf[] = ($Options[$t]/$call) * 100;
			else 
			 @$Perf[] = 0;
        }
        $arr_data = array('support'=>$support,'vars'=>$vars,'Options'=>$Options,'Perf'=>$Perf);
        return $arr_data;          
    }
    /*
    Hàm này tính Achat dun papillon, Vente dun papillon
    Ðây là d?ng : 1 1 C va -1 C hoac -1 -1 C va 1 C 
    */
    function Ftheo($LS, $LR, $LT, $LQ) {
        $Theorique = $LS * (1 + ($LR - $LQ) * ($LT / 360));
        return $Theorique;
    }
    
    function Calculate_F($S,$R,$T,$Q,$M,$Achat=1){
        $RR = $R/100;
        $QQ=$Q/100;
        $interval = $this->db->query("SELECT `interval_f` as I FROM  simul_interval WHERE {$S} BETWEEN smin and smax ORDER BY `interval` DESC limit 1")->row_array();
        $I = $interval['I'];
        //print_R($I);exit;
        $MM = $M / 100;
        $fv = $this->Ftheo($S, $RR, $T, $QQ);
        $bv = $fv - $S;
        $mv = $S * $MM;
        $su = $S;
        $i = 1;
        for($i;$i<=4;$i++){
            $su = $su - $I;
            $support[] = $su;
            
        }
        $su = $S;
        $n = 1;
        for($n;$n<=4;$n++){
            $su = $su + $I;
            $support[] = $su;
        }
        $support[] = $S;
        sort($support);
        $v = 1;
        for($v;$v<=9;$v++){
            $t = $v -1;
            $vars[] = (($support[$t]-$S)/$S)*100;
            $net[] = ($support[$t] - $fv)*$Achat;  
            $Perf[] = ((($support[$t] - $fv)*$Achat)/$mv)*100;
        }
        $arr_data = array('support'=>$support,'vars'=>$vars,'net'=>$net,'Perf'=>$Perf);
        return $arr_data;          
    }
	/*
    Hàm này tính Achat dun papillon, Vente dun papillon
    Ðây là d?ng : 1 1 C va -1 C hoac -1 -1 C va 1 C 
    */
    function Calculate_2($S,$K_1,$K_2,$R,$T,$Sigma,$Q,$II='100',$Type_1 = 'c',$Type_2='c',  $Achat_1=1,$Achat_2=1, $Quantity_1=1, $Quantity_2=1){
		$RR = $R/100;
        $QQ=$Q/100;
        $Sigmaa = $Sigma/100;
        $Temps = $T/365;
        $d1_1= (log($S/$K_1)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_1=$d1_1-$Sigmaa*sqrt($Temps);
		$call_1 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_1)-$K_1*exp(-$RR*$Temps)* $this->normal($d2_1);
        $put_1  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_1)+$K_1*exp(-$RR*$Temps)* $this->normal(-$d2_1);
        
		$d1_2= (log($S/$K_2)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_2=$d1_2-$Sigmaa*sqrt($Temps);
		$call_2 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_2)-$K_2*exp(-$RR*$Temps)* $this->normal($d2_2);
        $put_2  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_2)+$K_2*exp(-$RR*$Temps)* $this->normal(-$d2_2);
        $interval = $this->db->query("SELECT `interval` as I FROM  simul_interval WHERE {$S} BETWEEN smin and smax ORDER BY `interval` DESC limit 1")->row_array();
        $I = $interval['I'];
        $su = $S;
            $i = 1;
            for($i;$i<=4;$i++){
                $su = $su - $I;
                $support[] = $su;
                
            }
            $su = $S;
            $n = 1;
            for($n;$n<=4;$n++){
                $su = $su + $I;
                $support[] = $su;
            }
        $support[] = $S;
        sort($support);
        $v_1 = 1;
        for($v_1;$v_1<=9;$v_1++){
            $t_1 = $v_1 -1;
            $vars_1[] = ((($support[$t_1]/$S) - 1)*100);
            if($Type_1 == "c"){
                $max_1 = max(0,($support[$t_1] - $K_1));
                $Option_1 = $max_1 - $call_1;
            }else if($Type_1 == "p"){
                $max_1 = max(0,(-$support[$t_1] + $K_1));
                $Option_1 = $max_1 - $put_1;   
            }
			else if ($Type_1== "s"){
				$Option_1 = $support[$t_1] - $K_1;
			}
			$Options_1[] = $Achat_1 * $Option_1 * $Quantity_1;          
           // @$Perf[] = ($Options[$t]/$call) * 100;
        }
		$tong_put = (abs($Achat_1) * ($Type_1 == "p" ? $put_1 : ($Type_1 == "c" ? $call_1 : 0))) + (abs($Achat_2) * ($Type_2 == "p" ? $put_2 : ($Type_2 == "c" ? $call_2 : 0))) ;
		$v_2 = 1;
        for($v_2;$v_2<=9;$v_2++){
            $t_2 = $v_2 -1;
            //$vars_2[] = ((($support[$t_2]/$S) - 1)*100);
            if($Type_2 == "c"){
                $max_2 = max(0,($support[$t_2] - $K_2));
                $Option_2 = $max_2 - $call_2;
            }else if($Type_2 == "p"){
                $max_2 = max(0,(-$support[$t_2] + $K_2));
                $Option_2 = $max_2 - $put_2;   
            }
			else if ($Type_2== "s"){
				$Option_2 = $support[$t_2] - $K_2;
			}
			$Options_2[] = $Achat_2 * $Option_2 * $Quantity_2;  
			$combinee[] = $Options_1[$t_2] + $Options_2[$t_2]; 
			if($tong_put!=0)       
           		@$Perf[] = ($combinee[$t_2]/$tong_put) * 100;     
		   else 
		   		@$Perf[] = 0;
        }
		$arr_data = array('support'=>$support,'vars'=>$vars_1,'Pattes_1'=>$Options_1,'Pattes_2'=>$Options_2, 'combinee'=>$combinee,'Perf'=>$Perf);  
        return $arr_data;        
    }
    /*
    Hàm này tính Achat dun papillon, Vente dun papillon
    Ðây là d?ng : 1 1 C va -1 C hoac -1 -1 C va 1 C 
    */
    function Calculate_3($S,$K_1,$K_2,$K_3,$R,$T,$Sigma,$Q,$II='100',$Type_1 = 'c',$Type_2='c', $Type_3 = 'c', $Achat_1=1,$Achat_2=1,$Achat_3=1, $Quantity_1=1, $Quantity_2=1, $Quantity_3=1){
		$RR = $R/100;
        $QQ=$Q/100;
        $Sigmaa = $Sigma/100;
        $Temps = $T/365;
        $d1_1= (log($S/$K_1)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_1=$d1_1-$Sigmaa*sqrt($Temps);
		$call_1 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_1)-$K_1*exp(-$RR*$Temps)* $this->normal($d2_1);
        $put_1  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_1)+$K_1*exp(-$RR*$Temps)* $this->normal(-$d2_1);
        
		$d1_2= (log($S/$K_2)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_2=$d1_2-$Sigmaa*sqrt($Temps);
		$call_2 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_2)-$K_2*exp(-$RR*$Temps)* $this->normal($d2_2);
        $put_2  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_2)+$K_2*exp(-$RR*$Temps)* $this->normal(-$d2_2);
		
		$d1_3= (log($S/$K_3)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_3=$d1_3-$Sigmaa*sqrt($Temps);
		$call_3 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_3)-$K_3*exp(-$RR*$Temps)* $this->normal($d2_3);
        $put_3  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_3)+$K_3*exp(-$RR*$Temps)* $this->normal(-$d2_3);
		
        /*$deltac = exp(-$QQ*$Temps)*$this->normal($d1);
        $deltap = exp(-$QQ*$Temps)*($this->normal($d1)-1);
        $gammac = $this->fnormal($d1)/($S*$Sigmaa*sqrt($Temps));
        $gammap = $gammac;
        $vegac=$S*sqrt($Temps)*$this->fnormal($d1)*exp(-$QQ*$Temps);
        $vegap=$vegac;*/
        $interval = $this->db->query("SELECT `interval` as I FROM  simul_interval WHERE {$S} BETWEEN smin and smax ORDER BY `interval` DESC limit 1")->row_array();
        $I = $interval['I'];
        $su = $S;
            $i = 1;
            for($i;$i<=4;$i++){
                $su = $su - $I;
                $support[] = $su;
                
            }
            $su = $S;
            $n = 1;
            for($n;$n<=4;$n++){
                $su = $su + $I;
                $support[] = $su;
            }
        $support[] = $S;
        sort($support);
        $v_1 = 1;
        for($v_1;$v_1<=9;$v_1++){
            $t_1 = $v_1 -1;
            $vars_1[] = ((($support[$t_1]/$S) - 1)*100);
            if($Type_1 == "c"){
                $max_1 = max(0,($support[$t_1] - $K_1));
                $Option_1 = $max_1 - $call_1;
            }else if($Type_1 == "p"){
                $max_1 = max(0,(-$support[$t_1] + $K_1));
                $Option_1 = $max_1 - $put_1;   
            }
			else if ($Type_1== "s"){
				$Option_1 = $support[$t_1] - $K_1;
			}
			$Options_1[] = $Achat_1 * $Option_1 * $Quantity_1;          
           // @$Perf[] = ($Options[$t]/$call) * 100;
        }
		$v_2 = 1;
        for($v_2;$v_2<=9;$v_2++){
            $t_2 = $v_2 -1;
            //$vars_2[] = ((($support[$t_2]/$S) - 1)*100);
            if($Type_2 == "c"){
                $max_2 = max(0,($support[$t_2] - $K_2));
                $Option_2 = $max_2 - $call_2;
            }else if($Type_2 == "p"){
                $max_2 = max(0,(-$support[$t_2] + $K_2));
                $Option_2 = $max_2 - $put_2;   
            }
			else if ($Type_2== "s"){
				$Option_2 = $support[$t_2] - $K_2;
			}
			$Options_2[] = $Achat_2 * $Option_2 * $Quantity_2;          
           // @$Perf[] = ($Options[$t]/$call) * 100;
        }
		$tong_put = (abs($Achat_1) * ($Type_1 == "p" ? $put_1 : ($Type_1 == "c" ? $call_1 : 0))) + (abs($Achat_2) * ($Type_2 == "p" ? $put_2 : ($Type_2 == "c" ? $call_2 : 0))) + (abs($Achat_3) * ($Type_3 == "p" ? $put_3 : ($Type_3 == "c" ? $call_3 : 0))) ;
		$v_3 = 1;
        for($v_3;$v_3<=9;$v_3++){
            $t_3 = $v_3 -1;
           // $vars_3[] = ((($support[$t_3]/$S) - 1)*100);
            if($Type_3 == "c"){
                $max_3 = max(0,($support[$t_3] - $K_3));
                $Option_3 = $max_3 - $call_3;
            }else if($Type_3 == "p"){
                $max_3 = max(0,(-$support[$t_3] + $K_3));
                $Option_3 = $max_3 - $put_3;   
            }
			else if ($Type_3== "s"){
				$Option_3 = $support[$t_3] - $K_3;
			}
			$Options_3[] = $Achat_3 * $Option_3 * $Quantity_3;   
			$combinee[] = $Options_1[$t_3] + $Options_2[$t_3] + $Options_3[$t_3];
			//Performance = combinee chia cho tong_put 
			if($tong_put !=0)
				@$Perf[] = ($combinee[$t_3]/$tong_put) * 100;       
			else 
				@$Perf[] = 0;
           // @$Perf[] = ($Options[$t]/$call) * 100;
        }
		$arr_data = array('support'=>$support,'vars'=>$vars_1,'Pattes_1'=>$Options_1,'Pattes_2'=>$Options_2,
                                'Pattes_3'=>$Options_3,'combinee'=>$combinee,'Perf'=>$Perf);  
        return $arr_data;        
    }
	 /*
    Hàm này tính Achat dun papillon, Vente dun papillon
    Ðây là d?ng : 1 1 C va -1 C hoac -1 -1 C va 1 C 
    */
    function Calculate_4($S,$K_1,$K_2,$K_3,$K_4,$R,$T,$Sigma,$Q,$II='100',$Type_1 = 'c',$Type_2='c', $Type_3 = 'c',$Type_4 = 'c', $Achat_1=1,$Achat_2=1,$Achat_3=1,$Achat_4=1, $Quantity_1=1, $Quantity_2=1, $Quantity_3=1, $Quantity_4=1){
		$RR = $R/100;
        $QQ=$Q/100;
        $Sigmaa = $Sigma/100;
        $Temps = $T/365;
        $d1_1= (log($S/$K_1)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_1=$d1_1-$Sigmaa*sqrt($Temps);
		$call_1 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_1)-$K_1*exp(-$RR*$Temps)* $this->normal($d2_1);
        $put_1  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_1)+$K_1*exp(-$RR*$Temps)* $this->normal(-$d2_1);
        
		$d1_2= (log($S/$K_2)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_2=$d1_2-$Sigmaa*sqrt($Temps);
		$call_2 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_2)-$K_2*exp(-$RR*$Temps)* $this->normal($d2_2);
        $put_2  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_2)+$K_2*exp(-$RR*$Temps)* $this->normal(-$d2_2);
		
		$d1_3= (log($S/$K_3)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_3=$d1_3-$Sigmaa*sqrt($Temps);
		$call_3 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_3)-$K_3*exp(-$RR*$Temps)* $this->normal($d2_3);
        $put_3  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_3)+$K_3*exp(-$RR*$Temps)* $this->normal(-$d2_3);
		
		$d1_4= (log($S/$K_4)+($RR-$QQ+0.5*$Sigmaa*$Sigmaa)*$Temps)/($Sigmaa*sqrt($Temps));
        $d2_4=$d1_4-$Sigmaa*sqrt($Temps);
		$call_4 =  $S*exp(-$QQ*$Temps)* $this->normal($d1_4)-$K_4*exp(-$RR*$Temps)* $this->normal($d2_4);
        $put_4  = -$S*exp(-$QQ*$Temps)*$this->normal(-$d1_4)+$K_4*exp(-$RR*$Temps)* $this->normal(-$d2_4);
		
        /*$deltac = exp(-$QQ*$Temps)*$this->normal($d1);
        $deltap = exp(-$QQ*$Temps)*($this->normal($d1)-1);
        $gammac = $this->fnormal($d1)/($S*$Sigmaa*sqrt($Temps));
        $gammap = $gammac;
        $vegac=$S*sqrt($Temps)*$this->fnormal($d1)*exp(-$QQ*$Temps);
        $vegap=$vegac;*/
        $interval = $this->db->query("SELECT `interval` as I FROM  simul_interval WHERE {$S} BETWEEN smin and smax ORDER BY `interval` DESC limit 1")->row_array();
        $I = $interval['I'];
        $su = $S;
            $i = 1;
            for($i;$i<=4;$i++){
                $su = $su - $I;
                $support[] = $su;
                
            }
            $su = $S;
            $n = 1;
            for($n;$n<=4;$n++){
                $su = $su + $I;
                $support[] = $su;
            }
        $support[] = $S;
        sort($support);
        $v_1 = 1;
        for($v_1;$v_1<=9;$v_1++){
            $t_1 = $v_1 -1;
            $vars_1[] = ((($support[$t_1]/$S) - 1)*100);
            if($Type_1 == "c"){
                $max_1 = max(0,($support[$t_1] - $K_1));
                $Option_1 = $max_1 - $call_1;
            }else if($Type_1 == "p"){
                $max_1 = max(0,(-$support[$t_1] + $K_1));
                $Option_1 = $max_1 - $put_1;   
            }
			else if ($Type_1== "s"){
				$Option_1 = $support[$t_1] - $K_1;
			}
			$Options_1[] = $Achat_1 * $Option_1 * $Quantity_1;          
           // @$Perf[] = ($Options[$t]/$call) * 100;
        }
		$v_2 = 1;
        for($v_2;$v_2<=9;$v_2++){
            $t_2 = $v_2 -1;
            //$vars_2[] = ((($support[$t_2]/$S) - 1)*100);
            if($Type_2 == "c"){
                $max_2 = max(0,($support[$t_2] - $K_2));
                $Option_2 = $max_2 - $call_2;
            }else if($Type_2 == "p"){
                $max_2 = max(0,(-$support[$t_2] + $K_2));
                $Option_2 = $max_2 - $put_2;   
            }
			else if ($Type_2== "s"){
				$Option_2 = $support[$t_2] - $K_2;
			}
			$Options_2[] = $Achat_2 * $Option_2 * $Quantity_2;          
           // @$Perf[] = ($Options[$t]/$call) * 100;
        }
		$v_3 = 1;
        for($v_3;$v_3<=9;$v_3++){
            $t_3 = $v_3 -1;
           // $vars_3[] = ((($support[$t_3]/$S) - 1)*100);
            if($Type_3 == "c"){
                $max_3 = max(0,($support[$t_3] - $K_3));
                $Option_3 = $max_3 - $call_3;
            }else if($Type_3 == "p"){
                $max_3 = max(0,(-$support[$t_3] + $K_3));
                $Option_3 = $max_3 - $put_3;   
            }
			else if ($Type_3== "s"){
				$Option_3 = $support[$t_3] - $K_3;
			}
			$Options_3[] = $Achat_3 * $Option_3 * $Quantity_3;         
        }
		//$tong_put = (abs($Achat_1) * $call_1) + (abs($Achat_2) * $call_2) + (abs($Achat_3) * $call_3)+ (abs($Achat_4) * $call_4); 
		$tong_put = (abs($Achat_1) * ($Type_1 == "p" ? $put_1 : ($Type_1 == "c" ? $call_1 : 0))) + (abs($Achat_2) * ($Type_2 == "p" ? $put_2 : ($Type_2 == "c" ? $call_2 : 0))) + (abs($Achat_3) * ($Type_3 == "p" ? $put_3 : ($Type_3 == "c" ? $call_3 : 0))) + (abs($Achat_4) * ($Type_4 == "p" ? $put_4 : ($Type_4 == "c" ? $call_4 : 0))) ;
		$v_4 = 1;
        for($v_4;$v_4<=9;$v_4++){
            $t_4 = $v_4 -1;
           // $vars_3[] = ((($support[$t_3]/$S) - 1)*100);
            if($Type_4 == "c"){
                $max_4 = max(0,($support[$t_4] - $K_4));
                $Option_4 = $max_4 - $call_4;
            }else if($Type_4 == "p"){
                $max_4 = max(0,(-$support[$t_4] + $K_4));
                $Option_4 = $max_4 - $put_4;   
            }
			else if ($Type_4== "s"){
				$Option_4 = $support[$t_4] - $K_4;
			}
			$Options_4[] = $Achat_4 * $Option_4 * $Quantity_4;   
			$combinee[] = $Options_1[$t_4] + $Options_2[$t_4] + $Options_3[$t_4]+ $Options_4[$t_4];
			//Performance = combinee chia cho tong_put 
			if($tong_put !=0)
				@$Perf[] = ($combinee[$t_4]/$tong_put) * 100;      
			else
			 	@$Perf[] = 0;
           // @$Perf[] = ($Options[$t]/$call) * 100;
        }
		$arr_data = array('support'=>$support,'vars'=>$vars_1,'Pattes_1'=>$Options_1,'Pattes_2'=>$Options_2,
                                'Pattes_3'=>$Options_3,'Pattes_4'=>$Options_4,'combinee'=>$combinee,'Perf'=>$Perf);  
        return $arr_data;        
    }
}