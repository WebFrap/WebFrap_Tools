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
 * Klasse zum entpacken von Archiven
 * @package WebFrap
 * @subpackage Gaia
 */
class Software
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////// 

  protected $console = null;
  
////////////////////////////////////////////////////////////////////////////////
// Static Methodes
//////////////////////////////////////////////////////////////////////////////// 

  /**
   * Parsen der Configuration
   * @param string $fileType
   */
  public static function getInstaller( $installerType )
  {
    
    $className = 'Software'.ucfirst(Environment::$osName).$installerType;
    
    $osName = Environment::$osName;
    
    if ( !Gaia::classLoadable($className) )
      throw new GaiaException( "Für das aktuelle Environment {$osName} existiert leider kein Installer: {$installerType}" );
      
    return new $className( UiConsole::getActive() );
    
  }//end public function getInstaller */
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////// 

  /**
   * @param UiConsole $console
   */
  public function __construct( $console )
  {
    $this->console = $console;
  }//end public function __construct */
  
  
  /**
   * Parsen der Configuration
   * @param string $fileType
   */
  public function parseConf( $fileType = null )
  {
    
  }//end public function parseConf */
  
  /**
   * @param array $packages
   */
  public function install( $packages )
  {
    Process::system( 'apt-get -y install '.implode( ' ', $packages ) );
  }//end public function install */
  
  /**
   * @param string $package
   */
  public function isInstalled( $package )
  {
    
    $packageKey = Process::execute( 'dpkg --get-selections '.$package );

    $tmp = explode( "\t", $packageKey );
    
    if ( $package == $tmp[0] )
    {
      if ( 'install' == $tmp[1]  )
        return true;
    }
    
    return false;

  }//end public function isInstalled */
  

  /**
   * Prüfen ob die applikation überhaupt schon installiert ist
   * @return boolean
   */
  public function allreadyInstalled()
  {
    return true;
  }//end public function allreadyInstalled */
  
  /**
   */
  public function installCore( )
  {
    
  }//end public function installCore */
  
  /**
   * Ein bestimmtes Modul für die Software installieren
   * @param string $modName
   */
  public function installModule( $modName )
  {
  }//end public function installModule */
  
  /**
   * 
   */
  public function setupConf()
  {
    
  }//end public function setupConf */
  
  /**
   * Die Konfiguration eines dienstes neu laden
   */
  public function reload( )
  {
  }//end public function reload */
  
  /**
   * Einen bestimmten Dienst neu starten
   */
  public function restart( )
  {
  }//end public function restart */
  
  /**
   * Den Dienst starten
   */
  public function start( )
  {
  }//end public function start */
  
  /**
   * Den Dienst beenden
   */
  public function stop( )
  {
  }//end public function stop */ 

}//end class Admin */
