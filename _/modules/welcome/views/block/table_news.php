 <div class="portlet box red blocks" style="margin-bottom:5px; position:relative;">
    
        <div class="portlet-title header-table">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_news'); ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
        </div>
        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_scroll table_cus">
                    <thead>
                        <tr> 
                            <th class="th_custom" id="cld_id" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_id'); ?></h6></th>
                            <th class="th_custom" id="cld_datetime" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_datetime'); ?></h6></th>
                            <th class="th_custom" id="cld_title" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_title'); ?></h6> </th>
                             <th class="th_custom" id="cld_loca" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_location'); ?></h6> </th>
                            
                          
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					foreach($simul_news as $simul_new){?>
                        <tr>
                        <td class="td_custom" align="left"> <h6 class="color_h6 cus_type" id="cus_p"><?php echo $simul_new['id'];?></h6> </td>
                         <td class="td_custom" align="left">  <?php
							if(date("Y-m-d") == date("Y-m-d",strtotime($simul_new['datetime'])))
								echo date("H:i:s",strtotime($simul_new['datetime']));
								else echo date("Y-m-d H:i:s",strtotime($simul_new['datetime']));?> </td>
                            <td class="td_custom cus_pri" align="left"> <?php echo $simul_new['title'];?> </td>
                            <td class="td_custom" align="left"> <?php echo $simul_new['location'];?> </td>
                           
                     
                        
                        </tr>
                     <?php }?>
                     
                    </tbody>
                </table>
            </div>
        </div>
 
        
    </div>
    
