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
class PackageManager_Debian_Controller
  extends MvcController
{
  
  /**
   * 
   */
  public function do_default()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $workarea = $console->tpl->getWorkArea();
    $workarea->setCaption('Debian Packages');
    
    $workarea->addTemplate('package/manager/debian/package_form');
    
  }//end public function do_default */

  /**
   * 
   */
  public function do_buildPackage()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $workarea = $console->tpl->getWorkArea();
    $workarea->setCaption('Build Package');
    
    $workarea->addTemplate('package/manager/debian/package_form');
    
  }//end public function do_buildPackage */
  
}//end class PackageManager_Controller */
