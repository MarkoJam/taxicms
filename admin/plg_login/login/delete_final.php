<?
	/* CMS Studio 3.0 delete_final.php *///

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LOGIN_DELETE"))
	{
		if(isset($_REQUEST["userid"]))
		{
			$user = $ObjectFactory->createObject("User",-1);
			$user->UserID = $_REQUEST["userid"];
			
			// u slucaju da se koriste i role zajedno sa userima
			if(class_exists('UserUserRole'))
			{
				$useruserrole = $ObjectFactory->createObject("UserUserRole",-1);
				$DBBR->obrisiSlogove($useruserrole,"userid=".$_REQUEST["userid"]);
			}
			$DBBR->obrisiSlog($user);
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>