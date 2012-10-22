#!/bin/bash

cd $1

# Synchronisieren der Stammdaten in der Datenbank
php ./cli.php Daidalos.deploy.syncData "root_path=$2"
