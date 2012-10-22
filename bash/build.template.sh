#!/bin/bash

wspPath="/var/www/WorkspaceWebFrap/WebFrap_Genf/example/project.bdl"
doku="DokuErd"

cd "${wspPath}WebFrap_Genf/bin"

php ./genf.php Daidalos.Projects.clean "pfile=${wspPath}"
#php ./genf.php Daidalos.Projects.build "pfile=${wspPath}" #"catridges=${doku}"  #| tee ../protocol_build.log 
php ./genf.php Daidalos.Projects.build "pfile=${wspPath}" "cartridges=${1}"
php ./genf.php Daidalos.Projects.deploy "pfile=${wspPath}"



