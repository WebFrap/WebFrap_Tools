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
class Refactorer_Controller
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
    $workarea->setCaption( 'Refactoring' );
    $workarea->addTemplate( 'refactorer/form' );
    
  }//end public function do_default */
  
  /**
   * 
   */
  public function do_refactoring()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $search  = $_POST['search']; //  $request->data('search', Validator::RAW);
    $replace = $_POST['replace']; //  $request->data('replace', Validator::RAW);
    $path    = $_POST['path']; //  $request->data('path', Validator::RAW);
    $ending  = $_POST['ending']; //  $request->data('ending', Validator::RAW);
    
    if( $path )
    {
      $model = new Refactorer_Model();
      $files = $model->refactor( $search, $replace, PATH_ROOT.$path.'/', $ending );
    }
    else 
    {
      $files = '';
    }
    
    $workarea = $console->tpl->getWorkArea( );
    $workarea->vars->search   = $search;
    $workarea->vars->replace  = $replace;
    $workarea->vars->path     = $path;
    $workarea->vars->ending   = $ending;
    $workarea->vars->files    = $files;
    $workarea->setCaption( 'Refactoring' );
    $workarea->addTemplate( 'refactorer/protocol' );
    
  }//end public function do_default */

}//end class Refactorer_Controller */
