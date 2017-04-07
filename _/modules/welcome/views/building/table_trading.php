
<!----------------------->


<div class="portlet box red blocks">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_order'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>


    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px"<?php }?>>

        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <?php
                //get format any value
                if(isset($future_format['format'])){
                    $find_format = strpos($future_format['format'],'.');
                    $find_comma = strpos($future_format['format'],',');
                    if(isset($find_format) && $find_format){
                        $explode = explode(".",$future_format['format']);
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
                }
                else {
                    $get_decimal = 0;
                    $get_comma = '';
                }
                ?>
                <form method="post" action="" id="form_hide">
                    <input type="hidden" name="input_id_user" id="input_id_user" value="<?php echo $_SESSION['simulation']['user_id'];?>"/>
                    <input type="hidden" name="input_datetime" id="input_datetime" value="<?php echo date('Y-m-d H:i:s');?>"/>
                    <input type="hidden" name="input_order_type" id="input_order_type" value="Limit order"/>
                    <input type="hidden" name="input_order_method" id="input_order_method" value="Daily"/>
                    <input type="hidden" name="input_model" id="input_model" value="3"/>
                    <input type="hidden" name="input_expiry" id="input_expiry" value="<?php echo $_SESSION['session_expiry_date'];?>"/>
                    <input type="hidden" name="input_buy_sell" id="input_buy_sell" value=""/>
                    <input type="hidden" name="input_interest" id="input_interest" value="<?php if(isset($maxspd['r'])) echo $maxspd['r'];?>"/>
                    <input type="hidden" name="input_dividend" id="input_dividend" value="<?php if(isset($maxspd['dividend_vl'])) echo $maxspd['dividend_vl'];?>"/>
                    <input type="hidden" name="input_price" id="input_price" value="<?php if(isset($_SESSION['session_price'])){
                        echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                    }else{
                        echo ($price_futures !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($price_futures,$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                    }?>"/>
                    <input type="hidden" name="input_quatity" id="input_quatity" value="<?php  if(isset($_SESSION['session_lots'])){
                        echo $_SESSION['session_lots'];
                    }else{
                        echo $simul_settings['order']['lots'][0]['name'];
                    }?>"/>
                    <input type="hidden" name="input_deadline" id="input_deadline" value="<?php echo date('Y-m-d');?>"/>
                    <input type="hidden" name="input_dsymbol" id="input_dsymbol" value="<?php echo $_SESSION['array_other_product']['dsymbol'];?>"/>


                </form>
                <table class="table  table-bordered">

                    <tbody>
                    <tr>

                        <td width="50%" class="td_custom font_size_new" align="center"> <div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" data-target="#simul_expiry" data-toggle="modal"><?php translate('head_expiry'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 val_expiry" data-target="#simul_expiry" data-toggle="modal"><?php echo $_SESSION['session_expiry'];?></h6></div></td>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_last_day'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6"  style="color:#00a800; cursor:default;"><?php echo date('d/m/y',strtotime($_SESSION['session_expiry_date'])); ?></h6></div></td>

                    </tr>

                    <tr>

                        <td width="50%" class="td_custom font_size_new"  align="center"> <div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" data-target="#order_type" data-toggle="modal"><?php translate('head_order_type'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 val_order_type" data-target="#order_type" data-toggle="modal">  <?php
                                    if(isset($_SESSION['session_order_type'])){
                                        echo $_SESSION['session_order_type'];
                                    }else{
                                        echo $simul_settings['order']['type'][0]['name'];
                                    }?></h6></div></td>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type tooltips" data-original-title="The various types of orders traders can use to specify how long an order will remain active in the market." data-placement="top" data-container="body" data-target="#menu_duration" data-toggle="modal"><?php translate('head_duration'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 val_duration" data-target="#menu_duration" data-toggle="modal"><?php
                                    if(isset($_SESSION['session_duration'])){
                                        echo $_SESSION['session_duration'];
                                    }else{
                                        echo $simul_settings['order']['duration'][0]['name'];
                                    }?></h6></div></td>


                    </tr>

                    <tr>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_lots'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 load_modals" edit_for="lots" data-target="#modals" data-toggle="modal" data-type="input"
                                                                                                                                                                                                                                                      data-value="<?php
                                                                                                                                                                                                                                                      if(isset($_SESSION['session_lots'])){
                                                                                                                                                                                                                                                          echo $_SESSION['session_lots'];
                                                                                                                                                                                                                                                      }else{
                                                                                                                                                                                                                                                          echo $simul_settings['order']['lots'][0]['name'];
                                                                                                                                                                                                                                                      }?>">
                                    <?php
                                    if(isset($_SESSION['session_lots'])){
                                        echo $_SESSION['session_lots'];
                                    }else{
                                        echo $simul_settings['order']['lots'][0]['name'];
                                    }
                                    ?>

                                </h6></div></td>

                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_price'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 load_modals" edit_for="price" data-target="#modals" data-toggle="modal" data-type="input"
                                                                                                                                                                                                                                                       data_default="<?php if(isset($_SESSION['session_price'])){
                                                                                                                                                                                                                                                           echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                                                                                                                                                                                                                                                       }else{
                                                                                                                                                                                                                                                           echo ($price_futures !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($price_futures,$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                                                                                                                                                                                                                                                       }?>"
                                                                                                                                                                                                                                                       data-value="<?php
                                                                                                                                                                                                                                                       if(isset($_SESSION['session_price'])){
                                                                                                                                                                                                                                                           echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                                                                                                                                                                                                                                                       }else{
                                                                                                                                                                                                                                                           echo ($price_futures !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($price_futures,$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                                                                                                                                                                                                                                                       }?>">
                                    <?php
                                    if(isset($_SESSION['session_price'])){
                                        echo ($_SESSION['session_price'] !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($_SESSION['session_price'],$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                                    }else{
                                        echo ($price_futures !='-' && (isset($maxspd['tick']))) ? number_format(ceiling($price_futures,$maxspd['tick']),$get_decimal,'.',$get_comma):'-' ;
                                    }?>
                                </h6></div></td>

                    </tr>

                    <tr>
                        <td align="center" class="td_custom font_size_new" colspan="2"><div class="col-md-12"><a href="<?php echo base_url().'futures_pricers'?>" style="min-height: 40px; " class="btn btn-lg blue form-control"><strong>calculate</strong></a></div></td>
                    </tr>

                    <tr>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 "><!--<h6 class="color_h6">SELL</h6>-->
                                <a style="min-height: 40px; line-height:18px; background-color: #ee2222 ; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2), 0 3px 6px rgba(0, 0, 0, 0.26);" class="btn btn-lg green form-control button_sell" data-target="#click_sell" data-toggle="modal"><strong><?php translate('btn_sell'); ?></strong></a>
                            </div></td>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12">  <a style="min-height: 40px; line-height:18px;  background-color: #00a800 ; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2), 0 3px 6px rgba(0, 0, 0, 0.26);" class="btn btn-lg green form-control button_buy" data-target="#click_buy" data-toggle="modal"><strong><?php translate('btn_buy'); ?></strong></a></div></td>
                        <!--<td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading button_h6_buy"><h6 class="color_h6">BUY</h6></div></td>-->
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>

        <div class="portlet-body background_portlet" style="margin-top:10px;">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>
                        <th class="th_custom" style="text-align:left;"><h6 class="color_h6 cus_type"> <?php translate('head_tb_size'); ?> </h6> </th>
                        <th class="th_custom" style="text-align:right; color:#ee2222;"><h6 class="color_h6 cus_type"><?php translate('head_tb_bid'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:left; color:#00a800;"><h6 class="color_h6 cus_type"><?php translate('head_tb_ask'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_size'); ?></h6> </th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>

                        <td class="td_custom font_size_13 order_qbid" align="left" style="line-height:26px;"><?php if(isset($row_future['qbid'])) echo $row_future['qbid'];?></td>
                        <?php
                        //get format any value
                        if(isset($row_future['format'])) {
                            $find_format_bid_ask = strpos($row_future['format'],'.');
                            $find_comma_bid_ask = strpos($row_future['format'],',');
                            if(isset($find_format_bid_ask) && $find_format_bid_ask){
                                $explode_bid_ask = explode(".",$row_future['format']);
                                $get_decimal_bid_ask = strlen($explode_bid_ask[1]);
                                if(isset($find_comma_bid_ask) && $find_comma_bid_ask) {
                                    $get_comma_bid_ask = ',';
                                }else{
                                    $get_comma_bid_ask = '';
                                }
                            }
                            else if(isset($find_comma_bid_ask) && $find_comma_bid_ask){
                                $get_comma_bid_ask = ',';
                                $get_decimal_bid_ask = 0;
                            }
                            else{
                                $get_decimal_bid_ask = 0;
                                $get_comma_bid_ask = '';
                            }
                        }
                        else {
                            $get_decimal_bid_ask = 0;
                            $get_comma_bid_ask = '';
                        }
                        ?>
                        <td class="td_custom font_size_13" align="right"><h6 class="color_h6 cus_type btn btn-lg green form-control order_bid" style="font-size:13px; color:#fff !important; background:#ee2222 !important; padding:5px 0px !important; height:29px; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2), 0 3px 6px rgba(0, 0, 0, 0.26);"><?php echo ($row_future['bid'] != '' && $row_future['bid'] !='-' && $row_future['bid'] != 0) ? number_format($row_future['bid'],$get_decimal_bid_ask,'.',$get_comma_bid_ask) :'-';?></h6></td>
                        <td class="td_custom font_size_13" align="left"><h6 class="color_h6 cus_type btn btn-lg green form-control order_ask" style="font-size:13px; color:#fff !important; background:#00a800 !important; padding:5px 0px !important; height:29px; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2), 0 3px 6px rgba(0, 0, 0, 0.26);"><?php echo ($row_future['ask'] != '' && $row_future['ask'] !='-' && $row_future['ask'] != 0) ? number_format($row_future['ask'],$get_decimal_bid_ask,'.',$get_comma_bid_ask) : '-';?></h6></td>
                        <td class="td_custom font_size_13 order_qask" align="right" style="line-height:26px;"><?php echo $row_future['qask'];?></td>
                    </tr>


                    </tbody>
                </table>
                <table class="table  table-bordered table-hover table_color table_cus" style="margin-top:2px;">
                    <tbody>

                    <tr>
                        <td class="td_custom font_size_old" align="left"  style="color:#1688c3; line-height:26px;"><?php echo $sum_b['b'];?></td>
                        <?php
                        //get format any value
                        if(isset($avg_b['format'])){
                            $find_format_avgb = strpos($avg_b['format'],'.');
                            $find_comma_avgb = strpos($avg_b['format'],',');
                            if(isset($find_format_avgb) && $find_format_avgb){
                                $explode_avgb = explode(".",$avg_b['format']);
                                $get_decimal_avgb = strlen($explode_avgb[1]);
                                if(isset($find_comma_avgb) && $find_comma_avgb) {
                                    $get_comma_avgb = ',';
                                }else{
                                    $get_comma_avgb = '';
                                }
                            }
                            else if(isset($find_comma_avgb) && $find_comma_avgb){
                                $get_comma_avgb = ',';
                                $get_decimal_avgb = 0;
                            }
                            else{
                                $get_decimal_avgb = 0;
                                $get_comma_avgb = '';
                            }
                        }
                        else {
                            $get_decimal_avgb = 0;
                            $get_comma_avgb = '';
                        }
                        ?>
                        <td class="td_custom font_size_old " align="right"  style="color:#1688c3;" ><h6 id="avg_buy" class="color_h6 btn  form-control bg_color_red_order" style="background:#ee2222;"><?php echo $avg_b['b']!='-' ? number_format($avg_b['b'],$get_decimal_avgb,'.',$get_comma_avgb) :'-';?></h6></td>
                        <td class="td_custom font_size_old order_maxspd" align="center" style="color:#4c87b9 !important; line-height:26px;"><?php echo $order_maxspd ?></td>
                        <?php
                        //get format any value
                        if(isset($avg_s['format'])) {
                            $find_format_avgs = strpos($avg_s['format'],'.');
                            $find_comma_avgs = strpos($avg_s['format'],',');
                            if(isset($find_format_avgs) && $find_format_avgs){
                                $explode_avgs = explode(".",$avg_s['format']);
                                $get_decimal_avgs = strlen($explode_avgs[1]);
                                if(isset($find_comma_avgs) && $find_comma_avgs) {
                                    $get_comma_avgs = ',';
                                }else{
                                    $get_comma_avgs = '';
                                }
                            }
                            else if(isset($find_comma_avgs) && $find_comma_avgs){
                                $get_comma_avgs = ',';
                                $get_decimal_avgs = 0;
                            }
                            else{
                                $get_decimal_avgs = 0;
                                $get_comma_avgs = '';
                            }
                        }
                        else {
                            $get_decimal_avgs = 0;
                            $get_comma_avgs = '';
                        }
                        ?>
                        <td class="td_custom font_size_old" align="left"  style="color:#1688c3;" ><h6 id="avg_sell" class="color_h6 btn green form-control bg_color_green_order" style="background:#00a800;"><?php echo $avg_s['s']!='-' ? number_format($avg_s['s'],$get_decimal_avgs,'.',$get_comma_avgs): '-';?></h6></td>
                        <td class="td_custom font_size_old" align="right"  style="color:#1688c3; line-height:26px;"><?php echo ($sum_s['s'] !='') ? $sum_s['s']:'-';?></td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>

        <div class="portlet-body background_portlet" style="margin-top:10px;">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6></th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_change'); ?></h6></th>
                        <th class="th_custom" style="text-align:left"><h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_positn'); ?></h6></th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <td class="td_custom font_size_13 futures_last" align="left"><?php echo $dashboard_future['last'];?></td>
                        <td class="td_custom font_size_13 futures_change" align="right"><?php echo $dashboard_future['change'];?></td>
                        <td class="td_custom font_size_13 futures_var" align="left" ><?php echo $dashboard_future['var'];?></td>
                        <td class="td_custom font_size_13 futures_oi" align="right"><?php echo $dashboard_future['oi'];?></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>




    </div>
</div>
