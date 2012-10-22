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
class TemplateWorkarea_Text
  extends TemplateWorkarea
{
  
  /**
   * @var string
   */
  public $contentType = 'text/plain';
  
  /**
   * @var string
   */
  public $index = 'template/plain';
  
  /**
   * @return string
   */
  public function render()
  {
    
    $v = $this->vars;
    
    ob_start();
    foreach( $this->templates as $template )
    {
      if( Fs::exists( GAIA_PATH.'modules/'.$template.'.tpl' ) )
        include GAIA_PATH.'modules/'.$template.'.tpl';
      elseif( Fs::exists( GAIA_PATH.'gaia/'.$template.'.tpl' ) )
        include GAIA_PATH.'gaia/'.$template.'.tpl';
      else 
        echo 'Missing Template '.$template.NL;
    }
    
    $maincontent = ob_get_contents();
    ob_end_clean();
    
    ob_start();
    if( Fs::exists( GAIA_PATH.'modules/'.$this->index.'.idx' ) )
      include GAIA_PATH.'modules/'.$this->index.'.idx';
    elseif( Fs::exists( GAIA_PATH.'gaia/'.$this->index.'.idx' ) )
      include GAIA_PATH.'gaia/'.$this->index.'.idx';
    else 
      echo 'Missing Index '.$this->index.NL;
    $redered = ob_get_contents();
    ob_end_clean();

    $this->renderedContent = $redered;

    return $this->renderedContent;

  }//end public function render */
  
}//end class TemplateWorkarea_Css */