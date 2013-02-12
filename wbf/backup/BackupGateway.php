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
 * 
 * @package WebFrap
 * @subpackage Gaia
 */
class BackupGateway
{
  
  /**
   * @param Package $package
   */
  public function backupByPackage( $package )
  {
    
    $gateways = $package->getGateways();

    foreach( $gateways as /* @var $gateway PackageGateway */ $gateway )
    {

      $codeRoot  = $gateway->getCodeRoot();
      $gwName    = $gateway->getName();
      $gwSrc     = $gateway->getSrc();
      
      $gwTargetPath = $codeRoot.'/'.$gwName;

      $backupNode = $gateway->getBackupNode();
      
      if( !$backupNode )
      {
        continue;
      }
  
      if( !Fs::exists( $codeRoot ) )
      {
        $error = 'Das Zielverzeichniss '.$codeRoot.' existiert nicht.'
          .' Bitte überprüfe den Pfad und ob überhaupt ein Installation vorhanden ist.';
          
        throw new GaiaException( $error );
      }
      
      if( !Fs::exists( $gwTargetPath ) )
      {
        $error = 'Das Target Gateway: '.$gwTargetPath.' existiert nicht.';
        throw new GaiaException( $error );
      }

      $this->backup( $package, $gateway, $backupNode );
      
    }

  }//end public function backupByPackage */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageGatewayBackup $backup
   */
  public function backup( $package, $gateway, $backup )
  {
    
    $type   = $backup->getType( );
    
    if( !$type )
      $type = 'user_data';
    
    $action = 'backup_'.FormatString::subToCamelCase( $type );
    
    if( !method_exists( $this, $action ) )
      throw new GaiaException( "Got invalid backup type ".$type );
    
    $this->$action( $package, $gateway, $backup );
    
  }//end public function backup */

  /**
   * Full sichert alle Daten, die Datenbank und die Applikation
   * 
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageGatewayBackup $backup
   */
  protected function backup_Full( $package, $gateway, $backup )
  {
    
    $codeRoot    = $gateway->getCodeRoot();
    $gwName      = $gateway->getName();
    $backupDir   = $backup->getDir();

    $archive = new ArchiveZip( $backupDir.'/'.$gwName.'-'.date('YmdHis').'.zip' );
    
    if( Fs::exists( $codeRoot.$gwName.'/data/' ) )
    {
      $dataFiles = new IoFileIterator( $codeRoot.$gwName.'/data/', '/'.$gwName.'/data/' ); 
      
      foreach( $dataFiles as $target => $src )
      {
        $archive->addFile( $src, $target );
      }
    }
    
    if( Fs::exists( $codeRoot.$gwName.'/files/' ) )
    {
      $dataFiles = new IoFileIterator( $codeRoot.$gwName.'/files/', '/'.$gwName.'/files/' ); 
      
      foreach( $dataFiles as $target => $src )
      {
        $archive->addFile( $src, $target );
      }
    }
    
    $this->backupDatabase( $package, $gateway, $archive );
    
    $archive->close();
    
  }//end protected function backup_Full */
  
  /**
   * Files sichert die vom User generierten Daten und Uploads aber keine Datenbank
   * 
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageGatewayBackup $backup
   */
  protected function backup_Files( $package, $gateway, $backup )
  {
    $codeRoot    = $gateway->getCodeRoot();
    $gwName      = $gateway->getName();
    
    $backupDir   = $backup->getDir();

    $archive = new ArchiveZip( $backupDir.'/'.$gwName.'-'.date('YmdHis').'.zip' );
    
    if( Fs::exists( $codeRoot.$gwName.'/data/' ) )
    {
      $dataFiles = new IoFileIterator( $codeRoot.$gwName.'/data/', '/'.$gwName.'/data/' ); 
      
      foreach( $dataFiles as $target => $src )
      {
        $archive->addFile( $src, $target );
      }
    }
    
    if( Fs::exists( $codeRoot.$gwName.'/files/' ) )
    {
      $dataFiles = new IoFileIterator( $codeRoot.$gwName.'/files/', '/'.$gwName.'/files/' ); 
      
      foreach( $dataFiles as $target => $src )
      {
        $archive->addFile( $src, $target );
      }
    }

    $archive->close();
    
  }//end protected function backup_Files */
  
  /**
   * Userdata sichert alle vom User generierten Daten, Uploads und die Datenbank
   * 
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageGatewayBackup $backup
   */
  protected function backup_UserData( $package, $gateway, $backup )
  {
    $codeRoot    = $gateway->getCodeRoot();
    $gwName      = $gateway->getName();
    
    $backupDir   = $backup->getDir();

    $archive = new ArchiveZip( $backupDir.'/'.$gwName.'-'.date('YmdHis').'.zip' );
    
    if( Fs::exists( $codeRoot.$gwName.'/data/' ) )
    {
      $dataFiles = new IoFileIterator( $codeRoot.$gwName.'/data/', '/'.$gwName.'/data/' ); 
      
      foreach( $dataFiles as $target => $src )
      {
        $archive->addFile( $src, $target );
      }
    }
    
    if( Fs::exists( $codeRoot.$gwName.'/files/' ) )
    {
      $dataFiles = new IoFileIterator( $codeRoot.$gwName.'/files/', '/'.$gwName.'/files/' ); 
      
      foreach( $dataFiles as $target => $src )
      {
        $archive->addFile( $src, $target );
      }
    }
    
    $this->backupDatabase( $package, $gateway, $archive );
    
    $archive->close();
    
  }//end protected function backup_UserData */
  
  
  /**
   * Userdata sichert alle vom User generierten Daten, Uploads und die Datenbank
   * 
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageGatewayBackup $backup
   */
  protected function backup_Database( $package, $gateway, $backup )
  {
    $codeRoot    = $gateway->getCodeRoot();
    $gwName      = $gateway->getName();
    
    $backupDir   = $backup->getDir();

    $archive = new ArchiveZip( $backupDir.'/'.$gwName.'-'.date('YmdHis').'.zip' );
    
    $this->backupDatabase( $package, $gateway, $archive );
    
    $archive->close();
    
  }//end protected function backup_Database */
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param ArchiveZip $archive
   */ 
  protected function backupDatabase( $package, $gateway, $archive )
  {
    
    $servers = $gateway->getServers();
    
    $gwName      = $gateway->getName();
    
    foreach( $servers as /* @var $server PackageServer */ $server )
    {
      $databases = $server->getDatabases();
      
      foreach( $databases as /* @var $database PackageServerDb  */ $database )
      {
        
        $dbAdmin = Db::getAdmin
        (
          $database->getType(),
          $database->getHost(),
          $database->getPort(),
          $database->getDbName(),
          $database->getDbSchema(),
          $database->getAdminUser(),
          $database->getAdminPwd()
        );
          
        $tmpFoder = Gaia::mkTmpFolder();
        $tmpFile  = $tmpFoder.$database->getType().'-'.$database->getDbName().'-'.$database->getDbSchema().'.backup';

        /* @var $dbAdmin DbAdmin */
        $dbAdmin->dumpSchema( $database->getDbName(), $database->getDbSchema(), $tmpFile );
        
        $archive->addFile
        ( 
          $tmpFile, 
          '/dbms/'.$gwName.'/'.$database->getType().'/'.$database->getDbName().'-'.$database->getDbSchema().'.backup' 
        );
        
      }
      
    }
    
  }//end protected function backupDatabase */

}//end class BackupGateway */
