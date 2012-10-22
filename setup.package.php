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

// definieren, dass dies ein Syncscript ist
define( 'GAIA_CONTEXT', 'setup' );


// die Basis Logik einbinden
include 'gaia/bootstrap.cli.php';

/* @var $console UiConsole  */

$packagePath = Request::arg( 'package' );

$tmp = null;


// wenn ein package name übergeben wurde, wird dieses package installiert
if( $packagePath )
{
  
  if( !Fs::exists( $packagePath ) )
  {
    $console->error( "Konnte kein Paket unter ".$packagePath.' finden.' );
  }
  
  $archive = new ArchiveZip( $packagePath, ArchiveZip::MODE_HUGE );
  $tmp     = Gaia::mkTmpFolder();
  $archive->unpack( $tmp );
  
  $package = new Package( $tmp.'package.bdl' );
  
  if( !$package->isLoaded() )
  {
    $console->error( 'Konnte die '.$tmp.'package.bdl nicht laden' );
    exit(1);
  }
  
  $package->setDataPath( $tmp );
  
}
else 
{
  $package = new Package( GAIA_PATH.'conf/package.bdl' );
  
  if( !$package->isLoaded() )
  {
    $console->error( 'Konnte die '.GAIA_PATH.'conf/package.bdl nicht laden' );
    exit(1);
  }
}

$type     = $package->getType();

try 
{
  switch( $type )
  {
    case 'patch':
    {
      $builder = new WbfSetupPatch();
      $builder->patch( $package );
      
      break;
    }
    case 'update':
    {
      break;
    }
    case 'application':
    {
      $builder = new WbfSetupApplication( $console, $package->getDataPath() );
      $builder->setup( $package );
      break;
    }
    case 'app':
    {
      $builder = new WbfSetupApplication( $console, $package->getDataPath() );
      $builder->setup( $package );
      break;
    }
    case 'module':
    {
      break;
    }
    default:
    {
      $console->error( "Der pakettype: ".$type." wird von dieser Version nicht unterstützt." );
    }
  }
}
catch( GaiaException $exc )
{
  $console->error( 'Installation wurde abgebrochen '.$exc->getMessage() );
}

// tmp löschen
Fs::del( GAIA_PATH.'tmp' );


