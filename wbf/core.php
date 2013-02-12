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

define( 'NL', "\n" );

if( 'cli' == php_sapi_name() )
  define( 'IS_CLI', true );
else
  define( 'IS_CLI', false );

define( 'GAIA_PATH', realpath( dirname(__FILE__).'/../' ).'/' );
 
include GAIA_PATH.'core/i18n.php';
include GAIA_PATH.'core/request.php';
include GAIA_PATH.'core/console.php';
include GAIA_PATH.'core/process.php';
include GAIA_PATH.'core/db.php';
include GAIA_PATH.'core/webserver.php';
include GAIA_PATH.'core/fs.php';
include GAIA_PATH.'core/deploy.php';
include GAIA_PATH.'core/hg.php';
include GAIA_PATH.'core/archive.php';
include GAIA_PATH.'core/ssl.php';
include GAIA_PATH.'core/tarray.php';
include GAIA_PATH.'core/server.php';
include GAIA_PATH.'core/user.php';
include GAIA_PATH.'core/gaia.php';
include GAIA_PATH.'core/file.php';

include GAIA_PATH.'core/xml/XmlDocument.php';
include GAIA_PATH.'core/package/PackageFile.php';

if( '' == trim(Process::execute('echo $DISPLAY')) )
{
  include GAIA_PATH.'core/ui/UiConsoleCli.php';
}
else 
{
  include GAIA_PATH.'core/ui/UiConsoleZenity.php';
}


////////////////////////////////////////////////////////////////////////////////
// Bootstrap zum initialisieren des Scripts
////////////////////////////////////////////////////////////////////////////////

// liste der benötigten attribute / standard werte

$setupLang = 'de';
$conf      = new stdClass();


if( IS_CLI )
{
  Request::parseRequest( $argv );
}


if( $key = Request::arg( 'conf' ) )
{
  if( Fs::exists('./conf/conf.'.$key.'.php') )
  {
    include './conf/conf.'.$key.'.php';
  }
  else 
  {
    Console::error
    (
      "
      Die von die übergebene Konfiguration existiert nicht. Bitte Prüfe ob du nicht
      vielleicht einen Tippfehler in der Eingabe hast.
      "
    );
    exit(1);
  }
}
else 
{
  if( Fs::exists( './conf/conf.default.php' ) )
  {
    include  './conf/conf.default.php';
  }
  else 
  {
    Console::error
    (
      "
      Du hast versucht den Sync zu starten ohne explizit eine Konfiguration zu übergeben, und ohne eine Default Conf erstellt zu haben. 
      Ohne das PHP Module Mod Glaskugel ist leider nicht möglich zu erraten was du eigentlich machen möchtest. 
      Bitte definier zuerst eine default Conf, oder übergib mit dem parameter conf=key_deiner_conf einen Vereis auf ein existierendes Conf File.
      "
    );
    exit(1);
  }
}

I18n::loadLang( $setupLang );