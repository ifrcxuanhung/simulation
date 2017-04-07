
<div class="portlet box red blocks">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_specifications');?></div>
            <div class="tools">
           <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
      
    </div>
    <div class="portlet-body background_portlet">
        <div class="table-responsive" >
            <table class="table table-bordered table-hover table_cus">
                <thead>

                </thead>
                <tbody>
                <?php 
				
		//echo "<pre>";print_r($list_spe);exit;
				foreach($list_spe as $val){?>
                    <tr>
                       
                        <td class="td_custom " width="35%"><a class="cus_pri getval_tooltip upper_title format_fi" data-target="#info_box" data-toggle="modal" id="<?php echo $val['code'];?>"><?php trans_table($val['code']);?></a></td>
                        <td class="td_custom font_color" width="65%" ><?php 
						$find_format = strpos($val['format'],'.');
						$find_comma = strpos($val['format'],',');
						
						if(isset($find_format) && $find_format){
							$explode = explode(".",$val['format']);
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
						
						if($val['format'] != '' && $val['format'] != NULL){
							if($val['value'] == 0.00)
								echo '-';
							else
								echo number_format($val['value'],$get_decimal,'.',$get_comma);
						}else{
							if($val['value'] == ''){
								echo '-';
							}
							else{
								$check_upper_first = explode(" ",$val['value']);
								$get_array_first = array_shift($check_upper_first);
								//echo "<pre>";print_r($check_upper_first);
								if(!ctype_upper($get_array_first)){
									echo '<div class="format_fi">'.$val['value'].'</div>';	
								}else{
									echo '<span class="float_left">'.$get_array_first.'&nbsp;</span><div class="format_fi float_left">'.implode(" ",$check_upper_first).'</div>';		
								}
							}
						}
						?></td>
                      
                       
                    </tr>
               <?php }?>
                    
                  
                </tbody>
            </table>
        </div>
    </div>
</div>
