<?	
	/* CMS Studio 3.0 move.php */		

	$_ADMINPAGES = true;
	include_once("../../../config.php");		
	
	global $smarty;	
	global $auth;		
	
	$ObjectFactory = ObjectFactory::getInstance();	
	$LanguageHelper = LanguageHelper::getInstance();		
	
	
	$id_array=$_REQUEST["sectionsid"];	
	//$pid=$_REQUEST["parentid"];	
	$cnt_array=count($id_array);	
	//$parentIdQuery = " AND parentid = " . $pid;
	$parentIdQuery = "";
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_MOVE"))
	{
		for ($i = 0; $i <$cnt_array; $i++) 
		{	
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("grupaproizvodaid = " . $id_array[$i]. $parentIdQuery);
			$grupe = $ObjectFactory->createObjects("PrGrupaProizvoda");
			$ObjectFactory->Reset();
			foreach($grupe as $grupa)
			{
				$grupa->setGrupaProizvodaOrder($i+1);
			}
			$DBBR->promeniSlog($grupa);	
		}
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}	
?>