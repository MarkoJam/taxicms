<?
	include_once(ROOT_HOME."config.php");

	//deo koji registruje promenljive za news plugin na razlicitim jezicima
	$config = new XMLConfig;
	$lh = new LanguageHelper();
	//$of = new loginFactory($DBBR);
	$config->Parse(ROOT_HOME."config/languages/lang_".$lh->GetFileDesc().".xml");
	$arr_lang = $config->get("/newsletter");
	$lh->RegisterPluginLanguageFile($arr_lang, $this);
	
	
?>