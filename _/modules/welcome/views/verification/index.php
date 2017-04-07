<style>
.form .form-bordered .form-group{
	border-bottom: 1px solid #3e3e3e;
margin: 0;
}
.e{
     color:#eeeeee !important;
    }   
.form .form-bordered label{ color:#0f84c0; padding:20px !important; text-transform:uppercase; }
.portlet.light.bordered.form-fit > .portlet-title{ border-bottom:1px solid #444 !important}
.form .form-bordered .form-group > div{ border-left:1px solid #444 !important}
</style>
<div class="col-md-12">
    <!-- BEGIN PORTLET-->
<div class="row">
        <div class="portlet light form-fit bordered" style="width:100%;">
            <div class="portlet-title" style="background:#4c87b9; padding-top:0px; padding-bottom:0px; border:solid 1px #404040 !important;">
            <div class="caption" style="color:#fff; font-weight:bold; line-height:27px;">
                <i class="fa"></i><?php translate('Verification'); ?></div>
               
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->                    
                    <div class="portlet-body background_portlet">
                        <div class="table-responsive">
                        <table class="table  table-bordered table-hover table_color table_cus">
                            <thead>
                                <tr>
                                    <th class="th_custom" style="text-align:center"><h6 class="color_h6 cus_type"><?php translate('ID'); ?></h6>  </th>
                                    <th class=""><h6 class="color_h6 cus_type"><?php translate('Table name'); ?></h6>  </th>
                                     <th class="" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('Colum name'); ?></h6></th>
                                    <th class="" style="text-align:center"><h6 class="color_h6 cus_type"><?php translate('Status'); ?></h6></th>
                                    <th class="" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('Comment'); ?></h6></th>
                                    <th class="" style="text-align:center"><h6 class="color_h6 cus_type"><?php translate('Check'); ?></h6></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
        					
        					foreach($verification_list as $value){ ?>
                                <tr>
                                    <td class="cus_pri e" id="cld_id" style="text-align:center"> <?php echo $value['id'];?> </td>
                                    <td class="cus_pri" id="cld_loca" > <?php echo $value['table_name'];?> </td>
                                    <td class="cus_pri e" id="cld_loca" > <?php echo $value['colume_name'];?> </td>
                                    <td class="cus_pri e" id="cld_loca" style="text-align:center"> <?php echo $value['status'];?> </td>
                                    <td class="cus_pri e" align="left"> <?php echo $value['comment'];?> </td>
                                    <td class="cus_pri " id="cld_loca" style="text-align:center"><button class="btn blue btn_check" attr="<?php echo $value['id'];?>" type="button">CHECK</button></td>
                                </tr>
                             <?php }?>
                            
                            </tbody>
                        </table>
                </div>
            </div>
                <!-- END FORM-->
                
            </div>
        </div>
</div>
        <div class="row">
             <div class="portlet light form-fit bordered" style="width:100%;">
            <div class="portlet-title" style="background:#4c87b9; padding-top:0px; padding-bottom:0px; border:solid 1px #404040 !important;">
            <div class="caption" style="color:#fff; font-weight:bold; line-height:27px;">
                <i class="fa"></i><?php translate('Query'); ?></div>
               
            </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="form-horizontal form-bordered">
                        
                        <div class="portlet-body background_portlet">
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover table_color table_cus">
                            <thead>
                                <tr>
                                    <th class="th_custom" style="text-align:center"><h6 class="color_h6 cus_type"><?php translate('ID'); ?></h6>  </th>
                                    <th class=""><h6 class="color_h6 cus_type"><?php translate('Category'); ?></h6>  </th>
                                    <th class="" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('Name'); ?></h6></th>
                                    <th class="" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('Description'); ?></h6></th>
                                    <th class="" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('Update'); ?></h6></th>
                                    <th class="" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('Author'); ?></h6></th>
                                    <th class="" style="text-align:center"><h6 class="color_h6 cus_type"><?php translate('Check'); ?></h6></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
        					
        					foreach($query_list as $value){ ?>
                                <tr>
                                    <td class="cus_pri e" id="cld_id" style="text-align:center"> <?php echo $value['id'];?> </td>
                                    <td class="cus_pri " id="cld_loca"> <?php echo $value['category'];?> </td>
                                    <td class="cus_pri e" id="cld_cat"> <?php echo $value['name'];?> </td>
                                    <td class="cus_pri e" id="cld_desc"> <?php echo $value['description'];?> </td>
                                    <td class="cus_pri e" id="cld_loca" align="right"> <?php echo $value['date_update'];?> </td>
                                    <td class="cus_pri e" id="cld_loca" align="left"> <?php echo $value['author'];?> </td>
                                    <td class="cus_pri" id="cld_loca" style="text-align:center"><button class="btn blue ver_check" attr="<?php echo $value['id'];?>" type="button">CHECK</button></td>
                                </tr>
                             <?php }?>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                    <!-- END FORM-->
                    
                </div>
            </div>
         </div>
    <!-- END PORTLET-->
</div>


<div id="modal_view_user2" class="modal bs-modal-md fade" tabindex="-1" aria-hidden="true" data-width="500">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header" style="background-color: #E4AD36;">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	      <h4 class="modal-title"><?php echo translate('Do you want clean data ? '); ?></h4>
	    </div>
	    <form id="form_view_user" role="form" class="form-horizontal" action="" method="post">
	   <!--<input type="text" id="id_check"  class="form-control input-medium" hidden="true" value="">-->
	      <div class="modal-footer">
            <a href="#" class="btn default" data-dismiss="modal"><?php echo translate('Cancel'); ?></a>
	        <input type="button" class="btn green rever_check" value="<?php echo translate('OK'); ?>"/>

	      </div>
	    </form>
	  </div>
	</div>
</div>
 