#!/bin/bash

cd $1

# Synchronisieren der Metadaten
php ./cli.php Daidalos.deploy.syncMetaData "root_path=$2"

