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
class EnvironmentCore
{
  
  /**
   * @var EnvironmentCore
   */
  public $env = null;
  
  /**
   * @var IsARequest
   */
  public $request = null;

  /**
   * @var IsAConsole
   */
  public $console = null;
  
////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param EnvironmentCore $env
   */
  public function __construct( $env = null )
  {
    
    $this->env = $env;
    
  }//end public function __construct */
  
////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return IsARequest
   */
  public function getRequest()
  {
    
    if( !$this->request )
    {
      if( $this->env )
        $this->request = $this->env->getRequest();
      else
        $this->request = Request::getActive();
    }
      
    return $this->request;
    
  }//end public function getRequest */

  /**
   * @param IsARequest $request
   */
  public function setRequest( IsARequest $request )
  {
    
    $this->request = $request;
    
  }//end public function setRequest */
  
  /**
   * @return IsAConsole
   */
  public function getConsole()
  {
    
    if( !$this->console )
    {
      if( $this->env )
        $this->console = $this->env->getConsole();
      else
        $this->console = Console::getActive();
    }

    return $this->console;
    
  }//end public function getConsole */

  /**
   * @param IsAConsole $console
   */
  public function setConsole( IsAConsole $console )
  {
    
    $this->console = $console;
    
  }//end public function setConsole */

}// end class EnvironmentCore


