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
class PackageManager_Patch_Controller
  extends MvcController
{
  
  /**
   * 
   */
  public function do_default()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $workarea = $console->tpl->getWorkArea( );
    $workarea->setCaption( 'Patch' );
    
    $workarea->addTemplate( 'package/manager/patch/package_form' );
    
  }//end public function do_default */

  /**
   * 
   */
  public function do_buildByJson()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $workarea = $console->tpl->getWorkArea( );
    $workarea->setCaption( 'Build Patch' );
    $workarea->addTemplate( 'package/manager/patch/package_form' );

    $jsonRaw = $request->data( 'json_raw' );
    $noData = $request->data( 'no_data', Validator::BOOLEAN );
    
    $jsonData = json_decode( $jsonRaw );
    
    if ( JSON_ERROR_NONE !== json_last_error() )
      throw new RequestInvalid_Exception("JSON was invalid ".json_last_error() );
    
    Console::startCache();
      
    $model = new PackageManager_Patch_Model( $this );
    
    if ( $noData )
      $model->noData = true;
    
    $model->readJson( $jsonData );
    $model->buildPackage( );
    
    $workarea->vars->message = Console::getCache();
    
  }//end public function do_buildPackage */
  
}//end class PackageManager_Controller */
