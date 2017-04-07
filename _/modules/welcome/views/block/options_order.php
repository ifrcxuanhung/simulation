
    <div class="portlet box red blocks" style="position:relative;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa"></i><?php translate('head_box_order'); ?></div>
                      <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
              
              
            </div>
            <div class="portlet-body background_portlet">

                 <div class="portlet-body background_portlet">
                        <div class="table-responsive">
                          <?php
                        	//get format any value
							if(isset($row_option['format'])){
								$find_format = strpos($row_option['format'],'.');
								$find_comma = strpos($row_option['format'],',');
								if(isset($find_format) && $find_format){
									$explode = explode(".",$row_option['format']);
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
							else {
								$get_decimal = 0;
								$get_comma = '';
							}
						?>
                        
                         <form method="post" action="" id="form_hide">
                        	<input type="hidden" name="input_id_user" id="input_id_user" value="<?php echo $_SESSION['simulation']['user_id'];?>"/>
                            <input type="hidden" name="input_datetime" id="input_datetime" value="<?php echo date('Y-m-d H:i:s');?>"/>
                            <input type="hidden" name="input_order_type" id="input_order_type" value="Limit order"/>
                            <input type="hidden" name="input_order_method" id="input_order_method" value="Daily"/>
                            <input type="hidden" name="input_model" id="input_model" value="3"/>
                            <input type="hidden" name="input_expiry" id="input_expiry" value="<?php echo $_SESSION['session_expiry_date'];?>"/>
                            <input type="hidden" name="input_interest" id="input_interest" value="<?php echo $maxspd_options['r'];?>"/>
                            <input type="hidden" name="input_dividend" id="input_dividend" value="<?php echo $maxspd_options['dividend_vl'];?>"/>
                             <input type="hidden" name="input_volatility" id="input_volatility" value="<?php echo $maxspd_options['volat'];?>"/>
                              <input type="hidden" name="input_strike" id="input_strike" value="<?php if(isset($_SESSION['session_strike'])){
											echo $_SESSION['session_strike'];
										}else{
											echo number_format($strike[0]['strike'],0,'.',',');
										}?>"/>
                            <input type="hidden" name="input_price" id="input_price" value="<?php if(isset($_SESSION['session_price'])){
											echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd_options['tick']),$get_decimal,'.',$get_comma):'-' ;
										}else{
											echo ($price_futures !='-' && (isset($maxspd_options['tick']))) ? number_format(ceiling($price_futures,$maxspd_options['tick']),$get_decimal,'.',$get_comma):'-' ;
										}?>"/>
                            <input type="hidden" name="input_quatity" id="input_quatity" value="<?php  if(isset($_SESSION['session_lots'])){
										 	echo $_SESSION['session_lots'];
										 }else{
											echo $simul_settings['order']['lots'][0]['name'];	 
										}?>"/>
                             <input type="hidden" name="input_deadline" id="input_deadline" value="<?php echo date('Y-m-d');?>"/>
                             <input type="hidden" name="input_dsymbol" id="input_dsymbol" value="<?php echo $_SESSION['option_product']['dsymbol'];?>"/>
                             <input type="hidden" name="input_c_p" id="input_c_p" value="<?php if(isset($_SESSION['session_call_put'])){
											echo mb_convert_case($_SESSION['session_call_put'], MB_CASE_TITLE, "UTF-8");
										}else{
											echo $simul_settings['options']['callput'][0]['name'];
										}?>"/>
                            
                            
                        </form>
                        
                            <table class="table  table-bordered">
                            	
                                <tbody>
                                  <tr>

                                        <td width="50%" class="td_custom font_size_new" align="center"> <div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" data-target="#call_put" data-toggle="modal"><?php translate('head_call_put'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 val_call_put" data-target="#call_put" data-toggle="modal"><?php 
										if(isset($_SESSION['session_call_put'])){
											echo $_SESSION['session_call_put'];	
										}else{
											echo $simul_settings['options']['callput'][0]['name'];
										}?></h6></div></td>
                                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" data-target="#strike" data-toggle="modal"><?php translate('head_strike'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6  data-target="#strike" data-toggle="modal" class="cus_h6 val_strike"><?php 
										if(isset($_SESSION['session_strike'])){
											echo $_SESSION['session_strike'];
										}else{
												echo number_format($strike[0]['strike'],2,'.',',');
										}?></h6></div></td>

                                        
                                    </tr>
                                
                                <tr>

                                        <td width="50%" class="td_custom font_size_new"  align="center"> <div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" data-target="#order_type" data-toggle="modal"><?php translate('head_order_type'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 val_order_type" data-target="#order_type" data-toggle="modal">  <?php 
										if(isset($_SESSION['session_order_type'])){
											echo $_SESSION['session_order_type'];	
										}else{
											echo $simul_settings['order']['type'][0]['name'];
										}?></h6></div></td>
                                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type tooltips" data-original-title="The various types of orders traders can use to specify how long an order will remain active in the market." data-placement="top" data-container="body" data-target="#menu_duration" data-toggle="modal"><?php translate('head_duration'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 val_duration" data-target="#menu_duration" data-toggle="modal"><?php 
										if(isset($_SESSION['session_duration'])){
											echo $_SESSION['session_duration'];	
										}else{
											echo $simul_settings['order']['duration'][0]['name'];
										}?></h6></div></td>

                                        
                                    </tr>
                                 
                                 <tr>
                                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" ><?php translate('head_lots'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 load_modals" edit_for="lots" data-target="#modals" data-toggle="modal" data-type="input"  data-value="<?php if(isset($_SESSION['session_lots'])){
											echo $_SESSION['session_lots'];	
										}else{
											echo $simul_settings['order']['lots'][0]['name'];
										};?>">  <?php 
										
										if(isset($_SESSION['session_lots'])){
											echo $_SESSION['session_lots'];	
										}else{
											echo $simul_settings['order']['lots'][0]['name'];
										}?></h6></div></td>
                                      
                                        <!--td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type">PRICE<i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6"><?php echo  $simul_settings['order']['prices'][0]['name'];?></h6></div></td-->
                                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_tb_price'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 load_modals" edit_for="price" data-target="#modals" data-toggle="modal" data-type="input" 
                                        data_default="<?php if(isset($_SESSION['session_price'])){
											echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
										}else{
											echo ($price_options !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($price_options,$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
										}?>" 
                                        data-value="<?php 
										if(isset($_SESSION['session_price'])){
											echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
										}else{
											echo ($price_options !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($price_options,$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
										}?>">
										<?php 
										if(isset($_SESSION['session_price'])){
											echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
										}else{
											echo ($price_options !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($price_options,$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
										}?>
                                        </h6></div></td>
                                    </tr>
                                 
                                    <tr>
                                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading "><!--<h6 class="color_h6">SELL</h6>-->
                                        <a style="min-height: 40px; line-height:18px; background-color: #ee2222 ;" class="btn btn-lg green form-control button_sell_option" data-target="#click_sell_option" data-toggle="modal"><strong><?php translate('btn_sell'); ?></strong></a>
                                        </div></td>
                                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading">  <a style="min-height: 40px; line-height:18px;  background-color: #00a800 ;" class="btn btn-lg green form-control button_buy_option" data-target="#click_buy_option" data-toggle="modal"><strong><?php translate('btn_buy'); ?></strong></a></div></td>
                                     </tr>
                                 
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                     <div class="portlet-body background_portlet" style="margin-top:10px;">
                        <div class="table-responsive">
                            <table class="table  table-bordered table-hover table_color table_cus">
                                <thead>
                                    <tr>
                                        <th class="th_custom" style="text-align:left;"><h6 class="color_h6 cus_type"><?php translate('head_tb_size'); ?></h6> </th>
                                        <th class="th_custom" style="text-align:right; color:#ee2222;"><h6 class="color_h6 cus_type"><?php translate('head_tb_bid'); ?></h6>  </th>
                                        <th class="th_custom" style="text-align:left; color:#00a800;"><h6 class="color_h6 cus_type"><?php translate('head_tb_ask'); ?></h6>  </th>
                                        <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_size'); ?></h6> </th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      
                                        <td class="td_custom font_size_13" align="left" style="line-height:30px;"><span class="option_order_qbid"><?php echo (isset($row_option['qbid'])) ? $row_option['qbid']: '-';?></span></td>
                                        <td class="td_custom font_size_13" align="right"><h6 class="color_h6 cus_type btn btn-lg green form-control" style="font-size:13px; color:#fff !important; background:#ee2222 !important; padding:7px 0px !important;"><span class="option_order_bid"><?php echo (isset($row_option['bid'])) ? number_format($row_option['bid'],2,'.',','):'-';?></span></h6></td>
                                        <td class="td_custom font_size_13" align="left"><h6 class="color_h6 cus_type btn btn-lg green form-control" style="font-size:13px; color:#fff !important; background:#00a800 !important; padding:7px 0px !important;"><span class="option_order_ask"><?php echo (isset($row_option['ask'])) ? number_format($row_option['ask'],2,'.',','):'-';?></span></h6></td>
                                        <td class="td_custom font_size_13" align="right" style="line-height:30px;"><span class="option_order_qask"><?php echo (isset($row_option['qask'])) ? $row_option['qask']:'-';?></span></td>
                            
                                    </tr>
                                   
                                   
                                </tbody>
                            </table>
                            
                            
                            
                            
                             <table class="table  table-bordered table-hover table_color table_cus" style="margin-top:2px;">
                               <tbody>
                                  
                                  <tr>
                                         <td class="td_custom font_size_old" align="left"  style="color:#1688c3; line-height:26px;"><?php echo $sum_b['b'];?></td>
                                           <?php
											//get format any value
											if(isset($avg_b['format'])){
												$find_format_avgb = strpos($avg_b['format'],'.');
												$find_comma_avgb = strpos($avg_b['format'],',');
												if(isset($find_format_avgb) && $find_format_avgb){
													$explode_avgb = explode(".",$avg_b['format']);
													$get_decimal_avgb = strlen($explode_avgb[1]);
													if(isset($find_comma_avgb) && $find_comma_avgb) {
														$get_comma_avgb = ',';	
													}else{
														$get_comma_avgb = '';	
													}
												}
												else if(isset($find_comma_avgb) && $find_comma_avgb){
													$get_comma_avgb = ',';
													$get_decimal_avgb = 0;
												}
												else{
													$get_decimal_avgb = 0;
													$get_comma_avgb = '';	
												}
											}
											else {
												$get_decimal_avgb = 0;
												$get_comma_avgb = '';	
											}
										?>
                                        <td class="td_custom font_size_old " align="right"  style="color:#1688c3;" ><h6 id="avg_buy_option" class="color_h6 btn  form-control bg_color_red_order" style="background:#ee2222;"><?php echo $avg_b['b']!='-' ? number_format($avg_b['b'],$get_decimal_avgb,'.',$get_comma_avgb) :'-';?></h6></td>
                                        <td class="td_custom font_size_old order_maxspd" align="center" style="color:#4c87b9 !important; line-height:26px;"><?php echo $order_maxspd ?></td>
                                         <?php
                        	//get format any value
							if(isset($avg_s['format'])) {
								$find_format_avgs = strpos($avg_s['format'],'.');
								$find_comma_avgs = strpos($avg_s['format'],',');
								if(isset($find_format_avgs) && $find_format_avgs){
									$explode_avgs = explode(".",$avg_s['format']);
									$get_decimal_avgs = strlen($explode_avgs[1]);
									if(isset($find_comma_avgs) && $find_comma_avgs) {
										$get_comma_avgs = ',';	
									}else{
										$get_comma_avgs = '';	
									}
								}
								else if(isset($find_comma_avgs) && $find_comma_avgs){
									$get_comma_avgs = ',';
									$get_decimal_avgs = 0;
								}
								else{
									$get_decimal_avgs = 0;
									$get_comma_avgs = '';
								}
							}
							else {
								$get_decimal_avgs = 0;
									$get_comma_avgs = '';
							}
						?>
                                        <td class="td_custom font_size_old" align="left"  style="color:#1688c3;" ><h6 id="avg_sell_option" class="color_h6 btn green form-control bg_color_green_order" style="background:#00a800;"><?php echo $avg_s['s']!='-' ? number_format($avg_s['s'],$get_decimal_avgs,'.',$get_comma_avgs): '-';?></h6></td>
                                        <td class="td_custom font_size_old" align="right"  style="color:#1688c3; line-height:26px;"><?php echo ($sum_s['s'] !='') ? $sum_s['s']:'-';?></td>
                                    </tr>
                                 
                                   
                                </tbody>
                              </table>
                              
                              
                              
                        </div>
                    </div>
                    
                    <div class="portlet-body background_portlet" style="margin-top:10px;">
                        <div class="table-responsive">
                            <table class="table  table-bordered table-hover table_color table_cus">
                                <thead>
                                    <tr>
                                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6>  </th>
                                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_change'); ?></h6> </th>
                                        <th class="th_custom" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6>  </th>
                                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_positn'); ?></h6>  </th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td_custom font_size_13" align="left"><?php echo $simul_settings['options']['last'][0]['name'];?></td>
                                        <td class="td_custom font_size_13" align="right" <?php if($simul_settings['options']['change'][0]['name'] > 0){ echo 'style="color:#00a800;"';}else if($simul_settings['options']['change'][0]['name'] < 0) echo 'style="color:#ee2222;"';?>><?php echo $simul_settings['options']['change'][0]['name'];?></td>
                                        <td class="td_custom font_size_13" align="left" <?php if($simul_settings['options']['var'][0]['name'] > 0){ echo 'style="color:#00a800;"';}else if($simul_settings['options']['var'][0]['name'] < 0) echo 'style="color:#ee2222;"';?>><?php echo number_format($simul_settings['options']['var'][0]['name'],2,'.',',');?>%</td>
                                        <td class="td_custom font_size_13" align="right"><?php echo $simul_settings['order']['position'][0]['name'];?></td>
                                    </tr>
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
              		
                    
                   

            </div>
     </div>
