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
 * @subpackage Tools
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class PackageBuilder_Repo_Iterator
  extends IoFolderIterator
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $fileName = null;

  /**
   * @var array
   */
  public $repos = array();

  /**
   * @var DOMNameList
   */
  public $repoFolders = null;

  /**
   * @var string
   */
  public $repoName = null;

  /**
   * @var string
   */
  public $componentIdx = 0;

  /**
   * @var string
   */
  public $targetFolder = null;

  /**
   * @var string
   */
  public $deployRoot = null;

  /**
   * @var string
   */
  public $key = null;

  /**
   * @var PackageBuilder_File_Iterator
   */
  protected $activFolder = null;

  /**
   * Der Original Branch des aktuellen Repositories
   * @var string
   */
  protected $activRepoBranch = null;

  /**
   * Der Type des aktuellen Repositories
   * @var string
   */
  protected $activRepoType = null;

  /**
   * Der Type des aktuellen Repositories
   * @var IsAVcsAdapter
   */
  protected $activRepo = null;

  /**
   * @var string
   */
  protected $codeRoot = null;

  /**
   * @param stdObj{name} $repos
   * @param string $targetFolder
   */
  public function __construct( $repos, $deployRoot = null, $codeRoot = PATH_ROOT  )
  {

    $this->repos      = $repos;
    $this->deployRoot  = $deployRoot;
    $this->targetFolder = null;
    $this->codeRoot    = $codeRoot;

    $this->next();

  }// public function __construct

////////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
////////////////////////////////////////////////////////////////////////////////

  /**
   * @see Iterator::key
   */
  public function key ()
  {
    return $this->key;
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next ()
  {

    if (!$this->repos) {
      return null;
    }

    $tmp     = null;
    $doAgain = true;

    while ($doAgain) {

      $doAgain = false;
      $current = null;

      // wir haben einen aktiven folder
      if ($this->activFolder) {
        $current = $this->activFolder->current();
        $key     = $this->activFolder->key();

        if (!$current) {
          $this->activFolder = null;
          $this->current     = null;
          $this->key         = null;
          $doAgain = true;
          continue;
        } else {
          $this->activFolder->next();
          $this->current = $current;
          $this->key     = $key;

          break;
        }

      }

      // wir haben eine aktive componente
      if ($this->repoFolders) {
        $activFolder = current( $this->repoFolders );
        next($this->repoFolders);

        if ($activFolder) {
          $repoName     = $this->repoName;

          $this->activFolder = new PackageBuilder_File_Iterator
          (
            $this->codeRoot.$this->repoName.'/'.$activFolder->name,
            str_replace( '//', '/', $this->targetFolder.$activFolder->name ),
            IoFileIterator::RELATIVE,
            (isset($activFolder->recursive) && trim($activFolder->recursive)  ==  'false' ?false :true ),
            (isset($activFolder->filter) && trim($activFolder->filter)  !='' ?trim($activFolder->filter) :null )
          );

          $doAgain = true;
          continue;
        } else {
          $this->activFolder = null;
          $this->repoFolders = null;
        }
      }

      // das noch aktuelle repo zurücksetzen
      if ($this->activRepo) {
        $this->activRepo->switchBranch( $this->activRepoBranch );
      }

      $next = current($this->repos);

      if (!$next) {
        $this->activFolder = null;
        $this->repoFolders = null;
        $this->current     = null;
        break;
      } else {
        next($this->repos);
        $this->repoFolders = array();

        foreach ($next->folders as $folder) {
          $this->repoFolders[] = $folder;
        }

        $this->repoName    = $next->name;

        $target = $this->repoName;

        if( isset($next->target) )
          $target = $next->target;

        $this->targetFolder = $target.'/' ;

        $repoType = null;

        if( isset( $next->repo_type ) )
          $repoType = $next->repo_type;

        if ($repoType) {
          $this->activRepoType = FormatString::subToCamelCase( $repoType );
          $this->activRepo     = VcsManager::useRepository
          (
            $this->activRepoType,
            $this->codeRoot.$this->repoName.'/'
          );

         if ( $this->activRepo->isRepository() ) {
           $this->activRepoBranch = $this->activRepo->getActualBranch();

           $branch = $next->getAttribute( 'branch' );

           if( $branch )
             $this->activRepo->switchBranch( $branch );
         } else {
           $this->activRepoType   = null;
           $this->activRepo       = null;
           $this->activRepoBranch = null;
         }

        } else {
          $this->activRepoType   = null;
          $this->activRepo       = null;
          $this->activRepoBranch = null;
        }

        $doAgain = true;
        continue;
      }

    }

    return $this->current;

  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    $this->repoFolders = null;
    $this->repoName    = null;
    $this->key        = null;
    $this->current     = null;

    if ($this->repos) {
      reset( $this->repos );
    }

    $this->next();

  }//end public function rewind */

}//end class PackageBuilder_Repo_Iterator */

