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
class SoftwareUbuntuDovecot
  extends SoftwareUbuntu
{
  
  
  /**
   * (non-PHPdoc)
   * @see Software::installCore()
   */
  public function installCore()
  {

    $packages = array
    (
      'dovecot-common',
      'dovecot-imapd',
      'dovecot-pop3d',
    );
    
    $this->install();
    
  }//end public function installCore */
  
  /**
   * @param PackageServerMail $mailConf
   */
  public function setupConf($mailConf)
  {
    
    // setup 
    if (!Fs::exists(SYS_ROOT.'var/wbf_mail'))
    {
      Fs::mkdir(SYS_ROOT.'var/wbf_mail', 0771);
      
      $subDirs = explode(' ', "0 1 2 3 4 5 6 7 8 9 a b c d e f g h i j k l m n o p q r s t u v w x y z");
      
      foreach($subDirs as $dirName)
      {
        Fs::mkdir(SYS_ROOT.'var/wbf_mail/'.$dirName, 0751);
      }
      Fs::chgrp(SYS_ROOT.'var/wbf_mail', 'mail');
    }
    
  }//end public function install */

  /**
   * (non-PHPdoc)
   * @see Software::reload()
   */
  public function reload()
  {
    
    Process::execute("/etc/init.d/dovecot reload");
    
  }//end public function reload */
  
  /**
   * (non-PHPdoc)
   * @see Software::restart()
   */
  public function restart()
  {
    
    Process::execute("/etc/init.d/dovecot restart");
    
  }//end public function restart */
  
  /**
   * (non-PHPdoc)
   * @see Software::start()
   */
  public function start()
  {
    
    Process::execute("/etc/init.d/dovecot start");
    
  }//end public function start */
  
  /**
   * (non-PHPdoc)
   * @see Software::stop()
   */
  public function stop()
  {
    
    Process::execute("/etc/init.d/dovecot stop");
    
  }//end public function stop */ 
  
}//end class SoftwareUbuntuDovecot
