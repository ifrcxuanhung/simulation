<div class="portlet box blocks" style="position:relative;">
    <div class="portlet-title" style="background:#4c87b9 !important;">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_flot_chat'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet" style="margin-right:5px;">
        <input name="code_chart" id="code_chart" type="hidden" sttr='<?php echo $_SESSION['array_other_product']['usymbol'];?>' value="<?php echo $_SESSION['array_other_product']['codeint'];?>">
        <!--<div id="chart_4" class="chart" style="min-height:<?php echo $height; ?>;  padding: 0px; position: relative;"></div>-->
        <div id="chartdiv" class="chart" style="height: 463px;"> </div>
    </div>
</div>