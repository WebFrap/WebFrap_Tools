#!/usr/bin/php -q
<?php
/*******************************************************************************

 ____      ____  ________  ______   ________  _______          _       _______  
|_  _|    |_  _||_   __  ||_   _ \ |_   __  ||_   __ \        / \     |_   __ \ 
  \ \  /\  / /    | |_ \_|  | |_) |  | |_ \_|  | |__) |      / _ \      | |__) |
   \ \/  \/ /     |  _| _   |  __'.  |  _|     |  __ /      / ___ \     |  ___/ 
    \  /\  /     _| |__/ | _| |__) |_| |_     _| |  \ \_  _/ /   \ \_  _| |_    
     \/  \/     |________||_______/|_____|   |____| |___||____| |____||_____|   


Autor     : Dominik Bonsch
Copyright : Dominik Bonsch

*******************************************************************************/

set_time_limit(0);
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set("Europe/Berlin");


 /**
  * Class VmstatToCsv
  * @version 0.1
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
  * Die Offizielle Bezugs Quelle diese Scriptes ist http://homesono.de
  *
  * @copyright Dominik Bonsch
  *
  */
class VmstatToCsv
{

 /**
  * vorhandene Argumente
  */
  private $_arguments = array();

 /**
  * Unterstütze Kommandos
  */
  private $_actions = array
  (
  "help"      => "help", // Ausgabe der Hilfe
  "convert"   => "convert"
  );

 /**
  * Das InputFile
  */
  private $_fileIn = './vmstat.out';

 /**
  * Das ZielFile
  */
  private $_fileOut = './Conv_vmstat.csv';

 /**
  * Das Aktuelle Commando
  */
  private $_command = null;

 /**
  * Soll das Programm geschwätzig sein?
  */
  private $_verbose = false;

 /**
  * Der Standart Konstruktor
  */
  public function __construct()
  {

    if ($_SERVER["argc"] <= 1)
    {
      // Keine Parameter also Hilfe ausgeben
      $this->printHelp();
      exit(0);
    }

    for ($nam = 1 ; $nam < $_SERVER["argc"] ; ++$nam)
    {

      if (!$this->_isFlag($_SERVER["argv"][$nam])  )
      {
        if (!$this->_isCommand($_SERVER["argv"][$nam]))
        {
          $Key = $nam;
          ++$nam;

          if (!isset($_SERVER["argv"][$nam]))
          {
            echo "Falsche Parameter:\n\n";
            $this->printHelp();
            exit(1);
          }

          $this->_arguments[$_SERVER["argv"][$Key]] = $_SERVER["argv"][$nam];
        }
      }
    }

    if (isset($this->_arguments["-v"])){
      $this->_verbose = true;
      echo "Bin geschwätzig...\n";
    }


  } // end of member function __construct


 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function main()
  {

    switch($this->_checkAktion())
    {

      case 'help':
      {
        $this->printHelp();
        break;
      }

      case 'convert':
      {
        if ($this->_verbose)
          echo "Convertieren der Datei\n";

        $this->runConverter();
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
  * Ausgabe der Hilfe
  *
  * @return void
  */
  public function printHelp()
  {
    echo "Projekt Vmstat to Csv\n";
    echo "Author: Dominik Bonsch\n\n";
    echo "Kommandos:\n";
    echo "convert             Konvertieren der Vmstatausgabe zu einer Csv Datei\n";
    echo "help                Ausgabe dieser Hilfe\n";
    echo "\n";
    echo "Parameter:\n";
    echo "input /pfad/file    Die Datei von der eingelesen wird\n";
    echo "output /pfad/file   Die Datei in die geschrieben wird\n";
    echo "\n";
    echo "Flags:\n";
    echo "-h                  Ausgabe dieser Hilfe\n";
    echo "-v                  Sei geschwätzig\n";
    echo "-noHead             Den Kopf mit den Angaben weglassen\n";
    echo "\n";
    echo "Minimal Syntax:\n";
    echo "php TextToCsv.php convert input ./stats.out output ./stats.csv\n";
 }

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @return int
  */
  public function runConverter()
  {
    if ($this->_verbose)
      echo "Such Input Datei...\n";

    if (isset($this->_arguments['input']))
    {
      $this->_fileIn = $this->_arguments['input'] ;
    }

    if (!is_readable($this->_fileIn) or !is_file($this->_fileIn))
    {
      $this->_suicide("Fehler beim öffnen der Eingabedatei");
    }


    if (!$textarray = file($this->_fileIn))
    {
      $this->_suicide("Fehler beim einlesen der Datei");
    }

    $CsvBody = "";
    $CsvHead = "";


    if (!isset($this->_arguments["-noHead"])){
      $Head = $textarray[1];
      $HeadLines = explode(" " , $Head);

      // Convertieren des Heads

            // ansonsten lauf durch
      foreach($HeadLines as $Cell)
      {
        if (trim($Cell) != "")
        {
          $CsvHead .= trim($Cell). ";";
        }
      }
      $CsvHead = substr($CsvHead , 0 , -1);
      $CsvHead .= "\n";
    }


    // Convertieren des Bodys
    foreach($textarray as $rows)
    {
      $wort = explode(" " , $rows);

      // Wenns keine Zahl is: "Lauf WIDÄ!!"
      if (!is_numeric(trim($wort[1])))
      {
        continue;
      }

      // ansonsten lauf durch
      foreach($wort as $wor)
      {
        if (trim($wor) != "")
        {
          $CsvBody .= trim($wor). ";";
        }
      }
      $CsvBody = substr($CsvBody , 0 , -1);
      $CsvBody .= "\n";

    }// Ende Foreach


    // Wenn wir geschwätzig sind dann verraten wir schnell mal das ergebnis
    if ($this->_verbose)
    {
      echo "Convertierte Datei:\n";
      echo $CsvHead;
      echo $CsvBody;
    }


    if (isset($this->_arguments['output']))
    {
      $this->_fileOut = $this->_arguments['output'] ;
    }


    if (file_exists($this->_fileOut))
    {
      if (!is_writeable($this->_fileOut))
      {
        $this->_suicide('Ausgabedatei konnte bereits vorhandene Datei nicht ersetzen!!');
      }

    }
    elseif (!touch($this->_fileOut))
    {
      if (!is_writeable($this->_fileOut))
      {
        $this->_suicide('Konnte Ausgabedatei nicht erstellen!!');
      }
    }


    if (!file_put_contents ($this->_fileOut , $CsvHead.$CsvBody))
    {
      $this->_suicide('Konnte Daten nicht schreiben!');
    }


    if ($this->_verbose)
      echo "Öhm, Fädsch, Feierabnd...\n";

  }


////////////////////////////////////////////////////////////////////////////////
// BasisFunktion
////////////////////////////////////////////////////////////////////////////////

 /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  * @return bool
  */
  protected function _isFlag($Data)
  {

    if ($Data{0} == "-"){
      $this->_arguments[$Data] = true;
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
  protected function _isCommand($Data)
  {
    $Data = strtolower($Data);

    if (isset($this->_actions[$Data]))
    {
      $this->_command = $Data;
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
  protected function _checkAktion()
  {

    if ($this->_command)
    {
      return $this->_command;
    }
    else
    {
      // Keine Action gefunden, dann die Hilfe ausgeben
      return "help";
    }

  } // end of member function _checkAktion

 /**
  * beenden des Programmes
  *
  * @return void
  */
  protected function _suicide($Message)
  {

    echo "\n".$Message."\n";
    exit(1);

  } // end of member function _suicide

}//end class VmstatToCsv

$Run = new VmstatToCsv();
$Run->main();
exit(0);

?>
