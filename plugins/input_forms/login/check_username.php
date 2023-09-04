<?  
	/* CMS Studio 3.0 insert_pre.php */	//

	//$_ADMINPAGES = true;	
	include_once("../../../config.php");
	global $smarty;
	global $auth;
	if (isset($_SESSION["logeduserid"]) && $_SESSION["logeduserid"]==$_REQUEST['username']) echo 'Not';

	$ObjectFactory->Reset();
	$ObjectFactory->AddFilter("username = '".$_REQUEST['username']."'");
	$user = $ObjectFactory->createObjects("User");
	$ObjectFactory->Reset();
	if (count($user)>0) {
		if (isset($_SESSION["logeduserid"]) && $_SESSION["logeduserid"]==$user[0]->getUserID()) echo 'Not';
		else echo true;
	}	
	else echo 'Not';
	
?>