<?

/* CMS Studio 3.0 proizvodi.php */

// klasa PrProizvod cuva podatke o proizvodima
class PrProizvod extends OpstiDomenskiObjekat
{
	public $ProizvodID;
	private $Naziv;
	public $Sifra;
	public $Oem;
	public $Opis;
	public $KratakOpis;
	public $CenaA;  // normalna cena
	public $CenaB;  // snizena cena
	public $CenaAMP;  // normalna maloprodajna cena
	public $CenaBMP;  // snizena maloprodaja cena
	public $Dimenzije;
	public $Kolicina;
	public $Slika;
	public $SlikaThumb;
	public $SlikaOver;
	public $CountryID;
	public $Lokacija;
	public $Order;
	private $Napomena;
	private $NapomenaAdd;
	private $Godina;
	public $Tezina;

	public $PrKarakteristika;
	public $PrKategorija;
	public $PrGrupaProizvoda;
	public $PrProizvodKomentar;
	public $PrProizvodOcena;

	public $PrProizvodjac;
	public $SfStatus;
	public $SfCountries;
	public $PrTipProizvoda;
	public $PrVelicina; // array


	public $Kurs;
	public $Popust;
	public $Link;
	public $AddOneLink;
	public $Datum;

	public $Price;  // limit za izracunavanje postarine

	// ne cuva se u bazi
	private $KategorijeLink;

	//kolicina i medjuzbir za prikaz u korpi
	public $KolicinaBasket;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrProizvodjac = $this->ObjectFactory->createObject("PrProizvodjac", -1);
		$this->PrTipProizvoda = $this->ObjectFactory->createObject("PrTipProizvoda", -1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus", -1);
		$this->SfCountries = $this->ObjectFactory->createObject("SfCountries", -1);
		$this->PrKarakteristika = array();
		$this->PrKategorija = array();
		$this->PrGrupaProizvoda = array();
		$this->PrProizvodOcena = array();
		$this->PrProizvodKomentar = array();
		$this->PrVelicina = array();

		$this->ProizvodID = -1;
		$this->PrProizvodjac->setProizvodjacID(-1);
		$this->PrTipProizvoda->TipProizvodaID = -1;
		$this->SfStatus->StatusID = -1;
		$this->SfCountries->CountryID = -1;

		$this->Naziv = "";//getTranslation("PLG_PRODUCT_DEFAULT_TITLE");
		$this->Sifra = "";//getTranslation("PLG_PRODUCT_DEFAULT_CODE");
		$this->Oem = "";//getTranslation("PLG_PRODUCT_DEFAULT_CODE");
		$this->Opis = "";//getTranslation("PLG_PRODUCT_DEFAULT_TEXT");
		$this->KratakOpis = "";//getTranslation("PLG_PRODUCT_DEFAULT_SHORTTEXT");
		$this->CenaA = 0;
		$this->CenaB = 0;
		$this->CenaAMP = 0;
		$this->CenaBMP = 0;
		$this->Dimenzije = "";
		$this->Kolicina = "";
		$this->Slika = "";
		$this->SlikaOver = "";
		$this->CountryID = "";
		$this->Lokacija = "";
		$this->Napomena = "";
		$this->NapomenaAdd = "";
		$this->Godina = "";
		$this->Tezina = 0;
		$this->Order = 0;
		$this->Datum = time();
		$this->KategorijeLink = "";
		$this->GodinaVrednost = "";
		$this->Kurs = 1;
		$this->Popust = 0;
		$this->AddOneLink = "";
		$this->Link = "";
		$this->Price = 0;
		$this->TableName = "pr_proizvod";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrProizvod from POST
	function PrProizvod_POST($post)
	{
		$this->PrProizvodjac = $this->ObjectFactory->createObject("PrProizvodjac", -1);
		$this->PrTipProizvoda = $this->ObjectFactory->createObject("PrTipProizvoda", -1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus", -1);
		$this->SfCountries = $this->ObjectFactory->createObject("SfCountries", -1);

		$this->PrKarakteristika = array();
		$this->PrKategorija = array();
		$this->PrGrupaProizvoda = array();
		$this->PrProizvodOcena= array();
		$this->PrProizvodKomentar = array();
		$this->PrVelicina = array();


		$this->ProizvodID= isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->Naziv= isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Sifra= isset($post["sifra"]) ? $post["sifra"] : $this->Sifra;
		$this->Oem= isset($post["oem"]) ? $post["oem"] : $this->Oem;
		$this->Opis= isset($post["opis"]) ? $post["opis"] : $this->Opis;
		$this->KratakOpis = isset($post["kratak_opis"]) ? $post["kratak_opis"] : $this->KratakOpis;
		$this->CenaA = isset($post["cenaa"]) ? $post["cenaa"] : $this->CenaA;
		$this->CenaB = isset($post["cenab"]) ? $post["cenab"]: $this->CenaB;
		$this->CenaAMP = isset($post["cenaamp"]) ? $post["cenaamp"]: $this->CenaAMP;
		$this->CenaBMP = isset($post["cenabmp"]) ? $post["cenabmp"]: $this->CenaBMP;
		$this->Dimenzije = isset($post["dimenzije"]) ? $post["dimenzije"] : $this->Dimenzije;
		$this->Kolicina = isset($post["kolicina"]) ? $post["kolicina"] : $this->Kolicina;
		$this->Slika= isset($post["slika"]) ? $post["slika"] : $this->Slika;
		$this->SlikaOver= isset($post["slikaover"]) ? $post["slikaover"] : $this->SlikaOver;
		$this->CountryID= isset($post["countryid"]) ? $post["countryid"] : $this->CountryID;
		$this->Lokacija= isset($post["lokacija"]) ? $post["lokacija"] : $this->Lokacija;
		$this->Napomena= isset($post["napomena"]) ? $post["napomena"] : $this->Napomena;
		$this->NapomenaAdd= isset($post["napomenaadd"]) ? $post["napomenaadd"] : $this->NapomenaAdd;
		$this->Godina= isset($post["godina"]) ? $post["godina"] : $this->Godina;
		$this->Tezina = isset($post["tezina"]) ? $post["tezina"]: $this->Tezina;
		$this->PrProizvodjac->setProizvodjacID(isset($post["proizvodjacid"]) ? $post["proizvodjacid"] : $this->PrProizvodjac->getProizvodjacID());
		$this->PrTipProizvoda->TipProizvodaID= isset($post["tipproizvodaid"]) ? $post["tipproizvodaid"] : $this->PrTipProizvoda->TipProizvodaID;
		$this->SfStatus->StatusID = isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->StatusID;
		$this->SfCountries->CountryID = isset($post["countryid"]) ? $post["countryid"] : $this->SfCountries->CountryID;

		$this->Order = isset($post["redosled"]) ? $post["redosled"] : $this->Order;
		$this->Datum = isset($post["datum"]) ? $post["datum"] : $this->Datum;
	}
	function vratiImenaAtributa() {return "`proizvodid`,`naziv`,`sifra`,`oem`,`kratak_opis`,`opis`,`cenaa`,`cenab`,`cenaamp`,`cenabmp`,`dimenzije`,`kolicina`,`slika`,`slika_over`,`country_id`,`lokacija`,`napomena`,`napomena_add`,`godina`,`proizvodjacid`,`tipproizvodaid`,`proizvod_order`,`status_id`,`datum`,`tezina`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Sifra, true).",".$this->quote_smart($this->Oem).",".$this->quote_smart($this->Opis).",".$this->quote_smart($this->KratakOpis).",".$this->quote_smart($this->CenaA).",".$this->quote_smart($this->CenaB).",".$this->quote_smart($this->CenaAMP).",".$this->quote_smart($this->CenaBMP).",".$this->quote_smart($this->Dimenzije).",".$this->quote_smart($this->Kolicina).",".$this->quote_smart($this->Slika).",".$this->quote_smart($this->SlikaOver).",".$this->quote_smart($this->CountryID).",".$this->quote_smart($this->Lokacija).",".$this->quote_smart($this->Napomena).",".$this->quote_smart($this->NapomenaAdd).",".$this->quote_smart($this->Godina).",".$this->quote_smart($this->PrProizvodjac->getProizvodjacID()).",".$this->quote_smart($this->PrTipProizvoda->TipProizvodaID).",".$this->quote_smart($this->Order).",".$this->quote_smart($this->SfStatus->StatusID).",".$this->quote_smart($this->Datum).",".$this->quote_smart($this->Tezina);;}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`sifra` = ".$this->quote_smart($this->Sifra, true).",`oem` = ".$this->quote_smart($this->Oem).",`opis` = ".$this->quote_smart($this->Opis).",`kratak_opis` = ".$this->quote_smart($this->KratakOpis).",`cenaa` = ".$this->quote_smart($this->CenaA).",`cenab` = ".$this->quote_smart($this->CenaB).",`cenaamp` = ".$this->quote_smart($this->CenaAMP).",`cenabmp` = ".$this->quote_smart($this->CenaBMP).",`dimenzije` = ".$this->quote_smart($this->Dimenzije).",`kolicina` = ".$this->quote_smart($this->Kolicina).",`slika` = ".$this->quote_smart($this->Slika).",`slika_over` = ".$this->quote_smart($this->SlikaOver).",`country_id` = ".$this->quote_smart($this->CountryID).",`lokacija` = ".$this->quote_smart($this->Lokacija).",`napomena` = ".$this->quote_smart($this->Napomena).",`napomena_add` = ".$this->quote_smart($this->NapomenaAdd).",
	`proizvodjacid` = ".$this->quote_smart($this->PrProizvodjac->getProizvodjacID()).",`tipproizvodaid` = ".$this->quote_smart($this->PrTipProizvoda->TipProizvodaID).",`proizvod_order` = ".$this->quote_smart($this->Order).",
	`status_id` = ".$this->quote_smart($this->SfStatus->StatusID).",
	`godina` = ".$this->quote_smart($this->Godina).",
	`datum` = ".$this->quote_smart($this->Datum).",`tezina` = ".$this->quote_smart($this->Tezina);}
	function nazivVezeKaRoditelju(){ return "prproizvod";}
	function vratiUslovZaNadjiSlog(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaSortiranje(){ return "tipproizvodaid asc, `proizvod_order` asc";}
	function vratiUslovZaNadjiSlogF(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaNadjiSlogove(){ return "tipproizvodaid=".$this->quote_smart($this->PrTipProizvoda->TipProizvodaID);}
	function vratiAtributZaMax(){return "`proizvod_order`";}
	function postaviID($id){ $this->ProizvodID = $id;}
	function napuni($result_row){
		$this->ProizvodID = $result_row->proizvodid;
		$this->Naziv = $result_row->naziv;
		$this->Sifra = $result_row->sifra;
		$this->Oem= $result_row->oem;
		$this->Opis = $result_row->opis;
		$this->KratakOpis = $result_row->kratak_opis;
		$this->CenaA = $result_row->cenaa;
		$this->CenaB = $result_row->cenab;
		$this->CenaAMP = $result_row->cenaamp;
		$this->CenaBMP = $result_row->cenabmp;
		$this->Dimenzije = $result_row->dimenzije;
		$this->Kolicina = $result_row->kolicina;
		$this->Slika = $result_row->slika;
		$this->SlikaOver = $result_row->slika_over;
		$this->SfCountries->CountryID = $result_row->country_id;
		$this->Lokacija = $result_row->lokacija;
		$this->Napomena= $result_row->napomena;
		$this->NapomenaAdd= $result_row->napomena_add;
		$this->SfCountries->CountryID = $result_row->country_id;
		$this->PrProizvodjac->setProizvodjacID($result_row->proizvodjacid);
		$this->PrTipProizvoda->TipProizvodaID = $result_row->tipproizvodaid;
		$this->Godina = $result_row->godina;
		$this->Order = $result_row->proizvod_order;
		$this->SfStatus->StatusID = $result_row->status_id;
		$this->Datum = $result_row->datum;
		$this->Tezina = $result_row->tezina;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proiz = $this->ObjectFactory->createObject("PrProizvod",-1);
				$proiz->ProizvodID = $result_row->proizvodid;
				$proiz->Naziv = $result_row->naziv;
				$proiz->Sifra = $result_row->sifra;
				$proiz->Oem = $result_row->oem;
				$proiz->Opis = $result_row->opis;
				$proiz->KratakOpis = $result_row->kratak_opis;
				$proiz->CenaA = $result_row->cenaa;
				$proiz->CenaB = $result_row->cenab;
				$proiz->CenaAMP = $result_row->cenaamp;
				$proiz->CenaBMP = $result_row->cenabmp;
				$proiz->Dimenzije = $result_row->dimenzije;
				$proiz->Kolicina = $result_row->kolicina;
				$proiz->Slika = $result_row->slika;
				$proiz->SlikaOver = $result_row->slika_over;
				$proiz->Lokacija = $result_row->lokacija;
				$proiz->Napomena= $result_row->napomena;
				$proiz->NapomenaAdd= $result_row->napomena_add;
				$proiz->Godina= $result_row->godina;
				$proiz->SfCountries->setCountryID($result_row->country_id);
				$proiz->PrProizvodjac->setProizvodjacID($result_row->proizvodjacid);
				$proiz->PrTipProizvoda->TipProizvodaID = $result_row->tipproizvodaid;
				$proiz->Order = $result_row->proizvod_order;
				$proiz->SfStatus->StatusID = $result_row->status_id;
				$proiz->Datum = $result_row->datum;
				$proiz->Tezina = $result_row->tezina;
				array_push($al, $proiz);
			}
	}
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join){

		$pr_karakteristika = $this->LanguageHelper->ChangeTableNameR("pr_karakteristika");
		$pr_karakteristikaproizvoda = $this->LanguageHelper->ChangeTableNameR("pr_karakteristikaproizvoda");
		$pr_kategorija = $this->LanguageHelper->ChangeTableNameR("pr_kategorija");
		$pr_proizvodkategorija = $this->LanguageHelper->ChangeTableNameR("pr_proizvodkategorija");
		$pr_grupaproizvoda = $this->LanguageHelper->ChangeTableNameR("pr_grupaproizvoda");
		$pr_proizvodgrupaproizvoda= $this->LanguageHelper->ChangeTableNameR("pr_proizvodgrupaproiz");
		$pr_velicina = $this->LanguageHelper->ChangeTableNameR("pr_velicina");
		$pr_proizvodvelicina= $this->LanguageHelper->ChangeTableNameR("pr_proizvodvelicina");


		switch ($relation_class_name)
		{
			case $pr_karakteristika:
				$vezna_klasa = $pr_karakteristikaproizvoda;
				$uslov_join = "IJ1.karakteristikaid= IJ2.karakteristikaid";
				break;
			case $pr_kategorija:
				$vezna_klasa = $pr_proizvodkategorija;
				$uslov_join = "IJ1.kategorijaid= IJ2.kategorijaid";
				break;
			case $pr_grupaproizvoda:
				$vezna_klasa = $pr_proizvodgrupaproizvoda;
				$uslov_join = "IJ1.grupaproizvodaid= IJ2.grupaproizvodaid";
				break;
			case $pr_velicina:
				$vezna_klasa = $pr_proizvodvelicina;
				$uslov_join = "IJ1.velicinaid= IJ2.velicinaid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prproizvodjac":
				if(count($result_set)>0) $this->PrProizvodjac->napuni($result_set);
				break;
			case "prtipproizvoda":
				if(count($result_set)>0) $this->PrTipProizvoda->napuni($result_set);
				break;
			case "sfstatus":
				if(count($result_set)>0) $this->SfStatus->napuni($result_set);
				break;
			case "sfcountries":
				if(count($result_set)>0) $this->SfCountries->napuni($result_set);
				break;
			case "prkarakteristika":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$kar = $this->ObjectFactory->createObject("PrKarakteristika",-1);
					$kar->napuni($db_res);
					array_push($this->PrKarakteristika,$kar);}
				break;
			case "prkategorija":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$kateg = $this->ObjectFactory->createObject("PrKategorija",-1);
					$kateg->napuni($db_res);
					array_push($this->PrKategorija,$kateg);}
				break;
			case "prgrupaproizvoda":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$grp = $this->ObjectFactory->createObject("PrGrupaProizvoda",-1);
					$grp->napuni($db_res);
					array_push($this->PrGrupaProizvoda,$grp);}
				break;
			case "prproizvodocena":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$ocena = $this->ObjectFactory->createObject("PrProizvodOcena",-1);
					$ocena->napuni($db_res);
					array_push($this->PrProizvodOcena,$ocena);}
				break;
			case "prproizvodkomentar":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$kom = $this->ObjectFactory->createObject("PrProizvodKomentar",-1);
					$kom->napuni($db_res);
					array_push($this->PrProizvodKomentar,$kom);}
				break;
			case "prvelicina":
				if(count($result_set)>0)
					foreach($result_set as $db_res){
					$velicine = $this->ObjectFactory->createObject("PrVelicina",-1);
					$velicine->napuni($db_res);
					array_push($this->PrVelicina, $velicine);}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
			$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
			$arr = array_merge($arr, array("sifra" => $this->getSifra()));
			$arr = array_merge($arr, array("oem" => $this->getOem()));
			$arr = array_merge($arr, array("kratakopis" => $this->getKratakOpis()));
			$arr = array_merge($arr, array("opis" => $this->getOpis()));
			$arr = array_merge($arr, array("cenaa" => $this->getCenaA()));
			$arr = array_merge($arr, array("cenaaformatirano" => $this->getCenaAFormatirano()));
			$arr = array_merge($arr, array("cenab" => $this->getCenaB()));
			$arr = array_merge($arr, array("cenabformatirano" => $this->getCenaBFormatirano()));
			$arr = array_merge($arr, array("cenaamp" => $this->getCenaAMP()));
			$arr = array_merge($arr, array("cenaampformatirano" => $this->getCenaAMPFormatirano()));
			$arr = array_merge($arr, array("cenabmp" => $this->getCenaBMP()));
			$arr = array_merge($arr, array("cenabmpformatirano" => $this->getCenaBMPFormatirano()));
			$arr = array_merge($arr, array("popust" => $this->getPopust()));
			$arr = array_merge($arr, array("kurs" => $this->getKurs()));
			$arr = array_merge($arr, array("dimenzije" => $this->getDimenzije()));
			$arr = array_merge($arr, array("kolicina" => $this->getKolicina()));
			$arr = array_merge($arr, array("slika" => $this->getSlika()));
			$arr = array_merge($arr, array("slikaover" => $this->getSlikaOver()));
			$arr = array_merge($arr, array("country" => $this->getCountry()));
			$arr = array_merge($arr, array("countryid" => $this->getCountryID()));
			$arr = array_merge($arr, array("lokacija" => $this->getLokacija()));
			$arr = array_merge($arr, array("napomena" => $this->getNapomena()));
			$arr = array_merge($arr, array("napomenaadd" => $this->getNapomenaAdd()));
			$arr = array_merge($arr, array("proizvodjac" => $this->getProizvodjac()));
			$arr = array_merge($arr, array("proizvodjacid" => $this->getProizvodjacID()));
			$arr = array_merge($arr, array("slikathumb" => $this->getSlikaThumb()));
			$arr = array_merge($arr, array("tipproizvoda" => $this->getTipProizvoda()));
			$arr = array_merge($arr, array("kategorija" => $this->getKategorija()));
			$arr = array_merge($arr, array("grupaproizvoda" => $this->getGrupaProizvoda()));
			$arr = array_merge($arr, array("ocena" => $this->getOcena()));
			$arr = array_merge($arr, array("komentari" => $this->getKomentari()));
			$arr = array_merge($arr, array("komentariodobreni" => $this->getKomentariOdobreni()));
			$arr = array_merge($arr, array("kategorijelink" => $this->getKategorijeLink()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
			$arr = array_merge($arr, array("statusid" => $this->getSfStatusID()));
			$arr = array_merge($arr, array("statusvrednost" => $this->getSfStatusVrednost()));
			$arr = array_merge($arr, array("datum" => $this->getDatum()));
			$arr = array_merge($arr, array("tezina" => $this->getTezina()));
			$arr = array_merge($arr, array("link" => $this->getLink()));
			$arr = array_merge($arr, array("addonelink" => $this->getAddOneLink()));
			$arr = array_merge($arr, array("price" => $this->getPrice()));
			$arr = array_merge($arr, array("velicinaprint" => $this->getVelicinaPrint()));
			$arr = array_merge($arr, array("godina" => $this->getGodina()));
			$arr = array_merge($arr, array("cenabasket" => $this->getCenaBasket()));
			$arr = array_merge($arr, array("kolicinabasket" => $this->getKolicinaBasket()));
			$arr = array_merge($arr, array("medjuzbirbasket" => $this->getMedjuzbirBasket()));
		return $arr;
	}

	// get metode
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getNaziv()
	{
		return $this->Naziv;
	}
	function getSifra()
	{
		return $this->Sifra;
	}
	function getOem()
	{
		return $this->Oem;
	}
	function getOpis()
	{
		return $this->Opis;
	}
	function getKratakOpis()
	{
		return $this->KratakOpis;
	}
	function getCenaA()
	{
		return $this->CenaA * $this->Kurs  - ($this->CenaA * $this->Kurs * ($this->Popust / 100));
	}

	function getCenaAFormatirano()
	{
		return number_format(($this->CenaA * $this->Kurs - $this->CenaA * $this->Kurs * ($this->Popust / 100)),2, ',', '.');
	}

	function getCenaB()
	{
		return $this->CenaB * $this->Kurs - ($this->CenaB * $this->Kurs * ($this->Popust / 100));
	}

	function getCenaBFormatirano()
	{
		return number_format(($this->CenaB * $this->Kurs - $this->CenaB * $this->Kurs * ($this->Popust / 100)),2, ',', '.');
	}

	function getCenaAMP()
	{
		return $this->CenaAMP * $this->Kurs  - ($this->CenaAMP * $this->Kurs * ($this->Popust / 100));
	}

	function getCenaAMPFormatirano()
	{
		return number_format(($this->CenaAMP * $this->Kurs - $this->CenaAMP * $this->Kurs * ($this->Popust / 100)),2, ',', '.');
	}

	function getCenaBMP()
	{
		return $this->CenaBMP * $this->Kurs - ($this->CenaBMP * $this->Kurs * ($this->Popust / 100));
	}

	function getCenaBMPFormatirano()
	{
		return number_format(($this->CenaBMP * $this->Kurs - $this->CenaBMP * $this->Kurs * ($this->Popust / 100)),2, ',', '.');
	}

	function getDimenzije()
	{
		return $this->Dimenzije;
	}

	function getKolicina()
	{
		return $this->Kolicina;
	}

	function getKurs()
	{
		return $this->Kurs;
	}

	function getPopust()
	{
		return $this->Popust;
	}

	function getLink()
	{
		return $this->Link;
	}
	function getAddOneLink()
	{
		return $this->AddOneLink;
	}


	function getSlika()
	{
		if($this->Slika != "")
		{
			@Photo(extractFileName($this->Slika),"thumb",extractFilePathName($this->Slika));
		}
		return $this->Slika;
	}
	function getSlikaOver()
	{
		if($this->SlikaOver != "")
		{
			@Photo(extractFileName($this->SlikaOver),"thumb",extractFilePathName($this->SlikaOver));
		}
		return $this->SlikaOver;
	}
	function getSlikaThumb()
	{
		$this->SlikaThumb = extractFilePathName($this->Slika) . "/thumb_".extractFileName($this->Slika);
		return $this->SlikaThumb;
	}


	function getCountryID()
	{
		return $this->SfCountries->getCountryID();
	}
	function getCountry()
	{
		if($this->SfCountries->getCountryID() != -1)
		{
			return $this->SfCountries->Vrednost;
		}
		else return "no country";
	}


	function getLokacija()
	{
		return $this->Lokacija;
	}
	function getNapomena()
	{
		return $this->Napomena;
	}
	function getNapomenaAdd()
	{
		return $this->NapomenaAdd;
	}
	function getTezina()
	{
		return $this->Tezina;
	}
	function getPrice()
	{
		return $this->Price;
	}
	function getProizvodjac()
	{
		if($this->PrProizvodjac->getProizvodjacID() != -1)
		{
			return $this->PrProizvodjac->getNaziv();
		}
		else return "no manufacturer";
	}

	function getProizvodjacID()
	{
		return $this->PrProizvodjac->getProizvodjacID();
	}

	function getTipProizvoda()
	{
		if($this->PrTipProizvoda->getTipProizvodaID() == -1 )
		{
			return "no product type";
		}
		else return $this->PrTipProizvoda->getNaziv();
	}

	function getTipProizvodaID()
	{
		return $this->PrTipProizvoda->getTipProizvodaID();
	}

	function getKarakteristika()
	{
		return $this->PrKarakteristika;
	}
	function getKategorijeLink()
	{
		return $this->KategorijeLink;
	}
	function getKategorija()
	{
		$kategorije = "";
		if(count($this->PrKategorija) > 0)
		{
			foreach ($this->PrKategorija as $kateg)
			{
				$kategorije .= $kateg->Naziv .",";
			}

			$kategorije = substr($kategorije,0,strlen($kategorije)-1);
		}
		else
		{
			$kategorije = "no product category";
		}

		return $kategorije;
	}

	function getGrupaProizvoda()
	{
		$grupaproizvoda = "";
		if(count($this->PrGrupaProizvoda) > 0)
		{
			foreach ($this->PrGrupaProizvoda as $grupa)
			{
				$grupaproizvoda .= $grupa->getNaziv() .",";
			}

			$grupaproizvoda = substr($grupaproizvoda,0,strlen($grupaproizvoda)-1);
		}
		else
		{
			$grupaproizvoda = "no product group";
		}

		return $grupaproizvoda;
	}

	function getOcena()
	{
		$sum = 0;
		$cnt = count($this->PrProizvodOcena);
		if($cnt > 0)
		{
			if(count($this->PrProizvodOcena) > 0)
				foreach($this->PrProizvodOcena as $ocena)
				{
					$sum += $ocena->getOcena();
				}

			return $sum / $cnt;
		}

		return 0;
	}
	function getPrProizvodOcena()
	{
		return $this->PrProizvodOcena;
	}
	function getKomentari()
	{
		$komentari_arr = array();

		foreach($this->PrProizvodKomentar as $komentar)
		{
			$komentar->setOcenaKorisnika($this->getOcenaKorisnika($komentar->getUserID()));
			$komentari_arr[] = $komentar->toArray();
		}

		return $komentari_arr;
	}

	function getKomentariOdobreni()
	{
		$komentari_arr = array();

		foreach($this->PrProizvodKomentar as $komentar)
		{
			if($komentar->getSfStatusID() == STATUS_KOMENTAR_PROIZVODA_AKTIVAN)
			{
				$komentar->setOcenaKorisnika($this->getOcenaKorisnika($komentar->getUserID()));
				$komentari_arr[] = $komentar->toArray();
			}
		}

		return $komentari_arr;
	}

	private function getOcenaKorisnika($userId)
	{
		foreach($this->PrProizvodOcena as $ocenaProizvoda)
		{
			if($ocenaProizvoda->getUserID() == $userId) return $ocenaProizvoda->getOcena();
		}

		return 0;
	}

	function getSfStatus()
	{
		return $this->SfStatus->Vrednost;
	}

	function getSfStatusID()
	{
		return $this->SfStatus->StatusID;
	}

	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}

	function getSfStatusVrednost()
	{
		return $this->SfStatus->Vrednost;
	}


	function getGodina()
	{
		return $this->Godina;
	}


	function getVelicinaPrint()
	{
		$output = "";
		if($this->Velicina != null)
		{
			foreach($this->Velicina as $nwc)
			{
				$output .= $nwc->getNaziv() . ", ";
			}
		}

		return substr($output, 0, strlen($output)-2);
	}
	function getVelicina()
	{
		return $this->Velicina;
	}

	// set metode
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	function setSifra($val)
	{
		$this->Sifra= $val;
	}
	function setOem($val)
	{
		$this->Oem = $val;
	}
	function setOpis($val)
	{
		$this->Opis= $val;
	}
	function setKratakOpis($val)
	{
		$this->KratakOpis = $val;
	}
	function setCenaA($val)
	{
		$this->CenaA= $val;
	}
	function setCenaB($val)
	{
		$this->CenaB= $val;
	}
	function setCenaAMP($val)
	{
		$this->CenaAMP= $val;
	}
	function setCenaBMP($val)
	{
		$this->CenaBMP= $val;
	}
	function setDimenzije($val)
	{
		$this->Dimenzije= $val;
	}
	function setKolicina($val)
	{
		$this->Kolicina= $val;
	}
	function setSlika($val)
	{
		$this->Slika= $val;
	}
	function setSlikaOver($val)
	{
		$this->SlikaOver= $val;
	}
	function setCountryID($val)
	{
		$this->CountryID= $val;
	}
	function setLokacija($val)
	{
		$this->Lokacija= $val;
	}
	function setNapomena($val)
	{
		$this->Napomena= $val;
	}
	function setNapomenaAdd($val)
	{
		$this->NapomenaAdd= $val;
	}
	function setGodina($val)
	{
		$this->Godina= $val;
	}
	function setTezina($val)
	{
		$this->Tezina= $val;
	}
	function setPrProizvodjac($val)
	{
		$this->PrProizvodjac->setProizvodjacID($val);
	}
	function setPrTipProizvoda($val)
	{
		$this->PrTipProizvoda->TipProizvodaID= $val;
	}
	function setPrKarakteristika($val)
	{
		$this->PrKarakteristika = $val;
	}
	function setKategorijeLink($val)
	{
		$this->KategorijeLink = $val;
	}
	function setPrKategorija($val)
	{
		$this->PrKategorija = $val;
	}
	function setPrGrupaProizvoda($val)
	{
		$this->PrGrupaProizvoda = $val;
	}
	function getPrProizvodKomentar($val)
	{
		$this->PrProizvodKomentar = $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function setSfStatus($var)
	{
		$this->SfStatus->Vrednost = $var;
	}
	function setKurs($var)
	{
		$this->Kurs = $var;
	}

	function setPopust($var)
	{
		$this->Popust = $var;
	}

	function setLink($var)
	{
		$this->Link = $var;
	}
	function setAddOneLink($var)
	{
		$this->AddOneLink = $var;
	}
	function setVelicina($val)
	{
		$this->Velicina = $val;
	}
	function getOrder()
	{
		return $this->Order;
	}

	function setDatum($val)
	{
		$this->Datum = $val;
	}

	function getDatum()
	{
		return $this->LanguageHelper->getDateTranslated($this->Datum,"d-F-Y");
	}

	function setPrice($var)
	{
		$this->Price = $var;
	}

	function getLinkID()
	{
		return 'proizvodid='.$this->ProizvodID;
	}

	// dodato za pomoc pri orderingu
	function getKolicinaBasket()
	{
		return $this->KolicinaBasket;
	}

	function setKolicinaBasket($val)
	{
		$this->KolicinaBasket = $val;
	}

	function getCenaBasket()
	{
		if($this->CenaB!= 0)
		{
			return $this->CenaB;
		}

		return $this->CenaA;
	}

	function getMedjuzbirBasket()
	{
		return $this->getCenaBasket() * $this->getKolicinaBasket();
	}
}

// klasa PrProizvodList cuva listu objekata proizvoda
class PrProizvodList extends OpstiDomenskiObjekatList
{
	function GetProizvodIDsArray()
	{
		$proizvod_ids = array();

		foreach($this as $proizvod)
		{
			$proizvod_ids[] = $proizvod->ProizvodID;
		}
		return $proizvod_ids;
	}

	function GetProizvodIDs()
	{
		$proizvod_ids = "";
		foreach($this as $proizvod)
		{
			$proizvod_ids .= $proizvod->ProizvodID . ",";
		}
		return substr($proizvod_ids, 0, strlen($proizvod_ids)-1);
	}

	function GetProizvodIDsQueryIN()
	{
		$proizvod_query_in = "";

		if(strlen($this->GetProizvodIDs())> 0)
		{
			$proizvod_query_in = "proizvodid IN (". $this->GetProizvodIDs() .")";
		}
		else
		{
			$proizvod_query_in = "1=2";
		}

		return $proizvod_query_in;
	}



	public function SortByCenaAsc()
	{
	  $array_size = count($this);
	  for($dummy1 = ($array_size - 1); $dummy1 > 0; $dummy1--)
	  {
	    $large = $this[0]->getCenaA();
	    $index = 0;
	    for($dummy2 = 0; $dummy2 < ($dummy1 + 1); $dummy2++)
	    {
	      if($this[$dummy2]->getCenaA() > $large)
	      {
	        $large = $this[$dummy2]->getCenaA();
	        $index = $dummy2;
	      }
	    }
	    $this[$index]->setCenaA($this[$dummy1]->getCenaA());
	    $this[$dummy1]->setCenaA($large);
	  }
	}

	public function SortByCenaDesc()
	{
	  $array_size = count($this);
	  for($dummy1 = ($array_size - 1); $dummy1 > 0; $dummy1--)
	  {
	    $large = $this[0]->getCenaA();
	    $index = 0;
	    for($dummy2 = 0; $dummy2 < ($dummy1 + 1); $dummy2++)
	    {
	      if($this[$dummy2]->getCenaA() < $large)
	      {
	        $large = $this[$dummy2]->getCenaA();
	        $index = $dummy2;
	      }
	    }
	    $this[$index]->setCenaA($this[$dummy1]->getCenaA());
	    $this[$dummy1]->setCenaA($large);
	  }
	}
}

// klasa PrProizvodjac cuva podatke o proizvodjacima
class PrProizvodjac extends OpstiDomenskiObjekat
{
	private $ProizvodjacID;
	private $Naziv;
	private $Opis;
	private $PrProizvod;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrProizvod = array();

		$this->ProizvodjacID = -1;
		$this->Naziv = "Manufacturer title";
		$this->Opis = "Manufacturer description";

		$this->TableName = "pr_proizvodjac";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrProizvodjac from POST
	function PrProizvodjac_POST($post)
	{
		$this->PrProizvod = array();

		$this->ProizvodjacID= isset($post["proizvodjacid"]) ? $post["proizvodjacid"] : $this->ProizvodjacID;
		$this->Naziv= isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Opis= isset($post["opis"]) ? $post["opis"] : $this->Opis;
	}

	function vratiImenaAtributa() {return "`proizvodjacid`,`naziv`,`opis`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis);}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`opis` = ".$this->quote_smart($this->Opis);}
	function nazivVezeKaRoditelju(){ return "prproizvodjac";}
	function vratiUslovZaNadjiSlog(){ return "proizvodjacid=".$this->quote_smart($this->ProizvodjacID);}
	function vratiUslovZaSortiranje(){ return "proizvodjacid";}
	function vratiUslovZaNadjiSlogF(){ return "proizvodjacid=".$this->quote_smart($this->ProizvodjacID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->ProizvodjacID = $id;}
	function napuni($result_row)
	{
		$this->ProizvodjacID = $result_row->proizvodjacid;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
	}
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
			foreach($result_set as $result_row)
			{
				$prdj = $this->ObjectFactory->createObject("PrProizvodjac",-1);
				$prdj->ProizvodjacID = $result_row->proizvodjacid;
				$prdj->Naziv = $result_row->naziv;
				$prdj->Opis = $result_row->opis;
				array_push($al, $prdj);
			}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prproizvod":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$proiz = $this->ObjectFactory->createObject("PrProizvod",-1);
					$proiz->napuni($db_res);
					array_push($this->PrProizvod,$proiz);}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("proizvodjacid" => $this->getProizvodjacID()));
			$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
			$arr = array_merge($arr, array("opis" => $this->getOpis()));
		return $arr;
	}

	// get metode
	public function getProizvodjacID()
	{
		return $this->ProizvodjacID;
	}
	public function getNaziv()
	{
		return $this->Naziv;
	}
	public function getOpis()
	{
		return $this->Opis;
	}
	public function getPrProizvod()
	{
		return $this->PrProizvod;
	}
	// set metode
	public function setProizvodjacID($val)
	{
		$this->ProizvodjacID= $val;
	}
	public function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	public function setOpis($val)
	{
		$this->Opis= $val;
	}
	public function setPrProizvod($val)
	{
		$this->PrProizvod= $val;
	}
	public function getLinkID()
	{
		return 'proizvodjacid='.$this->ProizvodjacID;}
		function vratiIDKategorijeZaPlugin(){
		return $this->ProizvodjacID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Naziv;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->ProizvodjacID = $id;
	}
}

// klasa PrProizvodjacList cuva listu objekata proizvodjaca
class PrProizvodjacList extends OpstiDomenskiObjekatList
{

}

// klasa za vezu proizvoda sa drugim proizvodom
class PrProizvodProiz extends OpstiDomenskiObjekat
{
	public $ProizvodID;
	public $VProizvodID;
	public $Order;
	public $Kolicina;
	public $Vrsta;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ProizvodID = -1;
		$this->VProizvodID = -1;
		$this->Order = 0;
		$this->Kolicina = 1;
		$this->Vrsta = 0;

		$this->TableName = "pr_proizvodproizvod";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrProizvodGrupaProiz from POST
	function PrProizvodProiz_POST($post)
	{
		$this->ProizvodID= isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->VProizvodID= isset($post["vproizvodid"]) ? $post["vproizvodid"] : $this->VProizvodID;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
		$this->Kolicina = isset($post["kolicina"]) ? $post["kolicina"] : $this->Kolicina;
		$this->Vrsta = isset($post["vrsta"]) ? $post["vrsta"] : $this->Vrsta;
	}

	function vratiImenaAtributa() {return "`proizvodid`,`vproizvodid`,`order`,`kolicina`,`vrsta`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return
	$this->quote_smart($this->ProizvodID).",".
	$this->quote_smart($this->VProizvodID).",".
	$this->quote_smart($this->Order).",".
	$this->quote_smart($this->Kolicina).",".
	$this->quote_smart($this->Vrsta)
	;}
	function postaviVrednostiAtributa(){ return "
	`vproizvodid` = ".$this->quote_smart($this->VProizvodID).",
	`order` = ".$this->quote_smart($this->Order).",
	`kolicina` = ".$this->quote_smart($this->Kolicina).",
	`vrsta` = ".$this->quote_smart($this->Vrsta)
	;}
	function nazivVezeKaRoditelju(){ return "proizvodproizvod";}
	function vratiUslovZaNadjiSlog(){ return "proizvodid=".$this->quote_smart($this->ProizvodID)." AND vproizvodid=".$this->quote_smart($this->VProizvodID);}
	function vratiUslovZaSortiranje(){ return "";}
	function vratiUslovZaNadjiSlogF(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaNadjiSlogove(){ return "vproizvodid=".$this->quote_smart($this->VProizvodID);}
	function postaviID($id){ $this->ProizvodID = $id;}
	function vratiAtributZaMax(){return "`order`";}
	function napuni($result_row){
		$this->ProizvodID = $result_row->proizvodid;
		$this->VProizvodID = $result_row->vproizvodid;
		$this->Order = $result_row->order;
		$this->Kolicina = $result_row->kolicina;
		$this->Vrsta = $result_row->vrsta;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizpr = $this->ObjectFactory->createObject("PrProizvodProiz",-1);
				$proizpr->ProizvodID = $result_row->proizvodid;
				$proizpr->VProizvodID = $result_row->vproizvodid;
				$proizpr->Order = $result_row->order;
				$proizpr->Kolicina = $result_row->kolicina;
				$proizpr->Vrsta = $result_row->vrsta;
				array_push($al, $proizpr);
			}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
			$arr = array_merge($arr, array("vproizvodid" => $this->getVProizvodID()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
			$arr = array_merge($arr, array("kolicina" => $this->getKolicina()));
			$arr = array_merge($arr, array("vrsta" => $this->getVrsta()));
		return $arr;
	}


	// get metode
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getVProizvodID()
	{
		return $this->VProizvodID;
	}
	function getOrder()
	{
		return $this->Order;
	}
	function getKolicina()
	{
		return $this->Kolicina;
	}
		function getVrsta()
	{
		return $this->Vrsta;
	}
	// set metode
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setVProizvodID($val)
	{
		$this->VProizvodID= $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function setKolicina($val)
	{
		$this->Kolicina = $val;
	}
	function setVrsta($val)
	{
		$this->Vrsta = $val;
	}
}

// klasa PrVeznaGrupa cuva vezu proizvoda i njegove vezne grupe
class PrVeznaGrupa extends OpstiDomenskiObjekat
{
	public $ProizvodID;
	public $GrupaProizvodaID;
	public $Order;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ProizvodID = -1;
		$this->GrupaProizvodaID = -1;
		$this->Order = 0;

		$this->TableName = "pr_veznagrupa";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrProizvodGrupaProiz from POST
	function PrProizvodGrupaProiz_POST($post)
	{
		$this->ProizvodID= isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->GrupaProizvodaID= isset($post["grupaproizvodaid"]) ? $post["grupaproizvodaid"] : $this->GrupaProizvodaID;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
	}

	function vratiImenaAtributa() {return "`proizvodid`,`grupaproizvodaid`,`proizvodgrupaproiz_order`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->ProizvodID).",".$this->quote_smart($this->GrupaProizvodaID).",".$this->quote_smart($this->Order);}
	function postaviVrednostiAtributa(){ return "`grupaproizvodaid` = ".$this->quote_smart($this->GrupaProizvodaID).",`proizvodgrupaproiz_order` = ".$this->quote_smart($this->Order);}
	function nazivVezeKaRoditelju(){ return "prproizvodgrupaproiz";}
	function vratiUslovZaNadjiSlog(){ return "proizvodid=".$this->quote_smart($this->ProizvodID)." AND grupaproizvodaid=".$this->quote_smart($this->GrupaProizvodaID);}
	function vratiUslovZaSortiranje(){ return "proizvodgrupaproiz_order desc";}
	function vratiUslovZaNadjiSlogF(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaNadjiSlogove(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function postaviID($id){ $this->ProizvodID = $id;}
	function vratiAtributZaMax(){return "`proizvodgrupaproiz_order`";}
	function napuni($result_row){
		$this->ProizvodID = $result_row->proizvodid;
		$this->GrupaProizvodaID = $result_row->grupaproizvodaid;
		$this->Order = $result_row->proizvodgrupaproiz_order;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizgrppr = $this->ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
				$proizgrppr->ProizvodID = $result_row->proizvodid;
				$proizgrppr->GrupaProizvodaID = $result_row->grupaproizvodaid;
				$proizgrppr->Order = $result_row->proizvodgrupaproiz_order;
				array_push($al, $proizgrppr);
			}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
			$arr = array_merge($arr, array("grupaproizvodaid" => $this->getGrupaProizvodaID()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
		return $arr;
	}

	// get metode
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getGrupaProizvodaID()
	{
		return $this->GrupaProizvodaID;
	}
	function getOrder()
	{
		return $this->Order;
	}
	// set metode
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setGrupaProizvodaID($val)
	{
		$this->GrupaProizvodaID= $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function getLinkID()
	{
		return 'proizvodid='.$this->ProizvodID;}

	}

// klasa PrKitGrupa cuva vezu proizvoda i njegove kit grupe
class PrKitGrupa extends OpstiDomenskiObjekat
{
	public $ProizvodID;
	public $GrupaProizvodaID;
	public $Order;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ProizvodID = -1;
		$this->GrupaProizvodaID = -1;
		$this->Order = 0;

		$this->TableName = "pr_kitgrupa";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrProizvodGrupaProiz from POST
	function PrProizvodGrupaProiz_POST($post)
	{
		$this->ProizvodID= isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->GrupaProizvodaID= isset($post["grupaproizvodaid"]) ? $post["grupaproizvodaid"] : $this->GrupaProizvodaID;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
	}

	function vratiImenaAtributa() {return "`proizvodid`,`grupaproizvodaid`,`proizvodgrupaproiz_order`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->ProizvodID).",".$this->quote_smart($this->GrupaProizvodaID).",".$this->quote_smart($this->Order);}
	function postaviVrednostiAtributa(){ return "`grupaproizvodaid` = ".$this->quote_smart($this->GrupaProizvodaID).",`proizvodgrupaproiz_order` = ".$this->quote_smart($this->Order);}
	function nazivVezeKaRoditelju(){ return "prproizvodgrupaproiz";}
	function vratiUslovZaNadjiSlog(){ return "proizvodid=".$this->quote_smart($this->ProizvodID)." AND grupaproizvodaid=".$this->quote_smart($this->GrupaProizvodaID);}
	function vratiUslovZaSortiranje(){ return "proizvodgrupaproiz_order desc";}
	function vratiUslovZaNadjiSlogF(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaNadjiSlogove(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function postaviID($id){ $this->ProizvodID = $id;}
	function vratiAtributZaMax(){return "`proizvodgrupaproiz_order`";}
	function napuni($result_row){
		$this->ProizvodID = $result_row->proizvodid;
		$this->GrupaProizvodaID = $result_row->grupaproizvodaid;
		$this->Order = $result_row->proizvodgrupaproiz_order;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizgrppr = $this->ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
				$proizgrppr->ProizvodID = $result_row->proizvodid;
				$proizgrppr->GrupaProizvodaID = $result_row->grupaproizvodaid;
				$proizgrppr->Order = $result_row->proizvodgrupaproiz_order;
				array_push($al, $proizgrppr);
			}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
			$arr = array_merge($arr, array("grupaproizvodaid" => $this->getGrupaProizvodaID()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
		return $arr;
	}

	// get metode
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getGrupaProizvodaID()
	{
		return $this->GrupaProizvodaID;
	}
	function getOrder()
	{
		return $this->Order;
	}
	// set metode
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setGrupaProizvodaID($val)
	{
		$this->GrupaProizvodaID= $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function getLinkID()
	{
		return 'proizvodid='.$this->ProizvodID;}

	}




// klasa PrProizvodGrupaProiz cuva veze izmedju proizvoda i grupe proizvoda
class PrProizvodGrupaProiz extends OpstiDomenskiObjekat
{
	public $ProizvodID;
	public $GrupaProizvodaID;
	public $Order;
	public $kitnum;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ProizvodID = -1;
		$this->GrupaProizvodaID = -1;
		$this->Order = 0;
		$this->KitNum = 1;

		$this->TableName = "pr_proizvodgrupaproiz";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrProizvodGrupaProiz from POST
	function PrProizvodGrupaProiz_POST($post)
	{
		$this->ProizvodID= isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->GrupaProizvodaID= isset($post["grupaproizvodaid"]) ? $post["grupaproizvodaid"] : $this->GrupaProizvodaID;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
	}

	function vratiImenaAtributa() {return "`proizvodid`,`grupaproizvodaid`,`proizvodgrupaproiz_order`, `kitnum`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->ProizvodID).",".$this->quote_smart($this->GrupaProizvodaID).",".$this->quote_smart($this->Order).",".$this->quote_smart($this->KitNum);}
	function postaviVrednostiAtributa(){ return "`grupaproizvodaid` = ".$this->quote_smart($this->GrupaProizvodaID).",`proizvodgrupaproiz_order` = ".$this->quote_smart($this->Order).",`kitnum` = ".$this->quote_smart($this->KitNum);}
	function nazivVezeKaRoditelju(){ return "prproizvodgrupaproiz";}
	function vratiUslovZaNadjiSlog(){ return "proizvodid=".$this->quote_smart($this->ProizvodID)." AND grupaproizvodaid=".$this->quote_smart($this->GrupaProizvodaID);}
	function vratiUslovZaSortiranje(){ return "proizvodgrupaproiz_order desc";}
	function vratiUslovZaNadjiSlogF(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaNadjiSlogove(){ return "grupaproizvodaid=".$this->quote_smart($this->GrupaProizvodaID);}
	function postaviID($id){ $this->ProizvodID = $id;}
	function vratiAtributZaMax(){return "`proizvodgrupaproiz_order`";}
	function napuni($result_row){
		$this->ProizvodID = $result_row->proizvodid;
		$this->GrupaProizvodaID = $result_row->grupaproizvodaid;
		$this->Order = $result_row->proizvodgrupaproiz_order;
		$this->KitNum = $result_row->kitnum;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizgrppr = $this->ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
				$proizgrppr->ProizvodID = $result_row->proizvodid;
				$proizgrppr->GrupaProizvodaID = $result_row->grupaproizvodaid;
				$proizgrppr->Order = $result_row->proizvodgrupaproiz_order;
				$proizgrppr->KitNum = $result_row->kitnum;
				array_push($al, $proizgrppr);
			}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
			$arr = array_merge($arr, array("grupaproizvodaid" => $this->getGrupaProizvodaID()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
			$arr = array_merge($arr, array("kitnum" => $this->getKitNum()));
		return $arr;
	}

	// get metode
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getGrupaProizvodaID()
	{
		return $this->GrupaProizvodaID;
	}
	function getOrder()
	{
		return $this->Order;
	}
	function getKitNum()
	{
		return $this->KitNum;
	}
	// set metode
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setGrupaProizvodaID($val)
	{
		$this->GrupaProizvodaID= $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function setKitNum($val)
	{
		$this->KitNum = $val;
	}
	function getLinkID()
	{
		return 'proizvodid='.$this->ProizvodID;}

	}

// klasa PrGrupaProizvoda cuva podatke o grupama proizvoda
class PrGrupaProizvoda extends OpstiDomenskiObjekat
{
	public $GrupaProizvodaID;
	public $Naziv;
	private $Opis;
	private $Slika;
	private $ParentID;
	private $GrupaProizvodaOrder;
	private $TemplateID;
	private $StatusID;
	public $ConGroup;
	public $NLGroup;
	public $KitGroup;


	public $Template;
	public $SfStatus;

	private $CountProizvodi;

	public $PrProizvodList;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		$this->PrProizvodList = new PrProizvodList();

		$this->Template = $this->ObjectFactory->createObject("Template",-1);
		$this->Template->setTemplateID(-1);

		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfStatus->setStatusID(-1);

		$this->GrupaProizvodaID = -1;
		$this->Naziv = "";
		$this->Opis = "";
		$this->Slika = "";
		$this->ParentID = -1;
		$this->ConGroup = 0;
		$this->NLGroup = 0;
		$this->KitGroup = 0;
		$this->GrupaProizvodaOrder = -1;
		$this->CountProizvodi = 0;
		$this->TableName = "pr_grupaproizvoda";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrGrupaProizvoda from POST
	function PrGrupaProizvoda_POST($post)
	{
		$this->PrProizvodList = new PrProizvodList();

		$this->Template = $this->ObjectFactory->createObject("Template",-1);
		$this->Template->setTemplateID(isset($post["templateid"]) ? $post["templateid"] : $this->getTemplateID());

		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfStatus->setStatusID(isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->getStatusID());

		$this->GrupaProizvodaID = isset($post["grupaproizvodaid"]) ? $post["grupaproizvodaid"] : $this->GrupaProizvodaID;
		$this->Naziv = isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Opis = isset($post["opis"]) ? $post["opis"] : $this->Opis;
		$this->Slika = isset($post["slika"]) ? $post["slika"] : $this->Slika;
		$this->ParentID = isset($post["parentid"]) ? $post["parentid"] : $this->ParentID;
		$this->ConGroup = isset($post["congroup"]) ? $post["congroup"] : $this->ConGroup;
		$this->NLGroup = isset($post["nlgroup"]) ? $post["nlgroup"] : $this->NLGroup;
		$this->KitGroup = isset($post["kitgroup"]) ? $post["kitgroup"] : $this->KitGroup;
		$this->GrupaProizvodaOrder = isset($post["grupaproizvodaorder"]) ? $post["grupaproizvodaorder"] : $this->GrupaProizvodaOrder;
	}

	function vratiImenaAtributa() {return "`grupaproizvodaid`,`naziv`,`opis`,`slika`,`parentid`,`grupaproizvoda_order`,`templateid`,`statusid`,`congroup`,`nlgroup`,`kitgroup`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis).",".$this->quote_smart($this->Slika).",".$this->quote_smart($this->ParentID).",".$this->quote_smart($this->GrupaProizvodaOrder).",".$this->quote_smart($this->getTemplateID()).",
	".$this->quote_smart($this->getStatusID()).",
	".$this->quote_smart($this->getConGroup()).",
	".$this->quote_smart($this->getNLGroup()).",
	".$this->quote_smart($this->getKitGroup())
	;}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`opis` = ".$this->quote_smart($this->Opis).",`slika` = ".$this->quote_smart($this->Slika).",`parentid` = ".$this->quote_smart($this->ParentID).",`grupaproizvoda_order` = ".$this->quote_smart($this->GrupaProizvodaOrder).",`templateid` = ".$this->quote_smart($this->getTemplateID()).",
	`statusid` = ".$this->quote_smart($this->getStatusID()).",
	`congroup` = ".$this->quote_smart($this->getConGroup()).",
	`nlgroup` = ".$this->quote_smart($this->getNLGroup()).",
	`kitgroup` = ".$this->quote_smart($this->getKitGroup())
	;}
	function nazivVezeKaRoditelju(){ return "prgrupaproizvoda";}
	function vratiUslovZaNadjiSlog(){ return "grupaproizvodaid=".$this->quote_smart($this->GrupaProizvodaID);}
	function vratiUslovZaSortiranje(){ return "grupaproizvoda_order asc";}
	function vratiUslovZaNadjiSlogF(){ return "grupaproizvodaid=".$this->quote_smart($this->GrupaProizvodaID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->GrupaProizvodaID = $id;}
	function napuni($result_row){
		$this->GrupaProizvodaID = $result_row->grupaproizvodaid;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
		$this->Slika = $result_row->slika;
		$this->ParentID = $result_row->parentid;
		$this->GrupaProizvodaOrder = $result_row->grupaproizvoda_order;
		$this->Template->setTemplateID($result_row->templateid);
		$this->SfStatus->setStatusID($result_row->statusid);
		$this->ConGroup = $result_row->congroup;
		$this->NLGroup = $result_row->nlgroup;
		$this->KitGroup = $result_row->kitgroup;
		@$this->CountProizvodi = $result_row->countproizvodi;
	}
	function napuniNiz($result_set, &$al){
		//print_r($result_set);
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				@$gproiz = $this->ObjectFactory->createObject("PrGrupaProizvoda",-1);
				@$gproiz->GrupaProizvodaID = $result_row->grupaproizvodaid;
				@$gproiz->Naziv = $result_row->naziv;
				@$gproiz->Opis = $result_row->opis;
				@$gproiz->Slika = $result_row->slika;
				@$gproiz->ParentID = $result_row->parentid;
				@$gproiz->GrupaProizvodaOrder = $result_row->grupaproizvoda_order;
				@$gproiz->Template->setTemplateID($result_row->templateid);
				@$gproiz->SfStatus->setStatusID($result_row->statusid);
				@$gproiz->ConGroup = $result_row->congroup;
				@$gproiz->NLGroup = $result_row->nlgroup;
				@$gproiz->KitGroup = $result_row->kitgroup;
				@$gproiz->CountProizvodi = $result_row->countproizvodi;
				array_push($al, $gproiz);
			}
	}
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$pr_proizvod = $this->LanguageHelper->ChangeTableNameR("pr_proizvod");
		$pr_proizvodgrupaproiz = $this->LanguageHelper->ChangeTableNameR("pr_proizvodgrupaproiz");

		switch ($relation_class_name)
		{
			case $pr_proizvod:
				$vezna_klasa = $pr_proizvodgrupaproiz;
				$uslov_join = "IJ1.proizvodid = IJ2.proizvodid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prproizvod":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$proiz = $this->ObjectFactory->createObject("PrProizvod",-1);
					$proiz->napuni($db_res);
					$this->PrProizvodList->Add($proiz);}
				break;
			case "template":
				if(count($result_set)>0) $this->Template->napuni($result_set);
				break;
			case "sfstatus":
				if(count($result_set)>0) $this->SfStatus->napuni($result_set);
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();

			$arr = array_merge($arr, array("grupaproizvodaid" => $this->getGrupaProizvodaID()));
			$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
			$arr = array_merge($arr, array("opis" => $this->getOpis()));
			$arr = array_merge($arr, array("slika" => $this->getSlika()));
			$arr = array_merge($arr, array("parentid" => $this->getParentID()));
			$arr = array_merge($arr, array("grupaproizvodaorder" => $this->getGrupaProizvodaOrder()));
			$arr = array_merge($arr, array("templateid" => $this->Template->getTemplateID()));
			$arr = array_merge($arr, array("statusid" => $this->SfStatus->getStatusID()));
			$arr = array_merge($arr, array("congroup" => $this->getConGroup()));
			$arr = array_merge($arr, array("nlgroup" => $this->getNLGroup()));
			$arr = array_merge($arr, array("kitgroup" => $this->getKitGroup()));
			$arr = array_merge($arr, array("count" => $this->getCountProizvodi()));

			// deo koji puni proizvode
			$proizvodiArr = array();
			foreach($this->getPrProizvodList() as $proizvod)
			{
				$proizvodiArr[] = $proizvod->toArray();
			}

			$arr = array_merge($arr, array("proizvodi" => $proizvodiArr));

		return $arr;
	}

	function toArrayLight()
	{
		$arr = array();

			$arr = array_merge($arr, array("grupaproizvodaid" => $this->getGrupaProizvodaID()));
			$arr = array_merge($arr, array("naziv" => $this->getNaziv()));

		return $arr;
	}

	function toArrayHierarchy()
	{
		$arr = array(
					"id" => $this->getGrupaProizvodaID(),
					"parentid" => $this->getParentID(),
					"title" => $this->getNaziv(),
					"image" => $this->getSlika(),
					"link" => "?parentid=".$this->getGrupaProizvodaID(),
					"count" => $this->CountProizvodi,
					"templateid" => $this->getTemplateID()
			);
		return $arr;
	}

	// get metode ispravi ako ima nesto!!!
	function getGrupaProizvodaID()
	{
		return $this->GrupaProizvodaID;
	}
	function getNaziv()
	{
		return $this->Naziv;
	}
	function getOpis()
	{
		return $this->Opis;
	}
	function getSlika()
	{
		return $this->Slika;
	}
	function getParentID()
	{
		return $this->ParentID;
	}
	function getGrupaProizvodaOrder()
	{
		return $this->GrupaProizvodaOrder;
	}
	function getTemplateID()
	{
		return $this->Template->getTemplateID();
	}
	function getStatusID()
	{
		return $this->SfStatus->getStatusID();
	}
	function getConGroup()
	{
		return $this->ConGroup;
	}
	function getNLGroup()
	{
		return $this->NLGroup;
	}
	function getKitGroup()
	{
		return $this->KitGroup;
	}

	function getPrProizvodList()
	{
		return $this->PrProizvodList;
	}

	function getCountProizvodi()
	{
		return $this->CountProizvodi;
	}

	// set metode ispravi ako ima nesto!!!
	function setGrupaProizvodaID($val)
	{
		$this->GrupaProizvodaID= $val;
	}
	function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	function setOpis($val)
	{
		$this->Opis= $val;
	}
	function setSlika()
	{
		return $this->Slika;
	}
	function setParentID($val)
	{
		$this->ParentID= $val;
	}
	function setGrupaProizvodaOrder($val)
	{
		$this->GrupaProizvodaOrder= $val;
	}
	function setTemplateID($val)
	{
		$this->Template->setTemplateID($val);
	}
	function setStatusID($val)
	{
		$this->SfStatus->setStatusID($val);
	}
	function setConGroup()
	{
		return $this->ConGroup;
	}
	function setNLGroup()
	{
		return $this->NLGroup;
	}
	function setKitGroup()
	{
		return $this->KitGroup;
	}
	function setPrProizvodList($val)
	{
		$this->PrProizvodList = $val;
	}
	function getLinkID()
	{
		return 'grupaproizvodaid='.$this->GrupaProizvodaID;
	}

	// podesavanje za plugin
	function vratiIDKategorijeZaPlugin(){

		return $this->GrupaProizvodaID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Naziv;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->GrupaProizvodaID = $id;
	}

}

// klasa PrProizvodKategorija cuva veze izmedju proizvoda i kategorije proizvoda
class PrProizvodKategorija extends OpstiDomenskiObjekat
{
	public $ProizvodID;
	public $KategorijaID;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ProizvodID = -1;
		$this->KategorijaID = -1;

		$this->TableName = "pr_proizvodkategorija";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrProizvodKategorija from POST
	function PrProizvodKategorija_POST($post)
	{
		$this->ProizvodID= isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->KategorijaID= isset($post["kategorijaid"]) ? $post["kategorijaid"] : $this->KategorijaID;
	}

	function vratiImenaAtributa() {return "`proizvodid`,`kategorijaid`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->ProizvodID).",".$this->quote_smart($this->KategorijaID);}
	function postaviVrednostiAtributa(){ return "`kategorijaid` = ".$this->quote_smart($this->KategorijaID);}
	function nazivVezeKaRoditelju(){ return "prproizvodkategorija";}
	function vratiUslovZaNadjiSlog(){ return "proizvodid=".$this->quote_smart($this->ProizvodID)." AND kategorijaid=".$this->quote_smart($this->KategorijaID);}
	function vratiUslovZaSortiranje(){ return "proizvodid desc";}
	function vratiUslovZaNadjiSlogF(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaNadjiSlogove(){ return "proizvodid=".$this->quote_smart($this->ProizvodID);}
	function postaviID($id){ $this->ProizvodID = $id;}
	function napuni($result_row){
		$this->ProizvodID = $result_row->proizvodid;
		$this->KategorijaID = $result_row->kategorijaid;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizkateg = $this->ObjectFactory->createObject("PrProizvodKategorija",-1);
				$proizkateg->ProizvodID = $result_row->proizvodid;
				$proizkateg->KategorijaID = $result_row->kategorijaid;
				array_push($al, $proizkateg);
			}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
			$arr = array_merge($arr, array("kategorijaid" => $this->getKategorijaID()));
		return $arr;
	}

	// get metode
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getKategorijaID()
	{
		return $this->KategorijaID;
	}
	// set metode
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setKategorijaID($val)
	{
		$this->KategorijaID= $val;
	}
	function getLinkID()
	{
		return 'proizvodid='.$this->ProizvodID;}
	}

// klasa PrKategorija cuva podatke o kategorijama proizvoda
class PrKategorija extends OpstiDomenskiObjekat
{
	public $KategorijaID;
	public $Naziv;
	public $Opis;
	public $KratakOpis;
	public $Napomena;
	public $Slika;
	public $SlikaThumb;
	public $PrProizvodList;
	public $PrGrupaProizvoda;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrProizvodList = new PrProizvodList();
		$this->PrGrupaProizvoda = array();

		$this->KategorijaID = -1;
		$this->Naziv = "Naziv kategorije";
		$this->Opis = "Opis kategorije";
		$this->KratakOpis = "";
		$this->Napomena = "";
		$this->Slika = "";
		$this->SlikaThumb = "";

		$this->TableName = "pr_kategorija";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrKategorija from POST
	function PrKategorija_POST($post)
	{
		$this->PrProizvodList = new PrProizvodList();
		$this->PrGrupaProizvoda = array();

		$this->KategorijaID= isset($post["kategorijaid"]) ? $post["kategorijaid"] : $this->KategorijaID;
		$this->Naziv= isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Opis= isset($post["opis"]) ? $post["opis"] : $this->Opis;
		$this->KratakOpis= isset($post["kratakopis"]) ? $post["kratakopis"] : $this->KratakOpis;
		$this->Napomena = isset($post["napomena"]) ? $post["napomena"] : $this->Napomena;
		$this->Slika= isset($post["slika"]) ? $post["slika"] : $this->Slika;
	}

	function vratiImenaAtributa() {return "`kategorijaid`,`naziv`,`opis`,`kratak_opis`, `napomena`, `slika`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis).",".$this->quote_smart($this->KratakOpis).",".$this->quote_smart($this->Napomena).",".$this->quote_smart($this->Slika);}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`opis` = ".$this->quote_smart($this->Opis).",`kratak_opis` = ".$this->quote_smart($this->KratakOpis).",`slika` = ".$this->quote_smart($this->Slika).",`napomena` = ".$this->quote_smart($this->Napomena);}
	function nazivVezeKaRoditelju(){ return "prkategorija";}
	function vratiUslovZaNadjiSlog(){ return "kategorijaid=".$this->quote_smart($this->KategorijaID);}
	function vratiUslovZaSortiranje(){ return "naziv";}
	function vratiUslovZaNadjiSlogF(){ return "kategorijaid=".$this->quote_smart($this->KategorijaID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->KategorijaID = $id;}
	function napuni($result_row)
	{
		$this->KategorijaID = $result_row->kategorijaid;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
		$this->KratakOpis = $result_row->kratak_opis;
		$this->Napomena = $result_row->napomena;
		$this->Slika = $result_row->slika;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$prkateg = $this->ObjectFactory->createObject("PrKategorija",-1);
				$prkateg->KategorijaID = $result_row->kategorijaid;
				$prkateg->Naziv = $result_row->naziv;
				$prkateg->Opis = $result_row->opis;
				$prkateg->KratakOpis= $result_row->kratak_opis;
				$prkateg->Napomena= $result_row->napomena;
				$prkateg->Slika = $result_row->slika;
				array_push($al, $prkateg);
			}
	}
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$pr_proizvod = $this->LanguageHelper->ChangeTableNameR("pr_proizvod");
		$pr_proizvodkategorija = $this->LanguageHelper->ChangeTableNameR("pr_proizvodkategorija");
		$pr_grupakategorija = $this->LanguageHelper->ChangeTableNameR("pr_grupakategorija");
		$pr_kategorijagrupakateg = $this->LanguageHelper->ChangeTableNameR("pr_kategorijagrupakateg");

		switch ($relation_class_name)
		{
			case $pr_proizvod:
				$vezna_klasa = $pr_proizvodkategorija;
				$uslov_join = "IJ1.proizvodid = IJ2.proizvodid";
				break;
			case $pr_grupakategorija:
				$vezna_klasa = $pr_kategorijagrupakateg;
				$uslov_join = "IJ1.grupakategorijaid = IJ2.grupakategorijaid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prproizvod":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$proiz = $this->ObjectFactory->createObject("PrProizvod",-1);
					$proiz->napuni($db_res);
					$this->PrProizvodList->Add($proiz);}
				break;
			case "prgrupeproizvoda":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$grpproiz = $this->ObjectFactory->createObject("PrGrupaProizvoda",-1);
					$grpproiz->napuni($db_res);
					array_push($this->PrGrupaProizvoda,$grpproiz);}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("kategorijaid" => $this->getKategorijaID()));
			$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
			$arr = array_merge($arr, array("opis" => $this->getOpis()));
			$arr = array_merge($arr, array("kratakopis" => $this->getKratakOpis()));
			$arr = array_merge($arr, array("napomena" => $this->getNapomena()));
			$arr = array_merge($arr, array("slika" => $this->getSlika()));
			$arr = array_merge($arr, array("slikathumb" => $this->getSlikaThumb()));
		return $arr;
	}

	// get metode
	function getKategorijaID()
	{
		return $this->KategorijaID;
	}
	function getNaziv()
	{
		return $this->Naziv;
	}
	function getOpis()
	{
		return $this->Opis;
	}
	function getKratakOpis()
	{
		return $this->KratakOpis;
	}
	function getNapomena()
	{
		return $this->Napomena;
	}

	function getSlika()
	{
		if($this->Slika != "")
		{
			@Photo(extractFileName($this->Slika),"thumb",extractFilePathName($this->Slika));
		}
		return $this->Slika;
	}
	function getSlikaThumb()
	{
		$this->SlikaThumb = extractFilePathName($this->Slika) . "/thumb_".extractFileName($this->Slika);
		return $this->SlikaThumb;
	}

	function getPrProizvodList()
	{
		return $this->PrProizvodList;
	}
	function getPrGrupaProizvoda()
	{
		return $this->PrGrupaProizvoda;
	}
	// set metode
	function setKategorijaID($val)
	{
		$this->KategorijaID= $val;
	}
	function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	function setOpis($val)
	{
		$this->Opis= $val;
	}
	function setKratakOpis($val)
	{
		$this->KratakOpis= $val;
	}
	function setNapomena($val)
	{
		$this->Napomena= $val;
	}
	function setSlika($val)
	{
		$this->Slika= $val;
	}
	function setPrProizvodList($val)
	{
		$this->PrProizvodList= $val;
	}
	function setPrGrupaProizvoda($val)
	{
		$this->PrGrupaProizvoda= $val;
	}
	function getLinkID()
	{
		return 'kategorijaid='.$this->KategorijaID;
	}
	// podesavanje za plugin
		function vratiIDKategorijeZaPlugin(){

			return $this->KategorijaID;
		}

		function vratiNazivKategorijeZaPlugin(){
			return $this->Naziv;
		}

		function postaviIDKategorijeZaPlugin($id){
			$this->KategorijaID = $id;
		}
	}

// klasa PrKategorijaGrupaKateg cuva veze izmedju kategorija proizvoda i grupa kategorija
class PrKategorijaGrupaKateg extends OpstiDomenskiObjekat
{
	public $GrupaKategorijaID;
	public $KategorijaID;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->GrupaKategorijaID = -1;
		$this->KategorijaID = -1;

		$this->TableName = "pr_kategorijagrupakateg";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrKategorijaGrupaKateg from POST
	function PrKategorijaGrupaKateg_POST($post)
	{
		$this->GrupaKategorijaID= isset($post["grupakategorijaid"]) ? $post["grupakategorijaid"] : $this->GrupaKategorijaID;
		$this->KategorijaID= isset($post["kategorijaid"]) ? $post["kategorijaid"] : $this->KategorijaID;
	}

	function vratiImenaAtributa() {return "`grupakategorijaid`,`kategorijaid`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->GrupaKategorijaID).",".$this->quote_smart($this->KategorijaID);}
	function postaviVrednostiAtributa(){ return "`kategorijaid` = ".$this->quote_smart($this->KategorijaID)."";}
	function nazivVezeKaRoditelju(){ return "prkategorijagrupakateg";}
	function vratiUslovZaNadjiSlog(){ return "grupakategorijaid=".$this->quote_smart($this->GrupaKategorijaID)." AND kategorijaid=".$this->quote_smart($this->KategorijaID);}
	function vratiUslovZaSortiranje(){ return "grupakategorijaid desc";}
	function vratiUslovZaNadjiSlogF(){ return "grupakategorijaid=".$this->quote_smart($this->GrupaKategorijaID);}
	function vratiUslovZaNadjiSlogove(){ return "kategorijaid=".$this->quote_smart($this->KategorijaID);}
	function postaviID($id){ $this->GrupaKategorijaID = $id;}
	function napuni($result_row){
		$this->GrupaKategorijaID = $result_row->grupakategorijaid;
		$this->KategorijaID = $result_row->kategorijaid;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizkateg = $this->ObjectFactory->createObject("PrKategorijaGrupaKateg",-1);
				$proizkateg->GrupaKategorijaID = $result_row->grupakategorijaid;
				$proizkateg->KategorijaID = $result_row->kategorijaid;
				array_push($al, $proizkateg);
			}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("grupakategorijaid" => $this->getGrupaKategorijaID()));
		$arr = array_merge($arr, array("kategorijaid" => $this->getKategorijaID()));
		return $arr;
	}

	// get metode
	function getGrupaKategorijaID()
	{
		return $this->GrupaKategorijaID;
	}
	function getKategorijaID()
	{
		return $this->KategorijaID;
	}
	// set metode
	function setGrupaKategorijaID($val)
	{
		$this->GrupaKategorijaID= $val;
	}
	function setKategorijaID($val)
	{
		$this->KategorijaID= $val;
	}
	function getLinkID()
	{
		return 'grupakategorijaid='.$this->GrupaKategorijaID;
	}
	}

// klasa PrGrupaKategorija cuva podatke o grupama kategorija
class PrGrupaKategorija extends OpstiDomenskiObjekat
{
	public $GrupaKategorijaID;
	public $Naziv;
	public $Opis;
	public $PrKategorija;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrKategorija = array();

		$this->GrupaKategorijaID = -1;
		$this->Naziv = "Group category title";
		$this->Opis = "Group category description";

		$this->TableName = "pr_grupakategorija";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrGrupaKategorija from POST
	function PrGrupaKategorija_POST($post)
	{
		$this->PrKategorija = array();

		$this->GrupaKategorijaID= isset($post["grupakategorijaid"]) ? $post["grupakategorijaid"] : $this->GrupaKategorijaID;
		$this->Naziv= isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Opis= isset($post["opis"]) ? $post["opis"] : $this->Opis;
	}

	function vratiImenaAtributa() {return "`grupakategorijaid`,`naziv`,`opis`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis);}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`opis` = ".$this->quote_smart($this->Opis);}
	function nazivVezeKaRoditelju(){ return "prgrupakategorija";}
	function vratiUslovZaNadjiSlog(){ return "grupakategorijaid=".$this->quote_smart($this->GrupaKategorijaID);}
	function vratiUslovZaSortiranje(){ return "grupakategorijaid desc";}
	function vratiUslovZaNadjiSlogF(){ return "grupakategorijaid=".$this->quote_smart($this->GrupaKategorijaID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->GrupaKategorijaID = $id;}
	function napuni($result_row){
		$this->GrupaKategorijaID = $result_row->grupakategorijaid;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$gkateg = $this->ObjectFactory->createObject("PrGrupaKategorija",-1);
				$gkateg->GrupaKategorijaID = $result_row->grupakategorijaid;
				$gkateg->Naziv = $result_row->naziv;
				$gkateg->Opis = $result_row->opis;
				array_push($al, $gkateg);
			}
	}
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$pr_kategorija = $this->LanguageHelper->ChangeTableNameR("pr_kategorija");
		$pr_kategorijagrupakateg = $this->LanguageHelper->ChangeTableNameR("pr_kategorijagrupakateg");

		switch ($relation_class_name)
		{
			case $pr_kategorija:
				$vezna_klasa = $pr_kategorijagrupakateg;
				$uslov_join = "IJ1.kategorijaid = IJ2.kategorijaid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prkategorija":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$kateg = $this->ObjectFactory->createObject("PrKategorija",-1);
					$kateg->napuni($db_res);
					array_push($this->PrKategorija,$kateg);}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("grupakategorijaid" => $this->getGrupaKategorijaID()));
		$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
		$arr = array_merge($arr, array("opis" => $this->getOpis()));
		return $arr;
	}

	// get metode
	function getGrupaKategorijaID()
	{
		return $this->GrupaKategorijaID;
	}
	function getNaziv()
	{
		return $this->Naziv;
	}
	function getOpis()
	{
		return $this->Opis;
	}
	function getPrKategorija()
	{
		return $this->PrKategorija;
	}

	// set metode
	function setGrupaKategorijaID($val)
	{
		$this->GrupaKategorijaID= $val;
	}
	function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	function setOpis($val)
	{
		$this->Opis= $val;
	}
	function setPrKategorija($val)
	{
		$this->PrKategorija= $val;
	}
	function getLinkID()
	{
		return 'grupakategorijaid='.$this->GrupaKategorijaID;
	}
	// podesavanje za plugin
		function vratiIDKategorijeZaPlugin(){

			return $this->GrupaKategorijaID;
		}

		function vratiNazivKategorijeZaPlugin(){
			return $this->Naziv;
		}

		function postaviIDKategorijeZaPlugin($id){
			$this->GrupaKategorijaID = $id;
		}
	}

// klasa TipProizvoda cuva podatke o tipovima proizvoda
class PrTipProizvoda extends OpstiDomenskiObjekat
{
	public $TipProizvodaID;
	public $Naziv;
	public $Opis;
	public $Order;
	public $PrKarakteristika;

	public $PrProizvodList;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		$this->PrProizvodList = new PrProizvodList();

		$this->PrKarakteristika = array();

		$this->TipProizvodaID = -1;
		$this->Naziv = "Product type title";
		$this->Opis = "Product type description";
		$this->Order = 0;

		$this->TableName = "pr_tipproizvoda";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrGrupaKPrTipProizvoda from POST
	function PrTipProizvoda_POST($post)
	{
		$this->PrProizvodList = new PrProizvodList();

		$this->PrKarakteristika = array();

		$this->TipProizvodaID= isset($post["tipproizvodaid"]) ? $post["tipproizvodaid"] : $this->TipProizvodaID;
		$this->Naziv = isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Opis = isset($post["opis"]) ? $post["opis"] : $this->Opis;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
	}

	function vratiImenaAtributa() {return "`tipproizvodaid`,`naziv`,`opis`,`tipproizvoda_order`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis).",".$this->quote_smart($this->Order);}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`opis` = ".$this->quote_smart($this->Opis).",`tipproizvoda_order` = ".$this->quote_smart($this->Order);}
	function nazivVezeKaRoditelju(){ return "prtipproizvoda";}
	function vratiUslovZaNadjiSlog(){ return "tipproizvodaid=".$this->quote_smart($this->TipProizvodaID);}
	function vratiUslovZaSortiranje(){ return "`tipproizvoda_order` asc";}
	function vratiUslovZaNadjiSlogF(){ return "tipproizvodaid=".$this->quote_smart($this->TipProizvodaID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function vratiAtributZaMax(){return "`tipproizvoda_order`";}
	function postaviID($id){ $this->TipProizvodaID = $id;}
	function napuni($result_row){
		$this->TipProizvodaID = $result_row->tipproizvodaid;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
		$this->Order = $result_row->tipproizvoda_order;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$prtipp = $this->ObjectFactory->createObject("PrTipProizvoda",-1);
				$prtipp->TipProizvodaID = $result_row->tipproizvodaid;
				$prtipp->Naziv = $result_row->naziv;
				$prtipp->Opis = $result_row->opis;
				@$prtipp->Order = $result_row->tipproizvoda_order;
				array_push($al, $prtipp);
			}
	}
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$pr_grupakategorija = $this->LanguageHelper->ChangeTableNameR("pr_grupakategorija");
		$pr_kategorijagrupakateg = $this->LanguageHelper->ChangeTableNameR("pr_kategorijagrupakateg");

		switch ($relation_class_name)
		{
			case $pr_grupakategorija:
				$vezna_klasa = $pr_kategorijagrupakateg;
				$uslov_join = "IJ1.grupakategorijaid = IJ2.grupakategorijaid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prproizvod":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$proiz = $this->ObjectFactory->createObject("PrProizvod",-1);
					$proiz->napuni($db_res);
					//array_push($this->PrProizvod,$proiz);}
					$this->PrProizvodList->Add($proiz);}
				break;
			case "prkarakteristika":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$karakt = $this->ObjectFactory->createObject("PrKarakteristika",-1);
					$karakt->napuni($db_res);
					array_push($this->PrKarakteristika,$karakt);}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("tipproizvodaid" => $this->getTipProizvodaID()));
			$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
			$arr = array_merge($arr, array("opis" => $this->getOpis()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
			//$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
		return $arr;
	}

	// get metode ispravi ako ima nesto!!!
	function getTipProizvodaID()
	{
		return $this->TipProizvodaID;
	}
	function getNaziv()
	{
		return $this->Naziv;
	}
	function getOpis()
	{
		return $this->Opis;
	}
	function getProizvodList()
	{
		return $this->PrProizvodList;
	}
	function getKarakteristika()
	{
		return $this->PrKarakteristika;
	}
	// set metode ispravi ako ima nesto!!!
	function setTipProizvodaID($val)
	{
		$this->TipProizvodaID= $val;
	}
	function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	function setOpis($val)
	{
		$this->Opis= $val;
	}
	function setPrProizvodList($val)
	{
		$this->PrProizvodList = $val;
	}
	function setPrKarakteristika($val)
	{
		$this->PrKarakteristika= $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function getOrder()
	{
		return $this->Order;
	}

	function getLinkID()
	{
		return 'tipproizvodaid='.$this->TipProizvodaID;}
		// podesavanje za plugin
		function vratiIDKategorijeZaPlugin(){

			return $this->TipProizvodaID;
		}

		function vratiNazivKategorijeZaPlugin(){
			return $this->Naziv;
		}

		function postaviIDKategorijeZaPlugin($id){
			$this->TipProizvodaID = $id;
		}

	}

// klasa PrTipProizvodaGrupaTipovaProiz cuva veze izmedju tipova proizvoda i grupa tipova proizvoda
class PrTipProizvodaGrupaTipovaProiz extends OpstiDomenskiObjekat
{
	public $TipProizvodaID;
	public $GrupaTipovaProizvodaID;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->TipProizvodaID = -1;
		$this->GrupaTipovaProizvodaID = -1;
		$this->TableName = "pr_tipproizvodagrupatipovaproiz";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrTipProizvodaGrupaTipovaProiz from POST
	function PrTipProizvodaGrupaTipovaProiz_POST($post)
	{
		$this->TipProizvodaID= isset($post["tipproizvodaid"]) ? $post["tipproizvodaid"] : $this->TipProizvodaID;
		$this->GrupaTipovaProizvodaID= isset($post["grupatipovaproizvodaid"]) ? $post["grupatipovaproizvodaid"] : $this->GrupaTipovaProizvodaID;
	}

	function vratiImenaAtributa() {return "`tipproizvodaid`,`grupatipovaproizvodaid`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->TipProizvodaID.",".$this->GrupaTipovaProizvodaID;}
	function postaviVrednostiAtributa(){ return "`grupatipovaproizvodaid` = ".$this->GrupaTipovaProizvodaID;}
	function nazivVezeKaRoditelju(){ return "prtipproizvodagrupatipovaproiz";}
	function vratiUslovZaNadjiSlog(){ return "tipproizvodaid=".$this->TipProizvodaID." AND grupatipovaproizvodaid=".$this->GrupaTipovaProizvodaID;}
	function vratiUslovZaSortiranje(){ return "tipproizvodaid desc";}
	function vratiUslovZaNadjiSlogF(){ return "tipproizvodaid=".$this->TipProizvodaID;}
	function vratiUslovZaNadjiSlogove(){ return "grupatipovaproizvodaid=".$this->GrupaTipovaProizvodaID;}
	function postaviID($id){ $this->TipProizvodaID = $id;}
	function napuni($result_row){
		$this->TipProizvodaID = $result_row->tipproizvodaid;
		$this->GrupaTipovaProizvodaID = $result_row->grupatipovaproizvodaid;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$tipproizgtipproiz = $this->ObjectFactory->createObject("PrTipProizvodaGrupaTipovaProiz",-1);
				$tipproizgtipproiz->TipProizvodaID = $result_row->tipproizvodaid;
				$tipproizgtipproiz->GrupaTipovaProizvodaID = $result_row->grupatipovaproizvodaid;
				array_push($al, $tipproizgtipproiz);
			}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("tipproizvodaid" => $this->getTipProizvodaID()));
		$arr = array_merge($arr, array("grupatipovaproizvodaid" => $this->getGrupaTipovaProizvodaID()));
		return $arr;
	}

	// get metode
	function getTipProizvodaID()
	{
		return $this->TipProizvodaID;
	}
	function getGrupaTipovaProizvodaID()
	{
		return $this->GrupaTipovaProizvodaID;
	}
	// set metode
	function setTipProizvodaID($val)
	{
		$this->TipProizvodaID= $val;
	}
	function setGrupaTipovaProizvodaID($val)
	{
		$this->GrupaTipovaProizvodaID= $val;
	}
	function getLinkID()
	{
		return 'tipproizvodaid='.$this->TipProizvodaID;}


	}

// klasa PrGrupaTipovaProizvoda cuva podatke o grupama tipova proizvoda
class PrGrupaTipovaProizvoda extends OpstiDomenskiObjekat
{
	public $GrupaTipovaProizvodaID;
	public $Naziv;
	public $Opis;
	public $PrTipProizvoda;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrTipProizvoda = array();

		$this->GrupaTipovaProizvodaID = -1;
		$this->Naziv = "Naziv grupe tipova proizvoda";
		$this->Opis = "Opis grupe tipova proizvoda";

		$this->TableName = "pr_grupatipovaproizvoda";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrGrupaTipovaProizvoda from POST
	function PrGrupaTipovaProizvoda_POST($post)
	{
		$this->PrTipProizvoda = array();

		$this->GrupaTipovaProizvodaID= isset($post["grupatipovaproizvodaid"]) ? $post["grupatipovaproizvodaid"] : $this->GrupaTipovaProizvodaID;
		$this->Naziv= isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Opis= isset($post["opis"]) ? $post["opis"] : $this->Opis;
	}

	function vratiImenaAtributa() {return "`grupatipovaproizvodaid`,`naziv`,`opis`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis);}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`opis` = ".$this->quote_smart($this->Opis);}
	function nazivVezeKaRoditelju(){ return "prgrupatipovaproizvoda";}
	function vratiUslovZaNadjiSlog(){ return "grupatipovaproizvodaid=".$this->quote_smart($this->GrupaTipovaProizvodaID);}
	function vratiUslovZaSortiranje(){ return "grupatipovaproizvodaid desc";}
	function vratiUslovZaNadjiSlogF(){ return "grupatipovaproizvodaid=".$this->quote_smart($this->GrupaTipovaProizvodaID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->GrupaTipovaProizvodaID = $id;}
	function napuni($result_row)
	{
		$this->GrupaTipovaProizvodaID = $result_row->grupatipovaproizvodaid;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
	}

	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$gtproiz = $this->ObjectFactory->createObject("PrGrupaTipovaProizvoda",-1);
				$gtproiz->GrupaTipovaProizvodaID = $result_row->grupatipovaproizvodaid;
				$gtproiz->Naziv = $result_row->naziv;
				$gtproiz->Opis = $result_row->opis;
				array_push($al, $gtproiz);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$pr_tipproizvoda = $this->LanguageHelper->ChangeTableNameR("pr_tipproizvoda");
		$pr_tipproizvodagrupatipovaproiz = $this->LanguageHelper->ChangeTableNameR("pr_tipproizvodagrupatipovaproiz");

		switch ($relation_class_name)
		{
			case $pr_tipproizvoda:
				$vezna_klasa = $pr_tipproizvodagrupatipovaproiz;
				$uslov_join = "IJ1.tipproizvodaid = IJ2.tipproizvodaid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "prtipproizvoda":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$tproiz = $this->ObjectFactory->createObject("PrTipProizvoda",-1);
					$tproiz->napuni($db_res);
					array_push($this->PrTipProizvoda,$tproiz);}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("grupatipovaproizvodaid" => $this->getGrupaTipovaProizvodaID()));
		$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
		$arr = array_merge($arr, array("opis" => $this->getOpis()));
		return $arr;
	}

	// get metode
	function getGrupaTipovaProizvodaID()
	{
		return $this->GrupaTipovaProizvodaID;
	}
	function getNaziv()
	{
		return $this->Naziv;
	}
	function getOpis()
	{
		return $this->Opis;
	}
	function getPrTipProizvoda()
	{
		return $this->PrTipProizvoda;
	}
	// set metode
	function setGrupaTipovaProizvodaID($val)
	{
		$this->GrupaTipovaProizvodaID= $val;
	}
	function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	function setOpis($val)
	{
		$this->Opis= $val;
	}
	function setPrTipProizvoda($val)
	{
		$this->PrTipProizvoda= $val;
	}
	function getLinkID()
	{
		return 'grupatipovaproizvodaid='.$this->GrupaTipovaProizvodaID;
	}
	// za konfigurisanje plguina
		function vratiIDKategorijeZaPlugin(){

			return $this->GrupaTipovaProizvodaID;
		}

		function vratiNazivKategorijeZaPlugin(){
			return $this->Naziv;
		}

		function postaviIDKategorijeZaPlugin($id){
			$this->GrupaTipovaProizvodaID = $id;
		}

	}

// klasa PrKarakteristikaProizvoda cuva veze izmedju karakteristike proizvoda i proizvoda i dodaje vrednost za datu karakteristiku
class PrKarakteristikaProizvoda extends OpstiDomenskiObjekat
{
	public $KarakteristikaID;
	public $ProizvodID;
	public $Vrednost;
	public $PrKarakteristikaElement;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrKarakteristikaElement = $this->ObjectFactory->createObject("PrKarakteristikaElement",-1);
		$this->PrKarakteristikaElement->KarakteristikaElementID = -1;

		$this->KarakteristikaID = -1;
		$this->ProizvodID = -1;
		$this->Vrednost = "";

		$this->TableName = "pr_karakteristikaproizvoda";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrKarakteristikaProizvoda from POST
	function PrKarakteristikaProizvoda_POST($post)
	{
		$this->PrKarakteristikaElement = $this->ObjectFactory->createObject("PrKarakteristikaElement",-1);

		$this->KarakteristikaID= isset($post["karakteristikaid"]) ? $post["karakteristikaid"] : $this->KarakteristikaID;
		$this->ProizvodID= isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->Vrednost= isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
		$this->PrKarakteristikaElement->KarakteristikaElementID = isset($post["karakteristikaelementid"]) ? $post["karakteristikaelementid"] : $this->PrKarakteristikaElement->KarakteristikaElementID;
	}
	function vratiImenaAtributa() {return "`karakteristikaid`,`proizvodid`,`vrednost`,`karakteristika_element_id`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->KarakteristikaID).",".$this->quote_smart($this->ProizvodID).",".$this->quote_smart($this->Vrednost).",".$this->quote_smart($this->PrKarakteristikaElement->KarakteristikaElementID);}
	function postaviVrednostiAtributa(){ return "`proizvodid`=".$this->quote_smart($this->ProizvodID).",`vrednost`=".$this->quote_smart($this->Vrednost).",`karakteristika_element_id`=".$this->quote_smart($this->PrKarakteristikaElement->KarakteristikaElementID);}
	function nazivVezeKaRoditelju(){ return "prkarakteristikaproizvoda";}
	function vratiUslovZaNadjiSlog(){ return "karakteristikaid=".$this->quote_smart($this->KarakteristikaID)." AND proizvodid=".$this->quote_smart($this->ProizvodID);}
	function vratiUslovZaSortiranje(){ return "karakteristikaid desc";}
	function vratiUslovZaNadjiSlogF(){ return "karakteristikaid=".$this->quote_smart($this->KarakteristikaID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->KarakteristikaID = $id;}
	function napuni($result_row){
		$this->KarakteristikaID = $result_row->karakteristikaid;
		$this->ProizvodID = $result_row->proizvodid;
		$this->Vrednost = $result_row->vrednost;
		$this->PrKarakteristikaElement->KarakteristikaElementID = $result_row->karakteristika_element_id;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$karaktproiz = $this->ObjectFactory->createObject("PrKarakteristikaProizvoda",-1);
				$karaktproiz->KarakteristikaID = $result_row->karakteristikaid;
				$karaktproiz->ProizvodID = $result_row->proizvodid;
				$karaktproiz->Vrednost = $result_row->vrednost;
				$karaktproiz->PrKarakteristikaElement->KarakteristikaElementID = $result_row->karakteristika_element_id;
				array_push($al, $karaktproiz);
			}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "prkarakteristikaelement":
				if(count($result_set)>0) $this->PrKarakteristikaElement->napuni($result_set);
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("karakteristikaid" => $this->getKarakteristikaID()));
		$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
		$arr = array_merge($arr, array("karakteristikaelementid" => $this->getKarakteristikaElementID()));
		return $arr;
	}

	// get metode
	function getKarakteristikaID()
	{
		return $this->KarakteristikaID;
	}
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getVrednost()
	{
		return $this->Vrednost;
	}
	function getKarakteristikaElementID()
	{
		return $this->PrKarakteristikaElement->KarakteristikaElementID;
	}
	// set metode
	function setKarakteristikaID($val)
	{
		$this->KarakteristikaID= $val;
	}
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setVrednost($val)
	{
		$this->Vrednost= $val;
	}
	function getLinkID()
	{
		return 'karakteristikaid='.$this->KarakteristikaID;
	}
	function setKarakteristikaElementID($val)
	{
		$this->PrKarakteristikaElement->KarakteristikaElementID = $val;
	}
}

// klasa PrKarakteristika cuva nazive dodatnih karakteristika proizvoda
class PrKarakteristika extends OpstiDomenskiObjekat
{
	public $KarakteristikaID;
	public $Naziv;
	public $Order;
	public $PrTipProizvoda;
	public $PrKarakteristikaVrsta;

	public $Vrednost;
	public $PrKarakteristikaElement;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrTipProizvoda = $this->ObjectFactory->createObject("PrTipProizvoda",-1);
		$this->PrKarakteristikaVrsta = $this->ObjectFactory->createObject("PrKarakteristikaVrsta",-1);
		$this->PrKarakteristikaElement = $this->ObjectFactory->createObject("PrKarakteristikaElement",-1);

		$this->PrTipProizvoda->TipProizvodaID = -1;
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = -1;
		$this->PrKarakteristikaElement->KarakteristikaElementID = -1;
		$this->KarakteristikaID = -1;
		$this->Naziv = "Opšta karakteristika";
		$this->Order = 0;
		$this->Vrednost = "Vrednost karakteristike";


		$this->TableName = "pr_karakteristika";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrKarakteristika from POST
	function PrKarakteristika_POST($post)
	{
		$this->PrTipProizvoda = $this->ObjectFactory->createObject("PrTipProizvoda",-1);
		$this->PrKarakteristikaVrsta = $this->ObjectFactory->createObject("PrKarakteristikaVrsta",-1);

		$this->PrTipProizvoda->TipProizvodaID = -1;
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = -1;
		$this->KarakteristikaID= isset($post["karakteristikaid"]) ? $post["karakteristikaid"] : $this->KarakteristikaID;
		$this->PrTipProizvoda->TipProizvodaID = isset($post["tipproizvodaid"]) ? $post["tipproizvodaid"] : $this->PrTipProizvoda->TipProizvodaID;
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = isset($post["karakteristikavrstaid"]) ? $post["karakteristikavrstaid"] : $this->PrKarakteristikaVrsta->KarakteristikaVrstaID;
		$this->PrKarakteristikaElement->KarakteristikaElementID = isset($post["karakteristikaelementid"]) ? $post["karakteristikaelementid"] : $this->PrKarakteristikaElement->KarakteristikaElementID;
		$this->Naziv= isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
		$this->Vrednost =  isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
	}

	function vratiImenaAtributa() {return "`karakteristikaid`,`tipproizvodaid`,`naziv`,`karakteristika_vrsta_id`,`karakteristika_order`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->getTipProizvodaID()).",".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->getKarakteristikaVrstaID()).",".$this->quote_smart($this->Order);}
	function postaviVrednostiAtributa(){ return "`tipproizvodaid` = ".$this->quote_smart($this->getTipProizvodaID()).",`naziv` = ".$this->quote_smart($this->Naziv).",`karakteristika_vrsta_id` = ".$this->quote_smart($this->getKarakteristikaVrstaID()). ",`karakteristika_order` = ".$this->quote_smart($this->Order);}
	function nazivVezeKaRoditelju(){ return "prkarakteristika";}
	function vratiUslovZaNadjiSlog(){ return "karakteristikaid=".$this->quote_smart($this->KarakteristikaID);}
	function vratiUslovZaSortiranje(){ return "`karakteristika_order` asc";}
	function vratiUslovZaNadjiSlogF(){ return "karakteristikaid=".$this->quote_smart($this->KarakteristikaID);}
	function vratiUslovZaNadjiSlogove(){ return "tipproizvodaid=".$this->quote_smart($this->PrTipProizvoda->TipProizvodaID);}
	function vratiAtributZaMax(){ return "`karakteristika_order`";}

	function postaviID($id){ $this->KarakteristikaID = $id;}
	function napuni($result_row){
		$this->KarakteristikaID = $result_row->karakteristikaid;
		$this->PrTipProizvoda->TipProizvodaID = $result_row->tipproizvodaid;
		$this->Naziv = $result_row->naziv;
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = $result_row->karakteristika_vrsta_id;
		$this->Order = $result_row->karakteristika_order;
		@$this->Vrednost = $result_row->vrednost;
		@$this->PrKarakteristikaElement->KarakteristikaElementID = $result_row->karakteristika_element_id;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$prkarakt = $this->ObjectFactory->createObject("PrKarakteristika",-1);
				$prkarakt->KarakteristikaID = $result_row->karakteristikaid;
				$prkarakt->PrTipProizvoda->TipProizvodaID = $result_row->tipproizvodaid;
				$prkarakt->Naziv = $result_row->naziv;
				$prkarakt->PrKarakteristikaVrsta->KarakteristikaVrstaID = $result_row->karakteristika_vrsta_id;
				$prkarakt->Order = $result_row->karakteristika_order;
				$prkarakt->Vrednost= $result_row->vrednost;
				$prkarakt->PrKarakteristikaElement->KarakteristikaElementID = $result_row->karaktristika_element_id;
				array_push($al, $prkarakt);
			}
	}
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		 $pr_proizvod = $this->LanguageHelper->ChangeTableNameR("pr_proizvod");
		 $pr_karakteristikaproizvoda = $this->LanguageHelper->ChangeTableNameR("pr_karakteristikaproizvoda");

		switch ($relation_class_name)
		{
			case $pr_proizvod:
				$vezna_klasa = $pr_karakteristikaproizvoda;
				$uslov_join = "IJ1.proizvodid = IJ2.proizvodid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prtipproizvoda":
				if(count($result_set)>0) $this->PrTipProizvoda->napuni($result_set);
				break;
			case "prkarakteristikavrsta":
				if(count($result_set)>0) $this->PrKarakteristikaVrsta->napuni($result_set);
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("karakteristikaid" => $this->getKarakteristikaID()));
		$arr = array_merge($arr, array("tipproizvodaid" => $this->getTipProizvodaID()));
		$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
		$arr = array_merge($arr, array("karakteristikavrstaid" => $this->getKarakteristikaVrstaID()));
		$arr = array_merge($arr, array("karakteristikaelementid" => $this->getKarakteristikaElementID()));
		$arr = array_merge($arr, array("order" => $this->getOrder()));
		return $arr;
	}

	// get metode
	function getKarakteristikaID()
	{
		return $this->KarakteristikaID;
	}
	function getTipProizvodaID()
	{
		return $this->PrTipProizvoda->TipProizvodaID;
	}
	function getNaziv()
	{
		return $this->Naziv;
	}
	function getKarakteristikaVrstaID()
	{
		return $this->PrKarakteristikaVrsta->KarakteristikaVrstaID;
	}
	function getOrder()
	{
		return $this->Order;
	}
	function getKarakteristikaElementID()
	{
		return $this->PrKarakteristikaElement->KarakteristikaElementID;
	}

	function getVrednost()
	{
		if($this->Vrednost != "" && $this->getKarakteristikaElementID() == "")
		{
			return $this->Vrednost;
		}
		else
		{
			$kkElement = $this->ObjectFactory->createObject("PrKarakteristikaElement",$this->getKarakteristikaElementID());
			return $kkElement->Vrednost;
		}

	}
	// set metode
	function setKarakteristikaID($val)
	{
		$this->KarakteristikaID= $val;
	}
	function setTipProizvodaID($val)
	{
		$this->PrTipProizvoda->TipProizvodaID = $val;
	}
	function setNaziv($val)
	{
		$this->Naziv= $val;
	}
	function setKarakteristikaVrstaID($val)
	{
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function setPrTipProizvoda($val)
	{
		$this->PrTipProizvoda= $val;
	}
	function getLinkID()
	{
		return 'karakteristikaid='.$this->KarakteristikaID;
	}
	}

// klasa PrKurs cuva kurs Evra u dinarima
class PrKurs extends OpstiDomenskiObjekat
{
	public $KursID;
	public $Kurs;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->KursID = -1;
		$this->Kurs = 0;

		$this->TableName = "pr_kurs";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrKurs from POST
	function PrKurs_POST($post)
	{
		$this->KursID = isset($post["kursid"]) ? $post["kursid"] : $this->KursID;
		$this->Kurs = isset($post["kurs"]) ? $post["kurs"] : $this->Kurs;
	}
	function vratiImenaAtributa() {return "`kursid`,`kurs`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Kurs);}
	function postaviVrednostiAtributa(){ return "`kurs` = ".$this->quote_smart($this->Kurs);}
	function nazivVezeKaRoditelju(){ return "";}
	function vratiUslovZaNadjiSlog(){ return "kursid=".$this->quote_smart($this->KursID);}
	function vratiUslovZaSortiranje(){ return "kursid";}
	function vratiUslovZaNadjiSlogF(){ return "kursid=".$this->quote_smart($this->KursID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->KursID = $id;}
	function napuni($result_row){
		$this->KursID= $result_row->kursid;
		$this->Kurs = $result_row->kurs;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$prdj = $this->ObjectFactory->createObject("PrKurs",-1);
				$prdj->KursID = $result_row->kursid;
				$prdj->Kurs = $result_row->kurs;
				array_push($al, $prdj);
			}
	}
	//
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("kursid" => $this->getKursID()));
			$arr = array_merge($arr, array("kurs" => $this->getKurs()));
		return $arr;
	}

	public function getKursID()
	{
		return $this->KursID;
	}
	public function getKurs()
	{
		return $this->Kurs;
	}

	public function setKursID($val)
	{
		$this->KursID = $val;
	}
	public function setKurs($val)
	{
		$this->Kurs = $val;
	}

	public function getLinkID()
	{
		return 'kursid='.$this->Kursid;
	}
}


// klasa PrPrice cuva limit za postarinu u dinarima
class PrPrice extends OpstiDomenskiObjekat
{
	public $PriceID;
	public $Price;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PriceID = -1;
		$this->Price = 0;

		$this->TableName = "pr_pricelimit";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrPrice from POST
	function PrPrice_POST($post)
	{
		$this->PriceID = isset($post["priceid"]) ? $post["priceid"] : $this->PriceID;
		$this->Price = isset($post["price"]) ? $post["price"] : $this->Price;
	}
	function vratiImenaAtributa() {return "`priceid`,`price`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Price);}
	function postaviVrednostiAtributa(){ return "`price` = ".$this->quote_smart($this->Price);}
	function nazivVezeKaRoditelju(){ return "";}
	function vratiUslovZaNadjiSlog(){ return "priceid=".$this->quote_smart($this->PriceID);}
	function vratiUslovZaSortiranje(){ return "priceid";}
	function vratiUslovZaNadjiSlogF(){ return "priceid=".$this->quote_smart($this->PriceID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->PriceID = $id;}
	function napuni($result_row){
		$this->PriceID= $result_row->priceid;
		$this->Price = $result_row->price;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$prdj = $this->ObjectFactory->createObject("PrPrice",-1);
				$prdj->PriceID = $result_row->priceid;
				$prdj->Price = $result_row->price;
				array_push($al, $prdj);
			}
	}
	//
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("priceid" => $this->getPriceID()));
			$arr = array_merge($arr, array("price" => $this->getPrice()));
		return $arr;
	}

	public function getPriceID()
	{
		return $this->PriceID;
	}
	public function getPrice()
	{
		return $this->Price;
	}

	public function setPriceID($val)
	{
		$this->PriceID = $val;
	}
	public function setPrice($val)
	{
		$this->Price = $val;
	}

	public function getLinkID()
	{
		return 'priceid='.$this->Priceid;
	}
}

// klasa PostPrice cuva postarine prema masi u dinarima
class PostPrice extends OpstiDomenskiObjekat
{
	public $PriceID;
	public $Price;
	public $WeightFrom;
	public $WeightTo;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PriceID = -1;
		$this->Price = 0;
		$this->WeightFrom = 0;
		$this->WeightTo = 0;


		$this->TableName = "pr_postprice";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PostPrice from POST
	function PostPrice_POST($post)
	{
		$this->PriceID = isset($post["priceid"]) ? $post["priceid"] : $this->PriceID;
		$this->Price = isset($post["price"]) ? $post["price"] : $this->Price;
		$this->WeightFrom = isset($post["weightfrom"]) ? $post["weightfrom"] : $this->WeightFrom;
		$this->WeightTo = isset($post["weightto"]) ? $post["weightto"] : $this->WeightTo;
	}
	function vratiImenaAtributa() {return "`priceid`,`price`,`rang`,'weightfrom','weightto'";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Price).",".$this->quote_smart($this->WeightFrom).",
	".$this->quote_smart($this->WeightTo);}

	function postaviVrednostiAtributa(){ return "`priceid` = ".$this->quote_smart($this->PriceID).",`price` = ".$this->quote_smart($this->Price).",
	`weightfrom`=".$this->quote_smart($this->WeightFrom).",`weightto`=".$this->quote_smart($this->WeightTo);}
	function nazivVezeKaRoditelju(){ return "";}
	function vratiUslovZaNadjiSlog(){ return "priceid=".$this->quote_smart($this->PriceID);}
	function vratiUslovZaNadjiSlog2(){ return "priceid=".$this->quote_smart($this->PriceID);}
	function vratiUslovZaSortiranje(){ return "priceid";}
	function vratiUslovZaNadjiSlogF(){ return "priceid=".$this->quote_smart($this->PriceID);}
	function vratiUslovZaNadjiSlogove(){ return "1=1";}
	function postaviID($id){ $this->PriceID = $id;}
	function napuni($result_row){
		$this->PriceID= $result_row->priceid;
		$this->Price = $result_row->price;
		$this->WeightFrom = $result_row->weightfrom;
		$this->WeightTo = $result_row->weightto;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$prdj = $this->ObjectFactory->createObject("PostPrice",-1);
				$prdj->PriceID = $result_row->priceid;
				$prdj->Price = $result_row->price;
				$prdj->WeightFrom = $result_row->weightfrom;
				$prdj->WeightTo = $result_row->weightto;
				array_push($al, $prdj);
			}
	}
	//
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("priceid" => $this->getPriceID()));
			$arr = array_merge($arr, array("price" => $this->getPrice()));
			$arr = array_merge($arr, array("price" => $this->getWeightFrom()));
			$arr = array_merge($arr, array("price" => $this->getWeightTo()));
		return $arr;
	}

	public function getPriceID()
	{
		return $this->PriceID;
	}
	public function getPrice()
	{
		return $this->Price;
	}
	public function getWeightFrom()
	{
		return $this->WeightFrom;
	}
	public function getWeightTo()
	{
		return $this->WeightTo;
	}

	public function setPriceID($val)
	{
		$this->PriceID = $val;
	}
	public function setPrice($val)
	{
		$this->Price = $val;
	}

	public function setWeightFrom($val)
	{
		$this->WeightFrom = $val;
	}
	public function setWeightTo($val)
	{
		$this->WeightTo = $val;
	}

	public function getLinkID()
	{
		return 'priceid='.$this->Priceid;
	}
}


// klasa PrKarakteristikaVrsta cuva vrste karakteristika koje imaju svoje Elemente
class PrKarakteristikaVrsta extends OpstiDomenskiObjekat
{
	public $KarakteristikaVrstaID;
	public $Naziv;
	public $Opis;
	public $PrKarakteristikaElement;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->KarakteristikaVrstaID = -1;
		$this->Naziv = "Nova vrsta karakteristike";
		$this->Opis = "";
		$this->PrKarakteristikaElement = array();

		$this->TableName= "pr_karakteristika_vrsta";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function PrKarakteristikaVrsta_POST($post)
	{
		$this->KarakteristikaVrstaID = isset($post["karakteristika_vrsta_id"]) ? $post["karakteristika_vrsta_id"] : $this->KarakteristikaVrstaID;
		$this->Naziv = isset($post["naziv"]) ? $post["naziv"] : $this->Naziv;
		$this->Opis = isset($post["opis"]) ? $post["opis"] : $this->Opis;
		$this->PrKarakteristikaElement = array();
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`karakteristika_vrsta_id`,`naziv`,`opis`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`naziv`=".$this->quote_smart($this->Naziv).",`opis`=".$this->quote_smart($this->Opis);}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "prkarakteristikavrsta";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "karakteristika_vrsta_id=".$this->quote_smart($this->KarakteristikaVrstaID);}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "karakteristika_vrsta_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "karakteristika_vrsta_id=".$this->quote_smart($this->KarakteristikaVrstaID);}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=1";}

	//Function postaviID
	function postaviID($id){ $this->KarakteristikaVrstaID = $this->quote_smart($id);}

	//Function napuni
	function napuni($result_row)
	{
		$this->KarakteristikaVrstaID = $result_row->karakteristika_vrsta_id;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("PrKarakteristikaVrsta",-1);
			$odo->KarakteristikaVrstaID = $result_row->karakteristika_vrsta_id;
			$odo->Naziv = $result_row->naziv;
			$odo->Opis = $result_row->opis;
			array_push($al, $odo);
		}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "prkarakteristikaelement":
				if(count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$odo = $this->ObjectFactory->createObject("PrKarakteristikaElement",-1);
					$odo->napuni($db_res);
					array_push($this->PrKarakteristikaElement,$odo);
				}
			break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("karakteristikavrstaid" => $this->getKarakteristikaVrstaID()));
		$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
		$arr = array_merge($arr, array("opis" => $this->getOpis()));
		return $arr;
	}

	function getKarakteristikaVrstaID()
	{
		return $this->KarakteristikaVrstaID;
	}
	function getNaziv()
	{
		if($this->Naziv == "")
			return "<i>Slobodan unos</i>";

		return $this->Naziv;
	}
	function getOpis()
	{
		return $this->Opis;
	}

	function setKarakteristikaVrstaID($val)
	{
		$this->KarakteristikaVrstaID = $val;
	}
	function setNaziv($val)
	{
		$this->Naziv = $val;
	}
	function setOpis($val)
	{
		$this->Opis = $val;
	}

	function getLinkID()
	{
		return 'karakteristika_vrsta_id='.$this->KarakteristikaVrstaID;
	}
}

// tabela cuva skupove elemenata koje pripadaju vrsti karakteristike
class PrKarakteristikaElement extends OpstiDomenskiObjekat
{
	public $KarakteristikaElementID;
	public $Vrednost;
	public $PrKarakteristikaVrsta;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrKarakteristikaVrsta = $this->ObjectFactory->createObject("PrKarakteristikaVrsta",-1);
		$this->KarakteristikaElementID = 0;
		$this->Vrednost = "";
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = -1;

		$this->TableName= "pr_karakteristika_element";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function PrKarakteristikaElement_POST($post)
	{
		$this->PrKarakteristikaVrsta = $this->ObjectFactory->createObject("PrKarakteristikaVrsta",-1);
		$this->KarakteristikaElementID = isset($post["karakteristikaelementid"]) ? $post["karakteristikaelementid"] : $this->KarakteristikaElementID;
		$this->Vrednost = isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = isset($post["karakteristikavrstaid"]) ? $post["karakteristikavrstaid"] : $this->PrKarakteristikaVrsta->KarakteristikaVrstaID;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`karakteristika_element_id`,`vrednost`,`karakteristika_vrsta_id`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Vrednost).",".$this->quote_smart($this->PrKarakteristikaVrsta->KarakteristikaVrstaID);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`vrednost`=".$this->quote_smart($this->Vrednost).",`karakteristika_vrsta_id`=".$this->quote_smart($this->PrKarakteristikaVrsta->KarakteristikaVrstaID);}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "prkarakteristikaelement";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "karakteristika_element_id=".$this->quote_smart($this->KarakteristikaElementID);}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "karakteristika_element_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "karakteristika_element_id=".$this->quote_smart($this->KarakteristikaElementID);}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=1";}

	//Function postaviID
	function postaviID($id){ $this->KarakteristikaElementID = $this->quote_smart($id);}

	//Function napuni
	function napuni($result_row)
	{
		$this->KarakteristikaElementID = $result_row->karakteristika_element_id;
		$this->Vrednost = $result_row->vrednost;
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = $result_row->karakteristika_vrsta_id;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("PrKarakteristikaElement",-1);
			$odo->KarakteristikaElementID = $result_row->karakteristika_element_id;
			$odo->Vrednost = $result_row->vrednost;
			$odo->PrKarakteristikaVrsta->KarakteristikaVrstaID = $result_row->karakteristika_vrsta_id;
			array_push($al, $odo);
		}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "prkarakteristikavrsta":
				if(count($result_set)>0) $this->PrKarakteristikaVrsta->napuni($result_set);
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("karakteristikaelementid" => $this->getKarakteristikaElementID()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
		$arr = array_merge($arr, array("karakteristikavrstaid" => $this->getKarakteristikaVrstaID()));
		return $arr;
	}

	function getKarakteristikaElementID()
	{
		return $this->KarakteristikaElementID;
	}
	function getVrednost()
	{
		return $this->Vrednost;
	}
	function getKarakteristikaVrstaID()
	{
		return $this->PrKarakteristikaVrsta->KarakteristikaVrstaID;
	}

	function setKarakteristikaElementID($val)
	{
		$this->KarakteristikaElementID = $val;
	}
	function setVrednost($val)
	{
		$this->Vrednost = $val;
	}
	function setKarakteristikaVrstaID($val)
	{
		$this->PrKarakteristikaVrsta->KarakteristikaVrstaID = $val;
	}

	function getLinkID()
	{
		return 'karakteristikaelementid='.$this->KarakteristikaElementID;
	}
}

class PrProizvodOcena extends OpstiDomenskiObjekat
{
	private $OcenaID;
	private $Ocena;
	private $PrProizvod;
	private $User;

	function __construct()
	{
		parent::__construct();

		$this->PrProizvod = $this->ObjectFactory->createObject("PrProizvod", -1);
		$this->User = $this->ObjectFactory->createObject("User", -1);

		$this->OcenaID = -1;
		$this->PrProizvod->setProizvodID(-1);
		$this->User->setUserID(-1);

		$this->Ocena = 1;

		$this->TableName= "pr_proizvodocena";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function PrProizvodOcena_POST($post)
	{
		$this->PrProizvod = $this->ObjectFactory->createObject("PrProizvod", -1);
		$this->User = $this->ObjectFactory->createObject("User", -1);

		$this->OcenaID= isset($post["ocenaid"]) ? $post["ocenaid"] : $this->getOcenaID();
		$this->Ocena= isset($post["ocena"]) ? $post["ocena"] : $this->getOcena();
	}

	function vratiImenaAtributa() {return "`ocena_id`,`ocena`,`proizvodid`,`userid`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart(str_replace("&nbsp;","",$this->Ocena)).",".$this->quote_smart($this->PrProizvod->getProizvodID()).",".$this->quote_smart($this->User->UserID);}
	function postaviVrednostiAtributa(){ return "`ocena` = ".$this->quote_smart($this->Ocena).",`proizvodid` = ".$this->quote_smart($this->PrProizvod->getProizvodID()).",`userid` = ".$this->quote_smart($this->User->UserID);}
	function nazivVezeKaRoditelju(){ return "prproizvodocena";}
	function vratiUslovZaNadjiSlog(){ return "ocena_id=".$this->quote_smart($this->getOcenaID());}
	function vratiUslovZaSortiranje(){ return "userid, proizvodid";}
	function vratiUslovZaNadjiSlogF(){ return "ocena_id=".$this->quote_smart($this->getOcenaID());}
	function vratiUslovZaNadjiSlogove(){ return "proizvodid=".$this->quote_smart($this->PrProizvod->getProizvodID());}
	function vratiAtributZaMax(){return "";}
	function postaviID($id){ $this->OcenaID = $id;}
	function napuni($result_row){

		$this->PrProizvod->setProizvodID($result_row->proizvodid);
		$this->User->setUserID($result_row->userid);
		$this->setOcena($result_row->ocena);
		$this->setOcenaID($result_row->ocena_id);
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizvodOcena = $this->ObjectFactory->createObject("PrProizvodOcena",-1);
				$proizvodOcena->PrProizvod->setProizvodID($result_row->proizvodid);
				$proizvodOcena->User->setUserID($result_row->userid);
				$proizvodOcena->setOcena($result_row->ocena);
				$proizvodOcena->setOcenaID($result_row->ocena_id);

				array_push($al, $proizvodOcena);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join){

	}

	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prproizvod":
				if(count($result_set)>0) $this->PrProizvod->napuni($result_set);
				break;
			case "user":
				if(count($result_set)>0) $this->User->napuni($result_set);
				break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("ocenaid" => $this->getOcenaID()));
		$arr = array_merge($arr, array("ocena" => $this->getOcena()));
		$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
		$arr = array_merge($arr, array("userid" => $this->getUserID()));
		return $arr;
	}

	function getOcenaID()
	{
		return $this->OcenaID;
	}

	function setOcenaID($val)
	{
		$this->OcenaID = $val;
	}

	function getOcena()
	{
		return $this->Ocena;
	}

	function setOcena($val)
	{
		$this->Ocena = $val;
	}

	function getProizvodID()
	{
		return $this->PrProizvod->getProizvodID();
	}

	function setProizvodID($val)
	{
		$this->PrProizvod->setProizvodID($val);
	}

	function getUserID()
	{
		return $this->User->getUserID();
	}

	function setUserID($val)
	{
		$this->User->setUserID($val);
	}

	function getLinkID()
	{
		return 'proizvodocenaid='.$this->OcenaID;
	}
}

class PrProizvodKomentar extends OpstiDomenskiObjekat
{
	private $KomentarID;
	private $Naslov;
	private $Komentar;
	private $ImePrezime;
	private $DatumKreiranja;

	// puni se iz drugog izvora
	private $OcenaKorisnika;

	public $PrProizvod;
	public $User;
	public $SfStatus;

	function __construct()
	{
		parent::__construct();

		$this->PrProizvod = $this->ObjectFactory->createObject("PrProizvod", -1);
		$this->User = $this->ObjectFactory->createObject("User", -1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus", -1);

		$this->KomentarID = -1;
		$this->Naslov = "";
		$this->Komentar = "";
		$this->ImePrezime="";
		$this->DatumKreiranja = time();

		$this->PrProizvod->setProizvodID(-1);
		$this->User->setUserID(-1);
		$this->SfStatus->setStatusID(-1);

		$this->TableName= "pr_proizvodkomentar";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function PrProizvodKomentar_POST($post)
	{
		$this->PrProizvod = $this->ObjectFactory->createObject("PrProizvod", -1);
		$this->User = $this->ObjectFactory->createObject("User", -1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus", -1);

		$this->KomentarID= isset($post["proizvodkomentarid"]) ? $post["proizvodkomentarid"] : $this->getKomentarID();
		$this->Naslov = isset($post["naslov"]) ? $post["naslov"] : $this->getNaslov();
		$this->Komentar = isset($post["komentar"]) ? $post["komentar"] : $this->getKomentar();
		$this->ImePrezime= isset($post["imeprezime"]) ? $post["imeprezime"] : $this->getImePrezime();
		$this->DatumKreiranja= isset($post["datumkreiranja"]) ? $post["datumkreiranja"] : $this->getDatumKreiranja();
		$this->PrProizvod->setProizvodID(isset($post["proizvodid"]) ? $post["proizvodid"] : $this->PrProizvod->getProizvodID());
		$this->User->setUserID(isset($post["userid"]) ? $post["userid"] : $this->User->getUserID());
		$this->SfStatus->setStatusID(isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->getStatusID());
	}

	function vratiImenaAtributa() {return "`komentar_id`,`naslov`,`komentar`,`ime_prezime`,`datum_kreiranja`,`proizvodid`,`userid`,`status_id`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart(str_replace("&nbsp;","",$this->Naslov)).",".$this->quote_smart(str_replace("&nbsp;","",$this->Komentar)).",".$this->quote_smart(str_replace("&nbsp;","",$this->ImePrezime)).",".$this->quote_smart(str_replace("&nbsp;","",$this->DatumKreiranja)).",".$this->quote_smart($this->PrProizvod->getProizvodID()).",".$this->quote_smart($this->User->UserID).",".$this->quote_smart($this->SfStatus->getStatusID());}
	function postaviVrednostiAtributa(){ return "`komentar_id` = ".$this->quote_smart($this->KomentarID).",`naslov` = ".$this->quote_smart($this->Naslov).",`ime_prezime` = ".$this->quote_smart($this->ImePrezime).",`datum_kreiranja` = ".$this->quote_smart($this->DatumKreiranja).",`komentar` = ".$this->quote_smart($this->Komentar).",`proizvodid` = ".$this->quote_smart($this->PrProizvod->getProizvodID()).",`userid` = ".$this->quote_smart($this->User->getUserID()).",`status_id` = ".$this->quote_smart($this->SfStatus->getStatusID());}
	function nazivVezeKaRoditelju(){ return "prproizvodkomentar";}
	function vratiUslovZaNadjiSlog(){ return "komentar_id=".$this->quote_smart($this->getKomentarID());}
	function vratiUslovZaSortiranje(){ return "userid, proizvodid";}
	function vratiUslovZaNadjiSlogF(){ return "komentar_id=".$this->quote_smart($this->getKomentarID());}
	function vratiUslovZaNadjiSlogove(){ return "proizvodid=".$this->quote_smart($this->PrProizvod->getProizvodID());}
	function vratiAtributZaMax(){return "";}
	function postaviID($id){ $this->KomentarID = $id;}
	function napuni($result_row){

		$this->setKomentarID($result_row->komentar_id);
		$this->setNaslov($result_row->naslov);
		$this->setKomentar($result_row->komentar);
		$this->setImePrezime($result_row->ime_prezime);
		$this->setDatumKreiranja($result_row->datum_kreiranja);

		$this->PrProizvod->setProizvodID($result_row->proizvodid);
		$this->User->setUserID($result_row->userid);
		$this->SfStatus->setStatusID($result_row->status_id);
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$proizvodKomentar = $this->ObjectFactory->createObject("PrProizvodKomentar",-1);

				$proizvodKomentar->setKomentarID($result_row->komentar_id);
				$proizvodKomentar->setNaslov($result_row->naslov);
				$proizvodKomentar->setKomentar($result_row->komentar);
				$proizvodKomentar->setImePrezime($result_row->ime_prezime);
				$proizvodKomentar->setDatumKreiranja($result_row->datum_kreiranja);

				$proizvodKomentar->PrProizvod->setProizvodID($result_row->proizvodid);
				$proizvodKomentar->User->setUserID($result_row->userid);
				$proizvodKomentar->SfStatus->setStatusID($result_row->status_id);

				array_push($al, $proizvodKomentar);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join){

	}

	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "sfstatus":
				if(count($result_set)>0) $this->SfStatus->napuni($result_set);
				break;
			case "prproizvod":
				if(count($result_set)>0) $this->PrProizvod->napuni($result_set);
				break;
			case "user":
				if(count($result_set)>0) $this->User->napuni($result_set);
				break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("proizvodkomentarid" => $this->getKomentarID()));
		$arr = array_merge($arr, array("naslov" => $this->getNaslov()));
		$arr = array_merge($arr, array("komentar" => $this->getKomentar()));
		$arr = array_merge($arr, array("imeprezime" => $this->getImePrezime()));
		$arr = array_merge($arr, array("datumkreiranja" => $this->getDatumKreiranja()));
		$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
		$arr = array_merge($arr, array("userid" => $this->getUserID()));
		$arr = array_merge($arr, array("proizvod" => $this->PrProizvod->toArray()));
		$arr = array_merge($arr, array("proizvodnaziv" => $this->PrProizvod->getNaziv()));
		$arr = array_merge($arr, array("user" => $this->User->toArray()));
		$arr = array_merge($arr, array("ocenakorisnika" => $this->getOcenaKorisnika()));
		$arr = array_merge($arr, array("statusid" => $this->getSfStatusID()));
		return $arr;
	}

	function getKomentarID()
	{
		return $this->KomentarID;
	}

	function setKomentarID($val)
	{
		$this->KomentarID = $val;
	}

	function getKomentar()
	{
		return $this->Komentar;
	}

	function setKomentar($val)
	{
		$this->Komentar = $val;
	}

	function getNaslov()
	{
		return $this->Naslov;
	}

	function setNaslov($val)
	{
		$this->Naslov = $val;
	}

	function getImePrezime()
	{
		return $this->ImePrezime;
	}

	function setImePrezime($val)
	{
		$this->ImePrezime = $val;
	}

	function getDatumKreiranja()
	{
		return $this->DatumKreiranja;
	}

	function setDatumKreiranja($val)
	{
		$this->DatumKreiranja = $val;
	}

	function getProizvodID()
	{
		return $this->PrProizvod->getProizvodID();
	}

	function setProizvodID($val)
	{
		$this->PrProizvod->setProizvodID($val);
	}

	function getOcenaKorisnika()
	{
		return $this->OcenaKorisnika;
	}

	function setOcenaKorisnika($val)
	{
		$this->OcenaKorisnika = $val;
	}

	function getUserID()
	{
		return $this->User->getUserID();
	}

	function setUserID($val)
	{
		$this->User->setUserID($val);
	}

	function getSfStatus()
	{
		return $this->SfStatus->getVrednost();
	}

	function getSfStatusID()
	{
		return $this->SfStatus->getStatusID();
	}

	function setSfStatusID($val)
	{
		$this->SfStatus->setStatusID($val);
	}

	function getLinkID()
	{
		return 'proizvodkomentarid='.$this->KomentarID;
	}
}

// velicine proizvoda
class PrVelicina extends OpstiDomenskiObjekat
{
	 public $VelicinaID;
	 public $Naziv;
	 public $Opis;
	 public $Redosled;
	 public $Status;
	 public $PrProizvod;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->VelicinaID = -1;
		$this->Naziv = "";
		$this->Opis = 0;
		$this->Redosled = 0;
		$this->PrProizvod = array();

		$this->TableName= "pr_velicina";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrVelicina from POST
	function PrVelicina_POST($post)
	{
		$this->VelicinaID = isset($post["velicinaid"]) ? $post["velicinaid"] : -1;
		$this->Naziv = isset($post["naziv"]) ? $post["naziv"] : -1;
		$this->Opis = isset($post["opis"]) ? $post["opis"] : -1;
		$this->Opis = isset($post["redosled"]) ? $post["redosled"] : -1;
		$this->Status = isset($post["status"]) ? $post["status"] : -1;
		$this->PrProizvod = array();
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`velicinaid`,`naziv`,`opis`,`redosled`,`status`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Naziv).",".$this->quote_smart($this->Opis).",".$this->quote_smart($this->Redosled).",".$this->quote_smart($this->Status);}
	function postaviVrednostiAtributa(){ return "`naziv` = ".$this->quote_smart($this->Naziv).",`opis` = ".$this->quote_smart($this->Opis).",`redosled` = ".$this->quote_smart($this->Redosled).",`status` = ".$this->quote_smart($this->Status);}
	function nazivVezeKaRoditelju(){ return "pr_velicina";}
	function vratiUslovZaNadjiSlog(){ return "velicinaid=".$this->quote_smart($this->VelicinaID);}
	function vratiUslovZaSortiranje(){ return "redosled";}
	function vratiUslovZaNadjiSlogF(){ return "velicinaid=".$this->quote_smart($this->VelicinaID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->VelicinaID = $id;}
	function napuni($result_row)
	{
		$this->VelicinaID = $result_row->velicinaid;
		$this->Naziv = $result_row->naziv;
		$this->Opis = $result_row->opis;
		$this->Redosled = $result_row->redosled;
		$this->Status = $result_row->status;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$velicine = $this->ObjectFactory->createObject("PrVelicina",-1);
				$velicine->VelicinaID = $result_row->velicinaid;
				$velicine->Naziv = $result_row->naziv;
				$velicine->Opis = $result_row->opis;
				$velicine->Redosled = $result_row->redosled;
				$velicine->Status = $result_row->status;
				array_push($al, $velicine);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$pr_proizvod = $this->LanguageHelper->ChangeTableNameR("pr_proizvod");
		$pr_proizvodvelicina = $this->LanguageHelper->ChangeTableNameR("pr_proizvodvelicina");

		switch ($relation_class_name)
		{
			case $pr_proizvod:
				$vezna_klasa = $pr_proizvodvelicina;
				$uslov_join = "IJ1.proizvodid= IJ2.pr_proizvodid";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "pr_proizvod":
				if(count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$proizvodi= $this->ObjectFactory->createObject("PrProizvod",-1);
					$proizvodi->napuni($db_res);
					array_push($this->PrProizvod,$proizvodi);
				}
			break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("velicinaid" => $this->getVelicinaID()));
			$arr = array_merge($arr, array("naziv" => $this->getNaziv()));
			$arr = array_merge($arr, array("opis" => $this->getOpis()));
			$arr = array_merge($arr, array("redosled" => $this->getRedosled()));
			$arr = array_merge($arr, array("status" => $this->getStatus()));
		return $arr;
	}

	// getter and setter
	function getVelicinaID()
	{
		return $this->VelicinaID;
	}

	function getNazivUnchanged()
	{
		return $this->Naziv;
	}
	function getNaziv()
	{
		return $this->LanguageHelper->Transliterate($this->Naziv);
	}
	function getOpis()
	{
		return $this->Opis;
	}
	function getRedosled()
	{
		return $this->Redosled;
	}
	function getStatus()
	{
		return $this->Status;
	}

	function setVelicinaID($val)
	{
		$this->VelicinaID = $val;
	}
	function setNaziv($val)
	{
		$this->Naziv = $val;
	}
	function setOpis($val)
	{
		$this->Opis = $val;
	}
	function setRedosled($val)
	{
		$this->Redosled = $val;
	}
	function setStatus($val)
	{
		$this->Status = $val;
	}

	function getLinkID()
	{
		return 'velicinaid='.$this->Velicinaid;
	}

	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){

		return $this->VelicinaID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Naziv;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->VelicinaID = $id;
	}
}
// klasa PrProizvodVelicina cuva vezu proizvoda i njegovih velicina
class PrProizvodVelicina extends OpstiDomenskiObjekat
{
	private $ProizvodID;
	private $VelicinaID;
	private $Sifra;
	private $CenaA;
	private $CenaB;
	private $CenaAMP;
	private $CenaBMP;
	private $Kolicina;


	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ProizvodID = -1;
		$this->VelicinaID = -1;
		$this->Sifra="";
		$this->CenaA=0;
		$this->CenaB=0;
		$this->CenaAMP=0;
		$this->CenaBMP=0;
		$this->Kolicina=0;
		$this->TableName = "pr_proizvodvelicina";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill ProizvodVelicina from POST
	function ProizvodVelicina_POST($post)
	{
		$this->ProizvodID = isset($post["proizvodid"]) ? $post["proizvodid"] : $this->ProizvodID;
		$this->VelicinaID = isset($post["velicinaid"]) ? $post["velicinaid"] : $this->VelicinaID;
		$this->Sifra = isset($post["sifra"]) ? $post["sifra"] : $this->Sifra;
		$this->CenaA = isset($post["cenaa"]) ? $post["cenaa"] : $this->CenaA;
		$this->CenaB = isset($post["cenab"]) ? $post["cenab"] : $this->CenaB;
		$this->CenaAMP = isset($post["cenaamp"]) ? $post["cenaamp"] : $this->CenaAMP;
		$this->CenaBMP = isset($post["cenabmp"]) ? $post["cenabmp"] : $this->CenaBMP;
		$this->Kolicina = isset($post["kolicina"]) ? $post["kolicina"] : $this->Kolicina;
	}

	function vratiImenaAtributa() {
		return "`proizvodid`,`velicinaid`,`sifra`,`cenaa`,`cenab`,`cenaamp`,`cenabmp`,`kolicina`";
	}
	function vratiImeKlase(){
		return $this->TableName;
	}
	function vratiVrednostiAtributa(){ return
		"".$this->quote_smart($this->ProizvodID).",
		".$this->quote_smart($this->VelicinaID).",
		".$this->quote_smart($this->Sifra).",
		".$this->quote_smart($this->CenaA).",
		".$this->quote_smart($this->CenaB).",
		".$this->quote_smart($this->CenaAMP).",
		".$this->quote_smart($this->CenaBMP).",
	".$this->quote_smart($this->Kolicina);}


	function postaviVrednostiAtributa(){
		return
		"`proizvodid` = ".$this->quote_smart($this->ProizvodID).",
		`velicinaid` = ".$this->quote_smart($this->VelicinaID).",
		`sifra` = ".$this->quote_smart($this->Sifra).",
		`cenaa` = ".$this->quote_smart($this->CenaA).",
		`cenab` = ".$this->quote_smart($this->CenaB).",
		`cenaamp` = ".$this->quote_smart($this->CenaAMP).",
		`cenabmp` = ".$this->quote_smart($this->CenaBMP).",
		`kolicina` = ".$this->quote_smart($this->Kolicina);
	}
	function nazivVezeKaRoditelju(){
		return "pr_proizvod";
	}
	function vratiUslovZaNadjiSlog(){
		return "proizvodid=".$this->quote_smart($this->ProizvodID)." AND velicinaid=".$this->quote_smart($this->VelicinaID);
	}
	function vratiUslovZaSortiranje(){
		return "";
	}
	function vratiUslovZaNadjiSlogF(){
		return "proizvodid=".$this->quote_smart($this->ProizvodID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "proizvodid=".$this->quote_smart($this->ProizvodID);
	}
	function postaviID($id){
		$this->ProizvodID = $id;
	}
	function vratiAtributZaMax(){
		return "";
	}
	function napuni($result_row){
		$this->ProizvodID = $result_row->proizvodid;
		$this->VelicinaID = $result_row->velicinaid;
		$this->Sifra = $result_row->sifra;
		$this->CenaA = $result_row->cenaa;
		$this->CenaB = $result_row->cenab;
		$this->CenaAMP = $result_row->cenaamp;
		$this->CenaBMP = $result_row->cenabmp;
		$this->Kolicina = $result_row->kolicina;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
			$velicina= $this->ObjectFactory->createObject("PrProizvodVelicina",-1);
			$velicina->ProizvodID = $result_row->proizvodid;
			$velicina->VelicinaID = $result_row->velicinaid;
			$velicina->Sifra = $result_row->sifra;
			$velicina->CenaA = $result_row->cenaa;
			$velicina->CenaB = $result_row->cenab;
			$velicina->CenaAMP = $result_row->cenaamp;
			$velicina->CenaBMP = $result_row->cenabmp;
			$velicina->Kolicina = $result_row->kolicina;
			array_push($al, $velicina);
		}
	}
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
		$arr = array_merge($arr, array("velicinaid" => $this->getVelicinaID()));
		$arr = array_merge($arr, array("sifra" => $this->getSifra()));
		$arr = array_merge($arr, array("cenaa" => $this->getCenaA()));
		$arr = array_merge($arr, array("cenab" => $this->getCenaB()));
		$arr = array_merge($arr, array("cenaamp" => $this->getCenaAMP()));
		$arr = array_merge($arr, array("cenabmp" => $this->getCenaBMP()));
		$arr = array_merge($arr, array("kolicina" => $this->getKolicina()));
		return $arr;
	}

	// get metode
	function getProizvodID()
	{
		return $this->ProizvodID;
	}
	function getVelicinaID()
	{
		return $this->VelicinaID;
	}
	function getSifra()
	{
		return $this->Sifra;
	}
	function getCenaA()
	{
		return $this->CenaA;
	}
	function getCenaB()
	{
		return $this->CenaB;
	}
	function getCenaAMP()
	{
		return $this->CenaAMP;
	}
	function getCenaBMP()
	{
		return $this->CenaBMP;
	}
	function getKolicina()
	{
		return $this->Kolicina;
	}


	// set metode
	function setProizvodID($val)
	{
		$this->ProizvodID= $val;
	}
	function setVelicinaID($val)
	{
		$this->VelicinaID = $val;
	}
	function setSifra($val)
	{
		$this->Sifra = $val;
	}
	function setCenaA($val)
	{
		$this->CenaA = $val;
	}
	function setCenaB($val)
	{
		$this->CenaB = $val;
	}
	function setCenaAMP($val)
	{
		$this->CenaAMP = $val;
	}
	function setCenaBMP($val)
	{
		$this->CenaBMP = $val;
	}
	function setKolicina($val)
	{
		$this->Kolicina = $val;
	}


	function getLinkID()
	{
		return 'proizvodid='.$this->ProizvodID;
	}

}
?>
