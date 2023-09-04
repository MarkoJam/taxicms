<?php 

	class CommonFilter
	{
		/**
		 * Array for filters limits sorts etc.
		 *
		 * @var assocciate array (key => value)
		 * key is field
		 */
		private $filters;
		
		/**
		 * Limit for building DB query
		 *
		 * @var int
		 */
		private $limit;
		
		/**
		 * Offset for building DB query
		 *
		 * @var int
		 */
		
		private $offset;
		
		/**
		 * Array with sort fields
		 *
		 * @var 
		 */
		private $sort;
			
		function __construct()
		{
			$this->reset();
		}
		
		/**
		 * Resets filters array as new
		 *
		 * @access public
		 * @return void
		 */
		function Reset()
		{
			$this->filters = array();
			$this->limit = 1000000; // return all
			$this->offset = 0; // start from first
			$this->sort = array();
		}
		
		/**
		 * Add new CommonFilter item
		 * 
		 * @param string $field
		 * @param variant $field_value
		 */
		function AddFilter($field, $field_value, $operator = "=")
		{
			// if filter exists
			if(!$this->FilterHasKey($field))
			{
				// filter does not exists we are adding new
				$filter = new Filter($field, $field_value, $operator);
				$this->filters[] = $filter;
			}
			else
			{
				$filter = $this->GetFilterByKey($field);
				$filter->SetFieldValue($field_value);
				$filter->SetFieldOperator($operator);
			}
		}
		
		function RemoveFilter($field)
		{
			$tmpFilter = array();
			foreach ($this->filters as $filter) 
			{
				if(!($filter->GetFieldName() == $field))
				{
					$tmpFilter[] = $filter;
				}
			}
			
			$this->filters = $tmpFilter;
		}
		
		function GetFilters()
		{
			$filter_prepared = array();
			foreach ($this->filters as $filter)
			{
				$filter_prepared[] = $filter->GetPreparedFilter();
			}
			
			return $filter_prepared;
		}
		
		/**
		 * Checks if filter array has field with 
		 * coresponding name
		 *
		 * @param string $field
		 * @return bool
		 */
		function FilterHasKey($field)
		{
			foreach ($this->filters as $filter)
			{
				if($filter->GetFieldName() == $field)
				{
					return true;
				}
			}
			
			return false;
		}
		
		/**
		 * Gets filter value by key name - field name
		 *
		 * @param string $field
		 * @return string
		 */
		function GetFilterByKey($field)
		{
			foreach ($this->filters as $filter)
			{
				if($filter->GetFieldName() == $field)
				{
					return $filter;
				}
			}
			
			return null;
		}
		
		/**
		 * Gets filter value by key name - field name
		 *
		 * @param string $field
		 * @return string
		 */
		function GetFilterValueByKey($field)
		{
			foreach ($this->filters as $filter)
			{
				if($filter->GetFieldName() == $field)
				{
					return $filter->GetFieldValue();
				}
			}
			
			return null;
		}
		
		function GetPreparedFilters()
		{
			$filter_prepared = "";
			foreach ($this->filters as $filter)
			{
				$filter_prepared .= " AND " .$filter->GetPreparedFilter();
			}
			
			return $filter_prepared;
		}

		/**
		 * Assign limit for query
		 *
		 * @param int $limit
		 */
		function AddLimit($limit)
		{
			$this->limit = $limit;
		}
		
		function GetLimit()
		{
			return $this->limit;
		}
		
		/**
		 * Assign offset for query
		 *
		 * @param int $offset
		 */
		function AddOffset($offset)
		{
			$this->offset = $offset;
		}
		
		function GetOffset()
		{
			return $this->offset;
		}
		
		/**
		 * Add new Sort item
		 *
		 * @param string $field
		 * @param variant $field_value
		 */
		function AddSort($field, $field_value)
		{
			$this->sort[] = array($field => $field_value);
		}
	}
	
	class Filter
	{
		private $fieldName;
		private $fieldValue;
		private $fieldOperator;
		
		function __construct($fieldname, $fieldvalue, $fieldoperator = "=")
		{
			$this->fieldName = $fieldname;
			$this->fieldValue = $fieldvalue;
			$this->fieldOperator = $fieldoperator;
		}
		
		function GetPreparedFilter()
		{
			return $this->fieldName . " " . $this->fieldOperator . " " . $this->fieldValue;
		}
		
		function SetFieldName($val)
		{
			$this->fieldName = $val;
		}
		
		function SetFieldValue($val)
		{
			$this->fieldValue = $val;
		}
		
		function SetFieldOperator($val)
		{
			$this->fieldOperator = $val;
		}
		
		function GetFieldName()
		{
			return $this->fieldName;
		}
		
		function GetFieldValue()
		{
			return $this->fieldValue;
		}
		
		function GetFieldOperator()
		{
			return $this->fieldOperator;
		}
		
	}

?>