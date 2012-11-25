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
class Conf
  extends TArray
{
  
  /**
   * Die aktive Ko
   * @var Conf
   */
  private static $active = null;
  
  /**
   * Laden der Konfiguration
   */
  public static function init()
  {
    
    self::$active = new Conf();
    
  }// end public static function init */ 
  
  /**
   * @return Conf
   */
  public static function getActive()
  {
    
    return self::$active;
    
  }// end public static function getActive */ 
  
  /**
   * @var ConfRepoSync
   */
  public $sync = null;


} // end class Conf


