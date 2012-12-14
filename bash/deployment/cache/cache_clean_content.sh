#!/bin/bash
# rebuild the complete cache

# jump in the gateway

writeLn "Clean the content cache"

if [ -d "${deplPath}/${gatewayName}/cache/autoload" ]; then
  rm -rf "${deplPath}/${gatewayName}/cache/autoload"
fi
mkdir -p "${deplPath}/${gatewayName}/cache/autoload"
chown -R "$codeOwner" "${deplPath}/${gatewayName}/cache/autoload"

if [ -d "${deplPath}/${gatewayName}/cache/db_resources" ]; then
  rm -rf "${deplPath}/${gatewayName}/cache/db_resources"
fi
mkdir -p "${deplPath}/${gatewayName}/cache/db_resources"
chown -R "$codeOwner" "${deplPath}/${gatewayName}/cache/db_resources"

if [ -d "${deplPath}/${gatewayName}/cache/i18n" ]; then
  rm -rf "${deplPath}/${gatewayName}/cache/i18n"
fi
mkdir -p "${deplPath}/${gatewayName}/cache/i18n"
chown -R "$codeOwner" "${deplPath}/${gatewayName}/cache/i18n"

