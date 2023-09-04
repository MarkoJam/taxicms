<?

class SlideShow extends OpstiDomenskiObjekat 
{
	 public $SlideShowID;
	 public $ShowName;
	 public $Slide;
	 
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->SlideShowID = -1;
		$this->ShowName = "";
		$this->Slide = array();
		$this->TableName = "slideshow";
		
		// deo koji u zavisnosti od jezika dodaje postfikse na ime tabele
		// potrebno je dodati samo ako zelim da plugin bude vezan za razlicite jezike
		
		$lh = new LanguageHelper();
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function vratiImenaAtributa() {return "`slideshowid`,`showname`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->ShowName);}
	function postaviVrednostiAtributa(){ return "`showname` = ".$this->quote_smart($this->ShowName);}
	function nazivVezeKaRoditelju(){ return "slideshow";}
	function vratiUslovZaNadjiSlog(){ return "slideshowid=".$this->quote_smart($this->SlideShowID);}
	function vratiUslovZaSortiranje(){ return "slideshowid";}
	function vratiUslovZaNadjiSlogF(){ return "slideshowid=".$this->quote_smart($this->SlideShowID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->SlideShowID = $id;}
	function napuni($result_row){
		$this->SlideShowID = $result_row->slideshowid;
		$this->ShowName = $result_row->showname;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$slidecateg = $this->ObjectFactory->createObject("SlideShow",-1);
				$slidecateg->SlideShowID = $result_row->slideshowid;
				$slidecateg->ShowName = $result_row->showname;
				array_push($al, $slidecateg);
			}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "slide":
				if(count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$slide = $this->ObjectFactory->createObject("Slide",-1);
					$slide->napuni($db_res);
					array_push($this->Slide,$slide);
				}
			break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("slideshowid" => $this->getSlideShowID()));
		$arr = array_merge($arr, array("showname" => $this->getShowName()));
		return $arr;
	}
	
	function getSlideShowID()
	{
		return $this->SlideShowID;
	}
	function getShowName()
	{
		return $this->LanguageHelper->Transliterate($this->ShowName);
	}
	function getSlide()
	{
		return $this->Slide;
	}
	function setSlideShowID($var)
	{
		$this->SlideShowID = $var;
	}
	function setShowName($var)
	{
		$this->ShowName=$var;
	}
	function setSlide($var)
	{
		$this->Slide = $var;
	}
	
	function vratiIDKategorijeZaPlugin(){
		
		return $this->SlideShowID;
	}
		
	function vratiNazivKategorijeZaPlugin(){
		return $this->ShowName;
	}
	
	function postaviIDKategorijeZaPlugin($id){
		$this->SlideShowID = $id;
	}
	}
	
	
class Slide extends OpstiDomenskiObjekat 
{
	public $SlideID;
	public $SlideTitle;	
	public $SlideName;
	public $SlideUrl;
	public $BackImage;
	public $Image;
	public $Description;
	public $ImgOrder;
	public $SfStatus;

	
		 
	public $SlideShow;
		 
	//Bussiness PHP Object constructor
    function __construct()
    {
    	parent::__construct();
    	
		$this->SlideID = -1;
		$this->SlideTitle = "Slide title";		
		$this->SlideName = "Slide name";
		$this->SlideUrl = "";
		$this->BackImage = "";		
		$this->Image = "";
		$this->Description = "";
		$this->ImgOrder = 0;
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SlideShow = $this->ObjectFactory->createObject("SlideShow", -1);
		
		$this->TableName = "slide";
		$this->LanguageHelper->ChangeTableName($this->TableName);	
	}
	
	function Slide_POST(&$post)
	{
		$this->SlideShow = $this->ObjectFactory->createObject("SlideShow", -1);
		
		$this->SlideID= isset($post["slideid"]) ? $post["slideid"] : $this->SlideID;
		$this->SlideTitle= isset($post["slidetitle"]) ? $post["slidetitle"] : $this->SlideTitle;
		$this->SlideName= isset($post["slidename"]) ? $post["slidename"] : $this->SlideName;
		$this->SlideUrl= isset($post["slideurl"]) ? $post["slideurl"] : $this->SlideUrl;
		$this->BackImage= isset($post["backimage"]) ? $post["backimage"] : $this->BackImage;		
		$this->Image= isset($post["image"]) ? $post["image"] : $this->Image;
		$this->Description= isset($post["description"]) ? $post["description"] : $this->Description;
		$this->ImgOrder= isset($post["imgorder"]) ? $post["imgorder"] : $this->ImgOrder;
		$this->SfStatus->setStatusID(isset($post["statusid"])? $post["statusid"] : $this->SfStatus->getStatusID());

		$this->SlideShow->SlideShowID = isset($post["slideshowid"]) ? $post["slideshowid"] : $this->SlideShow->SlideShowID;
		
	}
	function vratiImenaAtributa() {return "`slideid`, `slidetitle`,`slidename`,`slideurl`,`back_image`,`image`,`description`,`img_order`, `status_id`,`slideshowid`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "
	'',
	".$this->quote_smart($this->SlideTitle).",
	".$this->quote_smart($this->SlideName).",	
	".$this->quote_smart($this->SlideUrl).",
	".$this->quote_smart($this->BackImage).",	
	".$this->quote_smart($this->Image).",	
	".$this->quote_smart($this->Description).",
	".$this->quote_smart($this->ImgOrder).",
	".$this->quote_smart($this->SfStatus->getStatusID()).",
	".$this->quote_smart($this->SlideShow->SlideShowID);}
	function postaviVrednostiAtributa(){ return "
	`slidetitle` = ".$this->quote_smart($this->SlideTitle).",	
	`slidename` = ".$this->quote_smart($this->SlideName).",
	`slideurl` = ".$this->quote_smart($this->SlideUrl).",
	`back_image` = ".$this->quote_smart($this->BackImage).",		
	`image` = ".$this->quote_smart($this->Image).",
	`description` = ".$this->quote_smart($this->Description).",
	`img_order` = ".$this->quote_smart($this->ImgOrder).",
	`status_id` =".$this->quote_smart($this->SfStatus->getStatusID()).",
	`slideshowid` = ".$this->quote_smart($this->SlideShow->SlideShowID);}
	function nazivVezeKaRoditelju(){ return "slide";}
	function vratiUslovZaNadjiSlog(){ return "slideid=".$this->quote_smart($this->SlideID);}
	function vratiUslovZaSortiranje(){ return "img_order";}
	function vratiUslovZaNadjiSlogF(){ return "slideid=".$this->quote_smart($this->SlideID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->SlideID = $this->quote_smart($id);}
	function napuni($result_row){
		$this->SlideID = $result_row->slideid;
		$this->SlideTitle = $result_row->slidetitle;
		$this->SlideName = $result_row->slidename;		
		$this->SlideUrl = $result_row->slideurl;
		$this->BackImage = $result_row->back_image;
		$this->Image = $result_row->image;		
		$this->Description = $result_row->description;
		$this->ImgOrder = $result_row->img_order;
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->SlideShow->SlideShowID = $result_row->slideshowid;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$rssf = $this->ObjectFactory->createObject("Slide",-1);
				$rssf->SlideID = $result_row->slideid;
				$rssf->SlideTitle = $result_row->slidetitle;				
				$rssf->SlideName = $result_row->slidename;
				$rssf->SlideUrl = $result_row->slideurl;
				$rssf->BackImage = $result_row->back_image;				
				$rssf->Image = $result_row->image;
				$rssf->Description = $result_row->description;
				$rssf->ImgOrder = $result_row->img_order;
				$rssf->SfStatus->setStatusID($result_row->status_id);
				$rssf->SlideShow->SlideShowID = $result_row->slideshowid;
				array_push($al, $rssf);
			}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "slideshow":
				$this->SlideShow->napuni($result_set); 
			break;
			case "sfstatus":
			if (count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
			break;
			default: break;
		}
	} 
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("slideid" => $this->getSlideID()));
			$arr = array_merge($arr, array("slidetitle" => $this->getSlideTitle()));
			$arr = array_merge($arr, array("slidename" => $this->getSlideName()));			
			$arr = array_merge($arr, array("slideurl" => $this->getSlideUrl()));
			$arr = array_merge($arr, array("backimage" => $this->getBackImage()));			
			$arr = array_merge($arr, array("image" => $this->getImage()));
			$arr = array_merge($arr, array("description" => $this->getDescription()));
			$arr = array_merge($arr, array("imgorder" => $this->getImgOrder()));
			$arr = array_merge($arr, array("statusid" => $this->getStatusID()));
			$arr = array_merge($arr, array("slideshowid" => $this->getSlideShow()));
		return $arr;
	}
	
	// get metode ispravi ako ima nesto!!!
	function getSlideID()
	{
		return $this->SlideID;
	}
	function getSlideTitle()
	{
		return $this->LanguageHelper->Transliterate($this->SlideTitle);
	}
	function getSlideName()
	{
		return $this->LanguageHelper->Transliterate($this->SlideName);
	}	
	function getSlideUrl()
	{
		return $this->SlideUrl;
	}
	function getBackImage()
	{
		return $this->BackImage;
	}	
	function getImage()
	{
		return $this->Image;
	}	
	function getDescription()
	{
		return $this->Description;
	}	
	function getImgOrder()
	{
		return $this->ImgOrder;
	}	
	function getSfStatus()
	{
		return $this->SfStatus;
	}
	function getStatusID()
	{
		return $this->SfStatus->StatusID;
	}
	function getSlideShow()
	{
		return $this->SlideShow->SlideShowID;
	}
	// set metode ispravi ako ima nesto!!!
	function setSlideID($val)
	{
		$this->SlideID= $val;
	}
	function setSlideTitle($val)
	{
		$this->SlideTitle= $val;
	}
	function setSlideName($val)
	{
		$this->SlideName= $val;
	}
	function setSlideUrl($val)
	{
		$this->SlideUrl= $val;
	}
	function setBackImage($val)
	{
		$this->BackImage= $val;
	}	
	function setImage($val)
	{
		$this->Image= $val;
	}	
	function setDescription($val)
	{
		$this->Description= $val;
	}	
	function setImgOrder($val)
	{
		$this->ImgOrder= $val;
	}
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}
	function setSlideShow($val)
	{
		$this->SlideShow->SlideShowID = $val;
	}
	function getLinkID()
	{
		return 'slideid='.$this->SlideID;
	}
	
}

?>