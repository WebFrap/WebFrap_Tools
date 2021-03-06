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
 * Betriebsystem spezifische elemente
 * @package WebFrap
 * @subpackage Gaia
 */
class Protocol
{
  
  /**
   * Der aktuelle Writer
   * @var Protocol
   */
  private static $writer;
  
////////////////////////////////////////////////////////////////////////////////
// Static Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $fileName
   * @param string $head
   * @param string $type
   */
  public static function openProtocol( $fileName = null, $head = null, $type = null )
  {
    
    if( $type )
      $type = '-'.$type;
    
    if( !$fileName )
      $fileName = GAIA_PATH.'log/protocol'.$type.'-'.date('YmdHis').'.log';
    
    self::$writer = new ProtocolWriter( $fileName ); 
      
    if( $head )
      self::head( $head );
      
    return self::$writer;
    
  }//end public static function openProtocol */
  
  /**
   * @param string $message
   */
  public static function closeProtocol( $message = null )
  {
    
    if( $message )
      self::foot( $message );
      
    self::$writer->close();
    
  }//end public static function openProtocol */
  
  /**
   * @param string $fileName
   */
  public static function getActive( )
  {
    
    if( !self::$writer )
      self::openProtocol();
    
    return self::$writer; 

  }//end public static function getActive */
  
  /**
   * @param string $msg
   */
  public static function head( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    $head = <<<HEAD
-------------------------------------------------------------------------------
- {$msg}
-------------------------------------------------------------------------------
HEAD;
      
    self::$writer->write( $head );

  }//end public static function head */
  
  /**
   * @param string $msg
   */
  public static function subHead( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    $head = <<<HEAD
-
- {$msg}
-------------------------------------------------------------------------------
HEAD;
      
    self::$writer->write( $head );

  }//end public static function subHead */
  
  /**
   * @param string $msg
   */
  public static function foot( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    $head = <<<HEAD
*******************************************************************************
* {$msg}
*******************************************************************************
HEAD;
      
    self::$writer->write( $head );

  }//end public static function foot */
  
  /**
   * @param string $msg
   */
  public static function line( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    self::$writer->write( $msg );

  }//end public static function line */
  
  /**
   * @param string $msg
   */
  public static function info( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    self::$writer->write( 'INFO: '.$msg );

  }//end public static function info */
  
  /**
   * @param string $msg
   */
  public static function warning( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    self::$writer->write( 'WARN: '.$msg );

  }//end public static function warning */
  
  /**
   * @param string $msg
   */
  public static function error( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    self::$writer->write( 'ERROR: '.$msg );

  }//end public static function error */
  
  /**
   * @param string $msg
   */
  public static function fatal( $msg )
  {
    
    if( !self::$writer )
      self::openProtocol();
      
    self::$writer->write( 'FATAL: '.$msg );

  }//end public static function error */


}//end class Protocol */