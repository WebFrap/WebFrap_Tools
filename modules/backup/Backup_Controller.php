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
class Backup_Controller
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
    

    $this->model = new Setup_Model( $this );
    $package     = $this->model->getPackageNode( $packagePath );
    
    $console->info( 'Backup Package '.$package->getName() );

    $backupEngine = new BackupGateway();
    $backupEngine->backupByPackage( $package );
    
    $console->info( 'Das Backup wurde erfolgreich abgeschlossen '.date('Y-m-d H:i:s') );
    
    $this->model->cleanTmp();
    
  }//end public function do_default */

}//end class Backup_Controller */
