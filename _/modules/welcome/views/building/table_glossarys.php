<div class="portlet box red blocks" style="margin-bottom:5px;">
    <div class="portlet-title header-table" style="position:relative;">

        <div class="caption"><?php translate('head_box_glossary'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="search_glosary"><input type="name" placeholder="<?php translate('holder_search'); ?>..." name="query" class="form-control input-small"></div>

    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px" <?php }?>>

        <div class="table-responsive text_scroll scroller" style="height:250px;">
            <table class="table table-bordered table-hover table_color table_scroll table_cus">
                <thead>
                <tr>
                    <th class="th_custom" id="edu_title"><h6 class="color_h6 cus_type"><?php translate('head_tb_title'); ?></h6> </th>
                    <th class="th_custom" id="edu_des" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_description'); ?></h6></th>

                </tr>
                </thead>
                <tbody>

                <?php foreach($glossary as $value){ ?>
                    <tr>
                        <td class="td_custom cus_pri" id="edu_title"><?php echo $value['title'] ?>  </td>
                        <td class="td_custom" align="left" id="edu_des"> <?php echo $value['description'] ?> </td>

                    </tr>
                <?php }?>

                </tbody>
            </table>
        </div>
    </div>

</div>