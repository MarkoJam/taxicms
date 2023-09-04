<?
	/* CMS Studio 3.0 delete_tmpl_final.php */

	//bitno je da u bazi podataka template STANDARDNI bude sa sifrom 1
	$_ADMINPAGES = true;	
	include_once("../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_PLUGINDELETE"))
	{
		if(isset($_REQUEST['template_id']))
		{
			//potrebno je obrisati template zapis kao i sve veze koje su u relaciji sa ovim template-om
			
			$tmpl = $ObjectFactory->createObject("Template", -1 ,array("PluginTemplate"));
			$tmpl->TemplateID = $_REQUEST['template_id'];
			
			//proveriti sve stranice da li imaju vezu sa templateom koji se brise,a ako ta veza 
			//postoji treba setovati da stranica bude vezana sa standardni template!
			
			$pages_all = $ObjectFactory->createObjects("Page");
	
			//prolazimo kroz sve stranice, i sve koje imaju template veza i gledamo koje imaju isti templateid i njih brisemo
			foreach($pages_all as $p)
			{
				if($p->getTemplate()->getTemplateID() == $tmpl->TemplateID)
				{
					$p->getTemplate()->setTemplateID(1);
					$DBBR->promeniSlog($p);
				}
			}
			
			// na kraju brisemo i sam templejt 
			$DBBR->obrisiSlog($tmpl);
			
			//prolazimo kroz niz svih veza i gledamo koje imaju isti templateid i njih brisemo

			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("template_id=".$_REQUEST['template_id']);
			$plgtmp = $ObjectFactory->createObjects("PluginTemplate");
			$ObjectFactory->Reset();
			
			foreach($plgtmp as $pt)
			{
				$DBBR->obrisiSlog($pt);
			}			
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";	
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
		


?>