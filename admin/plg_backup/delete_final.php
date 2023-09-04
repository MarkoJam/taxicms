<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");

	if($auth->isActionAllowed("ACTION_BACKUP_DELETE"))
	{
		if(isset($_REQUEST["filename"]))
		{
			$folder = "../backup/";
			@unlink($folder.$_REQUEST["filename"]);
		}
		echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
			}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
	
?>