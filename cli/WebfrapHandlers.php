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
Copyright:  Webfrap Developer Network <contact@webfrap.de>
Project: Webfrap Web Frame Application (Server)
ProjectUrl: http://webfrap.de / http://webfrapdev.de

Licence: (GNU LESSER GENERAL PUBLIC LICENSE 3.0) see: LICENCE/LGPL.txt

Version: 1  Revision: 1

Changes:

*******************************************************************************/

error_reporting(E_ALL | E_STRICT);
//error_reporting(0);

// Setting of the right timezone
date_default_timezone_set( 'Europe/Berlin' );

/**
 *
 */
define( 'INDEX_LOAD' , true );

/**
 *
 */
define( 'DEBUG' , true );

/**
 *
 */
define( 'ROOT'    , '../../');

/**
 *
 */
define( 'V_ROOT' , '../../' );

/**
 *
 */
define( 'WEB_ROOT' , '../../' );

/**
 *
 */
define( 'LIB_PATH' , ROOT.'src/');

/**
 *
 */
define( 'USER_LIB_PATH' , V_ROOT.'src/');

/**
 *
 */
define( 'SANDBOX_LIB_PATH' , ROOT.'/sandbox/src/');

/**
 * Enter description here...
 *
 */
define( 'MAX_PACKAGE_LEVEL' , 3 );

/**
 * @var string
 */
define( 'TEMPLATE_PATH' , ROOT.'templates/' );

/**
 *
 */
define( 'PDF_TEMPLATE_PATH' , TEMPLATE_PATH."pdf/");

/**
 * Enter description here...
 *
 */
define( 'THIRD_PARTY_PATH' , ROOT.'vendor/' );


/**
 *
 */
define( 'NL' , "\n" );

/**
 *
 */
define( 'TEMP_SEP' , "#&~" );

/**
 *
 */
define( 'P_S' , ":" );

/**
 *
 */
define( 'D_S' , "/" );

/**
 *
 */
define( 'LOG_CONF' , V_ROOT.'conf/Webfraplog.xml' );

define( 'ENABLE_FIREPHP' , false );



////////////////////////////////////////////////////////////////////////////////
// Configuration which Modules shoul be used
////////////////////////////////////////////////////////////////////////////////

/**
 * Which Systemcontroller Should be used
 */
define( 'WBF_CONTROLLER' , 'Cli' );


/**
 * The Session Class to Use in Webfrap
 *
 */
define( 'WBF_SESSION_TYPE' , 'Php'  );

/**
 * The Session Class to Use in Webfrap
 *
 */
define( 'WBF_SESSION_PATH' , V_ROOT.'tmp/session/'  );

/**
 * Default Name of the Webfrap Session
 *
 */
define( 'WBF_SESSION_NAME' , 'WEBFRAP_SID'  );

/**
 * Enter description here...
 *
 */
define( 'WBF_REQUEST_ADAPTER' , 'Php'  );

/**
 * What Type of Transaction Storage Should the Transaction Management Use
 *
 */
define( 'WBF_TRANSACTION_TYPE' , 'Session'  );

/**
 * What type of Configuration should the System use?
 *
 */
define( 'WBF_CONF_TYPE' , 'Xml'  );


/**
 * Which Lib should the System use to highlight Code
 *
 */
define( 'WBF_LIB_HIGHLIGHT' , 'Geshi'  );

/**
 * how much menupoints in one row
 *
 */
define( 'WBF_MENU_SIZE' , 3 );


define( 'WBF_CACHE_LEVEL1' , '60' );

define( 'WBF_CACHE_LEVEL2' , '1800' );


////////////////////////////////////////////////////////////////////////////////
// Url Parameters for the Urldesign
////////////////////////////////////////////////////////////////////////////////

/**
 * Is Urldesign activated
 *
 */
define( 'URL_DESIGN' , false  );

define( 'URL_START_SEP' , ','  );

define( 'URL_END_SEP' , ','  );

define( 'URL_PARAM_SEP' , '-'  );

define( 'URL_VALUE_SEP' , '-'  );

define( 'URL_TITLE_SEP' , '-'  );


////////////////////////////////////////////////////////////////////////////////
// The Webfrap PHP Configuration / Handling
////////////////////////////////////////////////////////////////////////////////


include_once('ezc/Base/base.php');

/*
this is the developer configuration!!
for productiv use we recomment to use just the autload function and
the notfounAutoload at the end
*/
spl_autoload_register('Webfrap::vhostAutoload');
spl_autoload_register('Webfrap::autoload');
if (Webfrap::class_loadable('ezcBase'))
{
  spl_autoload_register('ezcBase::autoload');
}
spl_autoload_register('Webfrap::notfoundAutoload');

/*
set_error_handler('Webfrap::errorHandler');
session_set_save_handler
(
  'SysSession::open',
  'SysSession::close',
  'SysSession::read',
  'SysSession::write',
  'SysSession::destroy',
  'SysSession::gc'
);
*/

/**
 * Enter description here...
 *
 */
class Webfrap
{


  /**
   * Enter description here...
   *
   * @var array
   */
  protected static $includePath = array();

  /**
   * Enter description here...
   *
   * @var array
   */
  protected static $autoload = array
  (
  'Webfrap::autoload' => true
  );

  /**
   * Enter description here...
   *
   * @var array
   */
  protected static $session = array();

  /**
   * Enter description here...
   *
   * @param string $includePath
   */
  public static function setIncludePath( $includePath )
  {
    if (!isset(self::$includePath[$includePath]))
    {
      set_include_path( get_include_path().P_S.$includePath );
      self::$includePath[$includePath] = true;
    }
  }//end public static function setIncludePath( $includePath )

  /**
   * Enter description here...
   *
   * @param string $includePath
   */
  public static function addIncludePath( $includePath )
  {
    if (!isset(self::$includePath[$includePath]))
    {
      set_include_path( get_include_path().P_S.$includePath );
      self::$includePath[$includePath] = true;
    }
  }//end public static function setIncludePath( $includePath )

  /**
   * Enter description here...
   *
   * @param string $includePath
   */
  public static function addAutoload( $autoload )
  {
    if (!isset(self::$autoload[$autoload]))
    {
      spl_autoload_register($autoload);
      self::$autoload[$autoload] = true;
    }
  }//end public static function setIncludePath( $includePath )

  /**
   * wrapper for class exists
   * cause class exists always throws an exception if the class not exists
   * @param string $classname
   * @return boolean
   */
  public static function class_loadable( $classname )
  {
    try
    {
      $back = class_exists($classname);
      return $back;
    }
    catch( SysClassNotFoundException $e )
    {
      return false;
    }

  }//end function class_loadable( $classname )

  /** The Autoloadfunction
   *
   *  Die Autoloadklasse wir aufgerufen wenn ein Objekt
   *  einer Klasse mit new erstellt werden soll, die Klassendefinition
   *  aber noch nicht bekannt ist.
   *
   *  @param string Name The Name of the Class that needs to be loaded
   */
  public static function vhostAutoload( $classname )
  {

      $length = strlen($classname);
      $requireMe = null;

      $parts = array();
      $start = 0;
      $end = 1;
      $package = '';


      if ( file_exists( USER_LIB_PATH.$classname.'.php' ) )
      {
        $requireMe = USER_LIB_PATH.$classname.'.php' ;
      }
      else
      {
        // 3 Stufen Packages
        $level = 0;
        for ( $pos = 1 ; $pos < $length  ; ++$pos )
        {
          if (ctype_upper($classname[$pos]) )
          {
            $package .= strtolower(substr( $classname, $start, $end  )).'/' ;
            $start += $end;
            $end = 0;
            ++$level;

            if ( file_exists( USER_LIB_PATH.$package.$classname.'.php' ) )
            {
              $requireMe = USER_LIB_PATH.$package.$classname.'.php' ;

              break;
            }

            if ( $level == MAX_PACKAGE_LEVEL )
            {
              break;
            }
          }
          ++$end;
        }
      }//end if ( file_exists( USER_LIB_PATH.$classname.'.php' ) )


      if ( $requireMe )
      {
        require $requireMe;
      }

  } //function __autoload( $classname )

  /** The Autoloadfunction
   *
   *  Die Autoloadklasse wir aufgerufen wenn ein Objekt
   *  einer Klasse mit new erstellt werden soll, die Klassendefinition
   *  aber noch nicht bekannt ist.
   *
   *  @param string Name The Name of the Class that needs to be loaded
   */
  public static function sandboxAutoload( $classname )
  {

    $length = strlen($classname);
    $requireMe = null;

    $parts = array();
    $start = 0;
    $end = 1;
    $package = '';

    if ( file_exists( SANDBOX_LIB_PATH.$classname.'.php' ) )
    {
      $requireMe = SANDBOX_LIB_PATH.$classname.'.php' ;
    }
    else
    {
      // 3 Stufen Packages
      $level = 0;
      for ( $pos = 1 ; $pos < $length  ; ++$pos )
      {
        if (ctype_upper($classname[$pos]) )
        {
          $package .= strtolower(substr( $classname, $start, $end  )).'/' ;
          $start += $end;
          $end = 0;
          ++$level;

          if ( file_exists( SANDBOX_LIB_PATH.$package.$classname.'.php' ) )
          {
            $requireMe = SANDBOX_LIB_PATH.$package.$classname.'.php' ;
            break;
          }

          if ( $level == MAX_PACKAGE_LEVEL )
          {
            break;
          }
        }
        ++$end;
      }
    }//end if ( file_exists( USER_LIB_PATH.$classname.'.php' ) )


    if ( $requireMe )
    {
      require $requireMe;
    }

  } //end public static function sandboxAutoload( $classname )

  /** The Autoloadfunction
   *
   *  Die Autoloadklasse wir aufgerufen wenn ein Objekt
   *  einer Klasse mit new erstellt werden soll, die Klassendefinition
   *  aber noch nicht bekannt ist.
   *
   *  @param string Name The Name of the Class that needs to be loaded
   */
  public static function autoload( $classname )
  {

    $length = strlen($classname);
    $requireMe = null;

    $parts = array();
    $start = 0;
    $end = 1;
    $package = '';

    if ( file_exists( LIB_PATH.$classname.'.php' ) )
    {
      $requireMe = LIB_PATH.$classname.'.php' ;
    }
    else
    {
      // 3 Stufen Packages
      $level = 0;
      for ( $pos = 1 ; $pos < $length  ; ++$pos )
      {
        if (ctype_upper($classname[$pos]) )
        {
          $package .= strtolower(substr( $classname, $start, $end  )).'/' ;
          $start += $end;
          $end = 0;
          ++$level;

          if ( file_exists( LIB_PATH.$package.$classname.'.php' ) )
          {
            $requireMe = LIB_PATH.$package.$classname.'.php' ;
            break;
          }

          if ( $level == MAX_PACKAGE_LEVEL )
          {
            break;
          }
        }
        ++$end;
      }
    }

    if ( $requireMe )
    {
      require $requireMe;
    }

  } //function public static function autoload( $classname )

  /**
   * Enter description here...
   *
   * @param unknown_type $classname
   */
  public static function notfoundAutoload( $classname )
  {

    $filename = ROOT.'tmp/cnf/'.uniqid().'.tmp';
    $errorText = "Class $classname not Found!";

    $toEval = "
    <?php

    // delete at require
    unlink( '$filename' );

    // throw at require
    throw new SysClassNotFoundException( '$errorText' );

    class $classname
    {
      public function __construct()
      {
        // throw everytime somebody wants to create an object from this
        throw new SysClassNotFoundException( '$errorText' );
      }

    }
    ?>";

    file_put_contents( $filename , $toEval );
    require $filename;

  } //function public static function notfoundAutoload( $classname )

  /**
   * Webfrap Own Error Handler
   *
   * @param unknown_type $errno
   * @param unknown_type $errstr
   * @param unknown_type $errfile
   * @param unknown_type $errline
   * @param unknown_type $errDump
   */
  public static function errorHandler
  (
    $errno,
    $errstr,
    $errfile,
    $errline,
    $errDump
  )
  {

    $errorType = array
    (
    E_ERROR            => 'ERROR',
    E_WARNING          => 'WARNING',
    E_PARSE            => 'PARSING_ERROR',
    E_NOTICE           => 'NOTICE',
    E_CORE_ERROR       => 'CORE_ERROR',
    E_CORE_WARNING     => 'CORE_WARNING',
    E_COMPILE_ERROR    => 'COMPILE_ERROR',
    E_COMPILE_WARNING  => 'COMPILE_WARNING',
    E_USER_ERROR       => 'USER_ERROR',
    E_USER_WARNING     => 'USER_WARNING',
    E_USER_NOTICE      => 'USER_NOTICE',
    E_STRICT           => 'STRICT',
    4096               => 'UNKNOWN ERROR'
    );

    // set of errors for which a var trace will be saved
    $UserErrors = array
    (
    E_USER_ERROR,
    E_USER_WARNING,
    E_USER_NOTICE
    );

    $L[] = microtime(true);
    $L[] = $errorType[$errno];
    $L[] = $errfile;
    $L[] = $errline;
    $L[] = $errstr.': '.SysDebug::dumpToString($errDump);

    $_SESSION['PHPLOG'][] = $L;

  }


}//end class Webfrap


if (ENABLE_FIREPHP)
{
  require_once ROOT.'vendor/FirePHPLibrary/lib/FirePHPCore/fb.php';

  /**
   * Class for emulating Errors as Exceptions
   */
  class wfErrorException
    extends Exception
  {
  }

  /**
   * Error handler class
   */
  class wfErrorHandler {

      /**
       * Error handler options
       *
       * Available options:
       *
       * file - log file
       * mail - log mail
       * ignore_notices - if set to true Error handler ignores notices
       * ignore_warnings - if set to true Error handler ignores warnings
       * display - if set to true Error handler display error to output
       * firebug - if set to true Error handler send error to firebug
       */
      public static $options = array(
      'firebug' => true
      );

      /**
       * Construtor - object cannot be created
       */
      private function __construct () {
      }

      /**
       * Factory method which setup handlers
       *
       * @param array $options Options for Error handler
       */
      static public function create($options = array() )
      {
          if ($options)
          {
            self::$options = $options;
          }

          $flags = E_ALL;
          if (isset($options['ignore_notices'])) {
              $flags = $flags ^ E_NOTICE;
              $flags = $flags ^ E_USER_NOTICE;
          }
          if (isset($options['ignore_warnings'])) {
              $flags = $flags ^ E_WARNING;
              $flags = $flags ^ E_USER_WARNING;
          }

          set_error_handler(array('wfErrorHandler', "errorHandler"), $flags);
          set_exception_handler(array('wfErrorHandler', "exceptionHandler"));
      }

      /**
       * Exception handler
       *
       * @param Exception $ex Exception
       */
      static public function exceptionHandler($ex)
      {
          $errMsg = $ex->getMessage();
          $backtrace = $ex->getTrace();

          if (!$ex instanceof wfErrorHandler) {
              $errMsg = get_class($ex).': '.$errMsg;
              array_unshift($backtrace, array('file'=>$ex->getFile(), 'line'=>$ex->getLine(),
                 'function'=>'throw '.get_class($ex), 'args'=>array($errMsg, $ex->getCode()) ));
          }

          $errMsg .= ' | '.date("Y-m-d H:i:s");
          if (empty($_SERVER['HTTP_HOST'])) {
              $errMsg .= ' | '.implode(' ', $_SERVER['argv']);
          } else {
                  $errMsg .= ' | '.$_SERVER['HTTP_HOST']." (".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].")"."\n";
          }

          $trace = '';
          foreach ($backtrace as $v) {
              $v['file'] = preg_replace('!^'.$_SERVER['DOCUMENT_ROOT'].'!', '' ,$v['file']);
              $trace .= $v['file']."\t".$v['line']."\t";
              if (isset($v['class'])) {
                  $trace .= $v['class'].'::'.$v['function'].'(';
                  if (isset($v['args'])) {
                      $errRow[] = $v['args'];
                      $separator = '';
                      foreach($v['args'] as $arg ) {
                          $trace .= $separator.self::getArgument($arg);
                          $separator = ', ';
                      }
                  }
                  $trace .= ')';
              } elseif (isset($v['function'])) {
                  $trace .= $v['function'].'(';
                  $errRow[] = $v['function'];
                  if (isset($v['args'])) {
                      $errRow[] = $v['args'];
                      $separator = '';
                      foreach($v['args'] as $arg ) {
                          $trace .= $separator.self::getArgument($arg);
                          $separator = ', ';
                      }
                  }
                  $trace .= ')';
              }
              $trace .= "\n";
          }

          if (isset(self::$options['firebug'])) {
              fb($ex);
          }

          if (isset(self::$options['display'])) {
              if (empty($_SERVER['HTTP_HOST'])) {
                  echo "\33[1m".$errMsg."\33[0m"."\n".$trace;
              } else {
                  echo "<"."pre style=\"background: #f55; color: #000; font-weight: bold; font-size: 13px; padding: 10px; margin: 10px; text-align: left; \">\n";
                  echo $errMsg."\n".$trace;
                  echo "<"."/pre>\n";
              }
          }

          if (isset(self::$options['mail'])) {
              $headers = "Content-Type: text/html; charset=utf-8\r\n" .
                  "Content-Transfer-Encoding: 8bit\r\n\r\n";
              @mail(self::$options['mail'], $errMsg, $errMsg."\n".$trace."\n", 'From: Error Handler', $headers);
          }
          if (isset(self::$options['file'])) {
              try {
                  $fp = fopen(self::$options['file'], "a+");
                  if (flock($fp, LOCK_EX)) {
                      fwrite($fp, "----\n".$errMsg."\n".$trace."\n");
                      flock($fp, LOCK_UN);
                  }
                  fclose($fp);
              } catch (Exception $ex) {
                  echo "\nError writing to file: ".self::$options['file']."\n";
              }
          }
          exit(1);
      }

      /**
       * Error handler
       *
       * @param int $errno Error code
       * @param string $errstr Error message
       */
      static public function errorHandler($errno, $errstr)
      {
          if (error_reporting() == 0)
          { // if error has been supressed with an @
              return;
          }
          $errorType = array (
              E_ERROR          => 'ERROR',
              E_WARNING        => 'WARNING',
              E_PARSE          => 'PARSING ERROR',
              E_NOTICE         => 'NOTICE',
              E_CORE_ERROR     => 'CORE ERROR',
              E_CORE_WARNING   => 'CORE WARNING',
              E_COMPILE_ERROR  => 'COMPILE ERROR',
              E_COMPILE_WARNING => 'COMPILE WARNING',
              E_USER_ERROR     => 'USER ERROR',
              E_USER_WARNING   => 'USER WARNING',
              E_USER_NOTICE    => 'USER NOTICE',
              E_STRICT         => 'STRICT NOTICE',
              E_RECOVERABLE_ERROR  => 'RECOVERABLE ERROR'
          );
          $errMsg = $errorType[$errno].': '.$errstr;
          throw new wfErrorException($errMsg);
      }

      /**
       * Converts variable into short text
       *
       * @param mixed $arg Variable
       * @return string
       */

      static protected function getArgument($arg) {
          switch (strtolower(gettype($arg))) {
              case 'string':
                  return( '"'.str_replace( array("\n","\""), array('','"'), $arg ).'"' );
              case 'boolean':
                  return (bool)$arg;
              case 'object':
                  return 'object('.get_class($arg).')';
              case 'array':
                  return 'array['.count($arg).']';
              case 'resource':
                  return 'resource('.get_resource_type($arg).')';
              default:
                  return var_export($arg, true);
          }
      }
  }

  wfErrorHandler::create(array('firebug'=>true));



}


?>