#!/bin/bash

wspPath="/var/www/WorkspaceWebFrap/"

cd "${wspPath}SDB_Gw_SBiz"

php ./cli.php Daidalos.deploy.syncDatabase sync_col=true delete_col=true  sync_table=true
php ./cli.php Daidalos.deploy.syncData
php ./cli.php Daidalos.deploy.syncMetaData



