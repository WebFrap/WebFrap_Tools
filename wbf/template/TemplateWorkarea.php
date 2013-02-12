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
class TemplateWorkarea
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $title = 'G A I A';

  /**
   * @var string
   */
  public $caption = null;

  /**
   * @var TArray
   */
  public $vars = null;

  /**
   * @var array
   */
  public $templates = array();

  /**
   * @var string
   */
  public $index = 'template/default';

  /**
   * @var string
   */
  public $renderedContent = null;

  /**
   * @var string
   */
  public $contentType = 'text/html';

  /**
   * @var string
   */
  public $encoding = 'utf-8';

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function __construct()
  {

    $this->vars = new TArray();

  }//end public function __construct */

  /**
   * Sender der Header der Workarea
   */
  public function sendHeader()
  {

    header( 'Content-Type:'.$this->contentType.'; charset='.$this->encoding );
    header( 'ETag: '.md5($this->renderedContent) );
    header( 'Content-Length: '.mb_strlen($this->renderedContent) );

  }//end public function sendHeader */

  /**
   * @param string $caption
   */
  public function setCaption( $caption )
  {

    $this->caption = $caption;

  }//end public function setCaption */

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
    foreach ($this->templates as $template) {
      if( Fs::exists( GAIA_PATH.'modules/'.$template.'.tpl' ) )
        include GAIA_PATH.'modules/'.$template.'.tpl';
      elseif( Fs::exists( GAIA_PATH.'wbf/'.$template.'.tpl' ) )
        include GAIA_PATH.'wbf/'.$template.'.tpl';
      else
        echo '<p class="wgt-box-error" >Missing Template '.$template.'</p>'.NL;
    }

    $maincontent = ob_get_contents();
    ob_end_clean();

    ob_start();
    if( Fs::exists( GAIA_PATH.'modules/'.$this->index.'.idx' ) )
      include GAIA_PATH.'modules/'.$this->index.'.idx';
    elseif( Fs::exists( GAIA_PATH.'wbf/'.$this->index.'.idx' ) )
      include GAIA_PATH.'wbf/'.$this->index.'.idx';
    else
      echo '<p class="wgt-box-error" >Missing Index '.$this->index.'</p>'.NL;
    $redered = ob_get_contents();
    ob_end_clean();

    $this->renderedContent = <<<HTML
<html>
  <head>
    <title>{$this->title}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-Script-Type" content="application/javascript" />
    <meta http-equiv="content-Style-Type" content="text/css" />
    <link type="text/css" href="./wgt/layout.php" rel="stylesheet" />
    <link type="text/css" href="./wgt/theme.php"  rel="stylesheet" />
  </head>
  <body>
    {$redered}
    <script type="application/javascript" src="./wgt/javascript.php" ></script>
  </body>
</html>

HTML;

    return $this->renderedContent;

  }//end public function render */

}//end class TemplateWorkarea */