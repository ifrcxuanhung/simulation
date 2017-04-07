$(document).ready(function() {
	//simulation
	
	function escapeRegExp(str) {
		return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
	}
	function replaceAll(str, find, replace) {
	  return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
	}
	
	
	$('.submit_contact').click(function(){
		var input_captcha = $("[name='userCaptcha']").val();
		var captcha_image = $('.captcha_image').attr('attr');
		if(input_captcha == captcha_image){
			bootbox.alert('Send message successfull');
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			return true;	
		}else{
			bootbox.alert('Captcha error');
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			return false;
		}
	});
	
	$(".update_exc").click(function(){
		bootbox.confirm({
					message: "Are you sure update data exchange ?",
					callback: function(result){
						if(result == true){
						  $.ajax({
								url: $base_url + "maintenance/update_data_final",
								type: "POST",
								data: {},
								async: false,
								success: function(response) {
									$.ajax({ 
										url:$base_url + "maintenance/update_date_setting",
										type:"POST",
										data:{param:'UPDATE_VDM_CONTRACTS_SETTING_EXC'},
										success: function(response2) {
											var rs = JSON.parse(response2);
											$('.date_parent_2').html('<button class="btn blue date2" type="button">'+rs.value+'</button>');
										},
									
									});
									 //window.location.reload();
								}
							});	
						}	
					}
				});
				$('.modal-header').html("CONFIRMATION"); 
				$('.modal-header').css("padding",'7px');
				$('.modal-header').css("color",'#fff'); 
	});
	$('.clean_dashboard').click(function(){
		bootbox.confirm({
					message: "Are you sure clean dashboard future ?",
					callback: function(result){
						if(result == true){
						  $.ajax({
								url: $base_url + "maintenance/clean_dashboard",
								type: "POST",
								data: {},
								async: false,
								success: function(response) {
									$.ajax({ 
										url:$base_url + "maintenance/update_date_setting",
										type:"POST",
										data:{param:'CLEAN_DASHBOARD_FUTURE'},
										success: function(response2) {
											var rs = JSON.parse(response2);
											$('.date_parent_3').html('<button class="btn blue date3" type="button">'+rs.value+'</button>');
										},
									
									});
									// window.location.reload();
								}
							});	
						}	
					}
				});
				$('.modal-header').html("CONFIRMATION"); 
				$('.modal-header').css("padding",'7px');
				$('.modal-header').css("color",'#fff');	
	});
	
	$('.clean_contracts_setting').click(function(){
		bootbox.confirm({
					message: "Are you sure clean contracts setting?",
					callback: function(result){
						if(result == true){
						  $.ajax({
								url: $base_url + "maintenance/clean_contracts_setting",
								type: "POST",
								data: {},
								async: false,
								success: function(response) {
									$.ajax({ 
										url:$base_url + "maintenance/update_date_setting",
										type:"POST",
										data:{param:'CLEAN_VDM_CONTRACTS_SETTING'},
										success: function(response2) {
											var rs = JSON.parse(response2);
											$('.date_parent_4').html('<button class="btn blue date4" type="button">'+rs.value+'</button>');
										},
									
									});
									// window.location.reload();
								}
							});	
						}	
					}
				});
				$('.modal-header').html("CONFIRMATION"); 
				$('.modal-header').css("padding",'7px');
				$('.modal-header').css("color",'#fff');	
	});
	
	$('.clean_dashboard_option').click(function(){
		bootbox.confirm({
					message: "Are you sure clean dashboard option?",
					callback: function(result){
						if(result == true){
						  $.ajax({
								url: $base_url + "maintenance/clean_dashboard_option",
								type: "POST",
								data: {},
								async: false,
								success: function(response) {
									$.ajax({ 
										url:$base_url + "maintenance/update_date_setting",
										type:"POST",
										data:{param:'CLEAN_DASHBOARD_OPTION'},
										success: function(response2) {
											var rs = JSON.parse(response2);
											$('.date_parent_5').html('<button class="btn blue date5" type="button">'+rs.value+'</button>');
										},
									
									});
									 //window.location.reload();
								}
							});	
						}	
					}
				});
				$('.modal-header').html("CONFIRMATION"); 
				$('.modal-header').css("padding",'7px');
				$('.modal-header').css("color",'#fff');	
	});
	$('.reset_market').click(function(){
		bootbox.confirm({
					message: "Are you sure reset market ?",
					callback: function(result){
						if(result == true){
						  $.ajax({
								url: $base_url + "maintenance/reset_market",
								type: "POST",
								data: {},
								async: false,
								success: function(response) {
									$.ajax({ 
										url:$base_url + "maintenance/update_date_setting",
										type:"POST",
										data:{param:'RESET_MARKET'},
										success: function(response2) {
											var rs = JSON.parse(response2);
											$('.date_parent_6').html('<button class="btn blue date6" type="button">'+rs.value+'</button>');
										},
									
									});
									// window.location.reload();
								}
							});	
						}	
					}
				}); 
				$('.modal-header').html("CONFIRMATION"); 
				$('.modal-header').css("padding",'7px');
				$('.modal-header').css("color",'#fff'); 	
	});
	
	/*$(".description_help").hover(function(event){
		var text_first = $(".description_help").html();
		var $this = $(event.currentTarget);
		$(".description_help").html('<textarea class="textarea_cus">'+$(".description_help").html()+'</textarea>');
		$('.textarea_cus').css({"width":"570px","height":"100px"});
		$this.removeClass('description_help');
	},function(event){
		
	});*/
	
	
	
	$('.button_sell').click(function(){
		$('#input_buy_sell').val('S');	
		
		
		var lots = $('.val_lots').html();
		var order_type = $('.val_order_type').html();
		
		var duration = $('.val_duration').html();
		
		var price = replaceAll($('.val_price').html(),',','');
		var index_last = $('.index_last').attr('value-default');
		var min_last = 0.5*index_last;
		var max_last = 1.5*index_last;
		
		if(order_type != 'LIMIT'){
			
			bootbox.alert($order_type_must_limit); 
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;
		}
		else if(duration != 'DAILY'){
			bootbox.alert($order_type_must_daily); 
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;	
		}
		else if(price < min_last || price > max_last){
			bootbox.alert($price_error); 
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;	
		}
		else if(lots <= 0){
			
			bootbox.alert($lots_must_equa_0); 
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;
		}else{
			return true;	
		}
	
		
	});
	$('.button_buy').click(function(){
		$('#input_buy_sell').val('B');	
		
		var lots = $('.val_lots').html();
		var order_type = $('.val_order_type').html();
		var duration = $('.val_duration').html();
		
		var price = replaceAll($('.val_price').html(),',','');
		var index_last = $('.index_last').attr('value-default');
		var min_last = 0.5*index_last;
		var max_last = 1.5*index_last;
		if(order_type != 'LIMIT'){
			bootbox.alert($order_type_must_limit);
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"}); 
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;
		}
		else if(duration != 'DAILY'){
			bootbox.alert($order_type_must_daily); 
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;	
		}
		else if(price < min_last || price > max_last){
			bootbox.alert($price_error); 
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;	
		}
		else if(lots <= 0){
			bootbox.alert($lots_must_equa_0); 
			$('.modal-header').html("INFOMATION");	
			$('.modal-header').css({"padding":"7px","color":"#fff"});
			setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);
			return false;
		}
		else{
			return true;
		}
	
	});
	$('.submit_sell').click(function(){
		//alert($('#simul_expiry .selected_tr td').attr('id'););
		var data = $('#form_hide').serializeArray();
		
		var data_value = $("[edit_for='lots']").attr("data-value");
		// kiem tra thoa dieu kien truoc khi dat lenh
		$.ajax({
			url: $base_url + 'ajax/check_margin_order',
			type: 'POST',
			async: false,
			data: {data_value:data_value} ,
			beforeSend: function(){
				 $(".loader").show();
				
			 },
			 complete: function(){
				 $(".loader").hide();
				 
			 },
			success: function(res) {
				if(res == 0){
					
					bootbox.confirm($error_buy_sell, function(result) {
						
						if(result == false){
							return true;
					   }
					   else{
						   return true;
						   }
					});
					$('.modal-header').html("INFOMATION"); 
					$('.modal-header').css("padding",'7px');
					$('.modal-header').css("color",'#fff');
				}
				else{
					$.ajax({
							url: $base_url + 'ajax/insert_daily_futures',
							type: 'POST',
							async: false,
							data: $.param(data) ,// "inp1=val1&inp2=val2"
							beforeSend: function(){
								 $(".loader").show();
								
							 },
							 complete: function(){
								 $(".loader").hide();
								 
							 },
							success: function() {
								//$("#loading").hide();	
								bootbox.alert("SELL SUCCESSFULLY ! "); 	
								$('.modal-header').html("INFOMATION");	
								$('.modal-header').css({"padding":"7px","color":"#fff"});
								setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);	  				  			
							}
						});
	
				}	  				  			
			}
		});
		
			
		
	});
	

	$('.submit_buy').click(function(){
		//alert($('#simul_expiry .selected_tr td').attr('id'););
		var data = $('#form_hide').serializeArray();
		var data_value = $("[edit_for='lots']").attr("data-value");
		// kiem tra thoa dieu kien truoc khi dat lenh
		$.ajax({
			url: $base_url + 'ajax/check_margin_order',
			type: 'POST',
			async: false,
			data: {data_value:data_value} ,
			beforeSend: function(){
				 $(".loader").show();
				
			 },
			 complete: function(){
				 $(".loader").hide();
				 
			 },
			success: function(res) {
				if(res == 0){
					
					bootbox.confirm($error_buy_sell, function(result) {
						
						if(result == false){
							return true;
					   }
					   else{
						   return true;
						   }
					});
					$('.modal-header').html("INFOMATION"); 
					$('.modal-header').css("padding",'7px');
					$('.modal-header').css("color",'#fff');
				}
				else{
					$.ajax({
						url: $base_url + 'ajax/insert_daily_futures',
						type: 'POST',
						async: false,
						data: $.param(data) ,// "inp1=val1&inp2=val2"
						beforeSend: function(){
							 $(".loader").show();
							
						 },
						 complete: function(){
							 $(".loader").hide();
							 
						 },
						success: function() {
							//$("#loading").hide();		
							bootbox.alert("BUY SUCCESSFULLY ! "); 
							$('.modal-header').html("INFOMATION");	
							$('.modal-header').css({"padding":"7px","color":"#fff"});
							setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);			  				  			
						}
					});
	
				}	  				  			
			}
		});
		
		
		
				
	});
	
	
	$('.submit_sell_option').click(function(){
		//alert($('#simul_expiry .selected_tr td').attr('id'););
		var data = $('#form_hide').serializeArray();
		var input_buy_sell = 'Sell';
		data.push({"name":"input_buy_sell","value":input_buy_sell});
		
		var data_value = $("[edit_for='lots']").attr("data-value");
		// kiem tra thoa dieu kien truoc khi dat lenh
		$.ajax({
			url: $base_url + 'ajax/check_margin_order_option',
			type: 'POST',
			async: false,
			data: {data_value:data_value} ,
			beforeSend: function(){
				 $(".loader").show();
				
			 },
			 complete: function(){
				 $(".loader").hide();
				 
			 },
			success: function(res) {
				if(res == 0){
					
					bootbox.confirm($error_buy_sell, function(result) {
						
						if(result == false){
							return true;
					   }
					   else{
						   return true;
						   }
					});
					$('.modal-header').html("INFOMATION"); 
					$('.modal-header').css("padding",'7px');
					$('.modal-header').css("color",'#fff');
				}
				else{
					$.ajax({
							url: $base_url + 'ajax/insert_daily_options',
							type: 'POST',
							async: false,
							data: $.param(data) ,// "inp1=val1&inp2=val2"
							beforeSend: function(){
								 $(".loader").show();
								
							 },
							 complete: function(){
								 $(".loader").hide();
								 
							 },
							success: function() {
								//$("#loading").hide();	
								bootbox.alert("SELL SUCCESSFULLY ! "); 	
								$('.modal-header').html("INFOMATION");	
								$('.modal-header').css({"padding":"7px","color":"#fff"});
								setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);	  				  			
							}
						});
	
				}	  				  			
			}
		});
		
			
		
	});
	
	
	$('.submit_buy_option').click(function(){
		//alert($('#simul_expiry .selected_tr td').attr('id'););
		var data = $('#form_hide').serializeArray();
		
		var input_buy_sell = 'Buy';
		data.push({"name":"input_buy_sell","value":input_buy_sell});
	
		var data_value = $("[edit_for='lots']").attr("data-value");
		// kiem tra thoa dieu kien truoc khi dat lenh
		$.ajax({
			url: $base_url + 'ajax/check_margin_order_option',
			type: 'POST',
			async: false,
			data: {data_value:data_value} ,
			beforeSend: function(){
				 $(".loader").show();
				
			 },
			 complete: function(){
				 $(".loader").hide();
				 
			 },
			success: function(res) {
				if(res == 0){
					
					bootbox.confirm($error_buy_sell, function(result) {
						
						if(result == false){
							return true;
					   }
					   else{
						   return true;
						   }
					});
					$('.modal-header').html("INFOMATION"); 
					$('.modal-header').css("padding",'7px');
					$('.modal-header').css("color",'#fff');
				}
				else{
					$.ajax({
							url: $base_url + 'ajax/insert_daily_options',
							type: 'POST',
							async: false,
							data: $.param(data) ,// "inp1=val1&inp2=val2"
							beforeSend: function(){
								 $(".loader").show();
								
							 },
							 complete: function(){
								 $(".loader").hide();
								 
							 },
							success: function() {
								//$("#loading").hide();	
								bootbox.alert("SELL SUCCESSFULLY ! "); 	
								$('.modal-header').html("INFOMATION");	
								$('.modal-header').css({"padding":"7px","color":"#fff"});
								setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);	  				  			
							}
						});
	
				}	  				  			
			}
		});
		
			
		
	});
	
	

	$('.click_show_box').click(function(event){
			
			bootbox.confirm("You need to sign in !", function(result) {
		  	//Example.show("Confirm result: "+result);
			if(result == false){
				return true;
		   }
		   else{
			   return true;
			   }
		});
		$('.modal-header').html("INFOMATION"); 
		$('.modal-header').css("padding",'7px');
		$('.modal-header').css("color",'#fff');
	});
	
	
	$('#open_off').prev().text('CLOSE').css("padding-left",'3px');;
	$('#open_off').prev().prev().prev().text('OPEN').css("padding-left",'8px');
	
	
	$('#freqm').keyup(function () { 
		this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	
	
	
	if($("[name='open_off']").bootstrapSwitch('state') == false){
		$('#freqm').attr('disabled','disabled');	
	}
	$("[name='open_off']").on('switchChange.bootstrapSwitch', function (e, data){
		if($("[name='open_off']").bootstrapSwitch('state') == false){
			$('#freqm').attr('disabled','disabled');	
		}
		else{
			$('#freqm').removeAttr('disabled','disabled');	
		}
	})
	
	
	
	 $('.submit_open_close').click(function(event){
		// bootbox.alert($('.status_market').text());
		// return false;
		
		
			var status = $('.status_market').text();
			//console.log(status);
			bootbox.confirm("Are you sure?", function(result) {
		  	//Example.show("Confirm result: "+result);

				if(result == false){
					return false;
			   }
			   else{
				   var open_close = $("[name='open_off']").bootstrapSwitch('state');
				  // var market_making_futures = $("[name='market_making_futures']").bootstrapSwitch('state');
				   var freqm = $('#freqm').val();
				   $.ajax({
						url: $base_url + 'ajax/update_vndmi_setting',
						type: 'POST',
						async: false,
						data: {open_close: open_close, freqm: freqm},
						 beforeSend: function(){
							 $(".loader").show();
							
						 },
						 complete: function(){
							 $(".loader").hide();
							 
						 },
						success: function() {
							//window.location.reload();
							//return false;

						}
					});
					
					if(open_close == false){
						$.ajax({
							type: "POST",
							url: $base_url + "ajax/closeMarket",
							async: false,
							 beforeSend: function(){
								 $(".loader").show();
								
							 },
							 complete: function(){
								 $(".loader").hide();
								 
							 },
							success: function() {
								//$("#loading").hide();		
								bootbox.alert("Done ! "); 
								$('.modal-header').html("INFOMATION"); 
								$('.modal-header').css("padding",'7px');
								$('.modal-header').css("color",'#fff');	
								setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);		  				  			
							}
						});
					}
					else {
						$.ajax({
							type: "POST",
							url: $base_url + "ajax/openMarket",
							async: false,
							 beforeSend: function(){
								 $(".loader").show();
								
							 },
							 complete: function(){
								 $(".loader").hide();
								 
							 },
							success: function() {
								//$("#loading").hide();		
								bootbox.alert("Done ! "); 
								$('.modal-header').html("INFOMATION"); 
								$('.modal-header').css("padding",'7px');
								$('.modal-header').css("color",'#fff');	
								setInterval(function(){ bootbox.hideAll(); }, $box_info_auto_close_seconds*1000);			  				  			
							}
						});
					}
					
				  
					//console.log($("[name='open_off']").bootstrapSwitch('state'));
			   }
		}); 
		$('.modal-header').html("INFOMATION"); 
		$('.modal-header').css("padding",'7px');
		$('.modal-header').css("color",'#fff');
	   
	 });
	 
	 
	 
	 
	 $('.submit_marketmaking').click(function(event){
		// bootbox.alert($('.status_market').text());
		// return false;
		
			bootbox.confirm("Are you sure?", function(result) {
		  	//Example.show("Confirm result: "+result);
			if(result == false){
					return false;
		   }
		   else{
			  
			   var market_making_futures = $("[name='market_making_futures']").is(':checked');
			   if(market_making_futures == false){
					 $.ajax({
						type: "POST",
						url: $base_url + "ajax/market_making_futures_close",
						async: false,
						beforeSend: function(){
							 $(".loader").show();
							
						 },
						 complete: function(){
							 $(".loader").hide();
							 
						 },
						success: function() {
																	
						}
					});  
				}
				else{
					 $.ajax({
						type: "POST",
						url: $base_url + "ajax/market_making_futures_open",
						async: false,
						beforeSend: function(){
							 $(".loader").show();
							
						 },
						 complete: function(){
							 $(".loader").hide();
							 
						 },
						success: function() {
								
						}
					});  	
				}
			
		   }
		});
		$('.modal-header').html("INFOMATION"); 
		$('.modal-header').css("padding",'7px');
		$('.modal-header').css("color",'#fff'); 
	   
	 });
	 
	 
	 
	 
	 
	 $('.btn_order_product').click(function(event){

         // xoa $_SESSION['session_price']
         $.ajax({
             url: $base_url + 'ajax/delete_session_price',
             type: 'POST',
             async: false,
             success: function() {

             }
         });
		var $this = $(event.currentTarget);
		var dsymbol = $('#order_product .selected_tr td').attr('id');
		if((dsymbol!='') && (typeof dsymbol != "undefined")){
			$.ajax({
				url: $base_url + 'ajax/save_session_array',
				type: 'POST',
				async: false,
				data: {dsymbol: dsymbol},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
					window.location.reload();
					return false;
				}
			});
		}


	});
	
	
	
	
	$('.save_session_dsymbol').click(function(event){
		var $this = $(event.currentTarget);
		var dsymbol = $this.attr('id');
		//console.log(dsymbol);
		if((dsymbol!='') && (typeof dsymbol != "undefined")){
			$.ajax({
				url: $base_url + 'ajax/save_session_array',
				type: 'POST',
				async: false,
				data: {dsymbol: dsymbol},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
					window.location.reload();
					return false;
				}
			});
		}
	});
	
	
	
	
	
	$('.btn_expiry').click(function(){

        $.ajax({
            url: $base_url + 'ajax/delete_session_price',
            type: 'POST',
            async: false,
            success: function() {

            }
        });

		var name = $('#simul_expiry .selected_tr td').text();
		var expiry = $('#simul_expiry .selected_tr td').attr('id');
	
		if((name!='') && (typeof name != "undefined")){
			$.ajax({
				url: $base_url + 'ajax/save_session_expiry',
				type: 'POST',
				async: false,
				data: {name: name, expiry:expiry},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
					//window.location.reload();
				   // return false;
				  window.location.reload();
				  return false;
				}
			});
		}
		//$.session.set("val_expiry", value);
		//$('.val_expiry').html($.session.get("val_expiry"));
		
	});
	
	
	
	
	$('.btn_order_type').click(function(){
		var name = $('#order_type .selected_tr td').text();
		if((name!='') && (typeof name != "undefined")){
			$.ajax({
				url: $base_url + 'ajax/save_session_order_type',
				type: 'POST',
				async: false,
				data: {name: name},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
					//window.location.reload();
				   // return false;
				   $('.val_order_type').html(name);
				}
			});
		}
	});
	
	

	$('.btn_duration').click(function(){
		var name = $('#menu_duration .selected_tr td').text();
		if((name!='') && (typeof name != "undefined")){
			$.ajax({
				url: $base_url + 'ajax/save_session_duration',
				type: 'POST',
				async: false,
				data: {name: name},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
					//window.location.reload();
				   // return false;
				   $('.val_duration').html(name);
				}
			});
		}
	});
	
	
	
	
	$('.btn_call_put').click(function(){
		var name = $('#call_put .selected_tr td').text();
		if((name!='') && (typeof name != "undefined")){
			$.ajax({
				url: $base_url + 'ajax/save_session_call_put',
				type: 'POST',
				async: false,
				data: {name: name},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
					window.location.reload();
				   // return false;
				   $('.val_call_put').html(name);
				}
			});
		}
	});
	
	
	
	
	$('.btn_strike').click(function(){
		var name = $('#strike .selected_tr td').text();
		if((name!='') && (typeof name != "undefined")){
			$.ajax({
				url: $base_url + 'ajax/save_session_strike',
				type: 'POST',
				async: false,
				data: {name: name},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
					window.location.reload();
				   // return false;
				   $('.val_strike').html(name);
				}
			});
		}
	});
	
	
	$('.minscreens').hide();
	$('.fullscreens').click(function(event){
		var $this = $(event.currentTarget);
		$('.blocks').css('display','none');
		$('.use_fullscreen').addClass('col-md-12');
		$('.slimScrollDiv').css('height','400px');
		$('.scroller').css('height','400px');
		$this.parents('.blocks').show();
		$this.hide();
		$('.minscreens').show();
	});
	
	
	
	$('.minscreens').click(function(){
		$('.blocks').show();
		$('.use_fullscreen').removeClass('col-md-12');
		$('.slimScrollDiv').css('height','250px');
		$('.scroller').css('height','250px');
		$('.minscreens').hide();
		$('.fullscreens').show();
	});
	
	
	
	
	$(".table_modal tr").click(function(){
	   $(this).addClass('selected_tr').siblings().removeClass('selected_tr');    
	 
	  
	});
	
	
	
	
	$('body').bind('copy paste',function(e) {
		e.preventDefault(); return false; 
	});
	
	
	
	
	$(".table_modal tr").dblclick(function(){
		$('.ladda-button').click();	
	});	
	
	
	
	$('.getval_tooltip').click(function(){
		var id = $(this).attr('id');
		var html ='';
		 $.ajax({
                url: $base_url + 'simulation/ajax/getSimul',
                type: 'POST',
                async: false,
                data: {id: id},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function(res){
					var result = JSON.parse(res);
					
					html = '<div class="mo_title">'+result.stype+'</div><div class="des">'+result.desc+'</div>';
					$('.append_ajax').html(html);	
				}
            });
		 
		
	});
	
	
	
    $('.load_modals').click(function(event) {
        var $this = $(event.currentTarget);
        var type = $this.data('type');
        var field = $this.attr('edit_for');
        var value = $this.data('value');
		var data_default = $this.attr('data_default');
       // var title = $this.data('title');
        $.ajax({
            url: $simulation_url + 'ajax/view_modal',
            type: 'POST',
            async: false,
            data: {field: field, value: value,type:type, data_default:data_default},
			beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
            success: function(response) {
                //console.log(response);
                $("#modals .modal-content").html(response);
                $.validator.addMethod("noSpace", function(value, element) { 
                    return value.indexOf(" ") < 0 && value != "";
                }, "No space please and don't leave it empty");
            }
        });
        $('a.edit-submit').click(function(event){
            var $this = $(event.currentTarget);
            var field = $this.data('field');
            var value = $('#'+field).val();
            $('[edit_for="'+field+'"]').text(value);
            $('[edit_for="'+field+'"]').data('value',value);
            $('#modals').modal('hide');
           // $.ajax({
    //            url: $base_url + 'profile/ajax_update_profile',
    //            type: 'POST',
    //            async: false,
    //            data: {table: table, field: field, value: value, id: id},
    //            success: function(response) {
    //               if(response!=false){
    //                    var obj = JSON.parse(response);
    //                    
    //               }
    //            }
    //        });   
        });
		
		 $('a.edit_price').click(function(event){
            var $this = $(event.currentTarget);
            var field = $this.data('field');
            var data_default = $('#'+field).attr('data_default');
			var value = $('#'+field).val();
            $('[edit_for="'+field+'"]').text(value);
            $('[edit_for="'+field+'"]').data('value',value);
            $('#modals').modal('hide');
			//console.log(value);
           $.ajax({
				url: $base_url + 'ajax/save_session_price',
				type: 'POST',
				async: false,
				data: {field: field, value: value,type:type, data_default: data_default},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
				  window.location.reload();
				  return false;
				}
			});
        });
		
		$('a.edit_lots').click(function(event){
            var $this = $(event.currentTarget);
            var field = $this.data('field');
            var data_default = $('#'+field).attr('data_default');
			var value = $('#'+field).val();
            $('[edit_for="'+field+'"]').text(value);
            $('[edit_for="'+field+'"]').data('value',value);
            $('#modals').modal('hide');
			//console.log(value);
           $.ajax({
				url: $base_url + 'ajax/save_session_lots',
				type: 'POST',
				async: false,
				data: {field: field, value: value,type:type, data_default: data_default},
				beforeSend: function(){
					 $(".loader").show();
					
				 },
				 complete: function(){
					 $(".loader").hide();
					 
				 },
				success: function() {
				  window.location.reload();
				  return false;
				}
			});
        });
		
		
		$('#lots').keydown(function(e){
			
                 var $this = $(e.currentTarget);
                 $this.parent().siblings('td').removeClass('option');   
                 if ($.inArray(e.keyCode, [46, 8, 9, 27,  110, 190]) !== -1 ||
                     // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                     // Allow: Ctrl+C
                    (e.keyCode == 67 && e.ctrlKey === true) ||
                     // Allow: Ctrl+X
                    (e.keyCode == 88 && e.ctrlKey === true) ||
                     // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                         // let it happen, don't do anything
						 return;
						
                }
				if ($.inArray(e.keyCode, [13]) !== -1 ) {
                         // let it happen, don't do anything
                         //e.preventDefault();
						var id = $this.data('id');
						var last = parseInt($this.attr('last'));
						var count = 0;
						var share = 0;
						if(typeof($this.val()) != "undefined" && $this.val() != null && $this.val() != 'NaN' && $this.val().length != 0){
							 share = parseInt($this.val());
						}else{
							$this.parent('td').addClass('option');
							$this.val(0);
						}
						var sumValue = 0;
						var value = last*share;
						$this.parents().find('tr[data-id='+id+']').children().find('.valueCaculaioned').text(number_format(value,0,'.',','));
						$('#tableSelected tr.selected').each(function() {
							var text = $(this).children().find('.valueCaculaioned').text().replace(/,/g , '');
							//console.log(text);
						   // var count = 0;
							if(typeof(text) != "undefined" && text != null && text != 'NaN' && text.length != 0){
								count ++;
								sumValue += parseFloat(text);
							}
						});
						$('.countShare').text(count);
						$('.sumValueCalculation').text(number_format(sumValue,0,'.',','));
                        $('.countShareI').attr('value',count);
                        $('.sumValueCalculationI').attr('value',number_format(sumValue,0,'.',','));
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            
		
		});
		
		$('#price').keydown(function(e){
			
                 var $this = $(e.currentTarget);
                 $this.parent().siblings('td').removeClass('option');   
                 if ($.inArray(e.keyCode, [46, 8, 9, 27,  110, 190]) !== -1 ||
                     // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                     // Allow: Ctrl+C
                    (e.keyCode == 67 && e.ctrlKey === true) ||
                     // Allow: Ctrl+X
                    (e.keyCode == 88 && e.ctrlKey === true) ||
                     // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                         // let it happen, don't do anything
                         return;
                }
				if ($.inArray(e.keyCode, [13]) !== -1 ) {
                         // let it happen, don't do anything
                         //e.preventDefault();
						var id = $this.data('id');
						var last = parseInt($this.attr('last'));
						var count = 0;
						var share = 0;
						if(typeof($this.val()) != "undefined" && $this.val() != null && $this.val() != 'NaN' && $this.val().length != 0){
							 share = parseInt($this.val());
						}else{
							$this.parent('td').addClass('option');
							$this.val(0);
						}
						var sumValue = 0;
						var value = last*share;
						$this.parents().find('tr[data-id='+id+']').children().find('.valueCaculaioned').text(number_format(value,0,'.',','));
						$('#tableSelected tr.selected').each(function() {
							var text = $(this).children().find('.valueCaculaioned').text().replace(/,/g , '');
							//console.log(text);
						   // var count = 0;
							if(typeof(text) != "undefined" && text != null && text != 'NaN' && text.length != 0){
								count ++;
								sumValue += parseFloat(text);
							}
						});
						$('.countShare').text(count);
						$('.sumValueCalculation').text(number_format(sumValue,0,'.',','));
                        $('.countShareI').attr('value',count);
                        $('.sumValueCalculationI').attr('value',number_format(sumValue,0,'.',','));
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            
		
		});
		
    });
	
	
	
    
    
    if( $('#clockbox').length )// use this if you are using id to check
    {
        GetClock();
	    setInterval(GetClock,1000);   
    }
	setInterval(function(){
		var data='';
		 $.ajax({
			url: $simulation_url + 'ajax/index_last',
			dataType: 'json',
			success: function(data) {
				//clearconsole();
				//console.log(data);	
				if($('.status_market').html()!=data.status_market.status){
					$('.status_market').fadeOut('slow', function() {						
						$('.status_market').html(data.status_market.status);
						if(data.status_market.value=='-1') $('.status_market').removeClass("bg_green_head").addClass("bg_red_head");
						else $('.status_market').removeClass("bg_red_head").addClass("bg_green_head");
						$('.status_market').fadeIn('slow');
					});
				}
				if($('.index_last').html()!=data.underlying_setting.last){
					$('.index_last').fadeOut('slow', function() {
						
						$('.index_last').html(data.underlying_setting.last);
						$('.index_last').effect("highlight", {color: '#4c87b9'}, 300);
						$('.index_last').fadeIn('slow');
					});
				}
				if($('.index_change').html()!=data.underlying_setting.change){
					$('.index_change').fadeOut('slow', function() {
						$('.index_change').effect("highlight", {color: '#4c87b9'}, 300);
						$('.index_change').html(data.underlying_setting.change);
							$('.index_change').fadeIn('slow');
					});
				}
				if($('.index_var').html()!=data.underlying_setting.var){
					$('.index_var').fadeOut('slow', function() {
						$('.index_var').effect("highlight", {color: '#4c87b9'}, 300);
						$('.index_var').html(data.underlying_setting.var);
							$('.index_var').fadeIn('slow');
					});
				}
				if($('.index_time').html()!=data.underlying_setting.time){
					$('.index_time').fadeOut('slow', function() {
						$('.index_time').effect("highlight", {color: '#4c87b9'}, 300);
						$('.index_time').html(data.underlying_setting.time);
						$('.index_time').fadeIn('slow');
					});
				}
				
				if($('.futures_last').html()!=data.dashboard_future.last){
					$('.futures_last').fadeOut('slow', function() {
						$('.futures_last').effect("highlight", {color: '#4c87b9'}, 300);
						$('.futures_last').html(data.dashboard_future.last);
							$('.futures_last').fadeIn('slow');
					});
				}
				if($('.futures_change').html()!=data.dashboard_future.change){
					$('.futures_change').fadeOut('slow', function() {
						$('.futures_change').effect("highlight", {color: '#4c87b9'}, 300);
						$('.futures_change').html(data.dashboard_future.change);
							$('.futures_change').fadeIn('slow');
					});
				}
				if($('.futures_var').html()!=data.dashboard_future.var){
					$('.futures_var').fadeOut('slow', function() {
						$('.futures_var').effect("highlight", {color: '#4c87b9'}, 300);
						$('.futures_var').html(data.dashboard_future.var);
							$('.futures_var').fadeIn('slow');
					});
				}
				if($('.futures_oi').html()!=data.dashboard_future.oi){
					$('.futures_oi').fadeOut('slow', function() {
						$('.futures_oi').effect("highlight", {color: '#4c87b9'}, 300);
						$('.futures_oi').html(data.dashboard_future.oi);
							$('.futures_oi').fadeIn('slow');
					});
				}
				if($('.future_time').html()!=data.dashboard_future.time){
					$('.future_time').fadeOut('slow', function() {
						$('.future_time').effect("highlight", {color: '#4c87b9'}, 300);
						$('.future_time').html(data.dashboard_future.time);
							$('.future_time').fadeIn('slow');
					});
				}
				//console.log(data.best_limit);
				$.each($('.best_limit_expiry'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_expiry_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].expiry){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].expiry);
								$('#'+this.id).fadeIn('slow');
						});
					
					}
				});
				$.each($('.best_limit_qbid'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_qbid_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].qbid){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].qbid);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.best_limit_bid'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_bid_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].bid){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_red');
							if(data.best_limit[key].bid!='' && data.best_limit[key].bid!='') $('#'+this.id).addClass('bg_color_red');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].bid);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.option_best_limit_qbid'),function(){
					var key = this.id.split("option_best_limit_qbid_")[1];
					if($('#'+this.id).html()!=data.option_best_limit[key].qbid){
						$('#'+this.id).fadeOut('slow', function(){
							$('#'+this.id).effect("highlight",{color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].qbid);
							$('#'+this.id).fadeIn('slow');	
						});
					}
				});
				
				$.each($('.option_best_limit_bid'), function() {
					//console.log( this.id );
					var key = this.id.split("option_best_limit_bid_")[1]; 
					if($('#'+this.id).html()!=data.option_best_limit[key].bid){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_red');
							if(data.option_best_limit[key].bid!='' && data.option_best_limit[key].bid!='') $('#'+this.id).addClass('bg_color_red');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].bid);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				
				$.each($('option_best_limit_ask'),function(){
					var key = this.id.split("option_best_limit_ask_")[1];
					if($('#'+this.id).html()!=data.option_best_limit[key].ask){
						$('#'+this.id).fadeOut('slow', function(){
							$('#'+this.id).removeClass('bg_color_green');
							if(data.option_best_limit[key].ask!='' && data.option_best_limit[key].ask!='-') $('#'+this.id).addClass('bg_color_green');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].ask);
							$('#'+this.id).fadeIn('slow');	
						});	
					}	
				});
				
				$.each($('.option_best_limit_qask'),function(){
					var key = this.id.split("option_best_limit_qask_")[1];
					if($('#'+this.id).html()!=data.option_best_limit[key].qask){
						$('#'+this.id).fadeOut('slow', function(){
							$('#'+this.id).effect("highlight",{color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].qask);
							$('#'+this.id).fadeIn('slow');	
						});
					}
				});
				
				$.each($('.option_best_limit_last'),function(){
					var key = this.id.split("option_best_limit_last_")[1];
					if($('#'+this.id).html()!=data.option_best_limit[key].last){
						$('#'+this.id).fadeOut('slow', function(){
							$('#'+this.id).effect("highlight",{color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].last);
							$('#'+this.id).fadeIn('slow');	
						});
					}
				});
				
				
				$.each($('.best_limit_ask'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_ask_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].ask){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_green');
							if(data.best_limit[key].ask!='' && data.best_limit[key].ask!='-') $('#'+this.id).addClass('bg_color_green');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].ask);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.best_limit_qask'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_qask_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].qask){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].qask);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.best_limit_last'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_last_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].last){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_green');
							if(data.best_limit[key].last!='' && data.best_limit[key].last!='-') $('#'+this.id).addClass('bg_color_grey');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].last);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.best_limit_time'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_time_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].time){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].time);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.best_limit_theo'), function() {
					//console.log( this.id );
					var key = this.id.split("best_limit_theo_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].theo){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].theo);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				//futures_contracts
				$.each($('.futures_contracts_underlying'), function() {
					//console.log( this.id );
					var key = this.id.split("futures_contracts_underlying_")[1]; 
					if($('#'+this.id).html()!=data.futures_contracts[key].underlying){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.futures_contracts[key].underlying);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				
				
				$.each($('.futures_contracts_bid'), function() {
					//console.log( this.id );
					var key = this.id.split("futures_contracts_bid_")[1]; 
					//console.log(key);
					if($('#'+this.id).html()!=data.futures_contracts[key].bid){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_red');
							if(data.futures_contracts[key].bid!='' && data.futures_contracts[key].bid!='-') $('#'+this.id).addClass('bg_color_red');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.futures_contracts[key].bid);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.futures_contracts_ask'), function() {
					//console.log( this.id );
					var key = this.id.split("futures_contracts_ask_")[1]; 
					//console.log(key);
					if($('#'+this.id).html()!=data.futures_contracts[key].ask){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_green');
							if(data.futures_contracts[key].ask !='' && data.futures_contracts[key].ask !='-') $('#'+this.id).addClass('bg_color_green');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.futures_contracts[key].ask);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.futures_contracts_last'), function() {
					//console.log( this.id );
					var key = this.id.split("futures_contracts_last_")[1]; 
					if($('#'+this.id).html()!=data.futures_contracts[key].last){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_grey');
							if(data.futures_contracts[key].last !='' && data.futures_contracts[key].last !='-') $('#'+this.id).addClass('bg_color_grey');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.futures_contracts[key].last);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.futures_contracts_var'), function() {
					//console.log( this.id );
					var key = this.id.split("futures_contracts_var_")[1]; 
					if($('#'+this.id).html()!=data.futures_contracts[key].var){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.futures_contracts[key].var);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				// option contracts
				
				$.each($('.option_contracts_bid'), function() {
					//console.log( this.id );
					var key = this.id.split("option_contracts_bid_")[1]; 
					//console.log(key);
					if($('#'+this.id).html()!=data.option_contracts[key].bid){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_red');
							if(data.option_contracts[key].bid!='' && data.option_contracts[key].bid!='-') $('#'+this.id).addClass('bg_color_red');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_contracts[key].bid);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.option_contracts_ask'), function() {
					//console.log( this.id );
					var key = this.id.split("option_contracts_ask_")[1]; 
					//console.log(key);
					if($('#'+this.id).html()!=data.option_contracts[key].ask){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_green');
							if(data.option_contracts[key].ask!='' && data.option_contracts[key].ask!='-') $('#'+this.id).addClass('bg_color_green');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_contracts[key].ask);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.option_contracts_last'), function() {
					//console.log( this.id );
					var key = this.id.split("option_contracts_last_")[1]; 
					//console.log(key);
					if($('#'+this.id).html()!=data.option_contracts[key].last){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_red');
							if(data.option_contracts[key].last!='') $('#'+this.id).addClass('bg_color_red');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_contracts[key].last);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.option_contracts_var'), function() {
					//console.log( this.id );
					var key = this.id.split("option_contracts_var_")[1]; 
					//console.log(key);
					if($('#'+this.id).html()!=data.option_contracts[key].var){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_red');
							if(data.option_contracts[key].var!='') $('#'+this.id).addClass('bg_color_red');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_contracts[key].var);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				
				
				//trades
				$.each($('.trades_expiry'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_expiry_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].expiry){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].expiry);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.trades_last'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_last_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].last){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].last);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				$.each($('.trades_change'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_change_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].change){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].change);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.trades_var'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_var_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].var){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].var);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.trades_volume'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_volume_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].volume){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].volume);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.trades_dvolume'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_dvolume_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].dvolume){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].dvolume);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.trades_oi'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_oi_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].oi){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].oi);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.trades_settle'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_settle_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].settle){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].settle);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				$.each($('.trades_psettle'), function() {
					//console.log( this.id );
					var key = this.id.split("trades_psettle_")[1]; 
					if($('#'+this.id).html()!=data.best_limit[key].psettle){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.best_limit[key].psettle);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
				});
				
				
				if($('#avg_buy').html()!=data.avg_buy){
					$('#avg_buy').fadeOut('slow', function() {
					
						$('#avg_buy').html(data.avg_buy);
							$('#avg_buy').fadeIn('slow');
					});
				}
				if($('#avg_sell').html()!=data.avg_sell){
					$('#avg_sell').fadeOut('slow', function() {
					
						$('#avg_sell').html(data.avg_sell);
							$('#avg_sell').fadeIn('slow');
					});
				}
				
				if($('.order_bid').html()!=data.dashboard_future.bid){
					$('.order_bid').fadeOut('slow', function() {
						$('.order_bid').html(data.dashboard_future.bid);
							$('.order_bid').fadeIn('slow');
					});
				}
				if($('.order_ask').html()!=data.dashboard_future.ask){
					$('.order_ask').fadeOut('slow', function() {

						$('.order_ask').html(data.dashboard_future.ask);
							$('.order_ask').fadeIn('slow');
					});
				}
				if($('.order_qask').html()!=data.dashboard_future.qask){
					$('.order_qask').fadeOut('slow', function() {
						$('.order_qask').effect("highlight", {color: '#4c87b9'}, 300);
						$('.order_qask').html(data.dashboard_future.qask);
							$('.order_qask').fadeIn('slow');
					});
				}
				if($('.order_qbid').html()!=data.dashboard_future.qbid){
					$('.order_qbid').fadeOut('slow', function() {
						$('.order_qbid').effect("highlight", {color: '#4c87b9'}, 300);
						$('.order_qbid').html(data.dashboard_future.qbid);
							$('.order_qbid').fadeIn('slow');
					});
				}
				if($('.order_maxspd').html()!=data.order_maxspd){
					$('.order_maxspd').fadeOut('slow', function() {
						$('.order_maxspd').effect("highlight", {color: '#4c87b9'}, 300);
						$('.order_maxspd').html(data.order_maxspd);
							$('.order_maxspd').fadeIn('slow');
					});
				}
				if(data.page_options=='1'){
				//option best limit
					$.each($('.option_best_limit_expiry'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_expiry_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].expiry){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].expiry);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_strike'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_strike_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].strike){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].strike);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_qbid'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_qbid_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].qbid){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].qbid);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_bid'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_bid_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].bid){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_red');
							if(data.option_best_limit[key].bid!='') $('#'+this.id).addClass('bg_color_red');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].bid);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_ask'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_ask_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].ask){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).removeClass('bg_color_green');
							if(data.option_best_limit[key].ask!='') $('#'+this.id).addClass('bg_color_green');
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].ask);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_qask'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_qask_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].qask){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].qask);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_last'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_last_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].last){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].last);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_time'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_time_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].time){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].time);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_implied'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_implied_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].theo){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].theo);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_change'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_change_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].change){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].change);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_var'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_var_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].var){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].var);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_volume'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_volume_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].volume){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].volume);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_dvolume'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_dvolume_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].dvolume){
						$('#'+this.id).fadeOut('slow', function() {
							$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
							$('#'+this.id).html(data.option_best_limit[key].dvolume);
								$('#'+this.id).fadeIn('slow');
						});
						
					}
					});
					$.each($('.option_best_limit_oi'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_oi_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].oi){
							$('#'+this.id).fadeOut('slow', function() {
								$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
								$('#'+this.id).html(data.option_best_limit[key].oi);
									$('#'+this.id).fadeIn('slow');
							});
							
						}
					});
					$.each($('.option_best_limit_settle'), function() {
						//console.log( this.id );
						var key = this.id.split("option_best_limit_settle_")[1]; 
						if($('#'+this.id).html()!=data.option_best_limit[key].settle){
							$('#'+this.id).fadeOut('slow', function() {
								$('#'+this.id).effect("highlight", {color: '#4c87b9'}, 300);
								$('#'+this.id).html(data.option_best_limit[key].settle);
									$('#'+this.id).fadeIn('slow');
							});
							
						}
					});
					//option order
					if($('.option_order_qbid').html()!=data.option_order.qbid){
						$('.option_order_qbid').fadeOut('slow', function() {
							
							$('.option_order_qbid').html(data.option_order.qbid);
							$('.option_order_qbid').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_qbid').fadeIn('slow');
						});
					}
					if($('.option_order_bid').html()!=data.option_order.bid){
						$('.option_order_bid').fadeOut('slow', function() {
							
							$('.option_order_bid').html(data.option_order.bid);
							$('.option_order_bid').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_bid').fadeIn('slow');
						});
					}
					if($('.option_order_ask').html()!=data.option_order.ask){
						$('.option_order_ask').fadeOut('slow', function() {
							
							$('.option_order_ask').html(data.option_order.ask);
							$('.option_order_ask').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_ask').fadeIn('slow');
						});
					}
					if($('.option_order_qask').html()!=data.option_order.qask){
						$('.option_order_qask').fadeOut('slow', function() {
							
							$('.option_order_qask').html(data.option_order.qask);
							$('.option_order_qask').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_qask').fadeIn('slow');
						});
					}
					if($('.option_order_sum_b_option').html()!=data.option_order.sum_b_option){
						$('.option_order_sum_b_option').fadeOut('slow', function() {
							
							$('.option_order_sum_b_option').html(data.option_order.sum_b_option);
							$('.option_order_sum_b_option').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_sum_b_option').fadeIn('slow');
						});
					}
					if($('.option_order_avg_b_option').html()!=data.option_order.avg_b_option){
						$('.option_order_avg_b_option').fadeOut('slow', function() {
							
							$('.option_order_avg_b_option').html(data.option_order.avg_b_option);
							$('.option_order_avg_b_option').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_avg_b_option').fadeIn('slow');
						});
					}
					if($('.option_order_avg_b_option').html()!=data.option_order.avg_b_option){
						$('.option_order_avg_b_option').fadeOut('slow', function() {
							
							$('.option_order_avg_b_option').html(data.option_order.avg_b_option);
							$('.option_order_avg_b_option').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_avg_b_option').fadeIn('slow');
						});
					}
					if($('.option_order_options_maxspd').html()!=data.option_order.options_maxspd){
						$('.option_order_options_maxspd').fadeOut('slow', function() {
							
							$('.option_order_options_maxspd').html(data.option_order.options_maxspd);
							$('.option_order_options_maxspd').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_options_maxspd').fadeIn('slow');
						});
					}
					if($('.option_order_avg_s_option').html()!=data.option_order.avg_s_option){
						$('.option_order_avg_s_option').fadeOut('slow', function() {
							
							$('.option_order_avg_s_option').html(data.option_order.avg_s_option);
							$('.option_order_avg_s_option').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_avg_s_option').fadeIn('slow');
						});
					}
					if($('.option_order_sum_s_option').html()!=data.option_order.sum_s_option){
						$('.option_order_sum_s_option').fadeOut('slow', function() {
							
							$('.option_order_sum_s_option').html(data.option_order.sum_s_option);
							$('.option_order_sum_s_option').effect("highlight", {color: '#4c87b9'}, 300);
							$('.option_order_sum_s_option').fadeIn('slow');
						});
					}
				}
				/*if($('#portfolio_value').html()!=data.portfolio.value[0].name){
					$('#portfolio_value').fadeOut('slow', function() {
						$('#portfolio_value').html(data.portfolio.value[0].name);
							$('#portfolio_value').fadeIn('slow');
					});
				}
				if($('#portfolio_change').html()!=data.portfolio.change[0].name){
					$('#portfolio_change').fadeOut('slow', function() {
						$('#portfolio_change').html(data.portfolio.change[0].name);
							$('#portfolio_change').fadeIn('slow');
					});
				}
				if($('#portfolio_var').html()!=data.portfolio.var[0].name){
					$('#portfolio_var').fadeOut('slow', function() {
						$('#portfolio_var').html(data.portfolio.var[0].name);
							$('#portfolio_var').fadeIn('slow');
					});
				}
				*/
				
				
			}
		});
	}, 1700);
	
	
	
	
	
	
	
	
	
	
	var log = function(settings, response) {
					var s = [],
						str;
					s.push(settings.type.toUpperCase() + ' url = "' + settings.url + '"');
					for (var a in settings.data) {
						if (settings.data[a] && typeof settings.data[a] === 'object') {
							str = [];
							for (var j in settings.data[a]) {
								str.push(j + ': "' + settings.data[a][j] + '"');
							}
							str = '{ ' + str.join(', ') + ' }';
						} else {
							str = '"' + settings.data[a] + '"';
						}
						s.push(a + ' = ' + str);
					}
					s.push('RESPONSE: status = ' + response.status);
			
					if (response.responseText) {
						if ($.isArray(response.responseText)) {
							s.push('[');
							$.each(response.responseText, function(i, v) {
								s.push('{value: ' + v.value + ', text: "' + v.text + '"}');
							});
							s.push(']');
						} else {
							s.push($.trim(response.responseText));
						}
					}
					s.push('--------------------------------------\n');
					$('#console').val(s.join('\n') + $('#console').val());
				}
					 var initAjaxMock = function() {
						//ajax mocks
				
						$.mockjax({
							url: '/post',
							response: function(settings) {
								log(settings, this);
							}
						});
				
						$.mockjax({
							url: '/error',
							status: 400,
							statusText: 'Bad Request',
							response: function(settings) {
								this.responseText = 'Please input correct value';
								log(settings, this);
							}
						});
				
						$.mockjax({
							url: '/status',
							status: 500,
							response: function(settings) {
								this.responseText = 'Internal Server Error';
								log(settings, this);
							}
						});
				
						$.mockjax({
							url: '/groups',
							response: function(settings) {
								this.responseText = [{
									value: 0,
									text: 'Limit'
								}, {
									value: 1,
									text: 'Market'
								}];
								log(settings, this);
							}
						});
				
					}
					var initEditables = function() {

						//set editable mode based on URL parameter
						if (App.getURLParameter('mode') == 'inline') {
							$.fn.editable.defaults.mode = 'inline';
							$('#inline').attr("checked", true);
						} else {
							$('#inline').attr("checked", false);
						}
				
						//global settings 
						$.fn.editable.defaults.inputclass = 'form-control';
						$.fn.editable.defaults.url = '/post';
				
						//editables element samples 
						$('#lots').editable({
							url: '/post',
							type: 'text',
							pk: 1,
							name: 'lots',
							title: 'Enter Lots'
						});
				
						$('#firstname').editable({
							validate: function(value) {
								if ($.trim(value) == '') return 'This field is required';
							}
						});
				
						$('#sex').editable({
							prepend: "not selected",
							inputclass: 'form-control',
							source: [{
								value: 1,
								text: 'Male'
							}, {
								value: 2,
								text: 'Female'
							}],
							display: function(value, sourceData) {
								var colors = {
										"": "gray",
										1: "green",
										2: "blue"
									},
									elem = $.grep(sourceData, function(o) {
										return o.value == value;
									});
				
								if (elem.length) {
									$(this).text(elem[0].text).css("color", colors[value]);
								} else {
									$(this).empty();
								}
							}
						});
				
						$('#status').editable();
				
						$('#group').editable({
							showbuttons: false
						});
				
						$('#vacation').editable({
							rtl: App.isRTL()
						});
				
						$('#dob').editable({
							inputclass: 'form-control',
						});
				
						$('#event').editable({
							placement: (App.isRTL() ? 'left' : 'right'),
							combodate: {
								firstItem: 'name'
							}
						});
				
						$('#meeting_start').editable({
							format: 'yyyy-mm-dd hh:ii',
							viewformat: 'dd/mm/yyyy hh:ii',
							validate: function(v) {
								if (v && v.getDate() == 10) return 'Day cant be 10!';
							},
							datetimepicker: {
								rtl: App.isRTL(),
								todayBtn: 'linked',
								weekStart: 1
							}
						});
				
						$('#comments').editable({
							showbuttons: 'bottom'
						});
				
						$('#note').editable({
							showbuttons: (App.isRTL() ? 'left' : 'right')
						});
				
						$('#pencil').click(function(e) {
							e.stopPropagation();
							e.preventDefault();
							$('#note').editable('toggle');
						});
				
						$('#state').editable({
							source: ["Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Dakota", "North Carolina", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"]
						});
				
						$('#fruits').editable({
							pk: 1,
							limit: 3,
							source: [{
								value: 1,
								text: 'banana'
							}, {
								value: 2,
								text: 'peach'
							}, {
								value: 3,
								text: 'apple'
							}, {
								value: 4,
								text: 'watermelon'
							}, {
								value: 5,
								text: 'orange'
							}]
						});
				
						$('#fruits').on('shown', function(e, reason) {
							
						});
				
						$('#tags').editable({
							inputclass: 'form-control input-medium',
							select2: {
								data: ['html', 'javascript', 'css', 'ajax'],
								tags: true,
								tokenSeparators: [','], 
								multiple: true
							}
						});
				
						var countries = [];
						$.each({
							"BD": "Bangladesh",
							"BE": "Belgium",
							"BF": "Burkina Faso",
							"BG": "Bulgaria",
							"BA": "Bosnia and Herzegovina",
							"BB": "Barbados",
							"WF": "Wallis and Futuna",
							"BL": "Saint Bartelemey",
							"BM": "Bermuda",
							"BN": "Brunei Darussalam",
							"BO": "Bolivia",
							"BH": "Bahrain",
							"BI": "Burundi",
							"BJ": "Benin",
							"BT": "Bhutan",
							"JM": "Jamaica",
							"BV": "Bouvet Island",
							"BW": "Botswana",
							"WS": "Samoa",
							"BR": "Brazil",
							"BS": "Bahamas",
							"JE": "Jersey",
							"BY": "Belarus",
							"O1": "Other Country",
							"LV": "Latvia",
							"RW": "Rwanda",
							"RS": "Serbia",
							"TL": "Timor-Leste",
							"RE": "Reunion",
							"LU": "Luxembourg",
							"TJ": "Tajikistan",
							"RO": "Romania",
							"PG": "Papua New Guinea",
							"GW": "Guinea-Bissau",
							"GU": "Guam",
							"GT": "Guatemala",
							"GS": "South Georgia and the South Sandwich Islands",
							"GR": "Greece",
							"GQ": "Equatorial Guinea",
							"GP": "Guadeloupe",
							"JP": "Japan",
							"GY": "Guyana",
							"GG": "Guernsey",
							"GF": "French Guiana",
							"GE": "Georgia",
							"GD": "Grenada",
							"GB": "United Kingdom",
							"GA": "Gabon",
							"SV": "El Salvador",
							"GN": "Guinea",
							"GM": "Gambia",
							"GL": "Greenland",
							"GI": "Gibraltar",
							"GH": "Ghana",
							"OM": "Oman",
							"TN": "Tunisia",
							"JO": "Jordan",
							"HR": "Croatia",
							"HT": "Haiti",
							"HU": "Hungary",
							"HK": "Hong Kong",
							"HN": "Honduras",
							"HM": "Heard Island and McDonald Islands",
							"VE": "Venezuela",
							"PR": "Puerto Rico",
							"PS": "Palestinian Territory",
							"PW": "Palau",
							"PT": "Portugal",
							"SJ": "Svalbard and Jan Mayen",
							"PY": "Paraguay",
							"IQ": "Iraq",
							"PA": "Panama",
							"PF": "French Polynesia",
							"BZ": "Belize",
							"PE": "Peru",
							"PK": "Pakistan",
							"PH": "Philippines",
							"PN": "Pitcairn",
							"TM": "Turkmenistan",
							"PL": "Poland",
							"PM": "Saint Pierre and Miquelon",
							"ZM": "Zambia",
							"EH": "Western Sahara",
							"RU": "Russian Federation",
							"EE": "Estonia",
							"EG": "Egypt",
							"TK": "Tokelau",
							"ZA": "South Africa",
							"EC": "Ecuador",
							"IT": "Italy",
							"VN": "Vietnam",
							"SB": "Solomon Islands",
							"EU": "Europe",
							"ET": "Ethiopia",
							"SO": "Somalia",
							"ZW": "Zimbabwe",
							"SA": "Saudi Arabia",
							"ES": "Spain",
							"ER": "Eritrea",
							"ME": "Montenegro",
							"MD": "Moldova, Republic of",
							"MG": "Madagascar",
							"MF": "Saint Martin",
							"MA": "Morocco",
							"MC": "Monaco",
							"UZ": "Uzbekistan",
							"MM": "Myanmar",
							"ML": "Mali",
							"MO": "Macao",
							"MN": "Mongolia",
							"MH": "Marshall Islands",
							"MK": "Macedonia",
							"MU": "Mauritius",
							"MT": "Malta",
							"MW": "Malawi",
							"MV": "Maldives",
							"MQ": "Martinique",
							"MP": "Northern Mariana Islands",
							"MS": "Montserrat",
							"MR": "Mauritania",
							"IM": "Isle of Man",
							"UG": "Uganda",
							"TZ": "Tanzania, United Republic of",
							"MY": "Malaysia",
							"MX": "Mexico",
							"IL": "Israel",
							"FR": "France",
							"IO": "British Indian Ocean Territory",
							"FX": "France, Metropolitan",
							"SH": "Saint Helena",
							"FI": "Finland",
							"FJ": "Fiji",
							"FK": "Falkland Islands (Malvinas)",
							"FM": "Micronesia, Federated States of",
							"FO": "Faroe Islands",
							"NI": "Nicaragua",
							"NL": "Netherlands",
							"NO": "Norway",
							"NA": "Namibia",
							"VU": "Vanuatu",
							"NC": "New Caledonia",
							"NE": "Niger",
							"NF": "Norfolk Island",
							"NG": "Nigeria",
							"NZ": "New Zealand",
							"NP": "Nepal",
							"NR": "Nauru",
							"NU": "Niue",
							"CK": "Cook Islands",
							"CI": "Cote d'Ivoire",
							"CH": "Switzerland",
							"CO": "Colombia",
							"CN": "China",
							"CM": "Cameroon",
							"CL": "Chile",
							"CC": "Cocos (Keeling) Islands",
							"CA": "Canada",
							"CG": "Congo",
							"CF": "Central African Republic",
							"CD": "Congo, The Democratic Republic of the",
							"CZ": "Czech Republic",
							"CY": "Cyprus",
							"CX": "Christmas Island",
							"CR": "Costa Rica",
							"CV": "Cape Verde",
							"CU": "Cuba",
							"SZ": "Swaziland",
							"SY": "Syrian Arab Republic",
							"KG": "Kyrgyzstan",
							"KE": "Kenya",
							"SR": "Suriname",
							"KI": "Kiribati",
							"KH": "Cambodia",
							"KN": "Saint Kitts and Nevis",
							"KM": "Comoros",
							"ST": "Sao Tome and Principe",
							"SK": "Slovakia",
							"KR": "Korea, Republic of",
							"SI": "Slovenia",
							"KP": "Korea, Democratic People's Republic of",
							"KW": "Kuwait",
							"SN": "Senegal",
							"SM": "San Marino",
							"SL": "Sierra Leone",
							"SC": "Seychelles",
							"KZ": "Kazakhstan",
							"KY": "Cayman Islands",
							"SG": "Singapore",
							"SE": "Sweden",
							"SD": "Sudan",
							"DO": "Dominican Republic",
							"DM": "Dominica",
							"DJ": "Djibouti",
							"DK": "Denmark",
							"VG": "Virgin Islands, British",
							"DE": "Germany",
							"YE": "Yemen",
							"DZ": "Algeria",
							"US": "United States",
							"UY": "Uruguay",
							"YT": "Mayotte",
							"UM": "United States Minor Outlying Islands",
							"LB": "Lebanon",
							"LC": "Saint Lucia",
							"LA": "Lao People's Democratic Republic",
							"TV": "Tuvalu",
							"TW": "Taiwan",
							"TT": "Trinidad and Tobago",
							"TR": "Turkey",
							"LK": "Sri Lanka",
							"LI": "Liechtenstein",
							"A1": "Anonymous Proxy",
							"TO": "Tonga",
							"LT": "Lithuania",
							"A2": "Satellite Provider",
							"LR": "Liberia",
							"LS": "Lesotho",
							"TH": "Thailand",
							"TF": "French Southern Territories",
							"TG": "Togo",
							"TD": "Chad",
							"TC": "Turks and Caicos Islands",
							"LY": "Libyan Arab Jamahiriya",
							"VA": "Holy See (Vatican City State)",
							"VC": "Saint Vincent and the Grenadines",
							"AE": "United Arab Emirates",
							"AD": "Andorra",
				
							"AG": "Antigua and Barbuda",
							"AF": "Afghanistan",
							"AI": "Anguilla",
							"VI": "Virgin Islands, U.S.",
							"IS": "Iceland",
							"IR": "Iran, Islamic Republic of",
							"AM": "Armenia",
							"AL": "Albania",
							"AO": "Angola",
							"AN": "Netherlands Antilles",
							"AQ": "Antarctica",
							"AP": "Asia/Pacific Region",
							"AS": "American Samoa",
							"AR": "Argentina",
							"AU": "Australia",
							"AT": "Austria",
							"AW": "Aruba",
							"IN": "India",
							"AX": "Aland Islands",
							"AZ": "Azerbaijan",
							"IE": "Ireland",
							"ID": "Indonesia",
							"UA": "Ukraine",
							"QA": "Qatar",
							"MZ": "Mozambique"
						}, function(k, v) {
							countries.push({
								id: k,
								text: v
							});
						});
				
						$('#country').editable({
							inputclass: 'form-control input-medium',
							source: countries
						});
				
						$('#address').editable({
							url: '/post',
							value: {
								city: "San Francisco",
								street: "Valencia",
								building: "#24"
							},
							validate: function(value) {
								if (value.city == '') return 'city is required!';
							},
							display: function(value) {
								if (!value) {
									$(this).empty();
									return;
								}
								var html = '<b>' + $('<div>').text(value.city).html() + '</b>, ' + $('<div>').text(value.street).html() + ' st., bld. ' + $('<div>').text(value.building).html();
								$(this).html(html);
							}
						});
					}
					 initAjaxMock();

            // init editable elements
            		initEditables();
	
	
	$('#login_modal').click(function(){
      //  var $this = $(event.currentTarget);
        $.ajax({
            url: $base_url + "login/login_modal",
            type: "POST",
            async: false,
            success: function(response) {
                $("#login_modals .modal-content").html(response);
                $('body').addClass("login"); // fix bug when inline picker is used in modal    
            }
        });
        $('#LoginProcess').click(function(){
           var datastring = 'username='+$("#username").val()+'&password='+$("#password").val() +'&remember='+$('#remember').val()+'&login=1&token='+$('#token').val();//  
            $.ajax({
                type: "POST",
                url: $base_url + "user-manage/login_vndmi.php",
                dataType: "json",
                data: datastring,
                success: function(output) {
					//console.log(output);
					//return false;
                  var obj = output;
                    if(obj.status){               
                      $('#login_modals').modal('hide');
					   $href = $(location).attr('href');
					   $(location).attr('href',$href);
                    }else{
                      $('span.alert_msg').html(obj.message);
					  $("#login_alert").removeAttr('style');
                    }
    
                }
            });
        });    
    });
	
	
	
	
	
	
	
	
	
	
	$('#LoginProcess').click(function(){
           var datastring = 'username='+$("#username").val()+'&password='+$("#password").val() +'&remember='+$('#remember').val()+'&login=1&token='+$('#token').val();//  
            $.ajax({
                type: "POST",
                url: $base_url + "user-manage/login_vndmi.php",
                dataType: "json",
                data: datastring,
                success: function(output) {
					//console.log(output);
					//return false;
                  var obj = output;
                    if(obj.status){               
                      $('#login_modals').modal('hide');
					   $href = $(location).attr('href');
					   $(location).attr('href',$href);
                    }else{
                      $('span.alert_msg').html(obj.message);
					  $("#login_alert").removeAttr('style');
                    }
    
                }
            });
        }); 
		
		
		
		
		
		
		
		
		
		
		  
	
	$('#logout_modal').click(function(){    
		$.ajax({
			type: "POST",
			url: $base_url + "user-manage/logout_2.php",
			dataType: "json",
			success: function(output) {
			  $href = $(location).attr('href');
			  $(location).attr('href',$href);
              window.location.href = $base_url;  
			}
		});
	});
	
	
	
	
	
	
	
	
	
	$('.switch-language').click(function(event) {
		var $this = $(event.currentTarget);
        var langcode = $(this).attr('langcode');
        $.ajax({
            url: $base_url + 'ajax/change_language',
            type: 'POST',
            async: false,
            data: {langcode: langcode},
            success: function() {
                window.location.reload();
				//$('.switch-language').children().css('opacity','0.5');
				//$this.children().css('opacity','1');
                return false;
            }
        });
    });
	
	
	
	
	
	
    
	//
	
	$(".sub-apso2").click(function(){
		$('.filter-submit').click();	
	});
    $(".filter-cancel").click(function(){
        var pathname = window.location.pathname; // Returns path only
        var url      = window.location.href; 
        abc = url.split('?');
        if(typeof abc[1] != 'undefined'){
            window.location.href = pathname;
        }	
	});
	
	
	
	
	
    
	$(".remove-image-profile").click(function(event){
		    var attr = $("#img").attr('src');
                $.ajax({
					url: $base_url + 'ajax/deleteImage',
					type: 'POST',
					data: {attr: attr},
					async: false,
					success: function(response) {
						//console.log(response);
					   if((response == true) || response) {
                          bootbox.alert("Delete image success!");  
						  //location.reload();                        
                        } else {
                            bootbox.alert("Delete fail!");   
                        }
         					
					}
			});
                
		
	});	
	
	
	
	
	
	
	
	$(".delete_image").click(function(event){
		    var attr = $("#img").attr('src');
                $.ajax({
					url: $base_url + 'ajax/deleteImage_intranet',
					type: 'POST',
					data: {attr: attr},
					async: false,
					success: function(response) {
						//console.log(response);
					   if((response == true) || response) {
                          bootbox.alert("Delete image success!");  
						  //location.reload();                        
                        } else {
                            bootbox.alert("Delete fail!");   
                        }
         					
					}
			});
                
		
	});	
	
	
	
	
	
	
	$(".delete_file").click(function(event){
		    var attr = $("#fil").attr('src');
                $.ajax({
					url: $base_url + 'ajax/deleteFile',
					type: 'POST',
					data: {attr: attr},
					async: false,
					success: function(response) {
						//console.log(response);
					   if((response == true) || response) {
						   $(".name_file").remove();
                          bootbox.alert("Delete file success!");  
						  //location.reload();                        
                        } else {
                            bootbox.alert("Delete fail!");   
                        }
         					
					}
			});
                
		
	});
	
	
	
	
	$(".delete_file_intranet").click(function(event){
		    var attr = $("#fil").attr('src');
                $.ajax({
					url: $base_url + 'ajax/deleteFile_intranet',
					type: 'POST',
					data: {attr: attr},
					async: false,
					success: function(response) {
						//console.log(response);
					   if((response == true) || response) {
						  $(".name_file").remove();
                          bootbox.alert("Delete file success!");  
						  //location.reload();                        
                        } else {
                            bootbox.alert("Delete fail!");   
                        }
         					
					}
			});
                
		
	});	
	
	
	
	
  
	$(".add-articles-order").click(function(){
		 
		 var clean_artid = $("#clean_artid").val();
		 var lang_code = $("#lang_code").val();
		 var clean_cat = $("#clean_cat").val();
		 var clean_scat = $("#clean_scat").val();
		
	     var title = $("#title").val();	
		 var website = $("#website").val();
		 var clean_order = $("#clean_order").val();
		 var status = $("#status").val();
		 var html_description = $("#html_description").val();
		 var html_long_description = $("#html_long_description").val();
		 var date_creation_start = $("#date_creation_start").val();
		 var date_creation_end = $("#date_creation_end").val();
		 var dataArr = [clean_artid,lang_code,clean_cat,clean_scat,title,website,clean_order,status,html_description,html_long_description,date_creation_start,date_creation_end];
		  $.ajax({
            url: $base_url + 'ajax/add_modal_vnxindex',
            type: 'POST',
            async: false,
            data: {dataArr: dataArr},
            success: function(respon){ 
                if(respon=='true'){
                    bootbox.alert("Update success !");
                }
            }
        });
		  //alert(dataArr);
	});
	
	
	
	
	
	
	$(".add-new-item").click(function(event){
		  event.preventDefault();
		  var $this = $(event.currentTarget);
		  $('#website').append($('<option/>', { 
			value: $("#website_add_new").val(),
			text : $("#website_add_new").val() 
		   }));
		   //var selectList = $('.select2_'+$id+' > option');
		  var selectList = $('#website'+' > option');
		 
		
		  selectList.sort(function(a,b){
		   a = a.value;
		   b = b.value;
		   return a == b ? 0 : (a < b ? -1 : 1);    
		  });
		  
		  $('#website').html(selectList);
		  $('#website').val($('#website_add_new').val());
		  $("#website_add_new").val('');
	 });
	 
	 
	 
	 
	 
	 
	 
	 $(".add-new-web").click(function(event){
		  event.preventDefault();
		  var list_web = $(".checked").find("[name='category_web']").map(function () {
				  return this.value;
			}).get();
		  var list = list_web.toString();
		  /*$('input:checkbox:checked.category_web').map(function () {
				  return this.value;
			}).get();*/
		  var $this = $(event.currentTarget);
		  $('#website').append($('<option/>', { 
			value: list,
			text : list 
		   }));
		   //var selectList = $('.select2_'+$id+' > option');
		  var selectList = $('#website'+' > option');
		
		  selectList.sort(function(a,b){
		   a = a.value;
		   b = b.value;
		   return a == b ? 0 : (a < b ? -1 : 1);    
		  });
		  
		  $('#website').html(selectList);
		  $('#website').val(list);
		  $('.modal').modal('hide');
	 });
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 $(".addrows").click(function(){
		 var data = $(".addweb").val();
		
		 if(data == ''){
			bootbox.alert("Data empty !");	
			return false; 
		}
		$.ajax({
            url: $base_url + 'ajax/check_website',
            type: 'POST',
            async: false,
            data: {data: data},
            success: function(respon){
                if(respon=='true'){
                    bootbox.alert("Website have exists!");
                }
				else{
					
					$.ajax({
						url: $base_url + 'ajax/update_int_article_websites',
						type: 'POST',
						async: false,
						data: {data: data},
						success: function(respon){
							var name = $(".addweb").val();
							var cut_name = name.replace(" ","");
							var cut_name = cut_name.replace(".","");
						var content = '<li><div class="portlet light" style="margin-bottom:5px; padding:12px 20px 1px;"><div class="portlet-title" style="min-height:32px;"><label class="hasborder"><span><input class="getcheck" style="width:27px;" type="checkbox" name="category_web" id ="check_'+cut_name+'" value="'+name+'"></span>'+name+'</label><div class="tools" style="padding:0px;"><a title="Delete" data-original-title="Delete" id="'+name+'" class="remove remove_website_name" href=""></a></div></li>';
							$("#unstyled").append(content);
							$(".getcheck").each(function() {
								//console.log($(this).attr('id'));
								$("#"+$(this).attr('id')).change(function() {
								if(this.checked) {
									$("#"+$(this).attr('id')).parent().addClass('checked');
									//console.log('true');
								}
								else{
									$("#"+$(this).attr('id')).parent().removeClass('checked');
									//console.log('false');	
								}
							});
							});
							$(".addweb").val('');
							
						}
					});	
				}
            }
        });
		 
		 
	});
	
	
	
	
	
	
	
	
	$("#checkall").click(function(){
			if(this.checked) {
				$(".checker").children().addClass('checked');
				//console.log('true');
			}
			else{
				$(".checker").children().removeClass('checked');	
			}
	});
	
	
	
	
	 
	/* $(".addrows").one("click",function(){
		 var data = $(".addweb").val();
		 if(data == ''){
			bootbox.alert("Data empty !");	
			return false; 
		}
		 $.ajax({
            url: $base_url + 'ajax/update_int_article_websites',
            type: 'POST',
            async: false,
            data: {data: data},
            success: function(respon){
					int_article_website = jQuery.parseJSON(respon);
					var html_str = '';
					$.each(int_article_website, function( key, value ){
							html_str += '<li><label><input type="checkbox" name="category_web" value="'+ value.name +'">'+value.name+'</label></li>';
					});
					$("#unstyled").html(html_str);
					location.reload();
				
                
            }
        });
		 
	});*/
	
	
	
	$(".update-new-web").click(function(event){
		  event.preventDefault();
		 
		  var list_web = $(".checked").find("[name='category_web']").map(function () {
				  return this.value;
			}).get();
		  var list = list_web.toString();
		  /*$('input:checkbox:checked.category_web').map(function () {
				  return this.value;
			}).get();*/
		  var $this = $(event.currentTarget);
		  $('#website').append($('<option/>', { 
			value: list,
			text : list 
		   }));
		   //var selectList = $('.select2_'+$id+' > option');
		  var selectList = $('#website'+' > option');
		
		  selectList.sort(function(a,b){
		   a = a.value;
		   b = b.value;
		   return a == b ? 0 : (a < b ? -1 : 1);    
		  });
		  
		  $('#website').html(selectList);
		  $('#website').val(list);
		  $('.modal').modal('hide');
	 });
	 
	 
	 
	 
	 
	   $(".updaterows").click(function(){
		 var data = $(".addweb").val();
		 var str_web_check = $("#web_check").val();
		 str_web_check = str_web_check.split(",");
		 var arr_web_check =[];
		 $.each(str_web_check, function( key, value ){
			 arr_web_check.push(value.trim());
		 });
		 
		 if(data == ''){
			bootbox.alert("Data empty !");	
			return false; 
		}
		
		$.ajax({
            url: $base_url + 'ajax/check_website',
            type: 'POST',
            async: false,
            data: {data: data},
            success: function(respon){
                if(respon=='true'){
                    bootbox.alert("Website have exists!");
                }
				else{
					 $.ajax({
						url: $base_url + 'ajax/update_int_article_websites',
						type: 'POST',
						async: false,
						data: {data: data},
						success: function(respon){
								var name = $(".addweb").val();
								var cut_name = name.replace(" ","");
								var cut_name = cut_name.replace(".","");
							var content = '<li><div class="portlet light" style="margin-bottom:5px; padding:12px 20px 1px;"><div class="portlet-title" style="min-height:32px;"><label class="hasborder"><span><input class="getcheck" style="width:27px;" type="checkbox" name="category_web" id ="check_'+cut_name+'" value="'+name+'"></span>'+name+'</label><div class="tools" style="padding:0px;"><a title="Delete" data-original-title="Delete" id="'+name+'" class="remove remove_website_name" href=""></a></div></li>';
								$("#unstyled").append(content);
								$(".getcheck").each(function() {
									//console.log($(this).attr('id'));
									$("#"+$(this).attr('id')).change(function() {
									if(this.checked) {
										$("#"+$(this).attr('id')).parent().addClass('checked');
										//console.log('true');
									}
									else{
										$("#"+$(this).attr('id')).parent().removeClass('checked');
										//console.log('false');	
									}
								});
								});
								$(".addweb").val("");
								//location.reload();
							
							
						}
					});
				}
            }
        });
		 
	   
		   
		});
		
		
	 
	 
	  $(".add-new-scat").click(function(event){
		  event.preventDefault();
		  var $this = $(event.currentTarget);
		  $('#clean_scat').append($('<option/>', { 
			value: $("#scat_add_new").val(),
			text : $("#scat_add_new").val() 
		   }));
		   //var selectList = $('.select2_'+$id+' > option');
		  var selectList = $('#clean_scat'+' > option');
		 
		
		  selectList.sort(function(a,b){
		   a = a.value;
		   b = b.value;
		   return a == b ? 0 : (a < b ? -1 : 1);    
		  });
		  
		  $('#clean_scat').html(selectList);
		  $('#clean_scat').val($('#scat_add_new').val());
		  $("#scat_add_new").val('');
	 });
	 
	 
	 
	 
	 
	 
	 
	 $(".remove_website").click(function(){
			var id = $(this).attr('id');
			 $.ajax({
				url: $base_url + 'ajax/remove_website',
				type: 'POST',
				async: false,
				data: {id: id},
				success: function(respon){ 
					/*if(respon=='true'){
						bootbox.alert("Delete success !");
					}*/
				}
        	});
				 
	});
	
	$(".remove_website_name").click(function(){
			console.log('haha');
			var name = $(this).attr('id');
			 $.ajax({
				url: $base_url + 'ajax/remove_website_name',
				type: 'POST',
				async: false,
				data: {name: name},
				success: function(respon){ 
					if(respon=='true'){
						bootbox.alert("Delete success !");
					}
				}
        	});
				 
	});
	
	
	
    $("textarea").keyup(function(e) {
        if(e.keyCode == 13) //13 is the ASCII code for ENTER
        {
            var rowCount = $(this).attr("rows");
            $(this).attr({rows: rowCount + 5});
        }
    });
	 $('.thumb').live("mouseenter", function() {
        var html='<img class="show-thumb-hover" src="'+$(this).attr('src')+'" height="'+ $(this).attr("data-height")+'" />';
        $(this).parent().append(html);
        $('.show-thumb-hover').fadeIn('slow');
        $(this).parent().addClass('relative');
    }).live("mouseleave", function() {
        $('.show-thumb-hover').fadeOut('slow').remove();
        $(this).parent().removeClass('relative');
    });
	
    if (!jQuery().clockface) {
        return;
    }
    $('.clockface_1').clockface();
    $('#update_attendate').click(function(){
        var time_from = $('.clockface_1[name="from"]').val();
		var time_to = $('.clockface_1[name="to"]').val();
       // console.log(time_from+' - '+time_to);
        $.ajax({
            url: $base_url + 'ajax/update_time_attendate',
            type: 'POST',
            async: false,
            data: {time_from: time_from, time_to: time_to},
            success: function(respon){ 
                if(respon=='true'){
                    bootbox.alert("Update success !");
                }
            }
        });
    });
    if ($(window).width() < 1024) {
           $('.page-sidebar-menu').addClass('page-sidebar-menu-hover-submenu');
           $('.page-sidebar-menu').addClass('page-sidebar-menu-closed'); 
     }
    $('[data-toggle="tooltip"]').tooltip({html:true});
    if (!jQuery.fancybox) {
        return;
    }

    
//  if($login=='1'){
//        setInterval(function() {
//            checkUser();
//        }, 20000);
//    }
     // picker show input calendar don't remove
     if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
     }
	 
	 $("a.mmenu").click(function() {
        
        /*var id_menu = $(this).attr('id_menu');
		
        var parent = $(this).attr('parent');
		var category = $(this).attr('id');
        $(this).closest('ul').find('li.active').removeAttr('class');
        $(this).closest('li').addClass('active');
        $.ajax({
            url: $base_url + 'ajax/create_session_menu',
            type: 'POST',
            async: false,
            data: {id_menu: id_menu}
        });
		*/
     });
     
    
   
    $('#login_modal').click(function(){
      //  var $this = $(event.currentTarget);
        $.ajax({
            url: $base_url + "login/login_modal",
            type: "POST",
            async: false,
            success: function(response) {
                $("#login_modals .modal-content").html(response);
                $('body').addClass("login"); // fix bug when inline picker is used in modal    
            }
        });
        $('#LoginProcess').click(function(){
            var datastring = 'username='+$("#username").val()+'&password='+$("#password").val() +'&remember='+$('#remember').val()+'&login=1&token='+$('#token').val();//  +'&redirect_url='+$("#redirect_url").val();
            $.ajax({
                type: "POST",
                url: $base_url + "user-manage/login_manage.php",
                dataType: "json",
                data: datastring,
                success: function(output) {
                  var obj = output;
                    if(obj.status){               
                      $('#login_modals').modal('hide');
					   $href = 'start';//$(location).attr('href').replace(/^.*?(#|$)/,'');
					  // $(this).attr('href').replace(/^.*?(#|$)/,'');
					   $(location).attr('href',$href);
                    }else{
                      $('span.alert_msg').html(obj.message);
					  $("#login_alert").removeAttr('style');
                    }
    
                }
            });
        });    
    });
	
	
	
	
	
    $('#logout_modal').click(function(){          
		$.ajax({
			type: "POST",
			url: $base_url + "ajax/logout",
			dataType: "json",
			success: function(output) {
			  //$href = $(location).attr('href').replace(/^.*?(#|$)/,'');
			  //$href = $(location).attr('href').replace('/profile','');
			  $href = $base_url+ 'start';
			  $(location).attr('href',$href);     
			}
		});
	}); 
	
	
	
	
    $('.switch-language').click(function() {
        var langcode = $(this).attr('langcode');
        $.ajax({
            url: $base_url + 'ajax/change_language',
            type: 'POST',
            async: false,
            data: {langcode: langcode},
            success: function() {
                window.location.reload();
                return false;
            }
        });
    }); 
	
	
	
	
    $('.demo-loading-btn').click(function () {
      //  alert('1111111111111');
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
        btn.button('reset')
        }, 3000)
    });
	
	
    $('.button-sendcontact').click(function() {
        var contact_name = $('input[name=contact_name]').val();
        var contact_email = $('input[name=contact_email]').val();
        var contact_message = $('textarea[name=contact_message]').val();
        var email_receiving_email = $('input[name=email_receiving_email]').val();
       	var validate_code = $('input[name=contact_code]').val();
        if (contact_name == "" || contact_email == "" || contact_message == "")
        {
            $('p.contact_warning').html('<span style="color: #FF0000; display: block; margin-top: 10px;">Please enter the full input</span>');
            setTimeout(function() {
                $('p.contact_warning').html('')
            }, 3000);
        }
        else
        {
            if (checkmail(contact_email) == false)
            {
                $('p.contact_warning').html('<span style="color: #FF0000; display: block; margin-top: 10px;">Email incorrect formats</span>');
                setTimeout(function() {
                    $('p.contact_warning').html('')
                }, 3000);
            }
            else if (checkValidateCode(validate_code))
            {
                $('.contact_warning').html('<div class="alert alert-danger display-hide" style="display: block;"><button data-close="alert" class="close"></button>Please enter the valid number.</div>');
            }
            else
            {
                $('p.contact_warning').html('<span style="color: green; display: block; margin-top: 10px;">Sending email...</span>')
                $.ajax({
                    url: $base_url + 'contact/sendcontact',
                    type: 'post',
                    async: false,
                    data: {contact_name: contact_name, contact_email: contact_email, contact_message: contact_message, email_receiving_email: email_receiving_email},
                    success: function(data) {
                        if (data == 1)
                        {
                            $('p.contact_warning').html('<span style="color: green; display: block; margin-top: 10px;">Send email success</span>');
                            $('input[name=contact_name]').val('');
                            $('input[name=contact_email]').val('');
                            $('textarea[name=contact_message]').val('');
                        }
                        else
                        {
                            $('p.contact_warning').html('<span style="color: red; display: block; margin-top: 10px;">Send email not success</span>')
                        }
                    }
                });
            }
        }
    });
	
	
	
	$('#feedback_popup').click(function(){
		$('.feedback_warning').html('');
		$('input[name=feedback_name]').val('');
		$('input[name=feedback_email]').val('');
		$('textarea[name=feedback_message]').val('');
		$('input[name=feedback_code]').val('');
	});
	
	
	
	$('.button-sendfeedback').click(function() {
        var contact_name = $('input[name=feedback_name]').val();
        var contact_email = $('input[name=feedback_email]').val();
        var contact_message = $('textarea[name=feedback_message]').val();
        var email_receiving_email = $('input[name=feedback_receiving_email]').val();
		var validate_code = $('input[name=feedback_code]').val();
        if (contact_name == "" || contact_email == "" || contact_message == "")
        {
            $('.feedback_warning').html('<div class="alert alert-danger display-hide" style="display: block;"><button data-close="alert" class="close"></button>Please enter the full input</div>');
        }
        else
        {
            if (checkmail(contact_email) == false)
            {
                $('.feedback_warning').html('<div class="alert alert-danger display-hide" style="display: block;"><button data-close="alert" class="close"></button>Email incorrect formats</div>');
            }
			else if (checkValidateCode(validate_code))
            {
                $('.feedback_warning').html('<div class="alert alert-danger display-hide" style="display: block;"><button data-close="alert" class="close"></button>Please enter the valid number.</div>');
            }
            else
            {
                $('.feedback_warning').html('<div class="alert alert-danger display-hide" style="display: block;"><button data-close="alert" class="close"></button>Sending email...</div>')
                $.ajax({
                    url: $base_url + 'tab/sendfeedback',
                    type: 'post',
                    async: false,
                    data: {contact_name: contact_name, contact_email: contact_email, contact_message: contact_message, email_receiving_email: email_receiving_email, url_send:window.location.href},
                    success: function(data) {
                        if (data == 1)
                        {
                            $('.feedback_warning').html('<div class="alert alert-danger display-hide" style="display: block;"><button data-close="alert" class="close"></button>Send email success</div>');
                            $('input[name=feedback_name]').val('');
                            $('input[name=feedback_email]').val('');
                            $('textarea[name=feedback_message]').val('');
                        }
                        else
                        {
							 $('.feedback_warning').html('<div class="alert alert-danger display-hide" style="display: block;"><button data-close="alert" class="close"></button>Send email not success</div>');
                        }
                    }
                });
            }
        }
    });
	
	
	
    //wysihtml5();
    // $("#timer").flipcountdown({
    //   size:"xs"
    // }); 
    createTicker();
	
});

//function wysihtml5(){
//    if (!jQuery().wysihtml5) {
//        return;
//    }
//    if ($('.wysihtml5').size() > 0) {
//        $('.wysihtml5').wysihtml5({
//            "stylesheets": [$template_url+"global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
//        });
//    }
//};

function createTicker() {
    var tickerLIs = $(".breaking-news ul").children();
    tickerItems = new Array();
    tickerLIs.each(function(el) {
        tickerItems.push($(this).html());
    });
    i = 0;
    rotateTicker();
};

function rotateTicker() {
    if (i == tickerItems.length) {
        i = 0;
    }
    tickerText = tickerItems[i];
    c = 0;
    typetext();
    setTimeout("rotateTicker()", 5000);
    i++;
};

function typetext() {
    if (typeof tickerText !== "undefined") {
        var thisChar = tickerText.substr(c, 1);
        if (thisChar == '<') {
            isInTag = true;
        }
        if (thisChar == '>') {
            isInTag = false;
        }
        jQuery('.breaking-news ul').html(tickerText.substr(0, c++));
        if (c < tickerText.length + 1)
            if (isInTag) {
                typetext();
            } else {
                setTimeout("typetext()", 28);
            }
        else {
            c = 1;
            tickerText = "";
        }
    }
};
//function trans(word) {
//    var translate;
//	//translate =  $objec_translation[word];
//	if($objec_translation[word]||$objec_translation[word]===0){
//		translate = $objec_translation[word];
//	}
//	else {
//		translate = word;
//	}
//				
//    return translate;
//};
function checkmail(email) {
    var emailfilter = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
    var returnval = emailfilter.test(email)
    return returnval;
};
function checkValidateCode(code) {
	var returnval = true;
     $.ajax({
		url: $base_url + 'journals/checkCode',
		type: 'post',
		async: false,
		data: {validate_code: code},
		success: function(data) {
			if (data == 1) returnval = false; 
			else returnval = true; 
		}
	});
	return returnval;
};

function datatable() {
    var oTable = $("#sample_3").dataTable({
        "aoColumnDefs": [
            {"aTargets": [0]}
        ],
        "aaSorting": [[1, 'asc']],
        "aLengthMenu": [
            [5, 15, 20, -1],
            [5, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "iDisplayLength": 50,
        "bLengthChange": false
    });

    jQuery('#sample_3_wrapper .dataTables_filter input').addClass("m-wrap small"); // modify table search input
    jQuery('#sample_3_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
    jQuery('#sample_3_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

    $('#sample_3_column_toggler input[type="checkbox"]').change(function() {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var iCol = parseInt($(this).attr("data-column"));
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis(iCol, (bVis ? false : true));
    });
};

/* function that process and display data */
function checkUser() {
    $.ajax({
        url: $base_url + "ajax/checkupdate",
        async: false,
        success: function(response) {
//            $("#timer").html(response);
            obj = jQuery.parseJSON(response);
            $('#userList').html(obj);
        }
    });
};

function updateservice() {
    $.ajax({
        type: "POST",
        url: $base_url + "ajax/getPrice_realtime",
        dataType: "JSON",
        success: function(response) {
            var rs = response;
            //console.log(rs);
            $("#last_update").html("(" + rs[0].date + " | " + rs[0].time + ")");
            var value = parseFloat($("#idx_last").val());
            $("#idx_last").val(rs[0].idx_last);
            var new_value = parseFloat(rs[0].idx_last);
            if (new_value != value) {
                $("#sample_3 tr#6 td.strike").addClass("yellow");
                if (new_value - value > 0) {
                    $("#sample_3 tr#6 td.strike").removeClass("color-red").addClass("color-green");
                } else {
                    $("#sample_3 tr#6 td.strike").removeClass("color-green").addClass("color-red");
                }
                var strike = Math.round(new_value / 25) * 25;
                $("#sample_3 tr#5 td.strike").text(strike - (25 * 1));
                $("#sample_3 tr#4 td.strike").text(strike - (25 * 2));
                $("#sample_3 tr#3 td.strike").text(strike - (25 * 3));
                $("#sample_3 tr#2 td.strike").text(strike - (25 * 4));
                $("#sample_3 tr#1 td.strike").text(strike - (25 * 5));
                $("#sample_3 tr#6 td.strike").text(strike);
                $("#sample_3 tr#7 td.strike").text(strike + (25 * 1));
                $("#sample_3 tr#8 td.strike").text(strike + (25 * 2));
                $("#sample_3 tr#9 td.strike").text(strike + (25 * 3));
                $("#sample_3 tr#10 td.strike").text(strike + (25 * 4));
                $("#sample_3 tr#11 td.strike").text(strike + (25 * 5));
            }
            setTimeout(function() {
                $("#sample_3 tr#6 td.strike").removeClass("yellow");
            }, 800);
        }
    });
    t = setTimeout(function() {
        updateservice();
    }, 15000);
};

var serverdate = new Date();
var ore = serverdate.getHours();
var minute = serverdate.getMinutes();
var secunde = serverdate.getSeconds();

/* function that process and display data */
function timer() {
    $.ajax({
        url: $base_url + "welcome/timer",
        async: false,
        success: function(response) {
            $("#timer").html(response);
        }
    });
    t = setTimeout(function() {
        timer();
    }, 1000);
};
function thumb() {	

	xOffset = 10;
	yOffset = 30;
	$("img.thumb").hover(function(e){
		$("body").append("<p id='thumb'><img src='"+ $(this).attr("src") +"' height='"+ $(this).attr("data-height") + "' /></p>");								 
		$("#thumb")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");					
    }, function() {
		$("#thumb").remove();
    });

	$("img.thumb").mousemove(function(e){
		$("#thumb")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};

function GetClock(){
	var d=new Date();
	var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear(),nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;
	nmonth = nmonth + 1;
	nmonth = nmonth + "";
	if (nmonth.length == 1)
    {
        nmonth = "0" + nmonth;
    }
	ndate = ndate + "";
	if (ndate.length == 1)
    {
        ndate = "0" + ndate;
    }
	
	/*if(nhour==0){ap=" AM";nhour=12;}
	else if(nhour<12){ap=" AM";}
	else if(nhour==12){ap=" PM";}
	else if(nhour>12){ap=" PM";nhour-=12;}*/
	
	if(nyear<1000) nyear+=1900;
	if(nmin<=9) nmin="0"+nmin;
	if(nsec<=9) nsec="0"+nsec;
	
	document.getElementById('clockbox').innerHTML=""+nyear+"-"+nmonth+"-"+ndate+" "+nhour+":"+nmin+":"+nsec+"";
};
function repeatString(string, n) {
		var result = '', i;
	
		for (i = 1; i <= n; i *= 2) {
			if ((n & i) === i) {
				result += string;
			}
			string = string + string;
		}
	
		return result;
};
function GetClock(){
	var d=new Date();
	var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear(),nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;
	nmonth = nmonth + 1;
	nmonth = nmonth + "";
	if (nmonth.length == 1)
    {
        nmonth = "0" + nmonth;
    }
	ndate = ndate + "";
	if (ndate.length == 1)
    {
        ndate = "0" + ndate;
    }
	
	/*if(nhour==0){ap=" AM";nhour=12;}
	else if(nhour<12){ap=" AM";}
	else if(nhour==12){ap=" PM";}
	else if(nhour>12){ap=" PM";nhour-=12;}*/
	
	if(nyear<1000) nyear+=1900;
	if(nmin<=9) nmin="0"+nmin;
	if(nsec<=9) nsec="0"+nsec;
	
	document.getElementById('clockbox').innerHTML=""+nyear+"-"+nmonth+"-"+ndate+" "+nhour+":"+nmin+":"+nsec+"";
};  
function clearconsole() { 
  console.log(window.console);
  if(window.console || window.console.firebug) {
   console.clear();
  }
} 