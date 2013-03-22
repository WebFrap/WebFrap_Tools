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

// definieren, dass dies ein Syncscript ist
define('GAIA_CONTEXT', 'sync');

// die Basis Logik einbinden
// hier wird auch das entsprechende conf / settingsfile eingebunden
// in welchem die hier verwendetetn Variablen vorhanden sind.
include 'wbf/bootstrap.php';

/* @var $console UiConsole */

$console->info("Start sync", true);

// eine Temporäre HG RC Datei erstellen, wird benötigt
// um die Passwörter nicht in die URL packen zu müssen oder bei Proxies
Hg::createTmpRc
(
  $repoRoot,
  $syncRepos,
  $displayName,
  $repoUser,
  $repoPwd
);

Hg::sync($syncRepos, $contactMail);
Fs::chown($repoRoot, $repoOwner);


Console::footer("Finished sync ", true);










