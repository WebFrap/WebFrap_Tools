#!/bin/bash
# to be included in a deployment package script

# jump in the gateway
cd "${deplPath}/${gatewayName}"



/usr/bin/php ./cli.php Daidalos.deploy.syncDatabase sync_col=true delete_col=true sync_table=true
/usr/bin/php ./cli.php Daidalos.deploy.syncData
/usr/bin/php ./cli.php Daidalos.deploy.syncMetaData


# jump back to the package path
cd $packagePath


