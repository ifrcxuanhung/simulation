<div class="portlet box red blocks" style="margin-bottom:5px;">
    <div class="portlet-title" style="position:relative;">
        <div class="caption text-uppercase">
            <i class="fa"></i><?php strtoupper(translate('head_box_options_strategies')); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <!--div class="search_strategies_options"><input type="name" placeholder="Search..." name="query" class="form-control input-small"></div-->
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height: <?php echo $height;?>px" <?php }?>>
        <div class="table-responsive scroller" style="height:250px;">
            <table class="table table-bordered table-hover table_cus">
                <thead>
                <tr>
                    <th class="th_custom" id="edu_des"style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_name'); ?></h6></th>
                    <th class="th_custom" id="edu_title"><h6 class="color_h6 cus_type"><?php translate('head_tb_more'); ?></h6> </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($array['options'] as $value){ ?>
                    <tr>
                        <td class="td_custom cus_pri bold" align="left"><?php echo $value['name'] ?></td>
                        <td class="td_custom more_p" ><a style="display:flex;" target="_blank" href="<?php echo base_url().DIR_SIMULATION.'strategies?tab='.$value["tab"] ?>"><img src="<?php echo template_url() ?>/images/more.png"></a></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
