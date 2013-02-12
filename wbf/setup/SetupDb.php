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
 * @package WebFrap
 * @subpackage Gaia
 */
class SetupDb
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var DbAdmin
   */
  protected $dbAdmin = null;

  /**
   * @var ProtocolWriter
   */
  protected $protocol = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param UiConsole $console
   * @param string $type
   * @param ProtocolWriter $protocol
   */
  public static function getSetup( $console, $type, $protocol = null )
  {

    $className = 'SetupDb'.ucfirst( $type );

    if( !Gaia::classLoadable($className) )
      throw new GaiaException( 'The requested setup not exists.' );

    return new $className( $console, $protocol );

  }//end public static function getSetup */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath
   */
  public function setup( $package, $gateway, $server, $database, $dataPath  )
  {

  }//end public function setup */

  /**
   * @param Package $package
   * @param PackageGateway $gateway
   * @param PackageServer $server
   * @param PackageServerDb $database
   * @param string $dataPath
   */
  public function update( $package, $gateway, $server, $database, $dataPath  )
  {

  }//end public function update */

} // end class SetupDb

