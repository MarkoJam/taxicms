<?php 

	include_once('../../../config.php');

	$ObjectFactory = ObjectFactory::getInstance();
	$DatabaseBroker = DatabaseBroker::getInstance();

	$ObjectFactory->Reset();
	$user= $ObjectFactory->createObject("User", $_REQUEST["userid"]);
	$ObjectFactory->Reset();
	$jsonUser= json_encode($user->toArray());		
	echo $jsonUser;
	
	exit();

?>