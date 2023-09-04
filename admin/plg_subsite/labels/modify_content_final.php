<?
	/* CMS Studio 3.0 modify_cena_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();

	if($auth->isActionAllowed("ACTION_LABELS_MODIFY"))
	{
		if(isset($_REQUEST["id"]) && isset($_REQUEST["value"]))
		{
			$id = $_REQUEST["id"];
			$content = $_REQUEST["value"];

			$subsite = $ObjectFactory->createObjects("SubSite",array("SfStatus"));
			foreach($subsite as $ss)
			{
				$dbpr=$ss->GetDbPostfix();
				$sql="UPDATE `labels".$dbpr."` SET `content`='".$content."' WHERE `id`=".$id;
				$DBBR->con->query($sql);
			}	
			
			/*$labels = $ObjectFactory->createObject("Labels",$id);
			$labels->setContent($content);
			$DBBR->promeniSlog($labels);*/
	
			echo $content;
			return;
		}
		else
		{
			echo "Wrong!";
			return;
		}
	}
	else
	{
		echo "Wrong!";
		return;
	}	
?>