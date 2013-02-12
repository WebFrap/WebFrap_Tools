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

///
/// NEIN, DIES DATEI ERHEBT NICHT DEN ANSPRUCH OOP ZU SEIN.
/// ES IS EXPLIZIT AUCH NICHT ALS OOP GEWOLLT.
/// DIE KLASSEN WERDEN LEDIGLICH ALS CONTAINER ZUM ORGANISIEREN DER FUNKTIONEN VERWENDET.
/// JA DAS IST VIEL CODE FÜR EINE DATEI, NEIN ES IST KEIN PROBLEM
/// NEIN ES IST WIRKLICH KEIN PROBLEM, SOLLTE ES DOCH ZU EINEM WERDEN WIRD ES
/// GELÖST SOBALD ES EINS IST
/// Danke ;-)
///

/**
 * Klasse für das Management eines Mercurial Repository
 * @package WebFrap
 * @subpackage Gaia
 */
class Hg
{

  /**
   * Eine Temporäre HGRC erstellen, wird bei Proxies benötigt
   * und wenn user und pwd nicht direkt in der URL erscheinen sollen
   *
   * @param string $deplPath
   * @param array $repos
   * @param string $displayName
   * @param string $userName
   * @param string $userPassd
   * @param string $proxy
   */
  public static function createTmpRc
  (
    $deplPath,
    $repos,
    $displayName,
    $userName,
    $userPassd,
    $proxy = null
  )
  {

    $hgRc = <<<CODE

[ui]
username = {$displayName}

[web]
name = {$userName}

[trusted]
users = *
groups = *

CODE;

    // wenn durch einen proxy hindurchgesynct werden soll
    if ($proxy) {

      $hgRc .= <<<CODE
[http_proxy]
host = {$proxy}
user = {$userName}
passwd = {$userPassd}

CODE;

    }

    $hgRc .= <<<CODE
[auth]

CODE;

    foreach ($repos as $repoKey => $listRepos) {

      $repoPath = $listRepos['path'];

      foreach ($listRepos['repos'] as $repo => $tmpUrl) {

        $key = str_replace('-','_',$repoKey);

        $hgRc .= <<<CODE

{$repo}_{$key}.prefix = {$tmpUrl['url']}{$repo}
{$repo}_{$key}.username = {$userName}
{$repo}_{$key}.password = {$userPassd}
{$repo}_{$key}.schemes = https

CODE;

      }
    }

    $rcPath = GAIA_PATH;

    if( !Fs::exists( $rcPath ) )
      Fs::mkdir( $rcPath );

    file_put_contents(  $rcPath.'.hgrc' , $hgRc  );
    putenv( "HGRCPATH={$rcPath}.hgrc" );

  }//end public static function createTmpRc */

  /**
   * Repository clonen
   * @param string $url
   * @param string $repo
   * @param string $user
   * @param string $pwd
   */
  public static function cloneRepo( $url, $repo, $user = null, $pwd = null )
  {

    // es wird nur https zugelassen. punkt
    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else
      $url = 'https://'.$url;

    Process::run( 'hg clone "'.$url.'" "'.$repo.'"' );

  }//end public static function cloneRepo */

  /**
   * Direkt ein bestimmtes Archiv vom Server laden anstelle zuerst zu clonen.
   *
   * @param string $repo
   * @param string $type
   * @param string $rev
   * @param string $user
   * @param string $pwd
   */
  public static function getArchive( $url, $type, $rev = null, $user = null, $pwd = null )
  {

    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else
      $url = 'https://'.$url;

    Process::run( 'wget "'.$url.'"' );

  }//end public static function getArchive */

  /**
   * Ein Archive aus einem geclonten repository erstellen
   * @param string $repo
   */
  public static function archive( $target )
  {

    Process::run( 'hg archive "'.$target.'"' );

  }//end public static function archive */

  /**
   * Repository clonen
   * @param string $rev
   */
  public static function update( $rev = null  )
  {

    $command = "hg update";

    if ($rev) {

      $tmp = explode( ':',$rev  );

      if( $rev[0] == 'ref' )
        $command .= "-C -r ".$rev[1];
      else
        $command .= " ".$rev[1].'  -C';
    } else {
      $command .= ' -C';
    }

    Process::run( $command );

  }//end public static function update */

  /**
   * Änderungen commiten
   */
  public static function commit( $message = 'Autocommit' )
  {

    Process::run( 'hg commit -A -m "'.$message.'"' );

  }//end public static function commit */

  /**
   * Auf einen Server pushen
   * @param string $url
   * @param string $user
   * @param string $pwd
   */
  public static function push( $url, $user = null, $pwd = null    )
  {

    // es wird nur https zugelassen. punkt
    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else
      $url = 'https://'.$url;

    $message = Process::execute( 'hg push -f "'.$url.'"' );

    Console::outln( $message );

  }//end public static function push */

  /**
   * Von einem Server pullen
   * @param string $url
   * @param string $user
   * @param string $pwd
   */
  public static function pull( $url, $user = null, $pwd = null )
  {

    // es wird nur https zugelassen. punkt
    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else
      $url = 'https://'.$url;

    Process::run( 'hg pull -f "'.$url.'"' );

  }//end public static function pull */

  /**
   * Methode zum synchronisieren mehrere Repositories zwischen einem Lokalen
   * Repository Server und einem oder meheren anderen Repository Servern
   *
   * @param array $repos
   */
  public static function sync( $repos, $contactMail )
  {

    foreach ($repos as $repoKey => $listRepos) {
      $repoPath = $listRepos['path'];

      foreach ($listRepos['repos'] as $repoName => $repoData) {
        if ( Fs::exists( $repoPath.'/'.$repoName) ) {

          Fs::chdir( $repoPath.'/'.$repoName );

          Console::chapter( "Sync {$repoData['url']}{$repoName} ", true );

          Console::startBlock(  );
          Hg::pull
          (
            $repoData['url'].$repoName,
            (isset($repoData['user'])?$repoData['user']:null),
            (isset($repoData['pwd'])?$repoData['pwd']:null)
          );

          Hg::push
          (
            $repoData['url'].$repoName,
            (isset($repoData['user'])?$repoData['user']:null),
            (isset($repoData['pwd'])?$repoData['pwd']:null)
          );

          Console::endBlock();

        } else {

          Console::chapter( "Clone {$repoData['url']}{$repoName} ", true  );
          Console::startBlock(  );
          Fs::chdir( $repoPath );

          Hg::cloneRepo
          (
            $repoData['url'].$repoName,
            $repoPath.'/'.$repoName,
            (isset($repoData['user'])?$repoData['user']:null),
            (isset($repoData['pwd'])?$repoData['pwd']:null)
          );

          // hgweb.config sollte bitte existieren, sonst schreiben wir keine
          if ( Fs::exists( $repoPath.'hgweb.config' ) ) {
            Process::run( 'echo "'.$repoName.' = ' .$repoPath.'/'.$repoName.'" >> hgweb.config' );
            Process::run( 'echo "[web]" > ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "contact = '.$contactMail.'" >> ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "allow_archive = gz, zip, bz" >> ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "allow_push = *' );
          }

          Console::endBlock();

        }

      }//end foreach

    }//end foreach

  }//end public static function sync */

  /**
   * Methode zum synchronisieren mehrere Repositories zwischen einem Lokalen
   * Repository Server und einem oder meheren anderen Repository Servern
   *
   * @param array $repos
   * @param string $repoPath
   * @param string $contactMail
   */
  public static function checkout( $repos, $repoPath, $contactMail )
  {

    foreach ($repos as $repoKey => $listRepos) {
      $repoPath = $listRepos['path'];

      if( !Fs::exists( $repoPath ) )
        Fs::mkdir( $repoPath );

      foreach ($listRepos['repos'] as $repoName => $repoData) {
        if ( Fs::exists( $repoPath.'/'.$repoName) ) {

          Fs::chdir( $repoPath.'/'.$repoName );

          Console::chapter( "Sync {$repoData['url']}{$repoName} ", true );

          Console::startBlock(  );
          Hg::pull
          (
            $repoData['url'].$repoName,
            (isset($repoData['user'])?$repoData['user']:null),
            (isset($repoData['pwd'])?$repoData['pwd']:null)
          );

          Console::endBlock();

        } else {

          Console::chapter( "Clone {$repoData['url']}{$repoName} ", true  );
          Console::startBlock(  );
          Fs::chdir( $repoPath );

          Hg::cloneRepo
          (
            $repoData['url'].$repoName,
            $repoPath.'/'.$repoName,
            (isset($repoData['user'])?$repoData['user']:null),
            (isset($repoData['pwd'])?$repoData['pwd']:null)
          );

          // hgweb.config sollte bitte existieren, sonst schreiben wir keine
          if ( Fs::exists( $repoPath.'hgweb.config' ) ) {
            Process::run( 'echo "'.$repoName.' = ' .$repoPath.'/'.$repoName.'" >> hgweb.config' );
            Process::run( 'echo "[web]" > ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "contact = '.$contactMail.'" >> ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "allow_archive = gz, zip, bz" >> ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "allow_push = *' );
          }

          Console::endBlock();

        }

      }//end foreach

    }//end foreach

  }//end public static function sync */

  /**
   * @param string $message
   */
  public static function checkError( $message )
  {

    if( false !== strpos( $message, 'abort: HTTP Error 404: Not Found' ) )

      return 'Repository not exists';

    if( false !== strpos( $message, 'abort: push creates new remote head' ) )

      return 'Push aborted cause of a conclict';

    if( false !== strpos( $message, 'abort: crosses branches' ) )

      return 'Repository has unresolved conflicts';

    return null;
  }//end public static function checkError */

}//end class Hg */