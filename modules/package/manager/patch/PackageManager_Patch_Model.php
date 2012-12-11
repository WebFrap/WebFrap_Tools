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
  public $appName = null;
  
  /**
   * @var string
   */
  public $appVersion = null;
  
  /**
   * @var string
   */
  public $appRevision = null;
  
  /**
   * @var string
   */
  public $deployPath = null;
  
  /**
   * @var Package
   */
  public $codeRoot = null;
  

  /**
   * @var string
   */
  public $packageName = null;
  
  /**
   * @var Package
   */
  public $packagePath = null;
  
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
 
  /**
   * List of users to be notified when an update / deployment was done 
   * successfully
   * @var array
   */
  public $toNotify = array();
  
  /**
   * @var array
   */
  protected $script = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param json $dataNode
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
    
    if( isset( $dataNode->app_name ) )
      $this->appName = $dataNode->app_name;
    else 
      $this->appName = "YourApplication";
      
    if( isset( $dataNode->app_version ) )
      $this->appVersion = $dataNode->app_version;
    else 
      $this->appVersion = "1";
      
    if( isset( $dataNode->app_revision ) )
      $this->appRevision = $dataNode->app_revision;
    else 
      $this->appRevision = date('YmdHis');
      
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
        $this->toDelete[] = $file;
      }
    }
    
    // list of users that have to be notified when the deployment was
    // sucessfull
    if( isset( $dataNode->notify ) )
    {
      $this->toNotify = $dataNode->notify;
    }

    // repositories to deploy    
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
    
    if( '' === trim( $this->packagePath ) || '' === trim( $this->appRevision ) )
      throw new GaiaException( 'Package path or package name was empty.' );
      
    $packageName = $this->packageName.'-'.$this->appVersion.'.'.$this->appRevision;
      
    
    if( Fs::exists( $this->packagePath.'/'.$packageName ) )
      Fs::del( $this->packagePath.'/'.$packageName );

    Fs::mkdir( $this->packagePath.'/'.$packageName.'/files' );
    
    $this->script = <<<CODE
#!/bin/bash
# webfrap deployment script

deplPath="{$this->deployPath}"
fPath="./files/"
started=$(date +"%Y%m%d%H%M%S")
finished=""
appName="{$this->appName}"
appVersion="{$this->appVersion}"
appRevision="{$this->appRevision}"

#if [ "$(whoami)" != "root" ];
#then
#   echo "Script need to be started as root"
#   exit
#fi

# echo and log
function writeLn {

	echo $1
	echo $1 >> ./deploy.log
}

# copy / deploy new files
function deploy {

  writeLn "deploy \${2} to \${deplPath}\${2}" 

  if [ ! -d "\${deplPath}\${1}/" ]; then
      mkdir -p \${deplPath}\${1}/
  fi

  cp -f "\${fPath}\${2}" "\${deplPath}\${2}"
}

# copy / deploy new files
function deployPath {

  writeLn "deploy folder \${1} to \${deplPath}\${1}" 
  cp -f "\${fPath}\${1}" "\${deplPath}\${1}"
}

# remove files or directories
function remove {

  if [ -d "\${deplPath}\${1}/" ]; then
  
  		writeLn "delete folder \${deplPath}\${1}" 
      rm -rf "\${deplPath}\${1}"
  fi
  
  if [ -a "\${deplPath}\${1}" ]; then
  
  		writeLn "delete file \${deplPath}\${1}" 
      rm -f "\${deplPath}\${1}"
  fi

}

# remove files or directories
function notifyStakeholder {

	subject="{$this->appName} {$this->appVersion}.{$this->appRevision} deployment finished sucessfully."

	msg="Dear \${1}\n"
	msg="\${msg}The deployment of {$this->appName} {$this->appVersion}.{$this->appRevision} was finished successfully.\n\n"
	msg="\${msg}Started: \${started} End: \${finished}\n"
	
  echo \$msg | mail -s \$subject $2

}

##### logic starts here

writeLn "Start deployment to \${deplPath} \${started}" 


# unpack if not yet unpacked
if [ ! -d "./files" ]; then
	
	# unpack the data container
  tar xjvf files.tar.bz2 1>/dev/null
  
  # check if unpack was successfull before proceed
  if [ ! -d "./files" ]; then
  
      writeLn "Failed to unpack the data container. Deployment failed!"
      exit 1 
  fi
    
fi

finished=$(date +"%Y%m%d%H%M%S")

CODE;
    
    
  }//end protected function setupPackage */
  
  
  /**
   */
  public function buildPackage(   )
  {
    
    $this->check();
    $this->setupPackage();
    

    $packageName = $this->packageName.'-'.$this->appVersion.'.'.$this->appRevision;
    
    $pPath = $this->packagePath.'/'.$packageName.'/files/';
    

    // first delete
    foreach( $this->toDelete as $target )
    {
      $this->script .= "remove \"{$target}\" ".NL;
    }
    
    // then copy repos
    if( $this->repos )
    {
      $iterator = new PackageBuilder_Repo_Iterator( $this->repos, null, $this->codeRoot );
      
      foreach( $iterator as $deployPath => $localPath )
      {
        Fs::copy( $localPath, $pPath.$deployPath, false );
        
        //$this->script .= "deploy \"".Fs::getFileFolder($deployPath)."\" \"{$deployPath}\" ".NL;
      }
      
      foreach( $this->repos as $repo )
      {
        foreach( $repo->folders as $folder )
        {
          $this->script .= "deployPath \"".$repo->name."/".$folder->name."\"".NL;
        }
      }
      
    }
    
    // then do the finetuning with files
    foreach( $this->files as $local => $target )
    {
      
      if( !file_exists($this->codeRoot.$local) )
      {
        echo "Missing file ".$this->codeRoot.$local."<br />";
        continue;
      }
      
      Fs::copy( $this->codeRoot.$local, $pPath.$target, false );
      
      $this->script .= "deploy \"".Fs::getFileFolder($target)."\" \"{$target}\" ".NL;
    }

    $this->script .=<<<CODE
    
writeLn "Cleaning the temporary install files"
rm -rf ./files
    
writeLn "Done"
    
CODE;
    
    // notify stakeholders
    $this->script .= $this->renderNotifyMails();
     
    Fs::mkdir( $pPath );
    $oldDir = Fs::actualPath();
    Fs::chdir( $this->packagePath.'/'.$packageName.'/' );
    Archive::create( $this->packagePath.'/'.$packageName.'/files.tar.bz2', 'files' );
    Fs::chdir( $oldDir );
    Fs::del( $pPath );
    
    Fs::write($this->script, $this->packagePath.'/'.$packageName.'/deploy.sh');
    
  }//end public function buildPackage */
  
  public function renderNotifyMails()
  {
    
    $code = <<<CODE
    
CODE;

    if( $this->toNotify )
    {
      
    $code = <<<CODE
writeLn "Notify the deployment stakeholders"
CODE;
      
    }

    foreach( $this->toNotify as $notify )
    {
      
      $code .= <<<CODE

notifyStakeholder "{$notify->name}" "{$notify->mail}"
      
CODE;
      
    }
    
    return $code;
    
    
  }
  
  /**
   * löschen des Temporären pfades
   */
  public function cleanTmp()
  {
    
    Fs::del( $this->tmpPath );
    
  }//end public function cleanTmp */

}//end class Update_Model */
