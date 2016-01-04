#!/usr/bin/env bash

#Create testing databases
rm storage/testing_stub.sqlite
touch storage/testing_stub.sqlite
php artisan migrate --database="sqlite_setup" --env="testing"
php artisan migrate:refresh --database="sqlite_setup" --env="testing" --seed

#Download GeoDB
php artisan updateGeoDB

#Run tests
./vendor/bin/codecept build
./vendor/bin/codecept run api,unit,functional --coverage-html
./vendor/bin/phpmd app/ html codesize,unusedcode,naming,cleancode,design  --reportfile tests/_output/phpmd.html

#Export test files to public location
DATE=$(date +%Y%m%d_%H%M%S)
COMMIT=$(git log -1 --format="%h")
DIRECTORY=${PWD##*/}

### Output files can be uploaded somewhere here or gitlabCI can do this for you