<?
	// Plugin za pretragu proizvoda filtriranjem, tipovi proizvoda su izlistani u osnovnom pregledu, kada se odabere
	// odgovarajuci tip proizvda pikazuju se svi njegovi proizvodaci, raspon cena i karakteristike sa 
	// vrednostima karakteristika 
	// 
	// Korisnik izborom odredjenih vrednosti karakteristika ili proizvodjaca suzava broj proizvoda u listi
	// proizvoda izabranog tipa. Ucitavanje novih proizvoda vrsi se putem ajaxa u definisani kontejner
	// 
	// Detaljni prikaz proizvoda prikazuje se na novoj stranici
	
	class ProductFilterSearchPlugin extends productsPlugin
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function showDefault()
		{
			$tipoviProizvoda = $this->ObjectFactory->createObjects("PrTipProizvoda");
			$tipoviProizvodaSmarty = array();
			foreach($tipoviProizvoda as $tipProizvoda)
			{
				$tipoviProizvodaSmarty[] = array_merge($tipProizvoda->toArray(), array("link" => "index.php?productsearchfilter=true&tipproizvodaid=".$tipProizvoda->getTipProizvodaID()));
			}

			if(isset($_REQUEST["productsearchfilter"]) && $_REQUEST["productsearchfilter"] == true && isset($_REQUEST["tipproizvodaid"]))
			{
				// odabran je neki tip proizvoda, treba prikazati njegove karakteristike i 
				// vrednosti karakteristika preko kojih se vrsi filtriranje listi
				$tipProizvodaId = $_REQUEST["tipproizvodaid"];
				
				$karakteristikeProizvoda = $this->ObjectFactory->createObjects("PrKarakteristika", array("PrKarakteristikaVrsta"));	
				
				print_r($karakteristikaProizvoda);
									
			}		
			
			$this->smarty->assign("tipoviProizvoda", $tipoviProizvodaSmarty);
			$this->smarty->assign("plg_productfiltersearch_default","true");
		}
		
		function showDetails()
		{
		
		}
	}

?>