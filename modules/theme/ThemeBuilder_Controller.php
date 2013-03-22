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
class ThemeBuilder_Controller
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
    $workarea->setCaption('Theme Builder');
    
    $workarea->addTemplate('theme/form');
    
  }//end public function do_default */
  
  /**
   * 
   */
  public function do_render()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $workarea = $console->tpl->getWorkArea('Css');
    
    $workarea->addTemplate('theme/theme_content');
    
  }//end public function do_render */

}//end class Welcome_Controller */
