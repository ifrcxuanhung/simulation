<?php //echo "<pre>";print_r($blockstart);exit;?>
<style>
.center-wrap{ overflow:inherit !important;}
.webapp-btn{ border:1px solid #536473;}
.webapp-btn p{ color:#a8b9c8;}

</style>
<?php  
if(!isset($_SESSION['simulation']['user_id'])){
			redirect(base_url().'start');	
}?>
        <!-- BEGIN PAGE BASE CONTENT -->
        <!-- Center Wrap BEGIN -->
        
        <div class="center-wrap">
            <div class="center-align">
                <div class="center-body">
                
                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                        <?php 
						$i = 1;
						//echo "<pre>";print_r($blockmanagement);exit;
						foreach($blockmanagement as $value){
							
							?>
                         <div class="col-sm-4 margin-bottom-30 <?php if($i == 1 || $i==4 || $i == 7){
							 			echo "padding_right_20";
									}if($i == 2 || $i==5 || $i == 8){
										echo "padding_left_right_10";	
									}if($i == 3 || $i==6 || $i == 9){
										echo "padding_left_20";
									}
									?>">
                            <a href="<?php echo $simulation_url.$value['url']; ?>" class="webapp-btn">
                                <?php
                                	if(isset($curent_language['code']) && $curent_language['code'] == 'fr'){ ?>
                                    		 <?php if($value['fr'] != ''){?>
										 		<h3><?php echo $value['fr']; ?></h3>
                                          	<?php }else{?>
                                          	<h3><?php echo $value['name']; ?></h3>
                                          	<?php }?>
                                            <?php if($value['info_fr'] != ''){?>
                                				<p><?php echo $value['info_fr'] ?></p>
                                            <?php }else{?>
                                            	<p><?php echo $value['info'] ?></p>
                                            <?php }?>
									<?php }else if(isset($curent_language['code']) && $curent_language['code'] == 'vn'){ ?>
                                     	<?php if($value['vn'] != ''){?>
										 		<h3><?php echo $value['vn']; ?></h3>
                                          	<?php }else{?>
                                          	<h3><?php echo $value['name']; ?></h3>
                                          	<?php }?>
                                			 <?php if($value['info_vn'] != ''){?>
                                				<p><?php echo $value['info_vn'] ?></p>
                                            <?php }else{?>
                                            	<p><?php echo $value['info'] ?></p>
                                            <?php }?>
									<?php }else if(isset($curent_language['code']) && $curent_language['code'] == 'en'){ ?>
                                     		<?php if($value['en'] != ''){?>
										 		<h3><?php echo $value['en']; ?></h3>
                                          	<?php }else{?>
                                          	<h3><?php echo $value['name']; ?></h3>
                                          	<?php }?>
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
                
                
                    <!--<div class="row" style="margin-left: 0px; margin-right: 0px;">
                        
                         <div class="col-sm-6 margin-bottom-30 ">
                            <a href="<?php echo $simulation_url; ?>jq_loadtable/efrc_summary" class="webapp-btn">
                               <h3><?php translate('tables'); ?></h3>
                               <p><?php translate('info'); ?></p> 
                            </a>
                            <div class="clear"></div>
                        </div>
                        
                        <div class="col-sm-6 margin-bottom-30 ">
                            <a href="<?php echo $simulation_url; ?>onoff" class="webapp-btn">
                               <h3><?php translate('open/close'); ?></h3>
                               <p><?php translate('info'); ?></p> 
                            </a>
                            <div class="clear"></div>
                        </div>
                         
                    </div>-->
                   
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