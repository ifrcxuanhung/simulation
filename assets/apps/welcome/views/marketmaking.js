define([
    'jquery',
    'underscore',
    'backbone'
    ], function($, _, Backbone){
        var marketmakingView = Backbone.View.extend({
            el: $(".main-container"),
            initialize: function(){

            },
            events: {
				"click .exportTxt": "actionExportTxt",
				"click .exportCsv": "actionExportCsv",
				"click .exportXls": "actionExportXls",
				"click .run_contract_setting": "actionRuncontractsetting",
				"click .run_bid_ask_order": "actionRunBidaskorder",
            },
			actionRuncontractsetting: function(event) {
				event.preventDefault();
				 $.ajax({
					url: $base_url + 'marketmaking/order_by_contract_setting',
					type: 'POST',
					async: false,
				
					 beforeSend: function(){
						 $(".loader").show();
						
					 },
					 complete: function(){
						 $(".loader").hide();
						 
					 },
					success: function(response) {
					   if((response == true) || response) {
                          bootbox.alert("Run success!");  
						  //location.reload();                        
                        } else {
                            bootbox.alert("Run fail!");   
                        }
         					
					}
				});
            },
			actionRunBidaskorder: function(event) {
				event.preventDefault();
				 $.ajax({
					url: $base_url + 'marketmaking/bid_ask_order',
					type: 'POST',
					async: false,
					 beforeSend: function(){
						 $(".loader").show();
						
					 },
					 complete: function(){
						 $(".loader").hide();
						 
					 },
					success: function(response) {
					   if((response == true) || response) {
                          bootbox.alert("Run success!");  
						  //location.reload();                        
                        } else {
                            bootbox.alert("Run fail!");   
                        }
         					
					}
				});
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
			var jq_table2 = $(".jq_table2").attr('attr');
			
			var summary_des = $(".jq_table").attr('summary_des');
			var summary_des2 = $(".jq_table2").attr('summary_des2');
			
			var order_by = $(".jq_table").attr('order_by');
			var admin = $(".jq_table").attr('admin');
			var order_by2 = $(".jq_table2").attr('order_by');
			var admin2 = $(".jq_table2").attr('admin');
			
			
		
			var arr_order_by = order_by.split(' ');
			var order_last = arr_order_by.pop();
			var order_first = arr_order_by.join(' ');
			
			var arr_order_by2 = order_by2.split(' ');
			var order_last2 = arr_order_by2.pop();
			var order_first2 = arr_order_by2.join(' ');
				
			//console.log(arr[0]);
			var column = jQuery.parseJSON($("#column").attr('attr'));// Phai parse json vi no la object
			var column2 = jQuery.parseJSON($("#column2").attr('attr'));// Phai parse json vi no la object
			
			var error = jQuery.parseJSON($("#column").attr('error'));// Phai parse json vi no la object
			var error2 = jQuery.parseJSON($("#column2").attr('error'));// Phai parse json vi no la object
			//console.log(error);
			//var col = [{"label":"Code","name":"code"}];
			//bengin 1
			// phan nay neu dang co nhay thi an nhay di
			
			var vndmi = $(".jq_table").attr('vndmi');
			var vndmi2 = $(".jq_table2").attr('vndmi2');
			
			if(vndmi == 1){
				var link_ajax = "ajax/jq_loadtable_vndmi";
				var link_edit_ajax = 'ajax/edit_del_add_vndmi_jq_loadtable?jq_table=';	
			}else{
				var link_ajax = "ajax/jq_loadtable_vndmi";
				var link_edit_ajax = 'ajax/edit_del_add_vndmi_jq_loadtable?jq_table=';			
			}
			
			if(vndmi2 == 1){
				var link_ajax = "ajax/jq_loadtable_vndmi";
				var link_edit_ajax = 'ajax/edit_del_add_vndmi_jq_loadtable?jq_table=';	
			}else{
				var link_ajax = "ajax/jq_loadtable_vndmi";
				var link_edit_ajax = 'ajax/edit_del_add_vndmi_jq_loadtable?jq_table=';			
			}
			
			$.each(column, function() {
				if(this.formatoptions!='' && this.formatoptions != null){
					this.formatoptions = {decimalSeparator:".", thousandsSeparator: ",", decimalPlaces:parseInt(this.formatoptions), defaultValue: "" };
				}
				
				if(this.editoptions != '' && this.editoptions != null){
					var editops = this.editoptions.replace('"','');
					this.editoptions = {dataInit: function (element) {$(element).datepicker({id: "orderDate_datePicker",dateFormat:editops,maxDate: new Date(2020, 0, 1),showOn: "focus"});}} ;
					
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
			
			
			
			$.each(column2, function() {
				if(this.formatoptions!='' && this.formatoptions != null){
					this.formatoptions = {decimalSeparator:".", thousandsSeparator: ",", decimalPlaces:parseInt(this.formatoptions), defaultValue: "" };
				}
				
				if(this.editoptions != '' && this.editoptions != null){
					var editops = this.editoptions.replace('"','');
					this.editoptions = {dataInit: function (element) {$(element).datepicker({id: "orderDate_datePicker",dateFormat:editops,maxDate: new Date(2020, 0, 1),showOn: "focus"});}} ;
					
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
			// end 2
			
			// neu la admin moi duoc quyen sua tren tung dong
			if(admin == 1){
				var edit_row = editRow;	
				var admin_per = true;
			}
			else{
				var edit_row='';
				var admin_per = false;	
			}
			
			if(admin2 == 1){
				var edit_row2 = editRow2;	
				var admin_per2 = true;
			}
			else{
				var edit_row2='';
				var admin_per2 = false;	
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
				  
				 /*	$('#gbox_jqGrid').css('width','100%');
					$('#gbox_jqGrid #gview_jqGrid').css('width','100%');
					$('#gbox_jqGrid .ui-jqgrid-bdiv').css('width','100%');
					$('#gbox_jqGrid .ui-jqgrid-hdiv').css('width','100%');
					$('#gbox_jqGrid #jqGridPager').css('width','100%');*/
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
			
			
			 $("#jqGrid2").jqGrid({
               // url: 'ajax/jq_efrc_currency_data',
			    url: $base_url+link_ajax,
				editurl: $base_url+link_edit_ajax+jq_table2,
			
                mtype: "POST",
                datatype: "json",
				postData:{jq_table:jq_table2,filter_get_all:filter_get_all},
                page: 1,
                colModel:column2,
				//loadonce: true,
				loadtext: "Loading...",
				onSelectRow: edit_row2,
				viewrecords: true,
				//multiSort: true,
				//sortname: arr_order_by[0],
               // sortorder: arr_order_by[1],
				sortname: order_first,
               	sortorder: order_last,
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
                pager: "#jqGridPager2",
				caption: summary_des2,// hien tren title
				//scroll: 1,// phai de chieu cao co dinh no moi hoat dong
				rowList:[10,15,20,25,30,35,40,45,50,55,60],// hien thi so trang can xem
				//multiselect: true
				 //recordpos: 'left',
			  loadComplete: function() {
				  
				 
					//$("tr.jqgrow:odd").css("background", "#E0E0E0");
					$("tr.jqgrow:odd").addClass('myAltRowClass');
					$(".ui-icon-locked").parent().addClass("dis_none");
					$("#edit_jqGrid2").hide();
					$("#del_jqGrid2").hide();
					$("#add_jqGrid2").hide();
					
					$.each(column2, function() {
						$("#jqgh_jqGrid2_"+this.name).attr("data-toggle", "tooltip");
						$("#jqgh_jqGrid2_"+this.name).attr("title", this.tooltips);
						$('[data-toggle="tooltip"]').tooltip({position: { my: "center bottom", at: "left+30 top" }});
						
					});
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
				 	return "<a href='marketmaking/"+ cellValue+"' class='link_overview'>" + cellValue.substring(0, 25) + "</a>";
				}
				else{
					return "<a href='"+$base_url + 'marketmaking/' + cellValue+ "' class='link_overview'>" + cellValue.substring(0, 25) + "</a>";	
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
			  var lastSelection2;

            function editRow(id) {
               // if (id && id !== lastSelection) {
                    var grid = $("#jqGrid");
                    grid.jqGrid('restoreRow',lastSelection);
                    grid.jqGrid('editRow',id, {keys:true, focusField: 4});
                    lastSelection = id;
               // }
            }
			function editRow2(id2) {
               // if (id2 && id2 !== lastSelection2) {
                    var grid = $("#jqGrid2");
                    grid.jqGrid('restoreRow',lastSelection2);
                    grid.jqGrid('editRow',id2, {keys:true, focusField: 4});
                    lastSelection2 = id2;
              //  }
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
			
			
			
			
			$('#jqGrid2').jqGrid('filterToolbar');
			$('#jqGrid2').jqGrid('navGrid',"#jqGridPager2", {                
                search: false, // show search button on the toolbar
                add: admin_per2,
                edit: admin_per2,
                del: admin_per2,
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
			
			$('#jqGrid2').jqGrid('navButtonAdd',"#jqGridPager2",
				{caption:"Disable edit",
				title:"Disable edit",
				buttonicon :'ui-icon-locked',
				id:'locked_2',
				onClickButton:function(){
					$.each(column2, function() {
						$('#jqGrid2').jqGrid("setColProp", this.name, {editable: false});
						
					});
					$("#locked_2").children().hide();
					$("#jqGrid2").trigger('reloadGrid');
					$("#edit_jqGrid2").hide();
					$("#del_jqGrid2").hide();
					$("#add_jqGrid2").hide();
					$("#unlocked_2").children().show();
					 
				}}
			);
			$('#jqGrid2').jqGrid('navButtonAdd',"#jqGridPager2",
				{caption:"Enable edit",
				title:"Enable edit",
				buttonicon :'ui-icon-unlocked',
				id:'unlocked_2',
				onClickButton:function(){
					$.each(column2, function() {
						if(this.format_notedit == "not_edit"){	
							$('#jqGrid2').jqGrid("setColProp", this.name, {editable: false});	
						}
						else{
							$('#jqGrid2').jqGrid("setColProp", this.name, {editable: true});
						}
						$("#unlocked_2").children().hide();
						//$("#jqGrid2").trigger("reloadGrid");
						$("#edit_jqGrid2").show();
						$("#del_jqGrid2").show();
						$("#add_jqGrid2").show();
						$("#locked_2").children().show();
						
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
        return new marketmakingView;
});// JavaScript Document