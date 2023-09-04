<?
	/* System definitions */

	if ( !defined('PATH_SEPARATOR') )
	{
    	define('PATH_SEPARATOR', ( substr(PHP_OS, 0, 3) == 'WIN' ) ? ';' : ':');
	}

	if ( !defined('FILEPATH_SEPARATOR') )
	{
    	define('FILEPATH_SEPARATOR', ( substr(PHP_OS, 0, 3) == 'WIN' ) ? '\\' : '/');
	}

	/* CMS Studio 3.0 definitions.php */

	// CMS predefinisani templateti koji se ne mogu brisati
	define("TEMPLATE_UNIVERSAL", 0);
	define("TEMPLATE_STANDARD", 1);
	define("TEMPLATE_SHOPPING_CART" ,2);
	define("TEMPLATE_REGISTRATION", 3);
	define("TEMPLATE_SITEMAP", 4);
	define("TEMPLATE_ALL", 5);
	define("TEMPLATE_SEARCH", 6);
	define("TEMPLATE_PRODUCT", 7);
	define("TEMPLATE_NEWS", 11);
	define("TEMPLATE_PERSONS", 12);
	define("TEMPLATE_MODULE", 13);
	define("TEMPLATE_GENRES", 14);
	define("TEMPLATE_OPTION", 15);
	define("TEMPLATE_GALLERY", 16);

	// Sifarnik: SF_TIP_STRANICA TO DO : prevesti u SF_PAGE_TYPE
	define("PAGE_TYPE_PAGE", 1);
	define("PAGE_TYPE_LINK", 2);
	define("PAGE_TYPE_CATEGORY", 3);
	define("PAGE_TYPE_PRODUCTGROUP", 4);

	// Sifarnik: SF_PAGE_PROTECTION
	define("PAGE_PROTECTION_NOTACTIVE" , 1);
	define("PAGE_PROTECTION_ACTIVE" , 2);

	// Sifarnik: SF_ORDER_TYPE
	define("ORDER_TYPE_1" , 1);
	define("ORDER_TYPE_2" , 2);
	define("ORDER_TYPE_3" , 3);
	define("ORDER_TYPE_4" , 4);

	// Sifarnik: SF_USER_TYPE
	define("USER_TYPE_PRIVATE_ENTITY", 		1); // Fizicko lice
	define("USER_TYPE_LEGAL_ENTITY", 		2); // Pravno lice
	define("USER_TYPE_ENTREPRENEUR_ENTITY", 3); // Preduzetnik
	//define("USER_TYPE_MAILINGLIST_ENTITY",  4); // Mailing lista

	// Sifarnik: SF_USER_CATEGORY
	define("USER_CATEGORY_USERS",	1);
	define("USER_CATEGORY_WEBUSERS",	2);


	// Sifarnici: SF_STATUS -- sifarnik svih mogucih statusa u sistemu

		// pages status -- from 1
		define("STATUS_PAGE_AKTIVAN",	1);
		define("STATUS_PAGE_AKTIVAN_LINK",	2);
		define("STATUS_PAGE_NEAKTIVAN",	3);

		// adminuser status -- from 21
		define("STATUS_ADMINUSER_AKTIVAN",	21);
		define("STATUS_ADMINUSER_NEAKTIVAN",	22);

		// news status ----- from 31
		define("STATUS_NEWS_AKTIVAN",	31);
		define("STATUS_NEWS_NEAKTIVAN",	32);

		// newsletter status ---- from 41
		define("STATUS_NEWSLETTER_POSLATO" , 41);
		define("STATUS_NEWSLETTER_NEPOSLATO" , 42);
		define("STATUS_NEWSLETTER_TESTIRANO" , 43);
		define("STATUS_NEWSLETTER_SLANJE" , 44);
		define("STATUS_NEWSLETTER_GRESKA" , 45);

		// product status -- from 51
		define("STATUS_PROIZVODA_AKTIVAN",		51);
		define("STATUS_PROIZVODA_NEKTIVAN",		52);
		define("STATUS_PROIZVODA_ARHIVIRAN",	53);
		define("STATUS_PROIZVODA_NEMANALAGERU",	54);
		define("STATUS_PROIZVODA_POZOVITE",	    55);
		define("STATUS_PROIZVODA_MALILAGER",	56);


		// poll status --- from 61
		define("STATUS_POLL_AKTIVAN",	61);
		define("STATUS_POLL_NEKATIVAN",	62);

		// user status --- from 71
		define("STATUS_USER_AKTIVAN",	71);
		define("STATUS_USER_NEAKTIVAN",	72);

		// order status --- from 81
		define("STATUS_ORDER_NEOBRADJENO",	81);
		define("STATUS_ORDER_UOBRADI",		82);
		define("STATUS_ORDER_OBRADJENO",	83);
		define("STATUS_ORDER_NEUSPESNO_PLACANJE",84);
		define("STATUS_ORDER_KORISNIK_ODUSTAO",85);
		define("STATUS_ORDER_USPESNO_PLACANJE",86);

		// option status --- from 91
		define("STATUS_OPTION_AKTIVAN",	91);
		define("STATUS_OPTION_NEAKTIVAN",	92);

		// event status --- from 101
		define("STATUS_PRODUCTGROUP_GLAVNA",	101);
		define("STATUS_PRODUCTGROUP_SPOREDNA",	102);
		define("STATUS_PRODUCTGROUP_NEAKTIVAN",	103);

		// persons status ----- from 131
		define("STATUS_PERSONS_AKTIVAN",	131);
		define("STATUS_PERSONS_NEAKTIVAN",	132);

		// slide status ----- from 141
		define("STATUS_SLIDE_AKTIVAN",	141);
		define("STATUS_SLIDE_NEAKTIVAN",	142);

		// project status ----- from 151
		define("STATUS_MODULE_AKTIVAN",	151);
		define("STATUS_MODULE_NEAKTIVAN",	152);

		// subsite status ----- from 161
		define("STATUS_SUBSITE_AKTIVAN",	161);
		define("STATUS_SUBSITE_NEAKTIVAN",	162);

		// labels status ----- from 171
		define("STATUS_LABELS_AKTIVAN",	171);
		define("STATUS_LABELS_NEAKTIVAN",	172);

		// genres status ----- from 181
		define("STATUS_GENRES_AKTIVAN",	181);
		define("STATUS_GENRES_NEAKTIVAN",	182);

		// commant status ----- from 191
		define("STATUS_COMMENT_AKTIVAN",	191);
		define("STATUS_COMMENT_NEAKTIVAN",	192);

		// commant status ----- from 200
		define("STATUS_SECTIONS_AKTIVAN",	201);
		define("STATUS_SECTIONS_NEAKTIVAN",	202);

		// commant status ----- from 210
		define("STATUS_GALLERY_AKTIVAN",	211);
		define("STATUS_GALLERY_NEAKTIVAN",	212);

		// question status ----- from 220
		define("STATUS_QUESTION_AKTIVAN",	221);
		define("STATUS_QUESTION_NEAKTIVAN",	222);

		// slide status ----- from 231
		define("STATUS_CATEGORY_GLAVNI",	231);
		define("STATUS_CATEGORY_POMOCNI",	232);
		define("STATUS_CATEGORY_NEAKTIVAN",	233);


	// Tip sifarnika: SF_TIP_STATUS
	define("STATUS_TIP_PAGE",		 1);
	define("STATUS_TIP_ADMINUSER",	 2);
	define("STATUS_TIP_NEWS",		 3);
	define("STATUS_TIP_NEWSLETTER",	 4);
	define("STATUS_TIP_PRODUCT",	 5);
	define("STATUS_TIP_POLL",		 6);
	define("STATUS_TIP_USER",		 7);
	define("STATUS_TIP_ORDER",		 8);
	define("STATUS_TIP_OPTION",		 9);
	define("STATUS_TIP_PRODUCTGROUP",		 10);
	define("STATUS_TIP_PRODUCTCOMMENT",		 11);
	define("STATUS_TIP_FREQ",     12);
	define("STATUS_TIP_PERSONS",	13);
	define("STATUS_TIP_SLIDE",	14);
	define("STATUS_TIP_MODULE",	15);
	define("STATUS_TIP_SUBSITE",	16);
	define("STATUS_TIP_LABELS",	17);
	define("STATUS_TIP_GENRES",	18);
	define("STATUS_TIP_COMMENT", 19);
	define("STATUS_TIP_SECTIONS", 20);
	define("STATUS_TIP_GALLERY", 21);
	define("STATUS_TIP_QUESTION", 22);
	define("STATUS_TIP_CATEGORY", 23);



	// Vrste plugin-ova

	define("PLUGIN_TYPE_PRODUCT", 36);
	define("PLUGIN_TYPE_NEWS", 3);

	// Plugin modules : SF_PLUGIN_MODULES
	define("PLUGIN_MODULE_CORE",		1); // Osnovni
	define("PLUGIN_MODULE_NEWS",		2); // Vesti
	define("PLUGIN_MODULE_POLL",		3); // Anketa
	define("PLUGIN_MODULE_UNIVERSAL",	4); // Univerzalni plugin
	define("PLUGIN_MODULE_LOGIN",		5); // Logovanje korisnika
	define("PLUGIN_MODULE_PRODUCTS",	6); // Proizvodi
	define("PLUGIN_MODULE_PRODUCTSEARCH",7); // Pretraga proizvoda
	define("PLUGIN_MODULE_NAVIGATION",	8); // Navigacija
	define("PLUGIN_MODULE_LINKCATEGORY",9); // Kategorije linkova
	define("PLUGIN_MODULE_NEWSLETTER",	10); // Mailing lista
	define("PLUGIN_MODULE_SEARCH",		11); // Pretraga sajta
	define("PLUGIN_MODULE_ADMINUSER",	12); // Admin korisnici
	define("PLUGIN_MODULE_CONTACTFROM",	13); // Kontakt formular
	define("PLUGIN_MODULE_BACKUP",		14); // Backup
	define("PLUGIN_MODULE_SETTING",		15); // Podešavanja

	// Vrednosti karakteristika: PR_KARAKTERISTIKE_VREDNOST

	define("PRODUCT_CHAR_TYPE_FREE",		1); // Slobodan unos
	define("PRODUCT_CHAR_TYPE_FILE",		2); // Datoteka
	define("PRODUCT_CHAR_TYPE_IMAGE",		3); // Slika


	// Vrednosti sifarnika vezanih za settings modul

	define("SETTING_EXCEL_EXPORT_PAGE",			1); // izvoz stranica u Excel
	define("SETTING_EXCEL_EXPORT_TEMPLATE",		2); // izvoz templejta u Excel
	define("SETTING_EXCEL_EXPORT_STATICPAGE",	3); // izvoz staticnih stranica u Excel
	define("SETTING_EXCEL_EXPORT_PLUGIN",		4); // izvoz plugin u Excel
	define("SETTING_EXCEL_EXPORT_ADMINPAGE",	5); // izvoz admin stranica u Excel
	define("SETTING_EXCEL_EXPORT_PRODUCTS",		6); // izvoz proizvoda u Excel
	define("SETTING_EXCEL_EXPORT_PRODUCTSTYPE",	7); // izvoz tipova proizvoda u Excel
	define("SETTING_EXCEL_EXPORT_PRODUCTSCATEGORY",	8); // izvoz kategorija proizvoda u Excel
	define("SETTING_EXCEL_EXPORT_USERS", 58); // izvoz korisnika u excel

	// admin: plg_newsletter/sendtomail.php
	define("NEWSLETTR_MAIL_EMAIL", 			9);
	define("NEWSLETTR_MAIL_NAME",			10);
	define("NEWSLETTER_SENDER_TYPE",		11);
	define("NEWSLETTER_HOST_NAME",			12);
	define("NEWSLETTER_MAIL_SUBJECT",		45);

	// admin: plg_newsletter/testmail.php
	define("NEWSLETTR_TEST_MAIL_EMAIL", 	13);
	define("NEWSLETTR_TEST_MAIL_NAME",		14);
	define("NEWSLETTER_TEST_HOST_NAME",		15);
	define("NEWSLETTER_TEST_SENDER_TYPE",	16);
	define("NEWSLETTER_TEST_TESTER_MAIL",	17);
	define("NEWSLETTER_TEST_MAIL_SUBJECT",	46);

	// front: plg_login/loginPlugin.php
	define("REGISTERMAIL_MAIL_EMAIL", 	18);
	define("REGISTERMAIL_MAIL_NAME",	19);
	define("REGISTERMAIL_HOST_NAME",	20);
	define("REGISTERMAIL_SENDER_TYPE",	21);
	define("REGISTERMAIL_MAIL",			22);
	define("REGISTERMAIL_MAIL_SUBJECT",	47);
	define("REGISTERMAIL_MAIL_ACTIVATION",	59);

	// front: plg_order/order_final.php
	define("ORDER_MAIL_EMAIL", 	23);
	define("ORDER_MAIL_NAME",	24);
	define("ORDER_SENDER_TYPE",	25);
	define("ORDER_HOST_NAME",	26);
	define("ORDER_MAIL", 27);
	define("ORDER_MAIL_ACTIVE",	28);
	define("ORDER_MAIL_SUBJECT",48);

	// admin: plg_login/modify_final.php
	define("USERACTIVATION_MAIL_EMAIL", 	29);
	define("USERACTIVATION_MAIL_NAME",		30);
	define("USERACTIVATION_SENDER_TYPE",	31);
	define("USERACTIVATION_HOST_NAME",		32);
	define("USERACTIVATION_SITENAME",		33);
	define("USERACTIVATION_MAIL_ACTIVE",	34);
	define("USERACTIVATION_MAIL_SUBJECT",	49);

	// front:
	define("ORDER_TO_USER_MAIL_EMAIL", 	35);
	define("ORDER_TO_USER_MAIL_NAME",	36);
	define("ORDER_TO_USER_SENDER_TYPE",	37);
	define("ORDER_TO_USER_HOST_NAME",	38);
	define("ORDER_TO_USER_MAIL_ACTIVE",	39);
	define("ORDER_TO_USER_MAIL_SUBJECT",50);

	// front: plg_formcontact/formcontactPlugin.php
	define("CONTACT_MAIL_EMAIL", 	40);
	define("CONTACT_MAIL_NAME",		41);
	define("CONTACT_SENDER_TYPE",	42);
	define("CONTACT_HOST_NAME",		43);
	define("CONTACT_MAIL",			44);
	define("CONTACT_MAIL_SUBJECT",	45);
	define("CONTACT_MAIL_SENDER",	46);
	define("CONTACT_MAIL_HOSTNAME",	73);
	define("CONTACT_MAIL_USERNAME",	74);
	define("CONTACT_MAIL_PASSWORD",	75);

	//front: plg_comment/commentPlugin.php
	define("COMMENT_MAIL_EMAIL", 	52);
	define("COMMENT_MAIL_NAME",		53);
	define("COMMENT_SENDER_TYPE",	54);
	define("COMMENT_HOST_NAME",		55);
	define("COMMENT_MAIL",			56);
	define("COMMENT_MAIL_SUBJECT",	57);


	define("SETTING_TYPE_ON" ,1);	// ukljuceno
	define("SETTING_TYPE_OFF" ,2);	// iskljuceno

	// mail podesavanja
	define("SENDER_TYPE_SMTP" , 3); // smtp protocl
	define("SENDER_TYPE_MAIL" , 4); // mail function

	// sortiranje proizvoda
	define("SORTBY_PRODUCT_DEFAULT", 0);
	define("SORTBY_PRODUCT_PRICE_DESC", 1);
	define("SORTBY_PRODUCT_PRICE_ASC", 2);
	define("SORTBY_PRODUCT_TITLE_ASC", 3);
	define("SORTBY_PRODUCT_TITLE_DESC", 4);

	//izvedeni proizvodi
	define("BASIC_PRODUCTS", 3);
	define("DERIVATED_PRODUCTS", 4);
?>
