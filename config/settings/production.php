<?php

return array(
    'phpSettings' => array(
        'display_startup_errors' => false,
        'display_errors' => false,
        'date' => array(
            'timezone' => 'America/New_York'
        )
    ),
    'bootstrap' => array(
        'path' => APPLICATION_PATH . '/Bootstrap.php'
    ),
    'autoloadernamespaces' => array(
        'Doctrine\\'
    ),
    'resources' => array(
        'frontController' => array(
            'moduleDirectory' => APPLICATION_PATH,
            'env' => APPLICATION_ENV,
            'actionHelperPaths' => array(
                'Epixa\\Controller\\Helper\\' => 'Epixa/Controller/Helper'
            )
        ),
        'doctrine' => array(
            'proxy' => array(
                'directory' => APPLICATION_ROOT . '/data/proxies'
            ),
            'connection'   => array(
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => 'epixaforumdb',
                'user'     => 'productionusr',
                'password' => 'productionpass'
            )
        ),
        'modules' => array(),
        'router' => array(
            'file' => APPLICATION_ROOT . '/config/routes.php'
        ),
        'view' => array(),
        'layout' => array(
            'layoutPath' => APPLICATION_ROOT . '/layouts',
            'layout' => 'default'
        )
    )
);