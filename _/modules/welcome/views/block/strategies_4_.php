
<?php //translate("Options Strategies - {$data['name']}") ?>
<div class="row">
	<div class="col-md-4">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i><?php translate("Options Strategies") ?></div>
            </div>
			<?php
                $this->load->model('mcalculate_model', 'mCalculate');
                //$mCalculate = new Models_models_mCalculate();
				if (!isset($S)) {
					$S = round($data["undlying_prices"]);
					$K_1 = round($data["strike_1"]);
					$K_2 = round($data["strike_2"]);
					$K_3 = round($data["strike_3"]);
					$K_4 = round($data["strike_4"]);
                    $R = round($data["r(%)"]);
                    $T = round($data["nb_of_date"]);
                    $Sigma = round($data["volatility(%)"]);
                    $Q = round($data["div_yield(%)"]);
					//$I = round($data["intervalle"]);
				}
				if (isset($_POST['ok'])) {
					$S = $_POST['s'];
                    $K_1 = $_POST['k1'];
                	$K_2 = $_POST['k2'];
					$K_3 = $_POST['k3'];
					$K_4 = $_POST['k4'];
                    $R = $_POST['r'];
                    $T = $_POST['t'];
                    $Sigma = $_POST['si'];
                    $Q = $_POST['q'];
					//$I = $_POST['i'];
				}
				$arr_cal = $this->mCalculate->Calculate_4($S, $K_1, $K_2, $K_3, $K_4, $R, $T, $Sigma, $Q, $data["intervalle"], $data['type_1'],$data['type_2'],$data['type_3'], $data['type_4'], $data['l/s_1'], $data['l/s_2'], $data['l/s_3'], $data['l/s_4'], $data['quantity_1'], $data['quantity_2'],  $data['quantity_3'], $data['quantity_4']);
				
			?>
            <div class="portlet-body background_portlet form">
                
                <form class="form-horizontal margin-bottom-10" method="post" onsubmit="return kiemtra();">
                    <div class="form-body">
                        <div class="clearfix"></div>
                        <div class="form-group margin-top-20">
                            <div class="col-md-offset-2 col-md-8">
                                <a class="btn grey form-control load_modals" edit_for="type" data-target="#modals" data-toggle="modal" data-type="choose"  data-value="<?php echo $data['name'];?>"> <?php echo $data['name'] ?> <i class="fa fa-angle-down"></i></a>
                            </div>
                        </div>
                    	<div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('STRATEGY_UNDERLYING_PRICE') ?></label>
                            <div class="col-md-4">
                                <input id="s" name="s" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($S)) echo $S; ?>" />
                            </div>
                        </div>
                       
                        <div class="form-group <?php echo $data['type_1'] == 's' ? 'hidden' : ""?>">
                            <label class="col-md-7 control-label bold"  ><?php translate('EXERCISE PRICE, K 1 =') ?></label>
                            <div class="col-md-4" >
                                <input id="k1" name="k1" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($K_1)) echo $K_1; ?>" />
                            </div>
                        </div>
                      
                  
                        <div class="form-group <?php echo $data['type_2'] == 's' ? 'hidden' : ""?>">
                            <label class="col-md-7 control-label bold"  ><?php translate('EXERCISE PRICE, K 2 =') ?></label>
                            <div class="col-md-4" >
                                <input id="k2" name="k2" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($K_2)) echo $K_2; ?>" />
                            </div>
                        </div>
                       
                        <div class="form-group <?php echo $data['type_3'] == 's' ? 'hidden' : ""?>">
                            <label class="col-md-7 control-label bold"  ><?php translate('EXERCISE PRICE, K 3 =') ?></label>
                            <div class="col-md-4" >
                                <input id="k3" name="k3" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($K_3)) echo $K_3; ?>" />
                            </div>
                        </div>
                       
                         <div class="form-group <?php echo $data['type_4'] == 's' ? 'hidden' : ""?>">
                            <label class="col-md-7 control-label bold"  ><?php translate('EXERCISE PRICE, K 4 =') ?></label>
                            <div class="col-md-4" >
                                <input id="k4" name="k4" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($K_4)) echo $K_4; ?>" />
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
                            <label class="col-md-7 control-label bold" ><?php translate('STRATEGY_VOLATILITY') ?></label>
                            <div class="col-md-4">
                                <input id="si" name="si" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($Sigma)) echo $Sigma; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-7 control-label bold" ><?php translate('STRATEGY_RATE_OF_RETURN') ?></label>
                            <div class="col-md-4">
                                <input id="q" name="q" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($Q)) echo $Q; ?>"/>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-8 control-label bold" ><?php translate('INTERVALLE, I =') ?></label>
                            <div class="col-md-4">
                                <input id="i" name="i" type="text"  placeholder="medium" class="form-control" value="<?php if (isset($I)) echo $I; ?>"/>
                            </div>
                        </div>-->
                        <div class="form-actions">
                            <div class="col-md-offset-8 col-md-12">
                                <button type="submit" class="btn blue"  name="ok" ><i class="icon"></i>Calculate</button>
                            </div>
                        </div>
                     </div>
                </form>
				 
				<script type="text/javascript" language="javascript">
					function kiemtra(){
					
						s  =  document.getElementById('s').value;
						sv =  document.getElementById('s').value.length;
						
						k1  =  document.getElementById('k1').value;
						k1v = document.getElementById('k1').value.length;
						
						k2  =  document.getElementById('k2').value;
						k2v = document.getElementById('k2').value.length;
						
						k3  =  document.getElementById('k3').value;
						k3v = document.getElementById('k3').value.length;
						
						k4  =  document.getElementById('k4').value;
						k4v = document.getElementById('k4').value.length;
						
						r = document.getElementById('r').value;
						rv = document.getElementById('r').value.length;
						
						t = document.getElementById('t').value;
						tv = document.getElementById('t').value.length;
						
						si = document.getElementById('si').value;
						siv = document.getElementById('si').value.length;
						
						q = document.getElementById('q').value;
						qv = document.getElementById('q').value.length;
						i = document.getElementById('i').value;
						iv = document.getElementById('i').value.length;
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
						
						for(var k1l = 0;k1l<k1v;k1l++)
						{
							if(digit.indexOf(k1.substr(k1l,1)) == -1)
							{
								
								flag = 1;
								break;
							}
						}
						
						for(var k2l = 0;k2l<k2v;k2l++)
						{
							if(digit.indexOf(k2.substr(k2l,1)) == -1)
							{
								
								flag = 1;
								break;
							}
						}
						
						for(var k3l = 0;k3l<k3v;k3l++)
						{
							if(digit.indexOf(k3.substr(k3l,1)) == -1)
							{
								
								flag = 1;
								break;
							}
						}
						
						for(var k4l = 0;k4l<k4v;k4l++)
						{
							if(digit.indexOf(k4.substr(k4l,1)) == -1)
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
						
						for(var il = 0;il<iv;il++)
						{
							if(digit.indexOf(i.substr(il,1)) == -1)
							{
								
								flag = 1;
								break;
							}
						}
						
						if(s == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false; 
						}else if(k1 == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false;
						}else if(k2 == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false;
						}else if(r == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false;
						}else if(t == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false;
						}else if(si == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false;
						}else if(q == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false;
						}else if(i == ""){
							alert("<?php translate('All Field Not Blank'); ?>");
							return false;
						}
						else if(flag == 1){
							alert("<?php translate('All Field the numbers'); ?>");
							return false;
						}else{
							return true;
						}
					}
				</script>
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>
    <div class="col-md-8">
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i><?php translate("Chart") ?></div>
            </div>
            <div class="portlet-body background_portlet">
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
					$s_support = '[' . implode(',', $arr_cal['support']) . ']';
					$s_Pattes_1 = '[' . implode(',', $arr_cal['Pattes_1']) . ']';
					$s_Pattes_2 = '[' . implode(',', $arr_cal['Pattes_2']) . ']';
					$s_Pattes_3 = '[' . implode(',', $arr_cal['Pattes_3']) . ']';
					$s_Pattes_4 = '[' . implode(',', $arr_cal['Pattes_4']) . ']';
					$s_combinee = '[' . implode(',', $arr_cal['combinee']) . ']';
                ?>  
                     
                <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
				<script type="text/javascript" language="javascript">
					var chart;
					var w;
					var highchartsaxis;
					var kt;
					var highchart_a;
			  
					var s_support = <?php echo $s_support; ?>;
					var s_Pattes_1 = <?php echo $s_Pattes_1; ?>;
					var s_Pattes_2 = <?php echo $s_Pattes_2; ?>;
					var s_Pattes_3 = <?php echo $s_Pattes_3; ?>;
					var s_Pattes_4 = <?php echo $s_Pattes_4; ?>;
					var s_combinee = <?php echo $s_combinee; ?>; 
                
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
                                       // this.series[0].setData(s_option);
                                        //this.xAxis[0].setCategories(s_support);
                                        var highchart_a = $('g.highcharts-axis').eq(1).children().children().length;
										this.series[0].setData(s_Pattes_1);
										this.series[1].setData(s_Pattes_2);
										this.series[2].setData(s_Pattes_3);
										this.series[3].setData(s_Pattes_4);
										this.series[4].setData(s_combinee);
										this.xAxis[0].setCategories(s_support);
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
									lineWidth:3,
									dataLabels: {
										//enabled: true
									},
									marker:{
										//fillColor:'#BF0B23'
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
								layout: 'horizontal',
    							align: 'center',
    							verticalAlign: 'bottom',
								//symbolWidth:50,
								//x: -10,
								//y: 100,
								borderWidth: 1,
								enabled:true
							},
                            credits: {
                                enabled:false //cái link duoi hinh
                            },
                            series: [{
                                name: '<?php strtoupper(translate($data['type_1']))?>(<?php if (isset($K_1)) echo $K_1; ?>)',
                                    marker:{
                                        //fillColor:'#BF0B23',
                                        symbol:'square',
                                        enabled:true
                                    },
                                    color:'#AA4643',
                                    data: []
                                },{
                                    name:'<?php strtoupper(translate($data['type_2']))?>(<?php if (isset($K_2)) echo $K_2; ?>)',
                                    marker:{
                                        symbol:'triangle-down',
                                        enabled:true
                                    },
                                    color:'#89A54E',
                                    data: []
                                },{
                                    name:'<?php strtoupper(translate($data['type_3']))?>(<?php if (isset($K_3)) echo $K_3; ?>)',
                                    marker:{
                                        symbol:'triangle-down',
                                        enabled:true
                                    },
                                    color:'#EB8203',
                                    data: []
                                },{
                                    name:'<?php strtoupper(translate($data['type_4']))?>(<?php if (isset($K_4)) echo $K_4; ?>)',
                                    marker:{
                                        symbol:'triangle-down',
                                        enabled:true
                                    },
                                    color:'#8e44ad ',
                                    data: []
                                },{
                                name:'<?php translate('Combine'); ?>',
                                marker:{
                                    symbol:'circle',
                                    fillColor:'#BF0B23',
                                    lineColor:'#BF0B23',
                                    lineWidth:4,
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                color:'#4572A7',
                                lineWidth:4,
                                data: []
                            }]
                        });
                    }
                });
            </script>       
                <div id="site_activities_loading">
					<img src="<?php echo template_url(); ?>admin/layout/img/loading.gif" alt="loading"/>
				</div>
				<div id="site_activities_content" class="display-none">
					<div id="container" style="min-width: 310px; height: 484px; margin: 0 auto"></div>
				</div>      
            </div>     
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
 <?php if(isset($description) && isset($description[0]['description']) ) { ?>
	<div class="col-md-6">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i><?php translate("Description") ?></div>
                <div class="tools">
					<a class="collapse" href="javascript:;" data-original-title="" title="">
					</a>
					
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
                                    <tr><td><strong><?php echo translate($key,true)?></strong></td><td><?php echo $value ?></td></tr>
                            <?php } ?>
                        </tbody>
                     </table>
				</div>
            </div>
        </div>
    </div>
<?php } ?>
    <div class="<?php echo isset($description)&&isset($description[0]['description']) ? 'col-md-6' : 'col-md-12' ?>">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption"><i class="icon-reorder"></i><?php translate("Result") ?></div>
            </div>
            <div class="portlet-body background_portlet ">     
                <div class="table-scrollable">
                    <table class="table table_color table_cus table-bordered table-hover">
    					<thead>
    						<tr>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php translate('STRIKE_PRICE') ?></h6></th>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php translate('VAR') ?></h6></th>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php strtoupper(translate($data['type_1']))?>(<?php if (isset($K_1)) echo $K_1; ?>)</h6></th>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php strtoupper(translate($data['type_2']))?>(<?php if (isset($K_2)) echo $K_2; ?>)</h6></th>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php strtoupper(translate($data['type_3']))?>(<?php if (isset($K_3)) echo $K_3; ?>)</h6></th>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php strtoupper(translate($data['type_4']))?>(<?php if (isset($K_4)) echo $K_4; ?>)</h6></th>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php translate('COMBINE') ?></h6></th>
                                <th width="<?php echo 100/8 ?>%" class="th_custom"><h6 class="color_h6 cus_type"><?php translate('PERFORMANCE') ?></h6></th>
    						</tr>
    					</thead>
    					<tbody>
                            <?php
							for ($c = 0; $c < 9; $c++) {
							?>
							<tr>
                                <td class="td_custom"><strong><?php printf("%10.2f", $arr_cal['support'][$c]); ?></strong></td>
								<td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['vars'][$c]); ?></td>
								<td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f",  $arr_cal['Pattes_1'][$c]); ?></td>
								<td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f",  $arr_cal['Pattes_2'][$c]); ?></td>
                                <td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f",  $arr_cal['Pattes_3'][$c]); ?></td>
                                <td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f",  $arr_cal['Pattes_4'][$c]); ?></td>
								<td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['combinee'][$c]); ?></td>
								<td class="td_custom" style="text-align: right !important;border-left-width: 1px;"><?php printf("%10.2f", $arr_cal['Perf'][$c]); ?></td>
							</tr>
							<?php } ?>
    					</tbody>
    				</table>
                </div>
            </div>
        </div>
    </div>  
</div>	