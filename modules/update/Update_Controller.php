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
class Update_Controller
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

    if (!$packagePath) {
      $this->do_help();

      return;
    }

    $console->info( 'Update Package '.$packagePath );

    $this->model = new Setup_Model( $this );
    $package     = $this->model->getPackage( $packagePath );

    $type        = $package->getType();

    $targetPath = $request->param( 'target', Validator_Folder::PLAIN );
    if( $targetPath )
      $package->setCodeRoot( $targetPath );

    $confKey = $request->param( 'conf_key', Validator_Text::PLAIN );
    if( $confKey )
      $package->setConfKey( $confKey );

    $serverKey = $request->param( 'server_key', Validator_Text::PLAIN );
    if( $serverKey )
      $package->setServerKey( $serverKey );

    $useGw = $request->param( 'use_gw', Validator_Text::PLAIN );
    if( $useGw )
      $package->setDeplGateway( $useGw );

    $gwName = $request->param( 'gw_name', Validator_Text::PLAIN );
    if( $gwName )
      $package->setGwName( $gwName );

    try {
      switch ($type) {
        case 'application':
        {
          $builder = new WbfUpdateApplication( $console, $package->getDataPath() );
          $builder->update( $package );
          break;
        }
        case 'app':
        {
          $builder = new WbfUpdateApplication( $console, $package->getDataPath() );
          $builder->update( $package );
          break;
        }
        default:
        {
          $console->error( "Der Pakettype: ".$type." wird von dieser Version nicht unterstützt." );
        }
      }
    } catch ( GaiaException $exc ) {
      $console->error( 'Update wurde abgebrochen '.$exc->getMessage() );
    }

    $console->info( 'Das Update wurde erfolgreich abgeschlossen '.date('Y-m-d H:i:s') );

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
gaia.php Update package=/path/to/software.package

Params:

package=/path/to/software.package

Optional:

target=/deploy/path
  Überschreiben des root_path im paket


conf_key=some.conf
  Überschreiben des conf.keys im gateway

server_key=server_name
  Es können mehrere Server definiert sein. Wenn Server key gesetzt wird, wird
  nur noch dieser eine Server verwendet.

use_gw=gw_name

gw_name=gw_name
  Überschreiben des Gateway Namens

HTML;

    $console->out( $helpText );

  }//end public function do_help */

}//end class Update_Controller */
