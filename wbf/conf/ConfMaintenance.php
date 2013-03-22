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
class ConfMaintenance
  extends TArray
{
  
  /**
   * Datenbank Verbindungen
   * @var array
   */
  public $databases = array
  (
    /*
    'default' => array
    (
      'type' => '',
      'host' => '',
      'port' => '',
      'db_name' => '',
      'schema_name' => '',
      'user_name' => '',
      'passwd' => '',
      'ssl' => true,
    )
    */
  );
  
  /**
   * Pfad zum workspace
   * Wenn nicht anders definiert dann wird der Root path als Workspace verwendet
   * 
   * @var string
   */
  public $workspace = PATH_ROOT;
  
  /**
   * Name des Users welcher in Logs angezeigt werden soll
   * 
   * Default ist Gaia, sollte jedoch angepasst werden
   * 
   * @var array
   */
  public $displayUser = 'Gaia';
  
  /**
   * Code Repositories
   * @var array
   */
  public $repositories = array
  (
    /*
    'Mercurial_Test' => array
    (
      'type' => 'Mercurial',
      'path' => '/var/www/workspace/Mercurial_Test/',
      'development_branch' => 'development',
      'testing_branch'     => 'testing',
      'stable_branch'      => 'stable',
    )
    */
  );
  
  
  /**
   * @param string $path
   * @throws GaiaException Wenn der Conf Pfad nicht vorhanden ist
   */
  public function load( $path )
  {
    
    $conf = $this;
    
    // erst mal potentiell alte confs leeren
    $this->databases     = array();
    
    if ( !Fs::pathIsAbsolute( $path ) )
    {
      $path = GAIA_PATH.'conf/conf.'.$path.'.php';
    }
    
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
  
////////////////////////////////////////////////////////////////////////////////
// Getter & setter 
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $key
   * @return 
   */
  public function getDbConf( $key = 'default' )
  {
    
    if ( !isset( $this->databases[$key] ) )
      return array();
    
    $conf = $this->databases[$key];
    
    return new TArray( $conf );
    
  }//end public function getDbConf */
  
////////////////////////////////////////////////////////////////////////////////
// Repositories
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return array
   */
  public function getRepositories(  )
  {
    
    return $this->repositories;
    
  }//end public function getRepositories */

} // end class ConfMaintenance


