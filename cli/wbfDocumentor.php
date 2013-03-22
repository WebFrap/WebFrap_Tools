#!/usr/bin/php -q
<?php
/*******************************************************************************
 ____      ____  ________  ______   ________  _______          _       _______
|_  _|    |_  _||_   __  ||_   _ \ |_   __  ||_   __ \        / \     |_   __ \
  \ \  /\  / /    | |_ \_|  | |_) |  | |_ \_|  | |__) |      / _ \      | |__) |
   \ \/  \/ /     |  _| _   |  __'.  |  _|     |  __ /      / ___ \     |  ___/
    \  /\  /     _| |__/ | _| |__) |_| |_     _| |  \ \_  _/ /   \ \_  _| |_
     \/  \/     |________||_______/|_____|   |____| |___||____| |____||_____|


Autor: Dominik Bonsch <dominik.bonsch@webfrap.de>
Date:
Copyright: Webfrap Developer Network <contact@webfrap.de>
Project: Webfrap Web Frame Application (Server)
ProjectUrl: http://webfrap.de / http://webfrapdev.de

Licence: (GNU LESSER GENERAL PUBLIC LICENSE 3.0) see: LICENCE/LGPL.txt

Version: 1  Revision: 1

Changes:

*******************************************************************************/

set_time_limit(0);
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set( "Europe/Berlin" );

class Documentor
{

////////////////////////////////////////////////////////////////////////////////
//
// Attribute
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * vorhandene Argumente
  */
  public $arguments = array();

 /**
  * Unterstütze Kommandos
  */
  public $actions = array
  (
  "help"      => "help", // Ausgabe der Hilfe
  "refactor"  => "refactor"
  );

 /**
  * Das Aktuelle Commando
  */
  public $command = 'extract';

 /**
  * Soll das Programm geschwätzig sein?
  */
  public $verbose = false;

  public $search = '';

  public $replace = '';

  public $endings = array( 'php');

  protected $commentOpen = false;

////////////////////////////////////////////////////////////////////////////////
// Konstruktoren
////////////////////////////////////////////////////////////////////////////////

 /**
  * Der Standart Konstruktor
  */
  public function __construct( )
  {



    for ( $nam = 1 ; $nam < $_SERVER["argc"] ; ++$nam )
    {

      if ( !$this->isFlag( $_SERVER["argv"][$nam] )  )
      {
        if ( !$this->isCommand( $_SERVER["argv"][$nam] ) )
        {
          $Key = $nam;
          ++$nam;

          if ( !isset( $_SERVER["argv"][$nam] ) )
          {
            echo "Falsche Parameter:\n\n";
            $this->printHelp( );
            exit(1);
          }

          $this->arguments[$_SERVER["argv"][$Key]] = $_SERVER["argv"][$nam];
        }
      }
    }

    if ( isset( $this->arguments["-v"] ) ){
      $this->verbose = true;
      echo "Bin geschwätzig...\n";
    }


  } // end public function __construct( )

////////////////////////////////////////////////////////////////////////////////
// Main Function
////////////////////////////////////////////////////////////////////////////////

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function main()
  {


    switch( $this->checkAktion() )
    {

      case 'help':
      {
        $this->printHelp();
        break;
      }

      case 'extract':
      {
        if ($this->verbose)
          echo "Extract Comments from Code\n";

        $this->extract( );
        break;
      }

      default:
      {
        $this->printHelp();
      }

    }// ende Switch


  }

////////////////////////////////////////////////////////////////////////////////
// Commands
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
    echo "refactor            Projekt refactorieren\n";
    echo "help                Ausgabe dieser Hilfe\n";
    echo "\n";
    echo "Parameter:\n";
    echo "path /path/to       Das Zielprojekt\n";
    echo "search str          Den zu Suchenden String\n";
    echo "replace str         Den zu ersetzenden String\n";
    echo "\n";
    echo "Flags:\n";
    echo "-h                  Ausgabe dieser Hilfe\n";
    echo "-v                  Sei geschwätzig\n";
 }

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function extract( )
  {

    if ( !isset( $this->arguments['path'] ) )
    {
      $this->printHelp();
      return false;
    }

    echo 'Starte mit der Refactorierung von: '.$this->arguments['path']."\n";

    $path = $this->arguments['path'];

    if ( is_dir($path) )
    {
      $this->runInSubdirs( $path );
    }
    else
    {
      echo "Fehlerhafte Pfadangabe: ".$path."\n";
    }

  }


////////////////////////////////////////////////////////////////////////////////
// Hilfsfunktionen
////////////////////////////////////////////////////////////////////////////////

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  protected function runInSubdirs( $path )
  {
    // auslesen und auswerten
    if ($dh = opendir($path))
    {
        while ( ( $potFolder = readdir($dh) ) !== false )
        {
            if ( $potFolder != "." and $potFolder != ".." )
            {

              $fullPath = $path."/".$potFolder ;

              if ( is_file( $fullPath ) )
              {
                if ( $this->validFile( $fullPath ) )
                {
                  $this->replaceFile( $fullPath );
                }
              }// Ende if
              else
              {
                $this->runInSubdirs( $fullPath );
              }// Ende if

            }
        }// Ende While
        closedir($dh);
    }// Ende If

  }// Ende protected function runInSubdirs


 /**
  * Zählen der Zeilen einer Datei
  * @return void
  */
  protected function replaceFile( $file )
  {


    $content = '';
    $handle = fopen ( $file , "r");

    while (!feof($handle))
    {
      $row = fgets($handle, 4096);
      $content .= $this->checkComment($row);
    }

    fclose ($handle);

    echo "Doku for $file \n";
    echo $content;


  }// Ende protected function replace

  public function checkComment( $row )
  {
    $row = trim($row);

    if ($this->commentOpen)
    {
      if ( substr($row , -2 ) == '*/' )
      {
        $this->commentOpen = false;
      }

      return $row."\n";
    }
    elseif ( substr($row , 0 , 3) == '/**' )
    {
      $this->commentOpen = true;
      return $row."\n";
    }
    else
    {
      return '';
    }

  }


 /**
  * Soll die Datei gezählt werden oder nicht
  * @return boolean
  */
  protected function validFile( $file )
  {

    $fileInfo = pathinfo( $file );

    if ( !isset($fileInfo["extension"]) )
    {
      return false;
    }

    $ext = $fileInfo["extension"];

    if (  in_array( $ext , $this->endings ) )
    {
      return true;
    }

    return false;

  }// protected function isFileToCount( $file )


////////////////////////////////////////////////////////////////////////////////
// App Hilfsfunktionen
////////////////////////////////////////////////////////////////////////////////


 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  * @return bool
  */
  protected function isFlag( $Data )
  {

    if ( $Data{0} == "-" )
    {
      $this->arguments[$Data] = true;
      return true;
    }
    else
    {
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
  protected function isCommand( $Data )
  {
    $Data = strtolower($Data);

    if ( isset( $this->actions[$Data] ) )
    {
      $this->command = $Data;
      return true;
    }
    else
    {
      return false;
    }

  } // end of member function _panicShutdown

 /**
  * Testen welche Aktion verwendet werden soll
  *
  * @return String
  */
  protected function checkAktion( )
  {

    if ( $this->command )
    {
      return $this->command;
    }
    else
    {
      //standardmäßig anfangen zu refactorieren
      return "refactor";
    }

  } // end protected function checkAktion( )


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
$Run = new Documentor();

$Run->arguments['path'] = '/var/www/WebFrapWorkspace/WebFrap_Application/src';
$Run->main();

$Ende = microtime( true );

echo 'Duration: '.( ($Ende-$Start) )."\n";

exit(0);


?>
