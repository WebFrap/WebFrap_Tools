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
class Db
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Liste mit den Datenbankverbindungen
   * @var array
   */
  private static $connections = array();
  
  /**
   * Liste der DB Admin Objekte
   * @var array
   */
  private static $dbAdmins = array();
  
  /**
   * Der Host
   * @var string
   */
  public static $host = '127.0.0.1';
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param string $host
   * @param string $dbName
   * @param string $user
   * @param string $schema
   */
  public static function getConnection( $host, $dbName, $user, $schema = null )
  {
    
    $conKey = "{$host}-{$dbName}-{$user}-{$schema}";
    
    if ( isset( self::$connections[$conKey] ) )
     return self::$connections[$conKey];
    
  }//end public static function getConnection */
  
  /**
   * @param PackageServerDb $dbConf
   */
  public static function getConnectionByPackage( $dbConf )
  {
    
    $host      = $dbConf->getHost();
    
    $dbName    = $dbConf->getDbName();
    $dbSchema  = $dbConf->getDbSchema();
    
    $user      = $dbConf->getDbUser();
    
    
    $conKey = "{$host}-{$dbName}-{$user}-{$dbSchema}";
    
    if ( isset( self::$connections[$conKey] ) )
     return self::$connections[$conKey];
    
  }//end public static function getConnection */
  
  /**
   * @param string $type
   * @param string $host
   * @param string $port
   * @param string $dbName
   * @param string $dbSchema
   * @param string $adminUser
   * @param string $adminPwd
   * @param ProtocolWriter $protocol
   * 
   * @return DbAdmin
   * 
   */
  public static function getAdmin
  (
    $type,
    $host,
    $port,
    $dbName,
    $dbSchema,
    $user,
    $pwd,
    $protocol = null
  )
  {
    
    $dbKey = "{$type}-{$host}-{$port}-{$dbName}-{$dbSchema}-{$user}-{$pwd}";
    
    if ( !isset( self::$dbAdmins[$dbKey] ) )
    {
      $className = 'DbAdmin'.ucfirst($type);
      
      if ( !Gaia::classLoadable($className) )
      {
        throw new DbException("DB Type: {$type} is not yet supported.");
      }
      
      self::$dbAdmins[$dbKey] = new $className
      (
        UiConsole::getActive(),
        $dbName,
        $user,
        $pwd,
        $host,
        $port,
        $dbSchema
      );
      
      if ( $protocol )
        self::$dbAdmins[$dbKey]->setProtocol( $protocol );
      
    }
    
    return self::$dbAdmins[$dbKey];
    
    
  }//end public static function getAdmin */

////////////////////////////////////////////////////////////////////////////////
// Alter Code
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Login Variablen ins Environment schreiben
   */
  public static function setLoginEnv( $user, $pwd  )
  {
    // der root user muss vorhanden sein
    putenv( "PGUSER={$user}" );
    putenv( "PGPASSWORD={$pwd}" );
    
  }//end public static function setLoginEnv */
  
  /**
   * Setup für die Datenbank
   * @param array $databases
   * @param string $tmpFolder
   */
  public static function startSetup( $databases, $tmpFolder )
  {
    
    // der root user muss vorhanden sein
    Db::setLoginEnv( $databases['root_user'], $databases['root_pwd']  );

    foreach( $databases['db'] as $dbConf )
    {
      
      Console::outl( "Create Database User: ".$dbConf['owner'] );
      Db::createUser( $dbConf['owner'], $dbConf['owner_pwd'] );
      
      Console::outl( "Create Database: ".$dbConf['name'] );
      Db::createDatabase
      ( 
        $dbConf['name'], 
        $dbConf['owner'],
        ( isset($dbConf['encoding'])?$dbConf['encoding']:'utf-8' )
      );
      
      Console::outl( "Create Schema: ".$dbConf['schema'] );
      Db::createSchema( $dbConf['name'], $dbConf['schema'], $dbConf['owner'] );
      
      // Wenn vorhanden allgemeine Scripts laden
      if ( isset($databases['pre_scripts']) )
      {
        
        if ( !Fs::exists( $tmpFolder.'db_script/' ) )
          Fs::mkdir( $tmpFolder.'db_script/' );
        
        foreach( $databases['pre_scripts'] as $script )
        {
          if ( Fs::exists($script) )
          {
            $tmpScriptN = $tmpFolder.'db_script/pre_'.$dbConf['name'].'.sql';
            Db::createImportFile( $script, $dbConf, $tmpScriptN );
            Process::execute( 'psql '.$dbConf['name'].'  -h '.Db::$host.'  -f '.$tmpScriptN );
          }
          else 
          {
            Console::error( "Es wurde versucht ein nicht existierendes SQL Script {$script} zu laden" );
          }
        }
      }
      
      // Wenn vorhanden Süezifische Scripts Scripts laden
      if ( isset($dbConf['pre_scripts']) )
      {
        if ( !Fs::exists( $tmpFolder.'db_script/' ) )
          Fs::mkdir( $tmpFolder.'db_script/' );
        
        foreach( $dbConf['pre_scripts'] as $script )
        {
          if ( Fs::exists($script) )
          {
            $tmpScriptN = $tmpFolder.'db_script/pre_'.$dbConf['name'].'.sql';
            Db::createImportFile( $script, $dbConf, $tmpScriptN );
            Process::execute( 'psql '.$dbConf['name'].'  -h '.Db::$host.'  -f '.$tmpScriptN );
          }
          else 
          {
            Console::error( "Es wurde versucht ein nicht existierendes DB SQL Script {$script} zu laden" );
          }
        }
      }
      
    }

  }//end public static function startSetup */
  
  /**
   * Setup für die Datenbank
   * @param array $databases
   * @param string $tmpFolder
   */
  public static function finishSetup( $databases, $tmpFolder )
  {
    
    Db::setLoginEnv( $databases['root_user'], $databases['root_pwd']  );
    
    foreach( $databases['db'] as $dbConf )
    {

      // Wenn vorhanden allgemeine Scripts laden
      if ( isset($databases['post_scripts']) )
      {
        
        if ( !Fs::exists( $tmpFolder.'db_script/' ) )
          Fs::mkdir( $tmpFolder.'db_script/' );
          
        foreach( $databases['post_scripts'] as $script )
        {
          if ( Fs::exists($script) )
          {
            $tmpScriptN = $tmpFolder.'db_script/post_'.$dbConf['name'].'.sql';
            Db::createImportFile( $script, $dbConf, $tmpScriptN );
            Process::execute( 'psql '.$dbConf['name'].'  -h '.Db::$host.'  -f '.$tmpScriptN );
          }
          else 
          {
            Console::error( "Es wurde versucht ein nicht existierendes SQL Script {$script} zu laden" );
          }
        }
      }
      
      // Wenn vorhanden Süezifische Scripts Scripts laden
      if ( isset($dbConf['post_scripts']) )
      {
        if ( !Fs::exists( $tmpFolder.'db_script/' ) )
          Fs::mkdir( $tmpFolder.'db_script/' );
        
        foreach( $databases['post_scripts'] as $script )
        {
          if ( Fs::exists($script) )
          {
            $tmpScriptN = $tmpFolder.'db_script/post_'.$dbConf['name'].'.sql';
            Db::createImportFile( $script, $dbConf, $tmpScriptN );
            Process::execute( 'psql '.$dbConf['name'].'  -h '.Db::$host.'  -f '.$tmpScriptN );
          }
          else 
          {
            Console::error( "Es wurde versucht ein nicht existierendes SQL Script {$script} für die Datenbank {$dbConf['name']} zu laden" );
          }
        }
      }
      
    }

  }//end public static function setup */
  
  /**
   * @param array $gateways
   */
  public static function createUser(  $user, $pwd )
  {
    
    $val = Process::execute( 'psql postgres -h '.Db::$host.' -tAc "SELECT 1 FROM pg_roles WHERE rolname=\''.$user.'\'"' );
    
    if ( '1' == trim($val) )
      return true;
    
    
    $val = Process::execute( 'psql postgres -h '.Db::$host.' -tAc "CREATE USER '.$user.' with password \''.$pwd.'\'"' );
    
    Console::outl( $val );
    
    if ( 'CREATE ROLE' == trim($val) )
      return true;
    else
      return false;
    
  }//end public static function createUser */
  
  /**
   * @param string $dbName
   */
  public static function createDatabase(  $dbName, $owner, $encoding = "utf-8"  )
  {
    
    $val = Process::execute( 'psql postgres -h '.Db::$host.' -tAc "SELECT 1 FROM pg_database WHERE datname=\''.$dbName.'\'"' );
    
    if ( '1' == trim($val) )
      return true;
    
    $val = Process::execute
    ( 
      'psql postgres -h '.Db::$host.' -tAc "CREATE DATABASE '.$dbName
      .' with owner  '.$owner
      .' encoding \''.$encoding.'\'"' 
    );
    
    Console::outl( $val );
    
    if ( 'CREATE DATABASE' == trim($val) )
      return true;
    else
      return false;
    
  }//end public static function createUser */
  
  /**
   * @param string $dbName
   * @param string $schema
   * @param string $owner
   */
  public static function createSchema(  $dbName, $schema, $owner   )
  {
    
    $val = Process::execute( 'psql postgres -h '.Db::$host.' -tAc "SELECT 1 FROM schemata WHERE catalog_name=\''.$dbName.'\'" and schema_name=\''.$schema.'\'' );
    
    if ( '1' == trim($val) )
      return true;
    
    $val = Process::execute
    ( 
      'psql '.$dbName.' -h '.Db::$host.' -tAc "CREATE SCHEMA '.$schema
      .' AUTHORIZATION '.$owner.';"'
    );
    
    Console::outln( $val );

    if ( 'CREATE SCHEMA' == trim($val) )
      return true;
    else
      return false;
    
  }//end public static function createSchema */
  
  /**
   * @param array $gateways
   */
  public static function syncDatabase( $gateways, $deployPath )
  {

    foreach( $gateways as $gatewayProject )
    {
      Fs::chdir( GAIA_PATH );
      Process::run( 'bash ./sync_database.sh "'.$deployPath.$gatewayProject['name'].'"' );    
    }
    
  }//end public static function syncDatabase */

  
  /**
   * @param string $scriptPath
   * @param string $dbConf
   * @param string $tmpName
   */
  public static function createImportFile( $scriptPath, $dbConf, $tmpName )
  {
    
    file_put_contents
    ( 
      $tmpName, 
      str_replace
      (
        array( '{@schema@}','{@owner@}' ), 
        array( $dbConf['schema'], $dbConf['owner'] ), 
        file_get_contents( $scriptPath )
      )
    );  
    
  }//end public static function createImportFile */
  
  /**
   * Analysieren der Rückgabe auf Fehler
   * @param string $msg
   */
  public static function searchError( $msg )
  {
    
    if ( false !== strpos($msg, 'FATAL:  Ident-Authentifizierung') )
      throw new DbException
      ( 
        'Die Datenbank hat den Login verweigert. Dafür kann es mehrer Möglichkeiten geben.
        Der Benutzer ist falsch geschrieben, existiert nicht, das Password könnte falsch sein,
        oder in der pg_hba.conf ist für local indent anstelle von md5 eingetragen.' 
      );
    
    // kein fehler gefunden
    return null;
    
  }//end public static function searchError */
  
  /**
   * @param string $query
   * @param string $dbName
   * @param string $user
   * @param string $passwd
   */
  public static function query( $query, $dbName, $user = null, $passwd = null )
  {
    
    if ( $user && $passwd )
      Db::setLoginEnv( $user, $passwd );
    
    return Process::execute( 'psql '.$dbName.' -h '.Db::$host.' -tAc "'.$query.'"' );

  }//end public static function query */
  
////////////////////////////////////////////////////////////////////////////////
// Restart
////////////////////////////////////////////////////////////////////////////////
  
  /**
   */
  public static function reload( )
  {
    
    Process::execute( "/etc/init.d/postgresql reload" );
    
  }//end public static function reload */
  
  /**
   */
  public static function restart( )
  {
    
    Process::execute( "/etc/init.d/postgresql restart" );
    
  }//end public static function restart */
  
  /**
   */
  public static function start( )
  {
    
    Process::execute( "/etc/init.d/postgresql start" );
    
  }//end public static function start */
  
  /**
   */
  public static function stop( )
  {
    
    Process::execute( "/etc/init.d/postgresql stop" );
    
  }//end public static function stop */ 
  
}//end class Db
