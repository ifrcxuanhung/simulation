<?php  
if(!isset($_SESSION['simulation']['user_id'])){
			redirect(base_url().'start');	
}?>
    <div class="row">
        <?php echo $dashboard_stat; ?>
    </div><!--row-->
    <!-- BEGIN CONTENT -->
	<div class="row">
        <div class="col-md-4 blocks use_fullscreen">
            <?php echo $education_news; ?>
        </div>
        <div class="col-md-5 blocks use_fullscreen">
            <?php echo $education_glossary; ?>
        </div>
       <div class="col-md-3 blocks use_fullscreen">
            <?php echo $type_strategies; ?>
       </div>
    </div>
    <!-- END CONTENT -->   
