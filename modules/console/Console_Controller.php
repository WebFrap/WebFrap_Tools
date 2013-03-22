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
class Console_Controller
  extends MvcController
{
  
  /**
   * 
   */
  public function do_default()
  {

    $request = $this->getRequest();
    $console = $this->getConsole();

    while( $command = trim($console->in()) )
    {
      
      if ( Gaia::C_QUIT == $command )
      {
        if ( !$request->flag('s') )
        {
          $console->out( 'Good night' );
        }
        exit(0);
      }
    
      $subRequest = new RequestSubCli( $command, $request );
    
      $conClass = $subRequest->service.'_Controller';
      
      if ( Gaia::classLoadable( $conClass ) )
      {
        $controller = new $conClass();
        /* @var $controller MvcController   */
        $controller->setRequest( $subRequest );
        $controller->setConsole( $console );
        
        try 
        {
          $controller->execute( $subRequest->action );
        }
        catch( GaiaException $exc )
        {
          $console->error( $exc->getMessage() );
        }
      }
      else 
      {
        $controller = new Error_Controller();
        /* @var $controller MvcController   */
        $controller->setRequest( $subRequest );
        $controller->setConsole( $console );
        
        try 
        {
          $controller->missingService( $subRequest->service );
        }
        catch( GaiaException $exc )
        {
          $console->error( $exc->getMessage() );
        }
      }
    
    }//end while
    
  }//end public function do_default */

}//end class Version_Controller */
