#!/bin/bash
# rebuild the complete cache

# jump in the gateway

writeLn "Clean the content cache"

if [ -d "${deplPath}/${gatewayName}/cache/autoload" ]; then
  rm -rf "${deplPath}/${gatewayName}/cache/autoload"
fi

if [ -d "${deplPath}/${gatewayName}/cache/db_resources" ]; then
  rm -rf "${deplPath}/${gatewayName}/cache/db_resources"
fi

if [ -d "${deplPath}/${gatewayName}/cache/i18n" ]; then
  rm -rf "${deplPath}/${gatewayName}/cache/i18n"
fi

