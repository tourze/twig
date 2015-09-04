<?php

namespace tourze\Twig\Component;

use tourze\Base\Component;
use tourze\Twig\Twig as TwigBase;
use Twig_Environment;
use Twig_Loader_Array;
use Twig_LoaderInterface;

/**
 * ArrayLoader的实现
 *
 * @property Twig_Loader_Array loader
 * @property array             loaderOptions
 * @property Twig_Environment  environment
 * @property array             environmentOptions
 * @package tourze\Twig\Component
 */
class Twig extends Component
{

    /**
     * @var Twig_Environment TWIG环境和配置
     */
    protected $_environment;

    /**
     * @return Twig_Environment
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }

    /**
     * @param Twig_Environment $environment
     */
    public function setEnvironment(Twig_Environment $environment)
    {
        $this->_environment = $environment;
    }

    /**
     * @var array 环境选项
     */
    protected $_environmentOptions = [
        'debug'               => false,
        'charset'             => 'UTF-8',
        'base_template_class' => 'Twig_Template',
        'strict_variables'    => false,
        'autoescape'          => 'html',
        'cache'               => false,
        'auto_reload'         => null,
        'optimizations'       => -1,
    ];

    /**
     * @return array
     */
    public function getEnvironmentOptions()
    {
        return $this->_environmentOptions;
    }

    /**
     * @param array $options
     */
    public function setEnvironmentOptions(array $options)
    {
        $this->_environmentOptions = $options;
    }

    /**
     * @var Twig_LoaderInterface 模板加载器
     */
    protected $_loader;

    /**
     * @return Twig_LoaderInterface
     */
    public function getLoader()
    {
        return $this->_loader;
    }

    /**
     * @param Twig_LoaderInterface $twig
     */
    public function setLoader(Twig_LoaderInterface $twig)
    {
        $this->_loader = $twig;
    }

    /**
     * @var array 加载器的配置选项
     */
    protected $_loaderOptions = [];

    /**
     * @return array
     */
    public function getLoaderOptions()
    {
        return $this->_loaderOptions;
    }

    /**
     * @param array $loaderOptions
     */
    public function setLoaderOptions($loaderOptions)
    {
        $this->_loaderOptions = $loaderOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->loader = TwigBase::createLoader($this->loaderOptions);
        $this->environment = TwigBase::createEnvironment($this->loader, $this->environmentOptions);
    }

    /**
     * 渲染模板
     *
     * @param string $name
     * @param array  $context
     * @return string
     */
    public function render($name, array $context = [])
    {
        $template = $this->environment->loadTemplate($name);
        return $template->render($context);
    }
}
