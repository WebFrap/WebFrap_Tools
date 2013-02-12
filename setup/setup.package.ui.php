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

$console = Zenity::getActive();

include 'setup/base/ui.start.php';
include 'setup/base/ui.base_data.php';
include 'setup/base/ui.deploy_path.php';
include 'setup/base/ui.apache_vhost.php';

$console->out( 'Instaliere in den Pfad '.$conf->deployRoot );

