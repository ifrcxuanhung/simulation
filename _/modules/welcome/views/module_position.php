<?php
if(!isset($_SESSION['simulation']['user_id'])){
    redirect(base_url().'start');
}?>

<!-- BEGIN CONTENT -->
<div class="row">
    <?php echo $dashboard_stat; ?>
    <?php if(isset($column1_top[0]['name']) && $column1_top[0]['name'] != ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column1 as $val){?>

                <?php
                if($val['position'] =='top'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column1_top[0])?$column1_top[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column1 as $val){?>

                <?php
                if($val['position'] =='top'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>


    <?php if(isset($column2_top[0]['name']) && $column2_top[0]['name']!= ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column2 as $val){?>

                <?php
                if($val['position'] =='top'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column2_top[0])?$column2_top[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column2 as $val){?>

                <?php
                if($val['position'] =='top'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>

    <?php }?>

    <?php if(isset($column3_top[0]['name']) && $column2_top[0]['name']!= ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column3 as $val){?>

                <?php
                if($val['position'] =='top'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column3_top[0])?$column3_top[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column3 as $val){?>

                <?php
                if($val['position'] =='top'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>


</div>

<div class="row">
    <?php if(isset($column1_content[0]['name']) && $column1_content[0]['name'] != ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column1 as $val){?>

                <?php
                if($val['position'] =='content'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>

        <div class="col-md-<?php echo isset($column1_content[0])?$column1_content[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column1 as $val){?>

                <?php
                if($val['position'] =='content'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>


    <?php if(isset($column2_content[0]['name']) && $column2_content[0]['name'] != ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column2 as $val){?>

                <?php
                if($val['position'] =='content'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column2_content[0])?$column2_content[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column2 as $val){?>

                <?php
                if($val['position'] =='content'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>


    <?php if(isset($column3_content[0]['name']) && $column3_content[0]['name'] != ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column3 as $val){?>

                <?php
                if($val['position'] =='content'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column3_content[0])?$column3_content[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column3 as $val){?>

                <?php
                if($val['position'] =='content'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>

</div>

<div class="row">

    <?php if(isset($column1_bottom[0]['name']) && $column1_bottom[0]['name'] != ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column1 as $val){?>

                <?php
                if($val['position'] =='bottom'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column1_bottom[0])?$column1_bottom[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column1 as $val){?>

                <?php
                if($val['position'] =='bottom'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>


    <?php if(isset($column2_bottom[0]['name']) && $column2_bottom[0]['name'] != ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column2 as $val){?>

                <?php
                if($val['position'] =='bottom'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column2_bottom[0])?$column2_bottom[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column2 as $val){?>

                <?php
                if($val['position'] =='bottom'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>

    <?php if(isset($column3_bottom[0]['name']) && $column3_bottom[0]['name'] != ''){?>
        <div class="col-md-12 blocks use_fullscreen">
            <?php foreach($column3 as $val){?>

                <?php
                if($val['position'] =='bottom'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }else{?>
        <div class="col-md-<?php echo isset($column3_bottom[0])?$column3_bottom[0]['final_wd']:'';?> blocks use_fullscreen">
            <?php foreach($column3 as $val){?>

                <?php
                if($val['position'] =='bottom'){
                    echo $$val['module'];
                }?>

            <?php }?>
        </div>
    <?php }?>
</div>
<!-- END CONTENT -->
