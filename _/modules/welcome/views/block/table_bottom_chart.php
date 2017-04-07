<style>
    .cus_type{
        font-weight: bold;
        color: #6fb9fc !important;
    }
</style>
<div class="portlet box red">
    <div class="portlet-body background_portlet">
        <div class="portlet-body background_portlet" style="margin-top:10px;">
            <div class="table-responsive">
                <table class="table  table-bordered table-hover table_color table_cus">
                    <thead>
                    <tr>
                    
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_open'); ?></h6> </th>
                        <th class="th_custom" style="text-align:right"><h6 class="color_h6 cus_type"><?php translate('head_tb_high'); ?></h6>  </th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_low'); ?></h6></th>
                        <th class="th_custom" style="text-align:right"> <h6 class="color_h6 cus_type"><?php translate('head_tb_last'); ?></h6> </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td_custom font_size_new" align="right"><?php echo (isset($bottomchart['open'])) ? number_format($bottomchart['open'],2,'.',','):'-';?></td>
                            <td class="td_custom font_size_new" align="right" ><?php echo (isset($bottomchart['high']))? number_format($bottomchart['high'],2,'.',','):'-';?></td>
                            <td class="td_custom font_size_new" align="right"><?php echo (isset($bottomchart['low'])) ? number_format($bottomchart['low'],2,'.',','):'-';?></td>
                            <td class="td_custom font_size_new" align="right"><?php echo (isset($bottomchart['last'])) ? number_format($bottomchart['last'],2,'.',','):'-';?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>