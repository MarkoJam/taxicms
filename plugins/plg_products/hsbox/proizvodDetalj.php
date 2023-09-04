<?
	include_once("../../../config.php");
	
	/* klasa se koristi kod standardne pretrage za gledanje detalja proizvoda */
	class ProizvodDetalj
	{
		private $LanguageHelper;
		private $ObjectFactory;
		private $Smarty;
		private $proizvodID;
		
		function __construct()
		{
			$this->LanguageHelper = LanguageHelper::getInstance();
			$this->ObjectFactory = ObjectFactory::getInstance();
			$this->Smarty = new Smarty;
		}
		
		function PrikaziProizvod()
		{
			if(isset($_REQUEST["proizvodid"]) && is_numeric($_REQUEST["proizvodid"]))
			{
				$this->proizvodID = $_REQUEST["proizvodid"];
				$proizvod = $this->ObjectFactory->createObject("PrProizvod", $this->proizvodID, array("PrProizvodjac", "PrKarakteristika"));
				
				$karakteristike = array();
				foreach($proizvod->PrKarakteristika as $karakteristika)
				{
					$karakteristike[] = $karakteristika->toArray();
				}
				
				$this->Smarty->assign("karakteristike", $karakteristike);
				$this->Smarty->assign("proizvod", $proizvod->toArray());
				$this->Smarty->display("proizvodDetalj.tpl");
			}
		}
	}
	
	$proizvodDetalj = new ProizvodDetalj();
	$proizvodDetalj->PrikaziProizvod(); 
?>