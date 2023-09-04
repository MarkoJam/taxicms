<?
	/* CMS Studio 3.0 modify_tmpl.php */
	
	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smarty;
	global $auth;

	$plgPositions = LoadPositionsFromSmartyTemplate();
	
	if($auth->isActionAllowed("ACTION_TEMPLATE_MODIFY"))
	{
		if(($_REQUEST["mode"])=='insert') $_REQUEST["template_id"]=-1;
		if ($_REQUEST['mode']=='insert2') 
		{
			$obj = $ObjectFactory->createObject("Template",-1);
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST['template_id']))
		{
			//dohvatam sve potrebne informacije za trenutno izabrani template
			$tmpl = $ObjectFactory->createObject("Template",$_REQUEST['template_id'],array("Plugin"));
			
			// deo za insertovanje novog sloga
			if(($_REQUEST["mode"])=='insert') $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			// prenosenje naslova i opisa u modify kod insertovanja		
			if (isset($_REQUEST['title']) && isset($_REQUEST['description'])) 
			{
				$tmpl->Title = $_REQUEST['title'];
				$tmpl->Description = $_REQUEST['description'];
			}
			else $DBBR->nadjiSlogVratiGa($tmpl);
			
			$ObjectFactory->ResetFilters();
			//dohvatam sve pluginove koji su trenutno instalirani na sistemu
			$ObjectFactory->AddFilter("active = 'true'");
			$plg_all = $ObjectFactory->createObjects("Plugin");
			$ObjectFactory->ResetFilters();
			
			$smarty->assign("TemplateID",$tmpl->TemplateID);
			$smarty->assign("Title",$tmpl->Title);
			$smarty->assign("Description",$tmpl->Description);
							
			$sel_output_plg = array();
			$sel_selected_plg = array();
			$sel_values_plg = array();
			
			$selekcijaID = array();
			$selekcijaTitle = array();
			$selekcijaPluginID = array();
						
			foreach ($plg_all as $p)
			{
				if($p->TemplateBase == "admin") continue;
				
				array_push($sel_output_plg, $p->Title);	
				array_push($sel_values_plg, $p->PluginID);

				//treba da popunim niz koji ce cuvati potrebne podkategorije...
				if($p->ClassName != 'null')
				{
					//pravim objekat tipa koji je vezan za plugin
					eval("\$obj = \$ObjectFactory->createObject(\"".$p->ClassName."\",-1);");
						
					//niz objekata koje sada filtriramo
					$objarray = array();
					$DBBR->vratiSveSlogove($obj,$objarray);
					foreach($objarray as $o)
					{
						if($o->vratiIDKategorijeZaPlugin() != "")
						{
							array_push($selekcijaID,$o->vratiIDKategorijeZaPlugin());
							array_push($selekcijaTitle,$o->vratiNazivKategorijeZaPlugin());
							array_push($selekcijaPluginID,$p->PluginID);
						}
						
					}
				}
			}

			//kreiranje javascript funkcije za vezu izmedju dva selection box-a
			$javafunction = "";

			$javafunction .= "var selekcija_id = new Array(".count($selekcijaID).");\n";
			$javafunction .= "var selekcija_title = new Array(".count($selekcijaTitle).");\n";
			$javafunction .= "var selekcija_plugin = new Array(".count($selekcijaPluginID).");\n";
			

			for($i=0; $i< count($selekcijaTitle);$i++)
			{
				$javafunction .= "selekcija_id[".$i."]=".$selekcijaID[$i].";\n";
				$javafunction .= "selekcija_title[".$i."]='".$selekcijaTitle[$i]."';\n";
				$javafunction .= "selekcija_plugin[".$i."]=".$selekcijaPluginID[$i].";\n";
			}
			
			//brisemo sve unose iz selection box-a
			$javafunction .= "document.tmplForm.selectionid.length = 0;\n";
			
			$javafunction .= "switch (pluginid) { \n";
			
			foreach ($plg_all as $p)
			{
			$javafunction .= "case \"".$p->PluginID."\":\n";
			$javafunction .= "	   for(j=0;j<".count($selekcijaID).";j++){if (pluginid == selekcija_plugin[j]){\n";
			$javafunction .= "         document.tmplForm.selectionid[document.tmplForm.selectionid.length] = new Option( selekcija_title[j] , selekcija_id[j]);\n";
			$javafunction .= "}} break; \n";
			}
			$javafunction .= "}";
			
			$smarty->assign("javafunction",$javafunction);
			
			$smarty->assign("sel_output_plg",$sel_output_plg);
			$smarty->assign("sel_selected_plg",$sel_selected_plg);
			$smarty->assign("sel_values_plg",$sel_values_plg);
			
			$ap = new AdminTable();
			$ap->SetHeader(
						array(
							getTranslation("PLG_NAME"),
							getTranslation("PLG_SELECTION"),
							getTranslation("PLG_POSITION"),
							getTranslation("PLG_DELETE")
				)
			);			
			
			$ap->SetOffsetName("offset_templtplgid");
			$ap->SetCountAllRows(count($tmpl->Plugin));	
			$ap->SetRowCount(count($tmpl->Plugin));

			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
			
			foreach($tmpl->Plugin as $plgt)
			{
				if(!isset($_REQUEST["tmplplgid"]) || $_REQUEST["tmplplgid"] != $plgt->PlgtemID)
				{
					if($auth->isActionAllowed("ACTION_PLUGINMODIFY"))
					{
						$modify_plugin = "<a class='naziv' data-param='modifyplugin=1&template_id=".$tmpl->TemplateID."&tmplplgid=".$plgt->PlgtemID."'>".$plgt->Title."</a>";						
						$filter_plugin = vratiNazivZaFilter($plgt);
						$position_plugin = $plgt->Position;
					}
					else
					{
						$modify_plugin = $plgt->Title;
						$filter_plugin = vratiNazivZaFilter($plgt);
						$position_plugin = $plgt->Position;
					}
					
					if($auth->isActionAllowed("ACTION_PLUGINDELETE"))
					{
						$delete_plugin = "<a id='delete_plugin' data-param='deleteplugin=1&template_id=".$tmpl->TemplateID."&tmplplgid=".$plgt->PlgtemID."'>".$html_img_delete."</a>";
					}
					else 
					{
						$delete_plugin = $html_img_delete;
					}

					$ap->AddTableRow(
										array(	$modify_plugin , 
												$filter_plugin ,
												$position_plugin,
												$delete_plugin));
				}
				else 
				{
					$pozicije_arr = VratiPozicijeZaPlugin($plgPositions, "plg_".$plgt->FileName);

					$position_selection = "";
					for ($i=0;$i<count($pozicije_arr);$i++)
					{
						$s = "";
						if ($pozicije_arr[$i] == $plgt->Position) $s = "selected";
						
						$position_selection .= "<option ".$s." value='".$pozicije_arr[$i]."'>".$pozicije_arr[$i]."</option>";
					}
					$position_selection = "<select class='form-control' id='position' name='position'>" . $position_selection . "</select>";
					
					$plugin_selection = "";
					for ($i=0;$i<count($sel_output_plg);$i++)
					{
						$s = "";
						if ($sel_values_plg[$i] == $plgt->PluginID) $s = "selected";
						
						$plugin_selection .= "<option ".$s." value='".$sel_values_plg[$i]."'>".$sel_output_plg[$i]."</option>";
					}
					$plugin_selection = "<select class='form-control' id='pluginid' name='pluginid' onchange='FilterSelection(this.options[this.selectedIndex].value)'>" . $plugin_selection . "</select>";
					
					$selection_selection = "";
					$selexist = false;
					
					for ($i=0;$i<count($selekcijaID);$i++)
					{
						if($selekcijaPluginID[$i] == $plgt->PluginID)
						{
							$s = "";
							if ($selekcijaID[$i] == $plgt->FilterID)
							{ 
									$s = "selected";
									$selexist = true;
							}
						
							$selection_selection  .= "<option ".$s." value='".$selekcijaID[$i]."'>".$selekcijaTitle[$i]."</option>";
						}
					}
					
					if($selexist) 
					{
						$s = "";
					}
					else
					{
						$s = "selected"; 
					}
					
					$selection_selection = "<option ".$s." value='-1'>Nema podešavanja</option>" . $selection_selection;
					$selection_selection  = "<select class='form-control' id='selectionid' name='selectionid'>" . $selection_selection  . "</select>";
					
					$ap->AddTableRow(array (
												$plugin_selection,
												$selection_selection,
												$position_selection,
												"<div name='modifybutt' data-param='".$plgt->PlgtemID."' id='modifybutt' class='btn btn-primary'><i class='fa fa-check'></i>&nbsp;".getTranslation("PLG_SAVE")."</div>"
												));
				}
			}
		
			if(count($tmpl->Plugin) != 0)
			{
				$ap->RegisterAdminPage($smarty);
			}
			else 
			{
				$smarty->assign("tbl_content", array(getTranslation("PLG_NONE")));
			}
			//poziv Smarty objektu da generise prikaz
			$smarty->display("modify.tpl");
		}
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}

// ucitavamo index.tpl kako bi izvukli pozicije za pluginove
function LoadPositionsFromSmartyTemplate()
{
	$path = ROOT_HOME . "templates".FILEPATH_SEPARATOR."index.tpl";
	$fh = fopen($path, 'r');
	$content = fread($fh, filesize($path));
	fclose($fh);
	
	$pattern_smarty_comment = '@({* <template:def\s+)(.+?)(\s*\>)@i';
	
	$smarty_comments = array();
	preg_match_all($pattern_smarty_comment,$content,$smarty_comments);
	
	$pluginPositions = array();
	foreach($smarty_comments[0] as $smarty_comment)
	{
		//echo $smarty_comment;
		$plugin = substr($smarty_comment, strpos($smarty_comment,"plugin=\"")+8, strlen($smarty_comment));
		$plugin = substr($plugin, 0, strpos($plugin, "\" position")-8);
		
		$position = substr($smarty_comment, strpos($smarty_comment,"position=\"")+10, strlen($smarty_comment));
		$position = substr($position, 0, strlen($position)-4);
		$pluginPosition[] = array( $plugin => $position);
	}
	
	return $pluginPosition;
}

// vraca sve pozicije na kojima se plugin moze naci
function VratiPozicijeZaPlugin($plgPositions, $plugin)
{
	$tmpArr = array();
	foreach($plgPositions as $plgPosition)
	{
		if( isset($plgPosition[$plugin]))
		{
			$tmpArr[] = $plgPosition[$plugin];
		}
	}
	
	return $tmpArr;
}

//funkcija koja pranalazi za dati FilterID naziv koji stoji iza njega
function vratiNazivZaFilter($plgtempl)
{	
	global $DBBR;
	global $ObjectFactory;
	//kreiram novi Plugin objekat
	$plugin = $ObjectFactory->createObject("Plugin",$plgtempl->PluginID);
	
	//kada smo nasli plugin objekat iz njega vadimo naziv klase 
	//a preko koga cemo doci do informacije o nazivu kategorije
	//koja je sa filterom povezana
	
	$classname = $plugin->ClassName;
	
	//kreiramo objekat koji je vezan za plugin ako takav postoji
	if($classname != 'null' && $plugin->DbStatus != 'NotFound' && $classname != "") 
	{
		//pravim objekat tipa koji je vezan za plugin
		eval("\$obj = \$ObjectFactory->createObject(\"".$classname."\",-1);");
		
		//niz objekata koje sada filtriramo
		if($plgtempl->FilterID == -1) return "nema podesavanja";
		$obj->postaviIDKategorijeZaPlugin($plgtempl->FilterID);
		$DBBR->nadjiSlogVratiGa($obj);
		$retstr = $obj->vratiNazivKategorijeZaPlugin();
		if($retstr != "") return $retstr;
		else "nema podesavanja";
	}
	
	return "nema podesavanja";
}
?>