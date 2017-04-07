define([
    'jquery',
    'underscore',
    'backbone'
    ], function($, _, Backbone){
        var verificationView = Backbone.View.extend({
            el: $(".main-container"),
            initialize: function() {

            },
            events: {
                 "click .ver_check": "action_Query",
                 "click .rever_check": "actionRequery",
                 "click .btn_check": "actionCheckdata"
                
            },
            
            actionCheckdata: function(event) {
                var $this = $(event.currentTarget);
                var id = $this.attr('attr');
                $('.btn_check').attr('id',id);
                var id = $this.attr('id');
					
                     $.ajax({
						url: $base_url + "verification/verification_check",
						type: "POST",
						data: {id: id},
						async: false,
						success: function(response) {
                        table.ajax.reload();
						}
					});   
            }, 
            
            action_Query: function(event) {
				var $this = $(event.currentTarget);
				var id = $this.attr('attr');
				$('.rever_check').attr('id',id);
				$('#modal_view_user2').modal('show');
            
            },
            actionRequery: function(event) {
                var $this = $(event.currentTarget);
					var id = $this.attr('id');
					
                     $.ajax({
						url: $base_url + "verification/verification_query",
						type: "POST",
						data: {id: id},
						async: false,
						success: function(response) {
                        $('#modal_view_user2').modal('hide');
						}
					});   
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
    return new verificationView;
});