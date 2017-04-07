<!-- Header BEGIN -->
<style>
<?php 

if(isset($_SESSION['curent_language']) && $_SESSION['curent_language']['code'] == 'vn'){?>

.webapp-btn h3{
	color: #009dc7;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 42px;
	font-weight: bold;
	line-height: 1.4;
	margin: 0;
	text-transform: uppercase;		
}
.page-header .navbar .navbar-nav > li > a{

	font-family: Arial,Helvetica,sans-serif;
	font-weight:bold;

}
h1, h2, h3, h4, h5, h6{
	font-family:Arial,sans-serif;
}


<?php }?>
.portlet-title{ background:#<?php echo $color_box_information['value'];?> !important;}
.modal-header{ background:#<?php echo $color_box_confirmation['value'];?> !important;}
.page-header{ background:#<?php echo $color_web_header['value'];?> !important;}
.page-header .navbar-fixed-top{ background:#<?php echo $color_web_header['value'];?> !important;}
.copyright{ background:#<?php echo $color_web_footer['value'];?> !important;}


</style>
<header class="page-header margin-bottom-40">
    <nav class="navbar mega-menu" role="navigation">
        <!--div class="container-fluid"-->
            <div class="clearfix navbar-fixed-top ">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
            
                <a id="index" class="page-logo" href="<?php echo $simulation_url; ?>" style="text-decoration: none;">
                    <strong style="color: #e4ad36"><font style="color:#0f84c0"><?php echo $logo_txt[0]['name'] ?></font> <?php echo $logo_txt[1]['name'] ?></strong>
                    <span class="bottom_logo"><?php translate('header_under_contruction'); ?></span>
                </a>
            	<!-- END LOGO -->
                <!-- BEGIN SEARCH -->
                <?php if($this->router->fetch_class() !='start'){?>
                <form class="search hidden-sm" action="#" method="GET">
                    <input type="name" class="form-control" name="query" placeholder="<?php translate('header_search'); ?>"/>
                    <a href="javascript:;" class="btn submit"><i class="fa fa-search"></i></a>
                </form>
    
                <?php }?>
                <!-- END SEARCH -->
                <div class="topbar-actions">
                	 	<?php 
                            if(count($user_job) > 0) {
                                foreach($user_job as $uj) {
                                if (!preg_match("/^(http|https|ftp):/", $uj['url'])) {
								   $link = base_url().$uj['url'];
								}else{
									$link = $uj['url'];
								}
                        ?>
             			<?php 
						//echo "<pre>";print_r($_SESSION['simulation']['user_id']);exit;
						if(isset($_SESSION['simulation']['user_id'])){ ?>
							
						
                        <div class="btn-group">
                       		  
                            <?php if (isset($uj['icon']) && $uj['icon']!='') { ?>
                             <a href="<?php echo $link ?>" class="btn btn-icon-only tooltips default" data-container="body" data-placement="bottom" data-original-title="<?php echo $uj['name'] ?>">
                            <i class="fa <?php echo $uj['icon'] ?>"></i> 
                             </a>
                            <?php } else { ?>
                              <a href="<?php echo $link ?>" class="btn tooltips default" data-container="body" data-placement="bottom" data-original-title="<?php echo $uj['name'] ?>">
                              <?php echo $uj['text'] ?>
                              </a>
                             <?php } ?>
                            
                        </div>
                        <?php }?>
                        <?php } }?>
                
                
                
                    <div class="btn-group md-time">
                        <a class="btn red timer">
                             <i style="color: #FFF; float: left;" class="fa fa-calendar"></i><span id="clockbox"><?php //echo date() ?></span>
                        </a>
                        <?php if((int)$status_market["value"] != -1) { ?>
                        	<a href="<?php echo base_url()?>onoff" class="btn bg_green_head status_market"><?php translate('header_open'); ?></a>
                        <?php } else { ?>
                        <a href="<?php echo base_url()?>onoff" class="btn bg_red_head status_market"><?php translate('header_close'); ?></a>
                        <?php } ?>
                      
                        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
            
                
                
                
                <!-- END SEARCH BUTTON -->
            
                <!-- BEGIN USER LOGIN DROPDOWN -->
                
                <li class="dropdown dropdown-user">
                <?php
                // if user logged in
                if(isset($_SESSION['simulation']['username'])) {
					 $url = explode("/",$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					 $baseURL = $url[0];
					
		
                    ?>
                    <a href="<?php echo base_url(); ?>profile" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img alt="" class="img-hide1" src="<?php echo (isset($user['thumb']) && is_file($user['thumb'])) ? base_url().$user['thumb'] :  base_url() .'assets/upload/avatar/no_avatar.jpg'; ?>" width="20" height="20"/>
                    <span class="username username-hide-on-mobile login_user">
                    <?php echo $_SESSION['simulation']['username']; ?> </span>
                    <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>profile">
                            <i class="icon-user"></i> <?php translate('header_my_profile'); ?> </a>
                        </li>
                        <!--li>
							<a href="<?php echo base_url(); ?>auth/lock">
							<i class="icon-lock"></i> <?php translate('lock_your_screen'); ?> </a>
						</li-->
                       <!-- <li>
                            <a href="<?php base_url(); ?>user-manage/admin/">
                            <i class="icon-key"></i> <?php translate('_user_manage'); ?></a>
                        </li>-->
                        <li>
                            <a href="<?php echo base_url()?>user-manage/profile.php"  id="change_password">
                            <i class="icon-lock"></i> <?php translate('header_change_password_email'); ?></a>
                        </li>
                        <li>
                            <a  id="logout_modal">
                            <i class="icon-key"></i> <?php translate('header_log_out'); ?></a>
                        </li>
                    </ul>
                    <?php
                } else {
                    ?>
                    <?php if($this->router->fetch_class() != 'start'){?>
                    <a id="login_modal" style="color: #636e77 ; padding-bottom:11px;" data-target="#login_modals" data-toggle="modal" >
					<i class="icon-lock"></i> <?php translate('sign_in'); ?></a>
                    <?php
                }}
                ?>
                </li>
         
                <!--<li class="hidden-sm hidden-xs">
                        <div class="languages" style="margin-top:10px; margin-left:10px;">
                            <?php
                                foreach($list_lang as $lang) {
                            ?>
                                <a class="switch-language" href="javascript: void(0);" langcode="<?php echo $lang['code'] ?>">
                                    <img style="<?php echo $curent_language['code'] == $lang['code'] ? '' : 'opacity: 0.5;'; ?>" src="<?php echo template_url() ?>img/<?php echo $lang['code'] ?>.png" />
                                </a>
                            <?php
                                }
                            ?>
                        </div>
                    </li>-->
                    
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
         <?php if(isset($multilanguage['value']) && $multilanguage['value']==1){?>
        <div class="btn-group-lang btn-group">
						<button type="button" class="btn btn-md dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img src="<?php echo template_url() ?>global/img/flags/<?php echo $curent_language['code']; ?>.png" alt="">
                            <span> <?php echo $curent_language['code']; ?> </span>
    						<i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu-v2">
                            <?php
                            foreach($list_lang as $lang) {
                            ?>
                            <li class="<?php echo $curent_language['code'] == $lang['code'] ? 'active' : ''; ?>" >
								<a class="switch-language" href="javascript: void(0);" langcode="<?php echo $lang['code'] ?>">
								<img src="<?php echo template_url() ?>global/img/flags/<?php echo $lang['code'] ?>.png" alt=""> <?php echo $lang['name'] ?> </a>
							</li>
							<?php } ?>
                        </ul>
                    </div>
         <?php }?>
       					
                    </div>
                </div>
               
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?php if($this->router->fetch_class() != 'start' && $this->router->fetch_class() != 'simulation'){?>
                <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav text-uppercase">
                    <?php 
					$i = 0;
					$active = end(explode('/',$_SERVER['REQUEST_URI']));
					foreach($simul_menu as $simul){
						?>
                        <li class="dropdown <?php if($active == $simul['url']){?> dropdown-fw dropdown-fw-disabled active open selected<?php }?>">
                            <a href="<?php echo $simulation_url; ?><?php echo $simul['url'];?>" class="text-uppercase">
                                <?php if(isset($simul['icon'])&&$simul['icon']!=''){?> 
                                <i class="<?php echo $simul['icon'];?>"></i>
                                <?php } ?>
                                <?php 
								if(isset($curent_language['code']) && $curent_language['code'] == 'fr'){
									echo $simul['fr'];
								}else if(isset($curent_language['code']) && $curent_language['code'] == 'vn'){
									echo $simul['vn'];	
								}else{
									echo $simul['en'];		
								}
								?> </a>
                        </li>
                        <?php $i++;}?>
                    </ul>
                </div>
            <?php }?>
            <!-- END NAVBAR COLLAPSE -->
        <!--/div-->
        <!--/container-->
    </nav>
</header>
<!-- Header END -->

