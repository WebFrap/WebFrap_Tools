<?php
/*******************************************************************************

 ____      ____  ________  ______   ________  _______          _       _______
|_  _|    |_  _||_   __  ||_   _ \ |_   __  ||_   __ \        / \     |_   __ \
  \ \  /\  / /    | |_ \_|  | |_) |  | |_ \_|  | |__) |      / _ \      | |__) |
   \ \/  \/ /     |  _| _   |  __'.  |  _|     |  __ /      / ___ \     |  ___/
    \  /\  /     _| |__/ | _| |__) |_| |_     _| |  \ \_  _/ /   \ \_  _| |_
     \/  \/     |________||_______/|_____|   |____| |___||____| |____||_____|



Autor     : Dominik Bonsch cdo@webfrapdev.de
Copyright : Dominik Bonsch cdo@webfrapdev.de
Licence		: Webfrap Common Working Together Licence 1.0 or later
Licence		: Webfrap Business Licence 1.0 or later

*******************************************************************************/


set_time_limit(0);
error_reporting( E_ALL );
date_default_timezone_set( "Europe/Berlin" );


 /**
  * Class StatsMaker
  * @version alpha 0.1
  * @license Webfrap Common Working Together Licence 1.0 or later
  * @license Webfrap Business Licence 1.0 or later
  * @copyright DominikBonsch <a href="contact@web-modules.de">Dominik Bonsch</a>
  *
  */
abstract class CliControllerAbstract
{

////////////////////////////////////////////////////////////////////////////////
//
// Attribute
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * vorhandene Argumente
  */
  protected $arguments = array();

 /**
  * Unterstütze Kommandos
  */
  protected $actions = array
  (
  'help'   => 'help'
  );

 /**
  * Das Aktuelle Commando
  */
  protected $command = null;


 /**
  * Soll das Programm geschwätzig sein?
  */
  public $verbose = false;

  /**
   *
   */
  public $debug = true;


////////////////////////////////////////////////////////////////////////////////
//
// Konstruktoren
//
////////////////////////////////////////////////////////////////////////////////

 /**
  * Der Standart Konstruktor
  */
  public function __construct( )
  {


    for ($nam = 1 ; $nam < $_SERVER['argc'] ; ++$nam) {

      if ( !$this->isFlag( $_SERVER['argv'][$nam] )  ) {
        if ( !$this->isCommand( $_SERVER['argv'][$nam] ) ) {
          $Key = $nam;
          ++$nam;

          if ( !isset( $_SERVER['argv'][$nam] ) ) {
            echo 'Falsche Parameter:\n\n';
            $this->printHelp( );
            exit(1);
          }

          $this->arguments[$_SERVER['argv'][$Key]] = $_SERVER['argv'][$nam];
        }
      }
    }

    if ( isset( $this->arguments['-v'] ) ) {
      $this->verbose = true;
      echo "Bin geschwätzig...\n";
    }


  } // end of member function __construct

////////////////////////////////////////////////////////////////////////////////
// Getter und Setter
////////////////////////////////////////////////////////////////////////////////


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

    switch ( $this->checkAktion() ) {

      case 'help':
      {
        $this->printHelp();
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
    echo 'No Help yet\n';
  }


////////////////////////////////////////////////////////////////////////////////
// Hilfsfunktionen
////////////////////////////////////////////////////////////////////////////////


 /**
  * Soll die Datei gezählt werden oder nicht
  * @return boolean
  */
  protected function isComment( $File )
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
        if ($File != '#' && $File != '*') {
          return false;
        } else {
          return true;
        }
        break;
      }

      default:
      {
        $Part = substr( $File , 0 , 2 );
        if ($Part != '//' && $Part != '/*') {
          return false;
        }

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
  protected function isFlag( $Data )
  {

    if ($Data{0} == '-') {
      $this->arguments[$Data] = true;

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
  protected function isCommand( $Data )
  {
    $Data = strtolower($Data);

    if ( isset( $this->actions[$Data] ) ) {
      $this->command = $Data;

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
  protected function checkAktion( )
  {

    if ( !is_null($this->command) ) {
      if($this->debug)
        echo "Gebe command zurück\n";

      return $this->command;
    } else {
      if($this->debug)
        echo "hab kein command\n";

      // Keine Action gefunden, dann die Hilfe ausgeben
      return 'help';
    }

  } // end of member function checkAktion

 /**
  * beenden des Programmes
  *
  * @return void
  */
  protected function suicide( $Message )
  {

    echo "\n$Message\n";
    exit(1);

  } // end of member function suicide

}//end CliControllerAbstract

