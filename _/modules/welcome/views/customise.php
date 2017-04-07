<?php  
if(!isset($_SESSION['simulation']['user_id'])){
			redirect(base_url().'start');	
}?>
<div class="row">
        <?php echo $dashboard_stat; ?>
    </div><!--row-->
  
<!-- BEGIN CONTENT -->
<div class="row">
    <div class="col-md-3 blocks use_fullscreen">
        
        <div class="portlet box red blocks" style="position:relative;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa"></i><?php translate('head_box_module1'); ?></div>
                    <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
            <div class="portlet-body background_portlet text-center" style="height: 250px; line-height: 250px;">
                <a class="btn btn-lg yellow custom_p" >
                    <?php translate('btn_drag_and_drop'); ?>
                </a>
            </div>
         </div>
         <div class="portlet box red blocks" style="position:relative">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa"></i><?php translate('head_box_module2'); ?></div>
                    <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
            <div class="portlet-body background_portlet text-center" style="height: 150px; line-height: 150px;">
                <a class="btn btn-lg yellow custom_p" >
                    <?php translate('btn_drag_and_drop'); ?>
                </a>
            </div>
         </div>

        
    </div>
    <div class="col-md-6 blocks use_fullscreen">
        <div class="portlet box red blocks" style="position:relative">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa"></i><?php translate('head_box_module3'); ?></div>
                    <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
            <div class="portlet-body background_portlet text-center" style="height: 450px; line-height: 450px;">
                 <a class="btn btn-lg yellow custom_p" >
                    <?php translate('btn_drag_and_drop'); ?>
                 </a>
            </div>
         </div>
    </div>
    <div class="col-md-3 blocks use_fullscreen">
        <div class="portlet box red blocks" style="position:relative">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa"></i><?php translate('head_box_module4'); ?></div>
                    <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
            <div class="portlet-body background_portlet text-center" style="height: 450px; line-height: 450px;">
                 <a class="btn btn-lg yellow custom_p" >
                    <?php translate('btn_drag_and_drop'); ?>
                </a>
            </div>
         </div>
    </div>
</div>
<!-- END CONTENT -->   
<div class="row">
    <div class="portlet box red blocks" style="position:relative">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_available_modules'); ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
        </div>
        <div class="portlet-body background_portlet">
            <div class="row">
                <div class="col-md-2" style="margin-left: 40px;">
                    <img class="img-responsive" src="<?php echo base_url() ?>assets/upload/1.png" />
                </div>
                <div class="col-md-2" style="margin-left: 40px;">
                    <img class="img-responsive" src="<?php echo base_url() ?>assets/upload/2.png" />
                </div>
                <div class="col-md-2" style="margin-left: 40px;">
                    <img class="img-responsive" src="<?php echo base_url() ?>assets/upload/3.png" />
                </div>
                <div class="col-md-2" style="margin-left: 40px;">
                    <img class="img-responsive" src="<?php echo base_url() ?>assets/upload/4.png" />
                </div>
                <div class="col-md-2" style="margin-left: 40px;">
                    <img class="img-responsive" src="<?php echo base_url() ?>assets/upload/5.png" />
                </div>
            </div>
        </div>
     </div>
</div><!--row-->