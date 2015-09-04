<?php

namespace tourze\Twig\Component;

use tourze\Base\Component;
use tourze\Twig\Twig;
use Twig_Environment;
use Twig_Loader_Array;

/**
 * ArrayLoader的实现
 *
 * @property array             templates
 * @property array             options
 * @property Twig_Loader_Array loader
 * @property Twig_Environment  environment
 * @package tourze\Twig\Component
 */
class TwigArrayLoader extends Component
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
    protected $_options = [
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
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->_options = $options;
    }

    /**
     * @var Twig_Loader_Array 模板加载器
     */
    protected $_loader;

    /**
     * @return Twig_Loader_Array
     */
    public function getLoader()
    {
        return $this->_loader;
    }

    /**
     * @param Twig_Loader_Array $twig
     */
    public function setLoader(Twig_Loader_Array $twig)
    {
        $this->_loader = $twig;
    }

    /**
     * @var array 模板列表
     */
    protected $_templates = [];

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->_templates;
    }

    /**
     * @param array $templates
     */
    public function setTemplates(array $templates)
    {
        $this->_templates = $templates;

        // 设置模板时，顺便写到twig
        // 先清空loader
        $this->loader = new Twig_Loader_Array([]);
        foreach ($this->_templates as $name => $content)
        {
            $this->addTemplate($name, $content);
        }
    }

    /**
     * 增加模板
     *
     * @param string $name
     * @param mixed  $content
     */
    public function addTemplate($name, $content)
    {
        $this->_templates[$name] = $content;
        $this->loader->setTemplate($name, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->loader = new Twig_Loader_Array([]);
        $this->environment = Twig::createEnvironment($this->loader, $this->options);
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
