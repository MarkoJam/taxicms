<?php
	$SITE_NAME = "TaxiCms";

	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);


	// neke globalne varijable
	define("IS_PRODUCTION", true);
	define("IS_URLREWRITE_ON", true);
	define('IS_CONN_STRING_LOADED', true);

	define("USE_PEAR", false);
	define("USE_UNITTEST", false);

	set_error_handler("myErrorHandler");
	set_error_handler("ErrorHandlerHeaderProblem");

	//----------------------------------------------------
	// definisanje parametara za rad sa bazom podataka
	//----------------------------------------------------

	if(IS_PRODUCTION) // produkcijski parametri
	{
		// produkcijski parametri
		define("EZSQL_DB_USER", "taxifrom_taxicms");					// <-- mysql db user
		define("EZSQL_DB_PASSWORD", "FvBNIobv2+s-");			// <-- mysql db password
		define("EZSQL_DB_NAME", "taxifrom_taxicms");				// <-- mysql db pname
		define("EZSQL_DB_HOST", "localhost");	// <-- mysql server host
	}
	else // test parametri
	{
		define("EZSQL_DB_USER", "root");
		define("EZSQL_DB_PASSWORD", "");
		define("EZSQL_DB_NAME", "taxicms");
		define("EZSQL_DB_HOST", "localhost");		// <-- mysql server host
	}

	//----------------------------------------------------
	// podesavanje putanja neophodnih za rad CMS-a
	//----------------------------------------------------

	if(IS_PRODUCTION) // produkcijski parametri
	{
		// definise putanje za rad sa sajtom
		define("ROOT_WEB", "https://taxicms.com/");
		define("ROOT_HOME", "/home/taxifrom/taxicms.com/");
		define("CAPTCHA_KEY_1", "6LdwZgMTAAAAAOiE_uSJ6ie926xgZithCCNk8tGt");
		define("CAPTCHA_KEY_2", "6LdwZgMTAAAAAA2yUHEQoPVlfgseYXOGQ_IZJruE");

		if(USE_UNITTEST)
		{
			define("ROOT_UNITTEST", "");

		}
	}
	else // test parametri
	{
		define("ROOT_WEB", "http://localhost/taxicms/");
		define("ROOT_HOME", "c:\\wamp\\www\\taxicms\\");

		define("CAPTCHA_KEY_1", "");
		define("CAPTCHA_KEY_2", "");

		if(USE_UNITTEST)
		{
			define("ROOT_UNITTEST", "");
		}
	}
	define("ROOT_DEMO", "https://wis.taxifrom.com/");
	define("ROOT_HELP", "https://help.taxicms.taxifrom.com/");


?>
