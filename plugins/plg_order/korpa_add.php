<?
	/* CMS Studio 2.0 korpa_add.php */

	include_once("../../config.php");
	
	$LanguageHelper = LanguageHelper::getInstance();
	
	$lang = $LanguageHelper->GetLinkPluginType("language");
	
	if (isset($_REQUEST["seladd"]) && (!isset($_REQUEST["delete"])) &&(!isset($_REQUEST["update"])) && (!isset($_REQUEST["empty"])))
	{
		$flg_postoji = false;
		
		foreach($_REQUEST["seladd"] as $key => $value)
		{
			$kolicina_tmp = 0;
			if(isset($_SESSION[$lang]["korpa"]) && count($_SESSION[$lang]["korpa"])>0)
			{
				foreach($_SESSION[$lang]["korpa"] as $proiz => $kolicina)
				{
					if($proiz == $value)
					{
						$flg_postoji = true;
						$kolicina_tmp = $kolicina;
						break;
					}
				}
			}
			
			if($flg_postoji)
			{
				$_SESSION[$lang]["korpa"][$proiz] = $kolicina_tmp + 1;
			}
			else
			{
				$_SESSION[$lang]["korpa"]["$value"]= 1;
			}
		}
	}
	

	$backUrl = $_SERVER[HTTP_REFERER]. "/a=1";
	$backUrl = removeVars($backUrl,"basket_message").'basket_message=added';
	
	header('Location: '. $backUrl);
	
	function removeVars($qs,$varname)
	{
		$qs_new = "";
		$qs_array = array();
		$qs_array = explode("&",$qs);
		foreach ($qs_array as $qsa) {
			if(strpos($qsa,$varname."=") === false)
			{
				$qs_new .= $qsa.'&';
			}

		}
		return $qs_new; 
	}
?>