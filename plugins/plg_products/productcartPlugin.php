<?
	include_once("plugins/plg_products/productsPlugin.php");

	class productcartPlugin extends productsPlugin 
	{
		function __construct()
		{
			parent::__construct();
			$this->kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
			$this->kpGrupaProizvodaTree->setPageId ( $this->getPageID () );
			$this->kpGrupaProizvodaTree->setLanguageHelper ( $this->LanguageHelper );
		}
		
		function showDefault()
		{
			$this->SetPluginLanguage("product");
			$lang = $this->LanguageHelper->GetLinkPluginType("language");

			$linkProdcutBasket = new LinkShoppingCard('basket');
			$basketLink = $this->LanguageHelper->getPrintLink($linkProdcutBasket);
			$basketCount = 0;
			
			if(isset($_SESSION[$lang]["korpa"]) || count($_SESSION[$lang]["korpa"])!= 0)
			{
				// blok koristi se i za orderPlugin / veliku kopru
				foreach($_SESSION[$lang]["korpa"] as $p => $kolicina)
				{
					$proiz = $this->ObjectFactory->createObject("PrProizvod",$p,array('PrGrupaProizvoda'));
					$proiz->setKolicinaBasket($kolicina);		
					$basketCount = $basketCount + $kolicina;	
					$this->getProductSettings($proiz,$this->kpGrupaProizvodaTree);
					if ($proiz->getPopust()>0) $ukupan_popust+=$proiz->getMedjuzbirBasket()*100/$proiz->getPopust()-$proiz->getMedjuzbirBasket();
					$proiz_arr = $proiz->toArray();			
					$ukupna_cena += $proiz->getMedjuzbirBasket();
					$proizvodi_array[] = $proiz_arr;
				}
				$this->smarty->assign("proizvodi_basket", $proizvodi_array);
				$this->smarty->assign("ukupna_cena_bp",$ukupna_cena+$ukupan_popust);
				$this->smarty->assign("ukupan_popust",$ukupan_popust);	
				$this->smarty->assign("ukupna_cena",$ukupna_cena);				
				// kraj bloka
				$this->smarty->assign("empty_basket","false");
						
			}
			$smartyData = array(
					"basketLink" => $basketLink,
					"basketCount" => $basketCount,
					"EMPTY" => true
			);
								
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->getPosition());
			$this->SmartyPluginBlock->setName("plg_productcart_default");
				
			return $this->SmartyPluginBlock->toArray();
		}
	}
?>