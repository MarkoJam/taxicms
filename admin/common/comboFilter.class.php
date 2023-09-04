<?

	/* Page filters ----------------------------------------*/
	class PageStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_page";
			$this->sessionVariable = "sess_pagestatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "pagestatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "Page";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_PAGE;
		}
	}
	
	class PageTipStranicaFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "typeid";
			$this->offsetVariable = "offset_page";
			$this->sessionVariable = "sess_pagetypeid";
			$this->dbFilterVariable= "type_id";
			$this->hitField = "pagetypeid_hit";
			
			$this->idField= "ID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "Page";
			$this->comboObjectType = "SfPageType";
			$this->comboObjectFilter = "";
		}
	}
	
	class PageTemplateFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "templateid";
			$this->offsetVariable = "offset_page";
			$this->sessionVariable = "sess_pagetemplateid";
			$this->dbFilterVariable= "template_id";
			$this->hitField = "pagetemplateid_hit";
			
			$this->idField= "TemplateID";
			$this->nameField = "Title";
			
			$this->objectType = "Page";
			$this->comboObjectType = "Template";
			$this->comboObjectFilter = "";
		}
	}
	/* Page filters ----------------------------------------*/
	
	/* Sections filters ----------------------------------------*/
	class SectionsCategoryFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "sectionscategoryid";
			$this->offsetVariable = "offset_sections";
			$this->sessionVariable = "sess_sectionscategoryid";
			$this->dbFilterVariable= "sectionscategoryid";
			$this->hitField = "sectionscategory_hit";
			
			$this->idField= "SectionsCategoryID";
			$this->nameField = "Title";
			
			$this->objectType = "Sections";
			$this->comboObjectType = "SectionsCategory";
			$this->comboObjectFilter = "";
		}
	}
	
	class SectionsStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_sections";
			$this->sessionVariable = "sess_sectionsstatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "sectionsstatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "Sections";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_SECTIONS;
		}
	}
	
	/* Sections filters ----------------------------------------*/
	
	/* GenRes filters ----------------------------------------*/
	class GenResCategoryFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "genrescategoryid";
			$this->offsetVariable = "offset_genres";
			$this->sessionVariable = "sess_genrescategoryid";
			$this->dbFilterVariable= "genrescategoryid";
			$this->hitField = "genrescategory_hit";
			
			$this->idField= "GenResCategoryID";
			$this->nameField = "Title";
			
			$this->objectType = "GenRes";
			$this->comboObjectType = "GenResCategory";
			$this->comboObjectFilter = "";
		}
	}
	
	class GenResStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_genres";
			$this->sessionVariable = "sess_genresstatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "genresstatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "GenRes";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_GENRES;
		}
	}
	
	/* GenRes filters ----------------------------------------*/
	
	/* News filters ----------------------------------------*/
	class NewsCategoryFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "newscategoryid";
			$this->offsetVariable = "offset_news";
			$this->sessionVariable = "sess_newscategoryid";
			$this->dbFilterVariable= "newscategoryid";
			$this->hitField = "newscategory_hit";
			
			$this->idField= "NewsCategoryID";
			$this->nameField = "Title";
			
			$this->objectType = "News";
			$this->comboObjectType = "NewsCategory";
			$this->comboObjectFilter = "";
		}
	}
	
	class NewsStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_news";
			$this->sessionVariable = "sess_newsstatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "newsstatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "News";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_NEWS;
		}
	}
	
	/* News filters ----------------------------------------*/
	
	/* Module filters ----------------------------------------*/
	class ModuleCategoryFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "modulecategoryid";
			$this->offsetVariable = "offset_module";
			$this->sessionVariable = "sess_modulecategoryid";
			$this->dbFilterVariable= "modulecategoryid";
			$this->hitField = "modulecategory_hit";
			
			$this->idField= "ModuleCategoryID";
			$this->nameField = "Title";
			
			$this->objectType = "Module";
			$this->comboObjectType = "ModuleCategory";
			$this->comboObjectFilter = "";
		}
	}
	
	class ModuleStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_module";
			$this->sessionVariable = "sess_modulestatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "modulestatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "Module";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_MODULE;
		}
	}
	
	/*class NewsStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_news";
			$this->sessionVariable = "sess_newsstatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "newsstatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "News";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_NEWS;
		}
	}	*/
	
	/* Module filters ----------------------------------------*/

	/* Option filters ----------------------------------------*/
	class OptionCategoryFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "optioncategoryid";
			$this->offsetVariable = "offset_option";
			$this->sessionVariable = "sess_optioncategoryid";
			$this->dbFilterVariable= "optioncategoryid";
			$this->hitField = "optioncategory_hit";
			
			$this->idField= "OptionCategoryID";
			$this->nameField = "Title";
			
			$this->objectType = "Option";
			$this->comboObjectType = "OptionCategory";
			$this->comboObjectFilter = "";
		}
	}
	
	class OptionStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_option";
			$this->sessionVariable = "sess_optionstatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "optionstatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "Option";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_OPTION;
		}
	}	
	
	class OptionModuleFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "moduleid";
			$this->offsetVariable = "offset_option";
			$this->sessionVariable = "sess_optionmoduleid";
			$this->dbFilterVariable= "module_id";
			$this->hitField = "optionmodule_hit";
			
			$this->idField= "ModuleID";
			$this->nameField = "Header";
			
			$this->objectType = "Option";
			$this->comboObjectType = "Module";
			$this->comboObjectFilter = " status_id = " . STATUS_MODULE_AKTIVAN;
		}
	}
	
	
	/* Option filters ----------------------------------------*/
	
	/* Slide filters ----------------------------------------*/		
	class SlideShowFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "slideshowid";
			$this->offsetVariable = "offset_module";
			$this->sessionVariable = "sess_slideshowid";
			$this->dbFilterVariable= "slideshowid";
			$this->hitField = "slideshow_hit";
			
			$this->idField= "SlideShowID";
			$this->nameField = "ShowName";
			
			$this->objectType = "Slide";
			$this->comboObjectType = "SlideShow";
			$this->comboObjectFilter = "";
		}
	}	
	
	
	class SlideStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_slide";
			$this->sessionVariable = "sess_slidestatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "slidestatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "Slide";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " . STATUS_TIP_SLIDE;
		}
	}
	
	/* Slide filters ----------------------------------------*/	
	
	/* Gallery filters ----------------------------------------*/
	class GalleryCategoryFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "gallerycategoryid";
			$this->offsetVariable = "offset_gallery";
			$this->sessionVariable = "sess_gallerycategoryid";
			$this->dbFilterVariable= "gallerycategoryid";
			$this->hitField = "gallerycategory_hit";
			
			$this->idField= "GalleryCategoryID";
			$this->nameField = "Title";
			
			$this->objectType = "Gallery";
			$this->comboObjectType = "GalleryCategory";
			$this->comboObjectFilter = "";
		}
	}
	
	class GalleryStatusFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_gallery";
			$this->sessionVariable = "sess_gallerystatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "gallerystatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->comboObjectType = "SfStatus";
		}
	}
	
	/* Gallery filters ----------------------------------------*/	

	/* Resource filters -------------------------------------*/
	class ResourceFilter extends comboFilter
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "resourceid";
			$this->offsetVariable = "offset_resource";
			$this->sessionVariable = "sess_resourceid";
			$this->dbFilterVariable= "resource_id";
			$this->hitField = "resource_hit";
			
			$this->idField= "ID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "Comment";
			$this->comboObjectType = "SfResource";
			$this->comboObjectFilter = "" ;
		}
	}
	/* Resource filters -------------------------------------*/
	
	
	
	/* Product filters -------------------------------------*/
	class ProizvodjacFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "proizvodjacid";   			// example: kategorijaid
			$this->offsetVariable = "offset_prproizvodi";   	// example: offset_prproizvodi
			$this->sessionVariable = "sess_prproizvodjacid";  	// example: sess_prkategorijaid
			$this->dbFilterVariable= "proizvodjacid"; 			// example: kategorijaid or kategorija_id
			$this->hitField = "proizvodjac_hit";				// example: kategorija_hit
			
			$this->idField = "ProizvodjacID";
			$this->nameField = "Naziv";
			
			$this->objectType = "PrProizvod"; 	   				// example: PrProizvod
			$this->comboObjectType = "PrProizvodjac";			
			$this->comboObjectFilter = "";						
		}
	}

	class TipProizvodaFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "tipproizvodaid";
			$this->offsetVariable = "offset_prproizvodi";
			$this->sessionVariable = "sess_tipproizvodaid";
			$this->dbFilterVariable= "tipproizvodaid";
			$this->hitField = "tipproizvoda_hit";
			
			$this->idField= "TipProizvodaID";
			$this->nameField = "Naziv";
			$this->sortField = "naziv";
			
			$this->objectType = "PrProizvod";
			$this->comboObjectType = "PrTipProizvoda";
		}
	}

	
	
	class ProizvodStatusFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_prproizvodi";
			$this->sessionVariable = "sess_statusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "statusproizvoda_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "PrProizvod";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " .STATUS_TIP_PRODUCT;
		}
	}

	class ProizvodFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "proizvodid";
			$this->offsetVariable = "offset_prproizvodkomentar";
			$this->sessionVariable = "sess_proizvodid";
			$this->dbFilterVariable= "proizvodid";
			$this->hitField = "proizvodproizvodkomentar_hit";
			
			$this->idField= "ProizvodID";
			$this->nameField = "Naziv";
			$this->sortField = "naziv";
			
			$this->objectType = "PrProizvodKomentar";
			$this->comboObjectType = "PrProizvod";
			$this->comboObjectFilter = "";
		}
	}
	
	class ProizvodKomentarStatusFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_prproizvodkomentar";
			$this->sessionVariable = "sess_statusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "statusproizvodkomentar_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "PrProizvodKomentar";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " .STATUS_TIP_PRODUCTCOMMENT;
		}
	}
	
	
	/* Product filters --------------------------------------*/
	
	
	/* AdminUser filters ------------------------------------*/
	class AdminUserStatusFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_adminusers";
			$this->sessionVariable = "sess_adminstatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "adminuserstatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "AdminUser";
			$this->comboObjectType = "AdminUserStatus";
			$this->comboObjectFilter = "";
		}
	}

	class AdminUserSubSiteFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_prproizvodi";
			$this->sessionVariable = "sess_statusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "statusproizvoda_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "PrProizvod";
			$this->comboObjectType = "PrProizvodStatus";
			$this->comboObjectFilter = "";
		}
	}
	/* AdminUser filters ------------------------------------*/
	
	/* User filters */
	
	class UserStatusFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "statusid";
			$this->offsetVariable = "offset_users";
			$this->sessionVariable = "sess_userstatusid";
			$this->dbFilterVariable= "status_id";
			$this->hitField = "userstatus_hit";
			
			$this->idField= "StatusID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "User";
			$this->comboObjectType = "SfStatus";
			$this->comboObjectFilter = " tip_status_id = " .STATUS_TIP_USER;
		}
	}
	
	class UserTypeFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "typeid";
			$this->offsetVariable = "offset_users";
			$this->sessionVariable = "sess_usertypeid";
			$this->dbFilterVariable= "user_type_id";
			$this->hitField = "usertype_hit";
			
			$this->idField= "ID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "User";
			$this->comboObjectType = "SfUserType";
			$this->comboObjectFilter = "";
		}
	}
	
	class UserCategoryFilter extends comboFilter 
	{
		function __construct($ObjectFactory,$AdminTable)
		{
			parent::__construct($ObjectFactory,$AdminTable);
			
			$this->filterVariable = "categoryid";
			$this->offsetVariable = "offset_users";
			$this->sessionVariable = "sess_usercategoryid";
			$this->dbFilterVariable= "user_category_id";
			$this->hitField = "usercategory_hit";
			
			$this->idField= "ID";
			$this->nameField = "Vrednost";
			
			$this->objectType = "User";
			$this->comboObjectType = "SfUserCategory";
			$this->comboObjectFilter = "";
		}
	}
	
	/* UserStatus filters ------------------------------------*/
	
	
	class comboFilter 
	{
		// related objects
		protected $DatabaseBroker;
		protected $AdminTable;
		protected $ObjectFactory;
		protected $LanguageArray;
		
		// internal class attributes
		protected $idField;			// example: KategorijaID
		protected $nameField;		// example: Naziv
		protected $sortField;		// example: kategorija_order
		protected $filterVariable;   // example: kategorijaid
		protected $offsetVariable;   // example: offset_prproizvodi
		protected $sessionVariable;  // example: sess_prkategorijaid
		protected $dbFilterVariable; // example: kategorijaid or kategorija_id
		
		protected $objectType; 	   	 // example: PrProizvod
		protected $comboObjectType;  // example: PrProizvodjac
		protected $comboObjectFilter;  // example: tip_statusa = 1
		protected $hitField;
		
		protected $generatedComboBox; 
		
		// default class constructor
		function __construct($ObjectFactory, $AdminTable)
		{
			$this->ObjectFactory = $ObjectFactory;
			$this->AdminTable = $AdminTable;
		}
		
		// template pattern method
		function generateProccessComboBox()
		{
			// 1. set all session variables
			$this->setSessionVariable();			
			// 2. create filter for object list
			$this->createFilter();
			// 3. generate actual combobox
			$this->generateComboBox();
		}
		
		// 1. set all session variables
		protected function setSessionVariable()
		{
			if(isset($_REQUEST[$this->filterVariable]))
			{
				//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
				$_SESSION[$this->offsetVariable]=0;
				//$this->AdminTable->SetOffset(0);
				$_SESSION[$this->sessionVariable] = $_REQUEST[$this->filterVariable];
			}
			if(isset($_SESSION[$this->sessionVariable])) {
				if($_SESSION[$this->sessionVariable] == -1) unset($_SESSION[$this->sessionVariable]);
			}		
		}
		
		// 2. create filter for object list
		function createFilter()
		{
			if(isset($_REQUEST[$this->filterVariable]) && $_REQUEST[$this->filterVariable] != -1)
			{
				$this->ObjectFactory->AddFilter($this->dbFilterVariable."=".$_REQUEST[$this->filterVariable]);
			}
			else
			{
				if(isset($_SESSION[$this->sessionVariable]) && $_SESSION[$this->sessionVariable] != -1)
				{
					$this->ObjectFactory->AddFilter($this->dbFilterVariable."=".$_SESSION[$this->sessionVariable]);	
				}
			}
		}
			
		// 3. generate actual combobox
		function generateComboBox()
		{
			$localObjFactory = new ObjectFactory();
			$localObjFactory->AddFilter($this->comboObjectFilter);
			if($this->sortField != "") $localObjFactory->SetSortBy($this->sortField);
			$objectList = $localObjFactory->createObjects($this->comboObjectType);
			$cmb_proizvodjaci  = "<select class='form-control' name='".$this->filterVariable."' onChange='formTable.submit();'>";
			$cmb_proizvodjaci .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
			
			foreach ($objectList as $obj)
			{
				$selected = "";
				eval("\$id = \$obj->get".$this->idField."();");
				eval("\$name = \$obj->get".$this->nameField."();");
				
				if(isset($_REQUEST[$this->filterVariable]) && $id == $_REQUEST[$this->filterVariable])
				{
					$selected = "selected";
				}
				else 
				{
					if(isset($_SESSION[$this->sessionVariable]) && $id == $_SESSION[$this->sessionVariable])
					{
						$selected = "selected";
					}
				}
				
				$cmb_proizvodjaci .= "<option ".$selected." value='".$id."'>" .$name . "</option>";
			}
			$this->generatedComboBox = $cmb_proizvodjaci .= "</select><input type='hidden' name='".$this->hitField."' value='true'>";	
		}
		
		function getComboBox()
		{
			return $this->generatedComboBox;	
		}
	}	
		
	class inputFilter 
	{
		// related objects
		protected $DatabaseBroker;
		protected $AdminTable;
		protected $ObjectFactory;
		protected $LanguageArray;
		
		// internal class attributes
		protected $nameField;		// example: Naziv
		protected $sortField;		// example: kategorija_order
		protected $filterVariable;   // example: kategorijaid
		protected $sessionVariable;  // example: sess_prkategorijaid
		
		
		// default class constructor
		function __construct($ObjectFactory, $AdminTable)
		{
			$this->ObjectFactory = $ObjectFactory;
			$this->AdminTable = $AdminTable;
		}
		

		
		function createFilter($fields)
		{				
			if (isset($_REQUEST['cancel'])) unset ($_SESSION['search']);
			if (isset($_SESSION['search'])) 	
			{	
				$filter='(';
				$cnt=count($fields);
				$i=1;
				foreach($fields as $field)
				{
					$filter.="`".$field."` LIKE '%".$_SESSION['search']."%'";
					if (!($i==$cnt)) $filter.=" OR "; 
					$i++;
				}
				$filter.=')';
				$this->ObjectFactory->AddFilter($filter);
			}

			return 
				"
				<div id='search_filter' class='form-inline'>
					<div class='form-group'>
						<label for='naziv'>".getTranslation("PLG_FILTER")."</label>
						<input class='form-control' name='search' id='search' value='".$_SESSION['search']."'  type='text' placeholder='".getTranslation("PLG_ADD_NEW")."' />
					</div>
					<div class='submitButton btn btn-primary' name='submitFilter'>".getTranslation("PLG_FILTER_DO")."</div>
					<div class='resetButton btn btn-danger cancel' name='resetFilter'>".getTranslation("PLG_RESET")."</div>
				</div>
				";
		}	
	}
?>