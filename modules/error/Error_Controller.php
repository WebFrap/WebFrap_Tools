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
class Error_Controller
  extends MvcController
{
  
  /**
   * 
   */
  public function missingService($servName)
  {

    $request = $this->getRequest();
    $console = $this->getConsole();

    $console->error('Missing Service '.$servName);
    
  }//end public function missingService */
  
  /**
   * 
   */
  public function do_default()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();

    $console->info('Gaia Version: '. Gaia::VERSION);
    
  }//end public function do_default */

}//end class Version_Controller */
