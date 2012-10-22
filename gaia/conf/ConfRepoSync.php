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
class ConfRepoSync
  extends TArray
{
    
  /**
   * Der Benötigte Username für den Zugriff auf die Repositories soweit
   * ein einheitlicher Access vorhanden ist
   * @var string
   */
  public $repoUser     = null;
  
  /**
   * Das benötigte Passwort für den Zugriff auf die Repositories soweit
   * ein einheitlicher Access vorhanden ist
   * @var string
   */
  public $repoPwd      = null;

  /**
   * Der Benutzer welchem das Repository zugeordnet werden soll
   * @var string
   */
  public $repoOwner    = null;

  /**
   * Der Name welcher bei Commits für den Sync angezeigt wird
   * @var string
   */
  public $displayName  = null;

  /**
   * Die Commitmessage welche bei Auto Sync Commits angegeben wird
   * @var string
   */
  public $commitMessage  = '"- this is an auto commit for synchronizing the repository with the master"';

  /**
   * Die Mailadresse welche in geclonten Repositories hinterlegt wird
   * @var string
   */
  public $contactMail    = null;
  
  /**
   * Liste mit den Repositories die gesynct werden sollen
   * @var array
   */
  public $repositories = array();

} // end class ConfRepoSync


