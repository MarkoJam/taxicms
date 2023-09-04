<?
	session_start();	
	
	foreach ($_SESSION as $key => $value)
	{
		unset($_SESSION[$key]);
	}

	if(isset($_REQUEST["lang"]))
	{
		header('Content-Type: text/html; charset=utf-8');
   		header('Set-Cookie: ad_cookie_language='.$_REQUEST["lang"].'; path=/ ');
		header("Location: index.php");
	}
?>