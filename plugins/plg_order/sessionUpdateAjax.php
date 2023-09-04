<?
	/* CMS Studio 2.0 korpa_add_one.php */
	$_AJAXPAGES=true;

	include_once("../../config.php");
	include_once("../pagePlugin.php");
	include_once("../plg_products/productsPlugin.php");
	$product = new productsPlugin;
	$LanguageHelper = LanguageHelper::getInstance();
	$LanguageHelper->subsite=$_REQUEST['lang'];
	$lang = $_REQUEST['lang'];
	$kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
	$kpGrupaProizvodaTree->setLanguageHelper ( $LanguageHelper );	
	$pr = $_REQUEST["proizvodid"];
	if (isset($_REQUEST['kolicina'])) $kol= $_REQUEST["kolicina"];
	if(!isset($_REQUEST['addone'])) {
		if ($kol>0) {
			if (isset($_REQUEST['option'])) $_SESSION[$lang]["korpa"][$pr] = $kol;
			else $_SESSION[$lang]["korpa"][$pr] += $kol;
		}
		else unset($_SESSION[$lang]["korpa"][$pr]);
	}
	else if (isset($_SESSION[$lang]["korpa"][$pr])) $_SESSION[$lang]["korpa"][$pr] = $_SESSION[$lang]["korpa"][$pr]+1;
	else $_SESSION[$lang]["korpa"][$pr] =1;

	$linkProdcutBasket = new LinkShoppingCard('basket');
	$basketLink = $LanguageHelper->getPrintLink($linkProdcutBasket);
	$basketCount=0;
	foreach($_SESSION[$lang]["korpa"] as $p => $kolicina)
	{
		$proiz = $ObjectFactory->createObject("PrProizvod",$p,array('PrGrupaProizvoda'));
		$proiz->setKolicinaBasket($kolicina);			
		$basketCount = $basketCount + $kolicina;	
		$product->getProductSettings($proiz,$kpGrupaProizvodaTree);			
		$proiz_arr = $proiz->toArray();			
		$ukupna_cena += $proiz->getMedjuzbirBasket();
		$proizvodi_array[] = $proiz_arr;
	}
	
	$smarty->assign("proizvodi_basket", $proizvodi_array);
	$smarty->assign("ukupna_cena",$ukupna_cena);
	$smarty->assign("empty_basket","false");
	$smarty->assign("data", array("basketLink" => $basketLink, "basketCount" => $basketCount, "EMPTY" => true));	
	$smarty->assign("orderstatus","process");
	$smarty->assign("ROOT_WEB",ROOT_WEB);
	
	ob_start();
	$smarty->display("../../templates/order/productcart_default.tpl");
	$output = ob_get_contents();
	ob_end_clean();
	
	echo $output;
		
?>