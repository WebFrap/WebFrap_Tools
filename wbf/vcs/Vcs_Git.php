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
 * @subpackage WebFrap
 *
 */
class Vcs_Git
  implements IsAVcsAdapter
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $localPath = null;
  
  /**
   * @var string
   */
  public $userName = null;
  
  /**
   * @var string
   */
  public $userPasswd = null;
  
  /**
   * @var string
   */
  public $displayName = null;
  
  /**
   * @var string
   */
  public $syncUrl = null;
  
/* (non-PHPdoc)
 * @see IsAVcsAdapter::getVersion()
 */
  public function getVersion()
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::getType()
 */
  public function getType()
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::isRepository()
 */
  public function isRepository()
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::commit()
 */
  public function commit($message)
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::status()
 */
  public function status($justCheckChanges = false)
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::update()
 */
  public function update($branch = null)
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::getActualBranch()
 */
  public function getActualBranch()
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::getBranches()
 */
  public function getBranches()
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::switchBranch()
 */
  public function switchBranch($branch)
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::hasBranch()
 */
  public function hasBranch($branch)
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::mergeBranches()
 */
  public function mergeBranches($target, $source, $commitMessage = null)
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::getHead()
 */
  public function getHead($branch)
  {

    // TODO Auto-generated method stub
    
  }

/* (non-PHPdoc)
 * @see IsAVcsAdapter::getHeads()
 */
  public function getHeads()
  {

    // TODO Auto-generated method stub
    
  }

  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////



}// end class Vcs_Mercurial

