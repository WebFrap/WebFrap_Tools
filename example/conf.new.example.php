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
// Allgemeine Angaben
////////////////////////////////////////////////////////////////////////////////

$conf = new stdClass();

/**
 * Der Absolute Pfad in welchen deployt werden soll
 * @var string
 */
$conf->deployRoot = null;

/**
 * Systembenutzer und Gruppe welchen die Deployten Daten zugeordnet werden sollen
 * @var string
 */
$conf->sysOwner  = 'www-data:root';

/**
 * Zugriffsberechtigungen
 * @var string
 */
$conf->sysAccess = '770';

////////////////////////////////////////////////////////////////////////////////
// Datenbank informationen
////////////////////////////////////////////////////////////////////////////////

/**
 * Für das Setup der Datenbank nötige Angaben
 * @var array
 */
$conf->setupDb = array
(
  'root_user'  => '',
  'root_pwd'   => '',
  'scripts'    => array // liste mit scripten und dumps die immer geladen werden sollen
  (
    ''
  ),
  'db'  => array
  (
    'WebFrap_Gw_SBiz' => array
    (
      'name'       => '',
      'owner'       => '',
      'owner_pwd'   => '',
      'schema'     => '',
      'encoding'   => '',
    )
  )
);
