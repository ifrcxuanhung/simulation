<!--div class="modal-header" style="background-color: #E4AD36;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title"><?php echo translate('edit_for').' '.$field; ?></h4>
</div-->
  
<div class="portlet box">
    <div style="background:#00a800; font-weight:bold;" class="portlet-title">
        <div class="caption text-uppercase">
        
        <?php echo $type=='choose' ? $field : translate('Input'); ?></div>
       <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
         <button aria-hidden="true" data-dismiss="modal" type="button" class="btn red mt-ladda-btn ladda-button" data-style="slide-right"><i aria-hidden="true" class="fa fa-times"></i></button>
    </div>
    <div class="portlet-body background_portlet form">
        
            <div class="form-body">
                   
                  <div class="form-group">
                  <div class="modal-body <?php echo $type=='choose' ? 'hidden' : '' ?> text-uppercase align-center" style="text-align:center; font-size:16px; padding:5px; border-bottom:1px solid #444444;"><?php echo translate($field); ?></div>
                          
                  <div class="modal-footer" style="padding-top:25px;">
                           
                           <div class="form-group" style="margin-bottom:0px;">
                           	<div class="<?php echo $type=='choose' ? 'col-md-12' : 'col-md-12' ?>">
                                <?php echo $html_code; ?>
                            
                                
                  			 </div>
                   			
                   			</div>
                           
                                                     
                          </div>      
                          
        
                
                  
            </div>
            
             <div class="form-actions" style="padding:0px;">
                        <div class="col-md-12 align-right">
                    <a class="btn blue mar_input <?php if($field == 'price') echo 'edit_price'; elseif($field =='lots') echo 'edit_lots'; else echo 'edit-submit'; ?>" data-field="<?php echo $field ?>" href="javascript:;">OK</a>
                     </div>
                    </div>
            
    
             
    





    </div>
    <!--div class="modal-footer">
        <a href="#" class="btn default" data-dismiss="modal"><?php echo translate('Cancel'); ?></a>
        <a href="javascript:;" class="btn green save_edit" data-field="<?php echo $field ?>"><?php echo translate('Save'); ?></a>
    </div-->
</div>
</div>

<style>
.table_modal > tbody > tr > td > a:hover{
    color: #fff !important;
    text-decoration: none;
}
.table_modal > tbody > tr > td > a{
    color: #eee !important;
    text-decoration: none;
} 
</style>

<script>
$("input").keyup(function(event)
{
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {   
        $('.mar_input').click();
    }
});
</script>