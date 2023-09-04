<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	global $smarty;
	global $auth;
	global $LanguageArray;

	if($auth->isActionAllowed("ACTION_SUBSITE_MODIFY"))
	{
		//insertovanje praznog sloga
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("SubSite");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			//$_REQUEST[$col]=$_POST[$col]=$id;
			$_REQUEST["subsiteid"]=$id;
		}
		
		if(isset($_REQUEST["subsiteid"]))
		{
			$ss = $ObjectFactory->createObject("SubSite",$_REQUEST["subsiteid"]);
			$ss->SubSite_POST($_REQUEST);
			
			//$ss->setFilePostfix(strtolower($ss->FilePostfix));
			//if ($_REQUEST['isdefault']==0) $ss->setDbPostfix("_".strtolower($_REQUEST['name']));
			
			$DBBR->promeniSlog($ss);
			
			//blok za azuriranje tabela za subsite
			array_push($DBBR->table_exception,"page") ;
			foreach ($DBBR->table_exception as $tbl_name)
			{
				if (!$DBBR->con->query("DESCRIBE `".$tbl_name.$ss->getDbPostfix()."`"))	
				{
					$DBBR->con->query("create table ".$tbl_name.$ss->getDbPostfix()." AS SELECT * FROM ".$tbl_name);
				}
			}
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";

?>