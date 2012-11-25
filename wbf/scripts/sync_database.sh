#!/bin/bash

cd $1

# Synchronisieren der Datenbank Struktur
php ./cli.php Daidalos.deploy.syncDatabase sync_col=true delete_col=true  sync_table=true "root_path=$2"

