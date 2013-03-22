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
class SetupProject_Controller
  extends MvcController
{
  
  /**
   * @var Setup_Model
   */
  public $model = null;
  
  /**
   * 
   */
  public function do_default()
  {
    
    $request = $this->getRequest();
    $console = $this->getConsole();
  
    $workarea = $console->tpl->getWorkArea();
    $workarea->setCaption('Setup Project');
    $workarea->addTemplate('setup/project/project_form');

  }//end public function do_default */
  
 

}//end class Setup_Controller */
