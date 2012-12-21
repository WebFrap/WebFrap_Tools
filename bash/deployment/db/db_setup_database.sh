#!/bin/bash
# to be included in a deployment package script

# set the environment variables
export PGUSER=$pgAdminUser
export PGPASSWORD=$pgAdminPwd
export PGHOST=$pgHost
export PGPORT=$pgPort

function pgQuery {

  psql $pgDb -tAc $1

}

function pgCreateDb {

  psql postgres -tAc "create database ${1} with owner = ${2} encoding = 'utf-8';"

}

function pgCreateSchema {

  psql ${1} -tAc "create schema ${2} with owner = ${2} encoding = 'utf-8';"

}