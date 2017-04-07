
    <div class="portlet box red blocks" style="margin-bottom:5px; position:relative;">
    
        <div class="portlet-title header-table">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_best_limits'); ?></div>
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
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('head_tb_expiry'); ?></h6> </th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_qbid'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_bid'); ?></h6></th>
                            <th class="th_custom" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_ask'); ?></h6></th>
                            <th class="th_custom" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_qask'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_time'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_theoretical'); ?></h6></th>
                          
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					//\\echo "<pre>";print_r($dashboard_future);exit;
					
					foreach($dashboard_future as $key => $finances){
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
                            <td class="td_custom cus_pri best_limit_expiry" id="best_limit_expiry_<?php echo $key ?>"><?php echo strtoupper($mmm.'-'.$yy);?></td>
                            
                            <td class="td_custom best_limit_qbid" align="right" id="best_limit_qbid_<?php echo $key ?>"><?php echo ($finances['qbid'] != NULL && $finances['qbid'] !='-')? number_format($finances['qbid'],0,'.',','):'';?></td>
                            
                            <td class="td_custom" align="right"><span class="best_limit_bid <?php echo ($finances['bid'] != NULL && $finances['bid'] !='-' && $finances['bid'] !=0)? 'bg_color_red': '';?>" id="best_limit_bid_<?php echo $key ?>"><?php echo ($finances['bid'] != NULL && $finances['bid'] !='-' && $finances['bid'] !=0) ? number_format($finances['bid'],$get_decimal,'.',$get_comma):'';?></span></td>
                            
                            <td class="td_custom" align="left"><span class="best_limit_ask <?php echo ($finances['ask'] != NULL && $finances['ask'] !='-' && $finances['ask'] !=0)? 'bg_color_green': '';?>" id="best_limit_ask_<?php echo $key ?>"><?php echo ($finances['ask'] != NULL && $finances['ask'] !='-' && $finances['ask'] !=0) ? number_format($finances['ask'],$get_decimal,'.',$get_comma):'';?></span></td>
                            
                            <td class="td_custom best_limit_qask" align="left" id="best_limit_qask_<?php echo $key ?>"><?php echo ($finances['qask'] != NULL && $finances['qask'] !='-') ? number_format($finances['qask'],0,'.',','):'';?></td>
                            
                            <td class="td_custom" align="right">
							<span class="<?php echo ($finances['last'] != NULL && $finances['last'] !='-' && $finances['last'] != 0)? 'bg_color_grey': '';?> best_limit_last" id="best_limit_last_<?php echo $key;?>">
							<?php echo ($finances['last'] != NULL) ? number_format($finances['last'],$get_decimal,'.',$get_comma):'';?>
                            </span>
                            </td>
                           <td class="td_custom best_limit_time" align="right" id="best_limit_time_<?php echo $key ?>"><?php
						   if(!empty($finances['time'])){
							if(date("Y-m-d") > date("Y-m-d",strtotime($finances['time'])))
								echo date("Y-m-d",strtotime($finances['time']));
								else echo date("H:i:s",strtotime($finances['time']));
						   }
							?></td>
                            <td class="td_custom best_limit_theo" align="right" id="best_limit_theo_<?php echo $key ?>"><?php echo ($finances['theo'] != NULL) ? number_format($finances['theo'],$get_decimal,'.',$get_comma):'';?></td>
                         
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
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('head_tb_expiry'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6> </th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_change'); ?></h6> </th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_volume'); ?></h6></th>
                             <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_dvolume'); ?></h6></th>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_position'); ?></h6></th>
                             <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_settlement'); ?></h6></th>
                              <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_psettlement'); ?></h6></th>
                            <!--<?php if($dashboard_future[0]['settle'] !=''){?>
                            <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_settlement'); ?></h6></th>
                            <?php }else{?>
                             <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_psettlement'); ?></h6></th>
                            <?php }?>-->
                            
                          
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					//echo "<pre>";print_r($dashboard_future);exit;
					foreach($dashboard_future as $key => $finances){
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
                            <td class="td_custom cus_pri trades_expiry" id="trades_expiry_<?php echo $key ?>"><?php echo strtoupper($mmm.'-'.$yy);?></td>
                            <td class="td_custom" align="right">
							<span class="<?php echo ($finances['last'] != NULL && $finances['last'] !='-' && $finances['last'] != 0)? 'bg_color_grey': '';?> trades_last" id="trades_last_<?php echo $key;?>">
							<?php echo ($finances['last'])? number_format($finances['last'],$get_decimal,'.',$get_comma):'';?>
                            </span>
                            </td>
                            <td class="td_custom trades_change" align="right" id="trades_change_<?php echo $key ?>"><?php 
							if($finances['change'] >= 0){
								echo ($finances['change'] != NULL) ? '<span class="po">+'.number_format($finances['change'],$get_decimal,'.',$get_comma).'</span>':'';
							}else{
								echo ($finances['change'] != NULL) ? '<span class="di">'.number_format($finances['change'],$get_decimal,'.',$get_comma).'</span>':'';	
							}
							?></td>
                            <td class="td_custom trades_var" align="right" id="trades_var_<?php echo $key ?>"><?php 
							if($finances['var'] >= 0){
								echo ($finances['var'] != NULL) ? '<span class="po">+'.number_format($finances['var'],2,'.',',').'%</span>':'';
							}else{
								echo ($finances['var'] != NULL) ? '<span class="di">'.number_format($finances['var'],2,'.',',').'%</span>':'';	
							}?></td>
                            <td class="td_custom trades_volume" align="right" id="trades_volume_<?php echo $key ?>"><?php echo ($finances['volume'] != NULL) ? number_format($finances['volume'],0,'.',','):'';?></td>
                             <td class="td_custom trades_dvolume" align="right" id="trades_dvolume_<?php echo $key ?>"><?php echo ($finances['dvolume'] != NULL) ? number_format($finances['dvolume'],0,'.',','):'';?></td>
                            <td class="td_custom trades_oi" align="right" id="trades_oi_<?php echo $key ?>"><?php echo ($finances['oi'] != NULL) ? number_format($finances['oi'],0,'.',','):'';?></td>
                             <td class="td_custom trades_settle" align="right" id="trades_settle_<?php echo $key ?>"><?php echo ($finances['settle'] != NULL) ? number_format($finances['settle'],$get_decimal,'.',$get_comma):'';?></td>
                             
                              <td class="td_custom trades_psettle" align="right" id="trades_psettle_<?php echo $key ?>"><?php echo ($finances['psettle'] != NULL) ? number_format($finances['psettle'],$get_decimal,'.',$get_comma):'';?></td>
                             
                           <!-- <td class="td_custom trades_settle" align="right" id="trades_settle_<?php echo $key ?>"><?php echo ($finances['settle'] != NULL) ? number_format($finances['settle'],$get_decimal,'.',$get_comma):number_format($finances['psettle'],$get_decimal,'.',$get_comma);?></td>-->
                        </tr>
                     <?php }?>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  
