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
 * Interface für die Validatoren
 * @package WebFrap
 * @subpackage Gaia
 */
interface IsaValidator
{

  /**
   * @param string $value
   * @param Db_Connection $db
   * @param int $flags
   */
  public function validate( $value, $db = null, $flags = null );

  public function santisize( $value, $db = null, $flags = null );

  public function validateToContainer( $value, $key, $container, $db = null, $flags = null );

  public function santisizeToContainer( $value, $key, $container, $db = null, $flags = null );

}//end class IsaValidator */

