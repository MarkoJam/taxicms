<?  
	/* CMS Studio 3.0 insert_pre.php */
	$_ADMINPAGES = true;
	include_once("../../config.php");
		
	$plugin = $ObjectFactory->createObject("Plugin",-1);
	$DBBR->kreirajSlog($plugin); 

?>