<style>
.form .form-bordered .form-group{
	border-bottom: 1px solid #3e3e3e;
margin: 0;

}
.form .form-bordered label{ color:#0f84c0; padding:20px !important; text-transform:uppercase; }
.portlet.light.bordered.form-fit > .portlet-title{ border-bottom:1px solid #444 !important}
.form .form-bordered .form-group > div{ border-left:1px solid #444 !important}
.cailon{width:60%; float:right; text-align:right; padding-top:9px;}
</style>
<div class="col-md-12">
    <!-- BEGIN PORTLET-->
    <div class="portlet light form-fit bordered" style="width:100%;">
        <div class="portlet-title" style="background:#4c87b9; padding-top:0px; padding-bottom:0px; border:solid 1px #404040 !important;">
        <div class="caption" style="color:#fff; font-weight:bold; line-height:27px;">
            <i class="fa"></i><?php translate('Maintenance'); ?>
           
            </div>
            <div class="cailon">
            	 <a class="btn btn-xs blue show-modal reset_all" style="line-height:22px;" href="javascript:;">
				    <i class="fa fa-times-circle"></i> reset </a>
            </div>
           
    </div>
    
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal form-bordered">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('CREATE TABLE'); ?></label>
                        <div class="col-md-3">
                             <div class="col-md-3">
                                 <button class="btn blue create_exc" type="button">CREATE VDM_CONTRACTS_SETTING_EXC</button>
                             </div>
                           
                        </div>
                        <div class="col-md-3 remove_border">
                             <div class="col-md-3 date_parent_1">
                             	<?php if($date1['value'] != ''){?>
                                 	<button class="btn blue date1" type="button"><?php echo $date1['value'];?></button>
                                <?php }?>
                             </div>
                            
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('UPDATE TABLE'); ?></label>
                         <div class="col-md-3">
                            <button class="btn blue update_exc" type="button">UPDATE VDM_CONTRACTS_SETTING_EXC</button>
                           </div>
                            <div class="col-md-3">
                            <div class="col-md-3 date_parent_2">
                             	<?php if($date2['value'] != ''){?>
                                 <button class="btn blue date2" type="button"><?php echo $date2['value'];?></button>
                                 <?php }?>
                             </div>
                            
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('CLEAN PROCESS'); ?></label>
                        <div class="col-md-3">
                            <button class="btn blue clean_dashboard" type="button">CLEAN DASHBOARD_FUTURE</button>
                           </div>
                            <div class="col-md-3">
                             <div class="col-md-3 date_parent_3">
                             	<?php if($date3['value'] != ''){?>
                                 <button class="btn blue date3" type="button"><?php echo $date3['value'];?></button>
                                 <?php }?>
                             </div>
                            
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('CLEAN PROCESS'); ?></label>
                        <div class="col-md-3">
                         <button class="btn blue clean_contracts_setting" type="button">CLEAN VDM_CONTRACTS_SETTING</button>
                            </div>
                             <div class="col-md-3">
                            <div class="col-md-3 date_parent_4">
                             	<?php if($date4['value'] != ''){?>
                                 <button class="btn blue date4" type="button"><?php echo $date4['value'];?></button>
                                 <?php }?>
                             </div>
                            
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('CLEAN PROCESS'); ?></label>
                        <div class="col-md-3">
                         <button class="btn blue clean_dashboard_option" type="button">CLEAN DASHBOARD_OPTION</button>
                         </div>
                          <div class="col-md-3">
                             <div class="col-md-3 date_parent_5">
                             	<?php if($date5['value'] != ''){?>
                                 <button class="btn blue date5" type="button"><?php echo $date5['value'];?></button>
                                 <?php }?>
                             </div>
                            
                        </div>
                    </div>
                     <!--<div class="form-group">
                        <label class="control-label col-md-3"><?php translate('UPDATE PROCESS'); ?></label>
                        <div class="col-md-9">
                         <button class="btn blue update_intraday" type="button">UPDATE INTRADAY</button>
                         </div>
                    </div>-->
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('RESET MARKET'); ?></label>
                        <div class="col-md-3">
                         <button class="btn blue reset_market" type="button">RESET MARKET</button>
                         </div>
                          <div class="col-md-3">
                             <div class="col-md-3 date_parent_6">
                             	<?php if($date6['value'] != ''){?>
                                 <button class="btn blue date6" type="button"><?php echo $date6['value'];?></button>
                                  <?php }?>
                             </div>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('USER ONLINE'); ?></label>
                        <div class="col-md-3">
                        <a href="<?php echo base_url()?>useronline"> <button class="btn blue" type="button">USER ONLINE</button></a>
                         </div>
                        
                    </div>
                    
                    
               
                </div>
                
            </form>
            
            <!-- END FORM-->
            
        </div>
 </div>
    <!-- END PORTLET-->
</div>


<div id="modal_view_user2" class="modal bs-modal-md fade" tabindex="-1" aria-hidden="true" data-width="500">
	<div class="modal-dialog">
    <div class="modal-header" style="background-color: #E4AD36; padding:7px;">
	     
	      <h4 class="modal-title" style="color:#fff;"><?php echo translate('Do you want create table vdm_contracts_setting_exc ? '); ?></h4>
	    </div>
	  <div class="modal-content">
	    
	    <form id="form_view_user" role="form" class="form-horizontal" action="" method="post">
	      <div class="modal-body">
           <button type="button" class="bootbox-close-button close close_hung_custom" data-dismiss="modal" aria-hidden="true" style="margin-top: -3px;">×</button>
	        <div class="scroller" style="height:20%;" data-always-visible="1" data-rail-visible1="1">
	          <div class="row">
	            <div class="col-md-12">
	              <div class="form-body">
	                <div class="form-group">
	                  <label class="col-md-6 control-label">Choose date to system: </label>
                      <input type="text" id="calculation_date" name="calculation_date" placeholder="Market making seconds" class="form-control input-medium" value="<?php echo date("Y-m-d"); ?>">
	                </div>	                
	                                   
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	      <div class="modal-footer">
          <!--<?php if ($calculation_date != date("Y-m-d")) {
            ?>
            <label class="col-md-8 control-label" style="background-color: red; text-align: left; color: yellow; ">
            <?php echo translate('Warning: Calculate date difference system date!!!'); ?></label>
            <?php
          }?>-->
            <a href="#" class="btn default" data-dismiss="modal"><?php echo translate('Cancel'); ?></a>
	        <input type="button" class="btn green re_create" value="<?php echo translate('OK'); ?>"/>

	      </div>
	    </form>
	  </div>
	</div>
</div>
 