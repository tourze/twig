<?php

use tourze\Twig\Twig;

return [

    'component' => [
        'twig' => [
            'class'  => 'tourze\Twig\Component\Twig',
            'params' => [
                'loaderOptions' => [
                    'type' => Twig::FILE_LOADER,
                    'args' => [],
                ],
            ],
            'call'   => [
            ],
        ],
    ],

];
