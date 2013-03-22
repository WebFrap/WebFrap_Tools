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
class Install_Model
  extends MvcModel
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $tmpPath = null;
  
  /**
   * der Package Bdl Knoten
   * @var Package
   */
  public $packageNode = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $packagePath
   * @return Package $package
   */
  public function getPackageNode($packagePath)
  {
    
    $console = $this->getConsole();
    
    if (!Fs::exists($packagePath))
    {
      $console->error("Konnte kein Paket unter ".$packagePath.' finden.');
    }
    
    if (Fs::isA($packagePath, 'package') || Fs::isA($packagePath, 'zip'))
    {
      $archive = new ArchiveZip($packagePath, ArchiveZip::MODE_HUGE);
      $tmp     = Gaia::mkTmpFolder();
      $this->tmpPath = $tmp;
      $archive->extractMetaFile('package.bdl', $tmp.'package.bdl');
      $package = new Package($tmp.'package.bdl');
      
      if (!$package->isLoaded())
      {
        Fs::del($tmp);
        throw new GaiaException('Konnte die '.$tmp.'package.bdl nicht laden');
      }
      
      $package->setDataPath($tmp);

    }
    else 
    {
      $package = new Package($packagePath);
      
      if (!$package->isLoaded())
      {
        Fs::del($tmp);
        throw new GaiaException('Konnte '.$packagePath.' nicht laden');
      }
    }


    
    
    return $package;
      
  }//end public function getPackageNode */
  
  /**
   * @param string $packagePath
   * @return Package $package
   */
  public function getPackage($packagePath)
  {
    
    $console = $this->getConsole();
    
    if (!Fs::exists($packagePath))
    {
      $console->error("Konnte kein Paket unter ".$packagePath.' finden.');
    }
    
    $archive = new ArchiveZip($packagePath, ArchiveZip::MODE_HUGE);
    $tmp     = Gaia::mkTmpFolder();
    $this->tmpPath = $tmp;
    $archive->extractMetaFile('package.bdl', $tmp);
    $archive->unpack($tmp);
    
    $package = new Package($tmp.'package.bdl');
    
    if (!$package->isLoaded())
    {
      Fs::del($tmp);
      throw new GaiaException('Konnte die '.$tmp.'package.bdl nicht laden');
    }
    
    $package->setDataPath($tmp);
    
    return $package;
      
  }//end public function getPackage */
  
  /**
   * löschen des Temporären pfades
   */
  public function cleanTmp()
  {
    
    Fs::del($this->tmpPath);
    
  }//end public function cleanTmp */

}//end class Install_Model */
