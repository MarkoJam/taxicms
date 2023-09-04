<?
	/* CMS Studio 3.0 modify_ncateg_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_OPTION_TYPE_MODIFY"))
	{
		//insertovanje praznog sloga
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("OptionType");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;		
		}		
		if(isset($_REQUEST["option_type_id"]))
		{
			$nwType = $ObjectFactory->createObject("OptionType",$_REQUEST["option_type_id"]);
			
			$nwType->OptionType_POST($_REQUEST);
			
			$DBBR->promeniSlog($nwType);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>
