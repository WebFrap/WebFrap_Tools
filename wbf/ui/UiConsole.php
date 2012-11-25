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
 * Ausgabe von UI elementen in die shell
 * @package WebFrap
 * @subpackage Gaia
 */
abstract class UiConsole
{
  
  /**
   * @var string
   */
  public $type = 'zenity';
  
  /**
   * @var array
   */
  private $version = array();
  
  /**
   * @var Zenity
   */
  private static $active = null;
  
  /**
   * @return UiConsole
   */
  public static function getActive()
  {
    
    return self::$active;  
    
  }//end public static function getActive */
  
  /**
   * @param UiConsole $active
   */
  public static function setActive( $active )
  {
    
    self::$active = $active;  
    
  }//end public static function setActive */

  
  /**
   * @param string $text
   */
  public function out( $text )
  {
    
    echo $text."\n";
    
  }//end public function out */
  
  
  /**
   * @param string $warning
   */
  public static function debugLine( $error )
  {
    self::$active->debug( $error );
  }

}//end class UiConsole

