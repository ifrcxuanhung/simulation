<?php
if(!isset($_SESSION['simulation']['user_id'])){
    redirect(base_url().'start');
}?>

<div class="portlet box red blocks" style="position:relative;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_module1'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet text-center" <?php if($height != 0){?>style="height:<?php echo $height;?>px; line-height:<?php echo $height;?>px"<?php }?>>
        <a class="btn btn-lg yellow custom_p" >
            <?php translate('btn_drag_and_drop'); ?>
        </a>
    </div>
</div>
