<?

//$wserv = new WeatherService("9e44b68109adecfa","1111826128","SIXX0002");
//$wserv->proccessAll();


class WeatherService {
	private $weatherUrl;
	private $xmlWeather;
	
	//
	private $xmlDOM;
	
	// data containers
	private $geoInformation;
	private $currentCondition;
	private $dailyForecasts;
	private $linkInformations;
	
	function __construct($licenceKey, $partnerID, $weathercode = "") {
		$this->weatherUrl = new WeatherUrl ( $licenceKey, $partnerID, $weathercode );
		$this->xmlDOM = new DOMDocument ( );
	}
	
	function GetFullUrl() {
		return $this->weatherUrl->getFullURL ();
	}
	
	function proccessAll() {
		$this->getRemoteWeather ();
		$this->getWeatherXML ();
		$this->parseGeoInformation ();
		$this->parseCurrentCondition ();
		$this->parseDailyForecast ();
		$this->parseLinkInformation();
	}
	
	function getRemoteWeather() {
		// create curl resource
		$ch = curl_init();
		// set url
		curl_setopt ( $ch, CURLOPT_URL, $this->weatherUrl->getFullURL () );
		//return the transfer as a string
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		// $output contains the output string
		$this->xmlWeather = curl_exec ( $ch );
		// close curl resource to free up system resources
		curl_close ( $ch );
	}
	
	function parseLinkInformation()
	{
		$this->xmlDOM->loadXML ( $this->xmlWeather );
		$xpath = new DomXPath ( $this->xmlDOM );
		$this->linkInformations = array();

		$elements = $xpath->query ( "//link" );

		foreach ($elements as $element) 
		{
			$linkInfo = new WeatherLinkInformation();
			$nodes = $element->childNodes;
			foreach ($nodes as $node) 
			{
				switch ($node->nodeName) 
				{
					case "l":
						$linkInfo->setLinkUrl($node->nodeValue);
						break;
					case "t":
						$linkInfo->setLinkText($node->nodeValue);
						break;
					default:
						break;
				}
			}
			
			$this->linkInformations[] = $linkInfo;		
		}
	}
	
	function parseGeoInformation() {
		$this->xmlDOM->loadXML ( $this->xmlWeather );
		$xpath = new DomXPath ( $this->xmlDOM );
		$this->geoInformation = new WeatherGeoInformation ( );
		// Location Name
		$element = $xpath->query ( "//loc" );
		$nodes = $element->item ( 0 )->childNodes;
		
		foreach ( $nodes as $node ) {
			switch ($node->nodeName) {
				case "dnam" :
					$this->geoInformation->setLocationName ( $node->nodeValue );
					break;
				case "tm" :
					// Local Time 
					$this->geoInformation->setLocalTime ( $node->nodeValue );
					break;
				case "lat" :
					// Latitute
					$this->geoInformation->setLatitude ( $node->nodeValue );
					break;
				case "lon" :
					// Longitude
					$this->geoInformation->setLongitude ( $node->nodeValue );
					break;
				case "sunr" :
					// Sunrise
					$this->geoInformation->setSunrise ( $node->nodeValue );
					break;
				case "suns" :
					// Sunset					
					$this->geoInformation->setSunset ( $node->nodeValue );
					break;
				default :
					break;
			}
		}
	}
	
	function parseCurrentCondition() {
		$this->xmlDOM->loadXML ( $this->xmlWeather );
		$xpath = new DomXPath ( $this->xmlDOM );
		$this->currentCondition = new WeatherCurrentCondition ( );
		
		$element = $xpath->query ( "//cc" );
		$nodes = $element->item ( 0 )->childNodes;
		
		foreach ( $nodes as $node ) {
			switch ($node->nodeName) {
				case "lsup" :
					$this->currentCondition->setLastUpdateDate ( $node->nodeValue );
					break;
				case "obst" :
					$this->currentCondition->setObservatoryStation ( $node->nodeValue );
					break;
				case "tmp" :
					$this->currentCondition->setTemperature ( $node->nodeValue );
					break;
				case "flik" :
					$this->currentCondition->setFeelLikeTemperature ( $node->nodeValue );
					break;
				case "t" :
					$this->currentCondition->setWeatherDescription ( $node->nodeValue );
					break;
				case "icon" :
					$this->currentCondition->setWeatherIcon ( $node->nodeValue );
					break;
				case "bar" :
					$subnodes = $node->childNodes;
					foreach ( $subnodes as $subnode ) {
						if ($subnode->nodeName != "#text") {
							switch ($subnode->nodeName) {
								// 
								case "r" :
									$this->currentCondition->setPreasure ( $subnode->nodeValue );
									break;
								case "d" :
									break;
								default :
									break;
							}
						}
					}
					break;
				case "wind" :
					$subnodes = $node->childNodes;
					foreach ( $subnodes as $subnode ) {
						if ($subnode->nodeName != "#text") {
							switch ($subnode->nodeName) {
								case "s" :
									$this->currentCondition->setWindSpeed( $subnode->nodeValue );
									break;
								case "gust" :
									break;
								case "d" :
									$this->currentCondition->setWindDirection( $subnode->nodeValue );
									break;
								case "t" :
									break;
								default :
									break;
							}
						}
					}
					break;
				case "hmid" :
					$this->currentCondition->setHumidity($node->nodeValue);
					break;
				case "vis" :
					//$this->currentCondition->setGetDateTime($node->nodeValue);
					break;
				case "uv" :
					//$this->currentCondition->setGetDateTime($node->nodeValue);
					break;
				case "dewp" :
					//$this->currentCondition->setGetDateTime($node->nodeValue);
					break;
				case "moon" :
					//$this->currentCondition->setGetDateTime($node->nodeValue);
					break;
				default :
					break;
			}
		
		}
	}
	
	function parseDailyForecast() {
		$this->xmlDOM->loadXML ( $this->xmlWeather );
		$xpath = new DomXPath ( $this->xmlDOM );
		$this->dailyForecasts = array ();
		
		$lsup = $xpath->query ( "//lsup" );
		$elements = $xpath->query ( "//day" );
		
		foreach ( $elements as $element ) {
			$nodes = $element->childNodes;
			$dailyForecast = new WeatherDailyForecast ( );
			$dailyForecast->setLastUpdateDate ( $lsup->item ( 0 )->nodeValue );
			$attributes = $element->attributes;
			foreach ( $attributes as $attribute ) {
				switch ($attribute->nodeName) {
					case "d" :
						$dailyForecast->setDayNumber ( $attribute->nodeValue );
						break;
					case "t" :
						$dailyForecast->setDayOfWeek ( $attribute->nodeValue );
						break;
					case "dt" :
						$dailyForecast->setDate ( $attribute->nodeValue );
						break;
					default :
						break;
				}
			}
			
			foreach ( $nodes as $node ) {
				if ($node->nodeName != "#text") {
					switch ($node->nodeName) {
						case "hi" :
							$dailyForecast->setHiTemp ( $node->nodeValue );
							break;
						case "low" :
							$dailyForecast->setLowTemp ( $node->nodeValue );
							break;
						case "sunr" :
							$dailyForecast->setSunrise ( $node->nodeValue );
							break;
						case "suns" :
							$dailyForecast->setSunset ( $node->nodeValue );
							break;
						case "part" :
							$attributes = $node->attributes;
							foreach ( $attributes as $attribute ) {
								if ($attribute->name == "p" && $attribute->value == "d") {
									// part DAY		
									$subnodes = $node->childNodes;
									foreach ( $subnodes as $subnode ) {
										if ($subnode->nodeName != "#text") {
											switch ($subnode->nodeName) {
												case "icon" :
													$dailyForecast->setWeatherIconDay ( $subnode->nodeValue );
													break;
												case "t" :
													$dailyForecast->setWeatherDescriptionDay ( $subnode->nodeValue );
													break;
												case "wind" :
													foreach ( $subnode->childNodes as $windinfo ) {
														switch ($windinfo->nodeName) {
															case "s" :
																$dailyForecast->setWindSpeedDay ( $windinfo->nodeValue );
																break;
															case "gust" :
																
																break;
															case "d" :
																$dailyForecast->setWindDirectionDay ( $windinfo->nodeValue );
																break;
															case "t" :
																
																break;
															default :
																break;
														}
													}
													break;
												case "bt" :
													
													break;
												case "ppcp" :
													
													break;
												case "hmid" :
													$dailyForecast->setHumidityDay ( $subnode->nodeValue );
													break;
												default :
													break;
											}
										}
									}
								}
								
								if ($attribute->name == "p" && $attribute->value == "n") {
									// part NIGHT	
									$subnodes = $node->childNodes;
									foreach ( $subnodes as $subnode ) {
										if ($subnode->nodeName != "#text") {
											switch ($subnode->nodeName) {
												case "icon" :
													$dailyForecast->setWeatherIconNight ( $subnode->nodeValue );
													break;
												case "t" :
													$dailyForecast->setWeatherDescriptionNight ( $subnode->nodeValue );
													break;
												case "wind" :
													foreach ( $subnode->childNodes as $windinfo ) {
														switch ($windinfo->nodeName) {
															case "s" :
																$dailyForecast->setWindSpeedNight ( $windinfo->nodeValue );
																break;
															case "gust" :
																
																break;
															case "d" :
																$dailyForecast->setWindDirectionNight ( $windinfo->nodeValue );
																break;
															case "t" :
																
																break;
															default :
																break;
														}
													}
													break;
												case "bt" :
													
													break;
												case "ppcp" :
													
													break;
												case "hmid" :
													$dailyForecast->setHumidityDay ( $subnode->nodeValue );
													break;
												default :
													break;
											}
										}
									}
								}
							
							}
							
							break;
						default :
							break;
					}
				}
			}
			$this->dailyForecasts [] = $dailyForecast;
		}
	}
	
	function getCurrentConditionArray() {
		return $this->currentCondition->toArray ();
	}
	
	function getGeoInformationArray() {
		return $this->geoInformation->toArray ();
	}
	
	function getDailyForecasts() {
		return $this->dailyForecasts;
	}
	
	function getLinksInformation()
	{
		$tmp_arr = array();
		foreach ($this->linkInformations as $li) 
		{
			$tmp_arr[] = $li->toArray();
		}
		
		return$tmp_arr;
	}
	
	function getWeatherXML() {
		if ($this->xmlWeather != "") {
			return $this->xmlWeather;
		} else {
			return "error: File empty";
		}
	}
}
class WeatherLinkInformation
{
	private $linkUrl;
	private $linkText;
	
	function __construct(){}
	
	function toArray() {
		$arr = array ();
		$arr = array_merge ( $arr, array ("linktext" => $this->getLinkText()) );
		$arr = array_merge ( $arr, array ("linkurl" => $this->getLinkUrl()) );
		return $arr;
	}
	
	function setLinkUrl($val)
	{
		$this->linkUrl = $val;
	}
	function setLinkText($val)
	{
		$this->linkText = $val;
	}
	function getLinkUrl()
	{
		return $this->linkUrl;
	}
	function getLinkText()
	{
		return $this->linkText;
	}
}
class WeatherUrl {
	private $baseUrl;
	private $daysForecast;
	private $linkType;
	private $productType;
	private $ccType;
	private $licenceKey;
	private $partnerID;
	private $weatherCode;
	private $fullUrl;
	private $unit;
	
	function __construct($licenceKey, $partnerID, $weathercode = "") {
		$this->licenceKey = $licenceKey;
		$this->partnerID = $partnerID;
		$this->weatherCode = $weathercode;
		$this->InitVars ();
		$this->fullUrl = $this->getBaseUrl () . $this->getWeatherCodeQuery () . $this->getDaysForecastQuery () . $this->getLinkTypeQuery () . $this->getProductTypeQuery () . $this->getCCTypeQuery () . $this->getAuthQuery () . $this->getUnit ();
	}
	function InitVars() {
		$this->baseUrl = "http://xoap.weather.com/weather/local/";
		$this->daysForecast = "5";
		$this->linkType = "xoap";
		$this->productType = "xoap";
		$this->ccType = "*";
		$this->unit = "m";
	}
	
	function getFullURL() {
		return $this->fullUrl;
	}
	function getBaseUrl() {
		return $this->baseUrl;
	}
	function getWeatherCodeQuery() {
		if ($this->weatherCode != "") {
			return $this->weatherCode . "?";
		}
		return "";
	}
	function getDaysForecastQuery() {
		if ($this->daysForecast != "") {
			return "&dayf=" . $this->daysForecast;
		}
		return "";
	}
	function getLinkTypeQuery() {
		if ($this->linkType != "") {
			return "&link=" . $this->linkType;
		}
		return "";
	}
	function getProductTypeQuery() {
		if ($this->productType != "") {
			return "&prod=" . $this->productType;
		}
		return "";
	}
	function getCCTypeQuery() {
		if ($this->ccType != "") {
			return "&cc=" . $this->ccType;
		}
		return "";
	}
	
	function getUnit() {
		return "&unit=" . $this->unit;
	}
	
	function getAuthQuery() {
		return "&par=" . $this->partnerID . "&key=" . $this->licenceKey;
	}
}

class WeatherGeoInformation {
	private $locationName;
	private $longitude;
	private $latitude;
	private $localTime;
	private $sunrise;
	private $sunset;
	
	function __construct() {
	}
	
	function getLocationName() {
		return $this->locationName;
	}
	function setLocationName($val) {
		$this->locationName = $val;
	}
	function getLongitude() {
		return $this->longitude;
	}
	function setLongitude($val) {
		$this->longitude = $val;
	}
	function getLatitude() {
		return $this->latitude;
	}
	function setLatitude($val) {
		$this->latitude = $val;
	}
	function getLocalTime() {
		return $this->localTime;
	}
	function setLocalTime($val) {
		$this->localTime = $val;
	}
	function getSunrise() {
		return $this->sunrise;
	}
	function setSunrise($val) {
		$this->sunrise = $val;
	}
	function getSunset() {
		return $this->sunset;
	}
	function setSunset($val) {
		$this->sunset = $val;
	}
	
	function toArray() {
		$arr = array ();
		$arr = array_merge ( $arr, array ("locationname" => $this->getLocationName () ) );
		$arr = array_merge ( $arr, array ("longitude" => $this->getLongitude () ) );
		$arr = array_merge ( $arr, array ("latitude" => $this->getLatitude () ) );
		$arr = array_merge ( $arr, array ("localtime" => $this->getLocalTime () ) );
		$arr = array_merge ( $arr, array ("sunrise" => $this->getSunrise () ) );
		$arr = array_merge ( $arr, array ("sunset" => $this->getSunset () ) );
		return $arr;
	}
}

class WeatherCurrentCondition {
	private $lastUpdateDate;
	private $observatoryStation;
	private $temperature;
	private $feelLikeTemp;
	private $weatherDescription;
	private $weatherIcon;
	private $preasure;
	private $humidity;
	private $windSpeed;
	private $windDirection;
	
	function __construct() {
	}
	
	function toArray() {
		$arr = array ();
		$arr = array_merge ( $arr, array ("lastupdatedate" => $this->getLastUpdateDate () ) );
		$arr = array_merge ( $arr, array ("observatorystation" => $this->getObservatoryStation () ) );
		$arr = array_merge ( $arr, array ("temperature" => $this->getTemperature () ) );
		$arr = array_merge ( $arr, array ("feelliketemp" => $this->getFeelLikeTemperature () ) );
		$arr = array_merge ( $arr, array ("weatherdescription" => $this->getWeatherDescription () ) );
		$arr = array_merge ( $arr, array ("weathericon" => $this->getWeatherIcon () ) );
		$arr = array_merge ( $arr, array ("preasure" => $this->getPreasure () ) );
		$arr = array_merge ( $arr, array ("humidity" => $this->getHumidity () ) );
		$arr = array_merge ( $arr, array ("windspeed" => $this->getWindSpeed () ) );
		$arr = array_merge ( $arr, array ("winddirection" => $this->getWindDirection () ) );
		return $arr;
	}
	
	function getLastUpdateDate() {
		return $this->lastUpdateDate;
	}
	
	function setLastUpdateDate($val) {
		$this->lastUpdateDate = $val;
	}
	
	function getObservatoryStation() {
		return $this->observatoryStation;
	}
	
	function setObservatoryStation($val) {
		$this->observatoryStation = $val;
	}
	
	function getTemperature() {
		return $this->temperature;
	}
	function setTemperature($val) {
		$this->temperature = $val;
	}
	function getFeelLikeTemperature() {
		return $this->feelLikeTemp;
	}
	function setFeelLikeTemperature($val) {
		$this->feelLikeTemp = $val;
	}
	function getWeatherDescription() {
		return $this->weatherDescription;
	}
	function setWeatherDescription($val) {
		$this->weatherDescription = $val;
	}
	function getWeatherIcon() {
		return $this->weatherIcon;
	}
	function setWeatherIcon($val) {
		$this->weatherIcon = $val;
	}
	function getPreasure() {
		return $this->preasure;
	}
	function setPreasure($val) {
		$this->preasure = $val;
	}
	function getHumidity() {
		return $this->humidity;
	}
	function setHumidity($val) {
		$this->humidity = $val;
	}
	function getWindSpeed() {
		return $this->windSpeed;
	}
	function setWindSpeed($val) {
		$this->windSpeed = $val;
	}
	function getWindDirection() {
		return $this->windDirection;
	}
	function setWindDirection($val) {
		$this->windDirection = $val;
	}
}

class WeatherDailyForecast {
	private $locationId;
	private $cityName;
	private $lastUpdateDate;
	private $dayNumber;
	private $dayOfWeek;
	private $date;
	private $hiTemp;
	private $lowTemp;
	private $sunrise;
	private $sunset;
	
	private $weatherDescriptionDay;
	private $weatherIconDay;
	private $windSpeedDay;
	private $windDirectionDay;
	private $humidityDay;
	
	private $weatherDescriptionNight;
	private $weatherIconNight;
	private $windSpeedNight;
	private $windDirectionNight;
	private $humidityNight;
	
	function toArray() {
		$arr = array ();
		$arr = array_merge ( $arr, array ("locationid" => $this->getLocationID () ) );
		$arr = array_merge ( $arr, array ("cityname" => $this->getCityName () ) );
		$arr = array_merge ( $arr, array ("lastupdatedate" => $this->getLastUpdateDate () ) );
		$arr = array_merge ( $arr, array ("daynumber" => $this->getDayNumber () ) );
		$arr = array_merge ( $arr, array ("dayofweek" => $this->getDayOfWeek () ) );
		$arr = array_merge ( $arr, array ("date" => $this->getDate () ) );
		$arr = array_merge ( $arr, array ("hitemp" => $this->getHiTemp () ) );
		$arr = array_merge ( $arr, array ("lowtemp" => $this->getLowTemp () ) );
		$arr = array_merge ( $arr, array ("sunrise" => $this->getSunrise () ) );
		$arr = array_merge ( $arr, array ("sunset" => $this->getSunset () ) );
		$arr = array_merge ( $arr, array ("weatherdescriptionday" => $this->getWeatherDescriptionDay () ) );
		$arr = array_merge ( $arr, array ("weathericonday" => $this->getWeatherIconDay () ) );
		$arr = array_merge ( $arr, array ("windspeedday" => $this->getWindSpeedDay () ) );
		$arr = array_merge ( $arr, array ("winddirectionday" => $this->getWindDirectionDay () ) );
		$arr = array_merge ( $arr, array ("humidityday" => $this->getHumidityDay () ) );
		$arr = array_merge ( $arr, array ("weatherdescriptionnight" => $this->getWeatherDescriptionNight () ) );
		$arr = array_merge ( $arr, array ("weathericonnight" => $this->getWeatherIconNight () ) );
		$arr = array_merge ( $arr, array ("windspeednight" => $this->getWindSpeedNight () ) );
		$arr = array_merge ( $arr, array ("winddirectionnight" => $this->getWindDirectionNight () ) );
		$arr = array_merge ( $arr, array ("humiditynight" => $this->getHumidityNight () ) );
		return $arr;
	}
	
	function getLocationID() {
		return $this->locationId;
	}
	function getCityName() {
		return $this->cityName;
	}
	function getLastUpdateDate() {
		return $this->lastUpdateDate;
	}
	function getDayNumber() {
		return $this->dayNumber;
	}
	function getDayOfWeek() {
		return $this->dayOfWeek;
	}
	function getDate() {
		return $this->date;
	}
	function getHiTemp() {
		return $this->hiTemp;
	}
	function getLowTemp() {
		return $this->lowTemp;
	}
	function getSunrise() {
		return $this->sunrise;
	}
	function getSunset() {
		return $this->sunset;
	}
	
	function getWeatherDescriptionDay() {
		return $this->weatherDescriptionDay;
	}
	function getWeatherIconDay() {
		return $this->weatherIconDay;
	}
	function getWindSpeedDay() {
		return $this->windSpeedDay;
	}
	function getWindDirectionDay() {
		return $this->windDirectionDay;
	}
	function getHumidityDay() {
		return $this->humidityDay;
	}
	
	function getWeatherDescriptionNight() {
		return $this->weatherDescriptionNight;
	}
	function getWeatherIconNight() {
		return $this->weatherIconNight;
	}
	function getWindSpeedNight() {
		return $this->windSpeedNight;
	}
	function getWindDirectionNight() {
		return $this->windDirectionNight;
	}
	function getHumidityNight() {
		return $this->humidityNight;
	}
	
	//--------------------------------
	

	function setLocationID($val) {
		$this->locationId = $val;
	}
	function setCityName($val) {
		$this->cityName = $val;
	}
	function setLastUpdateDate($val) {
		$this->lastUpdateDate = $val;
	}
	function setDayNumber($val) {
		$this->dayNumber = $val;
	}
	function setDayOfWeek($val) {
		$this->dayOfWeek = $val;
	}
	function setDate($val) {
		$this->date = $val;
	}
	function setHiTemp($val) {
		$this->hiTemp = $val;
	}
	function setLowTemp($val) {
		$this->lowTemp = $val;
	}
	function setSunrise($val) {
		$this->sunrise = $val;
	}
	function setSunset($val) {
		$this->sunset = $val;
	}
	
	function setWeatherDescriptionDay($val) {
		$this->weatherDescriptionDay = $val;
	}
	function setWeatherIconDay($val) {
		$this->weatherIconDay = $val;
	}
	function setWindSpeedDay($val) {
		$this->windSpeedDay = $val;
	}
	function setWindDirectionDay($val) {
		$this->windDirectionDay = $val;
	}
	function setHumidityDay($val) {
		$this->humidityDay = $val;
	}
	
	function setWeatherDescriptionNight($val) {
		$this->weatherDescriptionNight = $val;
	}
	function setWeatherIconNight($val) {
		$this->weatherIconNight = $val;
	}
	function setWindSpeedNight($val) {
		$this->windSpeedNight = $val;
	}
	function setWindDirectionNight($val) {
		$this->windDirectionNight = $val;
	}
	function setHumidityNight($val) {
		$this->humidityNight = $val;
	}
}

?>