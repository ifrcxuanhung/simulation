<div class="portlet box red blocks" style="margin-bottom:5px;">
    <div class="portlet-title header-table" style="position:relative;">
        <div class="caption"><?php translate('head_box_quiz'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
        <div class="search_glosary2"><input type="name" placeholder="<?php translate('holder_search'); ?>..." name="query2" class="form-control input-small"></div>
    </div>

    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px" <?php }?>>
        <div class="table-responsive scroller" style="height:250px;">
            <table class="table  table-bordered table-hover table_color table_scroll table_cus">
                <thead>
                <tr>
                    <th class="th_custom" id="edu_title" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_level'); ?></h6> </th>
                    <th class="th_custom" id="edu_des" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_name'); ?></h6></th>

                </tr>
                </thead>
                <tbody>
                <?php foreach($quiz as $value_quiz){ ?>
                    <tr>
                        <td class="td_custom cus_pri"><?php  echo $value_quiz['clean_sub']; ?>  </td>
                        <td class="td_custom" align="left"> <?php echo $value_quiz['title']; ?> </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>