#!/bin/bash
php artisan updateGeoDB
rm storage/testing_stub.sqlite
touch storage/testing_stub.sqlite
php artisan migrate --database="sqlite_setup" --env="testing"
php artisan migrate:refresh --database="sqlite_setup" --env="testing" --seed
./vendor/bin/codecept build
./vendor/bin/codecept run api,unit,functional --coverage-xml --coverage-html
./vendor/bin/phpmd app/ html codesize,unusedcode,naming,cleancode,design  --reportfile tests/_output/phpmd.html
