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
class SyncHg_Model
  extends MvcModel
{
  
  public $tmpPath = null;
  
  /**
   * @param SyncHg_Conf $conf
   * @param array $repos
   */
  public function setEnv( $conf, $repos )
  {
    
    $this->tmpPath = Gaia::mkTmpFolder();
    
    $hgRc = <<<CODE
[ui]
username = {$conf->displayName}

[web]
name = {$conf->userName}

[trusted]
users = *
groups = *

[auth]

CODE;

    foreach( $repos as $repoKey => $listRepos )
    {
      foreach( $listRepos as $repo )
      {
    
        $key = str_replace('-','_',$repoKey);
    
        $hgRc .= <<<CODE
    
    {$repo}_{$repoKey}.prefix = {$reposPaths[$repoKey]}{$repo}
    {$repo}_{$repoKey}.username = {$repo_user}
    {$repo}_{$repoKey}.password = {$repo_pwd}
    {$repo}_{$repoKey}.schemes = https

CODE;
    
      }
    }
  
    file_put_contents( $this->tmpPath.'.hgrc' , $hgRc  );
    putenv("HGRCPATH={$this->tmpPath}.hgrc");
    
  }//end public function setEnv */
  

}//end class SyncHg_Model */
