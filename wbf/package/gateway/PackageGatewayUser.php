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
class PackageGatewayUser
  extends XmlNode
  implements UserDataInf
{
////////////////////////////////////////////////////////////////////////////////
// Metadata
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var array
   */
  public $levels = array
  (
    'public_edit'    => 0,
    'public_access'  => 10,
    'user'           => 20,
    'ident'          => 30,
    'employee'       => 40,
    'superior'       => 50,
    'l4_manager'     => 60,
    'l3_manager'     => 70,
    'l2_manager'     => 80,
    'l1_manager'     => 90,
    'system'         => 100,
    1     => 0,
    2     => 10,
    3     => 20,
    4     => 30,
    5     => 40,
    6     => 50,
    7     => 60,
    8     => 70,
    9     => 80,
    10    => 90,
    11    => 100,
  );
  
  /**
   * @var array
   */
  public $profiles = array
  (
    'developer' => 'developer',
    'admin' => 'admin',
    'user' => 'user',
    1 => 'developer',
    2 => 'admin',
    3 => 'user',
  );
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->getAttribute( 'name' );
  }//end public function getName */
  
  /**
   * @return string
   */
  public function getPasswd()
  {
    return $this->getNodeValue( 'passwd' );
  }//end public function getPasswd */

  /**
   * @return string
   */
  public function getFirstname()
  {
    return $this->getNodeValue( 'firstname' );
  }//end public function getFirstname */
  
  /**
   * @return string
   */
  public function getLastname()
  {
    return $this->getNodeValue( 'lastname' );
  }//end public function getLastname */
  
  /**
   * @return string
   */
  public function getLevel()
  {
    
    $level = $this->getNodeValue( 'level' );
    
    if ( !$level )
      return 40;
      
    if ( !isset( $this->levels[$level] ) )
    {
      throw new GaiaException("Got nonexisting Userlevel {$level}");
    }
    
    return $this->levels[$level];
    
  }//end public function getLevel */
  
  /**
   * @return string
   */
  public function getProfile()
  {
    return $this->getNodeValue( 'profile' );
  }//end public function getProfile */
  
  /**
   * @return string
   */
  public function getEmail()
  {
    return $this->getNodeValue( 'email' );
  }//end public function getEmail */

} // end class PackageGatewayUser 


