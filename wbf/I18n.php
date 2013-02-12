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
 * Internationalisierung
 * @package WebFrap
 * @subpackage Gaia
 */
class I18n
{

  /**
   * Liste mit den sprachdaten
   * @var array
   */
  public static $l = array();

  /**
   * @param string $lang
   */
  public static function loadLang( $lang = 'de')
  {

    if( file_exists( GAIA_PATH.'wbf/i18n/'.$lang.'.php' ) )
      include GAIA_PATH.'wbf/i18n/'.$lang.'.php';
    else
      include GAIA_PATH.'wbf/i18n/en.php';

  }//end public static function loadLang */

  /**
   * @return string
   */
  public static function get( $key )
  {
    return isset(self::$l[$key])?:$key;
  }//end public static function get */

}//end class I18n */