<style>
.form .form-bordered .form-group{
	border-bottom: 1px solid #3e3e3e;
margin: 0;

}
.form .form-bordered label{ color:#0f84c0; padding:20px !important; text-transform:uppercase; }
.portlet.light.bordered.form-fit > .portlet-title{ border-bottom:1px solid #444 !important}
.form .form-bordered .form-group > div{ border-left:1px solid #444 !important}

</style>
<?php  
if(!isset($_SESSION['simulation']['user_id'])){
			redirect(base_url().'start');	
}?>



    <!-- BEGIN PORTLET-->
    <div class="portlet light form-fit bordered" style="width:100%;">
        <div style="background:#4c87b9; padding:11px 15px 9px 10px; border:solid 1px #404040 !important;">
        <div class="caption" style="color:#fff; font-weight:bold; text-transform:uppercase;
font-size: 18px;
line-height: 18px;
padding: 10px 0;">
            <i class="fa"></i><?php translate('head_marketmaking'); ?></div>
           
    </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal form-bordered">
                <div class="form-body">
                    
              
                
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('market_making_futures'); ?></label>
                        	<div class="col-md-9">
                          <input type="checkbox" <?php echo ($value2['value'] == 1)? "checked":'';?> class="make-switch" name="market_making_futures" id="market_making_futures" data-size="normal">
                           </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('mm_for_all'); ?></label>
                        	<div class="col-md-9">
                        <button data-style="slide-right" class="btn red mt-ladda-btn run_contract_setting" type="button" style="width:110px">
                            <span class="ladda-label"><?php translate('btn_run')?></span>
                        <span class="ladda-spinner"></span></button>
                           </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('mm_for_all_two'); ?></label>
                        	<div class="col-md-9">
                        <button data-style="slide-right" class="btn red mt-ladda-btn run_bid_ask_order" type="button" style="width:110px">
                            <span class="ladda-label"><?php translate('run_bid_ask_order')?></span>
                        <span class="ladda-spinner"></span></button>
                           </div>
                    </div>
                    
                     <!--    <div class="form-group">
                        <label class="control-label col-md-3"><?php translate('freqm'); ?></label>
                        <div class="col-md-9">
                         <input type="text" id="freqm" name="freqm" placeholder="Market making seconds" class="form-control input-medium" value="<?php echo $value['value'];?>">
                            </div>
                    </div>-->
                    
                    
                    
               
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <a href="javascript:;" class="btn green submit_marketmaking" style="width:110px">
                              Submit</a>
                           <!-- <a href="javascript:;" class="btn btn-outline grey-salsa">Cancel</a>-->
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- END FORM-->
            
        </div>
 </div>
    <!-- END PORTLET-->



<div class="col-md-12">

	<form id="form_currency">
	<?php if(isset($filter_get_all)){?>
    <input type="hidden" class="filter_get_all" id="filter_get_all" name="filter_get_all" attr='<?php echo $filter_get_all; ?>' />
    <?php }?>
   
    </form>
    <?php //echo "<pre>";print_r($column);exit;

	?>
    <input type="hidden" class="column" id="column" name="column" attr='<?php echo $column; ?>' error='<?php echo $error; ?>' />
   <div class="col-md-4" style="z-index:900;  position: absolute; right: 50px; top: 8px;">
        <div class="table-group-actions pull-right">
        
            <button class="btn btn-sm green exportTxt" >
                    TXT 
                </button>
             <button class="btn btn-sm red exportCsv" >
                    CSV 
                </button> 
            <button class="btn btn-sm yellow exportXls" >
                    Excel 
            </button>
        </div>
    </div>
    <form id="form_tab" action ="" method="post">
    <table id="jqGrid" class="jq_table" attr="<?php echo $table;?>" order_by="<?php echo $summary_des['order_by'];?>" summary_des="<?php echo $summary_des['description']?>" vndmi ="<?php echo $summary_des['vndmi'];?>" admin ="1">
    
    </table>	
    <div id="jqGridPager"></div>
    <input type="hidden" value="" name="actexport" id="actexport" />
    <input type="hidden" value="<?php echo $table ?>" name="table_name_export" id="table_name_export" />
    </form>

</div>


<div class="col-md-12" style="margin-top:10px;">

	<form id="form_currency">
	<?php if(isset($filter_get_all)){?>
    <input type="hidden" class="filter_get_all" id="filter_get_all" name="filter_get_all" attr='<?php echo $filter_get_all; ?>' />
    <?php }?>
   
    </form>
    <?php //echo "<pre>";print_r($column);exit;

	?>
    <input type="hidden" class="column2" id="column2" name="column2" attr='<?php echo $column2; ?>' error='<?php echo $error2; ?>' />
   <div class="col-md-4" style="z-index:900;  position: absolute; right: 50px; top: 8px;">
        <div class="table-group-actions pull-right">
        
            <button class="btn btn-sm green exportTxt2" >
                    TXT 
                </button>
             <button class="btn btn-sm red exportCsv2" >
                    CSV 
                </button> 
            <button class="btn btn-sm yellow exportXls2" >
                    Excel 
            </button>
        </div>
    </div>
    <form id="form_tab2" action ="" method="post">
    <table id="jqGrid2" class="jq_table2" attr="<?php echo $table2;?>" order_by="<?php echo $summary_des2['order_by'];?>" summary_des2="<?php echo $summary_des2['description']?>" vndmi ="<?php echo $summary_des2['vndmi'];?>" admin ="1">
    
    </table>	
    <div id="jqGridPager2"></div>
    <input type="hidden" value="" name="actexport2" id="actexport2" />
    <input type="hidden" value="<?php echo $table2 ?>" name="table_name_export2" id="table_name_export2" />
    </form>

</div>










 