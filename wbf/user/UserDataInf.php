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
interface UserDataInf
{

////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getPasswd();

  /**
   * @return string
   */
  public function getFirstname();

  /**
   * @return string
   */
  public function getLastname();

  /**
   * @return string
   */
  public function getLevel();

  /**
   * @return string
   */
  public function getProfile();

  /**
   * @return string
   */
  public function getEmail();

}//end class UserDataInf */
