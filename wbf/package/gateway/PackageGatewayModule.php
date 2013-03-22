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
class PackageGatewayModule
  extends XmlNode
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Zugriffsrechte
   * @var StructPermission
   */
  public $permission = null;
  
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
   * Flag ob das Modul vor dem 
   * @return string
   */
  public function cleanOnUpdate()
  {
    $value = $this->getAttribute('clean');
    
    return 'true' == $value?true:false;
    
  }//end public function cleanOnUpdate */


  /**
   * @return [string]
   */
  public function getFolders()
  {
    
    $folders = array();
    $fList   = $this->getNodes('folder');
    
    foreach($fList as $lNode)
    {
      $folders[] = $lNode->getAttribute('name');
    }
    
    return $folders;
    
  }//end public function getFolders */
  
  /**
   * @param string $rootPath
   * @return StructPermission
   */
  public function getPermission($rootPath)
  {
    
    if (!$this->permission)
    {
      $this->permission = new StructPermission();
      $this->permission->directory = $rootPath;
      
      $owner = $this->getAttribute('owner');
      if ($owner)
        $this->permission->owner = $owner;
        
      $group = $this->getAttribute('group');
      if ($group)
        $this->permission->group = $group;
      
      $access = $this->getAttribute('access');
      if ($access)
        $this->permission->accessMask = $access;
        
      if (!$owner && !$group && !$access)
        return null;
        
      $this->permission->directory =  $rootPath.$this->getName().'/';
      
    }
    
    return $this->permission;
    
  }//end public function getPermission */

} // end class PackageGatewayModule 


