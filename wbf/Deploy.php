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

///
/// NEIN, DIES DATEI ERHEBT NICHT DEN ANSPRUCH OOP ZU SEIN.
/// ES IS EXPLIZIT AUCH NICHT ALS OOP GEWOLLT. 
/// DIE KLASSEN WERDEN LEDIGLICH ALS CONTAINER ZUM ORGANISIEREN DER FUNKTIONEN VERWENDET. 
/// JA DAS IST VIEL CODE FÜR EINE DATEI, NEIN ES IST KEIN PROBLEM
/// NEIN ES IST WIRKLICH KEIN PROBLEM, SOLLTE ES DOCH ZU EINEM WERDEN WIRD ES
/// GELÖST SOBALD ES EINS IST
/// Danke ;-)
///

/**
 * @package WebFrap
 * @subpackage Gaia
 */
class Deploy
{
  
  /**
   * Methode zum deployen der Repositories
   * 
   * @param array $repos
   * @param string $deployPath
   * @param string $owner
   * @param string $access
   */
  public static function deployModules
  ( 
    $repos, 
    $deployPath, 
    $owner, 
    $access = '775',
    $fastDepl = false  
  )
  {
    
    // erst mal alle projekte kopieren
    foreach( $repos as $packageName => $modules )
    {
      
      // leere module ignorieren werden nur für die Gateways benötigt
      if( !count($modules) )
        continue;
      
      // alten code komplett löschen
      if( $fastDepl )
      {
        Fs::del( $deployPath.$packageName );
      }
      
      // bei bedarf erst mal erstellen
      if( !Fs::exists($deployPath.$packageName) )
        Fs::mkdir( $deployPath.$packageName );
    
      // deployen
      foreach ( $modules as $module => $modData )
      {
        Fs::chdir( "{$modData['path']}/{$module}" );
        Hg::update( (isset($modPath['rev'])?$modPath['rev']:null)  );
        Hg::archive( "{$deployPath}{$packageName}" );
      }
    
      Fs::chown( $deployPath.$packageName, $owner );
      Fs::chmod( $deployPath.$packageName, $access );
    
    }
    
  }//end public static function deployModules */
  
  /**
   * Methode zum deployen der Repositories
   * 
   * @param array $repos
   * @param string $deployPath
   * @param string $owner
   * @param string $access
   */
  public static function deployComponent
  ( 
    $repos, 
    $deployPath, 
    $owner, 
    $access   = '775',
    $fastDepl = false
  )
  {
    
    foreach( $repos as $deplKey => $modules )
    {
      // Zielprojekt erst mal cleanen
      if( $fastDepl )
        Fs::del( $deployPath.$deplKey );
      
      foreach( $modules as $module )
      {
        Fs::chdir( $module['src'] );
        
        Hg::update( (isset($module['rev'])?$module['rev']:null)  );
        Hg::archive( $deployPath.$deplKey );
      }
      
      Fs::chown( $deployPath.$deplKey, $owner );
      Fs::chmod( $deployPath.$deplKey, $access );
    }
    
  }//end public static function deployComponent */
  
  /**
   * Methode zum deployen der Repositories
   * 
   * @param array $repos
   * @param string $deployPath
   * @param string $owner
   * @param string $access
   */
  public static function deployFw
  ( 
    $repo, 
    $deployPath, 
    $owner, 
    $access   = '770',
    $fastDepl = false
  )
  {
    
    // Zielprojekt erst mal cleanen
    if( $fastDepl )
      Fs::del( $deployPath.$repo['name'] );
    
    Fs::chdir( $repo['src'] );
    
    Hg::update( (isset($repo['rev'])?$repo['rev']:null)  );
    Hg::archive( $deployPath.$repo['name'] );
    
    Fs::chown( $deployPath.$repo['name'], $owner );
    Fs::chmod( $deployPath.$repo['name'], $access );
    
  }//end public static function deployFw */
  
  /**
   * Spezielle Methode zum deployen der Gateways
   * 
   * @param array $repos
   */
  public static function deployGateways
  ( 
    $gwRepos, 
    $deplRepos,
    $deployPath, 
    $owner, 
    $access = '775',
    $fastDepl = false  
  )
  {
    
    foreach( $gwRepos as $gatewayProject )
    {
      
      // copy gateway
      Fs::chdir( $gatewayProject['src'] );
      Hg::update( (isset($gatewayProject['rev'])?$gatewayProject['rev']:null) );
      Hg::archive( "{$deployPath}{$gatewayProject['name']}" );
      
      // inlcude im gateway leeren
      Fs::del( $deployPath.$gatewayProject['name'].'/conf/include/gmod/*' );
      Fs::del( $deployPath.$gatewayProject['name'].'/conf/include/develop/*' );
      Fs::del( $deployPath.$gatewayProject['name'].'/conf/include/module/*' );
      Fs::del( $deployPath.$gatewayProject['name'].'/conf/include/metadata/*' );
      
      // im gateway die module die einzubinden sind anlegen
      $modules = array_keys($deplRepos);
      
      foreach( $modules as $projectName  )
      {
        Fs::touch( $deployPath.$gatewayProject['name'].'/conf/include/module/'.$projectName );
        Fs::touch( $deployPath.$gatewayProject['name'].'/conf/include/gmod/'.$projectName );
        Fs::touch( $deployPath.$gatewayProject['name'].'/conf/include/metadata/'.$projectName );
      }
      
      // wenn angegeben eine spezielle konfiguration laden
      if( isset($gatewayProject['conf']) )
      {
        if( Fs::exists( $deployPath.$gatewayProject['name'].'/conf/space/'.$gatewayProject['conf'].'/' ) )
        {
          // copy the conf files
          Fs::copy
          (
            $deployPath.$gatewayProject['name'].'/conf/space/'.$gatewayProject['conf'].'/*',
            $deployPath.$gatewayProject['name'].'/conf/',
            false
          );
        }
        else 
        {
          Console::error
          ( 
            "Es wurde explizit eine Konfiguration für das Gateway: {$gatewayProject['name']} gesetzt.
            Für diese Konfiguration existieren jedoch keine Daten. Daher wird das Gateway sehr wahrscheinlich nicht benutzbar sein.
            Bitte eine andere Konfiguration wählen, oder die gewünschte definieren." 
          );
        }
      }
      
      
      // Die session leeren
      Fs::del( $deployPath.$gatewayProject['name'].'/tmp/session/' );
      Fs::mkdir( $deployPath.$gatewayProject['name'].'/tmp/session/' );
      
      // cache leeren
      Fs::del( $deployPath.$gatewayProject['name'].'/cache/' );
      
    }
    
  }//end public static function deployGateway */
  
}//end class Deploy */
