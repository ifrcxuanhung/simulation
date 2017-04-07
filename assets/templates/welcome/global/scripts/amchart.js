if($("#code_chart").length > 0){
if(typeof $("#code_chart").val() != 'undefined'){
 	var code_chart = $("#code_chart").val();
 }else{
	var code_chart = '';	 
}
 var last_new;
 var time_new;
 function getvalueCHART(){
					//console.log(code_chart);
                    return $.ajax({
                        url: $base_url + "ajax/getSpectIntraday",
                        type: "POST",
                        data: {codeint:code_chart},
                        async: false
                    });
                }
				
                var data1 = jQuery.parseJSON(getvalueCHART().responseText);
               // console.log(data1);
                var res = [];
                for (var i = 1; i < data1.length; ++i){
					
					var date = data1[i].time.substring(0, 5);
    				res.push({'time':date,'value': parseFloat(data1[i].idx_last).toFixed(2)})
					if (i==(data1.length-1)) { last_new  = data1[i].idx_last;  time_new = data1[i].time}
                } 
				//last = data1[data1.length].idx_last;
				//console.log(last);
				/*setInterval(function () {
                            var x = (new Date()).getTime(), // current time
                                y = Math.random();
                            series.addPoint([x, y], true, true);
                        }, 1000);*/
						
               // console.log(res);
			   setInterval(function () {
					$.ajax({
						url: $base_url + "ajax/getSpectIntraday_last",
						data: {codeint:code_chart},
						type: 'POST',
						async: false,
						success: function(data) {
							data = jQuery.parseJSON(data);
							if(data.time!=time_new) {
								last_new = data.idx_last;
								time_new = data.time;
								chart.dataProvider.shift();
						
								// add new one at the end
								
								chart.dataProvider.push({'time': time_new.substring(0, 5),'value': parseFloat(last_new).toFixed(2)});
								chart.validateData();
								zoomChart();
							}
						}
					});
					
				}, 10000);
                /*setInterval(function () {
					
					// normally you would load new datapoints here,
					// but we will just generate some random values
					// and remove the value from the beginning so that
					// we get nice sliding graph feeling
					
					// remove datapoint from the beginning
					
					chart.dataProvider.shift();
					
					// add new one at the end
					
					var date = "14:00";
    				
					chart.dataProvider.push({'time':date,'value': parseFloat("2,456").toFixed(2)});
					chart.validateData();
				}, 1300);
				*/
                    
                function showChartTooltip(x, y, xValue, yValue) {
                    $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                        position: 'absolute',
                        display: 'none',
                        top: y - 40,
                        left: x - 40,
                        border: '0px solid #ccc',
                        padding: '2px 6px',
                        'background-color': '#fff'
                    }).appendTo("body").fadeIn(200);
                }
                if ($('#chartdiv').size() != 0) {

                    $('#site_statistics_loading').hide();
                    $('#site_statistics_content').show();
                    
                    var chart = AmCharts.makeChart("chartdiv", {
                            "type": "serial",
                            "theme": "light",
                            "marginRight": 0,
                            "marginLeft": 60,
                            "autoMarginOffset": 20,
                            "dataDateFormat": "L",
                            "pathToImages": $template_url + "global/plugins/amcharts/amcharts/images/",
                            "valueAxes": [{
                                "id": "v1",
                                "axisAlpha": 0,
                                "position": "left",
                                "ignoreAxisWidth":true
                            }],
                            "balloon": {
                                "borderThickness": 1,
                                "shadowAlpha": 0
                            },
                            "numberFormatter": {
                                "precision": -1,
                                "decimalSeparator": ".",
                                "thousandsSeparator": ","
                            },
                            "graphs": [{
                                "id": "g1",
                                "balloon":{
                                  "drop":true,
                                  "adjustBorderColor":false,
                                  "color":"#ffffff"
                                },
                                "bullet": "round",
                                "bulletBorderAlpha": 1,
                                "bulletColor": "#FFFFFF",
                                "bulletSize": 5,
                                "hideBulletsCount": 50,
                                "lineThickness": 2,
                                "title": "red line",
                                "useLineColorForBulletBorder": true,
                                "valueField": "value",
                                "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                            }],
                          //  "chartScrollbar": {
//                                "graph": "g1",
//                                "oppositeAxis":false,
//                                "offset":30,
//                                "scrollbarHeight": 80,
//                                "backgroundAlpha": 0,
//                                "selectedBackgroundAlpha": 0.1,
//                                "selectedBackgroundColor": "#888888",
//                                "graphFillAlpha": 0,
//                                "graphLineAlpha": 0.5,
//                                "selectedGraphFillAlpha": 0,
//                                "selectedGraphLineAlpha": 1,
//                                "autoGridCount":true,
//                                "color":"#AAAAAA"
//                            },
                            "chartCursor": {
                                "pan": true,
                                "valueLineEnabled": true,
                                "valueLineBalloonEnabled": true,
                                "cursorAlpha":1,
                                "cursorColor":"#258cbb",
                                "limitToGraph":"g1",
                                "valueLineAlpha":0.1
                            },
                            "valueScrollbar":{
                              "oppositeAxis":false,
                              "offset":50,
                              "scrollbarHeight":10
                            },
                            "categoryField": "time",
                            "categoryAxis": {
                              //  "parseDates": true,
                                "dashLength": 0,
                                "minorGridEnabled": true
                            },
                            "export": {
                                "enabled": true
                            },
                            "exportConfig": {
                                "menuBottom": "20px",
                                "menuRight": "22px",
                                "menuItems": [{
                                    "icon": $template_url + "global/plugins/amcharts/amcharts/images/export.png",
                                    "format": 'png'
                                }]
                            },
                            "dataProvider": res
                            //[{
//                                "date": "2013-01-30",
//                                "value": 81
//                            }]
                        });
                        
                        chart.addListener("rendered", zoomChart);
                        
                        zoomChart();
                        
                        
                
                        $('#chartdiv').closest('.portlet').find('.fullscreen').click(function() {
                            chart.invalidateSize();
                        });
                        
                    };
                    function zoomChart() {
                     //   chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
                     //chart.zoomToIndexes(chart.dataProvider.length - chart.dataProvider.length, chart.dataProvider.length - 1);
                    }
                    // END CHART 
}