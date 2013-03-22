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
 * Datenbank Hilfsklasse
 * @package WebFrap
 * @subpackage Gaia
 */
class SoftwareUbuntuPostgresql
  extends SoftwareUbuntu
{
  
  
  /**
   * (non-PHPdoc)
   * @see Software::installCore()
   */
  public function installCore()
  {
    
    if ($this->isInstalled('postgresql'))
      return;
    
    $packages = array
    (
      'postgresql',
      'postgresql-common',
      'postgresql-contrib',
      'postgresql-client',
    );
    
    $this->install($packages);
    
  }//end public function installCore */

  /**
   * @return boolean
   */
  public function allreadyInstalled()
  {
    
    return $this->isInstalled('postgresql');
    
  }//end public function allreadyInstalled */
  
  
  /**
   * (non-PHPdoc)
   * @see Software::reload()
   */
  public function reload()
  {
    
    Process::execute("/etc/init.d/postgresql reload");
    
  }//end public function reload */
  
  /**
   * (non-PHPdoc)
   * @see Software::restart()
   */
  public function restart()
  {
    
    Process::execute("/etc/init.d/postgresql restart");
    
  }//end public function restart */
  
  /**
   * (non-PHPdoc)
   * @see Software::start()
   */
  public function start()
  {
    
    Process::execute("/etc/init.d/postgresql start");
    
  }//end public function start */
  
  /**
   * (non-PHPdoc)
   * @see Software::stop()
   */
  public function stop()
  {
    
    Process::execute("/etc/init.d/postgresql stop");
    
  }//end public function stop */ 
  
}//end class DbAdminPostgresql
