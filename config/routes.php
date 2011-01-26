<?php

return array(
    'post-action' => array(
        'route' => 'post/:action/*',
        'defaults' => array(
            'module' => 'post',
            'controller' => 'post',
            'action' => 'index'
        ),
    ),
    'post-view' => array(
        'route' => 'post/:id',
        'defaults' => array(
            'module' => 'post',
            'controller' => 'post',
            'action' => 'view'
        ),
        'reqs' => array(
            'id' => '\d+'
        )
    )
);