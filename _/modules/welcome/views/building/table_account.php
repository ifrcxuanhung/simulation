<div class="portlet box red blocks" style="margin-bottom:5px;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_account'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>

    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style = "height:<?php echo $height;?>px" <?php }?>>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table_cus">
                <thead>        </thead>
                <tbody>
                <?php foreach($sim_account as $value){ ?>
                    <tr>
                        <td class="td_custom cus_pri"><?php echo $value['data'] ?> </td>
                        <td class="td_custom" align="right"><?php echo number_format($value['value']); ?></td>
                        <td class="td_custom"><?php echo $value['cur'] ?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
