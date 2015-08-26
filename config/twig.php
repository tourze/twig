<?php

return [

    // Loader选型
    'loader'    => [
        'extension' => 'html',
        'path'      => 'views',
    ],

    // 自定义函数
    'functions' => [
        'arr_get'  => ['\tourze\Base\Helper\Arr', 'get'],
    ],

    // 自定义过滤器
    'filters'   => [
        // 翻译
        'translate' => '__',
        'trans'     => '__',
        'tr'        => '__',
        '__'        => '__',
    ],
];
