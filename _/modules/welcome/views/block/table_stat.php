
<div class="portlet box red">
    <div class="portlet-body background_portlet">
        <div class="portlet-body background_portlet" style="margin-top:10px;">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>
                    
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6> </th>
                        <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_change'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:left"> <h6 class="color_h6 cus_type"><?php translate('head_tb_var'); ?></h6></th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_time'); ?></h6> </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td_custom font_size_13 index_last" align="left"><?php echo $underlying_setting['last'];?></td>
                            <td class="td_custom font_size_13 index_change" align="right"><?php echo $underlying_setting['change'];?></td>
                            <td class="td_custom font_size_13 index_var" align="left"><?php echo $underlying_setting['var'];?></td>
                            <td class="td_custom font_size_13 index_time" align="right"><?php echo $underlying_setting['time'];?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>