<?php

	/*
	 * helper function for generating thumbnail for a given image
	 */
	function Photo($image,$addstring="",$fileroot_normal="",$fileroot_small="")
	{
		if(!file_exists(ROOT_HOME.$fileroot_normal.$addstring."_".$image))
		{
			$filename = $fileroot_normal."/".$image;
			$fileout = ROOT_HOME . $fileroot_normal. $addstring."_" . $image;
			$newxsize = 300; $newysize = 300; $maxsize = 0; $bgred = 255; $bggreen = 255; $bgblue = 255;
			$new = new Img2Thumb(ROOT_HOME.$filename,$newxsize,$newysize,$fileout,$maxsize,$bgred,$bggreen,$bgblue);
		}
		return $image;
	}

	function ExtractFileName($filepath)
	{
		$elements = array();
		$elements = explode("/",$filepath);
		return str_replace("/","",$elements[count($elements)-1]);
	}

	function ExtractFilePathName($filepath)
	{
		$elements = array();
		$elements = explode("/",$filepath);
		$path = "";
		for($i=0;$i<count($elements)-1;$i++)
		{
			$path .= $elements[$i]."/";
		}

		return substr($path,1);
	}

?>
