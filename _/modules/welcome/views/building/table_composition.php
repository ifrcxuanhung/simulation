
<div class="portlet box red blocks" style="margin-bottom:5px; position:relative;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_composition'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px" <?php }?>>
        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>
                        <th class="th_custom" style="text-align:left" > <h6 class="color_h6 cus_type"><?php translate('head_date'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left" width="50%"> <h6 class="color_h6 cus_type"><?php translate('head_tb_name'); ?></h6> </th>
                        <th class="th_custom" style="text-align:right" width="15%"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_capitalisation'); ?></h6></th>
                        <th class="th_custom" style="text-align:right" width="12%"> <h6 class="color_h6 cus_type"><?php translate('head_tb_wgt'); ?></h6></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //echo "<pre>";print_r($simul_markets);exit;
                    foreach($simul_markets as $market){?>
                        <tr>
                            <td class="td_custom " align="left"><?php echo $market['date'] ;?> </td>
                            <td class="td_custom cus_pri" align="left"><?php echo cut_str($market['stk_name'],40) ?> </td>
                            <td class="td_custom " align="right"><?php echo ($market['stk_price'] != NULL && $market['stk_price'] !='-')? number_format($market['stk_price'],0,'.',','):'';?></td>
                            <td class="td_custom " align="right"><?php echo ($market['stk_mcap_idx'] != NULL && $market['stk_mcap_idx'] !='-')? number_format($market['stk_mcap_idx'],0,'.',','):'';?></td>
                            <td class="td_custom " align="right" <?php if($market['stk_wgt'] < 0) echo 'style =" color:#ee2222;"';
                            if($market['stk_wgt'] > 0) echo 'style =" color:#00a800;"';?> >

                                <?php
                                if($market['stk_wgt'] > 0){
                                    echo ($market['stk_wgt'] != NULL && $market['stk_wgt'] !='-')? (number_format($market['stk_wgt'],2,'.',',').' %'):'';
                                }

                                else{
                                    echo ($market['stk_wgt'] != NULL && $market['stk_wgt'] !='-')? (number_format($market['stk_wgt'],2,'.',',').' %'):'';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


