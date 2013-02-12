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
class PackageGateway
  extends XmlNode
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var PackageGatewayBackup
   */
  public $backup = null;
  
  /**
   * Das Deployment Target kann überschrieben werden
   * @var string
   */
  public $codeRoot = null;
  
  /**
   * Der zu verwendente ConfKey kann überschrieben werden
   * @var string
   */
  public $confKey = null;
  
  /**
   * Setzen eines neue Gatewaynamens wenn der vorhandene überschrieben werden soll
   * @var string
   */
  public $gwName = null;
  
  /**
   * Im Gateway können mehrere Server konfiguriert werden
   * Standardmäßig versucht das System in alle Server die vorhanden sind zu
   * deployen. 
   * 
   * Über UseServer kann ein einzellner Server fürs deployment festgepinnt werden
   * 
   * @var string
   */
  public $serverKey = null;
  
  /**
   * Permission Objekt für das komplette Gateway
   * @var StructPermission
   */
  public $defaultPermission = null;
  
  /**
   * Code Permissions
   * @var StructPermission
   */
  public $codePermission = null;
  
  /**
   * Permission Objekt für das komplette Gateway
   * @var StructPermission
   */
  public $editPermission = null;
  
////////////////////////////////////////////////////////////////////////////////
// Setter zum Überschreiben der Packetdaten
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $codeRoot
   */
  public function setCodeRoot( $codeRoot )
  {
    $this->codeRoot = $codeRoot;
  }//end public function setCodeRoot */
  
  /**
   * @param string $confKey
   */
  public function setConfKey( $confKey )
  {
    $this->confKey = $confKey;
  }//end public function setConfKey */
  
  /**
   * @param string $gwName
   */
  public function setGwName( $gwName )
  {
    $this->gwName = $gwName;
  }//end public function setGwName */
  
  /**
   * @param string $serverKey
   */
  public function setServerKey( $serverKey )
  {
    $this->serverKey = $serverKey;
  }//end public function setServerKey */
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return string
   */
  public function getName()
  {
    
    if( !$this->gwName )
    {
      $this->gwName = $this->getAttribute('name');
    }
    
    return $this->gwName;
    
  }//end public function getName */
  
  /**
   * @return string
   */
  public function getSrc()
  {
    return $this->getAttribute('src');
  }//end public function getSrc */
  
  /**
   * @return string
   */
  public function getCodeRoot()
  {
    
    if( !$this->codeRoot )
    {
      $this->codeRoot = $this->getNodeValue('code_root');
    }
    
    return $this->codeRoot;
    
  }//end public function getCodeRoot */
  
  /**
   * @return string
   */
  public function getConfKey()
  {
    
    if( !$this->confKey )
    {
      $this->confKey = $this->getNodeAttr('conf','key');
    }
    
    return $this->confKey;

  }//end public function getConfKey */
  
  /**
   * @return StructPermission
   */
  public function getGwPermission()
  {
    
    if( !$this->defaultPermission )
    {
      $this->defaultPermission = new StructPermission();
      
      $owner = $this->getNodeAttr( 'permissions', 'owner' );
      if( $owner )
        $this->defaultPermission->owner = $owner;
        
      $group = $this->getNodeAttr( 'permissions', 'group' );
      if( $group )
        $this->defaultPermission->group = $group;
      
      $access = $this->getNodeAttr( 'permissions', 'access' );
      if( $access )
        $this->defaultPermission->accessMask = $access;
        
        
      if( !$owner && !$group && !$access )
        return null;
        
      $this->defaultPermission->directory =  $this->codeRoot.$this->getName().'/';
      
    }
    
    return $this->defaultPermission;

  }//end public function getGwPermission */
  
  /**
   * @return StructPermission
   */
  public function getCodePermission()
  {
    
    if( !$this->codePermission )
    {
      $this->codePermission = new StructPermission();
      
      $owner = $this->getNodeAttr( 'permissions/code', 'owner' );
      if( $owner )
        $this->codePermission->owner = $owner;
        
      $group = $this->getNodeAttr( 'permissions/code', 'group' );
      if( $group )
        $this->codePermission->group = $group;
      
      $access = $this->getNodeAttr( 'permissions/code', 'access' );
      if( $access )
        $this->codePermission->accessMask = $access;
      
      if( !$owner && !$group && !$access )
        return null;
        
      $this->codePermission->directory =  $this->codeRoot;
      
    }
    
    return $this->codePermission;

  }//end public function getCodePermission */
  
  
  /**
   * @return StructPermission
   */
  public function getDefOwner()
  {
    
    $owner = $this->getNodeAttr( 'permissions', 'owner' );
    if( !$owner )
      $owner = 'www-data';
      
    return $owner;

  }//end public function getDefOwner */
  
  /**
   * @return string
   */
  public function getDefGroup()
  {
    
    $group = $this->getNodeAttr( 'permissions', 'group' );
    if( !$group )
      $group = 'www-data';
      
    return $group;

  }//end public function getDefGroup */
  
  /**
   * @return string
   */
  public function getDefAccess()
  {
    
    $access = $this->getNodeAttr( 'permissions', 'access' );
    if( !$access )
      $access = '700';
      
    return $access;

  }//end public function getDefAccess */

  /**
   * @return string
   */
  public function getDefWriteAccess()
  {
    
    $access = $this->getNodeAttr( 'permissions', 'write_access' );
    if( !$access )
      $access = '700';
      
    return $access;

  }//end public function getDefWriteAccess */

  /**
   * @return StructPermission
   */
  public function getGwEditPermissions()
  {
    
    $defOwner   = $this->getDefOwner();
    $defGroup   = $this->getDefGroup();
    $defAccess  = $this->getDefWriteAccess();
    
    $editPermission = array();
    
    // tmp
    $tmpPerm = new StructPermission();
    
    $owner = $this->getNodeAttr( 'permissions/tmp', 'owner' );
    if( !$owner )
      $owner = $defOwner;
    $tmpPerm->owner = $owner;
      
    $group = $this->getNodeAttr( 'permissions/tmp', 'group' );
    if( !$group )
      $group = $defGroup;
    $tmpPerm->group = $group;
    
    $access = $this->getNodeAttr( 'permissions/tmp', 'access' );
    if( !$access )
      $access = $defAccess;
    $tmpPerm->accessMask = $access;
      
    $tmpPerm->directory =  $this->codeRoot.''.$this->getName().'/tmp/';
      
    $editPermission[] = $tmpPerm;
    
    // cache
    $cachePerm = new StructPermission();
    
    $owner = $this->getNodeAttr( 'permissions/cache', 'owner' );
    if( !$owner )
      $owner = $defOwner;
    $cachePerm->owner = $owner;
      
    $group = $this->getNodeAttr( 'permissions/cache', 'group' );
    if( !$group )
      $group = $defGroup;
    $cachePerm->group = $group;
    
    $access = $this->getNodeAttr( 'permissions/cache', 'access' );
    if( !$access )
      $access = $defAccess;
    $cachePerm->accessMask = $access;
      
    $cachePerm->directory =  $this->codeRoot.''.$this->getName().'/cache/';
      
    $editPermission[] = $cachePerm;
    
    // files
    $filesPerm = new StructPermission();
    
    $owner = $this->getNodeAttr( 'permissions/files', 'owner' );
    if( !$owner )
      $owner = $defOwner;
    $filesPerm->owner = $owner;
      
    $group = $this->getNodeAttr( 'permissions/files', 'group' );
    if( !$group )
      $group = $defGroup;
    $filesPerm->group = $group;
    
    $access = $this->getNodeAttr( 'permissions/files', 'access' );
    if( !$access )
      $access = $defAccess;
    $filesPerm->accessMask = $access;
      
    $filesPerm->directory =  $this->codeRoot.''.$this->getName().'/files/';
      
    $editPermission[] = $filesPerm;
    
    // data
    $dataPerm = new StructPermission();
    
    $owner = $this->getNodeAttr( 'permissions/data', 'owner' );
    if( !$owner )
      $owner = $defOwner;
    $dataPerm->owner = $owner;
      
    $group = $this->getNodeAttr( 'permissions/data', 'group' );
    if( !$group )
      $group = $defGroup;
    $dataPerm->group = $group;
    
    $access = $this->getNodeAttr( 'permissions/data', 'access' );
    if( !$access )
      $access = $defAccess;
    $dataPerm->accessMask = $access;
      
    $dataPerm->directory =  $this->codeRoot.''.$this->getName().'/data/';
      
    $editPermission[] = $dataPerm;
    
    // backup
    $backupPerm = new StructPermission();
    
    $owner = $this->getNodeAttr( 'permissions/backup', 'owner' );
    if( !$owner )
      $owner = $defOwner;
    $backupPerm->owner = $owner;
      
    $group = $this->getNodeAttr( 'permissions/backup', 'group' );
    if( !$group )
      $group = $defGroup;
    $backupPerm->group = $group;
    
    $access = $this->getNodeAttr( 'permissions/backup', 'access' );
    if( !$access )
      $access = $defAccess;
    $backupPerm->accessMask = $access;
    
    // log
    $logPerm = new StructPermission();
    
    $owner = $this->getNodeAttr( 'permissions/log', 'owner' );
    if( !$owner )
      $owner = $defOwner;
    $logPerm->owner = $owner;
      
    $group = $this->getNodeAttr( 'permissions/log', 'group' );
    if( !$group )
      $group = $defGroup;
    $logPerm->group = $group;
    
    $access = $this->getNodeAttr( 'permissions/log', 'access' );
    if( !$access )
      $access = $defAccess;
    $logPerm->accessMask = $access;
      
    $logPerm->directory =  $this->codeRoot.''.$this->getName().'/log/';
      
    $editPermission[] = $logPerm;

    return $editPermission;

  }//end public function getGwEditPermission */
  
  /**
   * @return [StructPermission]
   */
  public function getCustomPermissions( )
  {
    
    $permissions = array();
    
    $nodes = $this->getNodes( 'permissions/root/path' );
    
    foreach( $nodes as /* @var DOMElement $node */ $node )
    {
      $perm = new StructPermission();

      $owner = $node->getAttribute( 'owner' );
      if( $owner )
        $perm->owner = $owner;
        
      $group = $node->getAttribute( 'group' );
      if( $group )
        $perm->group = $group;
      
      $access = $node->getAttribute( 'access' );
      if( $access )
        $perm->accessMask = $access;

        
      $perm->directory =  $this->codeRoot.''.$node->nodeValue;
      
      $permissions[] = $perm;

    }

    return $permissions;

  }//end public function getCustomPermissions */
  
////////////////////////////////////////////////////////////////////////////////
// Getter für Themes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return string
   */
  public function getIconThemeName()
  {
    return $this->getNodeAttr( 'icon_themes', 'name' );
  }//end public function getIconThemeName */
  
  /**
   * @return [string]
   */
  public function getIconThemeFolders()
  {
    
    $folders = array();
    
    $fList = $this->getNodes( 'icon_themes/folder' );
    
    foreach( $fList as $lNode )
    {
      $folders[] = $lNode->getAttribute('name');
    }
    
    return $folders;
    
  }//end public function getIconThemeFolders */
  
  /**
   * @return string
   */
  public function cleanIconThemes()
  {
    
    $value = $this->getNodeAttr( 'icon_themes', 'clean' );
    return ('true' == $value)?true:false;
    
  }//end public function cleanIconThemes */
  
  /**
   * @return string
   */
  public function getUiThemeName()
  {
    return $this->getNodeAttr( 'ui_themes', 'name' );
  }//end public function getUiThemeName */
  
  /**
   * @return [string]
   */
  public function getUiThemeFolders()
  {
    
    $folders = array();
    
    $fList = $this->getNodes( 'ui_themes/folder' );
    
    foreach( $fList as $lNode )
    {
      $folders[] = $lNode->getAttribute('name');
    }
    
    return $folders;
    
  }//end public function getUiThemeFolders */
  
  /**
   * @return string
   */
  public function cleanUiThemes()
  {
    
    $value = $this->getNodeAttr( 'ui_themes', 'clean' );
    return ('true' == $value)?true:false;
    
  }//end public function cleanUiThemes */
  
  /**
   * @return string
   */
  public function getWgtName()
  {
    return $this->getNodeAttr( 'wgt', 'name' );
  }//end public function getWgtName */
  
  /**
   * @return [string]
   */
  public function getWgtFolders()
  {
    
    $folders = array();
    
    $fList = $this->getNodes( 'wgt/folder' );
    
    foreach( $fList as $lNode )
    {
      $folders[] = $lNode->getAttribute('name');
    }
    
    return $folders;
    
  }//end public function getWgtFolders */
  
  /**
   * @return string
   */
  public function cleanWgt()
  {
    
    $value = $this->getNodeAttr( 'wgt', 'clean' );
    return ('true' == $value)?true:false;
    
  }//end public function cleanWgt */
  
  /**
   * @return [PackageGatewayModule]
   */
  public function getModules()
  {
    
    return $this->getNodes( 'modules/module', 'PackageGatewayModule' );
    
  }//end public function getModules */
  
  /**
   * @return int
   */
  public function countModules()
  {
    
    $nodeList =  $this->getNodes( 'modules/module' );
    return $nodeList->length;
    
  }//end public function countModules */
  
  /**
   * @return [PackageGatewayModule]
   */
  public function getVendorModules()
  {
    
    return $this->getNodes( 'vendor_modules/module', 'PackageGatewayModule' );
    
  }//end public function getVendorModules */
  
  /**
   * @return int
   */
  public function countVendorModules()
  {
    
    $nodeList =  $this->getNodes( 'vendor_modules/module' );
    return $nodeList->length;
    
  }//end public function countVendorModules */
  
////////////////////////////////////////////////////////////////////////////////
// Getter für Server
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return [PackageServer]
   */
  public function getServers()
  {
    
    if( $this->serverKey )
    {
      return $this->getNodes( "servers/server[@name='{$this->serverKey}']", 'PackageServer' );
    }
    else 
    {
      return $this->getNodes( "servers/server[@deploy!='demand']", 'PackageServer' );
    }
    
  }//end public function getServers */
  
  /**
   * @return int
   */
  public function countServers()
  {
    
    if( $this->serverKey )
    {
      $nodeList =  $this->getNodes( "servers/server[@name='{$this->serverKey}']" );
    }
    else 
    {
      $nodeList =  $this->getNodes( "servers/server[@deploy!='demand']" );
    }
    
    return $nodeList->length;
    
  }//end public function countServers */

////////////////////////////////////////////////////////////////////////////////
// Getter für User
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return [PackageGatewayUser]
   */
  public function getUsers()
  {
    
    return $this->getNodes( 'users/user', 'PackageGatewayUser' );
    
  }//end public function getUsers */
  
  /**
   * @return int
   */
  public function countUsers()
  {
    
    $nodeList =  $this->getNodes( 'users/user' );
    return $nodeList->length;
    
  }//end public function countUsers */
  
////////////////////////////////////////////////////////////////////////////////
// Backup Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return PackageGatewayBackup
   */
  public function getBackupNode()
  {
    
    if( !$this->backup )
    {
      $tmp = $this->getNode('backup');
      
      if( $tmp )
        $this->backup = new PackageGatewayBackup( $this->document, $tmp );
    }
    
    return $this->backup;
    
  }//end public function getBackupNode */
  
////////////////////////////////////////////////////////////////////////////////
// update Flags
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $path 
   * @return boolean
   */
  public function updateFlag( $path )
  {
    
    $node = $nodeList =  $this->getNode( $path );
    
    if( !$node )
      return false;
      
    $enabled = trim($node->getAttribute('enabled'));
    if( !$enabled )
      return true;
    
    return $enabled == 'false' ? false:true;
    
  }//end public function updateFlag */
  
  /**
   * @param string $path 
   * @param string $default 
   * @return string
   */
  public function updateFlagMode( $path, $value = null )
  {
    
    $mode = $this->getNodeAttr( $path, 'mode' );
    
    if( !$mode )
      return null;
      
    if( !$value && $value == $mode )
      return true;
    
    return $mode;

  }//end public function updateFlagMode */

  
} // end class PackageGateway


