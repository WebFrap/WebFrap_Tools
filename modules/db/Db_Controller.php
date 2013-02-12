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
class Db_Controller
  extends MvcController
{

  /**
   * Views cleanen
   */
  public function do_cleanSchemaViews()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();

    $confKey = $request->param('conf');

    $console->out( $confKey );

    $model = new Db_Model( $this );
    $model->init( $confKey );

    $model->cleanSchemaViews();

  }//end public function do_cleanAllViews */

  /**
   *
   */
  public function do_help()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();

    $helpText = <<<HTML
gaia.php cleanSchemaViews conf=key

HTML;

    $console->out( $helpText );

  }//end public function do_help */

}//end class Update_Controller */
