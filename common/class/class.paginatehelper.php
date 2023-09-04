<?php


/*
 * Class uses SmartyPaginatation but hides all complicated stuff
 * 
 */
class PaginateHelper
{
	private $paginateLimit;
	private $paginateTotal;
	
	function __construct($paginate_url)
	{
		//SmartyPaginate::disconnect();

		SmartyPaginate::connect();
		SmartyPaginate::setUrlVar("offset");
		
		SmartyPaginate::setTranslation
		(
			getTranslation("GLOBAL_PREV_TEXT"),
			getTranslation("GLOBAL_NEXT_TEXT"),
			getTranslation("GLOBAL_FIRST_TEXT"),
			getTranslation("GLOBAL_LAST_TEXT")
		);
		
		SmartyPaginate::setUrl($paginate_url);	
	}	
	
	function GetPaginateLimit()
	{
		return $this->paginateLimit;
	}
	
	function GetPaginateOffset()
	{
		return SmartyPaginate::getCurrentIndex();
	}
	
	function setLimit($value)
	{
		$this->paginateLimit = $value;
		SmartyPaginate::setLimit($value);
	}
	function setTotal($value)
	{
		SmartyPaginate::setTotal($value);
	}
	
	function toArray()
	{
		return SmartyPaginate::toArray("paginate");
	}
}

?>