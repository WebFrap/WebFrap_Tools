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
 * Betriebsystem spezifische elemente
 * @package WebFrap
 * @subpackage Gaia
 */
class Template_Http
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $renderedContent = null;
  
  /**
   * @var TemplateWorkarea
   */
  public $workarea = null;

  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * 
   */
  public function __construct()
  {
    
  }//end public function __construct */
  
  /**
   * @param string $key
   * @throws GaiaException
   */
  public function useWorkArea( $key )
  {
    
    $className = 'TemplateWorkarea_'.FormatString::subToCamelCase( $key );
    
    if( Gaia::classLoadable( $className ) )
      $this->workarea = new $className( );
    else 
      throw new GaiaException( "Workarea {$key} existiert nicht." );
    
    return $this->workarea;
    
  }//end public function useWorkArea */
  
  /**
   * @return TemplateWorkarea
   */
  public function getWorkArea( $key = null )
  {
    
    if( !$this->workarea )
    {
      if( $key )
      {
        $className = 'TemplateWorkarea_'.FormatString::subToCamelCase( $key );
        
        if( Gaia::classLoadable( $className ) )
          $this->workarea = new $className( );
        else 
          throw new GaiaException( "Workarea {$key} existiert nicht." );
      }
      else 
      {
        $this->workarea = new TemplateWorkarea_Default( );
      }
      
    }
    
    return $this->workarea;
    
  }//end public function getWorkArea */
  
  /**
   * @return string
   */
  public function render()
  {
    
    if( $this->workarea )
      $this->renderedContent = $this->workarea->render();
    else 
      $this->renderedContent = 'Nothing to see here';
      
    return $this->renderedContent;
    
  }//end public function render */
  
  /**
   * 
   */
  public function sendHeader()
  {
    $this->workarea->sendHeader();
  }//end public function sendHeader */


}//end class Template_Http */