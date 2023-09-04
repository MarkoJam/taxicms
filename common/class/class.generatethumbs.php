<?php

/*
 * Klasa za rad sa thumbnails slicicama
 * omogucava laku integraciju sa lightbox
 * sistemima javascript plugins
 */
class GenerateThumbs
{
	// property za cuvanje singlton instance
	private static $instance;

	/*
	 * Staticka metoda za vracanje instance
	 * na singleton objekat
	 */
	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			$object= __CLASS__;
			self::$instance=new $object;
		}

		return self::$instance;
	}

	/*
	 * funkcija uzima html kod i za dati kod trazi img
	 * tagove i to samo one koji imaju class='thumb'
	 */
	public function PrepareThumbs(& $param)
	{
		$pattern_img = '@(<img\s+)(.+?)(\s*/?>)@ise';
		$pattern_class = '@(class=(\'|\"))(.+?)(\'|\")@ise';

		$img_tags_orig = array();
		preg_match_all($pattern_img,$param,$img_tags_orig);
		$img_counter = 0;

		// prolazimo kroz sve izdvojene img tagove
		for($i = 0;$i< count($img_tags_orig[0]); $i++)
		{
			$img_class = array();
			preg_match($pattern_class,$img_tags_orig[0][$i],$img_class);

			if (isset($img_class[3]) && $img_class[3] == "thumb")
			{
				// ovde ide obrada potrebno je zameniti orginalni img tag sa
				// onim koji nam je potreban za prikaz thumbova
				$test = array();
				$pattern_sm = '@(src=)(\'|\")(.*?)(\'|\")@ise';
				preg_match($pattern_sm, $img_tags_orig[0][$i],$test);

				$alt = array();
				$pattern_alt = '@(alt=)(\'|\")(.*?)(\'|\")@ise';
				preg_match($pattern_alt, $img_tags_orig[0][$i], $alt);

				$align = array();
				$pattern_align = '@(align=)(\'|\")(.*?)(\'|\")@ise';
				preg_match($pattern_align, $img_tags_orig[0][$i],$align);

			//	print_r($test);

				$fname = $this->ExtractFileName($test[3]);
				$fpath = $this->ExtractFilePathName($test[3]);
				$this->Photo($this->ExtractFileName($test[3]),"thumb",$this->ExtractFilePathName($test[3]));

				$img_tag = '<img align="'.$align[3].'" style="" src="'.'/'.$fpath.'thumb_'.$fname.'" alt="'.$alt[3].'" border="0" />';
				$img_tag_new = '<a style="" id="thumb1" href="'.$test[3].'" class="highslide" onclick="return hs.expand(this, { captionId: \'caption-'.$img_counter.'\' } )">'.$img_tag.'</a>';
				$div_tag = "";
				if ($alt[3] != '')
				{
					$div_tag = "<div class='highslide-caption' id='caption-".$img_counter."'>".$alt[3]."</div>";
				}

				$param = str_replace($img_tags_orig[0][$i],$img_tag_new.$div_tag,$param);
			}
			$img_counter++;
		}
	}

	public function Photo($image,$addstring="",$fileroot_normal="")
	{
		if(!file_exists(ROOT_HOME.$fileroot_normal.$addstring."_".$image))
		{
			$filename = $fileroot_normal."/".$image;
			$fileout = ROOT_HOME . $fileroot_normal ."/". $addstring."_" . $image;
			$newxsize = 300; $newysize = 300; $maxsize = 0; $bgred = 255; $bggreen = 255; $bgblue = 255;
			$new = new Img2Thumb(ROOT_HOME.$filename,$newxsize,$newysize,$fileout,$maxsize,$bgred,$bggreen,$bgblue);
		}
		return $image;
	}

	private function ExtractFileName($filepath)
	{
		$elements = array();
		$elements = explode("/",$filepath);
		return str_replace("/","",$elements[count($elements)-1]);
	}

	private function ExtractFilePathName($filepath)
	{
		$elements = array();
		$elements = explode("/",$filepath);
		$path = "";
		for($i=0;$i<count($elements)-1;$i++)
		{
			$path .= $elements[$i]."/";
		}

		return substr($path,1);
	}}
?>
