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
class WbfSetupUniverse
  extends WbfSetup
{

  /**
   * @param Package $package
   * @param UiConsole $console
   */
  public function setup( $package, $console )
  {
    
    $gateways = $package->getGateway();
    
  }//end public function setup */
  
  /**
   * @param PackageGateway $gateway
   */
  protected function setupGateway( $gateway )
  {
    
  }//end protected function setupGateway */
  
} // end class WbfSetup


