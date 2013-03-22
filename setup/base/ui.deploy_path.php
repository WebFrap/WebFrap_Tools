<?php 

// den deploypath festlegen
$deplRootClear = false;
while( !$deplRootClear )
{
  
  if ( !isset($conf->appRoot) || ''=== trim($conf->appRoot) )
  {
    $conf->appRoot = '/var/www/'.$conf->appDomain;
  }
  
  $conf->appRoot = $console->readText
  (
    'In welchen Pfad soll das System installiert werden?',
    'Pfad setzen',
    $conf->appRoot
  );
  
  if ( !Fs::isDir( $conf->appRoot ) )
  {
    
    if ( $console->question( 'Der angegebene Pfad existiert nicht. Soll er erstellt werden?' ) )
    {
      Fs::mkdir($conf->appRoot);
    }
    else
    {
      if ( $console->question( 'Pfad wechseln? (Nein bricht die Installation komplett ab.)' ) )
      {
        continue;
      }
      else 
      {
        $console->error( 'Die Installation wurde manuell angebrochen.' );
        exit(0);
      }
    }
  }
  
  if ( Fs::isDir( $conf->appRoot.'/WebFrap' ) )
  {
    $action = (int)$console->radioList
    ( 
      "Im Angegebenen Pfad scheint bereits eine Installation zu existieren.", 
      array
      (
        array
        (
          'Select' => '1',
          'Option' => '1',
          'Desc' => 'Installation aktualisieren'
        ),
        array
        (
          'Select' => '2',
          'Option' => '2',
          'Desc' => 'Installation überschreiben'
        ),
        array
        (
          'Select' => '3',
          'Option' => '3',
          'Desc' => 'Neuen Pfad angeben'
        ),
        array
        (
          'Select' => '4',
          'Option' => '4',
          'Desc' => 'Abbrechen'
        )
      ),
      array(),
      new UiDimension( 550 )
    );
    
    $console->out( $action );
    
    if ( 1 === $action || 2 === $action )
    {
      $deplRootClear = true;
    }
    else if ( 4 === $action )
    {
      $console->error( 'Die Installation wurde manuell angebrochen.' );
      exit(0);
    }
    
  }
  else 
  {
    $deplRootClear = true;
  }
  
}//end while