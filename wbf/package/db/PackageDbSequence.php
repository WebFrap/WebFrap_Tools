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
class PackageDbSequence
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
    return $this->getAttribute('name');
  }//end public function getName */
  
  /**
   * @return string
   */
  public function getIncrement()
  {
    return $this->getAttribute('increment');
  }//end public function getIncrement */
  
  /**
   * @return string
   */
  public function getMinValue()
  {
    return $this->getAttribute('minvalue');
  }//end public function getMinValue */
  
  /**
   * @return string
   */
  public function getMaxValue()
  {
    return $this->getAttribute('maxvalue');
  }//end public function getMaxValue */
  
  /**
   * @return string
   */
  public function getStart()
  {
    return $this->getAttribute('start');
  }//end public function getStart */

} // end class PackageDbSequence


