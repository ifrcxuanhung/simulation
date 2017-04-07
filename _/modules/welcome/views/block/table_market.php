
    <div class="portlet box red blocks" style="margin-bottom:5px; position:relative	;">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa"></i><?php translate('head_box_market'); ?></div>
                 <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
        </div>
        <div class="portlet-body background_portlet">
            <div class="portlet-body background_portlet">
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover table_color table_cus">
                        <thead>
                        <tr>
                        
                            <th class="th_custom" style="text-align:left" width="40%"> <h6 class="color_h6 cus_type"><?php translate('head_tb_name'); ?></h6> </th>
                            <th class="th_custom" style="text-align:right" width="30%"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6>  </th>
                            <th class="th_custom" style="text-align:right" width="30%"> <h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        //echo "<pre>";print_r($finances);exit;
                        foreach($simul_markets as $market){
                            if(strtoupper($market['name']) != 'VN30' && strtoupper($market['name']) != 'HN30' && strtoupper($market['name']) != 'VNX25'){
                            ?>
                            <tr>
                                <td class="td_custom cus_pri" align="left"><?php echo $market['name'] ?> </td>
                                <td class="td_custom " align="right"><?php echo ($market['last'] != NULL && $market['last'] !='-' && $market['last'] !=0.00)? number_format($market['last'],2,'.',','):'-';?></td>
                                <td class="td_custom " align="right" <?php if($market['var'] < 0) echo 'style =" color:#ee2222;"';
							if($market['var'] > 0) echo 'style =" color:#00a800;"';?> >
                            
							<?php 
							if($market['var'] > 0){
								echo ($market['var'] != NULL && $market['var'] !='-' && $market['var'] !=0.00)? ('+'.number_format($market['var'],2,'.',',').' %'):'-';
							}
							
							else{
								echo ($market['var'] != NULL && $market['var'] !='-' && $market['var'] !=0.00)? (number_format($market['var'],2,'.',',').' %'):'-';		
							}
							?>
                            </td>
                            </tr>
                         <?php }
                            
                            }
                        
                            ?>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

