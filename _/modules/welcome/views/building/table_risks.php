<div class="portlet box red blocks" style="margin-bottom:5px; position:relative;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_portfolio_risk_mgt'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>

    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px"<?php }?>>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table_cus">
                <thead>
                <tr>
                    <th class="th_custom" id="edu_des"style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_name'); ?></h6></th>
                    <th class="th_custom" id="edu_title"><h6 class="color_h6 cus_type"><?php translate('head_tb_more'); ?></h6> </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($portfolio as $value){ ?>
                    <tr>
                        <td class="td_custom" align="left"><?php echo $value['title'] ?></td>
                        <td class="td_custom more_p" ><img src="<?php echo template_url() ?>/images/more.png"></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>