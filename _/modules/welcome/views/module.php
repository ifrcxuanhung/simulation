<?php
if(!isset($_SESSION['simulation']['user_id'])){
    redirect(base_url().'start');
}
?>
<div class="row">
    <?php echo $dashboard_stat; ?>
</div>

<div class="row">
    <div class="col-md-<?php echo $column1[0]['final_wd'];?> blocks use_fullscreen">
        <?php foreach($column1 as $val){
            echo $$val['module'];
        }?>

    </div>
    <div class="col-md-<?php echo $column2[0]['final_wd']?> blocks use_fullscreen">
        <?php
        foreach($column2 as $val){
            echo $$val['module'];
        }
        ?>
    </div>
    <div class="col-md-<?php echo $column3[0]['final_wd']?> blocks use_fullscreen">
        <?php
        foreach($column3 as $val){
            echo $$val['module'];
        }
        ?>
    </div>

</div>
