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
class TemplateFile
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var TArray
   */
  public $vars = null;
  
  /**
   * @var array
   */
  public $templates = array();

  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   */
  public function __construct()
  {
    
    $this->vars = new TArray();
    
  }//end public function __construct */

  
  /**
   * @param string $template
   */
  public function addTemplate( $template )
  {
    
    $this->templates[] = $template;
    
  }//end public function addTemplate */
  
  /**
   * @return string
   */
  public function render()
  {
    
    $v = $this->vars;
    
    ob_start();
    foreach( $this->templates as $template )
    {
      if ( Fs::exists( GAIA_PATH.'modules/'.$template.'.tpl' ) )
        include GAIA_PATH.'modules/'.$template.'.tpl';
      elseif ( Fs::exists( GAIA_PATH.'wbf/'.$template.'.tpl' ) )
        include GAIA_PATH.'wbf/'.$template.'.tpl';
      else 
        echo 'Missing Template '.$template.NL;
    }
    
    $maincontent = ob_get_contents();
    ob_end_clean();
    
    $this->renderedContent = $maincontent;

    return $this->renderedContent;

  }//end public function render */
  
  public function save( $filename )
  {
    
  }//end public function save */
  
}//end class TemplateFile */