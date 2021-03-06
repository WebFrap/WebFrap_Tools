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
class PackageLicence
  extends XmlNode
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->getValue()?:'';
  }//end public function getName */

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->getValue()?:'';
  }//end public function __toString */

} // end class PackageFolder


