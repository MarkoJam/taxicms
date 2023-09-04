<?php 
	
	include_once("plugins/pagePlugin.php");
	include_once("common/class/validation.class.php");
	
	class commentPlugin extends PagePlugin
	{
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
				
		function showDefault()
		{
			if (isset($_REQUEST['plugin'])) {
				$this->SetPluginLanguage("comment");
				if ($_REQUEST['plugin']=='katalogproizvoda') $plg='proizvod';
				else $plg=$_REQUEST['plugin'];
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("code = '".$plg."'"  );			
				$resources= $this->ObjectFactory->createObjects("SfResource");
				$this->ObjectFactory->ResetFilters();					
				$rid=$resources[0]->getCode()."id";

				// prikaz komentara
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("resource_id = ".$resources[0]->getID()." AND res_id = ".$_REQUEST[$rid]);		
				$this->ObjectFactory->AddSort('comment_order,create_date');			
				$comment= $this->ObjectFactory->createObjects('Comment');
				$this->ObjectFactory->ResetFilters();
				$this->smarty->assign("count_comments",count($comment));
				$comment_all=array();
				foreach ($comment as $com)
				{
					$com->setCreateDate(date("d.m.Y", $com->getCreateDate()));
					$comment_all[]=$com->toArray();
				}
				$this->smarty->assign("comments",$comment_all);
				
				// priprema za novi komentar		
				if(isset($_SESSION["loged"]) && $_SESSION['loged'] == "Yes") {
					$user= $this->ObjectFactory->createObject("User",$_SESSION["logeduserid"]);
					$this->smarty->assign("fullname",($user->getName()." ".$user->getSurName()));
					$this->smarty->assign("city",$user->getPlace());
					$this->smarty->assign("email",$user->getEmail());				
					
					$this->smarty->assign("login",true);
				}
				else $this->smarty->assign("login",false);						
				$rr="resurs".$resources[0]->getID()."res".$_REQUEST[$rid];
				if (!$_COOKIE[$rr]) 	{	
					$this->smarty->assign("new_comment",true);				
					$this->smarty->assign("resourceid",$resources[0]->getID());
					$this->smarty->assign("resid",$_REQUEST[$rid]);
					$this->smarty->assign("createdate",time());
					if (CAPTCHA_KEY_2 != '') $this->smarty->assign("dkey",CAPTCHA_KEY_2);
					//else $this->smarty->assign("dkey",'xxxx'); //za probu na local-u
					
				}	
				$this->smarty->assign("resource_link",$_SERVER[REQUEST_URI]);
				//$this->SmartyPluginBlock->setData($smartyData);
				$this->SmartyPluginBlock->setPosition($this->Position);
				$this->SmartyPluginBlock->setName("plg_comment_default");
				//$this->smarty->assign("plg_comment_default","true");
				return $this->SmartyPluginBlock->toArray();		
			}		
		}	
		
		function showDetails()
		{
			
		}
		
		function processAddNewCommentDetails()
		{
			// registration mode
			//$this->SetPluginLanguage("login");
			
			$this->smarty->assign("backUrl", $_SERVER['QUERY_STRING']);
	
			$validation = new Validation();

			$rules['fullname']		= "trim|required";
			$rules['title']			= "trim|required";
			$rules['message']		= "trim|required";	
			$rules['email']			= "trim|required|valid_email";
	
			$validation->set_rules($rules);
	
			$fields['fullname']		= 'Ime i prezime';
			$fields['city']			= 'Grad';
			$fields['state']		= 'Država';
			$fields['title']		= 'Naslov komentara';
			$fields['message']		= 'Komentar';
			$fields['email']		= 'Email adresa';
			
			$validation->set_fields($fields);
			
			$is_Valid = true;
			
			if($validation->run() == FALSE) $is_Valid = false;
			
			if(!$is_Valid)
			{
				foreach ($fields as $field => $value)
				{
					if($validation->$field != "")
					{
						$this->smarty->assign($field, $validation->$field);
					}
						
					$error_field = $field.'_error';
					$error_message_field = $field.'_error_message';
					
					if($validation->$error_field != "")
					{
						$this->smarty->assign($error_field , "error");
						$this->smarty->assign($error_message_field, "true");
					}
				}
			}
			else
			{
				// kreiranje novog komentara u bazi
				
				$comment = $this->ObjectFactory->createObject("Comment",-1);
				
				$comment->FullName = $validation->fullname;
				$comment->City = $validation->city;
				$comment->State = $validation->state;
				$comment->Title = $validation->title;
				$comment->Message = $validation->message;
				$comment->Email = $validation->email;
				$comment->CreateDate = time();
				
		        $DBBR = DatabaseBroker::getInstance();
				$DBBR->kreirajSlog($comment);
				
				// Obavestenje administratoru sistema
				
				$phpmail = new PHPMailer();
					
				switch($this->CMSSetting->getSettingByID(COMMENT_SENDER_TYPE))
				{
					case SENDER_TYPE_SMTP:
						$phpmail->IsSMTP();
						$phpmail->Host = $this->CMSSetting->getSettingByID(COMMENT_HOST_NAME);
						break;
					case SENDER_TYPE_MAIL:
						$phpmail->IsMail();
						break;
					default:
						break;
				}
				
				$phpmail->From = $this->CMSSetting->getSettingByID(COMMENT_MAIL_EMAIL);
				$phpmail->FromName = $this->CMSSetting->getSettingByID(COMMENT_MAIL_NAME);
				$phpmail->IsHTML(false);
					
				$phpmail->AddAddress($this->CMSSetting->getSettingByID(COMMENT_MAIL));
				$phpmail->Subject = $this->CMSSetting->getSettingByID(COMMENT_MAIL_SUBJECT);
		
				$body_text = "Ostavljen je novi komentar na sajtu molimo odobrite ga u administraciji CMS-a. Hvala.";
	
				foreach ($fields as $field => $value)
				{
					$body_text .= ucfirst($fields[$field]) .": " .$validation->$field ."\r\n";
				}
				
				$phpmail->Body = $body_text;
				$phpmail->WordWrap = 50;
				$phpmail->Send();
				
				unset($phpmail);
				
				$this->smarty->assign("succesfull_addnewcomment","true");
			}			
		}
		
	}
?>