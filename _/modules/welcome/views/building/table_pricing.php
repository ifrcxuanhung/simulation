<div id="menu_model" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="portlet box">
                <div class="portlet-title" style="background:#00a800; font-weight:bold;">
                    <div class="caption">
                        <i class="fa"></i><?php translate('model_head_model'); ?></div>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
                    <button data-style="slide-right" class="btn red mt-ladda-btn ladda-button" type="button" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="portlet-body background_portlet">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table_modal">
                            <thead>

                            </thead>
                            <tbody>
                            <?php foreach($name_vdm_model as $model){?>
                                <tr>
                                    <td class="td_custom cus_pri ma_cat" id="<?php echo $model['id'];?>" style=" text-transform:uppercase"><?php echo $model['name'];?></td>
                                </tr>
                            <?php }?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style=" background-color: #3598dc ; margin-right:20px;" class="btn green btn_model_pricing" data-dismiss="modal" ><?php translate('btn_ok'); ?></button>
                </div>
            </div>


        </div>
    </div>
</div>

<!--===================================================================================================-->

<div class="portlet box red blocks" style="position:relative;">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_pricing'); ?></div>
        <div class="tools">
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>


    </div>
    <?php
    if (!isset($S)) {
        $S = number_format($rs['underlying']['last'],2);
        $R = $rs['contacts']['r'];
        $T = (date('d',strtotime($rs['contacts']['expiry'])) - date('d'))+1;
        $TFORMAT = date("M-y",strtotime($rs['contacts']['expiry']));
        $Q = $rs['contacts']['dividend_vl'];
    }

    ?>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height: <?php echo $height;?>px" <?php }?>>

        <div class="portlet-body background_portlet">
            <div class="table-responsive">
                <table class="table  table-bordered">

                    <tbody>
                    <tr>
                        <td colspan="2" class="td_custom font_size_new" align="center"> <div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" data-target="#menu_model" data-toggle="modal"><?php translate('head_model'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 val_menu_model" data-target="#menu_model" id="<?php echo $vdm_model['id']?>" data-toggle="modal"><?php
                                    if(isset($_SESSION['session_menu_model'])){
                                        echo $_SESSION['session_menu_model'];
                                    }else{
                                        echo $vdm_model['name'];
                                    }?></h6></div></td>

                    </tr>

                    <tr>
                        <td width="50%" class="td_custom font_size_new" align="center"> <div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type" data-target="#simul_expiry" data-toggle="modal"><?php translate('head_expiry'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 expiry_t" data-target="#simul_expiry" attr = "<?php if (isset($T))echo $T; ?>" data-toggle="modal"><?php echo (isset($_SESSION['session_expiry']))?$_SESSION['session_expiry']:$TFORMAT; //date('M-y');?></h6></div></td>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_spot'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 spot_s" attr="<?php if (isset($S)) echo $rs['underlying']['last']; ?>"><?php if (isset($S)) echo $S; ?></h6></div></td>

                    </tr>

                    <tr>
                        <td width="50%" class="td_custom font_size_new"  align="center"> <div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_interest'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 load_modals interest_r" attr="<?php if (isset($R)) echo $R; ?>" edit_for="interest" data-target="#modals" data-toggle="modal" data-type="input"><?php if (isset($R)) echo $R; ?></h6></div></td>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_dividend'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 load_modals dividend_q" attr="<?php if (isset($T)) echo $Q; ?>" edit_for="dividend" data-target="#modals" data-toggle="modal" data-type="input"><?php if (isset($T)) echo $Q; ?></h6></div></td>

                    </tr>
                    <tr>
                        <td colspan="2" class="td_custom font_size_new" align="center"><div class="col-md-12"><a class="btn btn-lg green form-control" style="min-height: 40px; background-color: #00a800 ;" id="caculate_discrete"><strong><?php translate('btn_calculate'); ?></strong></a></div></td>
                    </tr>
                    <tr>
                        <?php
                        // calculation
                        function Ftheo($LS, $LR, $LT, $LQ) {
                            $Theorique = $LS * (1 + ($LR) * ($LT / 360)) - $LQ;
                            return $Theorique;
                        }

                        $RR = $R / 100;
                        $QQ = $Q;
                        $call = Ftheo($S, $RR, $T, $QQ);
                        $put = $call - $S;
                        ?>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_fair_value'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 value_theoretical">
                                    <?php echo '';//$dashboard_future['last'];?></h6></div></td>
                        <td width="50%" class="td_custom font_size_new" align="center"><div class="col-md-12 bg_trading"><h6 class="color_h6 cus_type"><?php translate('head_base'); ?><i class="m-icon-swapright m-icon-white icon_sma"></i></h6><h6 class="cus_h6 value_futures"><?php echo '';?></h6></div></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="td_custom font_size_new" align="center"><div class="col-md-12"><a class="btn btn-lg blue form-control" style="min-height: 40px;" href="<?php base_url() ?>futures_live"><strong><?php translate('btn_order'); ?></strong></a></div></td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
