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
    'db_name'     => 'gw_webfrap_net',
    'schema_name' => 'webfrap_net',
    'user_name'   => 'webfrap_net',
    'passwd'      => 'webfrap_net',
    'ssl'         => true,
  )
);

/**
 * Name des Users welcher in Logs angezeigt werden soll
 * @var array
 */
$conf->workspace = '/var/www/WorkspaceWebFrap/';

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
  'WebFrap' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Pontos' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Pontos/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Daidalos' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Daidalos/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Wgt' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Wgt/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_42_Business' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_42_Business/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_42_Core' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_42_Core/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Genf' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Genf/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Genf_Cartridge_Wbf' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Genf_Cartridge_Wbf/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Icons_Default' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Icons_Default/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Kb_Base' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Kb_Base/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Pontos' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Pontos/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  ),
  'WebFrap_Theme_Default' => array
  (
    'type' => 'Mercurial',
    'path' => $conf->workspace.'WebFrap_Theme_Default/',
    'development_branch' => 'development',
    'testing_branch'     => 'testing',
    'stable_branch'      => 'stable',
  )

);

