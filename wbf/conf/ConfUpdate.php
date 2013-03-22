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
class ConfUpdate
  extends XmlDocument
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $dataPath = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  
  
  /**
   * @return srtring
   */
  public function getName()
  {
    return $this->getAttribute('name');
  }//end public function getName */
  
  /**
   * @return srtring
   */
  public function getLabel()
  {
    return $this->getNodeValue('label');
  }//end public function getLabel */
  
  /**
   * @return string
   */
  public function getFullName()
  {
    return $this->getNodeValue('full_name');
  }//end public function getFullName */

  /**
   * @return string
   */
  public function getType()
  {
    return $this->getNodeValue('type');
  }//end public function getType */
  
  /**
   * Pfad in welchem sich der zu deployente Code befindet
   * @return string
   */
  public function getDataPath()
  {
    
    if ( $this->dataPath )
      return $this->dataPath;
    
    
    $dataPath = $this->getNodeValue('data_path');
    
    if ( $dataPath && '' != trim($dataPath) )
      return $dataPath;
    
    return GAIA_PATH.'data/';
    
  }//end public function getDataPath */

  /**
   * @param string $dataPath 
   */
  public function setDataPath( $dataPath )
  {
    
    $this->dataPath = $dataPath;
    
  }//end public function setDataPath */
  
  /**
   * @return string
   */
  public function getVersion()
  {
    return $this->getNodeValue('version');
  }//end public function getVersion */
  
  /**
   * @return string
   */
  public function getRevision()
  {
    return $this->getNodeValue('revision');
  }//end public function getRevision */
  
  /**
   * @return string
   */
  public function getAuthor()
  {
    return $this->getNodeValue('author');
  }//end public function getAuthor */
  
  /**
   * @return string
   */
  public function getProjectManager()
  {
    return $this->getNodeValue('project_manager');
  }//end public function getProjectManager */
  
  /**
   * @return string
   */
  public function getCopyright()
  {
    return $this->getNodeValue('copyright');
  }//end public function getCopyright */
  
  /**
   * @return [PackageGateway]
   */
  public function getGateways()
  {
    
    return $this->getNodes( 'gateways/gateway', 'PackageGateway' );
    
  }//end public function getGateways */
  
  /**
   * @return [PackageGateway]
   */
  public function countGateways()
  {
    
    $nodeList = $this->getNodes( 'gateways/gateway' );
    return $nodeList->length;
    
  }//end public function countGateways */
  
  /**
   * @return [PackageGateway]
   */
  public function countAllIconThemes()
  {
    
    $nodeList = $this->getNodes( 'gateways/gateway/icon_themes/folder' );
    return $nodeList->length;
    
  }//end public function countAllIconThemes */

  /**
   * @return [PackageGateway]
   */
  public function countAllUiThemes()
  {
    
    $nodeList = $this->getNodes( 'gateways/gateway/ui_themes/folder' );
    return $nodeList->length;
    
  }//end public function countAllUiThemes */
  
  /**
   * @param booolean $asArray
   * @return [string]
   */
  public function getFolders( $asArray = false )
  {
    
    $tmp = $this->xpath( '/package/folders/folder' );
    
    $folders = array();
    
    if ( $asArray )
    {
      foreach( $tmp as $folder )
      {
        $folders[] = array
        (
          'name'       => $folder->getAttribute('name'),
          'recursive'  => ($folder->getAttribute('recursive')?:'true'),
          'filter'     => ($folder->getAttribute('filter')?:''),
        );
      }
    }
    else 
    {
      foreach( $tmp as $folder )
      {
        $folders[] = $folder->getAttribute('name');
      }
    }

    
    return $folders;
    
  }//end public function getFolders */

  
  /**
   * @return [string]
   */
  public function getLicences()
  {
    
    $tmp = $this->xpath( '/package/licences/licence' );
    
    $licences = array();
    
    foreach( $tmp as $licence )
    {
      $licences[] = $licence->nodeValue;
    }
    
    return $licences;
    
  }//end public function getLicences */
  
  /**
   * @return [string]
   */
  public function getFiles()
  {
    
    $tmp = $this->xpath( '/package/files/file' );
    
    $files = array();
    
    foreach( $tmp as $file )
    {
      $files[] = $file->nodeValue;
    }
    
    return $files;
    
  }//end public function getFiles */
  
  /**
   * @return [string]
   */
  public function getLanguages()
  {
    
    $tmp = $this->xpath( '/package/languages/lang' );
    
    $languages = array();
    
    foreach( $tmp as $lang )
    {
      $languages[] = $lang->nodeValue;
    }
    
    return $languages;
    
  }//end public function getLanguages */
  

} // end class PackageFile


