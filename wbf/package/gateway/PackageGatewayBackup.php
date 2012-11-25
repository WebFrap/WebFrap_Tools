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
class PackageGatewayBackup
  extends XmlNode
{
////////////////////////////////////////////////////////////////////////////////
// Metadata
////////////////////////////////////////////////////////////////////////////////
 
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param boolean $asPart
   * @return string
   */
  public function getType( $asPart = false )
  {
    
    /**
     * full
     * data
     * user_data
     */
    
    if( $asPart )
      return '_'.ucfirst( $this->getAttribute( 'type' ) );
    else
      return $this->getAttribute( 'type' );
    
  }//end public function getType */
  
  /**
   * @return string
   */
  public function getMode()
  {
    return $this->getAttribute( 'mode' );
  }//end public function getMode */
  
  /**
   * @return string
   */
  public function getArchiveType()
  {
    return $this->getAttribute( 'archive_type' );
  }//end public function getArchiveType */
  
  /**
   * @return string
   */
  public function getStorageRate()
  {
    
    $attrVal = $this->getAttribute( 'storage_rate' );
    
    // Tag
    // Woche
    // Monat
    // Quartal
    // Year
    if( '' == $attrVal )
      $attrVal = '7,2,2,1,1';
      
    $tmp = explode( ',', $attrVal );
    
    return $tmp;
    
  }//end public function getStorageRate */

  /**
   * @return string
   */
  public function getAmountToKeep()
  {
    return $this->getAttribute( 'amount_to_keep' );
  }//end public function getAmountToKeep */
  
  /**
   * @return string
   */
  public function getDir()
  {
    return $this->getNodeValue( 'dir' );
  }//end public function getDir */

} // end class PackageGatewayBackup 


