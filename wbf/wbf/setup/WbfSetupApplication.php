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
 * @package WebFrap
 * @subpackage Gaia
 */
class WbfSetupApplication
  extends WbfSetup
{

  /**
   * @param Package $package
   */
  public function setup( $package )
  {

    $this->protocol = Protocol::openProtocol
    (
      null,
      'Application Deployment: '.$package->getName().' '.date('Y-m-d H:i:s'),
      'setup'
    );

    if ($package->hasCustom) {
      $this->protocol->subHead( 'Custom Daten' );

      if( $package->dataPath )
        $this->protocol->info( "Using Data Path: {$package->dataPath}" );

      if( $package->codeRoot )
        $this->protocol->info( "Using Code Root: {$package->codeRoot}" );

      if( $package->confKey )
        $this->protocol->info( "Using Conf Key: {$package->confKey}" );

      if( $package->serverKey )
        $this->protocol->info( "Using Server Key: {$package->serverKey}" );

      if( $package->deplGateway )
        $this->protocol->info( "Using Depl Gateway: {$package->deplGateway}" );

      if( $package->gwName )
        $this->protocol->info( "Using GW Name: {$package->gwName}" );

    }

    $gateways = $package->getGateways();

    foreach ($gateways as /* @var $gateway PackageGateway */ $gateway) {
      $this->setupGateway( $package, $gateway );
      $this->setupIconThemes( $package, $gateway );
      $this->setupUiThemes( $package, $gateway );
      $this->setupWgt( $package, $gateway );
      $this->copyCodeModules(  $package, $gateway );
      $this->copyCodeVendorModules(  $package, $gateway );

      $this->setupPermissions(  $package, $gateway );

      $this->setupDatabases( $package, $gateway );

      $this->setupSystemUsers( $package, $gateway );
    }

    Protocol::closeProtocol();

  }//end public function setup */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function setupGateway( $package, $gateway )
  {

    $request = $this->getRequest();

    $codeRoot  = $gateway->getCodeRoot();

    $gwName    = $gateway->getName();
    $gwSrc     = $gateway->getSrc();

    $this->protocol->subHead( 'Deploy Gateway '.$gwName.' to '.$codeRoot );

    if ( !Fs::exists($codeRoot) ) {
      if ( !Fs::mkdir($codeRoot)) {
        $this->protocol->error( 'Konnte das Zielverzeichnis: '.$codeRoot.' nicht anlegen.' );
        throw new GaiaException( 'Konnte das Zielverzeichnis: '.$codeRoot.' nicht anlegen.' );
      }
    }

    $gwSrcPath    = $this->dataPath.'gateway/'.$gwSrc;
    $gwTargetPath = $codeRoot.'/'.$gwName;

    if ( !Fs::exists($gwSrcPath) ) {
      $error = 'Konnte keine Daten zu dem Gateway: '.$gwSrc.' unter '.$gwSrcPath.' finden.';
      $this->protocol->error( $error );
      throw new GaiaException( $error );
    }

    if ( Fs::exists( $gwTargetPath ) ) {

      if( !$this->console->question
      (
        <<<QUESTION
Es existiert bereits ein Gateway unter: {$gwTargetPath}.
Soll die vorhandene Installation komplett überschrieben werden?

Warnung wenn du jetzt auf ja klickst werden alle Daten
die sich in der Installation befinden gelöscht.
QUESTION
      ))
      {

        $errMsg = <<<ERROR
Die Installation wurde abgebrochen da unter "{$gwTargetPath}"
bereits eine Installation vorhanden war.

Zum updaten der Installation bitte das update Script verwenden.
ERROR;

        $this->protocol->error( $errMsg );
        throw new GaiaException( $errMsg );
      }

      // löschen der alten installation
      // Hoffentlich hat da jemand gut drüber nachgedacht
      Fs::del( $gwTargetPath );
    }

    if ( !Fs::copyContent( $gwSrcPath, $gwTargetPath ) ) {
      $error = 'Kopieren der Gatewaydaten ist fehlgeschlagen';
      $this->protocol->error( $error );
      throw new GaiaException( $error );
    }

    // sollten versehentlich die sessiondaten mitkopiert worden sein
    // sicherstellen dass keine alten sessiondaten kopiert wurden
    if ( Fs::exists( $gwTargetPath.'/tmp/session' ) ) {
      $this->protocol->warning( 'lösche vorhadenen sessiondaten in '.$gwTargetPath.'/tmp/session' );
      Fs::del( $gwTargetPath.'/tmp/session' );
    }
    Fs::mkdir( $gwTargetPath.'/tmp/session' );

    // sicher stellen, dass der cache nicht mit deployt wurde
    if ( Fs::exists( $gwTargetPath.'/cache' ) ) {
      $this->protocol->warning( 'lösche vorhadenen cache in '.$gwTargetPath.'/cache' );
      Fs::del( $gwTargetPath.'/cache' );
    }
    Fs::mkdir( $gwTargetPath.'/cache' );

    // bearbeiten der gmod includes
    if ( Fs::exists( $gwTargetPath.'/conf/include/available_gmod' ) ) {
      $this->protocol->warning( 'Leere /conf/include/available_gmod in '.$gwTargetPath );
      Fs::del( $gwTargetPath.'/conf/include/available_gmod' );
    }
    Fs::mkdir( $gwTargetPath.'/conf/include/available_gmod' );

    if ( Fs::exists( $gwTargetPath.'/conf/include/gmod' ) ) {
      $this->protocol->warning( 'Leere /conf/include/gmod in '.$gwTargetPath );
      Fs::del( $gwTargetPath.'/conf/include/gmod' );
    }
    Fs::mkdir( $gwTargetPath.'/conf/include/gmod' );

    // bearbeiten der module includes
    if ( Fs::exists( $gwTargetPath.'/conf/include/available_module' ) ) {
      $this->protocol->warning( 'Leere /conf/include/available_module in '.$gwTargetPath );
      Fs::del( $gwTargetPath.'/conf/include/available_module' );
    }
    Fs::mkdir( $gwTargetPath.'/conf/include/available_module' );

    if ( Fs::exists( $gwTargetPath.'/conf/include/module' ) ) {
      $this->protocol->warning( 'Leere /conf/include/module in '.$gwTargetPath );
      Fs::del( $gwTargetPath.'/conf/include/module' );
    }
    Fs::mkdir( $gwTargetPath.'/conf/include/module' );

    // bearbeiten der metadata includes
    if ( Fs::exists( $gwTargetPath.'/conf/include/metadata' ) ) {
      $this->protocol->warning( 'Leere /conf/include/metadata in '.$gwTargetPath );
      Fs::del( $gwTargetPath.'/conf/include/metadata' );
    }
    Fs::mkdir( $gwTargetPath.'/conf/include/metadata' );


    // kopieren der conf
    // conf kann aus dem request genommen werden
    // wenn nicht im request wird in der package.bdl gesucht
    $confKey = $gateway->getConfKey();


    if ($confKey) {
      $this->protocol->info( "Use configuration {$confKey}" );

      if ( Fs::exists( $gwTargetPath.'/conf/space/'.$confKey ) ) {
        Fs::copyContent( $gwTargetPath.'/conf/space/'.$confKey, $gwTargetPath.'/conf/' );
      } else {

        $fatal = <<<FATAL
Die angefragte Konfiguration: {$confKey} existiert nicht im Gateway: {$gwTargetPath}/conf/space/
FATAL;

        $this->protocol->fatal( $fatal );
        throw new GaiaException( $fatal );
      }

    }



  }//end protected function setupGateway */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function setupPermissions( $package, $gateway )
  {

    $request = $this->getRequest();

    $codeRoot  = $gateway->getCodeRoot();

    $gwName    = $gateway->getName();
    $gwSrc     = $gateway->getSrc();

    $this->protocol->subHead( 'Setup Permissions Gw: '.$gwName );

    $codePermission = $gateway->getCodePermission();
    if ($codePermission) {
      Fs::setPermission( $codePermission, $this->protocol );
    }

    $permissions = $gateway->getCustomPermissions();
    foreach ($permissions as /* @var StructPermission $permission */ $permission) {
      Fs::setPermission( $permission, $this->protocol );
    }

    // fix the permissions
    $gwPermission       = $gateway->getGwPermission();
    $gwEditPermissions  = $gateway->getGwEditPermissions();

    if ($gwPermission) {
      Fs::setPermission( $gwPermission, $this->protocol );
    }

    foreach ($gwEditPermissions as $perm) {
      try {
        Fs::setPermission( $perm, $this->protocol );
      } catch ( GaiaException  $exc ) {
        $this->protocol->warning( $exc->getMessage() );
      }
    }

  }//end protected function setupPermissions */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Setup der Icon Themes
   */
  protected function setupIconThemes( $package, $gateway )
  {

    // laden der nötigen informationen
    $codeRoot      = $gateway->getCodeRoot();
    $iconThemeName = $gateway->getIconThemeName();

    if (!$iconThemeName) {
      $this->protocol->info( "Das Paket enthält keine Icon Themes, es wird nur das Standard WGT Theme vorhanden sein." );

      return;
    }

    $folders       = $gateway->getIconThemeFolders();

    $themeTargetPath = $codeRoot.'/'.$iconThemeName;

    $this->protocol->subHead( 'Deploy IconThemes '.$iconThemeName.' to '.$themeTargetPath );

    if ( Fs::exists($themeTargetPath) ) {

      if ( 0 == count($folders) ) {

        $this->protocol->info
        (
          'Das definierte Icontheme '.$iconThemeName.' enthält im Paket keine Theme-Informationen. Auf
dem Zielsystem sind jedoch bereits Themeinformationen vorhanden. Das Deploymentsystem geht davon aus,
dass die vorhanden Informationen auch für hier neu deployte Gateway verwendet werden können.'
        );

        $this->console->info
        (
        <<<INFO
Für das Gateway wurde keine neuen Icon Themes definiert.
Der angegebenen Icon Theme Container "{$themeTargetPath}" existiert jedoch bereits .
Es wird daher davon ausgegangen, dass die benötigten Icon Themes bereits vorhanden sind.
INFO
        );
      } else if( !$this->console->question
      (
        <<<QUESTION
Es existiert bereits ein Icon Theme Container unter dem Pfad: {$themeTargetPath}.
Soll der Container um die neuen Themes ergänzt werden?
QUESTION
      ))
      {

        $this->protocol->fatal
        (
          'Die Installation wurde manuell abgebroche, da es einen Konflikt mit einem
bereits vohandenen Theme in '.$iconThemeName.' gab. Der Benutzer hat sich dafür entschieden
das vorhandene Theme nicht zu überschreiben, daher wurde die Installation abgebrochen.'
        );

        throw new GaiaException
        (
        <<<ERROR
Die Installation wurde abgebrochen da unter "{$themeTargetPath}"
bereits eine Installation vorhanden war.

Zum updaten der Installation bitte das update Script verwenden.
ERROR
        );
      } else {
        $this->protocol->info
        (
        <<<INFO
Im Gateway existieren bereits Theme Informationen für "{$themeTargetPath}".
Das Setup wird die neuen Informationen ergänzen.
INFO
        );
      }
    }


    // alle ordner kopieren
    if ($folders) {
      foreach ($folders as $folder) {

        $iconSrcPath = realpath($this->dataPath.'/icon_theme/'.$folder);

        if ( !Fs::exists( $iconSrcPath ) ) {

          $error = <<<ERROR
Im Gateway wurde das IconTheme {$folder} für das setup definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen dass keine Icons vorhanden sein werden.
ERROR;

          $this->protocol->error( $error );
          $this->console->error( $error );
          continue;
        }

        if ( !Fs::copyContent( $iconSrcPath, $themeTargetPath ) ) {
          $fatal = "Kopieren des IconThemes \"{$iconSrcPath} => {$themeTargetPath}\" ist fehlgeschlagen.";
          $this->protocol->fatal( $fatal );
          throw new GaiaException( $fatal );
        }
      }
    }

  }//end protected function setupIconThemes */


  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Setup der Icon Themes
   */
  protected function setupUiThemes( $package, $gateway )
  {

    // laden der nötigen informationen
    $codeRoot      = $gateway->getCodeRoot();
    $uiThemeName   = $gateway->getUiThemeName();

    if (!$uiThemeName) {
      $this->protocol->info( "Das Paket enthält keine UI Themes, es wird nur das Standard WGT Theme vorhanden sein." );

      return;
    }

    $folders       = $gateway->getUiThemeFolders();

    $gwName        = $gateway->getName();
    $gwTargetPath  = $codeRoot.'/'.$gwName.'/';

    $themeTargetPath = $codeRoot.'/'.$uiThemeName;

    $this->protocol->subHead( 'Deploy UIThemes '.$uiThemeName.' to '.$themeTargetPath );

    Fs::touch( $gwTargetPath.'conf/include/module/'.$uiThemeName );

    if ( Fs::exists($themeTargetPath) ) {
      if ( 0 == count($folders) ) {

        $infoMsg = <<<INFO
Für das Gateway wurde keine neuen UI Themes definiert.
Der angegebenen UI Theme Container "{$themeTargetPath}" existiert jedoch bereits .
Es wird daher davon ausgegangen, dass die benötigten UI Themes bereits vorhanden sind.
INFO;

        $this->protocol->info( $infoMsg );
        $this->console->info( $infoMsg );

      } else if( !$this->console->question
      (
        <<<QUESTION
Es existiert bereits ein UI Theme Container unter dem Pfad: {$themeTargetPath}.
Soll der Container um die neuen Themes ergänzt werden?
QUESTION
      ))
      {

        $errorMsg = <<<ERROR
Die Installation wurde abgebrochen da unter "{$themeTargetPath}"
bereits eine Installation vorhanden war.

Zum updaten der Installation bitte das update Script verwenden.
ERROR;

        $this->protocol->info( $errorMsg );
        throw new GaiaException( $errorMsg );
      }
    }

    // alle ordner kopieren
    if ($folders) {

      foreach ($folders as $folder) {

        $uiSrcPath = realpath($this->dataPath.'/ui_theme/'.$folder);

        if ( !Fs::exists( $uiSrcPath ) ) {

          $errorMsg = <<<ERROR
Im Gateway wurde das UI Theme {$folder} für das setup definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen, dass keine Styleinformationen vorhanden sein werden.
ERROR;

          $this->protocol->error( $errorMsg );
          $this->console->error( $errorMsg );
          continue;
        }

        if ( !Fs::copyContent( $uiSrcPath, $themeTargetPath ) ) {
          $errorMsg = "Kopieren des UI Themes \"{$uiSrcPath} => {$themeTargetPath}\" ist fehlgeschlagen.";
          $this->protocol->error( $errorMsg );
          throw new GaiaException( $errorMsg );
        }

      }

    }

  }//end protected function setupUiThemes */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Setup der Icon Themes
   */
  protected function setupWgt( $package, $gateway )
  {

    // laden der nötigen informationen
    $codeRoot  = $gateway->getCodeRoot();
    $wgtName   = $gateway->getWgtName();

    if (!$wgtName) {
      $this->protocol->warning( "Das Paket enthält kein WGT Projekt. Das System kann nur im Servicemode betrieben werden." );

      return;
    }

    $folders   = $gateway->getWgtFolders();

    $wgtTargetPath = $codeRoot.'/'.$wgtName;

    $this->protocol->subHead( 'Deploy Wgt Project to '.$wgtTargetPath );

    if ( Fs::exists( $wgtTargetPath ) ) {
      if ( 0 == count($folders) ) {

        $infoMsg = <<<INFO
Für das Gateway wurde kein WGT Projekt definiert.
Das benötigte WGT Projekt existiert jedoch bereits unter "{$wgtTargetPath}".
Es wird davon ausgegangen, dass dieses WGT Projekt in der passenden Version vorliegt.
INFO;

        $this->protocol->info( $infoMsg );
        $this->console->info( $infoMsg );

      } else if( !$this->console->question
      (
        <<<QUESTION
Es existiert bereits ein WGT Projekt unter dem Pfad: {$wgtTargetPath}.
Soll das Projekt durch die aktuelle Version ersetzt werden?
QUESTION
      ))
      {

        $error = <<<ERROR
Die Installation wurde manuell abgebrochen, da bereits eine WGT installation vorhanden
war die nicht ersetzt werden sollte.
ERROR;

        $this->protocol->error( $error );
        throw new GaiaException( $error );
      }
    }

    // alle ordner kopieren
    if ($folders) {
      foreach ($folders as $folder) {

        $wgtSrcPath = realpath($this->dataPath.'/wgt/'.$folder);

        if ( !Fs::exists( $wgtSrcPath ) ) {
          $this->console->error
          (
        <<<ERROR
Im Gateway wurde das UI Theme {$folder} für das setup definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen, dass keine Styleinformationen vorhanden sein werden.
ERROR
          );
          continue;
        }

        if ( !Fs::copyContent( $wgtSrcPath, $wgtTargetPath ) ) {
          throw new GaiaException
          (
            "Kopieren des WGT Projektes \"{$wgtSrcPath} => {$wgtTargetPath}\" ist fehlgeschlagen."
          );
        }
      }
    }

  }//end protected function setupWgt */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Kopieren der Module
   */
  protected function copyCodeModules(  $package, $gateway )
  {

    $codeRoot    = $gateway->getCodeRoot();
    $modSrcPath  = $this->dataPath.'code/';

    $gwName        = $gateway->getName();
    $gwTargetPath  = $codeRoot.'/'.$gwName.'/';

    $modules = $gateway->getModules();

    foreach ($modules as /* @var $module PackageGatewayModule */ $module) {

      $modName = $module->getName();
      $modType = $module->getType();
      $folders = $module->getFolders();

      Fs::touch( $gwTargetPath.'conf/include/metadata/'.$modName );

      if ('genf' == $modType) {
        Fs::touch( $gwTargetPath.'conf/include/available_gmod/'.$modName );
        Fs::touch( $gwTargetPath.'conf/include/gmod/'.$modName );
      } else {
        Fs::touch( $gwTargetPath.'conf/include/available_module/'.$modName );
        Fs::touch( $gwTargetPath.'conf/include/module/'.$modName );
      }

      foreach ($folders as $folder) {

        if ( !Fs::exists( $modSrcPath.$folder ) ) {
          $this->console->error
          (
            <<<ERROR
Im Gateway wurde das Modul {$folder} für das setup definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen, dass ein Teil der erwarteten Funktionalität fehlen wird.
ERROR
          );
          continue;
        }

        $this->protocol->info( "Copy Module $modSrcPath.$folder => $codeRoot.'/'.$modName " );
        Fs::copyContent
        (
          $modSrcPath.$folder,
          $codeRoot.'/'.$modName
        );
      }

      $permission = $module->getPermission( $codeRoot );

      if( $permission )
        Fs::setPermission( $permission, $this->protocol );

    }

  }//end protected function copyCodeModules */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Kopieren der Module
   */
  protected function copyCodeVendorModules(  $package, $gateway )
  {

    $codeRoot    = $gateway->getCodeRoot();
    $modSrcPath  = $this->dataPath.'vendor/';

    $gwName        = $gateway->getName();
    $gwTargetPath  = $codeRoot.'/'.$gwName.'/';

    $modules       = $gateway->getVendorModules();

    foreach ($modules as /* @var $module PackageGatewayModule */ $module) {

      $modName = $module->getName();
      $modType = $module->getType();
      $folders = $module->getFolders();

      Fs::touch( $gwTargetPath.'conf/include/available_module/'.$modName );
      Fs::touch( $gwTargetPath.'conf/include/module/'.$modName );

      foreach ($folders as $folder) {

        if ( !Fs::exists( $modSrcPath.$folder ) ) {
          $this->console->error
          (
            <<<ERROR
Im Gateway wurde das Modul {$folder} für das setup definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen, dass ein Teil der erwarteten Funktionalität fehlen wird.
ERROR
          );
          continue;
        }

        $this->protocol->info( "Copy Vendor Module $modSrcPath.$folder => $codeRoot.'/'.$modName " );
        Fs::copyContent
        (
          $modSrcPath.$folder,
          $codeRoot.'/'.$modName
        );

      }//end foreach

      $permission = $module->getPermission( $codeRoot );

      if( $permission )
        Fs::setPermission( $permission, $this->protocol );

    }//end foreach

  }//end protected function copyCodeVendorModules */

////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function setupDatabases( $package, $gateway )
  {

    $gwName = $gateway->getName();

    $this->protocol->subHead( 'Setup der Datenbanken für Gateway '.$gwName );

    $servers = $gateway->getServers();

    foreach ($servers as /* @var $server PackageServer */ $server) {
      $databases = $server->getDatabases();
      foreach ($databases as /* @var $database PackageServerDb  */ $database) {

        $this->protocol->subHead( 'Setup der Datenbanken für Gateway '.$gwName );

        $dbSetup = SetupDb::getSetup( $this->console,  $database->getType(), $this->protocol );
        /* @var $dbSetup SetupDb */
        $dbSetup->setup( $package, $gateway, $servers, $database, $this->dataPath  );

      }
    }

  }//end protected function setupDatabases */

////////////////////////////////////////////////////////////////////////////////
// Users
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function setupSystemUsers( $package, $gateway )
  {

    $gwName = $gateway->getName();

    $this->protocol->subHead( 'Setup der Systemuser für Gateway '.$gwName );

    $servers = $gateway->getServers();
    $users   = $gateway->getUsers();

    foreach ($servers as /* @var $server PackageServer */ $server) {
      $databases = $server->getDatabases();
      foreach ($databases as /* @var $database PackageServerDb  */ $database) {

        $dbConnection = $database->getConnection();

        $userMgmt     = new UserManagement( $dbConnection, $this->protocol );

        foreach ($users as /* @var $server PackageGatewayUser */ $user) {
          $userMgmt->createUser( $user );
        }

      }
    }

  }//end protected function setupSystemUsers */

} // end class WbfSetupApplication

