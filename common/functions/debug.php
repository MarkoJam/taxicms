<?
	include_once('PHP/Debug.php');

	$options = array(
    	'HTML_DIV_images_path' => '../../../debug/images', 
    	'HTML_DIV_css_path' => '../../../debug/css', 
    	'HTML_DIV_js_path' => '../../../debug/js',
	);
	
	$Dbg = new PHP_Debug($options);
	
	ob_start();
	$Dbg->add('DEBUG INFO');
	$Dbg->display();
	$debug_info = ob_get_clean();
	$smarty->assign("debug_info",$debug_info);
	
	$smarty->assign("debug_images_path",$options["HTML_DIV_images_path"]);
	$smarty->assign("debug_css_path",$options["HTML_DIV_css_path"]);
	$smarty->assign("debug_js_path",$options["HTML_DIV_js_path"]);
	
	/*
	
	<script type="text/javascript" src="{$debug_js_path}/html_div.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="{$debug_css_path}/html_div.css" />
	
	{$debug_info}
	
	*/
?>