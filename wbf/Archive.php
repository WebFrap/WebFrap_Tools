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
 * Klasse zum entpacken von Archiven
 * @package WebFrap
 * @subpackage Gaia
 */
class Archive
{

  /**
   * @param string $archiveName
   * @param string $folder
   * @param string $relativPath
   */
  public static function create( $archiveName, $folder, $relativPath = null )
  {

    $tmp     = explode( '.', $archiveName );
    $ending  = $tmp[count($tmp)-1];

    switch ($ending) {
      case 'tar':
      {
        Process::run( "tar -cvf ".$archiveName.' '.$folder );

        return null;
      }

      case 'gz':
      {
        Process::run( "tar -zcvf ".$archiveName.' '.$folder );

        return null;
      }

      case 'bz2':
      {
        Process::run( "tar -cjvf ".$archiveName.' '.$folder );

        return null;
      }

      case 'zip':
      {
        Process::run( "zip ".$archiveName.' '.$folder );

        return null;
      }

      default:
      {
        return 'Unknown Archive Type: '.$archiveName;
      }

    }

  }//end public static function packArchive */

  /**
   * @param string $fileName
   */
  public static function extract( $fileName  )
  {

    $tmp     = explode( '.', $fileName );
    $ending  = $tmp[count($tmp)-1];

    switch ($ending) {
      case 'tar':
      {
        Process::run( "tar xvf ".$fileName );

        return null;
      }

      case 'gz':
      {
        Process::run( "tar xzvf ".$fileName );

        return null;
      }

      case 'bz2':
      {
        Process::run( "tar xjvf ".$fileName );

        return null;
      }

      case 'zip':
      {
        Process::run( "unzip ".$fileName );

        return null;
      }

      default:
      {
        return 'Unknown Archive Type: '.$ending;
      }

    }

  }//end public static function unpack */

}//end class Archive */
