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


if (!defined('PHP_VERSION_ID')) 
{
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    
  if (PHP_VERSION_ID < 50207) {
      define('PHP_MAJOR_VERSION',   $version[0]);
      define('PHP_MINOR_VERSION',   $version[1]);
      define('PHP_RELEASE_VERSION', $version[2]);
  }
}



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
 * Klasse zum prüfen der system requirements um sicher zu stellen, dass
 * das system auch laufen wird
 * 
 * @author dominik bonsch
 * @package WebFrap
 * @subpackage Gaia
 */
class CheckRequirements
{
  
  /**
   * Prüfen der PHP Version
   */
  public static function checkPhp($mode = 'production')
  {
    
    $errors   = array();
    $warnings = array();
    
    // prüfen der php version
    if (PHP_MAJOR_VERSION < 5)
    {
      $errors[] = I18n::get('{@appname@} requires a PHP version >= 5.3.0. You have {@your_version@} please upgrade your PHP version first to be able to install {@appname@} ');
    }
    else if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION < 3)
    {
      $errors[] = I18n::get('{@appname@} requires a PHP version >= 5.3.0. You have {@your_version@} please upgrade your PHP version first to be able to install {@appname@} ');
    }
    
    // prüfen der php konfiguration
    if (ini_get('register_globals'))
    {
      $errors[] = I18n::get(<<<I18N
You have register_globals activated. Due to security reasosn it is NOT allowed to run {@appname@} with register_globals=on. 
Deaktivate register_globals in the php.ini to continue. Note that the system will refuse to work if you reactiveate this option after installing.
You will lose all guarantees. Removing the check will be seen as a grossly negligent action, if a security issue due to this manipulation will occure you are in serious trouble.
Please note that we don't think that you personal even think about such things. In this world it's just a nessecary insurance to tell everybody who get's in contact with that
issue to resolv it in a correct way and not by curing headaches with a headshoot.
I18N
);
    }
    
    if (ini_get('short_open_tag'))
    {
      $errors[] = I18n::get(<<<I18N
You have short_open_tag activated. This is in general a bad idea and will cause several errors in the system. Please deactive "short_open_tag" in the php.ini before proceding.
I18N
);
    }
    
    if (ini_get('allow_url_include'))
    {
      $errors[] = I18n::get(<<<I18N
You have allow_url_include activated. This is a very dangerous option whith a uncalculateable security risk. Therefore it's not permitted to install {@appname@} when this option 
is active.
Deaktivate allow_url_include in the php.ini to continue. Note that the system will refuse to work if you reactiveate this option after installing.
You will lose all guarantees. Removing the check will be seen as a grossly negligent action, if a security issue due to this manipulation will occure you are in serious trouble.
Please note that we don't think that you personal even think about such things. In this world it's just a nessecary insurance to tell everybody who get's in contact with that
issue to resolv it in a correct way and not by curing headaches with a headshoot.
I18N
);
    }
    
    
    if ($mode == 'production' && ini_get('display_errors'))
    {
      $warnings[] = I18n::get(<<<I18N
You are going to set up a production system on a php version with display_errors=on. If you use it just to check for errors during the installation process everything ist fine.
But don't forge to disable this option after the setup is completed. Log the errors in a file instead.
I18N
);
    }
    
    $defCharset = ini_get('default_charset');
    if (strtolower($defCharset) != 'utf-8')
    {
      $warnings[] = I18n::get(<<<I18N
This version of {@appname@} expect utf-8 as default charset. Please change the option default_charset to 'utf-8' in the php.ini;
I18N
);
    }
    
    // prüfen der verfügbarkeit von benötigten modulen
    
    if (!extension_loaded('apc'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension APC is missing. The module is required for performance reasons, caching and the upload progess implementation.
Please install the APC extension and start the setup script again.
I18N
);
    }
    
   
    if (!extension_loaded('dom'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension DOM is missing. This extension is required for XML handling, imports, exports etc.
Please install the DOM extension and start the setup script again.
I18N
);
    }
    
     
    if (!extension_loaded('SimpleXML'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension SimpleXML is missing. This extension is required for XML handling, imports, exports etc.
Please install the SimpleXML extension and start the setup script again.
I18N
);
    }
   
    if (!extension_loaded('ctype'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension ctype is missing. This extension is essential for internal checks of data integrity.
Please install the ctype extension and start the setup script again.
I18N
);
    }
    
   
    if (!extension_loaded('mbstring'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension mbstring is missing. This extension is essential for handling multibyte unicode strings.
Please install the mbstring extension and start the setup script again.
I18N
);
    }
    
   
    if (!extension_loaded('iconv'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension iconv is missing. This extension is essential for handling multibyte unicode strings.
Please install the iconv extension and start the setup script again.
I18N
);
    }
    
   
    if (!extension_loaded('imap'))
    {
      $warnings[] = I18n::get(<<<I18N
PHP extension imap is missing. This extension is essential for the mailsystem.
Please note that the system will not be able to send emails if the extension is missing.
I18N
);
    }
    
     
    if (!extension_loaded('sockets'))
    {
      $warnings[] = I18n::get(<<<I18N
PHP extension sockets is missing. This extension is essential for the mailsystem.
Please note that the system will not be able to receive emails if the extension is missing.
I18N
);
    }
    
  
    if (!extension_loaded('pgsql'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension pgsql is missing. This extension is required for accessing the database.
It's not possible to install or run the system withour the pgsql extension.
Please install the pgsql extension and start the setup script again.
I18N
);
    }
    
    if (!extension_loaded('zip'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension zip is missing. This extension is required for backups, restore, the package manager an many other
usecases.
It's not possible to install or run the system withour the zip extension.
Please install the zip extension and start the setup script again.
I18N
);
    }
     
    if (!extension_loaded('zlib'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension zlib is missing. This extension is required for backups, restore, the package manager an many other
usecases.
It's not possible to install or run the system withour the zlib extension.
Please install the zlib extension and start the setup script again.
I18N
);
    }
    
    
    if (!extension_loaded('session'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension session is missing. It's not even possible to login without this extension.
Please install the session extension and start the setup script again.
I18N
);
    }
  
    if (!extension_loaded('gd'))
    {
      $warnings[] = I18n::get(<<<I18N
PHP extension gd is missing. This extension is essential for creating thumb images and render graph diagramms.
Please note, that the system will not be able to handle images in any way if this extension is missing.
I18N
);
    }
     
    if (!extension_loaded('pcre'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension pcre is missing. This extension is required for validation and processing / analysing of data.
Please install the pcre extension and start the setup script again.
I18N
);
    }
     
    if (!extension_loaded('filter'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension pcre is missing. This extension is required for the input validation.
Please install the pcre extension and start the setup script again.
I18N
);
    }
     
    if (!extension_loaded('hash'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension hash is missing. This extension is required for security reasons.
Please install the hash extension and start the setup script again.
I18N
);
    }
     
    if (!extension_loaded('json'))
    {
      $errors[] = I18n::get(<<<I18N
PHP extension json is missing. This extension is required for data exchange.
Please install the json extension and start the setup script again.
I18N
);
    }
  
     
    if (!extension_loaded('curl'))
    {
      $warnings[] = I18n::get(<<<I18N
PHP extension curl is missing. This extension is required for reading webservices from other systems.
If curl is missing the system will not be able to read webservices or trigger actions on other systems.
I18N
);
    }
    
    
    /*
    ldap
    openssl
    zlib
    date
    calendar
    bcmath
    */
    
    // rückgabe der gefundenen issues soweit vorhanden
    return array
    (
      'errors' => $errors,
      'warnings' => $warnings
    );


    
  }//end public static function checkPhp */
  
 
  
}//end class CheckRequirements */
