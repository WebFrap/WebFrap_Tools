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
   * @var Package Type, full "installer" or just a "patch"
   * 
   * if it's only a patch install and uninstall are not applicable
   * 
   */
  public $packageType = 'installer';
  
  /**
   * the name of the project gateway
   * is required to sync the dabase, rebuild caches etc
   * @var string
   */
  public $gatewayName = null;
  
  /**
   * The user:group on the server
   * @var string
   */
  public $codeOwner = null;
  
  /**
   * Single files to copy 
   * @var array
   */
  public $files = array();
  
  /**
   * @var array
   */
  public $chowns = array();
  
  /**
   * @var array
   */
  public $chmods = array();
  
  /**
   * Single files to copy 
   * @var array
   */
  public $touchFiles = array();
  
  /**
   * Single Files to delete
   * @var array
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
  public $scripts = array
  (
    "pre-install" => array(),
    "post-install" => array(),
    "success-install" => array(),
    "fail-install" => array(),
  
    "pre-update" => array(),
    "post-update" => array(),
    "success-update" => array(),
    "fail-update" => array(),
  
    "pre-uninstall" => array(),
    "post-uninstall" => array(),
    "success-uninstall" => array(),
    "fail-uninstall" => array()
  );
  
  /**
   * Flag wie beim sync mit vorhandenen Datenstrukturen, vor allem mit nicht automatisch
   * zu lösenden konflikten umgegangen werden soll
   * 
   * - skip konflikt überspringen muss von hand gelöst werden
   * - auto Änderungen umsetzen Daten wegkopieren nichts löschen
   * - force konflikte brutal lösen und deprecated datenstrukturen löschen, sehr vorsichtig einsetzen!
   * 
   * @var string
   */
  public $syncType = "skip";
  
  /**
   * Flag um was es sich genau handelt
   * 
   * - install
   * - update
   * - uninstall
   * 
   * @var string
   */
  public $deplType = "";
  
  /**
   * Flag if the data shoul be build of if only the scriptsfolder and the
   * deploy.sh should be created
   * @var boolean
   */
  public $noData = false;
  
  /**
   * The renderet script
   * @var string
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
    $this->codeRoot    = $dataNode->code_root;
    $this->packagePath = $dataNode->package_path;
    $this->packageName = $dataNode->package_name;
    $this->gatewayName = $dataNode->gateway_name;
    
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
      
    if( isset( $dataNode->sync_type ) )
      $this->syncType = $dataNode->sync_type;
      
    if( isset( $dataNode->package_type ) )
      $this->packageType = $dataNode->package_type;
      
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
    
    if( isset( $dataNode->touch ) )
    {
      $this->touchFiles = $dataNode->touch;
    }
    
    if( isset( $dataNode->chowns ) )
    {
      $this->chowns = $dataNode->chowns;
    }
    
    if( isset( $dataNode->chmods ) )
    {
      $this->chmods = $dataNode->chmods;
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

    // repositories to deploy    
    if( isset( $dataNode->scripts ) )
    {
      
      foreach( $dataNode->scripts as $key => $scripts )
      {
        $this->scripts[$key] = $scripts;
      }
      
    }
    
    if( isset( $dataNode->code_owner ) )
      $this->codeOwner = $dataNode->code_owner;
    
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
      
    if( !$this->noData )
    {
      if( Fs::exists( $this->packagePath.'/'.$packageName ) )
        Fs::del( $this->packagePath.'/'.$packageName );
  
      Fs::mkdir( $this->packagePath.'/'.$packageName.'/files' );
    }
    
    
    $codeTriggerEvents = $this->renderTriggerEvents();
    
    $this->script = <<<CODE
#!/bin/bash
# This is a automatically generated deployment script for WebFrap applications
# Version 0.9 WebFrap Tools

################################################################################
# Variables
################################################################################

# relevant path
deplPath="{$this->deployPath}"
packagePath=`pwd`
packagePath="\${packagePath}/"
fPath="\${packagePath}/files/"
gatewayName="{$this->gatewayName}"
codeOwner="{$this->codeOwner}"

# start/ende time
started=$(date +"%Y-%m-%d %H:%M:%S")
finished=""

# app related data
appName="{$this->appName}"
appVersion="{$this->appVersion}"
appRevision="{$this->appRevision}"

# settings flag
deplType="{$this->deplType}"
syncType="{$this->syncType}"
packageType="{$this->packageType}"


# status flag for the script
everyThinkOk=true;

################################################################################
# Functions
################################################################################

#if [ "$(whoami)" != "root" ];
#then
#   echo "Script need to be started as root"
#   exit
#fi

# echo and log
function writeLn {

	echo $1
	echo $1 >> \$packagePath/deploy.log
}

# touch or create file
function touchOrCreate {

	theDir=$(dirname \${deplPath}\${1})/;

	# create the path if not yet exists
  if [ ! -d \$theDir ]; then
      mkdir -p \$theDir
  fi
  
  # check if the creation was success full
  if [ ! -d \$theDir ]; then
  	writeLn "Failed to create folder \${deplPath}\${1}/"
  	exit 1;
  fi

  writeLn "touch file \${deplPath}\${1}" 
  touch \${deplPath}\${1}
  
}

# copy / deploy new files
function deploy {

  writeLn "deploy \${2} to \${deplPath}\${2}" 

  if [ ! -d "\${deplPath}\${1}/" ]; then
      mkdir -p \${deplPath}\${1}/
  fi
  
  if [ ! -d "\${deplPath}\${1}/" ]; then
  	writeLn "Failed to create folder \${deplPath}\${1}/"
  	exit 1;
  fi

  cp -f "\${fPath}\${2}" "\${deplPath}\${2}"
}

# copy / deploy new files
function deployPath {

	# create the path if not yet exists
  if [ ! -d "\${deplPath}\${1}/" ]; then
      mkdir -p \${deplPath}\${1}/
  fi
  
  # check if the creation was success full
  if [ ! -d "\${deplPath}\${1}/" ]; then
  	writeLn "Failed to create folder \${deplPath}\${1}/"
  	exit 1;
  fi

  writeLn "deploy folder \${1} to \${deplPath}\${1}" 
  cp -rf "\${fPath}\${1}" "\${deplPath}\${1}/../"
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

	command -v mail >/dev/null 2>&1 || { echo >&2 "Missing the mail command"; exit 1; }

	subject="{$this->appName} {$this->appVersion}.{$this->appRevision} deployment finished sucessfully."

	msg="Dear \${1}\\n"
	msg="\${msg}The deployment of {$this->appName} {$this->appVersion}.{$this->appRevision} was finished successfully.\\n\\n"
	msg="\${msg}Started: \${started} End: \${3}\\n"
	
  echo \$msg | mail -s \$subject $2

}

{$codeTriggerEvents}

# execute scripts
function executeScripts {
	
	# make shure to be in the package path
	cd \$packagePath

  if [ ! -d "\$packagePath/scripts/\${1}/" ]; then
  	# folder not even exists
  	writeLn "nothing to do for \${1}"
    return 0
  fi
	
  if [ ! "$(ls -A \$packagePath/scripts/\${1}/)" ]; then
  	# exists but empty
  	writeLn "no actions for \${1}"
    return 0
  fi

  # include scripts
  for file in "\$packagePath/scripts/\${1}/*"
  do
  	. \${file}
  	# make sure to be in the right path
  	cd \$packagePath
  done

}

function deploymentFailed {

	# if not execute the fail scripts
  if [ "install" == "\$deplType" ]; then
  	trigger_Fail_Install
  elif [ "update" == "\$deplType" ]; then
  	trigger_Fail_Update
  elif [ "uninstall" == "\$deplType" ]; then
  	trigger_Fail_Uninstall
  fi

}

function deploymentSuccess {

	# if not execute the fail scripts
  if [ "install" == "\$deplType" ]; then
  	trigger_Success_Install
  elif [ "update" == "\$deplType" ]; then
  	trigger_Success_Update
  elif [ "uninstall" == "\$deplType" ]; then
  	trigger_Success_Uninstall
  fi

}

function deploymentPre {

	# if not execute the fail scripts
  if [ "install" == "\$deplType" ]; then
  	trigger_Pre_Install
  elif [ "update" == "\$deplType" ]; then
  	trigger_Pre_Update
  elif [ "uninstall" == "\$deplType" ]; then
  	trigger_Pre_Uninstall
 	else
  	writeLn "Ok i got a unknown deployment type: \${deplType}. I assume you know what you are doing but be aware that this deployment will execute no scripts."
  fi
  
  if [ ! everyThinkOk ]; then
    deploymentFailed
  fi

}

function deploymentPost {

	# if not execute the fail scripts
  if [ "install" == "\$deplType" ]; then
  	trigger_Post_Install
  elif [ "update" == "\$deplType" ]; then
  	trigger_Post_Update
  elif [ "uninstall" == "\$deplType" ]; then
  	trigger_Post_Uninstall
  fi
  
  if [ ! everyThinkOk ]; then
    deploymentFailed
  fi

}

################################################################################
# Process logic
################################################################################


writeLn "Start deployment to \${deplPath} \${started}" 

# check parameters
if [ -n "$1" ]; then
  deplType=$1
fi

# try to guess the deployment type if not set or specified
if [ ! -n "\$deplType" ]; then

	writeLn "Got an untyped package, i try to guess now if this is a new installation or an update"

  if [ ! -d "\${deplPath}" ]; then
  	
  	writeLn "Deployment target: \${deplPath} does not exist. I assume this is an installation"
  	deplType="install"
    
  else
    if [ "$(ls -A \$deplPath)" ]; then
    	
    	writeLn "Deployment target: \${deplPath} exist and is not empty. I assume this is an update"
    	deplType="update"
    	
    else
      
    	writeLn "Got untyped package, system tries tu guess if this is an installation or an update"
    	deplType="install"
      
    fi
  
  fi
  
fi

# check if the deployment type fits to the package type
# install and uninstall are only valid for installer packages

if [ "patch" == "\$packageType" ]; then

  if [ ! "update" == "\$deplType" ]; then

  	writeLn "The install action \${deplType} is not applicale for \${packageType} packages."
  	writeLn "Your system was not changed"
  	writeLn "Shutting down the deployment process"
  	exit 2
  
  fi
  
fi

# unpack if not yet unpacked
if [ ! -d "./files" ]; then
	
	# unpack the data container
  tar xjvf files.tar.bz2 1>/dev/null
  
  # check if unpack was successfull before proceed
  if [ ! -d "./files" ]; then
  
      writeLn "Failed to unpack the data container. Deployment failed!"
  		deploymentFailed
      exit 1 
  fi
    
fi

# execute the pre deployment scripts, if an error occures the fail scripts
# will be also executed
writeLn "Execute the pre deployment scripts"

deploymentPre

CODE;
    
    
  }//end protected function setupPackage */
  
  
  /**
   */
  public function buildPackage(   )
  {
    
    $this->check();
    $this->setupPackage();
    $this->setupPackageScripts();
    

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
      
      if( !$this->noData )
      {
        foreach( $iterator as $deployPath => $localPath )
        {
          Fs::copy( $localPath, $pPath.$deployPath, false );
          
          //$this->script .= "deploy \"".Fs::getFileFolder($deployPath)."\" \"{$deployPath}\" ".NL;
        }
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
      
      if( !$this->noData )
      {
        Fs::copy( $this->codeRoot.$local, $pPath.$target, false );
      }
      
      $this->script .= "deploy \"".Fs::getFileFolder($target)."\" \"{$target}\" ".NL;
    }
    
    // then do the finetuning with files
    foreach( $this->touchFiles as $local => $target )
    {
      $this->script .= "touchOrCreate \"{$target}\" ".NL;
    }

    $this->script .= <<<CODE
    
writeLn "Execute the post deploment scripts"
    
# will also trigger fail if error
deploymentPost

# check if still everything ist ok
if [ everyThinkOk ]; then
	deploymentSuccess
fi

writeLn "Cleaning the temporary install files"
rm -rf ./files

CODE;

    foreach( $this->chowns as $chown )
    {
      $this->script .= "chown -R {$chown->owner} \"\${deplPath}{$chown->path}\"  ".NL;
    }

    foreach( $this->chmods as $chmod )
    {
      $this->script .= "chmod -R {$chmod->level} \"\${deplPath}{$chmod->path}\"  ".NL;
    }

    $this->script .= <<<CODE
    
finished=$(date +"%Y-%m-%d %H:%M:%S")

writeLn "Successfully finished deployment: \${finished}"
    
CODE;
    
    // notify stakeholders
    $this->script .= $this->renderNotifyMails();
     
    if( !$this->noData )
    {
      Fs::mkdir( $pPath );
      $oldDir = Fs::actualPath();
      Fs::chdir( $this->packagePath.'/'.$packageName.'/' );
      Archive::create( $this->packagePath.'/'.$packageName.'/files.tar.bz2', 'files' );
      Fs::chdir( $oldDir );
      Fs::del( $pPath );
    }
    
    Fs::write( $this->script, $this->packagePath.'/'.$packageName.'/deploy.sh' );
    
  }//end public function buildPackage */
  
  /**
   * 
   */
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

notifyStakeholder "{$notify->name}" "{$notify->mail}" finished
      
CODE;
      
    }
    
    return $code;
    
  }//end public function renderNotifyMails */
  
  /**
   * 
   */
  public function setupPackageScripts()
  {
    
    $packageName = $this->packageName.'-'.$this->appVersion.'.'.$this->appRevision;

    foreach( $this->scripts as $scriptType => $scripts )
    {
      
      Fs::mkdir( $this->packagePath.'/'.$packageName.'/scripts/'.$scriptType );
      
      foreach( $scripts as $script )
      {
        if( '/' === $script[0] )
        {
          if( file_exists( $script ) )
            Fs::copy( $script, $this->packagePath.'/'.$packageName.'/scripts/'.$scriptType.'/'.basename($script), false );
        }
        else
        {
          if( file_exists( GAIA_PATH.'bash/'.$script ) )
            Fs::copy( GAIA_PATH.'bash/'.$script, $this->packagePath.'/'.$packageName.'/scripts/'.$scriptType.'/'.basename($script),false );
        }
      }
      
    }

  }//end public function setupPackageScripts */

  /**
   * 
   */
  protected function renderTriggerEvents()
  {

    $code = '';

    foreach( $this->scripts as $scriptType => $scripts )
    {

      $scriptTypeKey = FormatString::subToCamelCase( $scriptType );

      $code .= <<<CODE

function trigger_{$scriptTypeKey} {

	cd \$packagePath

CODE;

      foreach( $scripts as $script )
      {

        $baseName = basename( $script );

        $code .= <<<CODE

	. ./scripts/{$scriptType}/{$baseName}
  # make shure we are in package path
  cd \$packagePath

CODE;

      }

        $code .= <<<CODE

}

CODE;

    }
    
    return $code;

  }//end protected function renderTriggerEvents *7
  
  
  /**
   * löschen des Temporären pfades
   */
  public function cleanTmp()
  {
    
    Fs::del( $this->tmpPath );
    
  }//end public function cleanTmp */

}//end class Update_Model */
