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
 * @subpackage Pontos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class PackageBuilder_Component_Iterator
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
  public $components = array();

  /**
   * @var DOMNameList
   */
  public $componentFolders = null;

  /**
   * @var string
   */
  public $componentName = null;

  /**
   * @var string
   */
  public $componentType = null;

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
  public $key = null;

  /**
   * @var array
   */
  public $typeFolderMap = array
  (
    'module'      => 'code',
    'core_module' => 'code',
    'code'        => 'code',
    'framework'   => 'code',
    'webfrap'     => 'code',
    'lib'         => 'code',
    'docu'        => 'docu',
    'db_dump'     => 'db_dump',
    'wgt'         => 'wgt',
    'ui_theme'    => 'ui_theme',
    'icon_theme'  => 'icon_theme',
    'gateway'     => 'gateway',
    'vendor'      => 'vendor',
    'metadata'    => 'metadata'
  );

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
   * @param [DOMNode] $components
   * @param string $targetFolder
   */
  public function __construct( $components, $targetFolder = '/code', $codeRoot = PATH_ROOT  )
  {

    $this->components = array();
    foreach ($components as $component) {
      $this->components[] = $component;
    }

    $this->targetFolder = $targetFolder.'/';

    $this->codeRoot = $codeRoot;

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

    if (!$this->components) {
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
      if ($this->componentFolders) {
        $activFolder = current( $this->componentFolders );
        next($this->componentFolders);

        if ($activFolder) {
          $componentName     = $this->componentName;

          $this->activFolder = new PackageBuilder_File_Iterator
          (
            $this->codeRoot.$this->componentName.'/'.$activFolder->getAttribute('name'),
            str_replace( '//', '/', $this->targetFolder.$activFolder->getAttribute('name') ),
            IoFileIterator::RELATIVE,
            (trim($activFolder->getAttribute('recursive'))  ==  'false' ?false :true ),
            (trim($activFolder->getAttribute('filter'))  !='' ?trim($activFolder->getAttribute('filter')) :null )
          );

          $doAgain = true;
          continue;
        } else {
          $this->activFolder      = null;
          $this->componentFolders = null;
        }
      }

      // das noch aktuelle repo zurücksetzen
      if ($this->activRepo) {
        $this->activRepo->switchBranch( $this->activRepoBranch );
      }

      $next = current($this->components);

      if (!$next) {
        $this->activFolder      = null;
        $this->componentFolders = null;
        $this->current          = null;
        break;
      } else {
        next($this->components);
        $this->componentFolders = array();
        $folders = $next->getElementsByTagName('folder');

        foreach ($folders as $folder) {
          $this->componentFolders[] = $folder;
        }

        $this->componentName    = $next->getAttribute('name');

        $type = $next->getAttribute('type');
        if( !$type )
          $type = 'code';

        $this->componentType    = $type;

        $target = $next->getAttribute('target');
        if( !$target )
          $target = $this->componentName;

        $this->targetFolder = (
          isset($this->typeFolderMap[$type])
            ? $this->typeFolderMap[$type].'/'
            : 'code/'
        ).$target.'/' ;

        $repoType = $next->getAttribute( 'repo_type' );

        if ($repoType) {
          $this->activRepoType = FormatString::subToCamelCase( $repoType );
          $this->activRepo     = VcsManager::useRepository
          (
            $this->activRepoType,
            $this->codeRoot.$this->componentName.'/'
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

        UiConsole::debugLine( "Got component {$this->componentName} target {$this->targetFolder}" );

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
    $this->componentFolders  = null;
    $this->componentName     = null;
    $this->key               = null;
    $this->current           = null;

    if ($this->components) {
      reset( $this->components );
    }

    $this->next();

  }//end public function rewind */

}//end class PackageBuilder_Component_Iterator */

