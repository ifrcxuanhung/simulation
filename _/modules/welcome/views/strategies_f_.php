
<?php //translate("Options Strategies - {$data['name']}") ?>
<div class="row">
    <div class="col-md-4 blocks use_fullscreen">
        <?php echo $education_news; ?>
    </div>
	<div class="col-md-8 blocks use_fullscreen">
        <div class="col-md-6 blocks use_fullscreen">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet box red blocks">
            <div class="portlet-title">
                <div class="caption text-uppercase"><i class="icon-reorder"></i><?php translate("Futures Strategies") ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
			<?php
                $this->load->model('mcalculate_model', 'mCalculate');
				if (!isset($S)) {
					$S = round($data["undlying_prices"],2);
                    $M = 5;
                    $R = round($data["r(%)"],2);
                    $T = round($data["nb_of_date"]);
                   // $Sigma = round($data["volatility(%)"]);
                    $Q = round($data["div_yield(%)"],2);
				}
				if (isset($_POST['ok'])) {
					$S = $_POST['s'];
                    $M = $_POST['m'];
                    $R = $_POST['r'];
                    $T = $_POST['t'];
                 //   $Sigma = $_POST['si'];
                    $Q = $_POST['q'];
				}
				$arr_cal = $this->mCalculate->Calculate_F($S, $R, $T, $Q,$M,$data['l/s_1']);
			?>
        	
            <div class="portlet-body background_portlet form">
                <form class="form-horizontal margin-bottom-10" method="post" onsubmit="return kiemtra();">
                    <div class="form-body">
                        <div class="clearfix"></div>
                        <div class="form-group margin-top-20">
                            <div class="col-md-offset-1 col-md-10">
                                <a class="btn green form-control load_modals bold" edit_for="type" data-target="#modals" data-toggle="modal" data-type="choose"  data-value="<?php echo $data['tab'];?>"> <?php echo $data['name'] ?> <i class="fa fa-angle-down"></i></a>
                            </div>
                        </div>
                    	<div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('STRATEGY_UNDERLYING_PRICE') ?></label>
                            <div class="col-md-4">
                                <input id="s" name="s" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($S)) echo $S; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-7 control-label bold"><?php translate('STRATEGY_INTEREST_RATES') ?></label>
                            <div class="col-md-4">
                                <input id="r" name="r" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($R)) echo $R; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('STRATEGY_MATURITY') ?></label>
                            <div class="col-md-4">
                                <input id="t" name="t" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($T)) echo $T; ?>"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('STRATEGY_RATE_OF_RETURN') ?></label>
                            <div class="col-md-4">
                                <input id="q" name="q" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($Q)) echo $Q; ?>"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('MARGIN_RATIO') ?></label>
                            <div class="col-md-4">
                                <input id="m" name="m" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($M)) echo $M; ?>"/>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <div class="col-md-12 align-right">
                                <button type="submit" class="btn blue margin-right-20 btn-calculation"  name="ok"><i class="icon"></i>Calculate</button>
                            </div>
                        </div>
                        <?php
                           function Ftheo($LS, $LR, $LT, $LQ) {
                                $Theorique = $LS * (1 + ($LR - $LQ) * ($LT / 360));
                                return $Theorique;
                            }
                            $MM = $M / 100;
                            $RR = $R / 100;
                            $QQ = $Q / 100;
                            $fv = Ftheo($S, $RR, $T, $QQ);
                            $bv = $fv - $S;
                            $mv = $S * $MM;
                        ?>
                        <div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('FUTURE_VALUE') ?></label>
                            <div class="col-md-4">
                                <input id="fv" name="fv" type="text"  placeholder="medium" class="form-control" disabled value="<?php echo round($fv,2); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('BASE_VALUE') ?></label>
                            <div class="col-md-4">
                                <input id="bv" name="bv" type="text"  placeholder="medium" class="form-control" disabled value="<?php echo round($bv,2); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('MARGIN_VALUE') ?></label>
                            <div class="col-md-4">
                                <input id="mv" name="mv" type="text"  placeholder="medium" class="form-control" disabled value="<?php echo round($mv,2) ?>"/>
                            </div>
                        </div>
                    </div>
                 </form>
                 <script type="text/javascript" language="javascript">
					function kiemtra(){
                    
                        s  =  document.getElementById('s').value;
                        sv =  document.getElementById('s').value.length;
                        
                        r = document.getElementById('r').value;
                        rv = document.getElementById('r').value.length;
                        
                        t = document.getElementById('t').value;
                        tv = document.getElementById('t').value.length;
                        
                        
                        q = document.getElementById('q').value;
                        qv = document.getElementById('q').value.length;
                        digit = '0123456789.';
                        flag = 0;
                        
                        for(var sl = 0;sl<sv;sl++)
                        {
                            if(digit.indexOf(s.substr(sl,1)) == -1)
                            {
                              
                                flag = 1;
                                break;
                            }
                        }
                        
                        
                        for(var rl = 0;rl<rv;rl++)
                        {
                            if(digit.indexOf(r.substr(rl,1)) == -1)
                            {
                               
                                flag = 1;
                                break;
                            }
                        }
                        
                        for(var tl = 0;tl<tv;tl++)
                        {
                            if(digit.indexOf(t.substr(tl,1)) == -1)
                            {
                               
                                flag = 1;
                                break;
                            }
                        }
                        
                        
                        for(var ql = 0;ql<qv;ql++)
                        {
                            if(digit.indexOf(q.substr(ql,1)) == -1)
                            {
                               
                                flag = 1;
                                break;
                            }
                        }
                        if(s == ""){
                            alert("<?php echo 'All Field Not Blank'; ?>");
                            return false; 
                        }else if(r == ""){
                            alert("<?php echo 'All Field Not Blank'; ?>");
                            return false;
                        }else if(t == ""){
                            alert("<?php echo 'All Field Not Blank'; ?>");
                            return false;
                        }else if(q == ""){
                            alert("<?php echo 'All Field Not Blank'; ?>");
                            return false;
                        }
                        else if(flag == 1){
                            alert("<?php echo 'All Field the numbers'; ?>");
                            return false;
                        }else{
                            return true;
                        }
                    }
				</script> 
            </div>
        </div>
    </div>
    <div class="col-md-6 blocks use_fullscreen">
        <div class="portlet box red blocks">
            <div class="portlet-title">
                <div class="caption text-uppercase"><i class="icon-reorder"></i><?php translate("Chart") ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
            <div class="portlet-body background_portlet" style="min-height: 460px;">  
                <?php
                    $pattern =  "/^-?[0-9]+\,[0-9]+$/";
                    foreach($arr_cal as $key => $item){
                        foreach($item as $key2 => $item2){
                            if(preg_match($pattern, $item2)){
                                $item2 = str_replace(",", ".", $item2);
                                $arr_cal[$key][$key2] = $item2;
                            }
                        }
                    }
                   
                    $s_support = '[' . implode(',', $arr_cal['support']). ']';
                    $s_net = '[' . implode(',', $arr_cal['net']) . ']';
                    $s_net_support = array_combine($arr_cal['support'],$arr_cal['net']);
                ?>     
                <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
                <script type="text/javascript" language="javascript">
                    var chart;
                    var w;
                    var highchartsaxis;
                    var kt;
                    var s_support = <?php echo $s_support; ?>;
                    var s_net = <?php echo $s_net; ?>;
                    
                    $(document).ready(function() {
                       if ($('#container').size() != 0) {
                        $('#site_activities_loading').hide();
                        $('#site_activities_content').show(); 
                            chart = new Highcharts.Chart({
                                chart: {
                                    renderTo: 'container',
                                    defaultSeriesType: 'line',
                                    events: {
                                        load: function(event){
                                            this.series[0].setData(s_net);
                                            this.xAxis[0].setCategories(s_support);
                                            var highchart_a = $('g.highcharts-axis').eq(1).children().children().length;
                                        //    alert(highchart_a);
                                            for(var a=0;a<highchart_a;a++){
                                                highchartsaxis = parseInt($('g.highcharts-axis').eq(1).children().children().eq(a).text());
                                                if(highchartsaxis != 0){
                                            
                                                }else{
                                                    kt = a;
                                                } 
                                            }
                                            $('g.highcharts-grid').eq(1).children().eq(kt).attr('stroke', '#000000').attr('stroke-width','1.6');
                                        }
                                    }
                                },
                                title: {
                                    text: '<?php translate('Profit at maturity'); ?>'
                                },
                                xAxis: {
                                    categories: [],
                                    gridLineWidth:1,
                                    lineWidth: 0,
                                    tickWidth: 0,
                                    plotLines: [{
                                            color: '#000000',
                                            width: 1.8,
                                            value: 4,
                                            id: 'plotline-1'
                                        }]
                                },
                                yAxis: {
                                    title: {
                                        text: '<?php translate('Profit'); ?>'
                                    },
                                    lineWidth: 1,
                                    tickWidth: 1,
                                  //  tickLength:7,
                                    labels: {
                                        formatter: function() {
                                            return this.value;
                                        }
                                    },
                                    id:'y-axis'
                                },
                                plotOptions:{
                                    line:{
                                   //     color:'#BF0B23',
                                        lineWidth:4,
                                        dataLabels: {
                                     //       enabled: true
                                        },
                                        marker:{
                                            fillColor:'#BF0B23',
                                            lineColor:'#BF0B23',
                                            lineWidth:4,
                                    
                                        }
                                    }  
                                },
                                tooltip: {
                                    enabled: true,
                                    formatter: function() {
                                        return '<b>'+ this.series.name +'</b><br/>'+
                                            this.x +': '+ this.y.toFixed(2);
                                    }
                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'top',
                                    x: -10,
                                    y: 100,
                                    borderWidth: 0,
                                    enabled:false
                                },
                                credits: {
                                    enabled:false //cái link duoi hinh
                                },
                                series: [{
                                        name: '<?php echo strtoupper('net')?>',
                                        data: []
                                    }]
                            });
                        }
                    });
                </script>
                
                
                <div id="site_activities_loading">
					<img src="<?php echo template_url(); ?>layouts/layout/img/ajax-loading.gif" alt="loading"/>
				</div>
				<div id="site_activities_content" class="display-none">
					<div id="container"></div>
				</div>
                                
                                
           
            </div>     
        </div>
    </div>
</div>
<div class="col-md-8 blocks use_fullscreen">
<!--div class="clearfix"></div>
<div class="row"-->
 <?php if(isset($description) && isset($description[0]['description']) ) { ?>
	<div class="col-md-6 blocks use_fullscreen">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet box red blocks">
            <div class="portlet-title">
                <div class="caption text-uppercase"><i class="icon-reorder"></i><?php translate("Description") ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
            <div class="portlet-body background_portlet">
				<div class="well">
					 <?php echo $description[0]['description']; ?>
                     <table class="table table_color table_cus table-bordered table-hover table-full-width">
                        <thead>
                            <tr>
                                <th width="20%" class="th_custom"><h6 class="color_h6 cus_type"><?php translate('spec') ?></h6>
                                    </th>
                                <th class="th_custom"><h6 class="color_h6 cus_type"><?php translate('description') ?></h6>
                                    </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($trategy_desc as $key => $value){ ?>
                                    <tr><td class="td_custom cus_pri"><strong><?php echo translate($key,true)?></strong></td><td class="td_custom"><?php echo $value ?></td></tr>
                            <?php } ?>
                        </tbody>
                     </table>
				</div>
            </div>
        </div>
    </div>
<?php } ?>
    <div class="<?php echo isset($description)&&isset($description[0]['description']) ? 'col-md-6' : 'col-md-12' ?> blocks use_fullscreen">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet box red blocks">
            <div class="portlet-title">
                <div class="caption text-uppercase"><i class="icon-reorder"></i><?php translate("Result") ?></div>
                <div class="tools">
                        <i class="fa fa-arrows-alt fullscreens"></i>
                        <i class="fa fa-compress minscreens"></i>
                    </div>
            </div>
            <div class="portlet-body background_portlet ">     
                <div class="table-scrollable">
                    <table class="table table_color table_cus table-bordered table-hover">
    					<thead>
    						<tr>
                                <tr>
        							<th width="30%" class="th_custom"><h6 class="color_h6 cus_type"><?php translate('PRICE_AT_MATURITY') ?></h6></th>
                                    <th width="20%" class="th_custom align-right"><h6 class="color_h6 cus_type"><?php translate('VAR') ?></h6></th>
                                    <th width="20%" class="th_custom align-right"><h6 class="color_h6 cus_type"><?php translate('NET')?></h6></th>
                                    <th width="30%" class="th_custom align-right"><h6 class="color_h6 cus_type"><?php translate('PERFORMANCE') ?></h6></th>
        						</tr>
    						</tr>
    					</thead>
    					<tbody>
                            <?php
							for ($c = 0; $c < 9; $c++) {
							?>
							<tr>
                                <td class="td_custom cus_pri"><strong><?php printf("%10.2f", $arr_cal['support'][$c]); ?></strong></td>
    							<td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['vars'][$c]); ?></td>
                                <td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['net'][$c]); ?></td>
                                <td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['Perf'][$c]); ?></td>
							</tr>
							<?php  } ?>
    					</tbody>
    				</table>
                    <!--input id="s_support" value="<?php echo $s_support; ?>" class="hidden" />
                    <input id="s_rs" value="" class="hidden" />
                    <input id="s_option" value="<?php echo $s_option ?>" class="hidden" /-->
                </div>
            </div>
        </div>
    </div>  
</div>
</div>