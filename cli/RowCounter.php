#!/usr/bin/php -q
<?php
  set_time_limit(0);
  error_reporting(E_ALL | E_STRICT);
  date_default_timezone_set( "Europe/Berlin" );

  $conf = array();
  include 'rowcounter/conf.php';

 /**
  * Class StatsMaker
  * @version alpha 0.1
  * @license
  * Frei zum Privaten Gebrauch, Forschung und Lehre sowie zur
  * Verwendung in der OpenSource und FreeWare Entwicklung
  * Keine Garantien für gar nichts. Sollten nachweislich Schäden durch
  * die Verwendung dieses Scriptes enstanden sein Weise ich hiermit jede
  * Verantwortung von mir.
  *
  * Die Benutzung ist frei, wenn Sie die Benutzungsbedingungen nicht akzeptieren
  * dann verwenden Sie dieses Script nicht!
  *
  * Dieses Script oder Teile davon dürfen nicht ohne Genehmigung des Authors
  * übernommen werden.
  *
  * Sie dürfen diese Script an alle weiter geben die mit den Benutzungbedingungen
  * einverstanden sind. Lediglich das Anbieten zum Dowload Bedarf der Genehmigung
  * des Authors.
  *
  * Die Offizielle BezugsQuelle diese Scriptes ist http://web-modules.de
  *
  * @copyright DominikBonsch <a href="contact@web-modules.de">Dominik Bonsch</a>
  *
  */
class StatsMaker
{

////////////////////////////////////////////////////////////////////////////////
//
// Attribute
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * vorhandene Argumente
  */
  private $_arguments = array();

 /**
  * Unterstütze Kommandos
  */
  private $_actions = array( "help"   => "help", // Ausgabe der Hilfe
                             "count"  => "count"
                           );

 /**
  * Das Aktuelle Commando
  */
  private $_command = null;

 /**
  * Soll das Programm geschwätzig sein?
  */
  private $_verbose = false;

 /**
  * Der Counter zum Zählen von Lines
  */
  private $_rowCounter = 0;

 /**
  * Der Counter zum Zählen von Lines
  */
  private $_fileCounter = 0;

 /**
  * Speicher für die Datei Namen
  */
  private $_fileNames = array();

 /**
  * Speicher für die Datei Länge
  */
  private $_fileLenght = array();

 /**
  * Speicher für die Datei Größe
  */
  private $_fileSize = array();

 /**
  * Welche Dateiendungen Sollen durchsucht werden
  */
  private $_countIn = array(  "php" => true,
                              "html" => true,
                              "xml" => true,
                              "css" => true,
                              "js" => true,
                              "tpl" => true
                           );

 /**
  * Flag Ob Dateigröße mit ausgegeben werden soll
  */
  private $_withSize = false;

  protected $validEndings = array();

////////////////////////////////////////////////////////////////////////////////
//
// Konstruktoren
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * Der Standart Konstruktor
  */
  public function __construct( $conf )
  {

    if ($_SERVER["argc"] <= 1) {
      // Keine Parameter also Hilfe ausgeben
      $this->printHelp( );
      exit(0);
    }

    if( isset($conf['validEndings']) )
      $this->validEndings =  $conf['validEndings'];

    for ($nam = 1 ; $nam < $_SERVER["argc"] ; ++$nam) {

      if ( !$this->_isFlag( $_SERVER["argv"][$nam] )  ) {
        if ( !$this->_isCommand( $_SERVER["argv"][$nam] ) ) {
          $Key = $nam;
          ++$nam;

          if ( !isset( $_SERVER["argv"][$nam] ) ) {
            echo "Falsche Parameter:\n\n";
            $this->printHelp( );
            exit(1);
          }

          $this->_arguments[$_SERVER["argv"][$Key]] = $_SERVER["argv"][$nam];
        }
      }
    }

    if ( isset( $this->_arguments["-v"] ) ) {
      $this->_verbose = true;
      echo "Bin geschwätzig...\n";
    }

  } // end of member function __construct

////////////////////////////////////////////////////////////////////////////////
//
// Getter und Setter
//
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
//
// Main Function
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function main()
  {

    switch ( $this->_checkAktion() ) {

      case 'help':{
        $this->printHelp();
        break;
      }

      case 'count':{
        if($this->_verbose)
          echo "Alle Dateien durchzählen\n";

        $this->runCounter( );
        break;
      }

      default:{
        $this->printHelp();
      }

    }// ende Switch

  }

////////////////////////////////////////////////////////////////////////////////
//
// Commands
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function printHelp( )
  {
    echo "Projekt Statsmaker\n";
    echo "Author: Dominik Bonsch\n\n";
    echo "Kommandos:\n";
    echo "count               Rekursives durchzählen aller relevanten Dateien\n";
    echo "help                Ausgabe dieser Hilfe\n";
    echo "\n";
    echo "Parameter:\n";
    echo "path /pfad/file     Das zu durchscannende Projekt\n";
    echo "\n";
    echo "Flags:\n";
    echo "-h                  Ausgabe dieser Hilfe\n";
    echo "-v                  Sei geschwätzig\n";
    echo "-noEmptys           keine leeren Reihen Mitzählen\n";
    echo "-noComments         keine Commentare mitzählen\n";
    echo "-withSize           Größe der Datei auslesen\n";
    echo "-listFiles          Dateien am Ende einzeln aufzählen\n";
 }

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function runCounter( )
  {
    if($this->_verbose)
      echo "Suche die Dateien...\n";

    if ( !isset( $this->_arguments['path'] ) ) {
      $this->printHelp();

      return false;
    }

    $Path = $this->_arguments['path'];

    if ( isset( $this->_arguments['-withSize'] ) ) {
      $this->_withSize = true;
    }

    if ( is_dir($Path) ) {

      if ( isset( $this->_arguments['-noComments'] ) ) {
        $this->_runInSubdirsNoComments( $Path );
      } elseif ( isset( $this->_arguments['-noEmptys'] )  ) {
        $this->_runInSubdirsNoEmptys( $Path );
      } else {
        $this->_runInSubdirs( $Path );
      }

      // Schaun ob noch die Dateien ausgegeben werden sollen
      if ( isset( $this->_arguments['-listFiles'] ) ) {

        if ($this->_withSize) {

          echo "\n\n";
          echo "Gefundene Dateien: \n\n";

          $Lenght = count($this->_fileLenght);

          for ($nam = 0 ; $nam < $Lenght ; ++$nam) {
            echo "Name: ".$this->_fileNames[$nam]."\t Lines: "
              .$this->_fileLenght[$nam]. "\t Size ". $this->_fileSize[$nam]
              ." Bytes\n";
          }

        } else {
          echo "\n\n";
          echo "Gefundene Dateien: \n\n";

          $Lenght = count($this->_fileLenght);

          for ($nam = 0 ; $nam < $Lenght ; ++$nam) {
            echo "Name: ".$this->_fileNames[$nam]." Lines: "
              .$this->_fileLenght[$nam]. "\n";
          }
        }

      }

      echo "Habe ".$this->_fileCounter." Dateien mit " .$this->_rowCounter
        . " Zeilen gezählt ";

      if ($this->_withSize) {
        echo "mit einer GesamtGröße von "
          . round( array_sum( $this->_fileSize ) / 1024 ). " Kb";
      }

      echo "\n";

    } else {
      echo "Fehlerhafte Pfadangabe: ".$Path."\n";
    }

  }

////////////////////////////////////////////////////////////////////////////////
//
// Hilfsfunktionen
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  protected function _runInSubdirs( $Path )
  {
    // auslesen und auswerten
    if ($dh = opendir($Path)) {
        while ( ( $PotFolder = readdir($dh) ) !== false ) {
            if ($PotFolder != "." and $PotFolder != "..") {

              $FullPath = $Path."/".$PotFolder ;

              if ( is_file( $FullPath ) ) {
                if (  $this->_isFileToCount( $FullPath ) ) {
                  $this->_countRows( $FullPath );
                }
              }// Ende if

              // Wenn der Ordner Subdirs hat und rekursiv getestet werden soll
              // Dann gehen wir in Rekursion
              if ( is_dir( $FullPath ) ) {
                if($this->_verbose)
                  echo "Gehe in Unterverzeichniss: ".$FullPath."\n";

                $this->_runInSubdirs( $FullPath );
              }// Ende if

            }
        }// Ende While
        closedir($dh);
    }// Ende If

  }// Ende protected function _listToDel

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  protected function _runInSubdirsNoEmptys( $Path )
  {
    // auslesen und auswerten
    if ($dh = opendir($Path)) {
        while ( ( $PotFolder = readdir($dh) ) !== false ) {
            if ($PotFolder != "." and $PotFolder != "..") {

              $FullPath = $Path."/".$PotFolder ;

              if ( is_file( $FullPath ) ) {
                if (  $this->_isFileToCount( $FullPath ) ) {
                  $this->_countNoEmptyRows( $FullPath );
                }
              }// Ende if

              // Wenn der Ordner Subdirs hat und rekursiv getestet werden soll
              // Dann gehen wir in Rekursion
              if ( is_dir( $FullPath ) ) {
                if($this->_verbose)
                  echo "Gehe in Unterverzeichniss: ".$FullPath."\n";

                $this->_runInSubdirsNoEmptys( $FullPath );
              }// Ende if

            }
        }// Ende While
        closedir($dh);
    }// Ende If

  }// Ende protected function _listToDel

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  protected function _runInSubdirsNoComments( $Path )
  {
    // auslesen und auswerten
    if ($dh = opendir($Path)) {
        while ( ( $PotFolder = readdir($dh) ) !== false ) {
            if ($PotFolder != "." and $PotFolder != "..") {

              $FullPath = $Path."/".$PotFolder ;

              if ( is_file( $FullPath ) ) {
                if (  $this->_isFileToCount( $FullPath ) ) {
                  $this->_countNoComments( $FullPath );
                }
              }// Ende if

              // Wenn der Ordner Subdirs hat und rekursiv getestet werden soll
              // Dann gehen wir in Rekursion
              if ( is_dir( $FullPath ) ) {
                if($this->_verbose)
                  echo "Gehe in Unterverzeichniss: ".$FullPath."\n";

                $this->_runInSubdirsNoComments( $FullPath );
              }// Ende if

            }
        }// Ende While
        closedir($dh);
    }// Ende If

  }// Ende protected function _listToDel

 /**
  * Zählen der Zeilen einer Datei
  * @return void
  */
  protected function _countRows( $File )
  {

    ++ $this->_fileCounter;

    if ($this->_withSize) {
      $this->_getSize( $File );
    }

    $InnerCounter = 0;
    $this->_fileNames[] = $File;

    $Handle = fopen ( $File , "r");

    while (!feof($Handle)) {
      $row = fgets($Handle, 4096);
      ++ $this->_rowCounter;
      ++ $InnerCounter;
    }

    $this->_fileLenght[] = $InnerCounter;

    fclose ($Handle);

  }// Ende protected function _countRows

 /**
  * Zählen der Zeilen einer Datei
  * @return void
  */
  protected function _countNoEmptyRows( $File )
  {

    ++ $this->_fileCounter;

    if ($this->_withSize) {
      $this->_getSize( $File );
    }

    $InnerCounter = 0;
    $this->_fileNames[] = $File;

    $Handle = fopen ( $File , "r");

    while (!feof($Handle)) {
      $row = fgets($Handle, 4096);
      if ( trim($row) != "") {
        ++ $this->_rowCounter;
        ++ $InnerCounter;
      }
    }

    $this->_fileLenght[] = $InnerCounter;

    fclose ($Handle);

  }// Ende protected function _countRows

 /**
  * Zählen der Zeilen einer Datei
  * @return void
  */
  protected function _countNoComments( $File )
  {

    ++ $this->_fileCounter;

    if ($this->_withSize) {
      $this->_getSize( $File );
    }

    $InnerCounter = 0;
    $this->_fileNames[] = $File;

    $Handle = fopen ( $File , "r");

    while (!feof($Handle)) {
      $row = fgets($Handle, 4096);
      if ( !$this->_isComment($row) ) {
        ++ $this->_rowCounter;
        ++ $InnerCounter;
      }
    }

    $this->_fileLenght[] = $InnerCounter;

    fclose ($Handle);

  }// Ende protected function _countRows

 /**
  * Soll die Datei gezählt werden oder nicht
  * @return boolean
  */
  protected function _getSize( $File )
  {

    $this->_fileSize[] = filesize($File);

  }// Ende protected function _countRows

 /**
  * Soll die Datei gezählt werden oder nicht
  * @return boolean
  */
  protected function _isFileToCount( $File )
  {

    $FileInfo = pathinfo( $File );

    if( !isset($FileInfo["extension"]) )

      return false;

    $Ext = $FileInfo["extension"];

    if(  isset( $this->_countIn[$Ext] ) )

      return true;

    return false;

  }// Ende protected function _countRows

 /**
  * Soll die Datei gezählt werden oder nicht
  * @return boolean
  */
  protected function _isComment( $File )
  {

    $File = trim($File);
    $Lenght = strlen($File);

    switch ($Lenght) {
      case 0:
      {
        // zwar kein Comment aber wir brauchens trotzdem nicht
        return true;
        break;
      }

      case 1:
      {
        if ($File != "#" && $File != "*") {
          return false;
        } else {
          return true;
        }
        break;
      }

      default:
      {
        $Part = substr( $File , 0 , 2 );
        if( $Part != "//" && $Part != "/*" )

          return false;

        return true;
      }

    }// Ende Switch

  }// Ende protected function _countRows

////////////////////////////////////////////////////////////////////////////////
//
// App Hilfsfunktionen
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  * @return bool
  */
  protected function _isFlag( $Data )
  {

    if ($Data{0} == "-") {
      $this->_arguments[$Data] = true;

      return true;
    } else {
      return false;
    }

  } // end of member function _panicShutdown

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @since 0.1
  * @return array
  */
  protected function _isCommand( $Data )
  {
    $Data = strtolower($Data);

    if ( isset( $this->_actions[$Data] ) ) {
      $this->_command = $Data;

      return true;
    } else {
      return false;
    }

  } // end of member function _panicShutdown

 /**
  * Testen welche Aktion verwendet werden soll
  *
  * @return String
  */
  protected function _checkAktion( )
  {

    if ($this->_command) {
      return $this->_command;
    } else {
      // Keine Action gefunden, dann die Hilfe ausgeben
      return "help";
    }

  } // end of member function _checkAktion

 /**
  * beenden des Programmes
  *
  * @return void
  */
  protected function _suicide( $Message )
  {

    echo "\n".$Message."\n";
    exit(1);

  } // end of member function _suicide

}

$Start = microtime( true );
$Run = new StatsMaker( $conf );
$Run->main();
$Ende = microtime( true );

exit(0);

?>
