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
 * Die Gaia Command Console
 * Über die Gaia Console lassen sich systeme verwalten
 */

// definieren, dass dies ein Syncscript ist
define('GAIA_CONTEXT', 'console');


// die Basis Logik einbinden
include 'wbf/bootstrap.cli.php';

/* @var $console UiConsole  */
/* @var $request IsARequest  */

if (!$request->flag('s'))
{
  $console->out("Welcome to GAIA");
  $console->out("What do you want to do?");
}


$conClass = $request->service.'_Controller';

if (Gaia::classLoadable($conClass))
{
  $controller = new $conClass();
  /* @var $controller MvcController   */
  $controller->setRequest($request);
  $controller->setConsole($console);
  
  try 
  {
    $controller->execute($request->action);
  }
  catch(GaiaException $exc)
  {
    $console->error($exc->getMessage());
  }
}
else 
{
  $controller = new Error_Controller();
  /* @var $controller MvcController   */
  $controller->setRequest($request);
  $controller->setConsole($console);
  
  try 
  {
    $controller->missingService($request->service);
  }
  catch(GaiaException $exc)
  {
    $console->error($exc->getMessage());
  }
}

exit(0);





