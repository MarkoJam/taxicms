<?php 

class FilterBox
{
	private $filters;
	protected $smarty;
	
	function __construct($smarty)
	{
		$this->filters = array();
		$this->smarty = $smarty;
	}
	
	function Reset()
	{
		$this->filters = array();
	}
	
	function AddFilter($field, $value, $operator = "=", $logic_operator = "AND")
	{
		$filterItem = new FilterItem($field, $value, $operator, $logic_operator);
		
		$this->filters[] = $filterItem;
	}		
	
	function HasFilters()
	{
		if(count($this->filters) > 0) return true;
		else return false;
	}
	
	function GetFilters()
	{
		$filterCount = count($this->filters);
		if( $filterCount > 0)
		{
			$strFilter = "( 1 = 1 AND ";
			
			$cnt = 1;
			foreach ($this->filters as $filter)
			{
				if($filterCount == $cnt)
					$strFilter .= $filter->GetFilter(true);
				else 
					$strFilter .= $filter->GetFilter(false);
				
				$cnt++;
			}

			$strFilter .=  " )";
		}
		else 
		{
			$strFilter = " AND 1 = 1 ";
		}
		
		return $strFilter;
	}
}

class FilterItem
{
	public $Field;
	public $Value;
	public $Operator;
	public $LogicOperator;
	
	function __construct($field, $value, $operator, $logic_operator)
	{
		$this->Field = $field;
		$this->Value = $value;
		$this->Operator = $operator;
		$this->LogicOperator = $logic_operator;
	}
	
	function GetFilter($isLast = false)
	{
		if($isLast)
		{
			return $this->Field . " " . $this->Operator . " " .$this->Value;
		}
		else 
		{
			return $this->Field . " " . $this->Operator . " " .$this->Value . " " . $this->LogicOperator . " ";
		}
			
	}
}

class LoginFilterBox extends FilterBox
{
    function Init()
    {
        $addFilter = "";
        $fieldName = "";
        $fieldValue = "";

        if(isset($_REQUEST["resetFilter"]))
        {
            unset($_SESSION["login_filter_field"]);
            unset($_SESSION["login_filter_value"]);
        }

        if(isset($_REQUEST["submitFilter"]))
        {
            $fieldName = $_SESSION["login_filter_field"] = $_REQUEST["filter_field"];
            $fieldValue = $_SESSION["login_filter_value"] = $_REQUEST["filter_value"];
        }
        else if (isset($_SESSION["login_filter_field"]) && isset($_SESSION["login_filter_field"]))
        {
            $fieldName = $_SESSION["login_filter_field"];
            $fieldValue = $_SESSION["login_filter_value"];
        }
        else
        {
            return;
        }

        $searchWords = explode(" ", $fieldValue);

        switch($fieldName)
        {
            case "place":
                foreach($searchWords as $searchWord)
                {
                    $this->AddFilter("place", "'%".$searchWord."%'", "LIKE", "AND");
                }
                break;
            case "namesurname":
                $query = "";
                foreach($searchWords as $searchWord)
                {
                    $query .= "(name LIKE '%".$searchWord."%' OR  surname LIKE '%".$searchWord."%') AND ";
                }
                $query = substr($query, 0, strlen($query)-4);

                $this->AddCustomFilter($query);

                break;
            case "firm":
                foreach($searchWords as $searchWord)
                {
                    $this->AddFilter("firm", "'%".$searchWord."%'", "LIKE", "AND");
                }

                break;
            default: break;
        }

        $this->smarty->assign("login_filter_value", $fieldValue);
    }
}
?>