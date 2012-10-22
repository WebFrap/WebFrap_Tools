#!/bin/bash

apt-get install php5-cli bzip2 postgresql

echo "Erstellen des DB Admin Users, muss mit dem ADMIN User der Conf übereinstimmen"
sudo -u postgres createuser -s -d -r -l -P

mkdir -p /srv/webfrap/setup

cp ./conf.default.php /srv/webfrap/setup/conf.default.php

cd /srv/webfrap/setup

wget --no-check-certificate "https://setup:7jut5rponm75dw3DT@hg.webfrap-servers.de/webfrap/WebFrap_Gaia/archive/tip.tar.bz2"

tar xjvf ./tip.tar.bz2

mv ./WebFrap_Gaia-* ./WebFrap_Gaia

cd ./WebFrap_Gaia
mkdir -p /srv/webfrap/setup/WebFrap_Gaia/conf

cp /srv/webfrap/setup/conf.default.php /srv/webfrap/setup/WebFrap_Gaia/conf/conf.default.php

php ./setup.php
 



