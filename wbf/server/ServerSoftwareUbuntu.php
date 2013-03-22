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
class ServerSoftwareUbuntu
{
////////////////////////////////////////////////////////////////////////////////
// Input Daten
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var array
   */
  public $requiredPackages = array
  (
    // tools
    'vim',
  
    // java
    'openjdk-6-jdk',
  
    // dbms
    'postgresql',
    'postgresql-common',
    'postgresql-contrib',
  
    // mailserver
    'postfix',
  
    // apache
    'apache2-mpm-prefork',
    'libapache2-mod-php5',
    
    // php 5
    'php5-common',
    'php5-curl',
    'php5-gd',
    'php5-imagick',
    'php5-imap',
    'php5-mcrypt',
    'php5-pgsql',
    'php5-memcache',
    'php5-xdebug',
    'php5-suhosin',
    'php-apc',

    // mercurial
    'mercurial',
    'mercurial-common',

  );
  
  /**
   * 
   */
  public function install()
  {
    
    Server::install($this->requiredPackages);
    
  }//end public function install */
  
}//end class ServerSoftwareUbuntu */
