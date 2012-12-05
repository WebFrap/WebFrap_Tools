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
   * @var Files to use
   */
  public $files = array();
  
  /**
   * @var Files to use
   */
  public $toDelete = array();
  
  /**
   * @var Repos to use
   */
  public $repos = array();
  
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
      
    if( !isset( $dataNode->files_raw ) && !isset( $dataNode->repos ) )
      throw new RequestInvalid_Exception( 'Package has no content' );
      
    $this->deployPath  = $dataNode->deploy_path;
    $this->codeRoot   = $dataNode->code_root;
    $this->packagePath = $dataNode->package_path;
    $this->packageName = $dataNode->package_name;
      
    //$files = explode( NL,  $dataNode->files_raw );
    
    if( isset( $dataNode->files_raw ) )
    {
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
    }
    
    if( isset( $dataNode->delete ) )
    {
      foreach( $dataNode->delete as $file )
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
    }

    
    if( isset( $dataNode->repos ) )
    {
      $this->repos = $dataNode->repos;
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
    
    if( '' === trim( $this->packagePath ) || '' === trim( $this->packageName ) )
      throw new GaiaException( 'Package path or package name was empty.' );
    
    if( Fs::exists( $this->packagePath.'/'.$this->packageName ) )
      Fs::del( $this->packagePath.'/'.$this->packageName );

    Fs::mkdir( $this->packagePath.'/'.$this->packageName.'/files' );
    
    $this->script = <<<CODE
    
#!/bin/bash
# simple deployment script

deplPath="{$this->deployPath}"

echo "Starting deployment to \${deplPath}"

#if [ "$(whoami)" != "root" ];
#then
#   echo "Script need to be started as root"
#   exit
#fi

function deploy {

  deplPath="{$this->deployPath}"
  fPath='./files/'
  
  echo "deploy \${2} to \${deplPath}\${2}" 

  if [ ! -d "\${deplPath}\${1}/" ]; then
      mkdir -p \${deplPath}\${1}/
  fi

  cp -f "\${fPath}\${2}" "\${deplPath}\${2}"
}

function remove {

  deplPath="{$this->deployPath}"
  
  if [ -d "\${deplPath}\${1}/" ]; then
  
  		echo "delete folder \${deplPath}\${1}" 
      rm -rf "\${deplPath}\${1}"
  fi
  
  if [ -a "\${deplPath}\${1}" ]; then
  
  		echo "delete file \${deplPath}\${1}" 
      rm -f "\${deplPath}\${1}"
  fi

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
    
    if( $this->repos )
    {
      $iterator = new PackageBuilder_Repo_Iterator( $this->repos, null, $this->codeRoot );
      
      foreach( $iterator as $deployPath => $localPath )
      {
        Fs::copy( $localPath, $pPath.$deployPath, false );
        $this->script .= "deploy \"".Fs::getFileFolder($deployPath)."\" \"{$deployPath}\" ".NL;
      }
    }
    
    foreach( $this->toDelete as $target )
    {
      $this->script .= "remove \"{$target}\" ".NL;
    }
    
    $this->script .=<<<CODE
    
echo "Done"
    
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
