<?
	/* CMS Studio 3.0 insert_plugin.php */

	$_ADMINPAGES = true;
	include_once("../config.php");

	global $smary;
	global $auth;


		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') {
			$resources = $ObjectFactory->createObject($_REQUEST['class'],-1);
			$_REQUEST['res_id']=$DBBR->kreirajSlog($resources); 
		}

		if (isset($_REQUEST['res_id']) && isset($_REQUEST['conres_id']) && $_REQUEST['conres_id']<>-1) {
			
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("class = '".$_REQUEST['class']."'"  );			
			$resources = $ObjectFactory->createObjects("SfResource");
			$ObjectFactory->ResetFilters();
			$rid=$resources[0]->getID();
			$rid=$rid.".".$_REQUEST['res_id'];
			
			$resres = $ObjectFactory->createObject("ResRes",-1);
			$resres->setConResID($_REQUEST['conres_id']);
			$resres->setResID($rid);
			$DBBR->kreirajSlog($resres);
			$insert = new ConnectedObject($ObjectFactory,$DBBR);	
			$insert->InsertConnectedObject($_REQUEST['class'], 'img', $_REQUEST['res_id']);
			$insert->InsertConnectedObject($_REQUEST['class'], 'vid', $_REQUEST['res_id']);						
			$insert->InsertConnectedObject($_REQUEST['class'], 'web', $_REQUEST['res_id']);	
			$insert->InsertConnectedObject($_REQUEST['class'], 'wb2', $_REQUEST['res_id']);				
			$insert->InsertConnectedObject($_REQUEST['class'], 'doc', $_REQUEST['res_id']);	
			$insert->InsertConnectedObject($_REQUEST['class'], 'dc2', $_REQUEST['res_id']);
			
			
			
			
			echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";	
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
									

?>