<?
	class Maintenance
	{
		var $DBBR;
			
		function __construct()
		{
			$this->DBBR = DatabaseBroker::getInstance();
		}
		
		function RunMaintenance()
		{
			$pfact = new productFactory($this->DBBR);
			$newdate = time()- (2 * 24 * 60 * 60);
			$pfact->AddFilter("`datum` < ". $newdate);
			$pfact->AddFilter("`status` = 'aktivan'");
			$proizvodi_stariji = $pfact->createObjects("proizvodi");
			$proizid_arr = array();
			if(count($proizvodi_stariji)>0)
			{
				foreach ($proizvodi_stariji as $proiz)
				{
					foreach ($proiz->Kategorije as $kateg)
					{
						if($kateg->KategorijaID == 51)
						{
							$proizid_arr[] = $proiz->ProizvodID;
							continue;			
						}
					}
				}
			}
			$query_delete = "proizvodid IN (";
			
			if(count($proizid_arr)>0)
			{
				foreach ($proizid_arr as $id)
				{
					$query_delete .= $id .",";
				}
			
				$query_delete = substr($query_delete,0,strlen($query_delete)-1);
				$query_delete .=")";
		
				$this->DBBR->con->query("DELETE FROM pr_proizvodkategorija WHERE ". $query_delete);
			}
		}
	}
?>