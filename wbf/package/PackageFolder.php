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
class PackageFolder
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
  public function getRecursive()
  {
    return $this->getAttribute('type')?:'false';
  }//end public function getRecursive */
  
  
  /**
   * @return string
   */
  public function getFilter()
  {
    return $this->getAttribute('filter');
  }//end public function getFilter */
  
  /**
   * @return string
   */
  public function __toString()
  {
    return $this->getAttribute('name')?:'';
  }//end public function __toString */

} // end class PackageFolder


