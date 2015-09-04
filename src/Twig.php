<?php

namespace tourze\Twig;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine;
use Asm89\Twig\CacheExtension\CacheProvider\DoctrineCacheAdapter;
use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;
use Doctrine\Common\Cache\ArrayCache;
use tourze\Base\Base;
use tourze\Base\Config;
use tourze\Base\Helper\Arr;
use tourze\Twig\Exception\TwigException;
use tourze\Twig\Loader\ArrayLoader;
use tourze\Twig\Loader\FileLoader;
use Twig_Environment;
use Twig_Extension_HTMLHelpers;
use Twig_LoaderInterface;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * Twig助手类
 *
 * @package tourze\Twig
 */
class Twig extends Base
{

    /**
     * 数组加载器
     */
    const ARRAY_LOADER = 1;

    /**
     * @const 文件加载器
     */
    const FILE_LOADER = 2;

    /**
     * @param array $options
     * @return ArrayLoader|FileLoader
     * @throws \tourze\Twig\Exception\TwigException
     */
    public static function createLoader(array $options)
    {
        $type = Arr::get($options, 'type', 'Array');
        $args = Arr::get($options, 'args', []);

        switch ($type)
        {
            case self::ARRAY_LOADER:
                $instance = new ArrayLoader($args);
                break;
            case self::FILE_LOADER:
                $instance = new FileLoader($args);
                break;
            default:
                throw new TwigException('The requested twig loader not found.');
        }

        return $instance;
    }

    /**
     * @param Twig_LoaderInterface $loader
     * @param array                $options
     * @return Twig_Environment
     */
    public static function createEnvironment(Twig_LoaderInterface $loader, $options)
    {
        $environment = new Twig_Environment($loader, $options);

        // 缓存插件设置
        $cacheProvider  = new DoctrineCacheAdapter(new ArrayCache);
        $cacheStrategy  = new LifetimeCacheStrategy($cacheProvider);
        $cacheExtension = new CacheExtension($cacheStrategy);
        $environment->addExtension($cacheExtension);

        // 增加markdown支持
        $engine = new MichelfMarkdownEngine();
        $environment->addExtension(new MarkdownExtension($engine));

        // 一些额外的html助手方法
        $environment->addExtension(new Twig_Extension_HTMLHelpers);

        // 自定义filter
        foreach (Config::load('twig')->get('filter') as $name => $filter)
        {
            $environment->addFilter(new Twig_SimpleFilter($name, $filter));
        }

        // 自定义函数
        foreach (Config::load('twig')->get('function') as $name => $function)
        {
            $environment->addFunction(new Twig_SimpleFunction($name, $function));
        }

        // 自定义token解析器
        foreach (Config::load('twig')->get('tokenParser') as $name => $tokenParser)
        {
            $environment->addTokenParser(new $tokenParser);
        }

        return $environment;
    }

    /**
     * 获取TWIG组件
     *
     * @return \tourze\Twig\Component\Twig
     * @throws \tourze\Base\Exception\ComponentNotFoundException
     */
    public static function getTwig()
    {
        return self::get('twig');
    }
}
