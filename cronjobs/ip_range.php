<?
	$_AJAXPAGES = true;
	include_once("../config.php");
	$LanguageHelper = LanguageHelper::getInstance();
	
	$countries=array("serbia","bosnia-and-herzegovina","macedonia-the-former-yugoslav-republic-of","montenegro","croatia","albania");
	foreach ($countries as $country)
	{
		$c = curl_init("https://lite.ip2location.com/".$country."-ip-address-ranges");
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$x1 = curl_exec($c);		
		if (curl_error($c))
			die(curl_error($c));		
		echo $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

		curl_close($c);
		
		//$x1=file_get_contents("https://lite.ip2location.com/".$country."-ip-address-ranges");
		if ($x1)
		{	
			$x2=get_string_between($x1, '<tbody>', '</tbody>');
			$x2=str_replace('</tr>',"<br>",$x2);
			$x2=str_replace('<tr>',"",$x2);
			$x3=explode('<br>',$x2);
			$sql1="DELETE FROM `ip_range` WHERE `country`='".$country."'";
			$DBBR->con->query($sql1);
			foreach ($x3 as $row)
			{
				$x4=str_replace('<td>',"",$row);
				$x5=explode('</td>',$x4);
				$sql2="INSERT INTO `ip_range`(`ip_start`, `ip_end`, `country`) VALUES ('".$x5[0]."','".$x5[1]."','".$country."')";
				$DBBR->con->query($sql2);
			}	
		}
		else
		{
			// kreiranje objekta za slanje maila
			$phpmail = new PHPMailer();	
			$phpmail->IsMail();

			$phpmail->From = $CMSSetting->getSettingByID(ORDER_MAIL_EMAIL);
			$phpmail->FromName = $CMSSetting->getSettingByID(ORDER_MAIL_NAME);
			$phpmail->IsHTML(true);
		
			$phpmail->AddAddress("office@sdstudio.rs");

			$phpmail->Subject = "ALARM ip range update";
			$phpmail->Body = "Ažuriranje opsega IP adresa za ".$country." nije izvršeno!";
			$phpmail->Send();
		
			// unisti objekat $phpmail
			unset($phpmail);
			//echo "slanje mail-a da nije azurirano";
		}	
	}
	
	function get_string_between($string, $start, $end){
				$string = ' ' . $string;
				$ini = strpos($string, $start);
				if ($ini == 0) return '';
				$ini += strlen($start);
				$len = strpos($string, $end, $ini) - $ini;
				return substr($string, $ini, $len);
	}
?>

