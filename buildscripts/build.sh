#!/usr/bin/env bash

php composer.phar install
npm install
./node_modules/.bin/gulp --production