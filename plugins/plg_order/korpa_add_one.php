<?
	/* CMS Studio 2.0 korpa_add_one.php */

	include_once("../../config.php");

	$LanguageHelper = LanguageHelper::getInstance();
	
	$lang = $LanguageHelper->GetLinkPluginType("language");

	$postoji = false;
	if (isset($_REQUEST["proizvodid"]))
	{
		$flg_postoji = false;

		// dodavanje velicine u sifru proizvoda ako velicina postoji
		if (isset($_POST["size"])) $pr = $_REQUEST["proizvodid"]."-".$_POST["size"];
		else $pr = $_REQUEST["proizvodid"];
		if (isset($_POST["kolicina"])) $kol=  $_POST["kolicina"];
		else $kol=1;
		
		if(isset($_SESSION[$lang]["korpa"]) && count($_SESSION[$lang]["korpa"])>0)
		{
			foreach($_SESSION[$lang]["korpa"] as $proiz => $kolicina)
			{
				if($proiz == $pr){
					$flg_postoji = true;
					break;
				}
			}
		}
		if($flg_postoji)$_SESSION[$lang]["korpa"][$pr] = $kolicina + $kol;
		else $_SESSION[$lang]["korpa"][$pr]= $kol;
	}
	
	$backUrl = $_SERVER[HTTP_REFERER]. "/";
	$backUrl = removeVars($backUrl,"basket_message").'basket_message=added';
	if ($_REQUEST["search_basket"]=="Yes") header('Location: ../../index.php?plugin=search&search=all&plugin_view=search_results&tid='.$_REQUEST['tid'].'&search_text='.$_SESSION["search_text"].'&basket_message=added');
	else header('Location: '. $backUrl);
	

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