<?php

namespace tourze\Twig;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine;
use Asm89\Twig\CacheExtension\CacheProvider\DoctrineCacheAdapter;
use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;
use Doctrine\Common\Cache\ArrayCache;
use tourze\Base\Config;
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
class Twig
{

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
     * 输出指定内容
     *
     * @param string $fileName
     * @param array  $context
     */
    public static function render($fileName, array $context)
    {
    }

}
