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
class SetupDbPostgresql
  extends SetupDb
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  
  /**
   * Die Connection Resource
   * @var DbPostgresql
   */
  protected $connection = null;
  
  /**
   * @var ConsoleUi
   */
  protected $console = null;

  
////////////////////////////////////////////////////////////////////////////////
// Init
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param UiConsole $console
   * @param ProtocolWriter $protocol
   */
  public function __construct
  (
    $console,
    $protocol = null
  )
  {

    $this->console     = $console;
    $this->protocol    = $protocol;
    
  }//end public function __construct */
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath 
   */
  public function setup( $package, $gateway, $server, $database, $dataPath  )
  {
    
    ///TODO Check bauen ob pg auch läuft wenn nicht automatisch starten
    $type = $database->getType();
    $host = $database->getHost();
    $port = $database->getPort();
    
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    
    $dbUser    = $database->getDbUser();
    $dbUserPwd = $database->getDbPwd();
    
    $adminUser = $database->getAdminUser();
    $adminPwd  = $database->getAdminPwd();
    
    // laden des datenbank admins
    $this->dbAdmin = Db::getAdmin
    (
      $type,
      $host,
      $port,
      $dbName,
      $dbSchema,
      $adminUser,
      $adminPwd,
      $this->protocol
    );

    // das DBMS installieren
    $this->installDbms( $package, $gateway, $server, $database );
    
    // custom user und gruppen anlegen
    $this->setupCustomUserAndRoles( $package, $gateway, $server, $database );
    
    // datenbank, schema + standard User anlegen
    $this->setupDatabase( $package, $gateway, $server, $database, $dataPath );
    
    $this->dbAdmin->setConnection( new DbPostgresql
    (
      $this->console, 
      $dbName, 
      $adminUser, 
      $adminPwd,
      $host,
      $port,
      $dbSchema
    ));
    
    // sicher gehen, dass die rechte in potentiell vorhandenen strukturen
    // stimmen
    $this->setRights( $package, $gateway, $server, $database );
    
    // Die nötigen sequences anlegen
    $this->setupSequences( $package, $gateway, $server, $database );
    
    // Das Gateway die Datenstruktur erstellen lassen
    $this->syncGatewayDatabase( $package, $gateway, $server, $database, $dataPath );

    // setzen der rechte
    $this->setRights( $package, $gateway, $server, $database );
    
  }//end protected function setup */
  
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath 
   */
  public function update( $package, $gateway, $server, $database, $dataPath  )
  {
    
    ///TODO Check bauen ob pg auch läuft wenn nicht automatisch starten
    $type = $database->getType();
    $host = $database->getHost();
    $port = $database->getPort();
    
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    
    $dbUser    = $database->getDbUser();
    $dbUserPwd = $database->getDbPwd();
    
    $adminUser = $database->getAdminUser();
    $adminPwd  = $database->getAdminPwd();
    
    $this->dbAdmin = Db::getAdmin
    (
      $type,
      $host,
      $port,
      $dbName,
      $dbSchema,
      $adminUser,
      $adminPwd,
      $this->protocol
    );

    // das DBMS installieren sollte bereits installiert sein.. oder?
    // $this->installDbms( $package, $gateway, $server, $database );
    
    // custom user und gruppen anlegen
    $this->setupCustomUserAndRoles( $package, $gateway, $server, $database );
    
    // datenbank, schema + standard User anlegen
    $this->updateDatabase( $package, $gateway, $server, $database );

    
    $this->dbAdmin->setConnection( new DbPostgresql
    (
      $this->console, 
      $dbName, 
      $adminUser, 
      $adminPwd,
      $host,
      $port,
      $dbSchema
    ));
    
    
    // sicher gehen, dass vorhandene rechte passen
    $this->setRights( $package, $gateway, $server, $database );
    
    // Die nötigen sequences anlegen
    $this->setupSequences( $package, $gateway, $server, $database );
    
    $this->cleanBeforeUpdate( $package, $gateway, $server, $database );
    
    // Das Gateway die Datenstruktur erstellen lassen
    $this->syncGatewayDatabase( $package, $gateway, $server, $database, $dataPath );

    // abschliesend nochmal vorsichtshalber alle rechte richtig setzen
    $this->setRights( $package, $gateway, $server, $database );
    
  }//end protected function update */
  
////////////////////////////////////////////////////////////////////////////////
// 
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   */
  protected function installDbms( $package, $gateway, $server, $database  )
  {
    
    // prüfen ob der server installiert werden soll
    if ( !$database->installServer() )
      return;
    
    $dbType = ucfirst($database->getType());
    
    if ( Environment::$isRoot )
    {
      try 
      {
        $dbInstaller = Software::getInstaller( $dbType );
        /* @var $dbInstaller Software */
        
        if ( !$dbInstaller->allreadyInstalled() )
        {
          $this->protocol->info( "{$dbType} is not yet installed. The installer will install it and make the setup for you." );
          $dbInstaller->installCore();
        }
        else
        {
          $this->protocol->info( "{$dbType} is allready installed." );
        }
        
      }
      catch( GaiaException $exc )
      {
        $this->console->error($exc->getMessage());
        continue;
      }
    }
    else 
    {
      $this->protocol->warning
      (
        "Script is running without root permission. I'm not able to check if the expected DBMS is allready installed." 
      );
    }

    
  }//end protected function installDbms */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath
   */
  protected function setupDatabase( $package, $gateway, $server, $database, $dataPath  )
  {
    

    ///TODO Check bauen ob pg auch läuft wenn nicht automatisch starten
    $type = $database->getType();
    $host = $database->getHost();
    $port = $database->getPort();
    
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    
    $dbUser    = $database->getDbUser();
    $dbUserPwd = $database->getDbPwd();

    if ( !$this->dbAdmin->userExists( $dbUser ) )
    {
      $this->protocol->info( "Lege den DB Backenduser: {$dbUser} an." );
      if ( !$this->dbAdmin->createBackendUser( $dbUser, $dbUserPwd ) )
      {
        $fatal = 'Konnte den DB User: '.$dbUser.' nicht anlegen';
        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }
    }
    
    if ( !$this->dbAdmin->databaseExists( $dbName ) )
    {
      $this->protocol->info( "Erstelle die Datenbank: {$dbName} neu." );
      
      if ( !$this->dbAdmin->createDatabase( $dbName, $dbUser ) )
      {
        $fatal = 'Konnte die Datenbank: '.$dbName.' nicht anlegen';
        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }
    }
    
    $dumpFile = $database->getDumpFile();
    
    if ( $dumpFile )
    {
      
      $this->protocol->info( "Erstelle Datenbankschema aus Dump: ".$dumpFile );
      
      $dbDump     = $dataPath.'db_dump/'.$dumpFile;
      $dumpSchema = $database->getDumpFileSchema();
      
      if ( Fs::exists( $dbDump ) )
      {
        $this->dbAdmin->restoreSchema( $dbName, $dbSchema, $dbDump, $dumpSchema );
      }
      else 
      {
        $fatal = 'Der Datenbankdump: '.$dbDump.' welcher importiert werden sollte existiert nicht oder ist invalide.';
        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }
      
    }
    else 
    {
      $this->setupDatabaseSchema( $package, $gateway, $server, $database, $dataPath );
    }

    // standard OID Sequence erstellen
    if ( !$this->dbAdmin->sequenceExists( $dbName, $dbSchema, 'entity_oid_seq' ) )
    {
      $this->protocol->info( "Erstelle Sequence: entity_oid_seq in {$dbName}.{$dbSchema}." );
      $this->dbAdmin->createSequence( $dbName, $dbSchema, 'entity_oid_seq', $dbUser );
    }
    
    if ( !$this->dbAdmin->sequenceExists( $dbName, $dbSchema, 'wbf_deploy_revision' ) )
    {
      $this->protocol->info( "Erstelle Sequence: wbf_deploy_revision in {$dbName}.{$dbSchema}." );
      $this->dbAdmin->createSequence( $dbName, $dbSchema, 'wbf_deploy_revision', $dbUser );
    }
    
  }//end protected function setupDatabase */

  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath
   */
  protected function setupDatabaseSchema( $package, $gateway, $server, $database, $dataPath  )
  {
    
    ///TODO Check bauen ob pg auch läuft wenn nicht automatisch starten
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    
    $dbUser    = $database->getDbUser();
    $dbUserPwd = $database->getDbPwd();

    
    if ( $this->dbAdmin->schemaExists( $dbName, $dbSchema ) )
    {
      $this->protocol->info( "Das Zielschema: {$dbSchema} existiert bereits." );
      
      $action = (int)$this->console->radioList
      ( 
        "Das angegeben Schema existiert bereits.", 
        array
        (
          array
          (
            'Select' => '1',
            'Option' => '1',
            'Desc' => 'Schema einfach verwenden, und nicht anpassen.'
          ),
          array
          (
            'Select' => '2',
            'Option' => '2',
            'Desc' => 'Schema verwenden und aktualisieren.'
          ),
          array
          (
            'Select' => '3',
            'Option' => '3',
            'Desc' => 'Vorhandene Schema umbenennen und eigenes Schema erstellen.'
          ),
          array
          (
            'Select' => '4',
            'Option' => '4',
            'Desc' => "Vorhandenes Schema löschen.\n(In den meisten Fällen keine gute Idee... Hoffe du hast ein Backup)"
          ),
          array
          (
            'Select' => '5',
            'Option' => '5',
            'Desc' => 'Setup Abbrechen'
          )
        ),
        array(),
        new UiDimension( 700,250 )
      );
      
      switch ( $action )
      {
        case '1':
        {
          $this->protocol->info
          ( 
            "Der User hat enschieden, dass vorhandene Schema: {$dbSchema}"
            ." in der Datenbank {$dbName} unverändert zu verwenden."
          );
          continue;
          break;
        }
        case '2':
        {
          $this->protocol->info
          ( 
            "Der User hat enschieden, dass vorhandene Schema: {$dbSchema} in der"
            ." Datenbank {$dbName} zu verwenden, aber an das neue System soweit nötig anzupassen."
          );

          break;
        }
        case '3':
        {
          $this->protocol->info
          ( 
            "Der User hat enschieden, dass vorhandene Schema: {$dbSchema} umzubenennen, so dass"
            ." das Setup ein neues Schema anlegen kann."
          );
          
                      
          if ( !$this->dbAdmin->renameSchema( $dbName, $dbSchema, $dbSchema.'_setup_'.date('YmdHis') ) )
          {
              $fatal = <<<FATAL
Das Schema {$dbSchema} in der Datenbank {$dbName} konnte umbenannt werden.
Ich breche das Setup daher ab. 
FATAL;
            $this->protocol->fatal( $fatal );
            throw new GaiaException( $fatal );
          }
          
          if ( !$this->dbAdmin->createSchema( $dbName, $dbSchema, $dbUser ) )
          {
              $fatal = <<<FATAL
Das Schema {$dbSchema} in der Datenbank {$dbName} konnte nicht erstellt werden.
Ich breche das Setup daher ab. 
FATAL;
            $this->protocol->fatal( $fatal );
            throw new GaiaException( $fatal );
          }
          
          break;
        }
        case '4':
        {
          $this->protocol->warning
          ( 
            "Der User hat enschieden, dass vorhandene Schema: {$dbSchema} zu löschen,"
            ." so dass das Setup ein neues Schema aufsetzen kann. "
            ." Fürs Protokoll er wurde gewarnt, dass das womöglich keine gute Idee ist."
          );
          
          if ( !$this->dbAdmin->dropSchema( $dbName, $dbSchema ) )
          {
              $fatal = <<<FATAL
Das Schema {$dbSchema} in der Datenbank {$dbName} konnte nicht gelöscht werden.
Ich breche das Setup daher ab. 
FATAL;
            $this->protocol->fatal( $fatal );
            throw new GaiaException( $fatal );
          }
          
          if ( !$this->dbAdmin->createSchema( $dbName, $dbSchema, $dbUser ) )
          {
              $fatal = <<<FATAL
Das Schema {$dbSchema} in der Datenbank {$dbName} konnte nicht erstellt werden.
Ich breche das Setup daher ab. 
FATAL;
            $this->protocol->fatal( $fatal );
            throw new GaiaException( $fatal );
          }

          break;
        }
        case '5':
        {
              $fatal = <<<FATAL
Benutzer hat sich entschlossen das Setup abzubrechen, da in der Datenbank
bereits ein Schema mit dem Namen: {$dbSchema} in der Datenbank {$dbName} vorhanden war. 
FATAL;
          $this->protocol->fatal( $fatal );
          throw new GaiaException( $fatal );
          break;
        }
      }
      
    }
    else 
    {
      $this->protocol->info( "Schema: {$dbSchema} existiert noch nicht in der Datenbank: {$dbName} und wird neu erstellt." );
      if ( !$this->dbAdmin->createSchema( $dbName, $dbSchema, $dbUser ) )
      {
          $fatal = <<<FATAL
Das Schema {$dbSchema} in der Datenbank {$dbName} konnte nicht erstellt werden.
Ich breche das Setup daher ab. 
FATAL;
        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }
    }

  }//end protected function setupDatabaseSchema */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   */
  protected function setupCustomUserAndRoles( $package, $gateway, $server, $database  )
  {
    
    $users = $database->getUsers();
    
    foreach( $users as /* @var $user PackageDbUser  */ $user )
    {
      if ( !$this->dbAdmin->userExists($user->getName()) )
      {
        $this->dbAdmin->createUser( $user->getName(), $user->getPasswd(), $user->getType()  );
      }
    }
    
    $groups = $database->getRoles();
    
    foreach( $groups as /* @var $group PackageDbGroup  */ $group )
    {
      if ( !$this->dbAdmin->groupExists( $group->getName() ) )
      {
        $this->dbAdmin->createGroup( $group->getName() );
      }
    }

  }//end protected function setupCustomUserAndRoles */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   */
  protected function setupSequences( $package, $gateway, $server, $database  )
  {
    
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    
    $sequences = $database->getSequences();
    
    foreach( $sequences as /* @var $sequence PackageDbSequence */ $sequence )
    {
      $this->dbAdmin->createSequence
      ( 
        $dbName,
        $dbSchema,
        $sequence->getName(), 
        $sequence->getIncrement(), 
        $sequence->getStart(),
        $sequence->getMinValue(),
        $sequence->getMaxValue()  
      );
    }

  }//end protected function setupSequences */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath
   * 
   * @throws GaiaException
   *   Wenn die Syntax eines Inputfiles broken ist
   */
  protected function setupSystemLogic( $package, $gateway, $server, $database, $dataPath  )
  {
    
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    $dbUser    = $database->getDbUser();

    $files     = $database->getStructureFiles();

    if ( $this->dbAdmin->con )
    {
      foreach( $files as /* @var PackageDbDumpFile $file */ $file )
      {
        
        $fileName = $dataPath.'db_dump/'.$file->getGateway().'/data/ddl/postgresql/gaia/'.$file->getName().'.php';
        $this->protocol->info( 'Execute SQL file: '.$fileName );
  
        $this->dbAdmin->importStructureFile( $fileName, $dbName, $dbSchema, $dbUser );
      }
    }
    else 
    {
      foreach( $files as /* @var PackageDbDumpFile $file */ $file )
      {
        
        $fileName = $dataPath.'db_dump/'.$file->getGateway().'/data/ddl/postgresql/'.$file->getName().'.sql';
        $this->protocol->info( 'Execute SQL file: '.$fileName );
  
        $this->dbAdmin->importStructureFile( $fileName, $dbName, $dbSchema, $dbUser );
      }
    }

    

  }//end protected function setupSystemLogic */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   */
  protected function setRights( $package, $gateway, $server, $database )
  {
    
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    $dbUser    = $database->getDbUser();

    $this->dbAdmin->chownSchemaCascade( $dbName, $dbSchema, $dbUser );
    

  }//end protected function setRights */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath
   */
  public function syncGatewayDatabase( $package, $gateway, $server, $database, $dataPath )
  {
    
    $codeRoot  = $gateway->getCodeRoot();
    $gwName    = $gateway->getName();
    
    $gwPath = realpath( $codeRoot.'/'.$gwName );
    
    // sicher stellen, dass wir im Gaia Path sind
    Fs::chdir( GAIA_PATH );
    
    // den datenbanksync starten
    Process::run( 'bash ./gaia/scripts/sync_database.sh "'.$gwPath.'" "'.$dataPath.'/metadata/" ' );   

    // Erstellen der Systemlogik wie Views, Functions, Keys etc
    Fs::chdir( GAIA_PATH );
    $this->setupSystemLogic( $package, $gateway, $server, $database, $dataPath );
    
    Fs::chdir( GAIA_PATH );
    Process::run( 'bash ./gaia/scripts/sync_metadata.sh "'.$gwPath.'" "'.$dataPath.'/metadata/" ' );
    
    Fs::chdir( GAIA_PATH );
    Process::run( 'bash ./gaia/scripts/sync_data.sh "'.$gwPath.'" "'.$dataPath.'/metadata/" ' );
    
    // und wieder in den Gaia Path
    Fs::chdir( GAIA_PATH );
    
  }//end public function syncGatewayDatabase */
  
////////////////////////////////////////////////////////////////////////////////
// UPDATE logic
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   */
  protected function updateDatabase( $package, $gateway, $server, $database  )
  {
    

    ///TODO Check bauen ob pg auch läuft wenn nicht automatisch starten
    $type = $database->getType();
    $host = $database->getHost();
    $port = $database->getPort();
    
    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    
    $dbUser    = $database->getDbUser();
    $dbUserPwd = $database->getDbPwd();

    if ( !$this->dbAdmin->userExists( $dbUser ) )
    {
      $this->protocol->info( "Lege den DB Backenduser: {$dbUser} an." );
      if ( !$this->dbAdmin->createBackendUser( $dbUser, $dbUserPwd ) )
      {
        $fatal = 'Konnte den DB User: '.$dbUser.' nicht anlegen';
        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }
    }
    
    if ( !$this->dbAdmin->databaseExists( $dbName ) )
    {
      $this->protocol->info( "Erstelle die Datenbank: {$dbName} neu." );
      
      if ( !$this->dbAdmin->createDatabase( $dbName, $dbUser ) )
      {
        $fatal = 'Konnte die Datenbank: '.$dbName.' nicht anlegen';
        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }
    }
    
    if ( !$this->dbAdmin->schemaExists( $dbName, $dbSchema ) )
    {
      $this->protocol->info( "Schema: {$dbSchema} existiert noch nicht in der Datenbank: {$dbName} und wird neu erstellt." );
      if ( !$this->dbAdmin->createSchema( $dbName, $dbSchema, $dbUser ) )
      {
          $fatal = <<<FATAL
Das Schema {$dbSchema} in der Datenbank {$dbName} konnte nicht erstellt werden.
Ich breche das Update daher ab. 
FATAL;
        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }
    }
    
    // standard OID Sequence erstellen
    if ( !$this->dbAdmin->sequenceExists( $dbName, $dbSchema, 'entity_oid_seq' ) )
    {
      $this->dbAdmin->createSequence( $dbName, $dbSchema, 'entity_oid_seq', $dbUser );
    }
    
    if ( !$this->dbAdmin->sequenceExists( $dbName, $dbSchema, 'wbf_deploy_revision' ) )
    {
      $this->dbAdmin->createSequence( $dbName, $dbSchema, 'wbf_deploy_revision', $dbUser );
    }
    
  }//end protected function updateDatabase */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   */
  protected function cleanBeforeUpdate( $package, $gateway, $server, $database  )
  {
    ///TODO Check bauen ob pg auch läuft wenn nicht automatisch starten

    $dbName    = $database->getDbName();
    $dbSchema  = $database->getDbSchema();
    
    // löschen aller views vor dem update
    if ( $database->updateFlag( 'clean/views' ) )
    {
      $this->protocol->info( "Lösche alle Views vor dem Update um Konflikte zu vermeiden" );
      $this->dbAdmin->dropSchemaViews( $dbName, $dbSchema );
    }

  }//end protected function cleanBeforeUpdate */

  /**
   * Setup für die Datenbank
   * @param array $databases
   * @param string $tmpFolder
   * /
  public function startSetup( $databases, $tmpFolder )
  {
    
    // der root user muss vorhanden sein
    SetupDbPostgresql::setLoginEnv( $databases['root_user'], $databases['root_pwd']  );

    foreach( $databases['db'] as $dbConf )
    {
      
      Console::outl( "Create Database User: ".$dbConf['owner'] );
      SetupDbPostgresql::createUser( $dbConf['owner'], $dbConf['owner_pwd'] );
      
      Console::outl( "Create Database: ".$dbConf['name'] );
      SetupDbPostgresql::createDatabase
      ( 
        $dbConf['name'], 
        $dbConf['owner'],
        ( isset($dbConf['encoding'])?$dbConf['encoding']:'utf-8' )
      );
      
      Console::outl( "Create Schema: ".$dbConf['schema'] );
      SetupDbPostgresql::createSchema( $dbConf['name'], $dbConf['schema'], $dbConf['owner'] );
      
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
            SetupDbPostgresql::createImportFile( $script, $dbConf, $tmpScriptN );
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
            SetupDbPostgresql::createImportFile( $script, $dbConf, $tmpScriptN );
            Process::execute( 'psql '.$dbConf['name'].'  -h '.Db::$host.'  -f '.$tmpScriptN );
          }
          else 
          {
            Console::error( "Es wurde versucht ein nicht existierendes DB SQL Script {$script} zu laden" );
          }
        }
      }
      
    }

  }//end public function startSetup */
  
  /**
   * Setup für die Datenbank
   * @param array $databases
   * @param string $tmpFolder
   * /
  public function finishSetup( $databases, $tmpFolder )
  {
    
    SetupDbPostgresql::setLoginEnv( $databases['root_user'], $databases['root_pwd']  );
    
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
            SetupDbPostgresql::createImportFile( $script, $dbConf, $tmpScriptN );
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
            SetupDbPostgresql::createImportFile( $script, $dbConf, $tmpScriptN );
            Process::execute( 'psql '.$dbConf['name'].'  -h '.Db::$host.'  -f '.$tmpScriptN );
          }
          else 
          {
            Console::error( "Es wurde versucht ein nicht existierendes SQL Script {$script} für die Datenbank {$dbConf['name']} zu laden" );
          }
        }
      }
      
    }

  }//end public function setup */

  
  /**
   * @param array $gateways
   * /
  public function syncGatewayDatabase( $gateways, $deployPath )
  {

    foreach( $gateways as $gatewayProject )
    {
      Fs::chdir( GAIA_PATH );
      Process::run( 'bash ./gaia/scripts/sync_database.sh "'.$deployPath.$gatewayProject['name'].'"' );    
    }
    
  }//end public function syncGatewayDatabase */

  
  /**
   * @param string $scriptPath
   * @param string $dbConf
   * @param string $tmpName
   */
  public function createImportFile( $scriptPath, $dbConf, $tmpName )
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
    
  }//end public function createImportFile */
  
  /**
   * Analysieren der Rückgabe auf Fehler
   * @param string $msg
   */
  public function searchError( $msg )
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
    
  }//end public function searchError */


  
}//end class SetupDbPostgresql
