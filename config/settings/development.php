<?php

$config = require 'production.php';

$config['phpSettings']['display_startup_errors'] = true;
$config['phpSettings']['display_errors']         = true;

$config['db']['username'] = 'root';
$config['db']['password'] = 'root';

return $config;