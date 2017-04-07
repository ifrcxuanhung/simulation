
<div class="portlet box red blocks" style="margin-bottom:5px; position:relative	;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_dashboard_future'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px"<?php }?>>
        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_utype'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_name'); ?></h6> </th>

                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_expiry'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_underlying'); ?></h6> </th>
                        <!--<th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_qbid'); ?></h6> </th>-->
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_bid'); ?></h6> </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_ask'); ?></h6> </th>
                        <!--<th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_qask'); ?></h6> </th>-->
                        <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //echo "<pre>";print_r($dashboard_future_trading);exit;
                    foreach($dashboard_future_trading as $key=>$val_dft){
                        $mmm = substr(strftime('%B',strtotime($val_dft['expiry'])),0,3);
                        $yy = strftime('%y',strtotime($val_dft['expiry']));
                        //get format any value
                        $find_format = strpos($val_dft['format'],'.');
                        $find_comma = strpos($val_dft['format'],',');
                        if(isset($find_format) && $find_format){
                            $explode = explode(".",$val_dft['format']);
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
                            <td class="td_custom futures_contracts_utype" id="futures_contracts_utype_<?php echo $key;?>" align="left"><?php echo substr($val_dft['utype'],0,3); ?> </td>
                            <td class="td_custom cus_pri futures_contracts_name" id="futures_contracts_name_<?php echo $key;?>" align="left"><a href="<?php echo base_url()?>futures_live" class="save_session_dsymbol" id="<?php echo $val_dft['dsymbol'] ?>"><?php echo $val_dft['name'] ?></a></td>

                            <td class="td_custom futures_contracts_expiry" id="futures_contracts_expiry_<?php echo $key;?>" align="left"><?php echo strtoupper($mmm.'-'.$yy);?></td>

                            <td class="td_custom futures_contracts_underlying" id="futures_contracts_underlying_<?php echo $key;?>" align="right"><?php echo ($val_dft['underlying'] != NULL && $val_dft['underlying'] !='-' && $val_dft['underlying'] != 0)? number_format($val_dft['underlying'],$get_decimal,'.',$get_comma):'-';?></td>

                            <!--<td class="td_custom" align="right"><?php echo $val_dft['qbid'] ?> </td>-->
                            <td class="td_custom"  align="right"> <span class="<?php echo ($val_dft['bid'] != NULL && $val_dft['bid'] !='-' && $val_dft['bid'] != 0)? 'bg_color_red': '';?> futures_contracts_bid" id="futures_contracts_bid_<?php echo $key;?>"><?php echo ($val_dft['bid'] != NULL && $val_dft['bid'] !='-' && $val_dft['bid'] != 0) ? number_format($val_dft['bid'],$get_decimal,'.',$get_comma):'';?></span> </td>
                            <td class="td_custom "  align="left"> <span class="<?php echo ($val_dft['ask'] != NULL && $val_dft['ask'] !='-' && $val_dft['ask'] != 0)? 'bg_color_green': '';?> futures_contracts_ask" id="futures_contracts_ask_<?php echo $key;?>"><?php echo ($val_dft['ask'] != NULL && $val_dft['ask'] !='-' && $val_dft['ask'] != 0) ? number_format($val_dft['ask'],$get_decimal,'.',$get_comma):'';?></span> </td>
                            <!-- <td class="td_custom" align="left"><?php echo $val_dft['qask'] ?> </td>-->
                            <td class="td_custom" align="right">
								<span class="<?php echo ($val_dft['last'] != NULL && $val_dft['last'] !='-' && $val_dft['last'] != 0)? 'bg_color_grey': '';?> futures_contracts_last" id="futures_contracts_last_<?php echo $key;?>">
								<?php echo ($val_dft['last'] != NULL && $val_dft['last'] !='-' && $val_dft['last'] !=0)? number_format($val_dft['last'],$get_decimal,'.',$get_comma):'-';?>
                                </span>
                            </td>
                            <td class="td_custom futures_contracts_var" id="futures_contracts_var_<?php echo $key;?>" align="right" <?php if($val_dft['var'] < 0) echo 'style =" color:#ee2222;"';
                            if($val_dft['var'] > 0) echo 'style =" color:#00a800;"';?> ><?php
                                if($val_dft['var'] > 0){
                                    echo ($val_dft['var'] != NULL && $val_dft['var'] !='-' && $val_dft['last'] !=0)? ('+'.number_format($val_dft['var'],2,'.',',').' %'):'-';
                                }

                                else{
                                    echo ($val_dft['var'] != NULL && $val_dft['var'] !='-' && $val_dft['last'] !=0)? (number_format($val_dft['var'],2,'.',',').' %'):'-';
                                }
                                ?></td>
                        </tr>
                    <?php }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


