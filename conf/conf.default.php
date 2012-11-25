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

/**
 * Der Pfad im dem sich die Repository Container befinden
 * @var string
 */
$repoRoot     = '/srv/mercurial/';

/**
 * Temporärer Ordner 
 * @var string
 */
$tmpFolder    = '/srv/tmp/';

/**
 * Temporärer Ordner 
 * @var string
 */
$backupFolder    = '/srv/backup/';


/**
 * Der Pfad im dem sich die Repository Container befinden
 * @var string
 */
$universe     = 'stab';

////////////////////////////////////////////////////////////////////////////////
// Setup
////////////////////////////////////////////////////////////////////////////////

/**
 * Sollen vor dem deployen erst einmal die Repositories local gesynct werden
 * @var boolean
 */
$syncBeforeDeploy = true;

/**
 * Für das Setup der Datenbank nötige Angaben
 * @var array
 */
$setupDb = array
(
  'root_user'  => 'depl_admin',
  'root_pwd'   => 'ji8hb7zj', 
  'pre_scripts'    => array // liste mit scripten und dumps die immer geladen werden sollen
  (
    GAIA_PATH.'data/dbms/postgresql/init_database.sql' 
  ),
  'post_scripts'    => array // liste mit scripten und dumps die immer geladen werden sollen
  (
    GAIA_PATH.'data/dbms/postgresql/finish_database.sql' 
  ),
  'db'  => array
  (
    'STAB_Gw_Intranet' => array
    (
      'name'       => 'stab_gw_intranet',
      'owner'       => 'stab_wbf_intranet',
      'owner_pwd'   => 'stab_wbf_intranet',
      'schema'     => 'stab',
      'encoding'   => 'utf-8',
    )
  )
);

////////////////////////////////////////////////////////////////////////////////
// Deployment
////////////////////////////////////////////////////////////////////////////////

/**
 * Das Universum in welches deployt werden soll
 * @var string
 */
$deployPath    = '/srv/universe/'.$universe.'/';

/**
 * Systembenutzer und Gruppe welchen die Deployten Daten zugeordnet werden sollen
 * @var string
 */
$sysOwner  = 'www-data:root';

/**
 * Zugriffsberechtigungen 
 * @var string
 */
$sysAccess = '770';

/**
 * Liste der zu deployenden Repositories
 * @var array
 */
$deplGateways   = array
(  
  
  array
  ( 
    'name'  => 'STAB_Gw_Portal', // Name des Projektes im Deployment Path
    'src'   => $repoRoot.'/st-a-b/STAB_Gw_Portal', 
    //'rev'    => '', // definieren welche Revision verwendet werden soll
    'conf'  => 'stab.prod', // den zu verwendenten Conf Key definieren
    'vhost' => array
    (
      'host'           => '217.8.62.169', 
      'port'           => '443',
      'server_admin'   => 'admin@daddelmedia.de',
      'server_name'    => 'intranet.daddelmedia.de',
      'icon_project'   => 'Icons',
      'theme_project'  => 'Themes',
    )
  ),/* examples
  array
  ( 
    'name'  => 'WebFrap_Gw_Cu4711' , 
    'src'   => $repoRoot.'WebFrap_customer/WebFrap_Gw_Cu4711', 
    'conf'  => 'prod.4711',
    'includes' => array // includes selbst definieren
    (
      'WebFrap_App_SBiz',
      'WebFrap_Core',
      'Customer_Module'
    )
  ),        
  */    
);

/**
 * Liste der Icon Projekte
 * @var array
 */
$deplIcons     = array
(  
  'Icons' => array
  (
    array
    ( 
      'src'   => $repoRoot.'webfrap/WebFrap_Icons_Default' 
    )
  )
);

/**
 * Liste der Theme Projekte
 * @var array
 */
$deplThemes    = array
(
  'Themes' => array
  (
    array
    (  
      'src'   => $repoRoot.'st-a-b/STAB_Theme_Default'
    )
  )
);

/**
 * Das Wgt Projekt
 * @var array
 */
$deplWgt       = array
(  
  'name'  => 'WebFrap_Wgt', 
  'src'   => $repoRoot.'webfrap/WebFrap_Wgt'
);

/**
 * Das Webfrap Projekt
 * @var array
 */
$deplFw     = array
(  
  'name'  => 'WebFrap', 
  'src'   => $repoRoot.'webfrap/WebFrap'         
);

/**
 * Anwendungs Module welche deployt werden sollen
 * @var array
 */
$deplRepos  = array
(
  'STAB_App_Intranet' => array
  (
    'STAB_App_Intranet' => array
    (
      'path' => $repoRoot.'st-a-b/',
    ),
  ),
  'WebFrap_Core' => array
  (
    'WebFrap_Pontos'      => array
    (
      'path' => $repoRoot.'webfrap/',
    ),
    'WebFrap_Daidalos'    => array
    (
      'path' => $repoRoot.'webfrap/',
    ),
  ),
);

////////////////////////////////////////////////////////////////////////////////
// Sync
////////////////////////////////////////////////////////////////////////////////

/**
 * Der Benötigte Username für den Zugriff auf die Repositories soweit
 * ein einheitlicher Access vorhanden ist
 * @var string
 */
$repoUser     = 'syncservice';

/**
 * Das benötigte Passwort für den Zugriff auf die Repositories soweit
 * ein einheitlicher Access vorhanden ist
 * @var string
 */
$repoPwd      = 'Tz9m.!u8n';

/**
 * Der Benutzer welchem das Repository zugeordnet werden soll
 * @var string
 */
$repoOwner    = 'www-data:root';

/**
 * Der Name welcher bei Commits für den Sync angezeigt wird
 * @var string
 */
$displayName  = 'dd <admin@daddelmedia.de>';

/**
 * Die Commitmessage welche bei Auto Sync Commits angegeben wird
 * @var string
 */
$commitMessage  = '"- this is an auto commit for synchronizing the repository with the master"';

/**
 * Die Mailadresse welche in geclonten Repositories hinterlegt wird
 * @var string
 */
$contactMail    = 'admin@daddelmedia.de';

/**
 * Array mit alle Sync Repositories
 * @var array
 */
$syncRepos = array
(
  'st-a-b' => array
  (
    'path'  => $repoRoot.'st-a-b/',
    'repos' => array
    (
      'STAB_Gaia'    => array
      (
        'url'   => 'hg.webfrap-servers.de/st-a-b/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'STAB_CI' => array
      (
        'url'   => 'hg.webfrap-servers.de/st-a-b/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'STAB_42' => array
      (
        'url'   => 'hg.webfrap-servers.de/st-a-b/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'STAB_Theme_Default' => array
      (
        'url'   => 'hg.webfrap-servers.de/st-a-b/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'STAB_Gw_Portal' => array
      (
        'url'   => 'hg.webfrap-servers.de/st-a-b/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'STAB_App_Intranet' => array
      (
        'url'   => 'hg.webfrap-servers.de/st-a-b/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
    )
  ),
  'webfrap' => array
  (
    'path'  => $repoRoot.'webfrap/',
    'repos' => array
    (
      'WebFrap'    => array
      (
        'url'   => 'hg.webfrap-servers.de/webfrap/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'WebFrap_Wgt' => array
      (
        'url'   => 'hg.webfrap-servers.de/webfrap_net/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'WebFrap_Pontos' => array
      (
        'url'   => 'hg.webfrap-servers.de/webfrap_net/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'WebFrap_Daidalos' => array
      (
        'url'   => 'hg.webfrap-servers.de/webfrap_net/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'WebFrap_Icons_Default' => array
      (
        'url'   => 'hg.webfrap-servers.de/webfrap_net/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
      'WebFrap_Theme_Default' => array
      (
        'url'   => 'hg.webfrap-servers.de/webfrap_net/',
        'user'  => $repoUser,
        'pwd'   => $repoPwd
      ),
    )
  ),
);



