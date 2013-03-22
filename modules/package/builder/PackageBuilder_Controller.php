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
class PackageBuilder_Controller
  extends MvcController
{
  
  /**
   * 
   */
  public function do_default()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $packagePath = $request->param( 'package', Validator_Text::PLAIN );
    
    $targetPath = $request->param( 'target', Validator_Text::PLAIN );
    
    if ( !$packagePath || !$targetPath )
    {
      $this->do_help();
      return;
    }

    $codeRoot = $request->param( 'root', Validator_Text::PLAIN );
    if ( !$codeRoot )
      $codeRoot = PATH_ROOT;
    
    $packageKey = $request->param( 'key', Validator_Text::PLAIN );
    if ( !$packageKey )
      $packageKey = date('YmdHis');
    

    $this->model = new PackageBuilder_Model( $this );
    
    $console->info( 'Baue Paket: '.$packagePath );

    $this->model->buildPackage( $packagePath, $packageKey, $targetPath, $codeRoot );
    
    $console->info( 'Das Paket '.$packagePath.' wurde erfolgreich gebaut '.date('Y-m-d H:i:s') );
    
    $this->model->cleanTmp();
    
  }//end public function do_default */
  
  /**
   * 
   */
  public function do_help()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $helpText = <<<HTML
gaia.php PackageBuilder package=/path/to/software.package target=/fuu/bar

Params:

package=/path/to/software.package
  die package bdl.

target=/path/to/the/new/package
  Pfad in welches das paket geschrieben wird

Optional:

root=/deploy/path   
  Überschreiben des root_path im paket
  
key=package_key    
  Key für das package, wenn nicht gesetzt wird das aktuelle datum verwendet
  
HTML;

    $console->out( $helpText );

    
  }//end public function do_help */

}//end class PackageBuilder_Controller */
