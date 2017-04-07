<!--h3 class="page-title col-md-6" style="font-weight: bold;">
<?php //translate("Options Strategies - {$data['name']}") ?> 
</h3-->
<!-- END PAGE HEADER-->
<div class="row">
	<div class="col-md-12">
    	<div class="row">
        	<div class="col-md-8">
                <!-- BEGIN Portlet PORTLET-->
                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-reorder"></i><?php translate("Options Strategies - {$data['name']}") ?></div>
                    </div>
    				<?php
                        $this->load->model('mcalculate_model', 'mCalculate');
                        //$mCalculate = new Models_models_mCalculate();
    					if (!isset($S)) {
    						$S = round($data["undlying_prices"]);
                            $K = round($data["strike_1"]);
                            $R = round($data["r(%)"]);
                            $T = round($data["nb_of_date"]);
                            $Sigma = round($data["volatility(%)"]);
                            $Q = round($data["div_yield(%)"]);
    					}
    					if (isset($_POST['ok'])) {
    						$S = $_POST['s'];
                            $K = $_POST['k'];
                            $R = $_POST['r'];
                            $T = $_POST['t'];
                            $Sigma = $_POST['si'];
                            $Q = $_POST['q'];
    					}
						$arr_cal = $this->mCalculate->Calculate_1($S, $K, $R, $T, $Sigma, $Q, round($data["intervalle"]), $data['type_1'], $data['l/s_1'], $data['quantity_1']);
						
    				?>
                    <div class="portlet-body">
                        <form class="form-horizontal margin-bottom-10" method="post" onsubmit="return kiemtra();">
                            <div class="col-md-6 margin-top-20">
                                <div class="clearfix"></div>
                            	<div class="form-group margin-top-20">
                                    <label class="col-md-8 control-label bold" ><?php translate('STRATEGY_UNDERLYING_PRICE') ?></label>
                                    <div class="col-md-4">
                                        <input id="s" name="s" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($S)) echo $S; ?>" />
                                    </div>
                                </div>
                    
                                <div class="form-group <?php echo $data['type_1'] == 's' ? 'hidden' : ""?>">
                                    <label class="col-md-8 control-label bold"  ><?php translate('STRATEGY_EXERCISE_PRICE') ?></label>
                                    <div class="col-md-4" >
                                        <input id="k" name="k" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($K)) echo $K; ?>" />
                                    </div>
                                </div>
     
                                <div class="form-group">
                                    <label class="col-md-8 control-label bold"><?php translate('STRATEGY_INTEREST_RATES') ?></label>
                                    <div class="col-md-4">
                                        <input id="r" name="r" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($R)) echo $R; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label bold" ><?php translate('STRATEGY_MATURITY') ?></label>
                                    <div class="col-md-4">
                                        <input id="t" name="t" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($T)) echo $T; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label bold" ><?php translate('STRATEGY_VOLATILITY') ?></label>
                                    <div class="col-md-4">
                                        <input id="si" name="si" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($Sigma)) echo $Sigma; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label bold" ><?php translate('STRATEGY_RATE_OF_RETURN') ?></label>
                                    <div class="col-md-4">
                                        <input id="q" name="q" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($Q)) echo $Q; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-actions">
                                        <div class="col-md-offset-8 col-md-12">
                                            <button type="submit" class="btn blue"  name="ok" ><i class="icon"></i>Calculate</button>
                                        </div>
                                    </div>
                                </div>
                         </div>
                         <div class="col-md-6">
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
                            $s_option = '[' . implode(',', $arr_cal['Options']) . ']';
                            $s_option_support = array_combine($arr_cal['support'],$arr_cal['Options']);
                            //foreach($s_option_support as $k =>$v){
//                                $arr[] = "['".$k."',".$v."]";
//                            }
//                            $s_rs = implode(',', $arr);
                           // print_r($s_rs);exit;
                        ?> 
                             
                                <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
                                <script type="text/javascript" language="javascript">
                        var chart;
                        var w;
                        var highchartsaxis;
                        var kt;
                        var s_support = <?php echo $s_support; ?>;
                        var s_option = <?php echo $s_option; ?>;
                        
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
                                                this.series[0].setData(s_option);
                                                this.xAxis[0].setCategories(s_support);
                                                var highchart_a = $('g.highcharts-axis').eq(1).children().children().length;
                                                //alert(highchart_a);
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
                                        //tickLength:7,
                                        labels: {
                                            formatter: function() {
                                                return this.value;
                                            }
                                        },
                                        id:'y-axis'
                                    },
                                    plotOptions:{
                                        line:{
                                            //color:'#BF0B23'
                                            lineWidth:4,
                                            dataLabels: {
                                                //enabled: true
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
                                                this.x +': '+ this.y;
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
                                            name: '<?php strtoupper(translate($data['type_1']))?>(<?php if (isset($K)) echo $K; ?>)',
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
                          <?php if(isset($description) && isset($description[0]['description']) ) { ?>
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="portlet">
        							<div class="portlet-title">
        								<div class="caption">
        									Description
        								</div>
        								<div class="tools">
        									<a class="collapse" href="javascript:;" data-original-title="" title="">
        									</a>
        								
        								</div>
        							</div>
        							<div class="portlet-body" style="display: block;">
        								<div class="well">
        									 <?php echo $description[0]['description']; ?>
                                             <table class="table table-striped table-bordered table-hover table-full-width">
                                                <thead>
                                                    <tr class="heading">
                                                        <th width="20%" style="color: #fff"><?php translate('spec') ?>
                                                            </th>
                                                        <th style="color: #fff"><?php translate('description') ?>
                                                            </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($trategy_desc as $key => $value){ ?>
                                                            <tr><td><strong><?php echo translate($key,true)?></strong></td><td><?php echo $value ?></td></tr>
                                                    <?php } ?>
                                                </tbody>
                                             </table>
        								</div>
        							</div>
        						</div>
                            </div>  
                        </div> 
                        <?php } ?>
                        </form>
    					 
    					<script type="text/javascript" language="javascript">
    						function kiemtra(){
                            
                                s  =  document.getElementById('s').value;
                                sv =  document.getElementById('s').value.length;
                                
                                k  =  document.getElementById('k').value;
                                kv = document.getElementById('k').value.length;
                                
                                r = document.getElementById('r').value;
                                rv = document.getElementById('r').value.length;
                                
                                t = document.getElementById('t').value;
                                tv = document.getElementById('t').value.length;
                                
                                si = document.getElementById('si').value;
                                siv = document.getElementById('si').value.length;
                                
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
                                
                                for(var kl = 0;kl<kv;kl++)
                                {
                                    if(digit.indexOf(k.substr(kl,1)) == -1)
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
                                
                                for(var sil = 0;sil<siv;sil++)
                                {
                                    if(digit.indexOf(si.substr(sil,1)) == -1)
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
                                }else if(k == ""){
                                    alert("<?php echo 'All Field Not Blank'; ?>");
                                    return false;
                                }else if(r == ""){
                                    alert("<?php echo 'All Field Not Blank'; ?>");
                                    return false;
                                }else if(t == ""){
                                    alert("<?php echo 'All Field Not Blank'; ?>");
                                    return false;
                                }else if(si == ""){
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                    					<thead>
                    						<tr class="heading">
                    							<th width="30%" style="color: #fff;"><strong><?php translate('PRICE_AT_MATURITY') ?></strong></th>
                                                <th width="20%" style="text-align: right !important; color: #fff ;"><strong><?php translate('VAR') ?></strong></th>
                                                <th width="20%" style="text-align: right !important; color: #fff;"><strong><?php strtoupper(translate($data['type_1']))?>(<?php if (isset($K)) echo $K; ?>)</strong></th>
                                                <th width="30%" style="text-align: right !important; color: #fff;"><strong><?php translate('PERFORMANCE') ?></strong></th>
                    						</tr>
                    					</thead>
                    					<tbody>
                                            <?php
                                            for ($c = 0; $c < 9; $c++) {
                                            ?>
                    						<tr>
                    							<td class="highlight"><strong><?php printf("%10.2f", $arr_cal['support'][$c]); ?></strong></td>
                    							<td class="highlight" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['vars'][$c]); ?></td>
                                                <td class="highlight" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $data['quantity_1'] * $arr_cal['Options'][$c]); ?></td>
                                                <td class="highlight" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['Perf'][$c]); ?></td>
                                			</tr>
                    						<?php } ?>
                    					</tbody>
                    				</table>
                                </div>
                            </div>
                        </div> 
                        <input id="s_support" value="<?php echo $s_support; ?>" class="hidden" />
                        <input id="s_rs" value="" class="hidden" />
                        <input id="s_option" value="<?php echo $s_option ?>" class="hidden" />
    
                    </div>
                </div>
                <!-- END Portlet PORTLET-->
            </div>
        </div>
        
    	<div class="clearfix"></div>	
    </div>
</div>