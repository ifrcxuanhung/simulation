<!-- BEGIN PAGE HEADER-->
<div class="page-content">
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT INNER -->
<div class="row profile blocks ">
	
	<div class="col-md-12">
		<!--BEGIN TABS-->				
				
					<div class="col-md-3">
                        <div class="portlet light">
                        
                            <div class="portlet-body">
                            <!--class="scroller" data-height="310px"-->
                                    <div data-always-visible="1" data-rail-visible="1">
                						<!--ul class="list-unstyled profile-nav">
                							<li>
                							<?php $base_url = base_url(); ?>
                								<img id="avatar" name="avatar" src="<?php echo is_file($detail_user['info']['avatar']) ? $base_url.$detail_user['info']['avatar'] : $base_url.'assets/upload/avatar/no_avatar.jpg'; ?>" class="img-responsive-avatar" alt=""/>
                								<div class="change-avatar" translate="<?php echo translate('change_avatar'); ?>"></div>
                							</li>
                						</ul-->
                                       
                                        <form enctype="multipart/form-data" method="POST"  id="fileupload" class="" style="width: 100%;"> 
                                            <center>
                                            <div class="fileinput <?php echo (isset($detail_user['info']['avatar']) && is_file($detail_user['info']['avatar'])) ? 'fileinput-exists' : 'fileinput-new'; ?>"
                                             data-provides="fileinput" data-name="avatar"style="width:100%;" >
                                                    <div class="margin-bottom-5 align-right"> <!-- style="margin: 0 20px; position: absolute; text-align: right !important; z-index: 1000;" -->
                                                    
                                                     
                                                    <!-- <button type="button" class="btn btn-icon-only red" id="elfinder_button"><i class="fa fa-edit" ></i></button><div class="url_image"></div>-->
                                                     
                                                       <span class="btn btn-icon-only blue btn-file" style="margin-top: 10px;">
                                                        <span class="fileinput-new"><i class="fa fa-edit"></i></span>
                                                        <span class="fileinput-exists">
                                                        <i class="fa fa-edit" ></i> </span>
                                                        <input type="file" name="fileavatar" id ="fileavatar" value="<?php echo (isset($detail_user['info']['avatar']) && is_file($detail_user['info']['avatar'])) ? str_replace(base_url(), "", $detail_user['info']['avatar']) : 'assets/upload/avatar/no_avatar.jpg'; ?>"/>
                                                        </span>
                                                        
                                                        <a href="javascript:;" class="btn btn-icon-only red fileinput-exists remove-image-profile" data-dismiss="fileinput"style="margin-top: 10px;margin-left: 0px!important;">
                                                        <i class="fa fa-remove"></i> </a>
                                                        <a class="btn btn-icon-only green save-avatar" href="javascript:;" style="margin-top: 10px;margin-left: 0px!important;">
                                                        <i class="fa fa-check"></i> </a>
                                                        <a class="btn btn-icon-only yellow mix-preview fancybox-button" data-fancybox-group="avatar" title='<?php echo $detail_user['firstname'].' '.$detail_user['lastname']; ?>' href="<?php echo (isset($user['avatar']) && is_file($detail_user['info']['avatar'])) ? str_replace(base_url(), "", $detail_user['info']['avatar']) : 'assets/upload/avatar/no_avatar.jpg'; ?>"style="margin-top: 10px;margin-left: 0px!important;">
                                                        <i class="fa fa-search-plus"></i></a>
                                                    </div>
                                                    <div id="file" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 86.5%">
                                                        <img id="myavatar" width="190" height="160" src="<?php
                                                        echo base_url();
                                                        echo (isset($detail_user['info']['avatar']) && is_file($detail_user['info']['avatar'])) ? str_replace(base_url(), "", $detail_user['info']['avatar']) : 'assets/upload/avatar/no_avatar.jpg';
                                                        ?>" alt=""/>
                                                    </div>                                                             
                                            </div>                          
                                            </center> 
                                        </form>
                                    </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">  
						  <div class="portlet light bordered box red blocks" style="margin-bottom:5px;">
							     <div class="portlet-body background_portlet">
                                <div   data-always-visible="1" data-rail-visible="1">  
    								<table class="table table-striped table-bordered table-advance table-hover set_background">
        								<tbody>
            								<tr>
            									<td class="td_custom" align="right" width="30%">
            										<a class="upper_title" href="javascript:;" style="color:#6fb9fc; font-weight:bold;">
            										<?php echo translate('Email');?> </a>
            									</td>
            									<td class="hidden-xs active_color td_custom"  width="80%">
            										<?php echo $detail_user['info']['email']; ?>
            									</td>
            								</tr>
                                            <tr>
            									<td class="td_custom" align="right" width="30%">
            										<a class="upper_title" href="javascript:;" style="color:#6fb9fc; font-weight:bold;">
            										<?php echo translate('Password');?> </a>
            									</td>
            									<td class="hidden-xs active_color td_custom"  width="80%" value="<?php echo $detail_user['info']['password']; ?>">
            										<?php echo translate('**********');?> </a>
            									</td>
            								</tr>
                                            <tr>
            									<td class="td_custom" align="right" width="30%">
            										<a class="upper_title" href="javascript:;" style="color:#6fb9fc; font-weight:bold;">
            										<?php echo translate('Last login');?> </a>
            									</td>
            									<td class="hidden-xs active_color td_custom"  width="80%">
            										<?php echo $detail_user['info']['lastlogin']; ?>
            									</td>
            								</tr> 
                                            <tr>
            									<td class="td_custom" align="right" width="30%">
            										<a class="upper_title" href="javascript:;" style="color:#6fb9fc; font-weight:bold;">
            										<?php echo translate('Create date');?> </a>
            									</td>
            									<td class="hidden-xs active_color td_custom"  width="80%">
            										<?php echo $detail_user['info']['timestamp']; ?>
            									</td>
            								</tr> 
                                            <?php if($level_user[0] == 1){?>
                                             <tr>
            									<td class="td_custom" align="right" width="30%">
                                                <a class="upper_title" href="javascript:;" style="color:#6fb9fc; font-weight:bold;">
            										<?php echo translate('Import users');?></a>
            									</td>
            									<td class="hidden-xs active_color td_custom"  width="80%">
                                                <form action="<?php echo base_url()?>profile/uploadCSV" method="post" id="create_form" enctype="multipart/form-data">
            										<input type="file" name="upload" size="70" />
                                                    <input style="cursor: pointer; margin-top:10px;" class="btn blue" type="submit" name="upload_file" value="Upload CSV File">
                                                </form>
            									</td>
            								</tr>  
                                            <?php }?>
                                        </tbody>
    								</table>	
                                </div>
							</div>
						</div>
					</div>
                        
					</div>
					<div class="col-md-9">
                            
        						<div class="portlet light bordered box red blocks" style="margin-bottom:5px;">
                                <div class="portlet-title header-table" style="position:relative;">
    
                                    <div class="caption" style=" line-height:28px; padding:10px; text-transform:uppercase;"><?php echo translate('PROFILE'); ?></div>
                                      <div class="tools">
                                       <!-- <a href="" class="fullscreen"> </a>-->
                                        <i class="fa fa-arrows-alt fullscreens"></i>
                                        <i class="fa fa-compress minscreens"></i>
                                    </div>
                                    
                                    <div class="actions" style=" line-height:28px; padding:10px;">
                                                <a class="view-user btn btn-icon-only blue" href="<?php echo base_url()?>user-manage/admin/users.php?uid=<?php echo $detail_user['info']['user_id'];?>">
                                                <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                </div>
                                
                                
                                		<!--<div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-bubble font-red-sunglo"></i>
                                                <span class="caption-subject font-red-sunglo "><?php echo translate('Profile'); ?> </span>
                                            </div>
                                            
                                            <div class="actions">
                                                <a class="view-user btn btn-icon-only blue" href="<?php echo base_url()?>user-manage/admin/users.php?uid=<?php echo $detail_user['info']['user_id'];?>">
                                                <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
        							    </div>-->
        								<div class="portlet-body background_portlet">
        									
                                            <!--class="scroller" data-height="262px"-->
                                                <div   data-always-visible="1" data-rail-visible="1">  
															<table class="table table-striped table-bordered table-advance table-hover set_background">
                                                           
													
														<tbody>
                                                        <?php 
														array_shift($detail_user);
														foreach($detail_user as $key=>$value){
																
															?>
														<tr>
															<td class="td_custom" align="right" width="20%">
																<a class="upper_title" href="javascript:;" style="color:#6fb9fc; font-weight:bold;">
																<?php echo translate($key);?> </a>
															</td>
															<td class="hidden-xs active_color td_custom"  width="80%">
																 <?php echo $value;?>
															</td>
															
														</tr>
                                                       <?php }?> 
                                                       
														</tbody>
														</table>
            										
                                                </div>
                                              
        									</div>
        								</div>
                      
					</div>
					<!--end row-->
			
				
					
		<!--END TABS-->
	</div>
  
    
</div>
<div class="row ">
  <div class="col-md-6 use_fullscreen">          
	<div class="portlet box red blocks">
        <div class="portlet-title header-table">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_orders'); ?></div>
                <div class="tools">
           <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
        </div>
        <div class="portlet-body background_portlet">
            <div class="table-responsive scroller" style="height:400px;">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                        <tr>
                        	 <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Symbol'); ?></h6>  </th>
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Date time'); ?></h6>  </th>
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('B/S'); ?></h6>  </th>
                           
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Order Type'); ?></h6>  </th>
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Type'); ?></h6>  </th>
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Specs'); ?></h6>  </th>
                            <th class="th_custom" align="right"><h6 class="color_h6 cus_type"><?php translate('Price'); ?></h6>  </th>
                            <th class="th_custom" align="right"><h6 class="color_h6 cus_type"><?php translate('Qty'); ?></h6>  </th>
                            <th class="th_custom" align="right"><h6 class="color_h6 cus_type"><?php translate('status'); ?></h6>  </th>
                        </tr>
                    </thead>
                    <tbody>
                    
					<?php 
					foreach($orders as $key=>$order){
						$mmm = substr(strftime('%B',strtotime($order['expiry'])),0,3);
           				 $yy = strftime('%y',strtotime($order['expiry']));
						if(isset($order['format'])){
								$find_format = strpos($order['format'],'.');
								$find_comma = strpos($order['format'],',');
								if(isset($find_format) && $find_format){
									$explode = explode(".",$order['format']);
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
                        <tr>
                         <td class="td_custom "><?php echo $order['dsymbol'];?> </td>
                            <td class="td_custom "> <?php echo $order['datetime'];?></td>
                             <td class="td_custom "> <?php echo $order['b/s'];?></td>
                             
                               <td class="td_custom "><?php echo $order['order_type'];?> </td>
                                <td class="td_custom "><?php echo $order['type'];?> </td>
                                 <td class="td_custom "><?php echo strtoupper($mmm.'-'.$yy);?></td>
                                  <td class="td_custom " align="right"><?php echo ($order['price'] != 0 || $order['price'] != NULL || $order['price'] != '')?number_format($order['price'],$get_decimal,'.',$get_comma):'-';?> </td>
                                   <td class="td_custom " align="right"><?php echo $order['quantity'];?> </td>
                                    <td class="td_custom" align="right"><?php echo $order['status'];?> </td>
                         
                        </tr>
                     <?php }?>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    
   <div class="col-md-6 use_fullscreen">          
	<div class="portlet box red blocks">
        <div class="portlet-title header-table">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_trades'); ?></div>
                <div class="tools">
           <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
        </div>
        <div class="portlet-body background_portlet">
            <div class="table-responsive scroller" style="height:400px;">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                        <tr>
                        
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Symbol'); ?></h6>  </th>
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Date time'); ?></h6>  </th>
                            <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Type'); ?></h6>  </th>
                             <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('Expiry'); ?></h6>  </th>
                            <th class="th_custom" align="right"><h6 class="color_h6 cus_type"><?php translate('Price'); ?></h6>  </th>
                            <th class="th_custom" align="right"><h6 class="color_h6 cus_type"><?php translate('Qty'); ?></h6>  </th>
                        </tr>
                    </thead>
                    <tbody>
                    
					<?php 
					
					foreach($trades as $key=>$trade){
						$mmm = substr(strftime('%B',strtotime($trade['expiry'])),0,3);
           				 $yy = strftime('%y',strtotime($trade['expiry']));
						if(isset($trade['format'])){
								$find_format = strpos($trade['format'],'.');
								$find_comma = strpos($trade['format'],',');
								if(isset($find_format) && $find_format){
									$explode = explode(".",$trade['format']);
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
                        <tr>
                        
                            <td class="td_custom "> <?php echo $trade['dsymbol'];?></td>
                             <td class="td_custom "> <?php echo $trade['datetime'];?></td>
                              <td class="td_custom "><?php echo $trade['type'];?></td>
                                 <td class="td_custom "><?php echo strtoupper($mmm.'-'.$yy);?></td>
                                  <td class="td_custom " align="right"><?php echo ($trade['p'] != 0 || $trade['p'] != NULL || $trade['p'] != '') ? number_format($trade['p'],$get_decimal,'.',$get_comma):'-';?></td>
                                   <td class="td_custom " align="right"><?php echo $trade['q'];?></td>
                         
                        </tr>
                     <?php }?>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>

</div><!--page-content-->
			<!-- END PAGE CONTENT INNER -->
<!-- MODAL CHANGE -->

<!-- END MODAL CHANGE -->
   <style>
   .borderless tbody tr td, .borderless thead tr th {
    border: none;
	}

   </style>
<!--MODAL VIEW USER -->

<!-- END MODAL VIEW USER -->