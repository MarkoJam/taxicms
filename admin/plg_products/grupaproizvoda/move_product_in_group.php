<?	/* CMS Studio 3.0 move.php */		
	$_ADMINPAGES = true;	
	include_once("../../../config.php");		
	global $smarty;	
	global $auth;		
	$ObjectFactory = ObjectFactory::getInstance();	
	$LanguageHelper = LanguageHelper::getInstance();		
	$id_array=$_REQUEST["sectionsid"];	
	$gpid=$_REQUEST["grupaproizvodaid"];	
	$cnt_array=count($id_array);	
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_MOVE"))
	{
		for ($i = 0; $i <$cnt_array; $i++) 
		{			
			$ObjectFactory->Reset();			
			$ObjectFactory->AddFilter("proizvodid = " . $id_array[$i] . " AND grupaproizvodaid = " . $gpid);
			$proizgrpproiz = $ObjectFactory->createObjects("PrProizvodGrupaProiz");			
			$ObjectFactory->Reset();			
			foreach($proizgrpproiz as $gp)			
			{				
				$gp->setOrder($i+1);				
				$DBBR->promeniSlog($gp);
			}
		}
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}	
?>