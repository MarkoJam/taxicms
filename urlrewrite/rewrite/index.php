<?php
##################################################
#              http://www.php-HR-net             #
##################################################


// uæitamo klasu
require_once ('../PathVars.php');

// PROMIJENITE OVO!!!
$baseUrl='/urlrewrite/rewrite/';

// Instanciramo objekt
$pathVars = &new PathVars($baseUrl);

// Koja je prva varijabla?
switch ( $pathVars->fetchByIndex(0) ) {
    case 'download':
        // Pogledamo drugi dio varijable
        if ( $pathVars->fetchByIndex(1) ) {
            echo ( 'Skidam datoteku '.$pathVars->fetchByIndex(1) );
        } else {
            echo ( 'Download <a href="'.$baseUrl.
                'download/nekadatoteka.zip">nekadadoteka.zip</a><br />' );
        }
        break;
    case 'clanak':
        // Pogledamo drugi dio varijable
        if ( $pathVars->fetchByIndex(1) ) {
            echo ( 'Èitate èlanak '.$pathVars->fetchByIndex(1) );
        } else {
            echo ( 'Pogledaj <a href="'.$baseUrl.
                'clanak/123">èlanak 123</a><br />' );
        }
        break;
    default:
        echo ( 'Dobrodošli<br />' );
        echo ( '<a href="'.$baseUrl.'download/">Download</a><br />' );
        echo ( '<a href="'.$baseUrl.'clanak/">Èlanci</a><br />' );
        break;
}
?>
