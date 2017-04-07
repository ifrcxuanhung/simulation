<style>
.form .form-bordered .form-group{
	border-bottom: 1px solid #3e3e3e;
margin: 0;

}
.form .form-bordered label{ color:#0f84c0; padding:20px !important; text-transform:uppercase; }
.portlet.light.bordered.form-fit > .portlet-title{ border-bottom:1px solid #444 !important}
.form .form-bordered .form-group > div{ border-left:1px solid #444 !important}
</style>
<div class="col-md-12">
    <!-- BEGIN PORTLET-->
    <div class="portlet light form-fit bordered" style="width:100%;">
        <div class="portlet-title" style="background:#4c87b9; padding-top:0px; padding-bottom:0px; border:solid 1px #404040 !important;">
        <div class="caption" style="color:#fff; font-weight:bold; line-height:27px;">
            <i class="fa"></i><?php translate('Maintenance'); ?></div>
           
    </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal form-bordered">
                <!--<div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('INSERT TABLE'); ?></label>
                        <div class="col-md-9">
                             <div class="col-md-3">
                                 <button class="btn blue create_exc" type="button">INSERT VDM_CONTRACTS_SETTING_EXC</button>
                             </div>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('UPDATE TABLE'); ?></label>
                         <div class="col-md-9">
                            <button class="btn blue update_exc" type="button">UPDATE VDM_CONTRACTS_SETTING_EXC</button>
                           </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('CLEAN DASHBOARD'); ?></label>
                        <div class="col-md-9">
                            <button class="btn blue clean_dashboard" type="button">CLEAN DASHBOARD_FUTURE</button>
                           </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('CLEAN CONTRACTS'); ?></label>
                        <div class="col-md-9">
                         <button class="btn blue clean_contracts_setting" type="button">CLEAN VDM_CONTRACTS_SETTING</button>
                            </div>
                    </div>
                    
                </div>-->
                <?php foreach($maintenance_list as $value){ ?>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php echo $value['description'] ; ?></label>
                        <div class="col-md-9">
                             <div class="col-md-3">
                                 <button class="btn blue <?php echo $value['title']; ?>" type="button"><?php echo $value['task'] ;?></button>
                             </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </form>
            
            <!-- END FORM-->
            
        </div>
 </div>
    <!-- END PORTLET-->
</div>


<div id="modal_view_user2" class="modal bs-modal-md fade" tabindex="-1" aria-hidden="true" data-width="500">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header" style="background-color: #E4AD36;">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	      <h4 class="modal-title"><?php echo translate('Do you want create table vdm_contracts_setting_exc ? '); ?></h4>
	    </div>
	    <form id="form_view_user" role="form" class="form-horizontal" action="" method="post">
	      <div class="modal-body">
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
 