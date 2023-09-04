<?php
class Date
{  /**
    * The array with the translated months and days 
    *
    * @var    array    $transDate
    * @access    private
    */
    var $transDate;
    
   /**
    * The offset of the servers timezone
    * 
    * When negative the timezone will be lowered, positive it will be
    * increased
    *
    * @var    int    $offset
    * @access    private
    */
    var $offset;
    
   /**
    * The current timestamp
    *
    * @var    int    $time
    * @access    private
    */
    var $time;
    
   /**
    * Constructor
    * 
    * Initializes the object variables 
    * 
    * @param array $transDate the array with the translated days and months
    * @param int $offset the offset time from the server, default = 0
    * @see transDate, offset
    * @author Ilja <ilj at quicknet dot nl>
    * @copyright Ilja <ilj at quicknet dot nl>
    * @version     1.0
    */
    function __construct($transDate, $time, $offset=0)
    {   
    	$this->time = $time;
    	$this->offset = $offset;
        $this->transDate = $transDate;
    }
    
   /**
    * Converts the date/time to the specified language and timezone
    * 
    * @param string $format The date/time format
     * @return string $thisDate the converted date/time
    * @see time, transDate
    * @author Ilja <ilj at quicknet dot nl>
    * @copyright Ilja <ilj at quicknet dot nl>
    * @version     1.0
    */
    function convertDate($format)
    {   
    	$this->time = time()+($this->offset*3600);
        $thisDate = date($format, $this->time);
        if(!empty($this->transDate))
            $thisDate = strtr($thisDate, $this->transDate);
        return $thisDate;
    }
    
    function printDate($format)
    {
        $thisDate = date($format, $this->time);
        if(!empty($this->transDate))
            $thisDate = strtr($thisDate, $this->transDate);
        return $thisDate;
    }
}

?>