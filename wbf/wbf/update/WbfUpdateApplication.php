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
class WbfUpdateApplication
  extends WbfUpdate
{

  /**
   * @param Package $package
   */
  public function update( $package )
  {
    
    $this->protocol = Protocol::openProtocol
    (
      null,
      'Application Deployment: '.$package->getName().' '.date('Y-m-d H:i:s'),
      'update'
    );
    
    if( $package->hasCustom )
    {
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
    
    foreach( $gateways as $gateway )
    {
      
      $this->backupGateway( $package, $gateway ); 
      
      $this->updateGateway( $package, $gateway );   

      $this->updateIconThemes( $package, $gateway );
      $this->updateUiThemes( $package, $gateway );
      $this->updateWgt( $package, $gateway );
      
      $this->updateCodeModules(  $package, $gateway );
      $this->updateVendorCodeModules(  $package, $gateway );
      
      $this->updatePermissions( $package, $gateway );
        
      $this->updateDatabases( $package, $gateway );
      $this->updateSystemUsers( $package, $gateway );
    }
    
    Protocol::closeProtocol();
    
  }//end public function setup */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function backupGateway( $package, $gateway )
  {
    
    $codeRoot  = $gateway->getCodeRoot();
    $gwName    = $gateway->getName();
    $gwSrc     = $gateway->getSrc();
    
    $gwSrcPath    = $this->dataPath.'gateway/'.$gwSrc;
    $gwTargetPath = $codeRoot.'/'.$gwName;
    
    $this->protocol->subHead( 'Erstelle Backup für Gateway '.$gwName.' in '.$codeRoot );
    
    $backupNode = $gateway->getBackupNode();
    
    if( !$backupNode )
    {
      $this->protocol->info( "Es werden keine Backups angelegt" );
      return;
    }

    if( !Fs::exists( $codeRoot ) )
    {
      $error = 'Das Zielverzeichniss '.$codeRoot.' existiert nicht.'
        .' Bitte überprüfe den Pfad und ob überhaupt ein Installation vorhanden ist.';
        
      $this->protocol->error( $error );
      throw new GaiaException( $error );
    }
    
    if( !Fs::exists( $gwTargetPath ) )
    {
      $error = 'Das Target Gateway: '.$gwSrcPath.' existiert nicht.';
      $this->protocol->error( $error );
      throw new GaiaException( $error );
    }
    
    $backupEngine = new BackupGateway();
    $backupEngine->backup( $package, $gateway, $backupNode );


  }//end protected function backupGateway */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function updatePermissions( $package, $gateway )
  {
    
    $request = $this->getRequest();
    
    $codeRoot  = $gateway->getCodeRoot();
    
    $gwName    = $gateway->getName();
    $gwSrc     = $gateway->getSrc();
    
    $this->protocol->subHead( 'Update Permissions Gw: '.$gwName );
    
    $codePermission = $gateway->getCodePermission();
    if( $codePermission )
    {
      Fs::setPermission( $codePermission, $this->protocol );
    }
    
    $permissions = $gateway->getCustomPermissions();
    
    foreach( $permissions as /* @var StructPermission $permission */ $permission )
    {
      Fs::setPermission( $permission, $this->protocol );
    }
    
    // fix the permissions
    $gwPermission      = $gateway->getGwPermission();
    $gwEditPermissions = $gateway->getGwEditPermissions();
    
    if( $gwPermission )
    {
      Fs::setPermission( $gwPermission, $this->protocol );
    }
    
    foreach( $gwEditPermissions as $perm )
    {
      try 
      {
        Fs::setPermission( $perm, $this->protocol );
      }
      catch( GaiaException  $exc )
      {
        $this->protocol->warning( $exc->getMessage() );
      }
    }

  }//end protected function updatePermissions */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function updateGateway( $package, $gateway )
  {
    
    $codeRoot  = $gateway->getCodeRoot();
    $gwName    = $gateway->getName();
    $gwSrc     = $gateway->getSrc();
    
    $gwSrcPath    = $this->dataPath.'gateway/'.$gwSrc;
    $gwTargetPath = $codeRoot.'/'.$gwName;
    
    $this->protocol->subHead( 'Update Gateway '.$gwName.' in '.$codeRoot );
    
    if( !Fs::exists( $codeRoot ) )
    {
      $error = 'Das Zielverzeichniss '.$codeRoot.' existiert nicht.'
        .' Bitte überprüfe den Pfad und ob überhaupt ein Installation vorhanden ist.';
        
      $this->protocol->error( $error );
      throw new GaiaException( $error );
    }
    
    if( !Fs::exists( $gwTargetPath ) )
    {
      $error = 'Das Target Gateway: '.$gwSrcPath.' existiert nicht.';
      $this->protocol->error( $error );
      throw new GaiaException( $error );
    }

    
    if( !Fs::copyContent( $gwSrcPath, $gwTargetPath ) )
    {
      $error = 'Kopieren der Gatewaydaten ist fehlgeschlagen';
      $this->protocol->error( $error );
      throw new GaiaException( $error );
    }
    
    $this->protocol->info( "Kopiere die Gateway Daten: {$gwSrcPath} => {$gwTargetPath}" );
    
    // im Gateway aufräumen
    $this->cleanGateway( $package, $gateway );
    $this->updateGatewayConf( $package, $gateway );
    


  }//end protected function updateGateway */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function cleanGateway( $package, $gateway  )
  {
    
    $codeRoot  = $gateway->getCodeRoot();
    
    $gwName    = $gateway->getName();
    $gwSrc     = $gateway->getSrc();
    
    $gwSrcPath    = $this->dataPath.'gateway/'.$gwSrc;
    $gwTargetPath = $codeRoot.'/'.$gwName;
    
    $flagCleanTmp = false;
    $flagCacheTmp = false;
    
    // löschen der Temporären Daten
    if( $gateway->updateFlagMode( 'clean/tmp', 'full' ) )
    {
      // sollten versehentlich die sessiondaten mitkopiert worden sein
      // sicherstellen dass keine alten sessiondaten kopiert wurden
      if( Fs::exists( $gwTargetPath.'/tmp' ) )
      {
        $this->protocol->info( 'Lösche die kompletten Tempdaten in '.$gwTargetPath.'/tmp' );
        Fs::del( $gwTargetPath.'/tmp' );
        $flagCleanTmp = true;
      }
      
      // session muss wieder erstellt werden
      Fs::mkdir( $gwTargetPath.'/tmp/session' );
    }
    else 
    {
      
      if( $gateway->updateFlag( 'clean/tmp/session' ) )
      {
        // sollten versehentlich die sessiondaten mitkopiert worden sein
        // sicherstellen dass keine alten sessiondaten kopiert wurden
        if( Fs::exists( $gwTargetPath.'/tmp/session' ) )
        {
          $this->protocol->info( 'Lösche die kompletten Sessiondaten in '.$gwTargetPath.'/tmp/session' );
          Fs::del( $gwTargetPath.'/tmp/session' );
        }
        
        // session muss wieder erstellt werden
        Fs::mkdir( $gwTargetPath.'/tmp/session' );
        $flagCleanTmp = true;
      }
      
    }
    
    if( !$flagCleanTmp )
      $this->protocol->info( 'Temporäre Daten bleiben unberührt' );

    // löschen des Caches
    if( $gateway->updateFlagMode( 'clean/cache', 'full' ) )
    {
      // sollten versehentlich die sessiondaten mitkopiert worden sein
      // sicherstellen dass keine alten sessiondaten kopiert wurden
      if( Fs::exists( $gwTargetPath.'/cache' ) )
      {
        $this->protocol->info( 'Lösche die kompletten Caches in '.$gwTargetPath.'/cache' );
        Fs::del( $gwTargetPath.'/cache' );
      }
      
      // session muss wieder erstellt werden
      Fs::mkdir( $gwTargetPath.'/cache' );
      $flagCacheTmp = true;
    }
    else 
    {
      
      if( $gateway->updateFlag( 'clean/cache/autoload' ) )
      {
        if( Fs::exists( $gwTargetPath.'/cache/autoload' ) )
        {
          $this->protocol->info( 'Lösche Autoload Cache in '.$gwTargetPath.'/cache/autoload' );
          Fs::del( $gwTargetPath.'/cache/autoload' );
          $flagCacheTmp = true;
        }
      }
      
      if( $gateway->updateFlag( 'clean/cache/css' ) )
      {
        if( Fs::exists( $gwTargetPath.'/cache/css' ) )
        {
          $this->protocol->info( 'Lösche Css Cache in '.$gwTargetPath.'/cache/css' );
          Fs::del( $gwTargetPath.'/cache/css' );
          $flagCacheTmp = true;
        }
      }
      
      if( $gateway->updateFlag( 'clean/cache/i18n' ) )
      {
        if( Fs::exists( $gwTargetPath.'/cache/i18n' ) )
        {
          $this->protocol->info( 'Lösche I18n Cache in '.$gwTargetPath.'/cache/i18n' );
          Fs::del( $gwTargetPath.'/cache/i18n' );
          $flagCacheTmp = true;
        }
      }
      
      if( $gateway->updateFlag( 'clean/cache/javascript' ) )
      {
        if( Fs::exists( $gwTargetPath.'/cache/javascript' ) )
        {
          $this->protocol->info( 'Lösche Javascript Cache in '.$gwTargetPath.'/cache/javascript' );
          Fs::del( $gwTargetPath.'/cache/javascript' );
          $flagCacheTmp = true;
        }
      }
      
      if( $gateway->updateFlag( 'clean/cache/theme' ) )
      {
        if( Fs::exists( $gwTargetPath.'/cache/theme' ) )
        {
          $this->protocol->info( 'Lösche Theme Cache in '.$gwTargetPath.'/cache/theme' );
          Fs::del( $gwTargetPath.'/cache/theme' );
          $flagCacheTmp = true;
        }
      }
      
    }
    
    if( !$flagCacheTmp )
      $this->protocol->info( 'Temporäre Daten bleiben unberührt' );

  }//end protected function cleanGateway */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function updateGatewayConf( $package, $gateway  )
  {

    $codeRoot  = $gateway->getCodeRoot();
    
    $gwName    = $gateway->getName();
    $gwSrc     = $gateway->getSrc();
    
    $gwSrcPath    = $this->dataPath.'gateway/'.$gwSrc;
    $gwTargetPath = $codeRoot.'/'.$gwName;
    
    // clean/conf/includes
    if( $gateway->updateFlag( 'clean/conf/includes' ) )
    {
      
      $this->protocol->info( 'Leere conf/include auf grund der Konfiguration des Gateways '.$gwTargetPath );
      
      // bearbeiten der gmod includes
      if( Fs::exists( $gwTargetPath.'/conf/include/available_gmod' ) )
      {
        $this->protocol->info( 'Leere /conf/include/available_gmod in '.$gwTargetPath );
        Fs::del( $gwTargetPath.'/conf/include/available_gmod' );
      }
      Fs::mkdir( $gwTargetPath.'/conf/include/available_gmod' );
      
      if( Fs::exists( $gwTargetPath.'/conf/include/gmod' ) )
      {
        $this->protocol->info( 'Leere /conf/include/gmod in '.$gwTargetPath );
        Fs::del( $gwTargetPath.'/conf/include/gmod' );
      }
      Fs::mkdir( $gwTargetPath.'/conf/include/gmod' );
      
      // bearbeiten der module includes
      if( Fs::exists( $gwTargetPath.'/conf/include/available_module' ) )
      {
        $this->protocol->info( 'Leere /conf/include/available_module in '.$gwTargetPath );
        Fs::del( $gwTargetPath.'/conf/include/available_module' );
      }
      Fs::mkdir( $gwTargetPath.'/conf/include/available_module' );
      
      if( Fs::exists( $gwTargetPath.'/conf/include/module' ) )
      {
        $this->protocol->info( 'Leere /conf/include/module in '.$gwTargetPath );
        Fs::del( $gwTargetPath.'/conf/include/module' );
      }
      Fs::mkdir( $gwTargetPath.'/conf/include/module' );
      
      // bearbeiten der metadata includes
      if( Fs::exists( $gwTargetPath.'/conf/include/metadata' ) )
      {
        $this->protocol->info( 'Leere /conf/include/metadata in '.$gwTargetPath );
        Fs::del( $gwTargetPath.'/conf/include/metadata' );
      }
      Fs::mkdir( $gwTargetPath.'/conf/include/metadata' );
    }
  
    // overwrite/config
    if( $gateway->updateFlag( 'overwrite/config' ) )
    {
      
      // kopieren der conf
      // conf kann aus dem request genommen werden
      // wenn nicht im request wird in der package.bdl gesucht
      $confKey = $gateway->getConfKey();
      
      if( $confKey )
      {
        $this->protocol->info( "Use configuration {$confKey}" );
        
        if( Fs::exists( $gwTargetPath.'/conf/space/'.$confKey ) )
        {
          Fs::copyContent( $gwTargetPath.'/conf/space/'.$confKey, $gwTargetPath.'/conf/' );
        }
        else 
        {
        
        $fatal = <<<FATAL
Die angefragte Konfiguration: {$confKey} existiert nicht im Gateway: {$gwTargetPath}/conf/space/
FATAL;
        
          $this->protocol->fatal( $fatal ); 
          throw new GaiaException( $fatal );
        }
          
      }
      else
      {
        $warning = <<<FATAL
Im Packet wurde definiert, dass die Konfiguration überschrieben werden soll. Es wurde
jedoch kein Confkey für Gateway {$gwTargetPath} definiert;
FATAL;
        
        $this->protocol->warning( $warning ); 
      }
      
    }
    
  }//end protected function updateGatewayConf */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Updaten der Icon Themes
   */
  protected function updateIconThemes( $package, $gateway )
  {
    
    // laden der nötigen informationen
    $codeRoot      = $gateway->getCodeRoot();
    $iconThemeName = $gateway->getIconThemeName();
    
    if( !$iconThemeName )
    {
      $this->protocol->info( "Das Paket enthält keine Icon Themes, es wird nur das Standard WGT Theme vorhanden sein." );
      return;
    }
    
    $folders       = $gateway->getIconThemeFolders();
    
    $targetPath = $codeRoot.'/'.$iconThemeName;
    
    $this->protocol->subHead( 'Update IconThemes '.$iconThemeName.' to '.$targetPath );
    
    if( Fs::exists($targetPath) )
    {
     
      if( 0 == count($folders) )
      {
        
        if( $gateway->updateFlag( 'clean/icon_theme' ) )
        {
          $warning = <<<WARNING
Das definierte Icontheme {$iconThemeName} enthält im Paket keine Theme-Informationen. 
Die Konfiguration des Packetes verlangt jedoch, das IconTheme on Update zu cleanen.
Ok möglicherweise hast du dir dabei etwas gedacht, daher machen wir das jetzt auch, aber
solltest du dich wundern, dass keine Icons vorhanden sind, dann war wohl genau diese 
Einstellung dein Problem.
WARNING;
        
          $this->protocol->warning( $warning );
          $this->console->warning( $warning );
          
          Fs::del( $targetPath );
          
        }
        else 
        {
          
          $info = <<<INFO
Das definierte Icontheme {$iconThemeName} enthält im Paket keine Theme-Informationen. Auf 
dem Zielsystem sind jedoch bereits Themeinformationen vorhanden. Das Deploymentsystem geht davon aus,
dass die vorhanden Informationen auch für hier neu deployte Gateway verwendet werden können.
INFO;
        
        $this->protocol->info( $info );
        $this->console->info( $info );
        
        }
      }
      else 
      {
        
        if( $gateway->updateFlag( 'clean/icon_theme' ) )
        {
          $info = <<<INFO
Das vorhandene IconTheme unter "{$targetPath}" wird durch das neue komplett ersetzt.
INFO;
        
          $this->protocol->info( $info );
          Fs::del( $targetPath );
          
        }
        else 
        {
          
          $info = <<<INFO
Das vorhandene IconTheme unter "{$targetPath}" wird upgedated.
INFO;
        
          $this->protocol->info( $info );
        
        }

      }
    }
    
    
    // alle ordner kopieren
    if( $folders )
    {
      foreach( $folders as $folder )
      {
        
        $iconSrcPath = realpath($this->dataPath.'/icon_theme/'.$folder);
        
        if( !Fs::exists( $iconSrcPath ) )
        {
          
          $error = <<<ERROR
Im Gateway wurde das IconTheme {$folder} für das update definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen dass keine Icons vorhanden sein werden.
ERROR;
          
          $this->protocol->error( $error );
          $this->console->error( $error );
          continue;
        }
        
        if( !Fs::copyContent( $iconSrcPath, $targetPath ) )
        {
          $fatal = "Kopieren des IconThemes \"{$iconSrcPath} => {$targetPath}\" ist fehlgeschlagen.";
          $this->protocol->fatal( $fatal );
          throw new GaiaException( $fatal );
        }
      }
    }

  }//end protected function updateIconThemes */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Updaten der Icon Themes
   */
  protected function updateUiThemes( $package, $gateway )
  {
    
    // laden der nötigen informationen
    $codeRoot      = $gateway->getCodeRoot();
    $targetName = $gateway->getUiThemeName();
    
    if( !$targetName )
    {
      $this->protocol->info( "Das Paket enthält keine UI Themes, es wird nur das Standard WGT Theme vorhanden sein." );
      return;
    }
    
    $folders       = $gateway->getUiThemeFolders();
    
    $targetPath = $codeRoot.'/'.$targetName;
    
    $this->protocol->subHead( 'Update UiThemes '.$targetName.' to '.$targetPath );
    
    if( Fs::exists($targetPath) )
    {
     
      if( 0 == count($folders) )
      {
        
        if( $gateway->updateFlag( 'clean/ui_theme' ) )
        {
          $warning = <<<WARNING
Das definierte UITheme {$targetName} enthält im Paket keine Theme-Informationen. 
Die Konfiguration des Packetes verlangt jedoch, das UITheme on Update zu cleanen.
Ok möglicherweise hast du dir dabei etwas gedacht, daher machen wir das jetzt auch, aber
solltest du dich wundern, dass keine Farbinformationen und Hintergrundbilder vorhanden sind, dann war wohl genau diese 
Einstellung dein Problem.
WARNING;
        
          $this->protocol->warning( $warning );
          $this->console->warning( $warning );
          
          Fs::del( $targetPath );
          
        }
        else 
        {
          
          $info = <<<INFO
Das definierte Icontheme {$targetName} enthält im Paket keine Theme-Informationen. Auf 
dem Zielsystem sind jedoch bereits Themeinformationen vorhanden. Das Deploymentsystem geht davon aus,
dass die vorhanden Informationen auch für hier neu deployte Gateway verwendet werden können.
INFO;
        
        $this->protocol->info( $info );
        $this->console->info( $info );
        
        }
      }
      else 
      {
        
        if( $gateway->updateFlag( 'clean/ui_theme' ) )
        {
          $info = <<<INFO
Das vorhandene UITheme unter "{$targetPath}" wird durch das neue koplett ersetzt.
INFO;
        
          $this->protocol->info( $info );
          Fs::del( $targetPath );
          
        }
        else 
        {
          
          $info = <<<INFO
Das vorhandene UITheme unter "{$targetPath}" wird upgedated.
INFO;
        
          $this->protocol->info( $info );
        
        }

      }
    }
    
    
    // alle ordner kopieren
    if( $folders )
    {
      foreach( $folders as $folder )
      {
        
        $srcPath = realpath($this->dataPath.'/ui_theme/'.$folder);
        
        if( !Fs::exists( $srcPath ) )
        {
          
          $error = <<<ERROR
Im Gateway wurde das UITheme {$folder} für das update definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen dass keine Theme Informationen / Hintergrundbilder vorhanden sein werden.
ERROR;
          
          $this->protocol->error( $error );
          $this->console->error( $error );
          continue;
        }
        
        if( !Fs::copyContent( $srcPath, $targetPath ) )
        {
          $fatal = "Kopieren des UITheme \"{$srcPath} => {$targetPath}\" ist fehlgeschlagen.";
          $this->protocol->fatal( $fatal );
          throw new GaiaException( $fatal );
        }
        
      }
    }

  }//end protected function updateUiThemes */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Updaten der Icon Themes
   */
  protected function updateWgt( $package, $gateway )
  {
    
    // laden der nötigen informationen
    $codeRoot    = $gateway->getCodeRoot();
    $targetName  = $gateway->getWgtName();
    
    if( !$targetName )
    {
      $this->protocol->warning( "Das Paket enthält kein WGT Projekt. Entweder es ist bereits eine WGT Version vorhanden
      oder das System kann nur im Service Mode betrieben werden." );
      return;
    }
    
    $folders     = $gateway->getWgtFolders();
    
    $targetPath = $codeRoot.'/'.$targetName;
    
    $this->protocol->subHead( 'Update WGT '.$targetName.' to '.$targetPath );
    
    if( Fs::exists($targetPath) )
    {
     
      if( 0 == count($folders) )
      {
        
        if( $gateway->updateFlag( 'clean/wgt' ) )
        {
          $warning = <<<WARNING
Das definierte WGT Projekt {$targetName} enthält keinen Code. 
Die Konfiguration des Packetes verlangt jedoch, das WGT Projekt on update zu cleanen.
Ok möglicherweise hast du dir dabei etwas gedacht, daher machen wir das jetzt auch, aber
solltest du dich wundern, dass die Seite nicht gerendert wird, dann war wohl genau diese 
Einstellung dein Problem.
WARNING;
        
          $this->protocol->warning( $warning );
          $this->console->warning( $warning );
          
          Fs::del( $targetPath );
          
        }
        else 
        {
          
          $info = <<<INFO
Das definierte WGT Projekt {$targetName} enthält im Paket keinen Code. Auf 
dem Zielsystem ist jedoch Code vorhanden. Das Deploymentsystem geht davon aus,
dass die vorhanden Informationen auch für hier neu deployte Gateway verwendet werden können.
INFO;
        
        $this->protocol->info( $info );
        $this->console->info( $info );
        
        }
      }
      else 
      {
        
        if( $gateway->updateFlag( 'clean/wgt' ) )
        {
          $info = <<<INFO
Das vorhandene WGT Projekt unter "{$targetPath}" wird durch das neue koplett ersetzt.
INFO;
        
          $this->protocol->info( $info );
          Fs::del( $targetPath );
          
        }
        else 
        {
          
          $info = <<<INFO
Das vorhandene WGT Projekt unter "{$targetPath}" wird upgedated.
INFO;
        
          $this->protocol->info( $info );
        
        }

      }
    }
    
    
    // alle ordner kopieren
    if( $folders )
    {
      foreach( $folders as $folder )
      {
        
        $srcPath = realpath($this->dataPath.'/wgt/'.$folder);
        
        if( !Fs::exists( $srcPath ) )
        {
          
          $error = <<<ERROR
Im Gateway wurde das WGT Projekt {$folder} für das update definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen, dass wichtige Logik zum Render der Seite im Client fehlt.
ERROR;
          
          $this->protocol->error( $error );
          $this->console->error( $error );
          continue;
        }
        
        if( !Fs::copyContent( $srcPath, $targetPath ) )
        {
          $fatal = "Kopieren des WGT Projektes \"{$srcPath} => {$targetPath}\" ist fehlgeschlagen.";
          $this->protocol->fatal( $fatal );
          throw new GaiaException( $fatal );
        }
        
      }
    }

  }//end protected function updateUiThemes */
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Kopieren der Module
   */
  protected function updateCodeModules(  $package, $gateway )
  {
    
    $codeRoot    = $gateway->getCodeRoot();
    $modSrcPath  = $this->dataPath.'code/';
    
    $gwName        = $gateway->getName();
    $gwTargetPath  = $codeRoot.'/'.$gwName.'/';
    
    $this->protocol->subHead( 'Update des Module Codes nach '.$codeRoot );
    
    $modules = $gateway->getModules();
    
    foreach( $modules as /* @var $module PackageGatewayModule */ $module )
    {
      
      $modName = $module->getName();
      $modType = $module->getType();
      $folders = $module->getFolders();
      
      $this->protocol->info( "Update Module {$modName}" );
      
      if( $module->cleanOnUpdate() )
      {
        $this->protocol->info( "Leeren des Modulecodes vor dem update {$codeRoot}.'/'.{$modName}" );
        
        if( Fs::exists( $codeRoot.'/'.$modName  ) )
        {
          Fs::del( $codeRoot.'/'.$modName );
        }
      }

      // sicher stellen, dass das modul geladen werden kann
      Fs::touch( $gwTargetPath.'conf/include/metadata/'.$modName );

      if( 'genf' == $modType )
      {
        Fs::touch( $gwTargetPath.'conf/include/available_gmod/'.$modName );
        Fs::touch( $gwTargetPath.'conf/include/gmod/'.$modName );
      }
      else 
      {
        Fs::touch( $gwTargetPath.'conf/include/available_module/'.$modName );
        Fs::touch( $gwTargetPath.'conf/include/module/'.$modName );
      }
      
      foreach( $folders as $folder )
      {
        
        if( !Fs::exists( $modSrcPath.$folder ) )
        {
          
          $error = <<<ERROR
Im Gateway wurde das Modul {$folder} für das update definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen, dass ein Teil der erwarteten Funktionalität fehlen wird.
ERROR;
          $this->protocol->error( $error );
          $this->console->error( $error );
          continue;
        }
        
        $this->protocol->info( "Copy Module $modSrcPath.$folder => $codeRoot.'/'.$modName " );
        Fs::copyContent
        ( 
          $modSrcPath.$folder, 
          $codeRoot.'/'.$modName 
        );
        
      }
      
      // set permissions
      $permission = $module->getPermission( $codeRoot );
      
      if( $permission )
        Fs::setPermission( $permission, $this->protocol );
      
    }

  }//end protected function updateCodeModules */
  
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * Kopieren der Module
   */
  protected function updateVendorCodeModules(  $package, $gateway )
  {
    
    $codeRoot    = $gateway->getCodeRoot();
    $modSrcPath  = $this->dataPath.'vendor/';
    
    $gwName        = $gateway->getName();
    $gwTargetPath  = $codeRoot.'/'.$gwName.'/';
    
    $this->protocol->subHead( 'Update des Vendor Module Codes nach '.$codeRoot );
    
    $modules = $gateway->getVendorModules();
    
    foreach( $modules as /* @var $module PackageGatewayModule */ $module )
    {
      
      $modName = $module->getName();
      $modType = $module->getType();
      $folders = $module->getFolders();
      
      $this->protocol->info( "Update Vendor Module {$modName}" );
      
      if( $module->cleanOnUpdate() )
      {
        
        $this->protocol->info( "Leeren des Vendor Modulecodes vor dem update {$codeRoot}.'/'.{$modName}" );
        
        if( Fs::exists( $codeRoot.'/'.$modName  ) )
        {
          Fs::del( $codeRoot.'/'.$modName );
        }
      }
      
      // sicher stellen, dass das modul geladen werden kann
      Fs::touch( $gwTargetPath.'conf/include/metadata/'.$modName );

      if( 'genf' == $modType )
      {
        Fs::touch( $gwTargetPath.'conf/include/available_gmod/'.$modName );
        Fs::touch( $gwTargetPath.'conf/include/gmod/'.$modName );
      }
      else 
      {
        Fs::touch( $gwTargetPath.'conf/include/available_module/'.$modName );
        Fs::touch( $gwTargetPath.'conf/include/module/'.$modName );
      }
      
      foreach( $folders as $folder )
      {
        
        if( !Fs::exists( $modSrcPath.$folder ) )
        {
          
          $error = <<<ERROR
Im Gateway wurde das Vendor Modul {$folder} für das update definiert.
Es fehlt jedoch leider im Datenpaket.
Das kann dazu führen, dass ein Teil der erwarteten Funktionalität fehlen wird.
ERROR;
          $this->protocol->error( $error );
          $this->console->error( $error );
          continue;
        }
        
        $this->protocol->info( "Copy Vendor Module $modSrcPath.$folder => $codeRoot.'/'.$modName " );
        Fs::copyContent
        ( 
          $modSrcPath.$folder, 
          $codeRoot.'/'.$modName 
        );
        
      }
      
      // set permissions
      $permission = $module->getPermission( $codeRoot );
      
      if( $permission )
        Fs::setPermission( $permission, $this->protocol );
      
    }

  }//end protected function updateVendorCodeModules */
  
////////////////////////////////////////////////////////////////////////////////
// DBMS Code
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function updateDatabases( $package, $gateway )
  {

    $gwName = $gateway->getName();
    
    $this->protocol->subHead( 'Update der Datenbanken für Gateway '.$gwName );

    $servers = $gateway->getServers();
    
    foreach( $servers as /* @var $server PackageServer */ $server )
    {
      $databases = $server->getDatabases();
      foreach( $databases as /* @var $database PackageServerDb  */ $database )
      {
        
        $this->protocol->subHead
        ( 
          'Update Datenbank: '.$database->getName().' host: '.$database->getHost().' type: '.$database->getType()
        );
        
        $dbSetup = SetupDb::getSetup( $this->console,  $database->getType(), $this->protocol );
        /* @var $dbSetup SetupDb */
        $dbSetup->update( $package, $gateway, $servers, $database, $this->dataPath  );
        
      }
    }
    
  }//end protected function updateDatabases */
  
////////////////////////////////////////////////////////////////////////////////
// Users
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param Package $package
   * @param PackageGateway $gateway
   */
  protected function updateSystemUsers( $package, $gateway )
  {

    $gwName = $gateway->getName();
    
    $this->protocol->subHead( 'Setup der Systemuser für Gateway '.$gwName );

    $servers = $gateway->getServers();
    $users   = $gateway->getUsers();
    
    foreach( $servers as /* @var $server PackageServer */ $server )
    {
      $databases = $server->getDatabases();
      foreach( $databases as /* @var $database PackageServerDb  */ $database )
      {
        
        $dbConnection = $database->getConnection();
        
        $userMgmt     = new UserManagement( $dbConnection, $this->protocol );
        
        foreach( $users as /* @var $server PackageGatewayUser */ $user )
        {
          if( !$userMgmt->userExists( $user ) )
            $userMgmt->createUser( $user );
          else 
            $userMgmt->updateUser( $user );
        }
        
      }
    }

  }//end protected function updateSystemUsers */
  
} // end class WbfUpdateApplication


