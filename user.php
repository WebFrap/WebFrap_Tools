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
include GAIA_PATH.'core/user/UserContainer.php';

$action = Request::arg( 'action' );

switch ( $action )
{
  case 'import_citems' :
  {
    
    $dbKey = Request::arg( 'db' );
    $file  = Request::arg( 'file' );
    $start = Request::arg( 'start', 1 );
    
    $types = Request::arg( 'types' );
    
    if( !$types )
    {
      $types = array( '2' => 'mail' );
    }
    else 
    {
      
      $tmp = explode( ',' , $types);
      
      $types = array();
      
      foreach( $tmp as $tNode )
      {
        $t2 = explode( ':', $tNode );
        $types[$t2[0]] = $t2[1];
      }
      
    }
    
    if( !Fs::exists($file) )
    {
      Console::outln( "The given File: {$file} not exists" );
      exit(1);
    }
    
    User::importContactItems( $file, $types, $setupDb, $key );
    
    break;
  }
  case 'add' :
  {
    
    $dbKey = Request::arg( 'db' );
    
    $data = new UserContainer();
    $data->read();

    User::addUser( $data, $setupDb, $dbKey );

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


