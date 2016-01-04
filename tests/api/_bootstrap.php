<?php
// Here you can initialize variables that will be available to your tests
exec('rm ' . __DIR__ . '/../../storage/testing_instance.sqlite');
exec('cp ' . __DIR__ . '/../../storage/testing_stub.sqlite ' . __DIR__ .     '/../../storage/testing_instance.sqlite');