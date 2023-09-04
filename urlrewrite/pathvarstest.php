<?php
##################################################
#              http://www.php-HR-net             #
##################################################


// uèitamo klasu
require_once('PathVars.php');

echo ( '$_SERVER[\'REQUEST_URI\'] is '.$_SERVER['REQUEST_URI'].'<br />' );
echo ( '$_SERVER[\'SCRIPT_NAME\'] is '.$_SERVER['SCRIPT_NAME'].'<br />' );

// Instanciramo objekt
$pathVars = &new PathVars($_SERVER['SCRIPT_NAME']);

echo ( "<b>Iteriramo kroz sve varijable</b><br />\n" );
while ($var = $pathVars->fetch()) {
    echo ( $var."<br />\n" );
}

echo ( "<b>Vrati varijablu sa indexom 2</b><br />\n" );
echo ( $pathVars->fetchByIndex(2) );
?>