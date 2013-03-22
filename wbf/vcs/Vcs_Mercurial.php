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
 * @subpackage WebFrap
 *
 */
class Vcs_Mercurial
  implements IsAVcsAdapter
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $repoKey = 'SomeRepo';

  /**
   * @var string
   */
  public $repoPath = null;
  
  /**
   * @var string
   */
  public $origPath = null;
  
  /**
   * @var string
   */
  public $userName = null;
  
  /**
   * @var string
   */
  public $userPasswd = null;
  
  /**
   * @var string
   */
  public $displayName = null;
  
  /**
   * @var string
   */
  public $syncUrl = null;
  
  /**
   * @var string
   */
  public $proxyUrl = null;
  
  /**
   * @var string
   */
  public $proxyUser = null;
  
  /**
   * @var string
   */
  public $proxyPwd = null;
  
  /**
   * @var string
   */
  public $hgrcPath = null;
  
  /**
   * @var string
   */
  public $bin = 'hg';
  
  /**
   * @var ProtocolWriter
   */
  public $protocol = null;
  
  /**
   * Flag die anzeigt ob das aktuelle Repo in Usage ist
   * @var boolean
   */
  public $used = false;
  
////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param sting $repoPath
   * @param sting $displayUser (Wird nicht zum lesen benötigt)
   * @param sting $repoKey (Wird nicht zum lesen benötigt)
   */
  public function __construct($repoPath, $displayUser = null, $repoKey = 'SomeRepo')
  {
    
    $this->repoPath    = $repoPath;
    $this->displayName = $displayUser;
    $this->repoKey     = $repoKey;

  }//end public function __construct */
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Sicher stellen, dass ein Repository verwendet werden kann
   */
  public function startUsage()
  {
    
    if ($this->used)
      return false;
    
    if (!$this->origPath)
      $this->origPath = getcwd().'/';
      
    // sicher stellen, dass die richtigen hg rc informationen verwendet werden
    if ($this->hgrcPath)
      putenv("HGRCPATH={$this->hgrcPath}");
    
    if ($this->origPath != $this->repoPath)
      chdir($this->repoPath);
      
    $this->used = true;
    
    return true;
      
  }//end public function startUsage */
  
  /**
   * zurück in den alten pfad springen
   * Repo benutzung unterbrechen
   */
  public function endUsage()
  {
    
    if ($this->origPath != $this->repoPath)
      chdir($this->origPath);
    
    $this->used = false;
      
  }//end public function endUsage */

  /**
   * @param string $syncUrl
   * @param string $userName
   * @param string $userPwd
   */
  public function open( $syncUrl = null, $userName = null, $userPwd = null)
  {
    
    $this->origPath = getcwd().'/';
    $this->buildEnv($syncUrl, $userName, $userPwd);
    
  }//end public function open */
  
  /**
   * 
   */
  public function close()
  {
    
    if ($this->hgrcPath)
      Fs::del($this->hgrcPath);
    
  }//end public function close */

  
  /**
   * Setzen eines Proxies für den sync
   * 
   * @param string $proxyUrl
   * @param string $proxyUser
   * @param string $proxyPasswd
   */
  public function setProxy($proxyUrl, $proxyUser, $proxyPasswd) 
  {
    
    $this->proxyUrl = $proxyUrl;
    $this->proxyUser = $proxyUser;
    $this->proxyPasswd = $proxyPasswd;
    
  }//end public function setProxy */
  
  /**
   * Setzen eines Protocol Writers
   * 
   * @param string $protocol
   */
  public function setProtocol($protocol) 
  {
    
    $this->protocol = $protocol;
    
  }//end public function setProtocol */
  
////////////////////////////////////////////////////////////////////////////////
// Metadata
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @return 
   */
  public function getVersion()
  {
    
  }//end public function getVersion */
  
  /**
   * @return 
   */
  public function getType()
  {
    return 'mercurial';
  }//end public function getVersion */
  
  /**
   * Prüfen ob das Repository überhaupt schon initialisiert ist
   * 
   * @return boolean
   */
  public function isRepository()
  {
    
    return Fs::exists($this->repoPath.'/.hgrc'); 
    
  }//end public function isRepository */
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * Bauen der HGRC
   * @param string $syncUrl
   * @param string $userName
   * @param string $userPwd
   */
  public function buildEnv($syncUrl = null, $userName = null, $userPwd = null)
  {
    
    if ($this->hgrcPath)
    {
      putenv("HGRCPATH={$this->hgrcPath}");
      return;
    }
    
    if (!$this->syncUrl)
      $this->syncUrl = $syncUrl;
      
    if (!$this->userName)
      $this->userName = $userName;
      
    if (!$this->userPasswd)
      $this->userPasswd = $userPwd;

    if (!$syncUrl)
      $syncUrl = $this->syncUrl;
      
    if (!$userName)
      $userName = $this->userName;
      
    if (!$userPwd)
      $userPwd = $this->userPasswd;

    $hgRc = <<<HGRC
[ui]
username = {$this->displayName}

[web]
name = {$this->userName}

[trusted]
users = *
groups = *

HGRC;

    if ($this->proxyUrl)
    {
    
    $hgRc .= <<<HGRC
[http_proxy]
host = {$this->proxyUrl}
user = {$this->proxyUser}
passwd = {$this->proxyPwd}

HGRC;

    }
    
    $hgRc .= <<<HGRC
[auth]
{$this->repoKey}.prefix = {$syncUrl}
{$this->repoKey}.username = {$userName}
{$this->repoKey}.password = {$userPwd}
{$this->repoKey}.schemes = https

HGRC;

    $tmpFolder = Gaia::mkTmpFolder();
    $this->hgrcPath = $tmpFolder.'.hgrc';
    
    Fs::write($hgRc, $this->hgrcPath);
    
    putenv("HGRCPATH={$this->hgrcPath}");

  }//end public function buildEnv */
  
  /**
   * @param string $branch
   */
  public function update($branch = null)
  {
    
    if ($branch)
      return $this->sendCommand("{$this->bin} update \"{$branch}\"");
    else 
      return $this->sendCommand("{$this->bin} update");

  }//end public function update */
  
  /**
   * @param string $message
   */
  public function commit($message)
  {
    
    if (!$this->displayName)
    {
      throw new GaiaException("Aborted commit... Displayname is missing");
    }
    
    $this->sendCommand("{$this->bin} commit -A -u \"{$this->displayName}\" -m \"{$message}\"");
    
  }//end public function commit */
  
  
  /**
   * @param boolean $justCheckChanges nur prüfen ob es Änderungen gab
   * @return string|boolean
   */
  public function status($justCheckChanges = false)
  {
      
    $status = $this->sendCommand("{$this->bin} status");
    
    if ($justCheckChanges)
    {
      return ('' == trim($justCheckChanges));
    }
    
    return $status;
    
  }//end public function status */
  
  /**
   * 
   */
  public function push()
  {

    
  }//end public function push */
  
  /**
   * 
   */
  public function pull()
  {

  }//end public function pull */
  
  /**
   * @param string $branch
   * @return string
   */
  public function switchBranch($branch)
  {

    $this->sendCommand($this->bin.' update '.$branch);
    
  }//end public function switchBranch */
  
  /**
   * @param string $syncMessage
   * @todo Error Handling
   */
  public function sync
  (
    $syncMessage = 'this is an auto commit for synchronizing the repository with the master' 
  )
  {
    
    $this->startUsage();
    
    if (file_exists($this->repoPath))
    {
      Process::execute($this->bin." add");
      Process::execute($this->bin.' commit -m "'.$syncMessage.'"');
      Process::execute($this->bin.' pull -f "https://'.$this->syncUrl.'"');
      Process::execute($this->bin.' update');
      Process::execute($this->bin.' push -f "https://'.$this->syncUrl.'"');
    }
    else
    {
      Fs::touchFileFolder($this->repoPath);
      Process::execute($this->bin.' clone "https://'.$this->syncUrl.'" "'.$this->repoPath.'"');
    }
    
    $this->endUsage();
    
  }//end public function pull */
  
////////////////////////////////////////////////////////////////////////////////
// Heads
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param string $branch
   * @return string
   */
  public function getHead($branch)
  {
    
    $tmp   = $this->sendCommand($this->bin." heads {$branch} -q");
    $heads = explode("\n", $tmp);

    if (1 == count($heads))
      return $heads[0];
    else 
      return $heads;

  }//end public function getHead */
  
  
  /**
   * @param string $branch
   * @return array
   */
  public function getHeads()
  {
    
    $tmp   = $this->sendCommand($this->bin." heads -q");
    $heads = explode("\n", $tmp);
    
    return $heads;
    
  }//end public function getHeads */
  
////////////////////////////////////////////////////////////////////////////////
// Branches
////////////////////////////////////////////////////////////////////////////////
  
  
  /**
   * @return [string]
   */
  public function getBranches()
  {
    
    $tmp = $this->sendCommand("hg branches -q");
    $branches = explode("\n", $tmp);
    
    return $branches;
    
  }//end public function getBranches */
  
  /**
   * Prüfen ob ein bestimmter Branch aktuell vorhanden ist
   * 
   * @param string $branch
   * @return boolean
   */
  public function hasBranch($branch)
  {
    
    $tmp = $this->sendCommand("hg branches -q");
    $branches = explode("\n", $tmp);

    return in_array($branch, $branches);
    
  }//end public function hasBranch */
  
  /**
   * @return string
   */
  public function getActualBranch()
  {

    return $this->sendCommand("hg branch -q");
    
  }//end public function pull */
  
////////////////////////////////////////////////////////////////////////////////
// Merge Logic
////////////////////////////////////////////////////////////////////////////////
  
  
  /**
   * @param string $target
   * @param string $source
   * @param string $commitMessage
   */
  public function mergeBranches($target, $source, $commitMessage = null)
  {
    
    $this->startUsage();
    
    if ($this->status(true))
    {
      if (!$commitMessage)
        $commitMessage = "Commit Changes before merge {$source} in {$target}";
        
      $this->commit($commitMessage);
    }
    
    $actualBranch = $this->getActualBranch();

    if ($target != $actualBranch)
    {
      $this->switchBranch($target);
    }
    
    $this->command("merge {$source}");
    $this->command('commit -m "Merge '.$source.' in '.$target.'"');
    
    /*
    if ($this->status(true))
    {
      $this->command('commit -m "Merge '.$source.' in '.$target.'"');
    }*/
    
    if ($target != $actualBranch)
    {
      $this->switchBranch($actualBranch);
    }
    
    $this->endUsage();
    
  }//end public function mergeBranches */
  
////////////////////////////////////////////////////////////////////////////////
// Helper Logic
////////////////////////////////////////////////////////////////////////////////
  
  
  /**
   * @param string $command
   * @return string
   */
  protected function sendCommand($command)
  {
    
    $started = $this->startUsage();
    $val = Process::execute($command);
    
    if ($started)
      $this->endUsage();
    
    return $val;
    
  }//end protected function sendCommand */
  
  /**
   * @param string $command
   * @return string
   */
  protected function command($command)
  {

    $val = Process::execute($this->bin.' '.$command);
    
    echo $val."\n";
    return $val;
    
  }//end protected function command */

}// end class Vcs_Mercurial

