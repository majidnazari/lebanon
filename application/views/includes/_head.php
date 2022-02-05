<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->
    
    <title><?=$title?></title>

    <link rel="icon" type="image/ico" href="favicon.ico"/>
    
    <link href="<?=base_url()?>css/stylesheets.css" rel="stylesheet" type="text/css" />  
    <!--[if lt IE 8]>
        <link href="css/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->            
    <link rel='stylesheet' type='text/css' href='<?=base_url()?>css/fullcalendar.print.css' media='print' />
    <link href="<?=base_url()?>css/select2.min.css" rel="stylesheet" type="text/css" />
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/jquery/jquery-1.9.1.min.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/jquery/jquery-ui-1.10.1.custom.min.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/jquery/jquery-migrate-1.1.1.min.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/jquery/jquery.mousewheel.min.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/cookie/jquery.cookies.2.2.0.min.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/bootstrap.min.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/charts/excanvas.min.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/charts/jquery.flot.js'></script>    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/charts/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/charts/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/charts/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/sparklines/jquery.sparkline.min.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/fullcalendar/fullcalendar.min.js'></script>

    <script type='text/javascript' src='<?=base_url()?>js/plugins/select2/select2.full.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/uniform/uniform.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/validation/languages/jquery.validationEngine-en.js' charset='utf-8'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/validation/jquery.validationEngine.js' charset='utf-8'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/qtip/jquery.qtip-1.0.0-rc3.min.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/cleditor/jquery.cleditor.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/dataTables/jquery.dataTables.min.js'></script>    
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/plugins/pnotify/jquery.pnotify.min.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins/ibutton/jquery.ibutton.min.js'></script>
    
    <script type='text/javascript' src='<?=base_url()?>js/cookies.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/actions.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/charts.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/plugins.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/settings.js'></script>
    <script type='text/javascript' src='<?=base_url()?>js/faq.js'></script>
  <script type="text/javascript">
	function confirmation(msg='Are You sure ?') {
		
		var answer = confirm(msg)
		if (answer){
			return true
		}
		else{
			return false
		}
	}

	function fn_submit(msg)
	{
		var answer = confirm("Are You sure You want to delete ?")
		if (answer){
			document.form1.submit();
			 return false;
		}
		else{
			return false
		}		
		
	}	
	function f_submit(id)
	{
	//	var answer = confirm("Are You Sure ?")
		//if (answer){
			//alert('test');
			document.getElementById(id).submit();
			 return false;
//		}
//	else{
//			return false
//		}		
		
	}	
$('#tet').click(function(){return false; });
$('#check').click(function() {
  if(!$(this).is(':checked')){
    $('#tet').bind('click', function(){ return false; });
  }else{
    $('#tet').unbind('click');
  }
});	

</script> 

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <style type="text/css">
 .search-select{
	 width:100% !important;
	 text-align:right !important;
 }
 </style>
 <script language="javascript">
 $(function() {
	  
	$(".search-select").select2();  
  });
</script>
</head>