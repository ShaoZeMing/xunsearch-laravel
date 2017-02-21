# xunsearch-laravel
- 基于XunSearch（讯搜）sdk的全文搜索Laravel 5.*包，支持全拼，拼音简写，模糊,同义词搜索。
- 由于本包主要方向为方便快捷，并未对模型进行封装，不仅仅laravel,所有包含composer框架均可使用。
- 本包包含xunsearch SDK 所有类文件，在使用本包之前，建议认真阅读XunSearch官方文档 <http://www.xunsearch.com/doc/>。本包操作基于官方进行修改封装。
- 本包只提供php封装代码，使用本包前，请自行先安装xunsearch服务端程序。帮助文档：<http://www.xunsearch.com/doc/php/guide/start.installation>

##INI配置文件说明：

如果你开发环境是windows或者你php程序并未和xunsearch服务端在同一台服务器上，由于xunsearch服务端只能在linux服务器下运行，你的ini配置文件端口需要加入对应服务端IP地址，如示例代码：

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

++ 注意 ++
请将`192.168.0.110` 修改为你服务端对应的IP。

 - 并且服务端启动xs-ctl.sh服务时，启动命令应为： `bin/xs-ctl.sh -b inet start`     // 监听在所有本地 IP 地址上
 - 并且服务端启动xs-ctl.sh服务时，启动命令应为： `bin/xs-ctl.sh -b inet start`     // 监听在所有本地 IP 地址上
 - 并且服务端启动xs-ctl.sh服务时，启动命令应为： `bin/xs-ctl.sh -b inet start`     // 监听在所有本地 IP 地址上

重要的事情说三遍。

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
 - 本包虽然针对laravel5.*框架进行封装，当然其他带composer框架同样可以使用。

## 方法 1：
执行命令

   `composer require shaozeming/xunsearch-laravel "dev-master"`

直接运行composer自动安装代码。

## 方法 2：
在项目根目录的下composer.json文件中添加代码 `shaozeming/xunsearch-laravel": "dev-master`
```
     "require": {
            "php": ">=5.6.4",
            "laravel/framework": "5.3.*",
            "predis/predis": "^1.1",
            "zizaco/entrust": "5.2.x-dev",
            "shaozeming/xunsearch-laravel": "dev-master"
        },
```
添加在 require 中。然后执行命令：`composer update`。

# 使用说明
本包为了方便使用而生，我将所有几种搜索结果统一封装到类文件wrapper/Search.php 中。对官方SDK文档不熟者也可以快速使用。

文件wrapper/Search.php 类继承核心`XS`类,包好所有`XS`类所有方法属性。如未满足你的需求，可根据官方文档进行自定义。
目前添加属性，方法（持续维护添加）：

属性$config
```
    protected $config = [
        'flushIndex'     => true,       //立即刷新索引
        'setFuzzy'       => true,       //开启模糊搜索
        'autoSynonyms'   => true,       //开启自动同义词搜索功能
    ];
```
构造方法:public function __construct($file, array $config = [])
```
        /**
        * 添加索引数据
        * @author szm19920426@gmail.com
        * $file string  @object@.ini文件
        * $config array  配置数组,参考属性$config
        */
```
添加索引方法：public object addIndex(array $data)
```
        /**
         * 添加索引数据
         *
         * @author szm19920426@gmail.com
         * $data array  一维||二维
         * @return object Index索引对象
         */
```
搜索方法 public function searchAll($string)
```
        /**
         * 搜索方法
         *
         * @author szm19920426@gmail.com
         * $string string  待搜索字符串
         * @return array  返回数组
           return [
                     'doc'           => Object,      //搜索数据结果文档
                     'hot'           => array,       //热门词汇
                     'count'         => int,         //搜索结果统计
                     'total'         => int,         //数据库总数据
                     'corrected'     => array,       //搜索提示
                     'related'       => array,       //相关搜索
                     'search_cost'   => int,         //搜索所用时间
                     'total_cost'    => int,         //页面所用时间
                 ];
         */
```
## 示例代码：

- 就以官方demo.ini配置文件为例：

创建索引，需要添加索引的数据直接以数组形式传入即可，一维二维数组均可，默认为立即索引生效，如需更改，可参考$config属性，在实例化数据对象时以第二个参数传入。
```
            $data=[
      				['pid'=>1,'subject'=>'关于 xunsearch 的 DEMO 项目测试,项目测试是一个很有意思的行为！','chrono'=>'1314336158'],
      				['pid'=>2,'subject'=>'测试第二篇,这里是第二篇文章的内容！','chrono'=>'1314336160'],
      				['pid'=>3,'subject'=>'项目测试第三篇,俗话说，无三不成礼，所以就有了第三篇','chrono'=>'1314336168'],
      				['pid'=>4,'subject'=>'测试安全第四篇,话说，天下，所以就有了孩子','chrono'=>'1314339868'],
      				['pid'=>5,'subject'=>'项目测试第五篇,俗气，非常客气，今天你就这样走了','chrono'=>'1315936168'],
      		];
            $xs = new \shaozeming\xunsearch\Search('demo');
      		$xs->addIndex($data);   //创建索引
```
搜索，默认开启模糊搜索和自动同义词搜索功能（同义词需要自行添加，请参考文档<http://www.xunsearch.com/doc/php/guide/special.synonym>），如需更改，可参考$config属性，在实例化数据对象时以第二个参数传入。
```
            $xs = new \shaozeming\xunsearch\Search('demo');
          	$data=$xs->searchAll('搜索世界'); //查询并返回数组
            /*再次说明返回数据$data格式为：
            $data = [
                                 'doc'           => Object,      //搜索数据结果文档
                                 'hot'           => array,       //热门词汇
                                 'count'         => int,         //搜索结果统计
                                 'total'         => int,         //数据库总数据
                                 'corrected'     => array,       //搜索提示
                                 'related'       => array,       //相关搜索
                                 'search_cost'   => int,         //搜索所用时间
                                 'total_cost'    => int,         //页面所用时间
                             ];
            */
```
请根据自己需要，对放回数据进行操作。

## 说明：

   由于本包主要方向为方便快捷，并未对模型进行封装，不仅仅laravel,所有包含composer框架均可使用。