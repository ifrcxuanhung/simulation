<?php  
if(!isset($_SESSION['simulation']['user_id'])){
			redirect(base_url().'start');	
}?>
  <div class="row">
        <?php echo $dashboard_stat; ?>
    </div><!--row-->
    <!-- BEGIN CONTENT -->
	<div class="row">
        <div class="col-md-3 blocks use_fullscreen">
        <?php echo $by_underlying; ?>
         <?php echo $market; ?>
           <?php //echo $chart; ?>
        </div>
        <div class="col-md-6 blocks use_fullscreen">
          <?php echo $news; ?>
            <?php echo $calendar; ?>
        </div>
        <div class="col-md-3 blocks use_fullscreen">
         	<?php echo $trading; ?>
        </div>
    </div>
  
    <!-- END CONTENT -->   