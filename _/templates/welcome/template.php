<?php   
$template_url = template_url();

//$template_url = str_replace('simulation','welcome',$template_url_); 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
    <meta charset="utf-8"/>
    <title><?php echo $logo_txt[0]['name'].' '.$logo_txt[1]['name'] ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    
    <link href="<?php echo $template_url; ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>layouts/layout5/css/layout.css" rel="stylesheet" type="text/css" />
    <?php if($this->router->fetch_class() == 'start' || $this->router->fetch_class() == 'simulation' || $this->router->fetch_class() == 'management'){?>
    <link href="<?php echo $template_url; ?>layouts/layout6/css/layout.min.css" rel="stylesheet" type="text/css"/>
    <?php }else {?>
    <link href="<?php echo $template_url; ?>layouts/layout5/css/custom.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>layouts/layout5/css/layout.min.css" rel="stylesheet" type="text/css"/>
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>css/style.css">
    <link href="<?php echo $template_url; ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="<?php echo $template_url; ?>global/plugins/morris/morris.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/select2/css/select2.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>    
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link href="<?php echo $template_url; ?>global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>pages/css/portfolio.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/clockface/css/clockface.css"/>
    <link href="<?php echo $template_url; ?>pages/css/tasks.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $template_url; ?>pages/css/profile.css" rel="stylesheet" type="text/css"/>
     <link href="<?php echo $template_url; ?>global/plugins/icheck/skins/all.css" rel="stylesheet"/>  
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'material design' style just load 'components-md.css' stylesheet instead of 'components.css' in the below style tag -->
    
    <link href="<?php echo $template_url; ?>global/css/plugins-md.css" rel="stylesheet" type="text/css"/>
    
    <!--link href="<?php echo $template_url; ?>pages/css/style.css" rel="stylesheet" type="text/css"/-->
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/bootstrap-editable/inputs-ext/address/address.css"/>
    
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>global/plugins/bootstrap-summernote/summernote.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $template_url; ?>pages/css/login-4.min.css">
    
    <!--css JQGRID-->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $template_url; ?>global/test/css/jquery-ui.css" />
<!-- The link to the CSS that the grid needs -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $template_url; ?>global/test/css/ui.jqgrid.css" />

<?php if($this->router->fetch_class() == 'profile'){?>
<!--ELFINDER CSS-->
<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $template_url; ?>global/plugins/elfinder/css/elfinder.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $template_url; ?>global/plugins/elfinder/css/theme.css">
<!--END ELFINDER CSS-->
<?php }?>
    <!--end css JQGRID-->
 	<!--scroll-->

    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="<?php echo $template_url; ?>img/favicon.ico"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
    <!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
    <!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
    <!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
    <!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
    <!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
    <!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
    <?php if( $this->router->fetch_class() == 'management'){?>
    <body class="page-md page-header-fixed page-quick-sidebar-over-content" style="background:url(<?php echo $template_url.$setting["bg_management_page"]; ?>) center center no-repeat fixed #2f373e !important" >
    <?php } else if ($this->router->fetch_class() == 'start' || $this->router->fetch_class() == 'simulation') { ?>
    <body class="page-md page-header-fixed page-quick-sidebar-over-content" style="background:url(<?php echo $template_url.$setting["bg_start_page"]; ?>) center center no-repeat fixed #2f373e !important" >
   
    <?php } else { ?>
     <body class="page-md page-header-fixed page-quick-sidebar-over-content" > 
    <?php } ?>
    <!-- BEGIN MAIN LAYOUT -->
	 <div class="page-container main-container" style="margin:0px;">
         <?php echo $header; ?>
	    <div class="container-fluid main-container margin-bottom-40" >
        
        	<!-- <div class="loader"></div>-->
             <div class="loader" style="display:none;"></div>
        	<div class="modal bs-modal-md fade" id="modals" role="dialog" aria-hidden="true" >
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<img src="<?php echo template_url(); ?>global/img/loading-spinner-grey.gif" alt="" class="loading"/>
							<span>
							&nbsp;&nbsp;Loading... </span>
						</div>
					</div>
				</div>
			</div>
            <div class="modal bs-modal-md fade" id="login_modals" role="dialog" aria-hidden="true" >
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<img src="<?php echo template_url(); ?>global/img/loading-spinner-grey.gif" alt="" class="loading"/>
							<span>
							&nbsp;&nbsp;Loading... </span>
						</div>
					</div>
				</div>
			</div>
            
            <?php echo $content; ?>
              
        </div> 
    </div>
    <p class="copyright">
    	<?php translate('dev_by'); ?> <a href="http://ifrc.fr/" target="_blank" style="color: #1c89b3 ;">IFRC</a>
    </p>
    <!-- END MAIN LAYOUT -->
    <a href="javascript:;" class="go2top"><i class="icon-arrow-up"></i></a>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="<?php echo $template_url; ?>global/plugins/respond.min.js"></script>
    <script src="<?php echo $template_url; ?>global/plugins/excanvas.min.js"></script> 
    <![endif]-->
    
    <script type="text/javascript">
        var $template_url = '<?php echo $template_url; ?>';
        var $base_url = '<?php echo base_url(); ?>';
		var $simulation_url = '<?php echo $simulation_url; ?>';
		var $order_type_must_limit = '<?php echo translate('order_type_must_limit'); ?>';
		var $order_type_must_daily = '<?php echo translate('order_type_must_daily'); ?>';
		var $price_error = '<?php echo translate('price_error'); ?>';
		var $lots_must_equa_0 = '<?php echo translate('lots_must_equa_0'); ?>';
		var $box_info_auto_close_seconds = '<?php echo $box_info_auto_close_seconds['value']; ?>';
		var $error_buy_sell = '<?php echo translate('error_buy_sell'); ?>';
        var $app = {'module': '<?php echo $this->router->fetch_module(); ?>',
            'controller': '<?php echo $this->router->fetch_class(); ?>',
            'action': '<?php echo $this->router->fetch_method(); ?>'};
    </script>
    <!-- <script src="<?php echo $template_url; ?>global/plugins/jquery-ui-1.12.1.js" type="text/javascript"></script>-->

    <!--ELFINDER JS-->
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
    
 
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/elfinder/js/elfinder.min.js"></script>
	<script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/elfinder/js/i18n/elfinder.ru.js"></script>
    <script>
		$('#elfinder_button').live('click', function() {
			$('<div id="editor" />').dialogelfinder({
				title : 'Manager files',
				width : "80%",
				destroyOnClose : true,
				url : '<?php echo base_url("profile/elfinder_init") ?>	',
				getFileCallback: function(file) {
					 $('#editor').dialogelfinder('close');
                    $('#editor').closest('#elfinder').val(file);
                    console.log($('#editor').closest('#editor'));
                    console.log(file);
					$('.url_image').html(file);
					//$('#editor').hide();
				}
			});
		});
	</script>-->
    <!--END ELFINDER JS-->
 
    <script src="<?php echo $template_url; ?>global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    
    <!--script src="<?php echo $template_url; ?>global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script-->
    <script src="<?php echo $template_url; ?>global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
     
    <script src="<?php echo $template_url; ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!--<script src="<?php echo $template_url; ?>global/plugins/bootstrap/js/bootstrap-ckeditor-fix.js" type="text/javascript"></script>-->
    
    <script src="<?php echo $template_url; ?>global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    
    <script src="<?php echo $template_url; ?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
   <!-- <script src="<?php echo $template_url; ?>global/plugins/jquery.cokie.min.js" type="text/javascript"></script>-->
    <script src="<?php echo $template_url; ?>global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
     <script src="<?php echo $template_url; ?>pages/scripts/components-bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/ckeditor/ckeditor.js"></script>
    <script src="<?php echo $template_url; ?>global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/jquery-mixitup/jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>    
    <script src="<?php echo $template_url; ?>global/scripts/app.min.js" type="text/javascript"></script>
    <!--<script src="<?php echo $template_url; ?>global/scripts/jquery.session.js" type="text/javascript"></script>-->
    <script src="<?php echo $template_url; ?>layouts/layout5/scripts/layout.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/icheck/icheck.min.js"></script>
    
    <?php //if($this->router->fetch_class() != 'start'){?>
    <!-- BEGIN PAGE CHART PLUGINS -->
   <!-- <script src="<?php echo $template_url; ?>global/plugins/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/flot/jquery.flot.stack.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/flot/jquery.flot.crosshair.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/flot/jquery.flot.axislabels.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/scripts/charts-flotcharts.js" type="text/javascript"></script>-->
    <!-- END PAGE CHART PLUGINS -->
    <?php //}?>
    
     <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="<?php echo $template_url; ?>global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
            
            
    <script src="<?php echo $template_url; ?>global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js"></script>
    <script src="<?php echo $template_url; ?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
  	<script src="<?php echo $template_url; ?>global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
	<script src="<?php echo $template_url; ?>global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <!--script src="<?php echo $template_url; ?>global/scripts/app.js" type="text/javascript"></script-->  
    <?php if($this->router->fetch_class() == 'strategies'){?>
    <script src="<?php echo $template_url; ?>global/scripts/highcharts.js" type="text/javascript"></script>
    <?php } ?>
    <!--edit form-->
    <script src="<?php echo $template_url; ?>global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/jquery.mockjax.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/bootstrap-editable/inputs-ext/address/address.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo $template_url; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="<?php echo $template_url; ?>pages/scripts/ui-modals.min.js" type="text/javascript"></script>
    
    <!--js JQGRID-->
    <script type="text/ecmascript" src="<?php echo $template_url; ?>global/test/src/i18n/grid.locale-en.js"></script>
    <!-- This is the Javascript file of jqGrid -->   
    <script type="text/ecmascript" src="<?php echo $template_url; ?>global/test/js/jquery.jqGrid.min.js"></script>
     <script type="text/ecmascript" src="<?php echo $template_url; ?>global/test/src/js/jquery-ui.min.js"></script>
     
     
    <!--end js JQGRID-->
    
  
    <!-- END JAVASCRIPTS -->

    <script data-main="<?php echo base_url(); ?>assets/apps/welcome/main" src="<?php echo base_url(); ?>assets/bundles/require.js"></script>
    <!-- CUSTOME JAVASCRIPTS -->
      <!-- BEGIN ECHARTS PLUGINS -->
    <script src="<?php echo $template_url; ?>global/plugins/echarts/echarts.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>pages/scripts/charts-echarts.js" type="text/javascript"></script>
    
    <?php if($this->router->fetch_class() != 'start'){?>
    <!--BEGIN AMCHART-->
    <script src="<?php echo $template_url; ?>global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
    <script src="<?php echo $template_url; ?>global/scripts/amchart.js" type="text/javascript"></script>
    <!--END AMCHART-->
    <?php }?>
    
    <!--scroll-->


    <!-- END ECHARTS PLUGINS -->
    <!-- END CUSTOME JAVASCRIPTS -->
   
    
<!--<script language=JavaScript>
  var message="!!YOU CANNOT COPY ANY TEXT OR IMAGE FROM THIS SITE!";
  function clickIE4()
  {
    if (event.button==2)
    {
      alert(message);
      return false;
    }
  }
  function clickNS4(e)
  {
    if (document.layers||document.getElementById&&!document.all)
    {
      if (e.which==2||e.which==3)
      {
        alert(message);
        return false;
      }
    }
  }

  if (document.layers)
  {
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown=clickNS4;
  }
  else if (document.all&&!document.getElementById)
  {
    document.onmousedown=clickIE4;
  }
  document.oncontextmenu=new Function("alert(message);return false")
</script>
-->

<script type="text/JavaScript">

	function killCopy(e){
		return false
	}
	function reEnable(){
		return true
	}
//	document.onselectstart=new Function ("return false")
//		if (window.sidebar){
//			document.onmousedown=killCopy
//			document.onclick=reEnable
//		}
</script>

<script>
$("input").keyup(function(event)
{
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {   
        $('#LoginProcess').click();
    }
});
</script>
    
</body>
<!-- END BODY -->
</html>