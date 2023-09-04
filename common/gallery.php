<? 

/* CMS Studio 3.0 gallery.php secured */

	class GalleryCategory extends OpstiDomenskiObjekat 
	{
		 public $GalleryCategoryID;
		 public $Title;
		 public $MessageNum;
		 public $Status;
		 public $Gallery;
		
		//Bussiness PHP Object constructor	 
		function __construct()
		{
			parent::__construct();
			
			$this->GalleryCategoryID = -1;
			$this->Title = "";
			$this->MessageNum = 0;
			$this->Gallery = array();
			
			$this->TableName= "gallerycategory";
			$this->LanguageHelper->ChangeTableName($this->TableName);
		}
		
		// fill GalleryCategory from POST
		function GalleryCategory_POST($post)
		{
			$this->GalleryCategoryID = isset($post["gallerycategoryid"]) ? $post["gallerycategoryid"] : -1;
			$this->Title = isset($post["title"]) ? $post["title"] : -1;
			$this->MessageNum = isset($post["messagenum"]) ? $post["messagenum"] : -1;
			$this->Status = isset($post["status"]) ? $post["status"] : -1;
			$this->Gallery = array();
		}
		
		// DatabaseBroker functions
		function vratiImenaAtributa() {return "`gallerycategoryid`,`title`,`messagenum`,`status`";}
		function vratiImeKlase(){return $this->TableName;}
		function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->MessageNum).",".$this->quote_smart($this->Status);}
		function postaviVrednostiAtributa(){ return "`title` = ".$this->quote_smart($this->Title).",`messagenum` = ".$this->quote_smart($this->MessageNum).",`status` = ".$this->quote_smart($this->Status);}
		function nazivVezeKaRoditelju(){ return "gallerycategory";}
		function vratiUslovZaNadjiSlog(){ return "gallerycategoryid=".$this->quote_smart($this->GalleryCategoryID);}
		function vratiUslovZaSortiranje(){ return "gallerycategoryid";}
		function vratiUslovZaNadjiSlogF(){ return "gallery_category_id=".$this->quote_smart($this->GalleryCategoryID);}
		function vratiUslovZaNadjiSlogove(){ return "1=";}
		function postaviID($id){ $this->GalleryCategoryID = $id;}
		function napuni($result_row)
		{
			$this->GalleryCategoryID = $result_row->gallerycategoryid;
			$this->Title = $result_row->title;
			$this->MessageNum = $result_row->messagenum;
			$this->Status = $result_row->status;
		}
		function napuniNiz($result_set, &$al){
			if(count($result_set)>0)
				foreach($result_set as $result_row){
					$gallerycateg = $this->ObjectFactory->createObject("GalleryCategory",-1);
					$gallerycateg->GalleryCategoryID = $result_row->gallerycategoryid;
					$gallerycateg->Title = $result_row->title;
					$gallerycateg->MessageNum = $result_row->messagenum;
					$gallerycateg->Status = $result_row->status;
					array_push($al, $gallerycateg);
				}
		}
		
		function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
		{
			$gallery = $this->LanguageHelper->ChangeTableNameR("gallery");
			$galleryGalleryCategory = $this->LanguageHelper->ChangeTableNameR("gallerygallerycategory");
		
			switch ($relation_class_name)
			{
				case $gallery:
					$vezna_klasa = $galleryGalleryCategory;
					$uslov_join = "IJ1.gallery_id= IJ2.gallery_id";
					break;
				default: $vezna_klasa = "";
				break;
			}
		}
		
		function napuniVisePovezi($result_set, $relation_name)
		{
			switch ($relation_name)
			{
				case "gallery":
					if(count($result_set)>0)
					foreach($result_set as $db_res)
					{
						$agallery= $this->ObjectFactory->createObject("Gallery",-1);
						$agallery->napuni($db_res);
						array_push($this->Gallery,$agallery);
					}
				break;
				default: break;
			}
		}

		function toArray()
		{
			$arr = array();
				$arr = array_merge($arr, array("gallerycategoryid" => $this->getGalleryCategoryID()));
				$arr = array_merge($arr, array("title" => $this->getTitle()));
				$arr = array_merge($arr, array("messagenum" => $this->getMessageNum()));
				$arr = array_merge($arr, array("status" => $this->getStatus()));
			return $arr;
		}
		
		// getter and setter
		function getGalleryCategoryID()
		{
			return $this->GalleryCategoryID;
		}
		
		function getTitleUnchanged()
		{
			return $this->Title;
		}
		function getTitle()
		{
			return $this->LanguageHelper->Transliterate($this->Title);
		}
		function getMessageNum()
		{
			return $this->MessageNum;
		}
		function getStatus()
		{
			return $this->Status;
		}
		
		function setGalleryCategoryID($val)
		{
			$this->GalleryCategoryID = $val;
		}
		function setTitle($val)
		{
			$this->Title = $val;
		}
		function setMessageNum($val)
		{
			$this->MessageNum = $val;
		}
		function setStatus($val)
		{
			$this->Status = $val;
		}
		
		function getLinkID()
		{
			return 'gallerycategoryid='.$this->Gallerycategoryid;
		}
		
		// podesavanje za pluginove
		function vratiIDKategorijeZaPlugin(){
			
			return $this->GalleryCategoryID;
		}
			
		function vratiNazivKategorijeZaPlugin(){
			return $this->Title;
		}
		
		function postaviIDKategorijeZaPlugin($id){
			$this->GalleryCategoryID = $id;
		}
	}


class Gallery extends OpstiDomenskiObjekat
{
	public $GalleryID;
	public $Header;
	public $Html;
	public $Date;
	public $SfStatus;
	
	public $GalleryCategory; // array
	
	private $Slika;
	private $SlikaThumb;
	
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->GalleryID = -1;
		$this->Header = "";
		$this->Html = "";
		$this->Date = time();
		
		$this->Slika = "";
		$this->SlikaThumb = "";
		
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->GalleryCategory = array();
		
		$this->TableName= "gallery";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill Gallery from POST
	function Gallery_POST($post)
	{
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		
		$this->GalleryID = isset($post["gallery_id"]) ? $post["gallery_id"] : -1;
		$this->Header = isset($post["header"]) ? $post["header"] : "";
		$this->Html = isset($post["html"]) ? $post["html"] : "";
		$this->Date = isset($post["date"]) ? $post["date"] :time();
		$this->Slika = isset($post["slika"]) ? $post["slika"] : "";
		$this->SlikaThumb = isset($post["slikathumb"]) ? $post["slikathumb"] : "";
		
		$this->SfStatus->setStatusID(isset($post["statusid"])? $post["statusid"] : $this->SfStatus->getStatusID());
		
		$this->GalleryCategory = array();
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`gallery_id` , `header` , `html` ,`date`,`slika`,`slika_thumb`, `status_id`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',". $this->quote_smart($this->Header) . ",". $this->quote_smart($this->Html) . ",".$this->quote_smart($this->Date). ", ".$this->quote_smart($this->Slika) . " , ".$this->quote_smart($this->SlikaThumb) . " ,  ". $this->quote_smart($this->SfStatus->getStatusID());} 
	
	function postaviVrednostiAtributa(){ 
		return "`header` = ".$this->quote_smart($this->Header). " , `html` = ".$this->quote_smart($this->Html).",`date` =". $this->quote_smart($this->Date).",`slika` =". $this->quote_smart($this->Slika).",`slika_thumb` =". $this->quote_smart($this->SlikaThumb).",
	`status_id` =".$this->quote_smart($this->SfStatus->getStatusID());
	}
	function nazivVezeKaRoditelju(){ return "gallery";}
	function vratiAtributPretrazivanja(){ return "gallery_id"; }
	function vratiUslovZaNadjiSlog(){ return "gallery_id=" . $this->quote_smart($this->GalleryID);}
	function vratiFulltextIndekse(){ return  "header, html, shorthtml";} //definisemo polja nad kojima je postavljem fulltext index
	function vratiUslovZaSortiranje(){ return "date DESC";} //??
	function vratiUslovZaNadjiSlogF(){ return "gallery_id=" . $this->quote_smart($this->GalleryID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function postaviID($id){ $this->GalleryID = $id;}
	function toString() {}
	
	function napuni($result_row)
	{
		$this->GalleryID = $result_row->gallery_id;
		$this->Header = $result_row->header;
		$this->Html = $result_row->html;
		$this->Date = $result_row->date;
		$this->Slika = $result_row->slika;
		$this->SlikaThumb = $result_row->slika_thumb;
		$this->SfStatus->setStatusID($result_row->status_id);
	}

	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$nw = $this->ObjectFactory->createObject("Gallery",-1);
				$nw->GalleryID = $result_row->gallery_id;
				$nw->Header = $result_row->header;
				$nw->Html = $result_row->html;
				$nw->Date = $result_row->date;
				$nw->Slika = $result_row->slika;
				$nw->SlikaThumb = $result_row->slika_thumb;
				$nw->SfStatus->setStatusID($result_row->status_id);
				array_push($al, $nw);
			}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$galleryCategory = $this->LanguageHelper->ChangeTableNameR("gallerycategory");
		$galleryGalleryCategory = $this->LanguageHelper->ChangeTableNameR("gallerygallerycategory");
	
		switch ($relation_class_name)
		{
			case $galleryCategory:
				$vezna_klasa = $galleryGalleryCategory;
				$uslov_join = "IJ1.gallery_category_id= IJ2.gallerycategoryid";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "sfstatus":
				if (count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
				break;
			case "gallerycategory":
				if(count($result_set)>0)
					foreach($result_set as $db_res){
					$galleryCategory = $this->ObjectFactory->createObject("GalleryCategory",-1);
					$galleryCategory->napuni($db_res);
					array_push($this->GalleryCategory, $galleryCategory);
				}
				break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("galleryid" => $this->getGalleryID()));
			$arr = array_merge($arr, array("header" => $this->getHeader()));
			$arr = array_merge($arr, array("html" => $this->getHtml()));
			$arr = array_merge($arr, array("dateorig" => $this->getDate()));
			$arr = array_merge($arr, array("date" => $this->getDateFormated()));
			$arr = array_merge($arr, array("datehronology" => $this->getDateFormatedHronology()));
			$arr = array_merge($arr, array("slika" => $this->getSlika()));
			$arr = array_merge($arr, array("slikathumb" => $this->getSlikaThumb()));
			$arr = array_merge($arr, array("statusid" => $this->getStatusID()));
			$arr = array_merge($arr, array("gallerycategoryprint" => $this->getGalleryCategoryPrint()));
		return $arr;
	}
	
	// getter and setter
	function getGalleryID()
	{
		return $this->GalleryID;
	}
	function getHeader()
	{
		return $this->LanguageHelper->Transliterate($this->Header);
	}
	function getHeaderUnchanged()
	{
		return $this->Header;
	}
	function getHtmlUnchanged()
	{
		return $this->Html;
	}
	function getHtml()
	{
		return $this->LanguageHelper->Transliterate($this->Html);
	}
	function getDate()
	{
		return $this->Date;
	}
	function getDateFormated()
	{
		return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),"d. F Y."));
	}
	function getDateFormatedDuration()
	{
		if($this->getDuration() > 1)
		{
			return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),"d. F - ")) . $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate() + 24*60*60*($this->Duration-1) ,"d. F Y."));
		}
		
		return $this->getDateFormated();
	}
	
	function getDateFormatedHronology()
	{		
		return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),"d. F Y."));
	}
	
	function getSlika()
	{
		return $this->Slika;
	}
	function getSlikaThumb()
	{
		return $this->SlikaThumb;
	}
	function getSfStatus()
	{
		return $this->SfStatus;
	}
	function getStatusID()
	{
		return $this->SfStatus->StatusID;
	}
	function getGalleryCategoryPrint()
	{
		$output = "";
		if($this->GalleryCategory != null)
		{
			foreach($this->GalleryCategory as $nwc)
			{
				$output .= $nwc->getTitle() . ", ";
			}
		}
		
		return substr($output, 0, strlen($output)-2);
	}
	
	function getGalleryCategory()
	{
		return $this->GalleryCategory;		
	}
	
	/*--- setter ---*/
	function setGalleryID($val)
	{
		$this->GalleryID = $val;
	}
	function setHeader($val)
	{
		$this->Header = $val;
	}
	function setHtml($val)
	{
		$this->Html = $val;
	}
	function setDate($val)
	{
		$this->Date = $val;
	}
	function setSlika($val)
	{
		$this->Slika = $val;
	}
	function setSlikaThumb($val)
	{
		$this->SlikaThumb = $val;
	}
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}
	
	function setGalleryCategory($val)
	{
		$this->GalleryCategory = $val;
	}
	
	function getLinkID()
	{
		return 'galleryid='.$this->GalleryID;
	}
}
		
// klasa PrGalleryGrupaProiz cuva veze izmedju gallerya i grupe gallerya
class GalleryGalleryCategory extends OpstiDomenskiObjekat
{
	private $GalleryID;
	private $GalleryCategoryID;
	private $GalleryGalleryCategoryOrder;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->GalleryID = -1;
		$this->GalleryCategoryID = -1;
		$this->GalleryGalleryCategoryOrder = 0;
		$this->TableName = "gallerygallerycategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill GalleryGalleryCategory from POST
	function GalleryGalleryCategory_POST($post)
	{
		$this->GalleryID = isset($post["galleryid"]) ? $post["galleryid"] : $this->GalleryID;
		$this->GalleryCategoryID = isset($post["gallerycategoryid"]) ? $post["gallerycategoryid"] : $this->GalleryCategoryID;
		$this->GalleryGalleryCategoryOrder = isset($post["gallerygallerycategoryorder"]) ? $post["gallerygallerycategoryorder"] : $this->GalleryGalleryCategoryOrder;
	}

	function vratiImenaAtributa() {
		return "`gallery_id`,`gallery_category_id`,`gallery_gallerycategory_order`";
	}
	function vratiImeKlase(){
		return $this->TableName;
	}
	function vratiVrednostiAtributa(){
		return $this->quote_smart($this->GalleryID).",".$this->quote_smart($this->GalleryCategoryID).",".$this->quote_smart($this->GalleryGalleryCategoryOrder);
	}
	function postaviVrednostiAtributa(){
		return "`gallery_category_id` = ".$this->quote_smart($this->GalleryCategoryID).",`gallery_gallerycategory_order` = ".$this->quote_smart($this->GalleryGalleryCategoryOrder);
	}
	function nazivVezeKaRoditelju(){
		return "gallery";
	}
	function vratiUslovZaNadjiSlog(){
		return "gallery_id=".$this->quote_smart($this->GalleryID)." AND gallery_category_id=".$this->quote_smart($this->GalleryCategoryID);
	}
	function vratiUslovZaSortiranje(){
		return "gallery_gallerycategory_order desc";
	}
	function vratiUslovZaNadjiSlogF(){
		return "gallery_id=".$this->quote_smart($this->GalleryID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "gallery_id=".$this->quote_smart($this->GalleryID);
	}
	function postaviID($id){
		$this->GalleryID = $id;
	}
	function vratiAtributZaMax(){
		return "`gallery_gallerycategory_order`";
	}
	function napuni($result_row){
		$this->GalleryID = $result_row->gallery_id;
		$this->GalleryCategoryID = $result_row->gallery_category_id;
		$this->GalleryGalleryCategoryOrder = $result_row->gallery_gallerycategory_order;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
			$galleryCateg= $this->ObjectFactory->createObject("GalleryGalleryCategory",-1);
			$galleryCateg->GalleryID = $result_row->gallery_id;
			$galleryCateg->GalleryCategoryID = $result_row->gallery_category_id;
			$galleryCateg->GalleryGalleryCategoryOrder = $result_row->gallery_gallerycategory_order;
			array_push($al, $galleryCateg);
		}
	}
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("galleryid" => $this->getGalleryID()));
		$arr = array_merge($arr, array("gallerycategoryid" => $this->getGalleryCategoryID()));
		$arr = array_merge($arr, array("gallerygallerycategoryorder" => $this->getGalleryGalleryCategoryOrder()));
		return $arr;
	}

	// get metode
	function getGalleryID()
	{
		return $this->GalleryID;
	}
	function getGalleryCategoryID()
	{
		return $this->GalleryCategoryID;
	}
	function getGalleryGalleryCategoryOrder()
	{
		return $this->GalleryGalleryCategoryOrder;
	}
	// set metode
	function setGalleryID($val)
	{
		$this->GalleryID= $val;
	}
	function setGalleryCategoryID($val)
	{
		$this->GalleryCategoryID = $val;
	}
	function setGalleryGalleryCategoryOrder($val)
	{
		$this->GalleryGalleryCategoryOrder = $val;
	}
	function getLinkID()
	{
		return 'galleryid='.$this->GalleryID;
	}

}


?>