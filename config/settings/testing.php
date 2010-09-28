<?php

$config = require 'production.php';

$config['phpSettings']['display_startup_errors'] = true;
$config['phpSettings']['display_errors']         = true;

$config['resources']['doctrine']['connection']['user']     = 'testingusr';
$config['resources']['doctrine']['connection']['password'] = 'testingpass';

return $config;