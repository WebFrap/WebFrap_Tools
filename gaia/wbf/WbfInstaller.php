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
class WbfInstaller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Console für die Ausgabe
   * @var UiConsole
   */
  protected $console = null;
  
  /**
   * Das request objekt
   * @var IsARequest
   */
  protected $request = null;
  
  /**
   * @var ProtocolWriter
   */
  public $protocol = null;
  
  /**
   * Pfad in welchem sich die Daten befinden
   * Standardmäßig gehen wir vom Gaia Root aus
   * @var string
   */
  protected $dataPath = GAIA_PATH;
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param UiConsole $console
   * @param string $dataPath
   * @param IsARequest $request
   */
  public function __construct( $console, $dataPath, $request = null )
  {
    
    $this->console   = $console;
    $this->dataPath  = $dataPath;
    
    $this->request   = $request;
    
  }//end public function __construct */
  
  
  /**
   * @return IsARequest
   */
  public function getRequest()
  {
    
    if( !$this->request )
      $this->request = Request::getActive();
      
    return $this->request;
    
  }//end public function getRequest */

  
} // end class WbfInstaller


