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

Console::header( "Start Deployment", true);


Fs::chdir( $deployPath );

if ( $syncBeforeDeploy )
{
  
  Console::outln( "Sync before deployment" );
  if ( !Fs::exists( $repoRoot ) )
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
Console::outln( "Start Database Deployment" );
// Datenbank syncen
Db::syncDatabase( $deplGateways, $deployPath );


Console::footer( 'Finished deployment', true );


