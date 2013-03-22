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
 * Klasse zum entpacken von Archiven
 * @package WebFrap
 * @subpackage Gaia
 */
class WebserverApache
{
  
  
  /**
   * @param WebserverApacheVhost $vhostConf
   */
  public static function renderConf($vhostConf)
  {
    
    $host = '';
    
    //  #ServerAlias *.sbiz.s-db.de
    
    /*

  #<IfModule mod_deflate.c>
    # compress text, html, javascript, css, xml:
   # AddOutputFilterByType DEFLATE text/plain
   # AddOutputFilterByType DEFLATE text/html
   # AddOutputFilterByType DEFLATE text/xml
   # AddOutputFilterByType DEFLATE text/css
   # AddOutputFilterByType DEFLATE text/json
   # AddOutputFilterByType DEFLATE application/xml
   # AddOutputFilterByType DEFLATE application/xhtml+xml
   # AddOutputFilterByType DEFLATE application/rss+xml
   # AddOutputFilterByType DEFLATE application/javascript
   # AddOutputFilterByType DEFLATE application/x-javascript
  #</IfModule>
     */
    
    /*

#    AuthType Basic
#    AuthName "SDB SBIZ"
#    AuthBasicProvider file
#    AuthUserFile /etc/apache2/htpasswd
#    AuthGroupFile /etc/apache2/htgroup
#    Require group sdb dbonsch 
     */
    
    $host .= <<<CODE
<VirtualHost {$vhostConf->serverIp}:{$vhostConf->serverSSLPort}>

  ServerAdmin {$vhostConf->serverAdmin}
  ServerName "{$vhostConf->appDomain}"

  DocumentRoot "{$vhostConf->vhostRoot}"

  # don't loose time with IP address lookups
  HostnameLookups Off

  # needed for named virtual hosts
  UseCanonicalName Off
  
  # configures the footer on server-generated documents
  ServerSignature Off   

  # configure etags
  FileETag MTime Size
  <IfModule mod_expires.c>
    <filesmatch "\.(jpg|gif|png|css|js|zip|json|html|xml|flv|mpg|avi)$">
         ExpiresActive on
         ExpiresDefault "access plus 1 year"
     </filesmatch>
  </IfModule>

  AddType application/x-httpd-php .php .tpl .dcss .djs

  #   SSL Engine Switch:
  #   Enable/Disable SSL for this virtual host.
  SSLEngine on

  #   SSL Cipher Suite:
  #   List the ciphers that the client is permitted to negotiate.
  #   See the mod_ssl documentation for a complete list.
  SSLProtocol all
  SSLCipherSuite HIGH:MEDIUM

  SSLCertificateFile    /etc/apache2/ssl/s-db.pem
  SSLCertificateKeyFile /etc/apache2/ssl/s-db.key

  <Directory "{$vhostConf->vhostRoot}">
    Options None
    Order allow,deny
    Allow from all
    AllowOverride None

    SSLOptions +StdEnvVars
    SSLRequireSSL

  </Directory>

  <Location /tmp>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /cache>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /data>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /conf>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /modules>
    Order allow,deny
    Deny from all
  </Location>

  <Location /src>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /templates>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /.hg>
    Order allow,deny
    Deny from all
  </Location>

  # Style
  Alias /icons "{$vhostConf->pathIcons}"

  # Wgt
  Alias /wgt "{$vhostConf->pathWgt}"

  # Theme
  Alias /themes "{$vhostConf->pathThemes}"

  ErrorDocument 400 "/error.php?t=400&t=Bad Request"
  ErrorDocument 401 "/error.php?t=401&t=Unauthorized"
  ErrorDocument 403 "/error.php?t=403&t=Forbidden"
  ErrorDocument 404 "/error.php?t=404&t=Not Found"
  ErrorDocument 405 "/error.php?t=405&t=Method Not Allowed"
  ErrorDocument 500 "/error.php?t=500&t=Internal Server Error"

  ErrorLog "/var/log/apache2/{$vhostConf->appDomain}/error.log"

  # Possible values include: debug, info, notice, warn, error, crit,
  # alert, emerg.
  LogLevel warn

  CustomLog "/var/log/apache2/{$vhostConf->appDomain}/access.log" combined

</VirtualHost>

CODE;
  
    if ($vhostConf->noSSl)
    {
      
      $host .= <<<CODE
<VirtualHost {$vhostConf->serverIp}:{$vhostConf->serverPort}>

  ServerAdmin {$vhostConf->serverAdmin}
  ServerName "{$vhostConf->appDomain}"

  DocumentRoot "{$vhostConf->vhostRoot}"

  # don't loose time with IP address lookups
  HostnameLookups Off

  # needed for named virtual hosts
  UseCanonicalName Off
  
  # configures the footer on server-generated documents
  ServerSignature Off   

  # configure etags
  FileETag MTime Size
  <IfModule mod_expires.c>
    <filesmatch "\.(jpg|gif|png|css|js|zip|json|html|xml|flv|mpg|avi)$">
         ExpiresActive on
         ExpiresDefault "access plus 1 year"
     </filesmatch>
  </IfModule>

  AddType application/x-httpd-php .php .tpl .dcss .djs

  <Directory "{$vhostConf->vhostRoot}">
    Options None
    Order allow,deny
    Allow from all
    AllowOverride None
  </Directory>

  <Location /tmp>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /cache>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /data>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /conf>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /modules>
    Order allow,deny
    Deny from all
  </Location>

  <Location /src>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /templates>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /.hg>
    Order allow,deny
    Deny from all
  </Location>

  # Style
  Alias /icons "{$vhostConf->pathIcons}"

  # Wgt
  Alias /wgt "{$vhostConf->pathWgt}"

  # Theme
  Alias /themes "{$vhostConf->pathThemes}"

  ErrorDocument 400 "/error.php?t=400&t=Bad Request"
  ErrorDocument 401 "/error.php?t=401&t=Unauthorized"
  ErrorDocument 403 "/error.php?t=403&t=Forbidden"
  ErrorDocument 404 "/error.php?t=404&t=Not Found"
  ErrorDocument 405 "/error.php?t=405&t=Method Not Allowed"
  ErrorDocument 500 "/error.php?t=500&t=Internal Server Error"

  ErrorLog "/var/log/apache2/{$vhostConf->appDomain}/error.log"

  # Possible values include: debug, info, notice, warn, error, crit,
  # alert, emerg.
  LogLevel warn

  CustomLog "/var/log/apache2/{$vhostConf->appDomain}/access.log" combined

</VirtualHost>

CODE;
      
    }
    
    return $host;

  }//end public static function renderConf */
  
  /**
   */
  public static function reload()
  {
    
    Process::execute("/etc/init.d/apache2 reload");
    
  }//end public static function reload */
  
  /**
   */
  public static function restart()
  {
    
    Process::execute("/etc/init.d/apache2 restart");
    
  }//end public static function restart */
  
  /**
   */
  public static function start()
  {
    
    Process::execute("/etc/init.d/apache2 start");
    
  }//end public static function start */
  
  /**
   */
  public static function stop()
  {
    
    Process::execute("/etc/init.d/apache2 stop");
    
  }//end public static function stop */ 

  /**
   * @param string $pageName
   */
  public static function activatePage($pageName)
  {
    
    Process::execute("a2enpage {$pageName}");
    
  }//end public static function activatePage */
  
  /**
   * @param string $pageName
   */
  public static function deactivatePage($pageName)
  {
    
    Process::execute("a2dissite {$pageName}");
    
  }//end public static function deactivatePage */
  
  /**
   * @param string $modName
   */
  public static function activateModule($modName)
  {
    
    Process::execute("a2enmod {$modName}");
    
  }//end public static function activateModule */
  
  /**
   * @param string $modName
   */
  public static function deactivateModule($modName)
  {
    
    Process::execute("a2dismod {$modName}");
    
  }//end public static function deactivateModule */

}//end class Archive */


/**
 * Der Apache Vhost
 * @author Dominik Bonsch
 */
class WebserverApacheVhost
{
  
  /**
   * Flag ob auch ein no ssl vhost erstellt werden soll
   * @var boolean
   */
  public $noSSl = false;
  
  /**
   * SSL Zertifikat
   * @var string
   */
  public $sslCertificateFile = null;
  
  /**
   * SSL Key File
   * @var string
   */
  public $sslCertificateKeyFile = null;

  /**
   * Die Domain für die Applikation
   * @var string
   */
  public $appDomain = null;
  
  /**
   * @var string
   */
  public $serverIp = null;
  
  /**
   * @var string
   */
  public $serverSSLPort = 443;
  
  /**
   * @var string
   */
  public $serverPort = 80;
  
  /**
   * @var string
   */
  public $serverAdmin = null;

  /**
   * @var string
   */
  public $pathRoot = null;
  
  /**
   * @var string
   */
  public $pathIcons = null;
  
  /**
   * @var string
   */
  public $pathWgt = null;
  
  /**
   * @var string
   */
  public $pathThemes = null;

  
}//end class WebserverApacheVhost */


