
<div class="portlet box red blocks">
    <div class="portlet-title header-table">
        <div class="caption">
            <i class="fa"></i><?php translate('head_box_finance'); ?></div>
        <div class="tools">
            <!-- <a href="" class="fullscreen"> </a>-->
            <i class="fa fa-arrows-alt fullscreens"></i>
            <i class="fa fa-compress minscreens"></i>
        </div>
    </div>
    <div class="portlet-body background_portlet" <?php if($height != 0){?>style="height:<?php echo $height;?>px"<?php }?>>
        <div class="table-responsive">
            <table class="table  table-bordered table-hover table_color table_cus">
                <thead>
                <tr>
                    <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('head_tb_date'); ?></h6>  </th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_type'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_stype'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_initial'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_flows'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_final'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_q'); ?></h6> </th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_trprice'); ?></h6> </th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_setmnt'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_psetmnt'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_change'); ?></h6></th>
                    <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                </tr>
                </thead>
                <tbody>
                <?php
                //echo "<pre>";print_r($finances);exit;
                foreach($list_finances as $finances){?>
                    <tr>
                        <td class="td_custom cus_pri"> <?php echo $finances['date'];?> </td>
                        <td class="td_custom cus_pri"> <?php echo $finances['type'];?> </td>
                        <td class="td_custom cus_pri"> <?php echo $finances['stype'];?> </td>
                        <td class="td_custom" align="right"> <?php echo ($finances['initial'])? number_format($finances['initial'],2,'.',','):'';?> </td>
                        <td class="td_custom" align="right"><?php echo ($finances['debcre'] != NULL) ? number_format($finances['debcre'],2,'.',','):'';?> </td>
                        <td class="td_custom" align="right"> <?php echo number_format($finances['final'],2,'.',',');?> </td>
                        <td class="td_custom" align="right"> <?php echo ($finances['q'] != NULL) ? $finances['q']:'';?> </td>
                        <td class="td_custom" align="right"> <?php echo ($finances['trade_price'] != NULL) ? number_format($finances['trade_price'],2,'.',','):'';?> </td>
                        <td class="td_custom" align="right"><?php echo ($finances['settlement'] != NULL) ? number_format($finances['settlement'],2,'.',','):'';?></td>
                        <td class="td_custom" align="right"><?php echo ($finances['psettlement'] != NULL) ? number_format($finances['psettlement'],2,'.',','):'';?></td>
                        <td class="td_custom" align="right" <?php if($finances['change'] < 0) echo 'style =" color:#ee2222;"';
                        if($finances['change'] > 0) echo 'style =" color:#00a800;"';?>><?php echo ($finances['change'] != NULL) ? number_format($finances['change'],2,'.',','):'';?></td>
                        <td class="td_custom" align="right" <?php if($finances['var'] < 0) echo 'style =" color:#ee2222;"';
                        if($finances['var'] > 0) echo 'style =" color:#00a800;"';?>><?php echo ($finances['var'] != NULL) ? number_format($finances['var'],2,'.',','):'';?></td>
                    </tr>
                <?php }?>

                </tbody>
            </table>
        </div>
    </div>
</div>
