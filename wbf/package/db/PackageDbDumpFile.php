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
class PackageDbDumpFile
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
  public function getGateway()
  {
    
    // check auf dem Node
    $gwName = $this->getAttribute('src');

    if( !$gwName )
    {
      
      // check auf files
      $gwName = $this->getNodeAttr( '..', 'src');

      if( !$gwName )
      {
        // check auf dem type
        $gwName = $this->getNodeAttr( '../..', 'src');
        
            
        if( !$gwName )
        {
          // check auf structure
          $gwName = $this->getNodeAttr( '../../..', 'src');
          
          
          if( !$gwName )
          {
            // die Src des Gateways verwenden
            $gwName = $this->getNodeAttr( '../../../../../../../..', 'src');
            
            if( !$gwName )
            {
              // wenn es nicht die src ist, kann es nur noch der name sein
              $gwName = $this->getNodeAttr( '../../../../../../../..', 'name');
            }
            
          }
          
        }
        
      }
      
    }
    
    // ok wenn jetzt nix drin ist kann ich auch nixmehr machen...
    return $gwName;
    
  }//end public function getGateway */


} // end class PackageDbGroup


