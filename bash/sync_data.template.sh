#!/bin/bash

wspPath="/var/www/workspace/"

cd "${wspPath}WebFrap_Gw_Example"

php ./cli.php Daidalos.deploy.syncDatabase sync_col=true delete_col=true  sync_table=true
php ./cli.php Daidalos.deploy.syncData
php ./cli.php Daidalos.deploy.syncMetaData



