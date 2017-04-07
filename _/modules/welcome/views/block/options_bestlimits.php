
    <div class="portlet box red blocks" style="margin-bottom:5px; position:relative;">
    
        <div class="portlet-title header-table">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_best_limit'); ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
        </div>
        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_scroll table_cus">
                    <thead>
                        <tr>
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('head_tb_cp'); ?></h6> </th>
                            <th class="th_custom" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_expiry'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_strike'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_qbid'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_bid'); ?></h6></th>
                            <th class="th_custom" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_ask'); ?></h6></th>
                            <th class="th_custom" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_qask'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_time'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_theo'); ?></h6></th>
                          
                        </tr>
                    </thead>
                    <tbody>
                    
                         <?php 
					//echo "<pre>";print_r($finances);exit;
					foreach($options_order as $key => $options){
						$mmm = substr(strftime('%B',strtotime($options['expiry'])),0,3);
           				 $yy = strftime('%y',strtotime($options['expiry']));
						 
						  if(isset($options['format'])){
								$find_format = strpos($options['format'],'.');
								$find_comma = strpos($options['format'],',');
								if(isset($find_format) && $find_format){
									$explode = explode(".",$options['format']);
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
						?>
                        <tr>
                            <td class="td_custom cus_pri"> <?php echo $options['type'];?> </td>
                            <td class="td_custom option_best_limit_expiry" align="left" id="option_best_limit_expiry_<?php echo $key ?>"><?php echo strtoupper($mmm.'-'.$yy);?></td>
                            <td class="td_custom option_best_limit_strike" align="right" id="option_best_limit_strike_<?php echo $key ?>"><?php echo ($options['strike'] != NULL && $options['strike'] !='-')? number_format($options['strike'],0,'.',','):'';?></td>
                            <td class="td_custom option_best_limit_qbid" align="right" id="option_best_limit_qbid_<?php echo $key ?>"><?php echo ($options['qbid'] != NULL && $options['qbid'] !='-')? number_format($options['qbid'],0,'.',','):'';?></td>
                            <td class="td_custom " align="right">
							<span id="option_best_limit_bid_<?php echo $key ?>" class=" option_best_limit_bid <?php echo ($options['bid'] != NULL && $options['bid'] !='-')? 'bg_color_red': '';?>">
							<?php echo ($options['bid'] != NULL && $options['bid'] !='-') ? number_format($options['bid'],$get_decimal,'.',$get_comma):'';?>
                            </span>
                            </td>
                            <td class="td_custom " align="left" >
							<span id="option_best_limit_ask_<?php echo $key ?>" class=" option_best_limit_ask <?php echo ($options['ask'] != NULL && $options['ask'] !='-')? 'bg_color_green': '';?>">
							<?php echo ($options['ask'] != NULL && $options['ask'] !='-') ? number_format($options['ask'],$get_decimal,'.',$get_comma):'';?>
                            </span>
                            </td>
                            <td class="td_custom option_best_limit_qask" align="left" id="option_best_limit_qask_<?php echo $key ?>"><?php echo ($options['qask'] != NULL && $options['qask'] !='-') ? number_format($options['qask'],0,'.',','):'';?></td>
                            <td class="td_custom option_best_limit_last" align="right" id="option_best_limit_last_<?php echo $key ?>"><?php echo ($options['last'] != NULL) ? number_format($options['last'],$get_decimal,'.',$get_comma):'';?></td>
                           <td class="td_custom option_best_limit_time" align="right" id="option_best_limit_time_<?php echo $key ?>"><?php
						   if(!empty($options['time'])){
							if(date("Y-m-d") > date("Y-m-d",strtotime($options['time'])))
								echo date("Y-m-d",strtotime($options['time']));
								else echo date("H:i:s",strtotime($options['time']));
						   }
								?></td>
                            <td class="td_custom option_best_limit_implied" align="right" id="option_best_limit_implied_<?php echo $key ?>"><?php echo ($options['theo'] != NULL) ? number_format($options['theo'],$get_decimal,'.',$get_comma):'';?></td>
                         
                        </tr>
                     <?php }?>
                     
                    </tbody>
                </table>
            </div>
        </div>
 
        
    </div>
    
      <div class="portlet box red blocks" style="position:relative;">
     <div class="portlet-title header-table">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_trades'); ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
                
        </div>
        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_scroll table_cus">
                    <thead>
                        <tr>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_cp'); ?></h6> </th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_expiry'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_strike'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6> </th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_change'); ?></h6> </th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_volume'); ?></h6></th>
                             <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_dvolume'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_position'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_settlement'); ?></h6></th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php 
					//echo "<pre>";print_r($finances);exit;
					foreach($options_order as $key => $finances){
						$mmm = substr(strftime('%B',strtotime($finances['expiry'])),0,3);
           				 $yy = strftime('%y',strtotime($finances['expiry']));
						   if(isset($finances['format'])){
								$find_format = strpos($finances['format'],'.');
								$find_comma = strpos($finances['format'],',');
								if(isset($find_format) && $find_format){
									$explode = explode(".",$finances['format']);
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
						?>
                        <tr>
                            <td class="td_custom cus_pri"> <?php echo $finances['type'];?> </td>
                            <td class="td_custom option_best_limit_expiry" id="option_best_limit_expiry_<?php echo $key ?>"><?php echo strtoupper($mmm.'-'.$yy);?></td>
                            <td class="td_custom option_best_limit_strike" align="right" id="option_best_limit_strike_<?php echo $key ?>"><?php echo ($finances['strike'] != NULL && $finances['strike'] !='-')? number_format($finances['strike'],0,'.',','):'';?></td>
                            <td class="td_custom option_best_limit_last" align="right" id="option_best_limit_last_<?php echo $key ?>"><?php echo ($finances['last'])? number_format($finances['last'],$get_decimal,'.',$get_comma):'';?></td>
                            <td class="td_custom option_best_limit_change" align="right" id="option_best_limit_change_<?php echo $key ?>"><?php 
							if($finances['change'] >= 0){
								echo ($finances['change'] != NULL) ? '<span class="po">+'.number_format($finances['change'],$get_decimal,'.',$get_comma).'</span>':'';
							}else{
								echo ($finances['change'] != NULL) ? '<span class="di">'.number_format($finances['change'],$get_decimal,'.',$get_comma).'</span>':'';	
							}
							?></td>
                            <td class="td_custom option_best_limit_var" align="right" id="option_best_limit_var_<?php echo $key ?>"><?php 
							if($finances['var'] >= 0){
								echo ($finances['var'] != NULL) ? '<span class="po">+'.number_format($finances['var'],$get_decimal,'.',$get_comma).'%</span>':'';
							}else{
								echo ($finances['var'] != NULL) ? '<span class="di">'.number_format($finances['var'],$get_decimal,'.',$get_comma).'%</span>':'';	
							}?></td>
                            <td class="td_custom option_best_limit_volume" align="right" id="option_best_limit_volume_<?php echo $key ?>"><?php echo ($finances['volume'] != NULL) ? number_format($finances['volume'],0,'.',','):'';?></td>
                             <td class="td_custom option_best_limit_dvolume" align="right" id="option_best_limit_dvolume_<?php echo $key ?>"><?php echo ($finances['dvolume'] != NULL) ? number_format($finances['dvolume'],0,'.',','):'';?></td>
                            <td class="td_custom option_best_limit_oi" align="right" id="option_best_limit_oi_<?php echo $key ?>"><?php echo ($finances['oi'] != NULL) ? number_format($finances['oi'],0,'.',','):'';?></td>
                            <td class="td_custom option_best_limit_settle" align="right" id="option_best_limit_settle_<?php echo $key ?>"><?php echo ($finances['settle'] != NULL) ? number_format($finances['settle'],$get_decimal,'.',$get_comma):'';?></td>
                        </tr>
                     <?php }?>
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  
