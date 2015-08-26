<?php

use tourze\Base\Base;
use tourze\Base\Config;
use tourze\Base\Debug;
use tourze\Base\I18n;
use tourze\Base\Message;
use tourze\Route\Route;
use tourze\Tourze\Asset;
use tourze\View\View;

if ( ! defined('ROOT_PATH'))
{
    define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}

require_once 'vendor/autoload.php';

Base::$cacheDir = ROOT_PATH . 'tmp/cache';
Base::$logConfig = [
    'file' => ROOT_PATH . 'tmp/log/' . date('Y/md') . '.log'
];

// 指定配置加载目录
Config::addPath(ROOT_PATH . 'config' . DIRECTORY_SEPARATOR);

// 语言文件目录
I18n::addPath(ROOT_PATH . 'i18n' . DIRECTORY_SEPARATOR);

// Message目录
Message::addPath(ROOT_PATH . 'message' . DIRECTORY_SEPARATOR);

// 指定视图加载目录
View::addPath(ROOT_PATH . 'view' . DIRECTORY_SEPARATOR);

// 激活调试功能
Debug::enable();

Asset::$version = '20150719';

// 指定控制器命名空间
Route::$defaultNamespace = '\\page\\Controller\\';

// 后台路由
Route::set('admin', 'admin/<action>(/<params>).html', [
    'action' => 'login|logout',
    'params' => '.*',
])->defaults([
    'controller' => 'Admin',
    'action'     => 'index',
]);

// 后台路由
Route::set('page-admin', 'admin/page/<controller>(/<action>(/<params>)).html', [
    //'controller' => 'element|layout|log|Base|Redirect|Snippet',
    'params' => '.*',
])
    ->defaults([
        'controller' => 'Entry',
        'action'     => 'index',
        'directory'  => 'Admin'
    ]);

// 默认路由
Route::set('default', '(<path>)', [
    'path' => '.*',
])
    ->defaults([
        'controller' => 'Base',
        'action'     => 'view',
    ]);

