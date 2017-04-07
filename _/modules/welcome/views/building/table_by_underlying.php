<div class="portlet box red blocks" style="margin-bottom:5px; position:relative	;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_future_by_underlying'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px" <?php }?>>
        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>

                        <th class="th_custom" style="text-align:left" width="25%"> <h6 class="color_h6 cus_type"><?php translate('head_tb_dsymbol'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left" width="25%"> <h6 class="color_h6 cus_type"><?php translate('head_tb_expiry'); ?></h6> </th>
                        <th class="th_custom" style="text-align:right" width="25%"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:right" width="25%"> <h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach($by_underlying as $under){
                        $mmm = substr(strftime('%B',strtotime($under['expiry'])),0,3);
                        $yy = strftime('%y',strtotime($under['expiry']));
                        $find_format = strpos($under['format'],'.');
                        $find_comma = strpos($under['format'],',');
                        if(isset($find_format) && $find_format){
                            $explode = explode(".",$under['format']);
                            $get_decimal = strlen($explode[1]);
                            if(isset($find_comma) && $find_comma) {
                                $get_comma = ',';
                            }else{
                                $get_comma = '';
                            }
                        }
                        else if(isset($find_comma) && $find_comma){
                            $get_comma = ',';
                            $get_decimal = 0;
                        }
                        else{
                            $get_decimal = 0;
                            $get_comma = '';
                        }
                        ?>
                        <tr>
                            <td class="td_custom cus_pri" align="left"><?php echo $under['dsymbol'] ?> </td>
                            <td class="td_custom" align="left"><?php echo strtoupper($mmm.'-'.$yy);?></td>
                            <td class="td_custom " align="right"><?php echo ($under['last'] != 0.00) ? number_format($under['last'],$get_decimal,'.',$get_comma):'-';?></td>
                            <td class="td_custom " align="right" <?php if($under['var'] < 0) echo 'style =" color:#ee2222;"';
                            if($under['var'] > 0) echo 'style =" color:#00a800;"';?>><?php
                                if($under['var'] > 0){
                                    echo ($under['var'] != 0.00) ? "+".number_format($under['var'],2,'.',',').' %':'-';

                                }
                                else{
                                    echo ($under['var'] != 0.00) ? number_format($under['var'],2,'.',',').' %':'-';
                                }?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


