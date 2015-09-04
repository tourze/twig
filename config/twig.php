<?php

return [

    // 自定义函数
    'function'    => [
        'array_get' => ['\tourze\Base\Helper\Arr', 'get'],
    ],

    // 自定义过滤器
    'filter'      => [
        // 翻译
        'translate' => '__',
        'trans'     => '__',
        'tr'        => '__',
        '__'        => '__',
    ],

    // 自定义token
    'tokenParser' => [],
];
