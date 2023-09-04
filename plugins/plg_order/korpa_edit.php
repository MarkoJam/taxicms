<?
	/* CMS Studio 2.0 korpa_edit.php */

	include_once("../../config.php");

	$LanguageHelper = LanguageHelper::getInstance();
	
	$lang = $LanguageHelper->GetLinkPluginType("language");
	if (isset($_REQUEST["delete"]))
	{
		if(isset($_REQUEST["selbox"]))
		{
			if(count($_REQUEST["selbox"]) == 0)
			{
				$message = "Niste nista selektovali za brisanje";
			}
			else
			{
				foreach($_REQUEST["selbox"] as $pr)
				{
					unset($_SESSION[$lang]["korpa"]["$pr"]);
					$message = "Selektovani proizvodi su uspesno obrisani";
				}
			}
		}
		else 
		{
			$message="Niste selektovali proizvod za promenu!";
		}
	}

	if(isset($_REQUEST["empty"]))
	{
		unset($_SESSION[$lang]["korpa"]);
		unset($_SESSION["kol"]);
		$_SESSION[$lang]["korpa"] = array();
		$message = "Korpa je prazna";
	}
	
	if(isset($_REQUEST["update"]))
	{
		if(count($_SESSION[$lang]["korpa"]) == 0)
		{
			$message = "Zao nam je nema proizvoda kojima mozete promeniti kolicinu";
		}
		else
		{
			$i = 0;
			foreach($_SESSION[$lang]["korpa"] as $kr => $proiz)
			{
				$proizvodid = $kr;
				$_SESSION[$lang]["korpa"]["$kr"] = $_REQUEST["kol"][$i]*1;
				$i++;
			}
			$message = "Kolicine proizvoda su uspesno promenjene";		
		}
	}
	
	$backUrl = $_SERVER[HTTP_REFERER]. "/a=1";
	$backUrl = removeVars($backUrl,"basket_message").'basket_message=' . $message;
	
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