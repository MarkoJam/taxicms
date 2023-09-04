<?
include_once("class.img2thumb.inc");

class PhotoToThum 
{
	var $image;
	var $dir_normal;
	var $dir_small;
	//dodajem zbog pozicije fajlova
	var $add_path;
	
	function __construct($image,$dir_normal="images/",$dir_small="images_small/",$xsize,$ysize)
	{
		$this->image = $image;
		$this->dir_normal = $dir_normal;
		$this->dir_small = $dir_small;
		// u slucaju da ime slike sadrzi / parsiramo naziv slike i razbijamo string na img i dir...
		if(strpos($image,"/") != -1) $this->parseImgName();
		$this->X = $xsize;
		$this->Y = $ysize;
		$this->add_path = "../../..";
//		$this->CreateThumb();
	}
	
	function CreateThumb(){
		// provera da li postoji mala slika
		if(!file_exists($this->add_path.$this->dir_small.$this->image))
		{
			// ako ne postoji podesava se ulaz i izlaz sa funkciju img2thumb
			$filename = $this->add_path.$this->dir_normal.$this->image;
			$fileout = $this->add_path.$this->dir_small.$this->image;
			$newxsize = $this->X; $newysize = $this->Y; $maxsize = 0; $bgred = 255; $bggreen = 255; $bgblue = 255;
			$new = new Img2Thumb($filename,$newxsize,$newysize,$fileout,$maxsize,$bgred,$bggreen,$bgblue);
		}
		return $this->dir_small.$this->image;
	}
	
	// u slucaju da imam u nazivu slike citavu putanju...moramo da parsiramo string
	function parseImgName()
	{
		$pos = strrpos($this->image,"/");
		$imgstr = substr($this->image,$pos+1,strlen($this->image));
		$dirstr = substr($this->image,0,$pos+1);
		
		$this->image = $imgstr;
		$this->dir_normal = $dirstr;
	}
}

//$pt = new PhotoToThum("files/Image/megabloks/mb9806.jpg","","files/Image/portfolio_small/",100,100);

?>