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
class PackageComponent
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
  public function getType()
  {
    return $this->getAttribute('type');
  }//end public function getType */

  /**
   * @return string
   */
  public function getBranch()
  {
    return $this->getAttribute('branch');
  }//end public function getBranch */

  /**
   * @return string
   */
  public function getRepoType()
  {
    return $this->getAttribute('repo_type');
  }//end public function getRepoType */

  /**
   * @return [PackageFolder]
   */
  public function getFolders()
  {

    $folders = array();

    $fList = $this->getNodes( 'folder' );

    foreach ($fList as $lNode) {
      $folders[] = new PackageFolder($lNode);
    }

    return $folders;

  }//end public function getFolders */

} // end class PackageComponent

