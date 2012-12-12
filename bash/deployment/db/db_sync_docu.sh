#!/bin/bash
# to be included in a deployment package script

# jump in the gateway
cd "${deplPath}/${gatewayName}"

writeLn "Synchronize the docu Database"
/usr/bin/php ./cli.php Daidalos.deploy.syncDocu

# jump back to the package path
cd $packagePath


