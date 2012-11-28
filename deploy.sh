#!/bin/bash
# simple deployment script

deplPath="/var/www/"

echo "\[\033[1;32m\]Starting deployment to \[\033[1;34m\]${deplPath}"

if [ "$(whoami)" != "root" ];
then
   echo "\[\033[0;31m\]Script need to be started as root\[\033[0m\]"
   exit
fi

function deploy {

  deplPath="/var/www/"
  fPath='./files/'
  
  echo "\[\033[1;33m\]deploy \[\033[1;34m\]${1} \[\033[1;30m\]to \[\033[1;34m\]${deplPath}${1}" 

  if [ ! -d "${deplPath}${1}/" ]; then
      mkdir -p ${deplPath}${1}/
  fi

  cp -f "${fPath}${1}" "${deplPath}${1}"
}


deploy fuu/bar/fuu.php

echo "\[\033[1;32m\]Done\[\033[0m\]"
