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
class PackageServerVhost
  extends XmlNode
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////
  
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
  
  /**
   * @return string
   */
  public function getServerAddress()
  {
    return $this->getNodeValue('address');
  }//end public function getServerAddress */
  
////////////////////////////////////////////////////////////////////////////////
// Getter für Themes
////////////////////////////////////////////////////////////////////////////////
  

  /**
   * @return [PackageServerDb]
   */
  public function getDatabases()
  {
   
    return $this->getNodes( 'databases/database', 'PackageServerDb' );
    
  }//end public function getDatabases */
 

  /**
   * @return [PackageServerDb]
   */
  public function countDatabases()
  {
   
    return $this->getNodes( 'databases/database' ).length;
    
  }//end public function getDatabases */
  
////////////////////////////////////////////////////////////////////////////////
// Getter für Themes
////////////////////////////////////////////////////////////////////////////////

} // end class PackageServerVhost


