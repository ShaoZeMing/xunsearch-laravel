# xunsearch-laravel
- 基于XunSearch（讯搜）sdk的Eloquent模型的全文搜索Laravel 5.*软件包，支持全拼，拼音简写，模糊搜索。
- 本包包含xunsearch SDK 所有类文件，在使用本包之前，请认真阅读XunSearch官方文档 <http://www.xunsearch.com/doc/>。本包操作基于官方进行修改封装。

在此简要介绍以下几个文件：

    - lib/XS.php             入口文件，所有搜索功能必须包含此文件
    - util/RequireCheck.php  命令行运行，用于检测您的 PHP 环境是否符合运行条件
    - util/IniWizzaard.php   命令行运行，用于帮助您编写 xunsearch 项目配置文件
    - util/Quest.php         命令行运行，搜索测试工具
    - util/Indexer.php       命令行运行，索引管理工具
    - util/SearchSkel.php    命令行运行，根据配置文件生成搜索骨架代码
    - util/xs                命令行工具统一入口

 - 在开始编写您的代码前强烈建议执行 util/RequireCheck.php 以检查环境。
