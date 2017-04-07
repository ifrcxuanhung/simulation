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
            <?php echo $specs; ?>
        </div>
        <div class="col-md-6 blocks use_fullscreen">
            <?php //echo $chart; ?>
             <?php //echo $bottom_chart; ?>
             <?php echo $dashboard_future_trading;?>
              <?php echo $dashboard_option_contract;?>
            
        </div>
        <div class="col-md-3 blocks use_fullscreen">
         <?php echo $trading; ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-9 blocks use_fullscreen">
            <?php echo $finance; ?>
        </div>
        <div class="col-md-3 blocks use_fullscreen">
            <?php echo $account; ?>
             <?php echo $portfolio; ?>
            
        </div>
      
    </div>
    <!-- END CONTENT -->   