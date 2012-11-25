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


////////////////////////////////////////////////////////////////////////////////
// Datenbank informationen
////////////////////////////////////////////////////////////////////////////////

/**
 * Für das Setup der Datenbank nötige Angaben
 * @var array
 */
$conf->databases = array
(
  'default' => array
  (
    'type' => 'Postgresql',
    'host' => '127.0.0.1',
    'port' => '5432',
    'db_name'     => 'gaia_test',
    'schema_name' => 'gaia_test',
    'user_name'   => 'gaia',
    'passwd'      => 'gaia',
    'ssl'         => true,
  )
);

/**
 * Name des Users welcher in Logs angezeigt werden soll
 * @var array
 */
$conf->displayUser = 'Dominik Bonsch';

/**
 * Für das Setup der Datenbank nötige Angaben
 * @var array
 */
$conf->repositories = array
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

