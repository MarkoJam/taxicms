<?php
 	print("\$_SERVER[\"PATH_INFO\"] = " . @$_SERVER['PATH_INFO'] . '<br />');
 	print("\$_SERVER[\"PHP_SELF\"] = " . @$_SERVER['PHP_SELF'] . '<br />');
 	print("\$_SERVER[\"REQUEST_URI\"] = " . @$_SERVER['REQUEST_URI'] . '<br />');
 	print("\$_SERVER[\"SCRIPT_NAME\"] = " . @$_SERVER['SCRIPT_NAME']);
?>