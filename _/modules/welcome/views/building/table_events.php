<div class="portlet box red blocks" style="margin-bottom:5px;">
    <div class="portlet-title header-table" style="position:relative;">
        <div class="caption"><?php translate('head_box_event'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px" <?php }?>>
        <div class="table-responsive">
            <table class="table  table-bordered table-hover table_color table_scroll table_cus">
                <thead>
                <tr>
                    <th class="th_custom" id="edu_title"><h6 class="color_h6 cus_type"><?php translate('head_tb_date'); ?></h6> </th>
                    <th class="th_custom" id="cld_title"  style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_title'); ?></h6></th>
                    <th class="th_custom" id="edu_title" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_location'); ?></h6></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($event_news as $value_event){ ?>
                    <tr>
                        <td class="td_custom cus_pri"><?php echo $value_event['datetime']; ?>  </td>
                        <td class="td_custom" align="left"> <?php echo $value_event['title']; ?> </td>
                        <td class="td_custom" align="right"> <?php echo $value_event['location']; ?> </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>