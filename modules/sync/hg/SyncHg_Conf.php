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
class SyncHg_Conf
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $userName = null;
  
  /**
   * @var string
   */
  public $userPwd = null;
  
  /**
   * @var string
   */
  public $displayName = null;

  /**
   * @var array
   */
  public $repos = array
  (
    'core' => array
    (
      'path'  => 'hg.webfrap-servers.de/core/',
      'user'  => '',
      'pwd'   => '',
      'nodes' => array
      (
        'WebFrap',
        'WebFrap_Gaia',
      )
    ) 
  );
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param string $path
   */
  public function load( $path )
  {
    
    // erst mal potentiell alte confs leeren
    $this->userName     = null;
    $this->userPwd      = null;
    $this->displayName  = null;
    $this->repos        = array();
    
    if ( Fs::exists( $path ) )
    {
      
      $error = null;
      
      if ( Gaia::checkSyntax( $path, $error ) )
      {
        include $path;
      }
      else 
      {
        throw new GaiaException( "Requested Conf {$path} was invalid ".$error );
      }
    }
    else 
    {
      throw new GaiaException( "Requested Conf {$path} not exists." );
    }

  }//end public function load */

}//end class SyncHg_Conf */
