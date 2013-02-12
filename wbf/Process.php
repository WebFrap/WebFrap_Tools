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

///
/// NEIN, DIES DATEI ERHEBT NICHT DEN ANSPRUCH OOP ZU SEIN.
/// ES IS EXPLIZIT AUCH NICHT ALS OOP GEWOLLT.
/// DIE KLASSEN WERDEN LEDIGLICH ALS CONTAINER ZUM ORGANISIEREN DER FUNKTIONEN VERWENDET.
/// JA DAS IST VIEL CODE FÜR EINE DATEI, NEIN ES IST KEIN PROBLEM
/// NEIN ES IST WIRKLICH KEIN PROBLEM, SOLLTE ES DOCH ZU EINEM WERDEN WIRD ES
/// GELÖST SOBALD ES EINS IST
/// Danke ;-)
///

/**
 * Klasse zum ausführen von Programmen
 * @package WebFrap
 * @subpackage Gaia
 */
class Process
{

  /**
   * @param string $command
   */
  public static function run( $command )
  {
    $result = '';
    if ($proc = popen("($command)2>&1","r") ) {
      while (!feof($proc))
        echo fgets($proc, 1000);

      pclose($proc);

    }

  }//end static function run */

  /**
   * @param string $command
   */
  public static function system( $command )
  {

    echo exec( $command );

  }//end static function system */

  /**
   * @param string $command
   */
  public static function execute( $command )
  {
    $result = '';
    if ($proc = popen("($command)2>&1","r") ) {
      while (!feof($proc))
        $result .= fgets($proc, 1000);

      pclose($proc);

      return $result;
    }

  }//end static function execute */

}//end class Process */
