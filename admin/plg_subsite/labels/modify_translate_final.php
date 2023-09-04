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
			$translate = $_REQUEST["value"];
			$labels = $ObjectFactory->createObject("Labels",$id);
			$labels->setTranslate($translate);
			
			$DBBR->promeniSlog($labels);
	
			echo $labels->getTranslate();
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