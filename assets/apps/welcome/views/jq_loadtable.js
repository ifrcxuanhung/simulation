define([
    'jquery',
    'underscore',
    'backbone'
    ], function($, _, Backbone){
        var jq_loadtableView = Backbone.View.extend({
            el: $(".main-container"),
            initialize: function(){

            },
            events: {
				"click .exportTxt": "actionExportTxt",
				"click .exportCsv": "actionExportCsv",
				"click .exportXls": "actionExportXls",
            },
			actionExportTxt: function(event) {
				$("#actexport").val('exportTxt');
				$('#form_tab').submit();
            },
			actionExportCsv: function(event) {
				$("#actexport").val('exportCsv');
				$('#form_tab').submit();
            },
			actionExportXls: function(event) {
				$("#actexport").val('exportXls');
				$('#form_tab').submit();
            },
            index: function(){
                  $(document).ready(function() {
                   //begin jqgrid
				 
				   
          // var form_currency = $('#form_currency').serialize();
		   var filter_get_all = $(".filter_get_all").attr('attr');
		
		 	var jq_table = $(".jq_table").attr('attr');
			//console.log(jq_table);
			var summary_des = $(".jq_table").attr('summary_des');
			var order_by = $(".jq_table").attr('order_by');
			var admin = $(".jq_table").attr('admin');
			
			
		
			var arr_order_by = order_by.split(' ');
			var order_last = arr_order_by.pop();
			var order_first = arr_order_by.join(' ');
				
			//console.log(arr[0]);
			var column = jQuery.parseJSON($("#column").attr('attr'));// Phai parse json vi no la object
			var error = jQuery.parseJSON($("#column").attr('error'));// Phai parse json vi no la object
			//console.log(error);
			//var col = [{"label":"Code","name":"code"}];
			//bengin 1
			// phan nay neu dang co nhay thi an nhay di
			
			var vndmi = $(".jq_table").attr('vndmi');
			if(vndmi == 1){
				var link_ajax = "ajax/jq_loadtable_vndmi";
				var link_edit_ajax = 'ajax/edit_del_add_vndmi_jq_loadtable?jq_table=';	
			}else{
				var link_ajax = "ajax/jq_loadtable";
				var link_edit_ajax = 'ajax/edit_del_add_jq_loadtable?jq_table=';			
			}
			
			$.each(column, function() {
				if(this.formatoptions!='' && this.formatoptions != null){
					this.formatoptions = {decimalSeparator:".", thousandsSeparator: ",", decimalPlaces:parseInt(this.formatoptions), defaultValue: "" };
				}
				
				if(this.editoptions != '' && this.editoptions != null){
					var editops = this.editoptions.replace('"','');
					if(this.editoptions == "0,1"){
						this.editoptions = { value:"1:0"};	
					}
					else{
					this.editoptions = {dataInit: function (element) {$(element).datepicker({id: "orderDate_datePicker",dateFormat:editops,maxDate: new Date(2020, 0, 1),showOn: "focus"});}} ;
					}
					
				}
				if(this.searchoptions != '' && this.searchoptions != null){
					
					var seops = this.searchoptions.replace('"','');
					if(seops.length == 8){
							this.searchoptions = {dataInit: function (element) {$(element).datepicker({id: "orderDate_datePicker",dateFormat: 'yy-mm-dd',maxDate: new Date(2020, 0, 1),showOn: "focus"});}};	
					//console.log(this.searchoptions);
					}
					else{
						//var selectoption = buildSearchSelect(this.name,jq_table);
						//var responseText = selectoption.responseText.replace('"','').slice(0,-2);
						var responseText = this.selectlist.replace('"','').slice(0,-2);
						if(responseText){
							this.searchoptions = { value: ":[All];"+ responseText}
						}
						else{
							this.searchoptions = {}
						}
						
							
					
					}
				}
				
				if(this.editrules != '' && this.editrules != null){
					var seops=this.editrules.split(",");
					var obj = [];
					$.each( seops, function( key, value ) {
						var val=value.split(":");
					  obj[val[0]]=val[1];
					});
					//console.log(obj["number"]);
					this.editrules ={
											
							number: (typeof(obj["number"]) === 'undefined' || obj["number"] === null) ? false :((obj["number"].trim())==='true' ? true :false),
							required: (typeof(obj["required"]) === 'undefined' || obj["required"] === null) ? false :((obj["required"].trim())=='true' ?true:false),
							edithidden: (typeof(obj["edithidden"]) === 'undefined' || obj["edithidden"] === null) ? false :((obj["edithidden"].trim())=='true' ?true:false) 
						}
					//console.log(this.editrules);
						
				}
				if(this.editable=='true'){
					this.editable = true;	
				}
				if(this.hidden=='true'){
					this.hidden = true;	
				}
				if(this.editable=='false'){
					this.editable = false;	
				}
				
				if(this.key=='true'){
					this.key = true;	
				}
				if(this.key=='false'){
					this.key = false;	
				}
				if(this.headertitles==''){
					this.headertitles = true;
				}
				if(this.formatter=='' || (this.formatter==null)){
					this.formatter = nullFormatter;
				}
				if(this.formatter=='link'){
					this.format_notedit = 'not_edit';
					this.formatter = formatLink;
				}
				if(this.formatter=='link2'){
					this.format_notedit = 'not_edit';
					this.formatter = formatlink2;
				}
				if(this.formatter=='info'){
					this.format_notedit = 'not_edit';
					this.formatter = formatInfo;
				}
                if(this.cellattr == ''){
					this.cellattr = function (rowId, tv, rawObject, cm, rdata) { return 'style="white-space: normal;"' };
				}
				
			  });
			// end 1
			// neu la admin moi duoc quyen sua tren tung dong
			if(admin == 1){
				var edit_row = editRow;	
				var admin_per = true;
			}
			else{
				var edit_row='';
				var admin_per = false;	
			}
			
            $("#jqGrid").jqGrid({
               // url: 'ajax/jq_efrc_currency_data',
			    url: $base_url+link_ajax,
				editurl: $base_url+link_edit_ajax+jq_table,
			
                mtype: "POST",
                datatype: "json",
				postData:{jq_table:jq_table,filter_get_all:filter_get_all},
                page: 1,
                colModel:column,
				//loadonce: true,
				loadtext: "Loading...",
				onSelectRow: edit_row,
				viewrecords: true,
				//multiSort: true,
				//sortname: arr_order_by[0],
               // sortorder: arr_order_by[1],
				sortname: order_first,
               	sortorder: order_last,
				sortable: true,
				loadOnce:false,
               	//width:1250,
			   autowidth: true,
			  // width: null,
				//shrinkToFit: false,
             	//gridview    :   true,
				//autoheight: true, // muon cuon xuong load them thi tat dong nay di va bat height o duoi len
                height:"100%", // co the de % de fix chieu cao auto
                rowNum: 15,
				//rownumbers: true, 
                pager: "#jqGridPager",
				caption: summary_des,// hien tren title
				//scroll: 1,// phai de chieu cao co dinh no moi hoat dong
				rowList:[10,15,20,25,30,35,40,45,50,55,100000000],// hien thi so trang can xem
				//multiselect: true
				 //recordpos: 'left',
			  loadComplete: function() {
				  
				  
				 	if(error){
						var html ='';
						$.each(error, function( key, value) {
							$(".show-error").css("display", "block");
							html += "["+value+"] ";
							
						});
						$(".show-error strong").html(html);
					}
					//$("tr.jqgrow:odd").css("background", "#E0E0E0");
					$("tr.jqgrow:odd").addClass('myAltRowClass');
					$(".ui-icon-locked").parent().addClass("dis_none");
					$("#edit_jqGrid").hide();
					$("#del_jqGrid").hide();
					$("#add_jqGrid").hide();
					
					$.each(column, function() {
						$("#jqgh_jqGrid_"+this.name).attr("data-toggle", "tooltip");
						$("#jqgh_jqGrid_"+this.name).attr("title", this.tooltips);
						$('[data-toggle="tooltip"]').tooltip({position: { my: "center bottom", at: "left+30 top" }});
						
					});
					$("option[value=100000000]").text('All');
				},// gan class chan le cho tung dong
				
				 
            });
			//Set null convert empty
			var nullFormatter = function(cellvalue, options, rowObject) {
				if(cellvalue === undefined || isNull(cellvalue)) {
					cellvalue = 'NULL';
				}
				return cellvalue;
			}
			function formatLink(cellValue, options, rowObject) {
				//$.each(column, function(key,val) {
				var url = options.colModel.url;
				var check_http = url.indexOf('http');
				$.each(rowObject, function(key,val) {
				 url = url.replace("@"+key+"@", val);
				});
				if(check_http == 0){
				 	return "<a href='jq_loadtable/"+ cellValue+"' class='link_overview'>" + cellValue.substring(0, 25) + "</a>";
				}
				else{
					return "<a href='"+$base_url + 'jq_loadtable/' + cellValue+ "' class='link_overview'>" + cellValue.substring(0, 25) + "</a>";	
				}
                
            };
			
			function formatlink2(cellValue, options, rowObject) {
				//console.log(rowObject.nb);
				if(rowObject.nb > 0){
					return "<a href='"+$base_url +"data_detail/?code="+ cellValue + "' class='link_overview'>" + cellValue.substring(0, 25) + "</a>";	
				}else{
					return cellValue;		
				}
            };
			
			function formatInfo(cellValue, options, rowObject) {
				return '<a target="_blank" href="'+$base_url+cellValue+'" class="btn btn-sm green"><i class="fa fa-globe"></i></a>';
            };
						
			
			
			 var lastSelection;

            function editRow(id) {
                //if (id && id !== lastSelection) {
                    var grid = $("#jqGrid");
                    grid.jqGrid('restoreRow',lastSelection);
                    grid.jqGrid('editRow',id, {keys:true, focusField: 4});
                    lastSelection = id;
               // }
            }
			/*function buildSearchSelect(name,table){
				
                return $.ajax({
                    url: $base_url + "ajax/getSelected",
                    type: "POST",
                    data: {name:name,table:table},
                    async: false,
                  
                });
				//var a = result;//"ALFKI:ALFKI;ANATR:ANATR;ANTON:ANTON";
				//console.log(a);
			}*/
			
			// activate the toolbar searching
            $('#jqGrid').jqGrid('filterToolbar');
			$('#jqGrid').jqGrid('navGrid',"#jqGridPager", {                
                search: false, // show search button on the toolbar
                add: admin_per,
                edit: admin_per,
                del: admin_per,
                refresh: true
            },
			{ 
					closeAfterEdit: true,
					width:1000,
					beforeShowForm: function ($form) {
						$form.closest(".ui-jqdialog").position({
							of: window, // or any other element
							my: "center top",
							at: "center top"
						});
						
						$('#sData').addClass("btn blue format_button");
						$('#cData').addClass("btn red format_button");
						$("#sData").html('<i class="fa fa-edit"></i> Save');
						$("#cData").html('<i class="fa fa-remove"></i> Cancel');
						/*$('<a href="#">Clear<span class="ui-icon ui-icon-document-b"></span></a>')
							.click(function() {
							  $(".ui-jqdialog input").val("");    
							}).addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
							  .prependTo("#Act_Buttons>td.EditButton");*/
					}
				},// Dong form edit sau khi sua
				{
					closeAfterAdd:true,
					width:1000,
					beforeShowForm: function ($form) {
						 $form.closest(".ui-jqdialog").position({
							of: window, // or any other element
							my: "center top",
							at: "center top"
						});
						$('#sData').addClass("btn blue format_button");
						$('#cData').addClass("btn red format_button");
						$("#sData").html('<i class="fa fa-edit"></i> Add');
						$("#cData").html('<i class="fa fa-remove"></i> Cancel');
						/*$('<a href="#">Clear<span class="ui-icon ui-icon-document-b"></span></a>')
							.click(function() {
							  $(".ui-jqdialog input").val("");    
							}).addClass("fm-button ui-state-default ui-corner-all fm-button-icon-left")
							  .prependTo("#Act_Buttons>td.EditButton");*/
					}
				
				
				}
			);
			
			
			// Click disable will not edit inline 
			
			$('#jqGrid').jqGrid('navButtonAdd',"#jqGridPager",
				{caption:"Disable edit",
				title:"Disable edit",
				buttonicon :'ui-icon-locked',
				onClickButton:function(){
					$.each(column, function() {
						$('#jqGrid').jqGrid("setColProp", this.name, {editable: false});
						
					});
					
					$(".ui-icon-locked").parent().hide();
					$("#jqGrid").trigger('reloadGrid');
					$("#edit_jqGrid").hide();
					$("#del_jqGrid").hide();
					$("#add_jqGrid").hide();
					$(".ui-icon-unlocked").parent().show();
					 
				}}
			);
			$('#jqGrid').jqGrid('navButtonAdd',"#jqGridPager",
				{caption:"Enable edit",
				title:"Enable edit",
				buttonicon :'ui-icon-unlocked',
				onClickButton:function(){
					$.each(column, function() {
						if(this.format_notedit == "not_edit"){	
							$('#jqGrid').jqGrid("setColProp", this.name, {editable: false});	
						}
						else{
							$('#jqGrid').jqGrid("setColProp", this.name, {editable: true});
						}
						$(".ui-icon-unlocked").parent().hide();
						
						//$("#jqGrid").trigger("reloadGrid");
						$("#edit_jqGrid").show();
						$("#del_jqGrid").show();
						$("#add_jqGrid").show();
						$(".ui-icon-locked").parent().show();
						
						
					});
				}}
			);
			
			// gan lai cho filter phia duoi
			/*var code = $('#filter_code').val();
			$('#gs_code').val(code);
			var date = $('#filter_date').val();
			$('#gs_date').val(date);
			var closes = $('#filter_close').val();
			$('#gs_close').val(closes);
			var cur_from = $('#filter_cur_from').val();
			$('#gs_cur_from').val(cur_from);
			var cur_to = $('#filter_cur_to').val();
			$('#gs_cur_to').val(cur_to);*/
  			// end jqgrid
				   
                   
           });   
                      
            },
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
            }
        });
        return new jq_loadtableView;
});// JavaScript Document