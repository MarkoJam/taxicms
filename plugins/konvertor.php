<?
	include_once("../config.php");

	$objlist = $ObjectFactory->createObjects("Question");

	foreach($objlist as $o)
	{
		echo $lq=LatToCir($o->getQuestion());
		$o->setQuestion($lq);
		$DBBR->promeniSlog($o);		
	}		
	
	function LatToCir($text)
	{
		$search = array("Š","š","LJ","NJ","DŽ" ,"Lj","Dž","Nj","lj","nj","dž","a","b","c","č","ć","d","đ","e","f","g","h","i","j","k","l","m","n","o","p","r","s","š","t","u","v","z","ž","A","B","C","Č","Ć","D","Đ","E","F","G","H","I","J","K","L","M","N","O","P","R","S","Š","T","U","V","Z","Ž");
		$replace =array("Ш","ш","Љ", "Њ", "Џ",  "Љ", "Џ", "Њ", "љ", "њ", "џ", "а","б","ц","ч","ћ","д","ђ","е","ф","г","х","и","ј","к","л","м","н","о","п","р","с","ш","т","у","в","з","ж","А","Б","Ц","Ч","Ћ","Д","Ђ","Е","Ф","Г","Х","И","Ј","К","Л","М","Н","О","П","Р","С","Ш","Т","У","В","З","Ж");
		
		$text = str_replace($search, $replace, $text);
		
		// fix html entites
		$search = array("&нбсп;","&qуот;","&бдqуо;","&лдqуо;","&рдqуо;","&лaqуо;","&рaqуо;","&булл;");
		$replace = array("&nbsp;","&quot;","&bdquo;","&ldquo;","&rdquo;","&ldquo;","&rdquo;","&bull;"); 
		
		return str_replace($search, $replace, $text);
	}
	
?>