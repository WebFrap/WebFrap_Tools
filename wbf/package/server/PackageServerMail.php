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
class PackageServerMail
  extends XmlNode
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getType()
  {
    return $this->getAttribute( 'type' );
  }//end public function getType */
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->getAttribute( 'name' );
  }//end public function getName */

  
////////////////////////////////////////////////////////////////////////////////
// Get Admin Data
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getConfSysUser()
  {
    return $this->getNodeValue('conf/sys_user');
  }//end public function getConfSysUser */

  /**
   * @return string
   */
  public function getConfSysGroup()
  {
    return $this->getNodeValue('conf/sys_group');
  }//end public function getConfSysGroup */
  
  /**
   * @return string
   */
  public function getConfDbUser()
  {
    return $this->getNodeValue('conf/db_user');
  }//end public function getConfDbUser */
  
  /**
   * @return string
   */
  public function getConfDbPwd()
  {
    return $this->getNodeValue('conf/db_passwd');
  }//end public function getConfDbPwd */
  
  /**
   * @return string
   */
  public function getConfType()
  {
    return $this->getNodeAttr( 'conf', 'type' );
  }//end public function getConfType */
  
  /**
   * @return string
   */
  public function getConfDbHost()
  {
    return $this->getNodeAttr( 'conf', 'host' );
  }//end public function getConfDbHost */

  /**
   * @return string
   */
  public function getConfDbName()
  {
    return $this->getNodeAttr( 'conf', 'db_name' );
  }//end public function getConfDbName */

  /**
   * @return string
   */
  public function getConfDbSchema()
  {
    return $this->getNodeAttr( 'conf', 'db_schema' );
  }//end public function getConfDbSchema */

} // end class PackageServerMail


