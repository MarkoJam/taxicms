<?
	function thumb($source, $sizeP=100, $quality=80)
	{
		if(!file_exists($source)){
			header('Content-Type: image/jpeg');
			$im = imagecreatefromjpeg("../images/nofile.jpg");
			imagejpeg($im,'',$quality);
			imagedestroy($im);			
		}
		else 
		{
			$size = getimagesize($source);
			if ($size['mime'] == 'image/jpeg' || $size['mime'] == 'image/png' || $size['mime'] == 'image/gif'){
				$scale = 1; //ne radim resize po defaultu
				$old_w = $size[0];
				$old_h = $size[1];
				
				if ($old_h > $sizeP) 
				{
					$scale = $old_h / 100; //radim resize na visinu 100px
				}
				$width = $old_w / $scale;
				$height = $old_h / $scale;
				
				$resize = imagecreatetruecolor($width,$height);
			}			
			if($quality > 100) 
			{
				echo "greska: maksimalni kvalitet je 100";
			}
			else
			{
				if ($size['mime'] == 'image/jpeg' || $size['mime'] == 'image/png' || $size['mime'] == 'image/gif')
				{

					switch($size['mime'])
					{
						case 'image/jpeg':
							header('Content-Type: image/jpeg');
							$im = imagecreatefromjpeg($source);
							imagecopyresampled($resize,$im,0,0,0,0,$width,$height,$size[0],$size[1]);
							imagejpeg($resize,'',$quality);
							break;
						case 'image/png':
							header('Content-Type: image/png');
							$im = imagecreatefrompng($source);
							imagecopyresampled($resize,$im,0,0,0,0,$width,$height,$size[0],$size[1]);
							imagepng($resize,'',$quality);
							break;
						case 'image/gif':
							header('Content-Type: image/jpeg');						
							$im = imagecreatefromjpeg("../images/gifformat.jpg");
							imagejpeg($im,'',$quality);
							/*$im = imagecreatefromgif($source);
							imagecopyresampled($resize,$im,0,0,0,0,$width,$height,$size[0],$size[1]);
							imagegif($resize,'',$quality);*/
							break;	
					}
				}
				else {
					header('Content-Type: image/jpeg');						
					$im = imagecreatefromjpeg("../images/badformat.jpg");
					imagejpeg($im,'',$quality);
				}
				imagedestroy($im);
			}
		}		
	}
?>