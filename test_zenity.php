<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

// die Basis Logik einbinden
include 'wbf/core.php';

echo Zenity::dialog( 'fuu ', 'licence/licence.txt', 'bar' );

/*
echo Zenity::question( "question" );

echo Zenity::warning( "warning" );

echo Zenity::readText( "Antwort auf alle fragen?", "Is klar... ne?" );
echo Zenity::readPassword( "Gibst du password", "aber zack zack" );

echo Zenity::dialog( "warning" );

echo Zenity::notification( "Some boring notification" );
*/

