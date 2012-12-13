#!/bin/bash
# to be included in a deployment package script

writeLn "Start the docu -> db sync"

# jump in the gateway
writeLn "Change directory into the gateway location: ${deplPath}/${gatewayName}"
cd "${deplPath}/${gatewayName}"

writeLn "Synchronize the docu Database"
/usr/bin/php ./cli.php Daidalos.deploy.syncDocu

# jump back to the package path
writeLn "Change directory back to the package location: $packagePath"
cd $packagePath


