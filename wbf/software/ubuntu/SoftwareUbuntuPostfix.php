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
class SoftwareUbuntuPostfix
  extends SoftwareUbuntu
{
  
  
  /**
   */
  public function installCore( )
  {
  
    $packages = array
    (
      'postfix',
      'postfix-pgsql',
    );
    
    $this->install( $packages );
    
  }//end public function installCore */

  
  
  /**
   */
  public function reload( )
  {
    
    Process::execute( "/etc/init.d/postfix reload" );
    
  }//end public function reload */
  
  /**
   */
  public function restart( )
  {
    
    Process::execute( "/etc/init.d/postfix restart" );
    
  }//end public function restart */
  
  /**
   */
  public function start( )
  {
    
    Process::execute( "/etc/init.d/postfix start" );
    
  }//end public function start */
  
  /**
   */
  public function stop( )
  {
    
    Process::execute( "/etc/init.d/postfix stop" );
    
  }//end public function stop */ 
  
}//end class SoftwareUbuntuPostfix
