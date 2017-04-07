<div id="click_help" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
          
                <div class="portlet box">
            <div class="portlet-title" style="background:#00a800; font-weight:bold;">
                <div class="caption">
                    <i class="fa"></i><?php translate('model_head_confirmation'); ?></div>
             
            <!--  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
             <button data-style="slide-right" class="btn red mt-ladda-btn ladda-button" type="button" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            
          
             <div class="modal-body" style="text-align:center; font-size:16px;">
             <h4 class="title_help"></h4>
             <div style="height:1px; background:#4f4f4f;"></div>
             <input type="hidden" id="id_help" value=""/>
             <p class="description_help"></p>
            </div>
            
            <div class="modal-footer">
            <button type="button" style=" background-color: #3598dc ; margin-right:20px;" class="btn blue btn_show_edit_help"><?php translate('btn_edit'); ?></button>
            	<button type="button" style=" background-color: #3598dc ; margin-right:20px; display:none;" class="btn blue btn_edit_help" data-dismiss="modal" ><?php translate('btn_save'); ?></button>
                <button type="button" style=" background-color: #3598dc ; margin-right:20px;" class="btn green" data-dismiss="modal" ><?php translate('btn_ok'); ?></button>

            </div>

</div>                                       
</div>
</div>
</div>




<!--=========================================================================-->

<div class="portlet box red blocks" style="margin-bottom:5px; position:relative;">
    <div class="portlet-title header-table" style="position:relative;">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_faq'); ?></div>
             <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
    </div>
    <!--div class="search_glosary"><input type="name" placeholder="Search..." name="query" class="form-control"></div-->
    <div class="portlet-body background_portlet">
        <div class="table-responsive">
            <table class="table  table-bordered table-hover table_color table_scroll table_cus">
                <thead>
                    <tr>
                        <th class="th_custom" id="edu_title"><h6 class="color_h6 cus_type"><?php translate('head_tb_title'); ?></h6> </th>
                        <th class="th_custom" id="edu_des"style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_description'); ?></h6></th>
                    </tr>
                </thead>
                <tbody>
                 <?php 
				 foreach($questions as $value){ ?>
                    <tr>
                        <td class="td_custom cus_pri"><?php echo $value['clean_sub'] ?>  </td>
                        <td class="td_custom hover_help handel_help" align="left" data-target="#click_help" data-toggle="modal" id="<?php echo $value['id'] ?>" > <?php echo $value['title'] ?> </td>
                        
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
