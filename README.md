# xunsearch-laravel
- 基于XunSearch（讯搜）sdk的Eloquent模型的全文搜索Laravel 5.*软件包，支持全拼，拼音简写，模糊搜索。
- 本包包含xunsearch SDK 所有类文件，在使用本包之前，请认真阅读XunSearch官方文档 <http://www.xunsearch.com/doc/>。本包操作基于官方进行修改封装。
- 本包只提供php封装代码，使用本包前，请自行先安装xunsearch服务端程序。帮助文档：<http://www.xunsearch.com/doc/php/guide/start.installation>

##INI配置文件说明：

如果你开发环境是windows，由于xunsearch服务端只能在linux服务器下运行，你的ini配置文件端口需要加入对应服务端IP地址，如示例代码：

    project.name = demo
    project.default_charset = utf-8
    server.index = 192.168.0.110:8383
    server.search = 192.168.0.110:8384
    [pid]
    type = id

    [subject]
    type = title

    [message]
    type = body

    [chrono]
    type = numeric

请将`192.168.0.110` 修改为你服务端对应的IP。并且服务端启动xs-ctl.sh服务时，启动命令应为： `bin/xs-ctl.sh -b inet start     // 监听在所有本地 IP 地址上`

在此简要介绍以下几个文件：

    - app/demo.php           配置文件样例，请根据自己实际项目更改
    - lib/XS.php             入口文件，所有搜索功能必须包含此文件
    - util/RequireCheck.php  命令行运行，用于检测您的 PHP 环境是否符合运行条件
    - util/IniWizzaard.php   命令行运行，用于帮助您编写 xunsearch 项目配置文件
    - util/Quest.php         命令行运行，搜索测试工具
    - util/Indexer.php       命令行运行，索引管理工具
    - util/SearchSkel.php    命令行运行，根据配置文件生成搜索骨架代码
    - util/xs                命令行工具统一入口
    - wrapper/Search.php     继承XS封装类，利用本类快速操作数据。

 - 在开始编写您的代码前强烈建议执行 util/RequireCheck.php 以检查环境。

# 安装本包
 - 本包虽然针对laravel5.*框架进行封装，当其他框架同样可以使用。

## 方法 1：
执行命令

   composer require shaozeming/xunsearch-laravel "dev-master"

直接运行composer自动安装代码。

## 方法 2：
在项目根目录的下composer.json文件中添加代码 `shaozeming/xunsearch-laravel": "dev-master`

     "require": {
            "php": ">=5.6.4",
            "laravel/framework": "5.3.*",
            "predis/predis": "^1.1",
            "zizaco/entrust": "5.2.x-dev",
            "shaozeming/xunsearch-laravel": "dev-master"
        },

添加在 require 中。然后执行命令：`composer update`。
