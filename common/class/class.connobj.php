<?
	class ConnectedObject
	{
		// related objects
		protected $DatabaseBroker;
		//protected $AdminTable;
		protected $ObjectFactory;
		//protected $LanguageArray;



		// default class constructor
		function __construct($ObjectFactory,$DBBR, $labels=null)
		{
			global $lh;
			$this->ObjectFactory = $ObjectFactory;
			$this->DatabaseBroker = $DBBR;
			$this->LanguageArray = $labels;
			$this->LanguageHelper = $lh;
			$this->con_resource = 'con_resource';
			$this->LanguageHelper->ChangeTableName($this->con_resource);
			$this->con_resource_add = 'con_resource_add';
			$this->LanguageHelper->ChangeTableName($this->con_resource_add);
			$this->GenerateThumbs = GenerateThumbs::getInstance();
		}

		function InsertConnectedObject($plugin, $res_obj, $id) {
			$change=false;
			$i=0;
			while (true) {
				$i++;
				$obj=$res_obj."_".(ltrim($i));
				$obj_old=$res_obj."_old_".(ltrim($i));
				$des_old="des_old_".(ltrim($i));
				$des="des_".(ltrim($i));
				$lid_old="lid_old_".(ltrim($i));
				$lid="lng_".(ltrim($i));

				if (isset ($_REQUEST[$obj])) {
					if (isset ($_REQUEST[$obj_old])) {
						if (
							($_REQUEST[$obj_old] != $_REQUEST[$obj])
							||
							($_REQUEST[$des_old] != $_REQUEST[$des])
							||
							($_REQUEST[$lid_old] != $_REQUEST[$lid])
							) $change = true;
					}
					else $change= true;
				}
				else break;

			}
			$num=$res_obj."_num";
			$i=$i-1;
			if (isset($_REQUEST[$num]) && $_REQUEST[$num] != $i) $change= true;
$change=true;
			if ($change) {
				$sql="DELETE FROM `".$this->con_resource."` WHERE `plugin`='".$plugin."' AND `obj`='".$res_obj."' AND `id`=".$id ;

				$this->DatabaseBroker->con->query($sql);
				//$sql="DELETE FROM `".$this->con_resource_add."` WHERE `id`=".$id ;
				//$this->DatabaseBroker->con->query($sql);
				$i=0;
				while (true) {
					$i++;
					$obj=$res_obj."_".(ltrim($i));

					if (isset ($_REQUEST[$obj]) ) {

						$obj2="lng_".(ltrim($i));
						if (isset($_REQUEST[$obj2]))  {
							$lid=$_REQUEST[$obj2];
						}
						else $lid=0;

						$obj3="des_".(ltrim($i));
						if (isset($_REQUEST[$obj3]))  {
							$des=$_REQUEST[$obj3];
							$des=htmlspecialchars($des, ENT_QUOTES);
						}
						else $des='';

						$_REQUEST[$obj]=str_replace('[','',$_REQUEST[$obj]);
						$_REQUEST[$obj]=str_replace(']','',$_REQUEST[$obj]);
						$_REQUEST[$obj]=str_replace('"','',$_REQUEST[$obj]);

						$reqobj_arr=explode(',',$_REQUEST[$obj]);

						foreach ($reqobj_arr as $reqobj) {
							$reqobj=htmlspecialchars($reqobj, ENT_QUOTES);
							$sql2="INSERT INTO `".$this->con_resource."`( `plugin`, `id`, `obj`, `url`,`lid`,`des`) VALUES ('".$plugin."','".$id."','".$res_obj."','".$reqobj."','".$lid."','".$des."')";
							$this->DatabaseBroker->con->query($sql2);
							if ($res_obj=='img') $this->GenerateThumbs->Photo(basename($reqobj),"thumb",dirname($reqobj));
						}

						$sql3="SELECT max(`res_id`) as maks FROM `".$this->con_resource."`";
						$xid=$this->DatabaseBroker->con->get_results($sql3);
						$last_id=$xid[0]->maks;
						if ($res_obj=='web' or $res_obj=='wb2') {
						//website url
							$siteURL = $_REQUEST[$obj];
							$arrContextOptions=array(
							   "ssl"=>array(
								   "verify_peer"=>false,
								   "verify_peer_name"=>false,
							   ),
							);
							//call Google PageSpeed Insights API
							$googlePagespeedData = file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$siteURL&screenshot=true&strategy=desktop&key=AIzaSyAAj-eecbGxYLjivA0KIe37x0MPbHptfXM", false, stream_context_create($arrContextOptions));

							//decode json data
							$googlePagespeedData = json_decode($googlePagespeedData, true);

							//screenshot data
							$screenshot = $googlePagespeedData['lighthouseResult']['audits']['final-screenshot']['details']['data'];
							$screenshot = str_replace(array('_','-'),array('/','+'),$screenshot);
							$imgBase64 = str_replace('data:image/jpeg;base64,', '', $screenshot);
							$imgBase64 = str_replace(' ', '+', $imgBase64);
							//$title = $googlePagespeedData['title'];
							//description
							// snimanje thumba ????
							file_put_contents("../../../files/Thumb/thumb".$last_id.".jpg", base64_decode($imgBase64));

							// snimanje web parametara u dodatnu tabelu


							if (!file_get_contents($siteURL)) {
								echo "<div class='warning'>".$siteURL." Access of web parameters prohibited</div>";
							}
							else {
								$str = file_get_contents($siteURL);
								$code=$this->getCode($str);
								if (isset($code) && $code!="") {
									$title=$this->getTitle($str);
									if (isset($title) && $title!="") {
										$title=iconv($code,"UTF-8",$title);
										$sql3="INSERT INTO `".$this->con_resource_add."`( `res_id`, `id`, `obj`, `content`) VALUES ('".$last_id."','".$id."','title','".$title."')";
										$this->DatabaseBroker->con->query($sql3);
									}
									else echo "<div class='warning'>".$siteURL." No web title</div>";


									$tags = get_meta_tags($siteURL);
									if (isset($tags['description'])) {
										$desc=iconv($code,"UTF-8",$tags['description']);
										$sql3="INSERT INTO `".$this->con_resource_add."`( `res_id`, `id`, `obj`, `content`) VALUES ('".$last_id."','".$id."','description','".$desc."')";
										$this->DatabaseBroker->con->query($sql3);
									}
									else echo "<div class='warning'>".$siteURL." No web description</div>";
								}
								else {
									echo "<div class='warning'>".$siteURL." Access of web parameters prohibited</div>";
								}
							}

						}
					}
					else break;
				}
			}
			return;
		}

		function ModifyConnectedObject($plugin, $obj, $id) {
			$sql="SELECT * FROM `".$this->con_resource."` WHERE `plugin`='".$plugin."' AND `id`=".$id." AND `obj`='".$obj."' ORDER by `res_id`";
			$result_set = $this->DatabaseBroker->con->get_results($sql);
			switch($obj) {
				case 'img':
					$button=" ".getTranslation("PLG_ADD")." / ".getTranslation("PLG_IMAGE");
					break;
				case 'vid':
					$button=" ".getTranslation("PLG_ADD")." / ".getTranslation("PLG_VIDEO");
					break;
				case 'web':
				case 'wb2':
					$button=" ".getTranslation("PLG_ADD")." / ".getTranslation("PLG_WEB");
					break;
				case 'doc':
				case 'dc2':
					$button=" ".getTranslation("PLG_ADD")." / ".getTranslation("PLG_DOCUMENT");
					break;
			}

			$obj_rows="
						<div id='normal_".$obj."'>
						<div id='new_obj' class='btn btn-success'><i class='fa fa-plus-square-o' ></i>".$button."</div>
						<table class='table table-bordered table-stripped'>
						  <thead>
						  <tr>
							<th>".getTranslation("PLG_ORDER")."</th>";
			switch($obj) {
				case 'img':
					$obj_rows.="<th>".getTranslation("PLG_IMAGE")."</th><th>".getTranslation("PLG_URLLINK")."</th>";
					break;
				case 'web':
				case 'wb2':
					$obj_rows.="<th>".getTranslation("PLG_IMAGE")."</th><th>".getTranslation("PLG_NAME")."</th><th>".getTranslation("PLG_URLLINK")."</th>";
					break;
				case 'vid':
					$obj_rows.="<th>".getTranslation("PLG_VIDEOLINK")."</th>";
					break;
				case 'doc':
				case 'dc2':
					$obj_rows.="<th>".getTranslation("PLG_URLLINK")."</th><th>".getTranslation("PLG_DESCRIPTION")."</th><th>".getTranslation("PLG_LANGUAGE")."</th>";
					break;
			}
			$obj_rows.="
                            <th>".getTranslation("PLG_DELETE")."</th>
                           </tr>
                        </thead>
						<tbody id='tabledivbody2'>

							<tr id='obj_div' style='display:none;'>
								<td style='width: 30px;' class='img_move'><img src='".ROOT_WEB."admin/images/fa-arrows.png' /></td>";

			switch($obj) {
				case 'img':
					$obj_rows.="<td class='img_in'>&nbsp</td>";
					break;
				case 'web':
				case 'wb2':
					$obj_rows.="<td class='img_in'>&nbsp</td><td class='title_in'>&nbsp</td>";
					break;
			}
			$obj_rows.="<td><input id='add_obj' name='obj' type='text' value=''  class='form-control main'></td>";

			if ($obj=='doc' || $obj=='dc2') {
				$obj_rows.="<td><input id='add_des' name='des' type='text' value=''  class='form-control description'></td>";
				$sql4="SELECT * FROM `document_language` WHERE 1";
				$result_set4 = $this->DatabaseBroker->con->get_results($sql4);
				$obj_rows.="<td><select id='add_lng' name='lng' class='form-control'>";
				if(count($result_set4)>0) {
					foreach($result_set4 as $result4)
					{
						$obj_rows.="<option value='".$result4->document_language_id."'>".$result4->language."</option>";
					}
				}
				$obj_rows.="</select></td>";
			}
			$obj_rows.="<td style='width: 30px;'><div id='del_obj' class='btn btn-white'><i class='fa fa-trash' ></i></div></td></tr>";
			$i=0;
			foreach ($result_set as $result) {
				$i++;
				$row="
					<tr id='active_row'>
					<td style='width: 30px;' class='img_move'><img src='".ROOT_WEB."admin/images/fa-arrows.png' /></td>";
				switch($obj) {
					case 'img':
						$row.="<td style='width: 120px;'><img src='".ROOT_WEB.$result->url."' /></td>";
						break;
					case 'web':
					case 'wb2':
						$row.="<td ><img src='".ROOT_WEB."files/Thumb/thumb".$result->res_id.".jpg' /></td>";
							$sql2="SELECT * FROM `".$this->con_resource_add."` WHERE `res_id`='".$result->res_id."' AND `obj`='title'";
							$result_set = $this->DatabaseBroker->con->get_results($sql2);
						$row.="<td >".$result_set[0]->content."</td>";
						break;
				}
				$row.="<td><input id='add_obj_".ltrim($i)."' name='obj' type='text' value='".$result->url."'  class='form-control main' disabled></td>";
				$row.="<input id='add_obj_old_".ltrim($i)."' name='".$obj."_old_".ltrim($i)."' type='hidden' value='".$result->url."'>";

				if ($obj=='doc' || $obj=='dc2') {
					$row.="<input id='add_des_old_".ltrim($i)."' name='des_old_".ltrim($i)."' type='hidden' value='".$result->des."'>";
					$row.="<input id='add_lid_old_".ltrim($i)."' name='lid_old_".ltrim($i)."' type='hidden' value='".$result->lid."'>";
					$row.="<td><input id='add_des_".ltrim($i)."' name='des' type='text' value='".$result->des."' class='form-control description'></td>";
					$sql3="SELECT * FROM `document_language` WHERE `document_language_id`=".$result->lid;
					$result_set = $this->DatabaseBroker->con->get_results($sql3);

					if(count($result_set)>0) $lang=$result_set[0]->language;
					else $lang='';

					$row.="<td><select id='add_lng' name='lng' class='form-control'>";
					foreach($result_set4 as $result4)
					{
						if ($result->lid==$result4->document_language_id) $selected="selected";
						else $selected="";
						$row.="<option value='".$result4->document_language_id."' ".$selected.">".$result4->language."</option>";
					}
					$row.="</td>";
				}
				$row.="<td style='width: 30px;'><div id='del_img_".ltrim($i)."' class='btn btn-white'><i class='fa fa-trash'></i></div></td></tr>";
				$obj_rows.=$row;
			}
			$obj_rows.="<input  name='".$obj."_num' type='hidden' value='".$i."'>";

			$obj_rows.="</tbody></table></div>";
			return $obj_rows;
		}


		function ViewConnectedObject($plugin, $obj, $id) {

			//print_r($this->LanguageArray);

				$order='res_id';
				$direct='asc';


			$sql="SELECT * FROM `".$this->con_resource."` WHERE `plugin`='".$plugin."' AND `id`=".$id." AND `obj`='".$obj."' ORDER by ".$order." ".$direct;
			$result_set = $this->DatabaseBroker->con->get_results($sql);

			$obj_rows="";

			$i=0;
			foreach ($result_set as $result) {
					$i++;
				//if ($obj<>'img') $row="<div class='card'>";
				//else $row="";
				$row="";

				switch($obj) {
					case 'img':
								$row.=$ROOT_WEB.$result->url."#";
							break;

					case 'web':
								$row.="<div class='res_web row'><div class='res_image col-md-6'><a href=".$result->url." target='_blank'><img src='".ROOT_WEB."files/Thumb/thumb".$result->res_id.".jpg' /></a></div>";
								//web title
								$sql2="SELECT * FROM `".$this->con_resource_add."` WHERE `res_id`='".$result->res_id."' AND `obj`='title'";
								$result_set = $this->DatabaseBroker->con->get_results($sql2);
								$row.="<div class='col-md-6'><div class='res_title'><h2><a href=".$result->url." target='_blank'>".$result_set[0]->content."</a></h2>";
								//web description
								$sql2a="SELECT * FROM `".$this->con_resource_add."` WHERE `res_id`='".$result->res_id."' AND `obj`='description'";
								$result_set = $this->DatabaseBroker->con->get_results($sql2a);
								$row.="<p>".$result_set[0]->content."</p></div>";
								$row.="</div></div>";
						break;


					case 'vid':
								$row.="<div class='col-md-6 pb-5'>".htmlspecialchars_decode($result->url)."</div>";

						break;

					case 'doc':
					// upit za jezik
						$sql3="SELECT * FROM `document_language` WHERE `document_language_id`=".$result->lid;
						$result_set = $this->DatabaseBroker->con->get_results($sql3);
						if(count($result_set)>0) $lang=$result_set[0]->language;
						else $lang='';
						$file=$result->des;
								$row.="<div class='col-md-6'><p class='icon icon-file-pdf'><a href='".ROOT_WEB.$result->url."' target='_blank'>".$file."</a><span class='size'>(".round(filesize(ROOT_HOME.$result->url)/1024)." Kb)</span></p></div>";
							break;

			}
		//	if ($obj<>'img') $row.="</div>";
		//	else $row.="";
		$row.="";
			$obj_rows.=$row;
		}
			$obj_rows.="";

			return $obj_rows;
		}
		function getTitle($str){
			if(strlen($str)>0){
				preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
				$title = str_replace('"', '', $title[1]);
				$title = str_replace("'", '', $title);
				return $title;
			}
		}
		function getCode($html){
			preg_match('/(?<=charset\=).+(?=\")/iU', $html, $match);
			if (!empty($match[0])) {
				$charset = str_replace('"', '', $match[0]);
				$charset = str_replace("'", '', $charset);
				$charset = strtolower( trim($charset) );
				return $charset;
			}
		}
	}
?>
