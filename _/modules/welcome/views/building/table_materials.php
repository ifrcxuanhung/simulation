<div class="portlet box red blocks" style="margin-bottom:5px;">
    <div class="portlet-title header-table" style="position:relative;">
        <div class="caption"><?php translate('head_box_material'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
        <div class="search_glosary1"><input type="name" placeholder="<?php translate('holder_search'); ?>..." name="query1" class="form-control input-small"></div>
    </div>

    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px" <?php }?>>
        <div class="table-responsive scroller" style="height:250px;">
            <table class="table  table-bordered table-hover table_color table_scroll table_cus">
                <thead>
                <tr>
                    <th class="th_custom" id="edu_title"><h6 class="color_h6 cus_type"><?php translate('head_tb_type'); ?></h6> </th>
                    <th class="th_custom" id="edu_des" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_title'); ?></h6></th>

                </tr>
                </thead>
                <tbody>
                <?php foreach($material as $value_material){ ?>
                    <tr>
                        <td class="td_custom cus_pri" style="text-transform: capitalize;"> <?php echo $value_material['clean_scat'] ?> </td>
                        <td class="td_custom" align="left"><strong><?php echo $value_material['title'] ?></strong><br /><?php echo $value_material['by'] ?> </td>
                        <td class="td_custom more_p"><?php if($value_material['url'] !='') echo '<a target="_blank" href="'.$value_material['url'].'"><img src="'.template_url().'/images/more.png"></a>' ?></td>

                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>