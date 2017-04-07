
<div class="portlet box red blocks" style="margin-bottom:5px; position:relative	;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_option_contract'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style = "height:<?php echo $height;?>px" <?php }?>>
        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_utype'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_name'); ?></h6> </th>


                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_expiry'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_callput'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_strike'); ?></h6> </th>

                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_bid'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_ask'); ?></h6> </th>


                        <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //echo "<pre>";print_r($finances);exit;
                    foreach($dashboard_option_contract as $key=>$market){
                        $mmm = substr(strftime('%B',strtotime($market['expiry'])),0,3);
                        $yy = strftime('%y',strtotime($market['expiry']));
                        $find_format = strpos($market['format'],'.');
                        $find_comma = strpos($market['format'],',');
                        if(isset($find_format) && $find_format){
                            $explode = explode(".",$market['format']);
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
                            <td class="td_custom" align="left"><?php echo substr($market['utype'],0,3); ?> </td>
                            <td class="td_custom cus_pri" align="left"><?php echo $market['name'] ?> </td>


                            <td class="td_custom" align="left"><?php echo strtoupper($mmm.'-'.$yy);?></td>
                            <td class="td_custom" align="left"><?php echo $market['type'] ?> </td>

                            <td class="td_custom" align="left"><?php echo $market['strike'] ?> </td>

                            <td class="td_custom" align="right"> <span class="<?php echo ($market['bid'] != NULL && $market['bid'] !='-')? 'bg_color_red': '';?> option_contracts_bid" id="option_contracts_bid_<?php echo $key;?>"><?php echo ($market['bid'] != NULL && $market['bid'] !='-') ? number_format($market['bid'],$get_decimal,'.',$get_comma):'';?></span> </td>
                            <td class="td_custom" align="left"> <span class="<?php echo ($market['ask'] != NULL && $market['ask'] !='-')? 'bg_color_green': '';?> option_contracts_ask" id="option_contracts_ask_<?php echo $key;?>"><?php echo ($market['ask'] != NULL && $market['ask'] !='-') ? number_format($market['ask'],$get_decimal,'.',$get_comma):'';?></span> </td>


                            <td class="td_custom " align="right"><?php echo ($market['last'] != NULL && $market['last'] !='-' && $market['last'] !=0.00)? number_format($market['last'],$get_decimal,'.',$get_comma):'-';?></td>
                            <td class="td_custom " align="right" <?php if($market['var'] < 0) echo 'style =" color:#ee2222;"';
                            if($market['var'] > 0) echo 'style =" color:#00a800;"';?> >

                                <?php
                                if($market['var'] > 0){
                                    echo ($market['var'] != NULL && $market['var'] !='-' && $market['last'] !=0.00)? ('+'.number_format($market['var'],2,'.',',').' %'):'-';
                                }

                                else{
                                    echo ($market['var'] != NULL && $market['var'] !='-' && $market['last'] !=0.00)? (number_format($market['var'],2,'.',',').' %'):'-';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php }


                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


