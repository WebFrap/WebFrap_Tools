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
 * Validator für Text
 * @package WebFrap
 * @subpackage Gaia
 */
class Validator_Number
  implements IsAValidator
{

  /**
   * @var string
   */
  const INT_VAL = 'Validator_Text::intval';

  /**
   * @var string
   */
  const FLOAT_VAL = 'Validator_Text::floatval';

  /**
   * @var string
   */
  const ONLY_POSITIVE = 1;

  /* (non-PHPdoc)
   * @see IsaValidator::santisize()
   */
  public function santisize( $value, $db = null, $flags = null )
  {

    // TODO Auto-generated method stub

  }//end public function santisize */

  /* (non-PHPdoc)
   * @see IsaValidator::santisizeToContainer()
   */
  public function santisizeToContainer( $value, $key, $container, $db = null, $flags = null )
  {

    // TODO Auto-generated method stub

  }//end public function santisizeToContainer */

  /* (non-PHPdoc)
 * @see IsaValidator::validate()
 */
  public function validate( $value, $db = null, $flags = null )
  {

    // TODO Auto-generated method stub

  }//end public function validate */

  /* (non-PHPdoc)
   * @see IsaValidator::validateToContainer()
   */
  public function validateToContainer( $value, $key, $container, $db = null, $flags = null )
  {

    // TODO Auto-generated method stub

  }//end public function validateToContainer */

}//end class Validator_Number */

