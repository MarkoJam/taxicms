<?
	/* CMS Studio 3.0 move.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();
	
	
	$id_array=$_REQUEST["sectionsid"];
	$cnt_array=count($id_array);

		for ($i = 0; $i <$cnt_array; $i++) 
		{
			$subsite = $ObjectFactory->createObject("SubSite",$id_array[$i]);
			$subsite->setSSOrder($i+1);
			$DBBR->promeniSlog($subsite);			
		}	


?>