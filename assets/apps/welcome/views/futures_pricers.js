define([
    'jquery',
    'underscore',
    'backbone'
    ], function($, _, Backbone){
        var futures_pricersView = Backbone.View.extend({
            el: $(".main-container"),
            initialize: function() {

            },
            events: {
                "click #caculate_discrete": "actionCaculate_discrete",
				"click .btn_model_pricing": "actionBtn_model_pricing",
				"click [data-field='interest']": "actionInterest",
				"click [data-field='dividend']": "actionDividend",
				"click .btn_order_session": "actionBtnOrderSession",
            },
            actionBtnOrderSession:function(event){
            	var param = $(".value_theoretical").text();
                $.ajax({
                    url: $base_url + 'ajax/save_session_live',
                    type: 'POST',
                    async: false,
                    data: {param: param},
                    success: function(respone) {

                    }
                });

			},
			actionDividend: function(event){
				$(".dividend_q").attr('attr',$("#dividend").val());
			},
			actionInterest: function(event){
				$(".interest_r").attr('attr',$("#interest").val());
			},
			actionBtn_model_pricing: function(event) {
				var name = $('#menu_model .selected_tr td').text();
				var id = $('#menu_model .selected_tr td').attr('id');
				if((name!='') && (typeof name != "undefined")){
					$.ajax({
						url: $base_url + 'ajax/save_session_menu_model',
						type: 'POST',
						async: false,
						data: {name: name},
						success: function(respone) {
							var result = JSON.parse(respone);
							$('.expiry_t').html(result['TFORMAT']);
							$('.expiry_t').attr('attr',result['T']);
							
							$('.spot_s').html(result['SFORMAT']);
							$('.spot_s').attr('attr',result['S']);
							
							$('.interest_r').html(result['R']);
							$('.interest_r').attr('attr',result['R']);
							
							$('.dividend_q').html(result['Q']);
							$('.dividend_q').attr('attr',result['Q']);
							
						   $('.val_menu_model').html(name);
						   $('.val_menu_model').attr('id',id);
						}
					});
					 
					
				}
				$('#caculate_discrete').click();
			},
			actionCaculate_discrete: function(event) {
				function addCommas(nStr)
				{
					nStr += '';
					var x = nStr.split('.');
					var x1 = x[0];
					var x2 = x.length > 1 ? '.' + x[1] : '';
					var rgx = /(\d+)(\d{3})/;
					while (rgx.test(x1)) {
						x1 = x1.replace(rgx, '$1' + ',' + '$2');
					}
					return x1 + x2;
				}
				var s  =  $('.spot_s').attr('attr');
				var r = $('.interest_r').attr('attr');
				var t = $('.expiry_t').attr('attr');
				var q = $('.dividend_q').attr('attr');
				if($('.val_menu_model').attr('id') == 3){
					   $.ajax({
							url: $base_url+'ajax/caculate_dmwdd',
							type: "POST",
							data: {s:s,r:r,t:t,q:q},
							success: function(res){
								res = parseFloat(res);
								var put = res-s;
								//console.log(put);
								Number.prototype.round = function(places) {
								  return +(Math.round(this + "e+" + places)  + "e-" + places);
								}
								
								$('.value_theoretical').html(addCommas(res.round(6)));
								$('.value_futures').html(addCommas(put.round(2)));	
							}
							   
						});
				}
				else if($('.val_menu_model').attr('id') == 4){
					$.ajax({
							url: $base_url+'ajax/caculate_dmwpd',
							type: "POST",
							data: {s:s,r:r,t:t,q:q},
							success: function(res){
								res = parseFloat(res);
								var put = res-s;
								//console.log(put);
								Number.prototype.round = function(places) {
								  return +(Math.round(this + "e+" + places)  + "e-" + places);
								}
								
								$('.value_theoretical').html(res.round(6));
								$('.value_futures').html(put.round(2));	
							}
							   
						});	
				}
				else if($('.val_menu_model').attr('id') == 135){
					$.ajax({
							url: $base_url+'ajax/caculate_cmwdd',
							type: "POST",
							data: {s:s,r:r,t:t,q:q},
							success: function(res){
								res = parseFloat(res);
								var put = res-s;
								//console.log(put);
								Number.prototype.round = function(places) {
								  return +(Math.round(this + "e+" + places)  + "e-" + places);
								}
								
								$('.value_theoretical').html(res.round(6));
								$('.value_futures').html(put.round(2));	
							}
							   
						});	
				}
				else if($('.val_menu_model').attr('id') == 136){
					$.ajax({
							url: $base_url+'ajax/caculate_cmwpd',
							type: "POST",
							data: {s:s,r:r,t:t,q:q},
							success: function(res){
								res = parseFloat(res);
								var put = res-s;
								//console.log(put);
								Number.prototype.round = function(places) {
								  return +(Math.round(this + "e+" + places)  + "e-" + places);
								}
								
								$('.value_theoretical').html(res.round(6));
								$('.value_futures').html(put.round(2));	
							}
							   
						});	
				}
				else{
						
				}
            },
            index: function(){
                $(document).ready(function(){
                   $('#caculate_discrete').click();
                });
            },
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
            }
        });
    return new futures_pricersView;
});