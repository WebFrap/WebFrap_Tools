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
include 'gaia/core.php';

Console::header( "Start Deployment", true );

// erst mal die basis pakete installieren
$serverSoftware = new ServerSoftwareUbuntu();
$serverSoftware->install();

// erstellen des deploypathes und temppathes soweit noch nicht vorhanden
if( !Fs::exists($deployPath) )
  Fs::mkdir( $deployPath );
  
if( !Fs::exists( $tmpFolder ) )
  Fs::mkdir( $tmpFolder );

// dafür sorgend dass der tempfolder auch von der datenbank gelesen werden kann
Fs::chmod( $tmpFolder, '775' );
  
Fs::chdir( $deployPath );

if( $syncBeforeDeploy )
{
  
  if( !Fs::exists( $repoRoot ) )
    Fs::mkdir( $repoRoot );
  
  // eine Temporäre HG RC Datei erstellen, wird benötigt
  // um die Passwörter nicht in die URL packen zu müssen oder bei Proxies
  Hg::createTmpRc
  ( 
    $repoRoot,
    $syncRepos,
    $displayName,
    $repoUser,
    $repoPwd
  );
  
  Hg::checkout( $syncRepos, $repoRoot, $contactMail );
  Fs::chown( $repoRoot, $repoOwner );
}


// Module deployen
Console::outln( "Deploying the modules" );
Deploy::deployModules
( 
  $deplRepos, 
  $deployPath, 
  $sysOwner, 
  $sysAccess  
);

// Icons deployen
Console::outln( "Deploying the icon themes" );
Deploy::deployComponent
( 
  $deplIcons, 
  $deployPath, 
  $sysOwner, 
  $sysAccess 
);

// Themes deployen
Console::outln( "Deploying the themes" );
Deploy::deployComponent
( 
  $deplThemes, 
  $deployPath, 
  $sysOwner, 
  $sysAccess
);

// Webfrap Deployen
Console::outln( "Deploying WebFrap" );
Deploy::deployFw
( 
  $deplFw, 
  $deployPath, 
  $sysOwner, 
  $sysAccess
);

// Wgt Deployen
Console::outln( "Deploying WGT" );
Deploy::deployFw
( 
  $deplWgt, 
  $deployPath, 
  $sysOwner, 
  $sysAccess 
);

Fs::chown( $deployPath, $sysOwner );
Fs::chmod( $deployPath, $sysAccess );


// Gateways deployent
Console::outln( "Deploying the gateways" );
Deploy::deployGateways
( 
  $deplGateways, 
  $deplRepos,
  $deployPath, 
  $sysOwner, 
  $sysAccess
);


// Datenbanken erstellen
Console::outln( "Start Database Setup" );
Db::startSetup( $setupDb, $tmpFolder );

// Datenbank syncen
Db::syncDatabase( $deplGateways, $deployPath );
Db::finishSetup( $setupDb, $tmpFolder );


Ssl::simpleCert( $universe );
Webserver::createGwVhosts( $deplGateways, $deployPath, $universe );

Console::footer( 'Finished deployment', true );


