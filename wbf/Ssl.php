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
 * SSL Klasse
 * @package WebFrap
 * @subpackage Gaia
 */
class Ssl
{

  /**
   * @param string $universeKey
   */
  public static function simpleCert( $universeKey )
  {

    if( Fs::exists( "/etc/apache2/ssl/{$universeKey}/{$universeKey}.pem" ) )

      return;

    if( !Fs::exists( "/etc/apache2/ssl/{$universeKey}/" ) )
      Fs::mkdir( "/etc/apache2/ssl/{$universeKey}/" );

    Process::system
    (
      "openssl req -new -x509 -days 365 -nodes "
      ." -out /etc/apache2/ssl/{$universeKey}/{$universeKey}.pem "
      ." -keyout /etc/apache2/ssl/{$universeKey}/{$universeKey}.pem"
    );

    Process::system
    (
      "ln -sf /etc/apache2/ssl/{$universeKey}/{$universeKey}.pem "
      ." /etc/apache2/ssl/{$universeKey}/`/usr/bin/openssl x509 "
      ." -noout -hash < /etc/apache2/ssl/{$universeKey}/{$universeKey}.pem`.0"
    );

    Fs::chmod( "/etc/apache2/ssl/{$universeKey}/{$universeKey}.pem", '600' );

  }//end public static function simpleCert *

  /**
   *
   */
  public static function createCa( $caFolder, $days )
  {
    //$command = 'openssl ca '

    // erstellen der benötigten Ordner
    Fs::mkdir( $caFolder.'/certs' );
    Fs::mkdir( $caFolder.'/crl' );
    Fs::mkdir( $caFolder.'/newcerts' );
    Fs::mkdir( $caFolder.'/private' );
    Fs::touch( $caFolder.'index.txt' );

    $command = 'openssl req -new -keyout '.$caFolder.'/private/cakey.pem -out '.$caFolder.'/careq.pem';
    Process::system( $command );

    $command = 'openssl ca -create_serial ';
    $command .= '-out '.$caFolder.'/cacert.pem '.$days.' ';
    $command .= ' -batch ';
    $command .= ' -batch ';
    $command .= ' -keyfile '.$caFolder.'/private/cakey.pem ';
    $command .= ' -selfsign ';
    $command .= ' -extensions v3_ca ';
    $command .= ' -infiles '.$caFolder.'/careq.pem ';
    Process::system( $command );

  }//end public static function createCa *

}//end class Ssl */
