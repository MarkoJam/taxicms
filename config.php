<?php
	//----SdStudio sajt copyright SDStudio 2005 godna-----
	//
	//  Verzija sajta 1.001
	//
	//  Autori sajta: Kolarov Ivan, Dejan Stojadinovic
	//
	//----------------------------------------------------


	include_once("definitions.php");
	
	include_once("conn_string.php");
	
	date_default_timezone_set('Europe/Belgrade');
	
	if(!IS_CONN_STRING_LOADED) 
	{
		echo "ERROR LOADING CONNECTION STRINGS";
		exit(0);
	}
	
	session_start();	
	
	if(!isset($_ADMINPAGES)) $_ADMINPAGES = false;

	//----------------------------------------------------
	// provera funkcionisanja XML na PHP 5-ci
	//----------------------------------------------------
	//if(IS_PRODUCTION)
	{	
		if (version_compare(PHP_VERSION,'5','>='))
 		require_once('common/class/domxml-php4-to-php5.php'); 
		// samo za php=<8.0
		if (!function_exists('is_countable')) {
			function is_countable($x) {
				if (!in_array(gettype($x),array('object','array'))) return false;
				else return true;
			}	
		}	
		function countObject($x) {
			if (!is_countable($x)) return NULL;
			else return count($x);
		}
	}
	//----------------------------------------------------
	// klase neophodne za rad SD/CMS aplikacije
	//----------------------------------------------------

		include_once("common/functions/xmlconfig.php");
		include_once("common/functions/date.php");
		include_once("common/functions/PathVars.php"); 
		include_once("common/functions/helpers.php"); 
		
		include_once("common/class/img2thumb.php");
		include_once("common/class/interfejsi.php");
		include_once("common/class/dbbr.php");
		include_once("common/class/languageHelper.php");
		include_once("common/class/adminTable.php");
		include_once("common/class/smartyHelper.php");
		include_once("common/class/TreeMenu.class.php");
		include_once("common/class/class.auth.php");
		include_once("common/class/class.settings.php");
		include_once("common/class/class.generatethumbs.php");
		include_once("common/class/class.smartypluginblock.php");
		include_once("common/class/class.memtree.php");
		include_once("common/class/class.KpGrupaProizvodaTree.php");
		include_once("common/class/class.paginatehelper.php");
		include_once("common/class/class.commonfilter.php");
		include_once("common/class/class.filterbox.php");
		include_once("common/class/maintenance.php");
		include_once("common/link.php");

		if(isset($_ADMINPAGES) && !$_ADMINPAGES)
		{
			include_once("common/class/pluginInvoker.class.php");
		}
		
		include_once("common/factories/factoryBase.php");
		include_once("common/factories/ObjectFactory.class.php");
		include_once("common/libs/Smarty.class.php");
		include_once("common/libs/SmartyValidate.class.php");
		include_once("common/libs/SmartyPaginate.class.php");
		
		include_once("common/phpmailer/class.phpmailer.php"); 
		include_once("common/phpmailer/class.smtp.php");
		include_once("common/class/class.connobj.php"); 									
		
		if($_ADMINPAGES)
		{
			include_once("admin/common/SortLink.class.php"); 
			include_once("admin/common/comboFilter.class.php"); 	
			include_once("admin/common/function.php");			
		}
		
		if(USE_PEAR && isset($_ADMINPAGES) && $_ADMINPAGES)
		{
			require_once 'Spreadsheet/Excel/Writer.php';
		}
	//----------------------------------------------------
	//inicijalizacija Smarty objekta
	//----------------------------------------------------	
	
	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging =false;
	
	$smarty->assign("SITE_NAME",$SITE_NAME);

	$db = new ezSQL_mysql;
		
	//----------------------------------------------------
	// Globalna promenljiva DatabaseBroker
	//----------------------------------------------------
	if(!DatabaseBroker::isOnline())
	{
		$smarty->display("mysqldown.tpl");
		exit();
	}
	

	$DBBR = DatabaseBroker::getInstance();

	//----------------------------------------------------
	// Globalna promenljiva ObjectFactory koji je 
	// odgovoran za kreiranje svih objekata u aplikaciji
	// i njihovo povezivanje
	//----------------------------------------------------
	
	$ObjectFactory = ObjectFactory::getInstance();
	//----------------------------------------------------
	// podesavanja za jezike
	//----------------------------------------------------
	
	$lh = LanguageHelper::getInstance();
	$lh->Initialize();
	//----------------------------------------------------
	// CmsSetting klasa koristi se za ucitavanje i
	// interaktivan rad sa podesvanjima sadrzanim u bazi u
	// tabeli sys_setting.
	//----------------------------------------------------
	
	$CMSSetting = CMSSettings::getInstance();
	//----------------------------------------------------
	// ucitavanje jezika
	//----------------------------------------------------

	$config = new XMLConfig;
	$LanguageArray = array();
	$smarty->assign("local_language",$lh->CurrentLanguage());
	//istek sesije za front administraciju
	if (!(isset($_SESSION["logeduserid"])) && isset($_REQUEST['frontadmin'])) {
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter("adminpagename='session_expire'");
		$adminpages = $ObjectFactory->createObjects("AdminPage");
		$ObjectFactory->ResetFilters();
		if(count($adminpages) == 1)
		{
			$adminpage = $adminpages[0];
			$linkAdminPage = new LinkAdminPage($lh, $adminpage->getAdminPageID(), $adminpage->getAdminPageName(), $adminpage->getHeader());
			$linkAdminPagePrint = $lh->getPrintLink($linkAdminPage);
			header('Location: '. $linkAdminPagePrint);
		}
	}
	if($_ADMINPAGES && !isset($_REQUEST['frontadmin']))
	{
		//if (isset($_POST['latinica']) && $lh->GetFileDesc() == 'srp') $_SESSION['lat']=true;
		//$config->Parse(ROOT_HOME."admin/languages/lang_".$lh->GetFileDesc().".xml"); //ako hocemo visejezicnu administraciju
		$config->Parse(ROOT_HOME."admin/languages/lang_srp.xml");
		$LanguageArray = $config->get("/administration");
		$MessageArray = $config->get("/messages");
		foreach ($LanguageArray['value'] as $key=>$lng)
		{
			$LanguageArray['value'][$key]= $lh->CirToLat($lng);
		}
		foreach ($MessageArray['value'] as $key=>$msg)
		{
			$MessageArray['value'][$key]= $lh->CirToLat($msg);
		}
		$lh->RegisterPluginLanguageFile($LanguageArray , $smarty);
	}

	if(isset($_ADMINPAGES) && !$_ADMINPAGES) {
		$labels = $ObjectFactory->createObjects("Labels");
		$LanguageArray = array();

		foreach ($labels as $lab)
		{
			if ($lab->getTranslate()=="") $lab->setTranslate($lab->getContent());
			$smarty->assign($lab->getName(), $lab->getTranslate());
			$LanguageArray['value'][$lab->getName()]=$lab->getTranslate();
		}
	}
	if($_ADMINPAGES)
	{
		$inputFilter= new inputFilter($ObjectFactory,$ap);
		if (isset($_REQUEST['search']) ) $_SESSION['search']=$_REQUEST['search'];
		//za slicice
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_copy = "<i class='fa fa-clone' aria-hidden='true'></i>";

		$auth = new Authenticate();
	}

	if (isset($_REQUEST['frontadmin'])) $_SESSION["subsiteid"]=1;

	if($_ADMINPAGES && !isset($_REQUEST['frontadmin']))
	{
		if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "logout")
		{
			$auth->logout();
			unset ($_SESSION['lat']);
		}

		if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "login" )
		{


			if (!IS_PRODUCTION) $_POST["g-recaptcha-response"]='LOCAL'; // za premoscavanje na localhostu
			if($_POST["g-recaptcha-response"] && $_POST["g-recaptcha-response"]!='' )
		 	{
				/* request validation from the reCAPTCHA API */
		        $captcha = $_POST["g-recaptcha-response"];
				$response = file_get_contents_curl("https://www.google.com/recaptcha/api/siteverify?secret=".CAPTCHA_KEY_1."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
				$data = json_decode($response);
		         /* process form when the API has confirmed validation */
		        if ((isset($data->success) AND $data->success==true) || ($_POST["g-recaptcha-response"]=='LOCAL')) {

		            /* the business logic happens here …      */
		            /* e.g. process form, send mail, whatever */

		            /* return "success" in order to switch the template */
		         	if($auth->login())
				 	{
						header('Content-Type: text/html; charset=utf-8');
						header('Set-Cookie: ad_cookie_language='.$_SESSION["ad_cookie_language"].';path=/ ');
						header('Location: index.php');
				  	}
		         	else $smarty->assign("error_login","true");
		        }
		        else
		        {
		            /* return an error if the CAPTCHA was incorrect */
		            //$smarty->assign("recaptcha",recaptcha_get_html($pubkey,$rsp->error));
		            $smarty->assign("error_login","true");
		        }
			}
			else
			{
			 /* return an error if an empty CAPTCHA was submitted */
			 //$smarty->assign("recaptcha",recaptcha_get_html($pubkey,‘incorrect-captcha-sol’));
			 $smarty->assign("error_login","true");
			}
		}
		// user is not logged - show him login form
		if(!$auth->isLogged())
		{
			if (isset($_REQUEST['user_name']) || isset($_REQUEST['user_password']) ) $smarty->assign("error_login","true");;



			// potrebno je napuniti combobox sa subsiteovima
			$subsite_arr = $ObjectFactory->createObjects("SubSite");

			$shSubSite = new SmartyHtmlSelection("subsite", $smarty);
			if(count($subsite_arr)>0)
			{
				foreach ($subsite_arr as $subsite)
				{
					if($subsite->SfStatus->StatusID == STATUS_SUBSITE_AKTIVAN)
					{
						$shSubSite->AddOutput($subsite->Name);
						$shSubSite->AddValue($subsite->SubSiteID);
					}
				}
			}
			$shSubSite->SmartyAssign();

			if (CAPTCHA_KEY_2 != '') $smarty->assign("dkey",CAPTCHA_KEY_2);
			$smarty->display(ROOT_HOME.'admin/templates/login.tpl');
			exit();
		}
	}


	function htmldecode(& $html)
	{
		$html = str_replace('&gt;', '>', $html);
		$html = str_replace('&lt;', '<', $html);
		$html = str_replace('&quot;','"', $html);
		$html = str_replace('&amp;', '&', $html);
		$html = str_replace('&amp;', '&', $html);
		$html = str_replace('&#039;', '\'', $html);
		$html = str_replace('&ndash;', '-', $html);

		return $html;
	}

	function rteSafe($strText)
	{
		//returns safe code for preloading in the RTE
		$tmpString = $strText;

		//convert all types of single quotes
		$tmpString = str_replace(chr(145), chr(39), $tmpString);
		$tmpString = str_replace(chr(146), chr(39), $tmpString);
		$tmpString = str_replace("'", "&#39;", $tmpString);

		//convert all types of double quotes
		$tmpString = str_replace(chr(147), chr(34), $tmpString);
		$tmpString = str_replace(chr(148), chr(34), $tmpString);

		//replace carriage returns & line feeds
		$tmpString = str_replace(chr(10), " ", $tmpString);
		$tmpString = str_replace(chr(13), " ", $tmpString);

		return $tmpString;
	}

	function getTranslation($translationid)
	{
		global $LanguageArray;
		if(@$LanguageArray["value"][$translationid] != "")
		{
			return $LanguageArray["value"][$translationid];
		}
		else
		{
			return "Invalid translation! - ".$translationid;
		}
	}

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr $errfile $errline<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr $errfile $errline<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr $errfile $errline<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

function ErrorHandlerHeaderProblem($errno, $errstr, $errfile, $errline)
{
		//echo $errstr;
		if(strpos($errstr, "headers"))
			echo "Header ERROR: [$errno] $errstr $errfile $errline<br />\n";
}



function quote_smart($value)
{
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	if (!is_numeric($value))
	{
		$db = new ezSQL_mysql;
		//$value = "'" . mysql_real_escape_string($value) . "'";
		$value = "'" . mysqli_real_escape_string($db->links,$value) . "'";
	}
	if($value == -1)
	{
		$value = "NULL";
	}
	return $value;
}

function dump($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function asciify($str)
{
	$str = str_replace("č","c",$str); $str = str_replace("Č","C",$str);
	$str = str_replace("ć","c",$str); $str = str_replace("Ć","C",$str);
	$str = str_replace("š","s",$str); $str = str_replace("Š","S",$str);
	$str = str_replace("ž","z",$str); $str = str_replace("Ž","Z",$str);
	$str = str_replace("đ","dj",$str); $str = str_replace("Đ","Dj",$str);

	return $str;
}

/*function urlize($val)
{
	global $lh;
	$val = $lh->CirToLatAsciffy($val);
	$val = iconv('UTF-8', 'ASCII//TRANSLIT', $val);
	$val = str_replace('"', '', $val);
    $val = strtolower(asciify(trim($val)));
    $val = str_replace('&quot', '', $val);
	$val = str_replace('&', 'i', $val);
    $val = str_replace(' ', '-', $val);
    $val = str_replace("'", '', $val);
    $val = preg_replace('/[^a-z0-9]+/', '-', $val);
    $val = preg_replace('/^[^a-z0-9]+/', '', $val);
    $val = preg_replace('/[^a-z0-9]+$/', '', $val);

	return $val;
}*/

function urlize($val,$sh=null)
{
	global $lh;
	//$val2=$val;
	$val = $lh->CirToLatAsciffy($val);
	$val = strtolower(asciify(trim($val)));
	$val = iconv('UTF-8', 'ASCII//TRANSLIT', $val);
	$val = str_replace('"', '', $val);
	$val = str_replace('&quot', '', $val);
	$val = str_replace('&', 'i', $val);
	$val = str_replace(' ', '-', $val);
	$val = str_replace('"', '', $val);
	$val = str_replace("'", '', $val);
	$val = str_replace("’", '', $val);
	$val = preg_replace('/[^a-z0-9]+/', '-', $val);
	$val = preg_replace('/^[^a-z0-9]+/', '', $val);
	$val = preg_replace('/[^a-z0-9]+$/', '', $val);
	if ($sh<>"" and $sh!="-999") {
		//global $DBBR;
		//global $ObjectFactory;
		//$page=$ObjectFactory->createObject('Page',$pid);
		$val=urlize($sh);
	}
	return $val;
}

function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
