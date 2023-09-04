<?
	if($this->CMSSetting->getSettingByID(ORDER_MAIL_ACTIVE) == SETTING_TYPE_ON)
	{
		// slanje maila da je narudzbenica kreirana
		$phpmail = new PHPMailer();

		switch($this->CMSSetting->getSettingByID(ORDER_SENDER_TYPE))
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

		$phpmail->From = $this->CMSSetting->getSettingByID(ORDER_MAIL_EMAIL);
		$phpmail->FromName = $this->CMSSetting->getSettingByID(ORDER_MAIL_NAME);
		$phpmail->IsHTML(true);
		$phpmail->AddAddress($this->CMSSetting->getSettingByID(ORDER_MAIL), "Order confirmation");
		$phpmail->Subject = $this->CMSSetting->getSettingByID(ORDER_MAIL_SUBJECT) . " No. " . $order->getOrderID();
		$this->smarty->assign("printorder",$order->getPrintOrder());
		ob_start();
		$this->smarty->display("mail/header.tpl");
		$this->smarty->display("mail/mail_adm.tpl");
		$this->smarty->display("mail/footer.tpl");
		$message = ob_get_contents();
		ob_end_clean();

		$phpmail->Body = $message;
		$phpmail->Send();
		$message;
		unset($phpmail);
	}

	// proveriti da li je aktivirano slanje maila korisniku nakon narudzbe
	if($this->CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_ACTIVE) == SETTING_TYPE_ON)
	{
		// slanje maila da je narudzbenica kreirana
		$phpmail = new PHPMailer();

		switch($this->CMSSetting->getSettingByID(ORDER_SENDER_TYPE))
		{
			case SENDER_TYPE_SMTP:
				$phpmail->IsSMTP();
				$phpmail->Host = $this->CMSSetting->getSettingByID(ORDER_TO_USER_HOST_NAME);
				break;
			case SENDER_TYPE_MAIL:
				$phpmail->IsMail();
				break;
			default:
				break;
		}

		$phpmail->From = $this->CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_EMAIL);
		$phpmail->FromName = $this->CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_NAME);
		$phpmail->IsHTML(true);

		$phpmail->AddAddress($order->User->getEmail());

		$phpmail->Subject = "Blue molds - Order confirmation";

		$this->smarty->assign("printorder",$order->getPrintOrder());

		ob_start();
		$this->smarty->display("mail/header.tpl");
		$this->smarty->display("mail/mail.tpl");
		$this->smarty->display("mail/footer.tpl");
		$message = ob_get_contents();
		ob_end_clean();

		$phpmail->Body = $message;
		$phpmail->Send();
		unset($phpmail);
	}
?>
