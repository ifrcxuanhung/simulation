<?php
if(!isset($_SESSION['simulation']['user_id'])){
    redirect(base_url().'start');
}?>
<div class="portlet box red blocks" style="position:relative">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_available_modules'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>

        <div class="portlet-body background_portlet text-center" <?php if($height != 0){?>style="height:<?php echo $height;?>px; line-height:<?php echo $height;?>px"<?php }?>>
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
            <div style="clear: both;"></div>
        </div>



</div>