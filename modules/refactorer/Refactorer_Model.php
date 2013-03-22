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
class Refactorer_Model
  extends MvcModel
{
  
  /**
   * @param string $search
   * @param string $replace
   * @param string $path
   * @param string $ending
   */
  public function refactor( $search, $replace, $path, $ending = null )
  {
    
    
    $files = new IoFileIterator
    (
      $path,
      IoFileIterator::RELATIVE,
      true,
      $ending
    );
    
    $html = '';
    
    foreach( $files as $file )
    {
      
      $orig = str_replace( "\r\n", "\n", file_get_contents( $file ));
      $search  = str_replace( "\r\n", "\n" , $search );
      $replace = str_replace( "\r\n", "\n" , $replace );
      
      $new  = str_replace( $search ,$replace, $orig );
      
      //$new  = str_replace( "\r\n", "\n" , $orig );
      
      if ( $orig != $new )
      {
        file_put_contents( $file, $new );
        $html .= "Changed: $file<br />".NL;
      }
      else 
      {
        $html .= "Ignored: $file<br />".NL;
      }
    }

    return $html;
    
  }//end public function refactor */


}//end class Refactorer_Model */
