<?
	/* CMS Studio 2.0 korpa_add_one.php */
	$_AJAXPAGES=true;
	include_once("../../config.php");
	include_once("../pagePlugin.php");
	include_once("../plg_products/productsPlugin.php");
	$product = new productsPlugin;
	$LanguageHelper = LanguageHelper::getInstance();
<<<<<<< HEAD
	$LanguageHelper->subsite=$_REQUEST['lang'];
	$lang = $_REQUEST['lang'];
	$kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
	$kpGrupaProizvodaTree->setLanguageHelper ( $LanguageHelper );
	$LanguageArrayInternal = array();
	$ObjectFactory->ResetFilters();
	$labels = $ObjectFactory->createObjects("Labels");
	foreach ($labels as $lab)
	{
		if ($lab->getTranslate()=="") $lab->setTranslate($lab->getContent());
		$smarty->assign($lab->getName(), $lab->getTranslate());
		$LanguageArrayInternal['value'][$lab->getName()]=$lh->Transliterate($lab->getTranslate());
	}		
=======
	$lang = $LanguageHelper->GetLinkPluginType("language");
	$kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
	$kpGrupaProizvodaTree->setLanguageHelper ( $LanguageHelper );
>>>>>>> 6c7a9b31ef9c3ffc476a9fd2a48f5bef9fa01d80

	$linkProdcutBasket = new LinkShoppingCard('basket');
	$basketLink = $LanguageHelper->getPrintLink($linkProdcutBasket);
	$basketCount=0;
	if ($_SESSION["loged"])	{$user = $ObjectFactory->createObject("User", $_SESSION["logeduserid"]);
		$smarty->assign("user", $user->toArray());
		$smarty->assign("usertip",$_SESSION['logedusertypeid']);
	}
	foreach($_SESSION[$lang]["korpa"] as $p => $kolicina)
	{
		$proiz = $ObjectFactory->createObject("PrProizvod",$p,array('PrGrupaProizvoda'));
		$proiz->setKolicinaBasket($kolicina);
		$basketCount = $basketCount + $kolicina;
		$product->getProductSettings($proiz,$kpGrupaProizvodaTree);
		if ($proiz->getPopust()>0) $ukupan_popust+=$proiz->getMedjuzbirBasket()*100/$proiz->getPopust()-$proiz->getMedjuzbirBasket();
		$proiz_arr = $proiz->toArray();
		$ukupna_cena += $proiz->getMedjuzbirBasket();
		$proizvodi_array[] = $proiz_arr;
	}
	$nextstep_link = $LanguageHelper->GetPrintLink(new LinkShoppingCard('checkout'));
	$smarty->assign("nextstep_link", $nextstep_link);
	
	$smarty->assign("lang",$lang);
	$smarty->assign("proizvodi_basket", $proizvodi_array);
	$smarty->assign("ukupna_cena_bp",$ukupna_cena+$ukupan_popust);
	$smarty->assign("ukupan_popust",$ukupan_popust);
	$smarty->assign("ukupna_cena",$ukupna_cena);
	$smarty->assign("empty_basket","false");
	$smarty->assign("data", array("basketLink" => $basketLink, "basketCount" => $basketCount, "EMPTY" => true));
	$smarty->assign("orderstatus","process");
	$smarty->assign("ROOT_WEB",ROOT_WEB);

	ob_start();
	$smarty->display("../../templates/order/basket.tpl");
	$output = ob_get_contents();
	ob_end_clean();

	echo $output;

?>
