#!/bin/bash
# to be included in a deployment package script

# set the environment variables
export PGUSER=$pgAdminUser
export PGPASSWORD=$pgAdminPwd
export PGHOST=$pgHost
export PGPORT=$pgPort

function pgBackup {

  # make sure the backup path exists
  mkdir -p "{$backupPath}/db/"

  /usr/bin/pg_dump --host $pgHost \
    --port $pgPort \
    --username $pgAdminUser \
    --format custom \
    --file "{$backupPath}/db/{$pgDb}-{$pgSchema}.backup" \
    --schema "{$pgSchema}" "{$pgDb}"


}
