<?php
session_start();	
$_ADMINPAGES = false;
$_SH=true;	
include_once("config.php");
require_once("CmsEngine.php");

global $smarty;

$cmsEngine = new CmsEngine($smarty);
//$cmsEngine->SetDebugOn();
$cmsEngine->Start();
	exit();
	

	
function CheckPlugin($smartypluginblocks, $pluginName, $pluginPosition, & $data)
{
	foreach($smartypluginblocks as $smartypluginblock)
	{
		if($smartypluginblock["name"] == $pluginName && $smartypluginblock["position"] == $pluginPosition)
		{
			$data = $smartypluginblock["data"];
			return true;
		}
	}

	return false;
}

?>