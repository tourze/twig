# TWIG组件

途者框架的Twig组件，在Twig原生语法的基础上，增加一些扩展语法。

关于[Twig](http://twig.sensiolabs.org)，如果读者还不太熟悉，可以参考下面链接

1. [Twig的在线文档（英文）](http://twig.sensiolabs.org/documentation)
2. [Twig的PDF文档（英文）](http://twig.sensiolabs.org/pdf/Twig.pdf)
3. [Twig的简明教程（中文）](http://m.blog.csdn.net/blog/benben_1678/43772001)

如果你有发现更好的其他关于Twig的入门教程，欢迎你帮忙补充上去~

关于Twig的基础语法，这里就不赘述了，在这里只讲述本组件中新增的特性。

## 安装

首先需要下载和安装[composer](https://getcomposer.org/)，具体请查看官网的[Download页面](https://getcomposer.org/download/)

在你的`composer.json`中增加：

    "require": {
        "tourze/twig-html-helpers": "^1.0"
    },

或直接执行

    composer require tourze/twig-html-helpers:"^1.0"

## 新特性

### 缓存

感谢[Alexander](mailto:iam.asm89@gmail.com)写的[asm89/twig-cache-extension](https://github.com/asm89/twig-cache-extension)，为我们提供了Twig的缓存解决方案。

一般情况下，如果要对Twig进行缓存处理，我们需要在Twig外部来进行处理，如：

    if ( ! $result = getCache($fileName))
    {
        $result = twigRender($fileName);
        setCache($fileName, $result);
    }
    return $result;

但对于Twig模板的设计者来说，有时候需要自己决定缓存一部分解析结果。
`asm89/twig-cache-extension`为我们的这种需求提供了解决办法：

    {% cache 'v1/summary' 900 %}
        {# 这里存放一些耗时的、需要缓存的代码，输出或者读取其他文件也可以 #}
    {% endcache %}

其中`v1/summary`是这段缓存的标志，`900`是缓存时间（单位：秒）。

你也可以嵌套使用：

    {% cache 'v1' 900 %}
        {% for item in items %}
            {% cache 'v1' item %}
                {# ... #}
            {% endcache %}
        {% endfor %}
    {% endcache %}

缓存标志那里还可以用表达式，用于设置特定的标志：

    {% set version = 42 %}
    {% cache 'hello_v' ~ version 900 %}
        Hello {{ name }}!
    {% endcache %}

### Markdown支持

我个人是个Markdown的重度用户，平时写笔记都不由自觉地使用了Markdown。

个人觉得，掌握Markdown这种标签语言（或其他类似的标签语言），可以有效提高IT从业者的文字书写效率。
Markdown让人能更专注于内容和排版，而暂时忽略样式，从而提高书写效率。

关于Markdown，更多说明可以参考：

1. [献给写作者的 Markdown 新手指南](http://www.jianshu.com/p/q81RER)
2. [Markdown 语法说明 (简体中文版)](http://wowubuntu.com/markdown/)

得益于[Gunnar Lium](mailto:gunnar@aptoma.com)写的[aptoma/twig-markdown](https://github.com/aptoma/twig-markdown)，我们很方便就在组件中集成了Markdown语法。

在本组件中使用Markdown很简单，有两种方式可以选择:

1. 使用过滤器

使用方法如：

    {{ "# Heading Level 1"|markdown }}

假如你的Markdown文本存放在动态变量中，那么使用这种方法可以很方便。

2. 使用标签

使用方法如：

    {% markdown %}# Heading Level 1{% endmarkdown %}

具体使用哪种方法，应视具体情况

### HTML助手方法

本组件封装了[Nicholas Humfrey](http://www.aelius.com/njh/)提供的[njh/twig-html-helpers](https://github.com/njh/twig-html-helpers)，为使用者提供了以下函数，用于方便地生成HTML标签：

* check_box_tag($name, $value = '1', $default = false, $options = array())
* content_tag($name, $content='', $options=array())
* hidden_field_tag($name, $default = null, $options = array())
* html_tag($name, $options=array())
* image_tag($src, $options=array())
* input_tag($type, $name, $value=null, $options=array())
* label_tag($name, $text = null, $options = array())
* labelled_text_field_tag($name, $default = null, $options = array())
* link_tag($title, $url=null, $options=array())
* password_field_tag($name = 'password', $default = null, $options = array())
* radio_button_tag($name, $value, $default = false, $options = array())
* reset_tag($value = 'Reset', $options = array())
* select_tag($name, $options, $default = null, $html_options = array())
* submit_tag($value = 'Submit', $options = array())
* text_area_tag($name, $default = null, $options = array())
* text_field_tag($name, $default = null, $options = array())
