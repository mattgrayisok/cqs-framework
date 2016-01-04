#!/usr/bin/env bash

echo "provision"
apt-get update
apt-get -y install php5 php5-curl php5-mysql php5-sqlite php5-cgi php5-mcrypt php5-readline pkg-config libcairo2-dev libjpeg-dev python-software-properties python g++ make php5-xdebug php5-memcached memcached imagemagick graphicsmagick unzip sshpass

echo xdebug.max_nesting_level = 1000 >> /etc/php5/mods-available/xdebug.ini

curl -sS https://getcomposer.org/installer | php

curl -sL https://deb.nodesource.com/setup | sudo bash -
apt-get -y install nodejs build-essential
npm install -g npm
npm cache clean