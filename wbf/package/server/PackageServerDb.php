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
class PackageServerDb
  extends XmlNode
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var Db_Connection
   */
  public $con = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function installServer()
  {
    $val = $this->getAttribute('install');
    
    return ( 'true' == $val );
    
  }//end public function installServer */
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->getAttribute('name');
  }//end public function getName */
  
  /**
   * @return string
   */
  public function getType()
  {
    return $this->getAttribute('type');
  }//end public function getType */

  
////////////////////////////////////////////////////////////////////////////////
// Get Admin Data
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getAdminUser()
  {
    return $this->getNodeValue('admin/user');
  }//end public function getAdminUser */
  
  /**
   * @return string
   */
  public function getAdminPwd()
  {
    return $this->getNodeValue('admin/passwd');
  }//end public function getAdminPwd */
  
////////////////////////////////////////////////////////////////////////////////
// Connection Infos
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getHost()
  {
    $address = $this->getNodeAttr('../..','address');
    
    if ( !$address )
    {
      $hostType = $this->getNodeAttr('../..','type');
      
      if (  $hostType && 'local' != $hostType )
      {
        throw new PackageException( 'Host ist nicht lokal. Hat aber keine Addresse' );
      }
      else 
      {
        return '127.0.0.1';
      }
      
    }
    
    return $address;
    
  }//end public function getHost */
  
  /**
   * @return string
   */
  public function getPort()
  {
    
    $port = $this->getNodeAttr('connection','port');
    
    if ( !$port )
    {
      $port = '5432';
    }
    
    return $port;
    
  }//end public function getPort */
  
  /**
   * @return string
   */
  public function getDbName()
  {

    return $this->getNodeAttr('connection','db_name');
    
  }//end public function getDbName */
  
  /**
   * @return string
   */
  public function getDbSchema()
  {

    return $this->getNodeAttr('connection','db_schema');
    
  }//end public function getDbSchema */
  
  /**
   * @return string
   */
  public function getDbUser()
  {
    return $this->getNodeValue('connection/user');
  }//end public function getDbUser */
  
  /**
   * @return string
   */
  public function getDbPwd()
  {
    return $this->getNodeValue('connection/passwd');
  }//end public function getDbPwd */
  
////////////////////////////////////////////////////////////////////////////////
// Structure Files
////////////////////////////////////////////////////////////////////////////////

  /**
   * Einen potentiell vorhandenen Dump erfragen
   * @return string
   */
  public function getDumpFile()
  {

    $dumpFile = $this->getNodeAttr( 'structure/dump', 'name' );
    return $dumpFile;
    
  }//end public function getDumpFile */
  
  /**
   * Schemaname des Dumpfiles erfragen
   * @return string
   */
  public function getDumpFileSchema()
  {

    $schemaName = $this->getNodeAttr( 'structure/dump', 'schema_name' );
    return $schemaName;
    
  }//end public function getDumpFileSchema */
  
  /**
   * Type des dumps erfragen
   * @return string
   */
  public function getDumpType()
  {

    $dumpType = $this->getNodeAttr( 'structure/dump', 'type' );
    return $dumpType;
    
  }//end public function getDumpType */

  /**
   * @return [PackageDbGroup]
   */
  public function getRoles()
  {

    return $this->getNodes( 'structure/roles/entries/entry', 'PackageDbGroup' );

  }//end public function getRoles */

  /**
   * @return [PackageDbDumpFile]
   */
  public function getRoleFiles()
  {
    
    return $this->getNodes( 'structure/roles/files/file', 'PackageDbDumpFile' );
    
  }//end public function getRoleFiles */
  
  /**
   * @return [PackageDbUser]
   */
  public function getUsers()
  {

    return $this->getNodes( 'structure/users/entries/entry', 'PackageDbUser' );
    
  }//end public function getUsers */

  /**
   * @return [PackageDbDumpFile]
   */
  public function getUserFiles()
  {
    return $this->getNodes( 'structure/users/files/file', 'PackageDbDumpFile' );
  }//end public function getUserFiles */
  
  /**
   * @return [PackageDbSequence]
   */
  public function getSequences()
  {

    return $this->getNodes( 'structure/sequences/entries/entry', 'PackageDbSequence' );
    
  }//end public function getSequences */

  
  /**
   * @return [PackageDbDumpFile]
   */
  public function getStructureFiles()
  {
    
    return $this->getNodes( 'structure/files/file', 'PackageDbDumpFile' );

  }//end public function getStructureFiles */
 
////////////////////////////////////////////////////////////////////////////////
// Connection
////////////////////////////////////////////////////////////////////////////////

  /**
   * Die Datenbankverbindung zu diesen Daten erfragen
   * @return Db_Connection
   */
  public function getConnection()
  {
    
    if ( $this->con )
      return $this->con;
      
    $className = 'Db'.ucfirst($this->getType());
    
    if ( !Gaia::classLoadable( $className ) )
      throw new GaiaException( "Requested Connection for nonexisting Type ".$this->getType() );
      
    $this->con = new $className
    ( 
      UiConsole::getActive(), 
      $this->getDbName(), 
      $this->getDbUser(), 
      $this->getDbPwd(),
      $this->getHost(),
      $this->getPort(),
      $this->getDbSchema()
    );
    
    return $this->con;

  }//end public function getConnection */
  
////////////////////////////////////////////////////////////////////////////////
// update Flags
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $path 
   * @return boolean
   */
  public function updateFlag( $path )
  {
    
    $nodeList =  $this->getNodes( $path );
    return (boolean)$nodeList->length;
    
  }//end public function updateFlag */
  
  /**
   * @param string $path 
   * @param string $default 
   * @return string
   */
  public function updateFlagMode( $path, $value = null )
  {
    
    $mode = $this->getNodeAttr( $path, 'mode' );
    
    if ( !$mode )
      return null;
      
    if ( !$value && $value == $mode )
      return true;
    
    return $mode;

  }//end public function updateFlagMode */
  
} // end class PackageServerDb


