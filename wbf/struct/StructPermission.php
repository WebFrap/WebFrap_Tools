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
 * Reiner Datencontainer zum speichern von Permissions auf Ordnern
 * @package WebFrap
 * @subpackage Gaia
 */
class StructPermission
{
  
  /**
   * @var string $owner
   */
  public $owner = null;
  
  /**
   * @var string $group
   */
  public $group = null;
  
  /**
   * @var string $directory
   */
  public $directory = null;
  
  /**
   * @var string $accessMask
   */
  public $accessMask = null;
  
  /**
   * @var string $recursive
   */
  public $recursive = true;
  
  
  /**
   * Für einen neuen Pfad clonen
   * @param string $path
   * @return StructPermission
   */
  public function cloneForPath( $path )
  {
    
    $newPerm = clone $this;
    $newPerm->directory = $path;
    
    return $newPerm;
    
  }//end public function cloneForPath */


}//end class StructPermission */
