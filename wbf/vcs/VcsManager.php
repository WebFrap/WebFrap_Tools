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
 * @subpackage WebFrap
 *
 */
class VcsManager
{

  /**
   * 
   * @param string $type
   * @param string $path
   * @param string $displayUser
   * @param string $repoKey
   * 
   * @return IsAVcsAdapter
   */
  public static function useRepository( $type, $path, $displayUser = null, $repoKey = null )
  {
    
    $className = 'Vcs_'.$type;
    
    if ( !Gaia::classLoadable( $className ) )
    {
      throw new GaiaException( "Im Moment existiert noch kein VCS Adapter für {$type}" );
    }
    
    $mgmtNode = new $className( $path, $displayUser, $repoKey );
    
    return $mgmtNode;
    
  }//end public static function useRepository */
  

}// end class VcsManager

