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
 * Den Apache konfigurieren
 * 
 * @package WebFrap
 * @subpackage Gaia
 */
class UiDimension
{
  
  /**
   * @var int
   */
  public $width = null;
  
  /**
   * @var int
   */
  public $height = null;
  
  /**
   * @param int $width
   * @param int $height
   */
  public function __construct( $width = null, $height = null )
  {
    
    $this->width   = $width;
    $this->height  = $height;
    
  }//end public function __construct */
  
  /**
   * @return string
   */
  public function render()
  {
    
    $html = ' ';
    
    if ( $this->width )
      $html .= ' --width='.$this->width;
    
    if ( $this->height )
      $html .= ' --height='.$this->height;
      
    return $html;
    
  }//end public function render */
  
  /**
   * @return string
   */
  public function __toString()
  {
    return $this->render();
  }//end public function __toString */
  
}//end class UiDimension */

