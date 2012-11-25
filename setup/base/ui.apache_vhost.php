<?php 


// den deploypath festlegen
$apacheVhost_Done = false;
while( !$apacheVhost_Done )
{
  
  if( !$conf->deployRoot = $console->question
  (
    'Soll ein Apache Vhost erstellt werden?'
  ))
  {
    $apacheVhost_Done = true;
    break;
  }
  
  if( !isset($conf->apacheVhost)  )
  {
    $conf->apacheVhost = new stdClass();
  }
  
  /*
  if( !isset($conf->apacheVhost)  )
  {
    $conf->deployRoot = $console->readText
    (
      'Bitte geben sie den Pfand an in welchen die Applikation deployt werden soll',
      'Pfad setzen'
    );
  }
  else 
  {
    $conf->deployRoot = $console->readText
    (
      'In welchen Pfad möchten sie installieren?',
      'Pfad prüfen',
      $conf->deployRoot
    );
  }
  
  /*
  if( !Fs::isDir( $conf->deployRoot ) )
  {
    if( $console->question( 'Der angegebene Pfad existiert nicht. Soll er erstellt werden?' ) )
    {
      Fs::mkdir($conf->deployRoot);
    }
    else
    {
      $console->error( 'Die Installation wurde manuell angebrochen.' );
      exit(0);
    }
  }
  
  if( Fs::isDir( $conf->deployRoot.'/WebFrap' ) )
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
    
    if( 1 === $action || 2 === $action )
    {
      $deplRootClear = true;
    }
    else if( 4 === $action )
    {
      $console->error( 'Die Installation wurde manuell angebrochen.' );
      exit(0);
    }
    
  }
  else 
  {
    $deplRootClear = true;
  }
  */
  
}//end while

