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
class PackageManager_Patch_Model
  extends Install_Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $deployPath = null;
  
  /**
   * @var Package
   */
  public $codeRoot = null;
  
  /**
   * @var Package
   */
  public $packagePath = null;
  
  /**
   * @var Package
   */
  public $packageName = null;
  
  /**
   * @var Package
   */
  public $files = array();
  
  protected $script = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param unknown_type $dataNode
   * @throws RequestInvalid_Exception
   */
  public function readJson( $dataNode )
  {
    
    if( !isset( $dataNode->deploy_path) )
      throw new RequestInvalid_Exception( 'Missing deploy_path' );
      
    if( !isset( $dataNode->code_root ) )
      throw new RequestInvalid_Exception( 'Missing code_root' );
      
    if( !isset( $dataNode->package_path ) )
      throw new RequestInvalid_Exception( 'Missing package_path' );
      
    if( !isset( $dataNode->package_name ) )
      throw new RequestInvalid_Exception( 'Missing package_name' );
      
    if( !isset( $dataNode->files_raw ) )
      throw new RequestInvalid_Exception( 'Missing files_raw' );
      
    $this->deployPath  = $dataNode->deploy_path;
    $this->codeRoot   = $dataNode->code_root;
    $this->packagePath = $dataNode->package_path;
    $this->packageName = $dataNode->package_name;
      
    //$files = explode( NL,  $dataNode->files_raw );
    
    foreach( $dataNode->files_raw as $file )
    {
      $tmpFile = trim($file);
      
      if( '' === $tmpFile )
        continue;
        
       $sourceTarget = explode( '->',  $tmpFile );
       
       if( isset( $sourceTarget[1] ) )
       {
         $this->files[$sourceTarget[0]] = $sourceTarget[1];
       }
       else
       {
         $this->files[$sourceTarget[0]] = $sourceTarget[0];
       }
      
    }
    
  }//end public function readJson

  /**
   * Prüfen ob alle nötigen Daten vorhanden sind
   */
  protected function check()
  {
    
  }//end protected function check */
  
  
  /**
   * Erstellen des Packages
   */
  protected function setupPackage()
  {

    Fs::mkdir( $this->packagePath.'/'.$this->packageName.'/files' );
    
    $this->script = <<<CODE
    
#!/bin/bash
# simple deployment script

deplPath="{$this->deployPath}"

echo "\\[\\033[1;32m\\]Starting deployment to \\[\\033[1;34m\\]\${deplPath}"

if [ "$(whoami)" != "root" ];
then
   echo "\\[\\033[0;31m\\]Script need to be started as root\\[\\033[0m\\]"
   exit
fi

function deploy {

  deplPath="{$this->deployPath}"
  fPath='./files/'
  
  echo "\\[\\033[1;33m\\]deploy \\[\\033[1;34m\\]\${2} \\[\\033[1;30m\\]to \\[\\033[1;34m\\]\${deplPath}\${2}" 

  if [ ! -d "\${deplPath}\${1}/" ]; then
      mkdir -p \${deplPath}\${1}/
  fi

  cp -f "\${fPath}\${2}" "\${deplPath}\${2}"
}
    
CODE;
    
    
  }//end protected function setupPackage */
  
  
  /**
   */
  public function buildPackage(   )
  {
    
    $this->check();
    $this->setupPackage();
    
    $pPath = $this->packagePath.'/'.$this->packageName.'/files/';
    
    foreach( $this->files as $local => $target )
    {
      Fs::copy( $this->codeRoot.$local, $pPath.$target, false );
      
      $this->script .= "deploy \"".Fs::getFileFolder($target)."\" \"{$target}\" ".NL;
      
    }
    
    $this->script .=<<<CODE
    
echo "\\[\\033[1;32m\\]Done\\[\\033[0m\\]"
    
CODE;
   
    Fs::write($this->script, $this->packagePath.'/'.$this->packageName.'/deploy.sh');
    
      
  }//end public function buildPackage */
  

  
  /**
   * löschen des Temporären pfades
   */
  public function cleanTmp()
  {
    
    Fs::del( $this->tmpPath );
    
  }//end public function cleanTmp */

}//end class Update_Model */
