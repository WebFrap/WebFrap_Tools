#!/bin/bash

cd $1

php ./cli.php Daidalos.deploy.syncDatabase sync_col=true delete_col=true  sync_table=true
php ./cli.php Daidalos.deploy.syncData
php ./cli.php Daidalos.deploy.syncMetaData
