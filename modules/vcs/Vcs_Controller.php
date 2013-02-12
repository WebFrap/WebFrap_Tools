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
class Vcs_Controller
  extends MvcController
{
  
  /**
   * Views cleanen
   */
  public function do_switchTo( )
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $confKey = $request->param( 'conf', Validator_File::PLAIN );
    $branch  = $request->param( 'branch', Validator_Text::CKEY );
    
    $console->info( "Switch to branch: ".$branch );

    $model = new Vcs_Model( $this );
    $model->loadConf( $confKey );

    $model->switchToBranch( $branch );
    
    $console->info( "Done" );
    
  }//end public function do_setTesting */
  
  /**
   * Views cleanen
   */
  public function do_setTesting()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $confKey = $request->param( 'conf', Validator_File::PLAIN );
    
    $console->info( "Merge Development to Testing" );

    $model = new Vcs_Model( $this );
    $model->loadConf( $confKey );
    $model->setTesting(  );
    
    $console->info( "Done" );
    
  }//end public function do_setTesting */
  
  /**
   * Views cleanen
   */
  public function do_setStable()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $confKey = $request->param( 'conf', Validator_File::PLAIN );
    
    $console->info( "Merge Testing to Stable" );

    $model = new Vcs_Model( $this );
    $model->loadConf( $confKey );
    $model->setStable(  );
    
    $console->info( "Done" );

    
  }//end public function do_setStable */

  /**
   * 
   */
  public function do_help()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();
    
    $helpText = <<<HTML
gaia.php Vcs switchTo branch=branch_name conf=key

gaia.php Vcs setTesting conf=key

gaia.php Vcs setStable conf=key

HTML;

    $console->out( $helpText );

    
  }//end public function do_help */
  
}//end class Update_Controller */
