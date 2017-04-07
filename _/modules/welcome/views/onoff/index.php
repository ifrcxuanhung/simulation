<style>
.form .form-bordered .form-group{
	border-bottom: 1px solid #3e3e3e;
margin: 0;

}
.form .form-bordered label{ color:#0f84c0; padding:20px !important; text-transform:uppercase; }
.portlet.light.bordered.form-fit > .portlet-title{ border-bottom:1px solid #444 !important}
.form .form-bordered .form-group > div{ border-left:1px solid #444 !important}
</style>
<?php  
if(!isset($_SESSION['simulation']['user_id'])){
			redirect(base_url().'start');	
}?>
<div class="col-md-12">
    <!-- BEGIN PORTLET-->
    <div class="portlet light form-fit bordered" style="width:100%;">
        <div class="portlet-title" style="background:#4c87b9 !important; padding-top:0px; padding-bottom:0px; border:solid 1px #404040 !important;">
        <div class="caption" style="color:#fff; font-weight:bold; line-height:27px;">
            <i class="fa"></i><?php translate('head_open_close'); ?></div>
           
    </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal form-bordered">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('open/close'); ?></label>
                        <div class="col-md-9">
                          <input type="checkbox" <?php echo ($value['value'] != -1)? "checked":'';?> class="make-switch" name="open_off" id="open_off" data-size="normal">
                           </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('break'); ?></label>
                         <div class="col-md-9">
                           <input id="break" type="checkbox" name="break" value="break" class="make-switch switch-radio1"> 
                           </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('suspended'); ?></label>
                        <div class="col-md-9">
                           <input id="suspended" type="checkbox" name="suspended" value="suspended" class="make-switch switch-radio1"> 
                           </div>
                    </div>
                    
                    
                   <!-- <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('close'); ?></label>
                        <div class="col-md-9">
                            <input id="option2" type="radio" name="radio1" value="option2" class="make-switch switch-radio1"> </div>
                    </div>-->
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('freqm'); ?></label>
                        <div class="col-md-9">
                         <input type="text" id="freqm" name="freqm" placeholder="Market making seconds" class="form-control input-medium" value="<?php echo $value['value'];?>">
                            </div>
                    </div>
                    
                  <!--  <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('market_making_futures'); ?></label>
                        	<div class="col-md-9">
                          <input type="checkbox" <?php echo ($value2['value'] == 1)? "checked":'';?> class="make-switch" name="market_making_futures" id="market_making_futures" data-size="normal">
                           </div>
                    </div>
                    -->
                    
               
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <a href="javascript:;" class="btn green submit_open_close">
                                <i class="fa fa-check"></i> Submit</a>
                           <!-- <a href="javascript:;" class="btn btn-outline grey-salsa">Cancel</a>-->
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- END FORM-->
            
        </div>
 </div>
    <!-- END PORTLET-->
</div>
 