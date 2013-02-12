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
class Vcs_Model
  extends MvcModel
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var ConfMaintenance
   */
  public $conf = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $confKey
   */
  public function loadConf( $confKey )
  {

    $this->conf = $this->getConf( $confKey );

  }//end public function loadConf */

  /**
   * @param string $confKey
   * @return ConfMaintenance
   */
  public function getConf( $confKey )
  {

    $conf = new ConfMaintenance();
    $conf->load( $confKey );

    return $conf;

  }//end public function getConf */

  /**
   * @param string $branch
   */
  public function switchToBranch( $branch )
  {

    $console = $this->getConsole();
    $repos   = $this->conf->getRepositories();

    /* Datenstruktur
      $repos = array
      (
        'WebFrap' => array
        (
          'type' => 'Mercurial',
          'path' => '/var/www/workspace/WebFrap/',
          'development_branch' => 'development',
          'testing_branch'     => 'testing',
          'stable_branch'      => 'stable',
        )
      );
     */

    foreach ($repos as $repoKey => $repoData) {

      $repository = VcsManager::useRepository
      (
        FormatString::subToCamelCase($repoData['type']),
        $repoData['path'],
        $this->conf->displayUser,
        $repoKey
      );

      if ( $repository->hasBranch( $branch ) ) {

        if ( $repository->status(true) ) {
          $repository->commit( "Commit changes before switching to branch: {$branch}" );
        }

        $console->info( "Switched: {$repoKey} to branch: {$branch}" );
        $repository->switchBranch( $branch );

      } else {
        $console->warning( "Repository: {$repoKey} in: {$repoData['type']} has no branch: {$branch}" );
      }

    }

  }//end public function switchToBranch */

  /**
   */
  public function setTesting(  )
  {

    $console = $this->getConsole();
    $repos   = $this->conf->getRepositories();

    /* Datenstruktur
      $repos = array
      (
        'WebFrap' => array
        (
          'type' => 'Mercurial',
          'path' => '/var/www/workspace/WebFrap/',
          'development_branch' => 'development',
          'testing_branch'     => 'testing',
          'stable_branch'      => 'stable',
        )
      );
     */

    foreach ($repos as $repoKey => $repoData) {

      $repository = VcsManager::useRepository
      (
        FormatString::subToCamelCase($repoData['type']),
        $repoData['path'],
        $this->conf->displayUser,
        $repoKey
      );

      if
      (
        isset( $repoData['development_branch'] )
          && isset( $repoData['testing_branch'] )
          && $repository->hasBranch( $repoData['development_branch'] )
          && $repository->hasBranch( $repoData['testing_branch'] )
      )
      {
        $console->info( "Merge: {$repoKey} development: {$repoData['development_branch']}  to testing: {$repoData['testing_branch']}" );
        $repository->mergeBranches( $repoData['testing_branch'], $repoData['development_branch'] );
      } else {
        $console->warning( "Missing required Branches or Informations to set the repository: {$repoKey} to testing." );
      }

    }

  }//end public function setTesting */

  /**
   */
  public function setStable(  )
  {

    $console = $this->getConsole();
    $repos   = $this->conf->getRepositories();

    /* Datenstruktur
      $repos = array
      (
        'Mercurial_Test' => array
        (
          'type' => 'Mercurial',
          'path' => '/var/www/workspace/Mercurial_Test/',
          'development_branch' => 'development',
          'testing_branch'     => 'testing',
          'stable_branch'      => 'stable',
        )
      );
    */

    foreach ($repos as $repoKey => $repoData) {

      $repository = VcsManager::useRepository
      (
        FormatString::subToCamelCase( $repoData['type'] ),
        $repoData['path'],
        $this->conf->displayUser,
        $repoKey
      );

      if
      (
        isset( $repoData['testing_branch'] )
          && isset( $repoData['stable_branch'] )
          && $repository->hasBranch( $repoData['testing_branch'] )
          && $repository->hasBranch( $repoData['stable_branch'] )
      )
      {
        $console->info( "Merge: {$repoKey} testing: {$repoData['testing_branch']} to stable: {$repoData['stable_branch']}" );
        $repository->mergeBranches( $repoData['stable_branch'], $repoData['testing_branch'] );
      } else {
        $console->warning( "Missing required Branches or Informations to set the repository: {$repoKey} to stable." );
      }

    }

  }//end public function setStable */

}//end class Vcs_Model */
