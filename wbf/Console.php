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
 * Ausgabe in die Console
 * @package WebFrap
 * @subpackage Gaia
 */
class Console
{
  
  /**
   * @var IsAConsole
   */
  private static $active = null;
  
  /**
   * @return IsAConsole
   */
  public static function getActive()
  {
    return self::$active;
  }//end public static function getActive */
  
  /**
   * @param IsAConsole $console
   */
  public static function setActive( IsAConsole $console )
  {
    self::$active = $console;
  }//end public static function setActive */
  
////////////////////////////////////////////////////////////////////////////////
// Static functions
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Einfach ausgabe des Textes
   * @param string $text
   */
  static function in(   )
  {
    
    return fgets(STDIN);
    
  }//end static function in */
  
  /**
   * Nicht sichbare eingabe
   * @return string
   */
  static function secretIn(   )
  {
    
    system('stty -echo');
    $password = trim(fgets(STDIN));
    system('stty echo');
    // add a new line since the users CR didn't echo
    echo "\n";
        
    return $password;
    
  }//end static function in */
  
  /**
   * Einfach ausgabe des Textes
   * @param string $text
   */
  static function out( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    echo $text;
    flush();
    
  }//end static function out */
  
  /**
   * Neue Zeile schreiben
   * @param string $text
   */
  static function outl( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
      echo $text.NL;
    else 
      echo $text.NL."<br />";
    
    flush();
    
  }//end static function outl */
  
  /**
   * Neue Zeile schreiben
   * @param string $text
   */
  static function outln( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
      echo $text.NL;
    else 
      echo $text.NL."<br />";
    
    flush();
    
  }//end static function outln */
  
  /**
   * Ausgabe eines Fehlers
   * @param string $text
   */
  static function error( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
    {
      fwrite( STDERR, 'ERROR: '.$text.NL );
    }
    else 
    {
      echo '<p style="color:red;" >ERROR: '.$text.'</p>'.NL;
      flush();
    }
  
  }//end static function error */
  
  /**
   * Head Bereich
   * @param string $text
   */
  static function header( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
    {
      echo "################################################################################".NL;
      echo "# ".$text.NL;
      echo "################################################################################".NL;
    }
    else 
    {
      echo "<h1>".$text."<h1>".NL;
    }
    
    flush();
    
  }//end static function header */
  
  /**
   * Head Bereich
   * @param string $text
   */
  static function chapter( $text, $appendDate = false )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
    {
      echo "| ".$text.NL;
      echo "|_______________________________________________________________________________".NL;
    }
    else 
    {
      echo "<h2>".$text."<h2>".NL;
    }
    
    flush();
    
  }//end static function chapter */
  
  /**
   * Head Bereich
   * @param string $text
   */
  static function footer( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
    {
      echo "________________________________________________________________________________".NL;
      echo "|".NL;
      echo "| ".$text.NL;
      echo "|_______________________________________________________________________________".NL;
    }
    else 
    {
      echo "<br /><strong>".$text."<strong><br />".NL;
    }
    
    flush();
    
  }//end static function head */
  
  /**
   * Block Starten
   */
  static function startBlock( )
  {
    
    if( IS_CLI )
    {
      //echo "--------------------------------------------------------------------------------".NL;
      echo NL;
    }
    else 
    {
      echo "<pre>".NL;
    }
    
    flush();
    
  }//end static function chapter */
  
  /**
   * Block beenden
   */
  static function endBlock( )
  {
    
    if( IS_CLI )
    {
      //echo "--------------------------------------------------------------------------------".NL;
      echo NL.NL;
    }
    else 
    {
      echo "</pre>".NL;
    }
    
    flush();
    
  }//end static function endBlock */
  
}//end class Console */
