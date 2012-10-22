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

// definiere des GAIA Root Pfades
define( 'GAIA_PATH', realpath( dirname(__FILE__).'/../' ).'/' );

// root pfad der Gaia Installation
define( 'PATH_ROOT', realpath( dirname(__FILE__).'/../../' ).'/' );

// der pfad für temporäre dateien
define( 'TMP_PATH', PATH_ROOT.'tmp/' );

define( 'SYS_ROOT', '/var/www/test_root/' );
 
include GAIA_PATH.'gaia/Gaia.php';

spl_autoload_register( 'Gaia::pathAutoload' );

/*
if( '' == trim(Process::execute('echo $DISPLAY')) )
{
  include GAIA_PATH.'gaia/ui/UiConsoleCli.php';
}
else 
{
  include GAIA_PATH.'gaia/ui/UiConsoleZenity.php';
}
*/

include GAIA_PATH.'gaia/ui/UiConsoleHttp.php';

Environment::guessOsData();

$console = UiConsole::getActive();

if( !defined( 'GAIA_CONTEXT' ) )
{
  $console->error("Der Scriptauthor hat vergessen einen GAIA_CONTEXT zu definieren.");
  exit(1);
}

////////////////////////////////////////////////////////////////////////////////
// Bootstrap zum initialisieren des Scripts
////////////////////////////////////////////////////////////////////////////////

// liste der benötigten attribute / standard werte

$setupLang = 'de';
$conf      = new stdClass();

$request   = Request::parseRequest(  );

$confRequired = array
(
  'sync'
);

if( in_array(GAIA_CONTEXT, $confRequired) )
{

  if( $key = Request::arg( 'conf' ) )
  {
    
    $confPath = GAIA_PATH.'conf/conf.'.GAIA_CONTEXT.'.'.$key.'.php';
    
    if( Fs::exists($confPath) )
    {
      include $confPath;
    }
    else 
    {
      $console->error
      (
        <<<ERROR
Die von die übergebene Konfiguration existiert nicht. Bitte Prüfe ob du nicht 
vielleicht einen Tippfehler in der Eingabe hast.
ERROR
      );
      exit(2);
    }
  }
  else 
  {
    if( Fs::exists( GAIA_PATH.'conf/conf.'.GAIA_CONTEXT.'.default.php' ) )
    {
      include  GAIA_PATH.'conf/conf.'.GAIA_CONTEXT.'.default.php';
    }
    else 
    {
      $console->error
      (
        <<<ERROR
Du hast versucht Gaia zu starten ohne explizit eine Konfiguration zu übergeben, und ohne eine Default Conf erstellt zu haben. 
Ohne das PHP Module Mod Glaskugel ist leider nicht möglich zu erraten was du eigentlich machen möchtest. 
Bitte definier zuerst eine default Conf, oder übergib mit dem parameter conf=key_deiner_conf einen Vereis auf ein existierendes Conf File.
ERROR
      );
      exit(1);
    }
  }

}

I18n::loadLang( $setupLang );