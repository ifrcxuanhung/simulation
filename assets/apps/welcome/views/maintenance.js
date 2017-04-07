define([
    'jquery',
    'underscore',
    'backbone'
    ], function($, _, Backbone){
        var maintenanceView = Backbone.View.extend({
            el: $(".main-container"),
            initialize: function() {

            },
            events: {
                 "click .create_exc": "actionCreate_exc",
                 "click .re_create": "actionRecreate",
                 /*"click .update_exc": "actionUpdate_exc",
                 "click .clean_dashboard": "actionClean_dashboard",
                 "click .clean_contracts_setting": "actionClean_contracts_setting",
                 "click .clean_dashboard_option": "actionClean_dashboard_option",
				  "click .reset_market": "actionReset_market",*/
                 "click .update_intraday": "actionUpdate_intraday",
                
				 "click .reset_all": "actionReset_all"
                
            },
            actionReset_all: function(event){
				var $this = $(event.currentTarget);
				$.ajax({
					url: $base_url + "maintenance/reset_all",
					type:"POST",
					success: function(response){
						$(".date1").remove();
						$(".date2").remove();
						$(".date3").remove();
						$(".date4").remove();
						$(".date5").remove();
						$(".date6").remove();
					},	
				});
			},
            actionReset_market: function(event) {
                var $this = $(event.currentTarget);
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
            },  
            
             actionUpdate_intraday: function(event) {
                var $this = $(event.currentTarget);
				bootbox.confirm({
					message: "Are you sure update data intraday ?",
					callback: function(result){
						if(result == true){
						  $.ajax({
								url: $base_url + "maintenance/update_intraday",
								type: "POST",
								data: {},
								async: false,
								success: function(response) {
									 window.location.reload();
								}
							});	
						}	
					}
				}); 
            },  
            
            actionCreate_exc: function(event) {
            var $this = $(event.currentTarget);
            $('#modal_view_user2').modal('show');
            
            },
            actionRecreate: function(event) {
                var $this = $(event.currentTarget);
                     $.ajax({
						url: $base_url + "maintenance/create_contracts_setting",
						type: "POST",
						data: {date: $('#calculation_date').val()},
						async: false,
						success: function(response) {
                        	$('#modal_view_user2').modal('hide');
							
							$.ajax({ 
								url:$base_url + "maintenance/update_date_setting",
								type:"POST",
								data:{param:'CREATE_VDM_CONTRACTS_SETTING_EXC'},
								success: function(response2) {
									var rs = JSON.parse(response2);
									console.log(rs);
									$('.date_parent_1').html('<button class="btn blue date1" type="button">'+rs.value+'</button>');
								},
							
							});
							//console.log();
							//$('.date1').html('');
							
						}
					});   
            },
            
            actionUpdate_exc: function(event) {
                var $this = $(event.currentTarget);
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
            },  
            
            actionClean_dashboard: function(event) {
                var $this = $(event.currentTarget);
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
            },  

            actionClean_contracts_setting: function(event) {
                var $this = $(event.currentTarget);
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
              
            },  
            
            
            actionClean_dashboard_option: function(event) {
                var $this = $(event.currentTarget);
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
              
            },  
            
            
            index: function(){
                $(document).ready(function(){
                    
                });
            },
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
            }
        });
    return new maintenanceView;
});