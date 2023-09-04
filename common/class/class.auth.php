<?
	/* CMS Studio 3.0 class.auth.php */

	class Authenticate
	{
		private $DBBR;
		private $AuthUser;
		private $ObjectFactory;

		function __construct()
		{
			$this->DBBR = DatabaseBroker::getInstance();
			$this->ObjectFactory = ObjectFactory::getInstance();
		}

		function isActionAllowed($action_code)
		{
			if (isset($_REQUEST['frontadmin'])) return true;
			$this->ObjectFactory->ResetFilters();
            $adminUser = $this->ObjectFactory->createObject("AdminUser", $this->getAdminUserId());

            $this->ObjectFactory->ResetFilters();
            $adminusergroup = $this->ObjectFactory->createObject("AdminUserGroup",$adminUser->AdminUserGroup->AdminUserGroupID,array("AdminUserAction"));

            // super administrator moze sve da radi nema potrebe za proverom
            if($adminusergroup->AdminUserGroupID == 1) return true;

            if(count($adminusergroup)>0)
            {
				foreach ($adminusergroup->AdminUserAction as $action)
				{
					if($action->ActionCode == $action_code) return true;
				}
            }

			return false;
		}

		function logAdminData($adminuserid)
		{
			$AdminUserLogHistory = $this->ObjectFactory->createObject("AdminUserLogHistory", -1);
			$AdminUserLogHistory->AdminUser->setAdminUserID($adminuserid);
			$AdminUserLogHistory->setLastLogDate(time());
			$AdminUserLogHistory->setLastLogIP(getenv("REMOTE_ADDR"));

			$this->DBBR->kreirajSlog($AdminUserLogHistory);
		}

		function login()
	    {
	    	$values = $this->getLoginForm();
	        $username = (isset($values['user_name']) ? $values['user_name'] : false);
	        $password = (isset($values['user_password']) ? $values['user_password'] : false);
	        $subsiteid = (isset($values['subsiteid']) ? $values['subsiteid'] : false);
	        $autoLogin = (isset($values['user_autologin']) ? $values['user_autologin'] : 0);

	        if (($username != false) && ($password != false))
	        {
	        	$password = md5($password);

	        	$this->ObjectFactory->ResetFilters();
	            $this->ObjectFactory->AddFilter("password=".$this->quote_smart($password));
	            $this->ObjectFactory->AddFilter("username=".$this->quote_smart($username));
	            $adminUsers = $this->ObjectFactory->createObjects("AdminUser",array("SfStatus"));
				$this->ObjectFactory->ResetFilters();

	            if (count($adminUsers) == 1)
	            {
	            	$this->AuthUser = $adminUsers[0];

	                $status = $this->AuthUser->SfStatus->StatusID;
	                if ($status == STATUS_ADMINUSER_AKTIVAN)
	                {
	                    // proveravamo da li je super administrator ako jeste logujemo ga, a ako nije
	                    // moramo da vidimo da li je odgovarajuci subsite

	                    if($this->AuthUser->AdminUserGroup->AdminUserGroupID == 1)
	                    {
	                    	$this->_set_logindata($this->AuthUser->AdminUserID, $this->AuthUser->FullName, $subsiteid);
		                    $this->logAdminData($this->AuthUser->AdminUserID);
		                    return true;
	                    }
	                    else
	                    {
	                    	// u slucaju da se ne radi o super administratoru moramo videti da li ima prava da se
	                    	// loguje na odredjeni subsite

	                    	if($this->AuthUser->SubSite->SubSiteID == $subsiteid)
	                    	{
	                    		$this->_set_logindata($this->AuthUser->AdminUserID, $this->AuthUser->FullName, $subsiteid);
		                    	$this->logAdminData($this->AuthUser->AdminUserID);
	                    		return true;
	                    	}


	                    	// ako je subsite postavljen na -1 to znaci da taj user ima pravo da vidi sve subsiteove!
	                    	if($this->AuthUser->SubSite->SubSiteID == -1 )
	                    	{
	                    		$this->_set_logindata($this->AuthUser->AdminUserID, $this->AuthUser->FullName, $subsiteid);
								$this->logAdminData($this->AuthUser->AdminUserID);
	                    		return true;
	                    	}
	                    }
	                }
	            }
	        }

	        return false;
		}

		function _set_logindata($adminuser_id, $fullname = null, $subsiteid)
	    {
			$this->_set_user($adminuser_id, $subsiteid, $fullname);
	    }

	    function _unset_user()
	    {
			$newdata = array(
						'adminuserid'  => '',
						'logged_in' => FALSE,
						'subsiteid' => '',
						'ad_cookie_language' => $_SESSION["ad_cookie_language"]
	               );

	        $this->unset_userdata($newdata);
			setcookie("ad_cookie_language","", mktime(12,0,0,1, 1, 1990),"/");
	    }

	    function unset_userdata($newdata)
	    {
			$_SESSION["adminuserid"] = $newdata["adminuserid"];
			$_SESSION["logged_in"] = $newdata["logged_in"];
			$_SESSION["subsiteid"] = $newdata["subsiteid"];
			$_SESSION["ad_cookie_language"] = $newdata["ad_cookie_language"];

			$_SESSION['KCFINDER'] = array();
	    }

	    function _set_user($adminuser_id, $subsiteid, $fullname)
	    {
			$subsite = $this->ObjectFactory->createObject("SubSite",$subsiteid);

	    	$newdata = array( 'adminuserid'  => $adminuser_id, 'logged_in' => TRUE, 'subsiteid' => $subsiteid,'ad_cookie_language' => $subsite->Language ,'adminfullname' => $fullname);
	    	$this->set_userdata($newdata);
	    }

	    function set_userdata($newdata)
	    {
			$_SESSION["adminuserid"] = $newdata["adminuserid"];
			$_SESSION["logged_in"] = $newdata["logged_in"];
			$_SESSION["subsiteid"] = $newdata["subsiteid"];
			$_SESSION["adminfullname"] = $newdata["adminfullname"];
			$_SESSION["ad_cookie_language"] = $newdata["ad_cookie_language"];

			// SPECTIAL SETTINGS FOR KC FINDER
			$_SESSION['KCFINDER'] = array();
			$_SESSION['KCFINDER']['UKLJUCEN'] = "DA";
			$_SESSION['RESPONSIVE']['UKLJUCEN'] = "DA";
	    }

	    function checkLogin()
	    {
	    	if($this->userdata('logged_in') != TRUE)
	    	{
	    		redirect('/frontpage/','location');
	    	}

	    	return true;
	    }

	    function getAdminUserGroup()
	    {
			$adminUser = $this->ObjectFactory->createObject("AdminUser", $this->getAdminUserId());
			$adminusergroup = $this->ObjectFactory->createObject("AdminUserGroup",$adminUser->AdminUserGroup->AdminUserGroupID);
	    	return $adminusergroup->Title;
	    }

	    function getAdminUserId()
	    {
	    	return $_SESSION["adminuserid"];
	    }

		function getAdminFullName()
	    {
	    	return $_SESSION["adminfullname"];
	    }

	    function getSubSiteLanguage()
	    {
	    	return $subsite->Language;
	    }
	    function isLogged()
	    {
	    	if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == TRUE)
	    	{
	    		return true;
	    	}
	    	return false;
	    }

	    function logout()
	    {
	    	$this->_unset_user();
	    	header("Location: index.php");
	    }

	    function email_exists($email)
	    {
	    	$this->ObjectFactory->ResetFilters();
	    	$this->ObjectFactory->AddFilter("email=".$this->quote_smart($email));
			$adminUsers = $this->ObjectFactory->createObjects("AdminUser");
			if(count($adminUsers)>0)
			{
				return true;
			}

			return false;
	    }

   	    function username_exists($username)
	    {
	    	$this->ObjectFactory->ResetFilters();
	    	$this->ObjectFactory->AddFilter("username=".$this->quote_smart($username));
			$adminUsers = $this->ObjectFactory->createObjects("AdminUser");

			if(count($adminUsers)>0)
			{
				return true;
			}

			return false;
	    }

		function getLoginForm()
	    {
	        $values = array();
	    	$values['user_name'] = $_REQUEST['user_name'];
	        $values['user_password'] = $_REQUEST['user_password'];
	        $values['subsiteid'] = $this->quote_smart($_REQUEST['subsiteid']);

	        return $values;
	    }

	    function quote_smart($value)
		{
			/*if (get_magic_quotes_gpc())
			{
				$value = stripslashes($value);
			}*/
			if (!is_numeric($value))
			{
				$db = new ezSQL_mysql;
				//$value = "'" . mysql_real_escape_string($value) . "'";
				$value = "'" . mysqli_real_escape_string($db->links,$value) . "'";
			}
			return $value;
		}
	}
?>
