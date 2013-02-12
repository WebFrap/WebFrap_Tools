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

/**
 * Datenbank Hilfsklasse
 * @package WebFrap
 * @subpackage Gaia
 */
class SoftwareConfPostfix
  extends SoftwareConf
{

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf( $server, $mailConf )
  {

  }//end public function setupConf */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_transport( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    //pgsql-transport.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# The SQL query template used to search the database
query = SELECT transport FROM {$dbSchema}.postfix_transport WHERE address='%s'

FILE;

  }//end public function setupConf_pg_transport */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_relocated_maps( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    //pgsql-relocated_maps.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# The SQL query template used to search the database
query = SELECT destination FROM {$dbSchema}.postfix_relocated WHERE address='%s'

FILE;

  }//end public function setupConf_pg_relocated_maps */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_smtpd_sender_login_maps( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    // pgsql-smtpd_sender_login_maps.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# XXX see create_optional_types_and_functions.pgsql
#   * line  9: type sender_login
#   * line 26: function postfix_smtpd_sender_login_map + comment above
#
# The SQL query template used to search the database
query = SELECT login FROM {$dbSchema}.postfix_smtpd_sender_login_map('%u', '%d')

FILE;

  }//end public function setupConf_pg_smtpd_sender_login_maps */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_smtpd_sender_login1_maps( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    // pgsql-smtpd_sender_login_maps.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# XXX see create_optional_types_and_functions.pgsql
#   * line  9: type sender_login
#   * line 26: function postfix_smtpd_sender_login_map + comment above
#
# The SQL query template used to search the database
query = SELECT login FROM {$dbSchema}.postfix_smtpd_sender_login_map('%u', '%d')

FILE;

  }//end public function setupConf_pg_smtpd_sender_login_maps */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_virtual_alias_maps( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    // pgsql-virtual_alias_maps.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# The SQL query template used to search the database
query = SELECT destination FROM {$dbSchema}.postfix_alias WHERE address='%s'

FILE;

  }//end public function setupConf_pg_virtual_alias_maps */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_virtual_gid_maps( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    // pgsql-virtual_gid_maps.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# The SQL query template used to search the database
query = SELECT gid FROM {$dbSchema}.postfix_gid WHERE domainname='%d'

FILE;

  }//end public function setupConf_pg_virtual_gid_maps */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_virtual_mailbox_domains( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    // pgsql-virtual_mailbox_domains.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# The SQL query template used to search the database
query = SELECT gid FROM {$dbSchema}.postfix_gid WHERE domainname='%s'

FILE;

  }//end public function setupConf_pg_virtual_mailbox_domains */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_virtual_mailbox_maps( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    // pgsql-virtual_mailbox_maps.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# The SQL query template used to search the database
query = SELECT maildir FROM {$dbSchema}.postfix_maildir WHERE address='%s'

FILE;

  }//end public function setupConf_pg_virtual_mailbox_maps */

  /**
   * @param PackageServer $server
   * @param PackageServerMail $mailConf
   */
  public function setupConf_pg_virtual_uid_maps( $server, $mailConf )
  {

    $host     = $mailConf->getConfDbHost();
    $user     = $mailConf->getConfDbUser();
    $pwd      = $mailConf->getConfDbPwd();
    $dbName   = $mailConf->getConfDbName();
    $dbSchema = $mailConf->getConfDbSchema();

    // pgsql-virtual_uid_maps.cf
    $file = <<<FILE
# All parameters are described in pgsql_table(5) / PGSQL PARAMETERS
#
# The hosts that Postfix will try to connect to and query from.
hosts = {$host}

# The user name and password to log into the pgsql server.
user = {$user}
password = {$pwd}

# The database name on the servers.
dbname = {$dbName}

# The SQL query template used to search the database
query = SELECT uid FROM {$dbSchema}.postfix_uid WHERE address='%s'

FILE;

  }//end public function setupConf_pg_virtual_uid_maps */

}//end class SoftwareConfPostfix
