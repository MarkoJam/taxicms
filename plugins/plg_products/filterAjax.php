<?php 
	include_once("../../config.php");
	
	
	if (isset($_REQUEST['cf'])) {
		unset ($_SESSION['filter_products']);
		unset ($_SESSION['selected_products']);	
		unset ($_SESSION['fields']);	
		unset ($_SESSION['count_products']);		
		exit ();
	}	
	
	$DatabaseBroker = DatabaseBroker::getInstance();
	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();
		
	
	$gpid = $_REQUEST["gpid"];
	if (isset($_SESSION['gpid']) && $_SESSION['gpid']!=$gpid) {
		unset ($_SESSION['filter_products']);
		unset ($_SESSION['selected_products']);	
		unset ($_SESSION['fields']);	
		unset ($_SESSION['count_products']);				
	}
	$_SESSION['gpid']=$gpid;
	$p_ids=$_REQUEST["p_ids"];
	$change_field=$_REQUEST["change_field"];
	$field_content=$_REQUEST["field_content"];
	
	$change_field_arr=explode('-',$change_field);
	$field=$change_field_arr[0];
	$oper=$change_field_arr[1];
	
	$field_arr=explode('X',$field);
	
	$table=$field_arr[0];
	$id=$field_arr[1];

	
	if ($oper=='select') $relation="=";
	if ($oper=='from') $relation=">=";
	if ($oper=='to') $relation="<=";
	if ($oper=='search') {
		$relation=" LIKE ";
		$field_content="'%".$field_content."%'";
	}	
	if ($table == 'k') $class="PrKarakteristikaProizvoda";	
	else $class="PrProizvod";
	if (($oper=='select' && $field_content==0) 
		|| ($oper=='search' && $field_content=="'%%'")
		|| ($oper=='from' && $field_content==0)
		|| ($oper=='to' && $field_content==0)		
	) {
		$filter="proizvodid IN (".$p_ids.") "; 
		$class="PrProizvod";
	}	
	else {	
		if ($table == 'k') {
			if ($oper!='select')
				$filter="proizvodid IN (".$p_ids.") AND karakteristikaid = ".$id." AND vrednost".$relation.$field_content;
			else 
				$filter="proizvodid IN (".$p_ids.") AND karakteristikaid = ".$id." AND karakteristika_element_id".$relation.$field_content;	
		}
		else {	
			$filter="proizvodid IN (".$p_ids.") AND ".$field.$relation.$field_content;
		}
	}
	
	$field_content=str_replace("%","",$field_content);
	$field_content=str_replace("'","",$field_content);
	$p_array[]=array();
	$ObjectFactory->Reset();
	$ObjectFactory->AddFilter($filter);		
	$proizvodi = $ObjectFactory->createObjects($class);
	$ObjectFactory->Reset();
	unset ($_SESSION['filter_products'][$change_field]);
	$p_array=array();
	if(count($proizvodi) > 0)
	{
		foreach($proizvodi as $p)
		{
			$p_array[]=$p->getProizvodID();
		}
	}
	$_SESSION['filter_products'][$change_field]=$p_array;
	$products=explode(',',$p_ids);
	foreach($_SESSION['filter_products'] as $fp)
	{
		foreach ($fp as $p)
		{
			if (in_array("$p",$products)) $x[]=$p;
		}	
		$products=$x;
		$x=array();		
	}	
	if(count($products) > 0) {
		foreach($products as $p)
		{
			$pr_ids .=$p. ",";
		}
	}	
	$pr_ids = substr($pr_ids,0,strlen($pr_ids)-1);	
	$_SESSION['selected_products']=$pr_ids;
	$_SESSION['count_products']=count($products);
	$change_field=str_replace('-','',$change_field);
	$_SESSION['fields'][$change_field]=$field_content;
	echo count($products);
	
	
