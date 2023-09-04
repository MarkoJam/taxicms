<?
	/* CMS Studio 3.0 insert_pre.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_CREATE"))
	{
		$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",-1);
		$maxorder = $DBBR->vratiMaxPoUslovu($tipproizvoda);
		$tipproizvoda->Order = $maxorder;
		$_REQUEST["tipproizvodaid"]=$DBBR->kreirajSlog($tipproizvoda);

		$karakt = $ObjectFactory->createObject("PrKarakteristika",-1);
		$karakt->setKarakteristikaID(1);
		$karakt->setTipProizvodaID($tipproizvoda->getTipProizvodaID());
		$karakt->setOrder(0);

		$DBBR->kreirajSlog($karakt);
		$iid=$karakt->getKarakteristikaID();

		$query="UPDATE `pr_karakteristika` SET `karakteristikaid`=1 WHERE `karakteristikaid` = " . $iid;
		$results = $DBBR->con->get_results($query);
	}

?>
