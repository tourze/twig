<?php

namespace tourze\Twig;

use Exception;
use tourze\Base\Config;
use tourze\Twig\Loader\File;
use tourze\View\Base;
use Twig_Environment;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * Twig视图
 */
class Twig extends Base
{

    /**
     * Twig environment
     */
    protected static $_environment = null;

    /**
     * @var string
     */
    public static $ext = '.twig';

    /**
     * 创建一个twig环境变量
     *
     * @param mixed $loader
     * @return Twig_Environment
     */
    public static function generateEnvironment($loader = null)
    {
        $config = Config::load('twig');

        if ($loader === null)
        {
            $loader = new File($config->get('loader'));
        }

        $env = new Twig_Environment($loader, $config->get('environment'));

        foreach ($config->get('functions') as $key => $value)
        {
            $function = new Twig_SimpleFunction($key, $value);
            $env->addFunction($function);
        }

        foreach ($config->get('filters') as $key => $value)
        {
            $filter = new Twig_SimpleFilter($key, $value);
            $env->addFilter($filter);
        }

        return $env;
    }

    /**
     * 创建环境变量
     *
     * @return  Twig_Environment  Twig environment
     */
    protected static function environment()
    {
        if (static::$_environment === null)
        {
            static::$_environment = self::generateEnvironment();
        }
        return static::$_environment;
    }

    /**
     * 获取视图的最终输入
     *
     * @param  string $viewFilename 文件名
     * @param  array  $viewData     变量
     * @return string
     * @throws Exception
     */
    protected function capture($viewFilename, array $viewData)
    {
        return static::environment()->render($viewFilename, $viewData);
    }
}
