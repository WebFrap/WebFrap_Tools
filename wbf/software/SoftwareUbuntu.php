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
 * Datenbank Hilfsklasse
 * @package WebFrap
 * @subpackage Gaia
 */
class SoftwareUbuntu
  extends Software
{
  
  
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
    
    if( $package == $tmp[0] )
    {
      if( 'install' == $tmp[1]  )
        return true;
    }
    
    return false;

  }//end public function isInstalled */
  

}//end class SoftwareUbuntu
