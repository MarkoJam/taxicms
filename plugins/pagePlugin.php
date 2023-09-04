<?
	// base class for all plugins
	class pagePlugin
	{
		protected $LanguageHelper;
		protected $ObjectFactory;
		protected $DatabaseBroker;
		protected $CMSSetting;
		protected $GenerateThumb;
		protected $smarty;

		private $LanguageArray = array();
		private $LanguageArrayInternal = array();
		private $xmlConfig;

		protected $SmartyPluginBlock;
		protected $Position = "standard";

		function __construct()
		{
			$this->LanguageHelper = LanguageHelper::getInstance();
			$this->ObjectFactory = ObjectFactory::getInstance();
			$this->DatabaseBroker = DatabaseBroker::getInstance();
			$this->CMSSetting = CMSSettings::getInstance();
			$this->GenerateThumbs = GenerateThumbs::getInstance();
			$this->HierarchicalTree = new Tree();

			$this->xmlConfig = new XMLConfig;
			$this->xmlConfig->Parse(ROOT_HOME."config/languages/lang_".$this->LanguageHelper->GetFileDesc().".xml");
			$this->LanguageArray["value"] = array();

			$this->SmartyPluginBlock = new SmartyPluginBlock();
		}

		function showDefault(){}
		function showDetails(){}
		function setFilterID($filterId){}

		function setPosition($value)
		{
			$this->Position = $value;
		}

		function getPosition()
		{
			return $this->Position;
		}

		function setSmarty($smarty)
		{
			$this->smarty = $smarty;
		}

		/*
		 * Vraca PageID za stranicu na kojoj se nalazimo
		 *
		 * @return int
		 */
		function getPageID()
		{
			if(isset($_REQUEST["page_id"]))
			{
				return $_REQUEST["page_id"];
			}
			else if (isset($_REQUEST["spage_id"]))
			{
				return $_REQUEST["spage_id"];
			}
			else
			{
				return 0;
			}
		}

		/*
		 * Vraca formiran PageLink
		 *
		 * @return string
		 */
		function getPageLink()
		{
			if (isset($_REQUEST["spage_id"]))
			{
				return "spage_id=".$_REQUEST["spage_id"];
			}

			if(isset($_REQUEST["page_id"]))
			{
				return "page_id=".$_REQUEST["page_id"];
			}

			return "page_id=0";
		}

		public function SetPluginLanguage($plg_lang)
		{
			//varijanta preko xml tabele
			/*$this->LanguageArrayInternal = $this->xmlConfig->get("/".$plg_lang);
			$this->RegisterPluginLanguage();
			$this->AddToBigLanguageArray();*/
			//varijanta preko sql tabele
			$this->SetLabels();
		}

		public function SetLabels()
		{
			$labels = $this->ObjectFactory->createObjects("Labels");
			foreach ($labels as $lab)
			{
				if ($lab->getTranslate()=="") $lab->setTranslate($lab->getContent());
				$this->smarty->assign($lab->getName(), $lab->getTranslate());
				$this->LanguageArrayInternal['value'][$lab->getName()]=$this->LanguageHelper->Transliterate($lab->getTranslate());
			}
			$this->RegisterPluginLanguage();
			$this->AddToBigLanguageArray();
			return $this->LanguageArray;
		}

		function RegisterPluginLanguage()
		{
			if(count($this->LanguageArrayInternal["value"])> 0)
			{
				foreach ($this->LanguageArrayInternal["value"] as $key => $value)
				{
					$this->smarty->assign($key,$value);
				}
			}
		}

		function AddToBigLanguageArray()
		{
			if(count($this->LanguageArrayInternal["value"])> 0)
			{
				foreach ($this->LanguageArrayInternal["value"] as $key => $value)
				{
					if(!$this->isKeyExists($key))
					{
						$this->LanguageArray["value"] = array_merge($this->LanguageArray["value"], array($key => $value));
					}
				}
			}
		}

		function isKeyExists($key_test)
		{
			if(count($this->LanguageArray["value"])> 0)
			{
				foreach ($this->LanguageArray["value"] as $key => $value)
				{
					if($key_test == $key) return true;
				}
			}
			return false;
		}



		function getTranslation($translationId)
		{
			if(isset($this->LanguageArray["value"][$translationId]))
			{
				return $this->LanguageArray["value"][$translationId];
			}
			else return "ERROR_TRANSLATION-".$translationId;
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
			return $value;
		}

		function getTemplateID()
		{
			if(isset($_REQUEST["tid"]))
			{
				return $_REQUEST["tid"];
			}
		}

		function GetOffsetParam()
		{
			$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			$var  = parse_url($url, PHP_URL_QUERY);
			$var  = html_entity_decode($var);
			$var  = explode('&', $var);
			$params  = array();

			foreach($var as $val)
			{
				$x = explode('=', $val);
				if(count($x) == 2)
				{
					$params[$x[0]] = $x[1];
				}
			}
			unset($val, $x, $var);

			foreach($params as $param => $value)
			{
				if(strpos($param, "offset".$this->getPosition()) === 0)
					return $param."=".$value;
			}

			return "";
		}

		function showConResource($class,$limit=4)
		{	
			// direktno konektovani resursi iz tabele resres
			eval ('$ss=STATUS_'.strtoupper($class).'_AKTIVAN;');
			eval ('$id=$_REQUEST["'.strtolower($class).'_id"];');
			if ($class<>"Option") eval ('$category="'.$class.'Category";');
			$ids=array();
			//prolaz kroz sve plugine
			$this->ObjectFactory->ResetFilters();
			$this->ObjectFactory->AddFilter("class = '".$class."'"  );			
			$resources = $this->ObjectFactory->createObjects("SfResource");
			$this->ObjectFactory->ResetFilters();
			$rid=$resources[0]->getID();
			$rid=$rid.".".$id;
			$i=0;
			$this->ObjectFactory->ResetFilters();
			$this->ObjectFactory->AddFilter("res_id = " . $rid );			
			$resres= $this->ObjectFactory->createObjects("ResRes");
			$this->ObjectFactory->ResetFilters();	
			// prolaz kroz sve resurse plugina	
			foreach ($resres as $nn)													
			{
				$i++;
				if ($i>$limit) break;	
				$id_arr=explode('.',$nn->getConResID());	
				$resource = $this->ObjectFactory->createObject("SfResource",$id_arr[0]);
				$class=$resource->getClass();
				eval ('$ss=STATUS_'.strtoupper($class).'_AKTIVAN;');
				$conres = $this->ObjectFactory->createObject($class,$id_arr[1],array("SfStatus",$category));
				eval('$idx=$conres->get'.$class.'ID();');
				$ids[]=$id_arr[1];
				if($conres->SfStatus->getStatusID()==$ss) $conres_all[]=$this->prepareConResource($conres,$class,$idx);
				else $i=$i-1;
			}
			// vezivanje preko kljucnih reci
			/*if ($i<$limit) {
				// niz kljucnih reci datog resursa
				$resource = $this->ObjectFactory->createObject($class,$id,array("SfStatus",$category));	
				$k_arr=explode(',',$resource->getKeywords());	
				
				// sve kljucne reci
				// prolaz kroz sve plugine
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("status = 1"  );			
				$resources = $this->ObjectFactory->createObjects("SfResource");
				$this->ObjectFactory->ResetFilters();
				foreach($resources as $res) {
					eval ('$ss2=STATUS_'.strtoupper($res->getCode()).'_AKTIVAN;');
					eval ('$category2="'.$res->getClass().'Category";');
					
					//prolaz kroz sve resurse tekuceg plugina
					$this->ObjectFactory->ResetFilters();
					$this->ObjectFactory->AddFilter("keywords != '' AND status_id=".$ss2);				
					$resources2 = $this->ObjectFactory->createObjects($res->getClass(),array("SfStatus",$category2));
					$this->ObjectFactory->ResetFilters();
					foreach ($resources2 as $rs)													
					{
						eval('$idx=$rs->get'.$res->getClass().'ID();');
						if ($id<>$idx) {
							// punjenje niza kljucnih reci
							$k2_arr=explode(',',$rs->getKeywords());	
							//koliko imaju zajednichih kljucnih reci
							$result = array_intersect($k_arr, $k2_arr);
							$cnt=count($result);
							if ($cnt>0) {
								// pravljenje niza sa rezultatom ukrstanja nizova kljucnih reci
								$datum=$rs->getDate();
								$cntADD=$cnt.'-'.$datum;
								$arr=array("class" => $res->getClass(), "id" => $idx,"cnt" => $cntADD);
								$all[]=$arr;
							}
						}
					}
				}
				// sortiranje niz rezultata ukrstanja po broju ukrstanja
				$this->aasort($all,"cnt");
				// prolazak kroz sortiran niz rezultata ukrstanja
				foreach ($all as $x) {
					// da li je vec prikazan
					if (!in_array($x['id'],$ids)) {
						$i++;
						if ($i>$limit) break;	
						eval ('$category3="'.$x['class'].'Category";');
						$conres = $this->ObjectFactory->createObject($x['class'],$x['id'],array("SfStatus",$category3));
						eval('$idx=$conres->get'.$x['class'].'ID();');
						$ids[]=$idx;
						if($conres->SfStatus->getStatusID()==$ss) $conres_all[]=$this->prepareConResource($conres,$x['class'],$idx);
						else $i=$i-1;	
					}
				}						
			}*/
			//vezivanje preko poslednjih vesti iste kategorije
			/*if ($i<$limit) {
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("status_id=".$ss);	
				$this->ObjectFactory->AddLimit($limit+10);	
				$resources3 = $this->ObjectFactory->createObjects($class,array("SfStatus",$category));
				$this->ObjectFactory->ResetFilters();
				foreach ($resources3 as $conres)													
				{
					eval('$idx=$conres->get'.$class.'ID();');
					if (!in_array($idx,$ids) && $id<>$idx) {
						$i++;
						if ($i>$limit) break;
						if($conres->SfStatus->getStatusID()==$ss) $conres_all[]=$this->prepareConResource($conres,$class,$idx);
						else $i=$i-1;	
					}
				}
			}*/
			return $conres_all;
		}
		
		function aasort (&$array, $key) {
			$sorter=array();
			$ret=array();
			reset($array);
			foreach ($array as $ii => $va) {
				$sorter[$ii]=$va[$key];
			}
			arsort($sorter);
			foreach ($sorter as $ii => $va) {
				$ret[$ii]=$array[$ii];
			}
			$array=$ret;
		}	

		function prepareConResource($conres,$class,$idx) {
			$html = $conres->getHtmlUnchanged();
			$html = htmldecode($html);
			$shorthtml = $conres->getShortHtmlUnchanged();
			$shorthtml = htmldecode($shorthtml);
			$this->GenerateThumbs->PrepareThumbs($html);
			if(IS_URLREWRITE_ON) $html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
			$conres->setHtml($html);
			$conres->setShortHtml($shorthtml);	
			$conres_array = $conres->toArray();
			$links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, strtolower($class), $idx,'w',$conres->getHeaderUnchanged()));			
			return $conres_array = array_merge($conres_array, array("link_print_dt" => $links_print_dt));
		}
		
		function pagination($count,$limit)
		{
			if ($limit>0) {
				global $smarty;
				$pageno=(number_format($count/$limit+0.5,0));
				$current_page=$_REQUEST['offset']/$limit+1;
				$lres=$_REQUEST['offset']+$limit;
				if ($lres>$count) $lres=$count;
				$smarty->assign('fres',$_REQUEST['offset']+1);
				$smarty->assign('lres',$lres);
				$current_page2=$current_page;
				if ($current_page<4) $current_page2=3;
				if ($current_page>$pageno-4) $current_page2=$pageno-2;
				for ($i = 0; $i <= $count-1; $i=$i+$limit) {
					$pn++;
					if ($pn>$current_page2-3 && $pn<$current_page2+3) {
						$arr=array('page'=>$pn,'offset'=>$i);
						$pages_arr[]=$arr;
					}		
				}
				$smarty->assign('count',$count);
				$smarty->assign('pages_no',$pageno);
				$smarty->assign('current_page',$current_page);
				if (count($pages_arr)>1) {

					$smarty->assign('pages_arr',$pages_arr);
					$smarty->assign('pages_limit',($limit));			
					if ($current_page>2) $smarty->assign('first',true);
					$smarty->assign('first_offset',1);
					if ($current_page<$count-1) $smarty->assign('last',true);					
					$smarty->assign('last_offset',$pageno);			
					if ($current_page>1) $smarty->assign('previous',true);
					$smarty->assign('previous_offset',$current_page-1);
					if ($current_page<$count) $smarty->assign('next',true);
					$smarty->assign('next_offset',($current_page+1));
				}
				ob_start();
				$smarty->display(ROOT_HOME.'templates/pagination.tpl');
				$data = ob_get_contents();
				ob_end_clean();
				return $data;
			}
		}
		
		function prepare_mail($tpl,$smarty=null) {
			if (!is_null($smarty)) $this->smarty=$smarty;
			$sc=$this->ObjectFactory->CreateObject('SectionsCategory',MAIL_HEADER_LOGO,array('Sections'));
			if (count($sc->Sections)>0) $this->smarty->assign('mail_logo',$sc->Sections[0]->toArray());
			$sc=$this->ObjectFactory->CreateObject('SectionsCategory',MAIL_FOOTER_DATA,array('Sections'));
			if (count($sc->Sections)>0) $this->smarty->assign('mail_footer',$sc->Sections[0]->toArray());
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->AddFilter("sections_category_id = " .MAIL_HEADER_NAVIGATION);
			$this->ObjectFactory->SetSortBy("sections_sectionscategory_order");
			$ssc= $this->ObjectFactory->createObjects("SectionsSectionsCategory");
			$this->ObjectFactory->Reset();
			foreach($ssc as $sec) {
				$sc=$this->ObjectFactory->CreateObject('Sections',$sec->getSectionsID());
				$nav[]=$sc->toArray();
			}
			if (count($ssc)>0) $this->smarty->assign('mail_nav',$nav);
			ob_start();
			$this->smarty->assign('ROOT_WEB',ROOT_WEB);
			$this->smarty->display("mail/mail_header.tpl");
			$this->smarty->display("mail/".$tpl);
			$this->smarty->display("mail/mail_footer.tpl");
			$message = ob_get_contents();
			ob_end_clean();
			return $message;
		}

		function send_mail($sendertype,$from,$fromName,$AddAddress,$subject,$message,$CMSSetting=null,$admin=false) {
			if (!is_null($CMSSetting)) $this->$CMSSetting=$CMSSetting;
			if(IS_PRODUCTION) {
				$phpmail = new PHPMailer();
				switch($sendertype)
				{
					case SENDER_TYPE_SMTP:
						$phpmail->IsSMTP();
						$phpmail->Host = $this->CMSSetting->getSettingByID(ORDER_HOST_NAME);
						break;
					case SENDER_TYPE_MAIL:
						$phpmail->IsMail();
						break;
					default:
						break;
				}
			//	$phpmail->From = $this->CMSSetting->getSettingByID($from);
			//	$phpmail->FromName = $this->CMSSetting->getSettingByID($fromName);
			//	$phpmail->From = $this->CMSSetting->getSettingByID(ORDER_MAIL_EMAIL);
			//	$phpmail->FromName = $this->CMSSetting->getSettingByID(ORDER_MAIL_NAME);
			//	echo $AddAddress."<br>";
				$phpmail->IsHTML(true);
				$phpmail->AddAddress($AddAddress);
				$phpmail->Subject = $subject;
				$phpmail->Body = $message;
				$phpmail->Send();
				unset($phpmail);
			}
			else {
				if ($admin) echo "<div class='success'>".$message."</div>";
				else echo $message."<br>";
			}
		}


	}

?>
