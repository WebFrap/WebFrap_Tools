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
 * Datenbank Hilfsklasse
 * @package WebFrap
 * @subpackage Gaia
 */
class SoftwareConfDovecot
  extends SoftwareConf
{

  /**
   * 
   */
  public function setupConf()
  {
    
  }//end public function setupConf */
  
  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_dovecot_conf($server, $mailConf)
  {
    
    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();
    
    // /etc/dovecot/dovecot.conf
    $file = <<<FILE
#disable_plaintext_auth = no

mail_location = maildir:~/Maildir
mail_privileged_group = mail

first_valid_uid = 70000
first_valid_gid = 70000

protocol lda {
  postmaster_address = postmaster@YOUR-DOMAIN.TLD
  # uncomment this to use server side filtering (Dovecot v1.0.x/v1.1.x)
  #mail_plugins = cmusieve
  # uncomment this to use server side filtering (Dovecot v1.2.x)
  #mail_plugins = sieve
}

protocol pop3 {
  pop3_uidl_format = %08Xu%08Xv
}

# uncomment this to use the ManageSieve protocol, if supported by your installation
#protocol managesieve {
#  # only valid with Dovecot v1.0.x/v1.1.x.
#  # see also: http://wiki.dovecot.org/ManageSieve/Configuration#v1.0.2BAC8-v1.1
#  sieve = ~/.dovecot.sieve
#  sieve_storage = ~/sieve
#}

auth default {
  mechanisms = cram-md5 login plain
  passdb sql {
    args = /etc/dovecot/dovecot-sql.conf
  }
  userdb sql {
    args = /etc/dovecot/dovecot-sql.conf
  }
  user = nobody
  socket listen {
    master {
      path = /var/run/dovecot/auth-master
      mode = 0600
    }
    client {
      path = /var/spool/postfix/private/auth
      mode = 0660
      user = postfix
      group = postfix
    }
  }
}

# uncomment this if you use the ManageSieve protocol with Dovecot v1.2.x
#plugin {
#  # Sieve and ManageSieve settings
#  # see also: http://wiki.dovecot.org/ManageSieve/Configuration#v1.2
#  sieve = ~/.dovecot.sieve
#  sieve_dir = ~/sieve
#}

FILE;
    
  }//end public function setupConf_pg_transport */
  
  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_dovecot2_conf($server, $mailConf)
  {
    
    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();
    
    // /etc/dovecot/dovecot.conf
    $file = <<<FILE
driver = pgsql
connect = host={$host} dbname={$dbName} user={$user} password={$pwd}
default_pass_scheme = PLAIN
password_query = SELECT "user", password FROM dovecot_password WHERE "user" = '%Lu' AND %Ls
user_query = SELECT home, uid, gid, 'maildir:'||mail AS mail FROM {$dbSchema}.dovecot_user WHERE userid = '%Lu'

FILE;
    
  }//end public function setupConf_pg_transport */
  
}//end class SoftwareConfDovecot
