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

$action = Request::arg( 'action' );

switch ( $action )
{
  case 'start_setup' :
  {
    Db::startSetup( $setupDb, $tmpFolder );
    break;
  }
  case 'finish_setup' :
  {
    Db::finishSetup( $setupDb, $tmpFolder );
    break;
  }  
  case 'help' :
  {
    
    $help = <<<HELP
    
HELP;

    Console::out( $help );
    
    break;
  }
  default:
  {
    ///TODO fehlermeldung verbessern
    Console::outln( "Invalid Parameter" );
  }
}


