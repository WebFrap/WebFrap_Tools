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

/**
 * @package WebFrap
 * @subpackage Gaia
 */
class Environment
{
  
  /**
   * Os Familie des aktuellen betriebsystems
   * zb, linux, windows, crapple etc.
   * @var string
   */
  public static $sapi = PHP_SAPI;
  
  /**
   * Os Familie des aktuellen betriebsystems
   * zb, linux, windows, crapple etc.
   * @var string
   */
  public static $osFamily = null;
  
  /**
   * Name des aktuellen betriebsystems
   * @var string
   */
  public static $osName = null;
  
  /**
   * Version des aktuellen Betriebsystems
   * @var string
   */
  public static $osVersion = null;
  
  /**
   * Version des aktuellen Betriebsystems
   * @var string
   */
  public static $osMinorVersion = null;
  
  /**
   * Version des aktuellen Betriebsystems
   * @var string
   */
  public static $osRevision = null;
  
  /**
   * Die Art der Architektur des Betriebsystems
   * @var string
   */
  public static $architecture = null;
  
  /**
   * Flag ob der aktuelle User Rootrechte hat
   * @var bolean
   */
  public static $isRoot = false;

  /**
   * Erraten des aktuellen Betriebsystems
   * @return string
   */
  public static function guessOsData()
  {
    
    self::$osFamily     = php_uname('s');
    self::$architecture = php_uname('m');
    
    // check ob wir root sind
    self::$isRoot = '0' ==  Process::execute("echo \$EUID") 
      ?true
      :false;
    
    if (Fs::exists('/etc/issue'))
    {
      self::$osName = 'ubuntu';
      
      $osInfo = Fs::read('/etc/issue');
      
      $parts  = explode(' ', $osInfo); 
      
      $versions = explode('.', $parts[1]);
      
      self::$osVersion      = $versions[0];
      self::$osMinorVersion = isset($versions[1])?$versions[1]:0;
      self::$osRevision     = isset($versions[2])?$versions[2]:0;
      
      return;
    }
    
    /*
Novell SuSE---> /etc/SuSE-release 
Red Hat--->/etc/redhat-release, /etc/redhat_version
Fedora-->/etc/fedora-release
Slackware--->/etc/slackware-release, /etc/slackware-version
Debian--->/etc/debian_release, /etc/debian_version
Mandrake--->/etc/mandrake-release
Yellow dog-->/etc/yellowdog-release
Sun JDS--->/etc/sun-release 
Solaris/Sparc--->/etc/release 
Gentoo--->/etc/gentoo-release
     */
    
  }//end public static function guessOsData */

} // end class Environment


