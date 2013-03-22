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
class Db_Model
  extends MvcModel
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var ConfMaintenance
   */
  public $conf = null;
  
  /**
   * @var DbPostgresql
   */
  public $db = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param string $confKey
   */
  public function init( $confKey )
  {
    
    $this->conf = $this->getConf( $confKey );
    $this->getDb( $this->conf );
    
  }//end public function init */
  
  /**
   * @param string $confKey
   * @return ConfMaintenance
   */
  public function getConf( $confKey )
  {
    
    $conf = new ConfMaintenance();
    $conf->load( $confKey );
    
    return $conf;
    
  }//end public function getConf */
  
  /**
   * @param ConfMaintenance $conf
   * @return DbPostgresql
   */
  public function getDb( ConfMaintenance $conf )
  {
    
    if ( !$this->db )
    {
      
      $dbConf = $conf->getDbConf( 'default' );
      
      if ( $dbConf )
      {
        
        $className = 'Db'.ucfirst( $dbConf->type );
        
        if ( !Gaia::classLoadable( $className ) )
          throw new GaiaException( "Requested nonexisting DB Adapter ".$dbConf->type );
        
        $this->db = new $className
        ( 
          $this->getConsole(), 
          $dbConf->db_name, 
          $dbConf->user_name, 
          $dbConf->passwd,
          $dbConf->host,
          $dbConf->port,
          $dbConf->schema_name
        );
      }
    }
    
    return $this->db;
    
  }//end public function getDb */
  
////////////////////////////////////////////////////////////////////////////////
// DB Logic
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * 
   */
  public function cleanSchemaViews()
  {
    
    $dbAdmin = $this->db->getDbAdmin();
    $dbConf  = $this->conf->getDbConf( 'default' );
    
    $dbAdmin->dropSchemaViews( $dbConf->db_name , $dbConf->schema_name );
    
  }//end public function cleanViews */

}//end class Db_Model */
