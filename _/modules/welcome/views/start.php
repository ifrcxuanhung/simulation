<?php //echo "<pre>";print_r($blockstart);exit;?>
<style>
.center-wrap{ overflow:inherit !important;}
.webapp-btn{ border:1px solid #536473;}
.webapp-btn p{ color:#a8b9c8;}

</style>
<?php
if(empty($_SESSION['simulation']['token']))
			$_SESSION['simulation']['token'] = md5(uniqid(mt_rand(),true));
?>
        <!-- BEGIN PAGE BASE CONTENT -->
        <!-- Center Wrap BEGIN -->
        <div class="center-wrap">
            <div class="center-align">
                <div class="center-body">
                    <div class="row" style="margin-left: 0px; margin-right: 0px;">
                        <?php 
						$i = 1;
						foreach($blockstart as $value){
							
							?>
                         <div class="col-sm-4 margin-bottom-30 <?php 
						 			if($i == 1 || $i==4 || $i == 7){
							 			echo "padding_right_20";
									}if($i == 2 || $i==5 || $i == 8){
										echo "padding_left_right_10";	
									}if($i == 3 || $i==6 || $i == 9){
										echo "padding_left_20";
									}
									?>">
                            <a href="<?php echo (isset($_SESSION['simulation']['username'])) ? $simulation_url.$value['url']: 'javascript:void(0)'; ?>"" class="webapp-btn <?php if(!isset($_SESSION['simulation']['username'])) echo "click_show_box";?>"">
                                <?php
                                	if(isset($curent_language['code']) && $curent_language['code'] == 'fr'){ ?>
										 	<h3><?php echo $value['fr'] ?></h3>
                                            <?php if($value['info_fr'] != ''){?>
                                				<p><?php echo $value['info_fr'] ?></p>
                                            <?php }else{?>
                                            	<p><?php echo $value['info'] ?></p>
                                            <?php }?>
									<?php }else if(isset($curent_language['code']) && $curent_language['code'] == 'vn'){ ?>
										 	<h3><?php echo $value['vn'] ?></h3>
                                			 <?php if($value['info_vn'] != ''){?>
                                				<p><?php echo $value['info_vn'] ?></p>
                                            <?php }else{?>
                                            	<p><?php echo $value['info'] ?></p>
                                            <?php }?>
									<?php }else if(isset($curent_language['code']) && $curent_language['code'] == 'en'){ ?>
											<h3><?php echo $value['en'] ?></h3>
                                			 <?php if($value['info_en'] != ''){?>
                                				<p><?php echo $value['info_en'] ?></p>
                                            <?php }else{?>
                                            	<p><?php echo $value['info'] ?></p>
                                            <?php }?>
									<?php }
											else{
									 ?>
                                     		<h3><?php echo $value['name'] ?></h3>
                                			<p><?php echo $value['info'] ?></p>
                                     <?php }?>
                                
                            </a>
                            <div class="clear"></div>
                        </div>
                        <?php $i++; }?>
                                        
                    </div>
                    <?php if(!isset($_SESSION['simulation']['username'])) {?>
                   <div class="col-md-12 webapp-signin">
                        <div class="col-md-offset-3 col-md-6 margin-bottom-30" style="color: #fff;">
                            <form method="post" action="<?php echo $simulation_url; ?>futures_trading" class="login-form" novalidate="novalidate">
                                <h3 class="form-title font-green upper_login"><?php translate('title_sign_in'); ?></h3>
                                <div class="alert alert-danger display-hide">
                                    <button data-close="alert" class="close"></button>
                                    <span> Enter any username and password. </span>
                                </div>
                                
                                <div class="row">
                                	<div class="alert alert-danger login-alert" id="login_alert" style="display:none;">
                <button class="close" data-close="alert"></button>
                <span class="aler_msg"><?php translate('mess_login_failed'); ?></span>
            </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                            <label class="control-label visible-ie8 visible-ie9">Username</label>
                                            <input type="text" id="username" name="username" placeholder="<?php translate('holder_username'); ?>" autocomplete="off" class="form-control form-control-solid placeholder-no-fix"> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label visible-ie8 visible-ie9">Password</label>
                                            <input type="password" id="password" name="password" placeholder="<?php translate('holder_password'); ?>" autocomplete="off" class="form-control form-control-solid placeholder-no-fix"> </div>
                                    </div>
                                    
                                    <input type="hidden" id="remember" name="remember" value="1"/>
                <input type="hidden" id="token" name="token" value="<?php if(isset($_SESSION['simulation']['token'])) echo $_SESSION['simulation']['token']; ?>"/>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-10">
                                            <button class="btn green uppercase " type="button" id="LoginProcess"><?php translate('btn_login'); ?></button>
                                            <label class="rememberme check mt-checkbox mt-checkbox-outline upper_login_cap" >
                                                <input type="checkbox" value="1" name="remember"><?php translate('check_remember'); ?>
                                                <span></span>
                                            </label>
                                            <a class="forget-password upper_login_cap" id="forget-password" href="<?php echo base_url();?>user-manage/forgot_password.php">| <?php translate('text_forgot_password'); ?></a>
                                            
                                            <a id="register-btn" class="upper_login_cap" href="<?php echo base_url();?>user-manage/sign_up.php">| <?php translate('text_create_account'); ?></a> 
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="login-options">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <h4 class="col-md-6"  style="text-align: right;"><?php translate('text_or_login_with'); ?></h4>
                                            <ul class="social-icons">
                                                <li>
                                                    <a href="javascript:;" data-original-title="facebook" class="social-icon-color facebook"></a>
                                                </li>
                                               <!-- <li>
                                                    <a href="javascript:;" data-original-title="Twitter" class="social-icon-color twitter"></a>
                                                </li>-->
                                                <li>
                                                    <a href="javascript:;" data-original-title="Goole Plus" class="social-icon-color googleplus"></a>
                                                </li>
                                              <!--  <li>
                                                    <a href="javascript:;" data-original-title="Linkedin" class="social-icon-color linkedin"></a>
                                                </li>-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                   </div>
                    <?php }?>
                </div>
            </div>
            
        </div>
        
        <!-- Center Wrap END -->
        <!-- END PAGE BASE CONTENT -->
        <!-- BEGIN FOOTER -->
        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
        <!--button type="button" class="quick-sidebar-toggler" data-toggle="collapse">
            <span class="sr-only">Toggle Quick Sidebar</span>
            <i class="icon-logout"></i>
        </button-->
        <!-- END QUICK SIDEBAR TOGGLER -->
       
        <!-- END FOOTER -->

<!-- END CONTAINER -->