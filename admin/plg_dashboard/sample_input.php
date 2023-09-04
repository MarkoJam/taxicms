<?php 

	$_ADMINPAGES = true;
	include_once("../../config.php");
	global $auth;
		
		$plugin_array=array("general","proizvod","news","persons","project","event");
		$access_array=array("w","nl","in","fb");


		$sql="SELECT `userid` FROM `user` WHERE 1";
		$result_set = $DBBR->con->get_results($sql);
		$uid_array=array();
		foreach ($result_set as $result) {
			$uid_array[]=$result->userid;	
		}			
		
		$sql="SELECT `newsletter_id` FROM `newsletter` WHERE 1";
		$result_set = $DBBR->con->get_results($sql);
		$nlid_array=array();
		foreach ($result_set as $result) {
			$nlid_array[]=$result->newsletter_id;	
		}

		$sql="SELECT `proizvodid` FROM `pr_proizvod` WHERE 1";
		$result_set = $DBBR->con->get_results($sql);
		$pr_id_array=array();
		foreach ($result_set as $result) {
			$pr_id_array[]=$result->proizvodid;	
		}	
		
		$sql="SELECT `news_id` FROM `news` WHERE 1";
		$result_set = $DBBR->con->get_results($sql);
		$news_id_array=array();
		foreach ($result_set as $result) {
			$news_id_array[]=$result->news_id;	
		}	
		
		$sql="SELECT `persons_id` FROM `persons` WHERE 1";
		$result_set = $DBBR->con->get_results($sql);
		$persons_id_array=array();
		foreach ($result_set as $result) {
			$persons_id_array[]=$result->persons_id;	
		}

		$sql="SELECT `project_id` FROM `project` WHERE 1";
		$result_set = $DBBR->con->get_results($sql);
		$project_id_array=array();
		foreach ($result_set as $result) {
			$project_id_array[]=$result->project_id;	
		}
		
		$sql="SELECT `event_id` FROM `event` WHERE 1";
		$result_set = $DBBR->con->get_results($sql);
		$event_id_array=array();
		foreach ($result_set as $result) {
			$event_id_array[]=$result->event_id;	
		}
		

	for ($x = 1; $x <= 5000; $x++) {
		
		shuffle($plugin_array);
		shuffle($access_array);
		shuffle($uid_array);
		shuffle($nlid_array);
		shuffle($pr_id_array);		
		shuffle($news_id_array);
		shuffle($persons_id_array);
		shuffle($project_id_array);
		shuffle($event_id_array);
		
		$uid=$uid_array[array_rand($uid_array)];		
		$plugin=$plugin_array[array_rand($plugin_array)];
		if ($plugin=='general') {
			$id=0;
			$nlid=0;
			$access='';
		}
		else {
			$access=$access_array[array_rand($access_array)];
			if ($access=='nl') $nlid=$nlid_array[array_rand($nlid_array)];
			else $nlid=0;
			switch ($plugin) {
				case 'proizvod':
				$id=$pr_id_array[array_rand($pr_id_array)];
				break;				
				case 'news':
				$id=$news_id_array[array_rand($news_id_array)];
				break;
				case 'persons':
				$id=$persons_id_array[array_rand($persons_id_array)];
				break;
				case 'project':
				$id=$project_id_array[array_rand($project_id_array)];
				break;
				case 'event':
				$id=$event_id_array[array_rand($event_id_array)];
				break;			
			}	
		}
		
		$vreme=time()-365*24*3600+rand(0, (365*24*3600));
			$sql="INSERT INTO `visits`(`plugin`,`resource_id`,`access`,`user_id`,`newsletter_id`, `time` ) VALUES ('".$plugin."','".$id."','".$access."','".$uid."','".$nlid."','".$vreme."')";
			$results = $DBBR->con->query($sql);
	}	
		
	
?>