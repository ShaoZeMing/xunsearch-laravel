# xunsearch-laravel
---
[![](https://travis-ci.org/ShaoZeMing/xunsearch-laravel.svg?branch=master)](https://travis-ci.org/ShaoZeMing/xunsearch-laravel) 
[![](https://img.shields.io/packagist/v/ShaoZeMing/xunsearch-laravel.svg)](https://packagist.org/packages/shaozeming/xunsearch-laravel) 
[![](https://img.shields.io/packagist/dt/ShaoZeMing/xunsearch-laravel.svg)](https://packagist.org/packages/stichoza/shaozeming/xunsearch-laravel)


- 旧版本请访问 v1.0[https://github.com/ShaoZeMing/xunsearch-laravel/tree/v1.0.1]


## 前置说明：

### 请先安装xunsearch 服务端：

- 普通编译安装

```

wget http://www.xunsearch.com/download/xunsearch-full-latest.tar.bz2
tar -xjf xunsearch-full-latest.tar.bz2

cd xunsearch-full-1.4.11/
sh setup.sh  
//第一次安装的话，过程可能会稍显漫长，请不必着急，您大可泡杯茶一边喝一边等待即可。
               
cd $prefix ; bin/xs-ctl.sh restart


更多详情请移步：http://www.xunsearch.com/doc/php/guide/start.installation
```

- docker 安装
```$xslt
Docker 方式安装服务端
---------------------

//下载映像：

docker pull hightman/xunsearch

//启动映像：

docker run --name xunsearch -d \
-p 8383:8383 -p 8384:8384 \
-v /var/xunsearch/data:/usr/local/xunsearch/data \
hightman/xunsearch:latest

//以上启动参数可自行修改，该方式仅运行服务端

```



## Installing

```shell
$ composer require shaozeming/xunsearch-laravel -v
```
### Laravel



```php
// config/app.php

    'providers' => [
        //...
        ShaoZeMing\Laravelxunsearch\XunsearchServiceProvider::class,    //This is default in laravel 5.5
    ],
```

And publish the config file: 

```shell
$ php artisan vendor:publish --provider=ShaoZeMing\\LaravelXunsearch\\XunsearchServiceProvider
```

if you want to use facade mode, you can register a facade name what you want to use, for example `xunsearch`: 

```php
// config/app.php

    'aliases' => [
        'xunsearch' => ShaoZeMing\LaravelXunsearch\Facade\Xunsearch::class,   //This is default in laravel 5.5
    ],
```

### lumen

- 在 bootstrap/app.php 中 82 行左右：
```
$app->register( ShaoZeMing\LaravelXunsearch\xunsearchServiceProvider::class);
```
将 `vendor/ShaoZeMing/laravel-xunsearch/config/xunsearch.ini` 拷贝到项目根目录`/config`目录下，并将文件名改成`xunsearch.ini`。


### configuration 

```
// config/demo.ini
project.name = teachers  //名称，建议和文件同名
project.default_charset = utf-8   //字符编码
server.index = 127.0.0.1:8383     //xunsearch 服务器ip:端口
server.search = 127.0.0.1:8384    //xunsearch 服务器ip:端口

//字段类型配置请参考 http://www.xunsearch.com/doc/php/guide/ini.guide
[id]
type = id           

[email]
index = mixed

[name]
index = mixed

[lesson]
index = mixed

[desc]
index = mixed

```



Example:

```php
// 配置文件



        //也可以直接传入ini文件
       $file = your/ini_file_path/dir/demo.ini
       $xs = new XunsearchService($file);
       $data =[
            ['id' => 1, 'email' => '928240096@qq.com', 'name' => 'Shao ZeMing 邵泽明 邵澤明', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，','desc'=>'我是谁，我在哪儿，我要做什么，我不告诉你'],
            ['id' => 2, 'email' => '12315@qq.com', 'name' => 'Chris Dong 董胜君  董勝君', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，演講辯論，speech debate，演讲辩论','desc'=>'如果有一天，我走了，你应该知道我去了哪儿'],
            ['id' => 3, 'email' => 'shao-ze-ming@outlook.com', 'name' => '二傻子 Two fools', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，','desc'=>'最近头发掉的厉害，我该怎么办好呀'],
            ['id' => 4, 'email' => 'szm19920426@qq.com', 'name' => '君莫笑 jun mo xiao 君莫笑', 'lesson' => '写作批改,writing correction,寫作批改,国学经典,National Classics,國學經典','desc'=>'哎呀，脑壳疼，脑壳疼，脑壳疼'],
            ['id' => 5, 'email' => '1270912585@qq.com', 'name' => '李四，li si 李四', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，演講辯論，speech debate，演讲辩论，国学经典,National Classics,國學經典','desc'=>'你知道我对你不静静是喜欢'],
        ];
         

//        Xunsearch::addIndex($data);  //添加索引
        
//        $data = ['id'=>1,'email'=>'123456@ming.com'];
//        Xunsearch::updateIndex($data); 更新索引
        
//        Xunsearch::delIndex($ids); 删除索引
        
//        Xunsearch::cleanIndex(); 清空索引
        
        
//        $res = Xunsearch::search('朗诵');    //默认搜索
//        $res = Xunsearch::setLimit(15)->search('朗诵');  //搜索每页条数
        $res = Xunsearch::setSort('id',true)->setLimit(15)->search('朗诵');  //搜索排序



 print_r($res);
  * @return array  返回数组结构
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
 

 
 /*
 示例结果：
Array
(
    [doc] => Array
        (
            [0] => XSDocument Object
                (
                    [_data:XSDocument:private] => Array
                        (
                            [id] => 1
                            [email] => 928240096@qq.com
                            [name] => Shao ZeMing 邵泽明 邵澤明
                            [lesson] => 朗诵主持,Reciting Hosting,朗誦主持，
                            [desc] => 我是谁，我在哪儿，我要做什么，我不告诉你
                            [255] => 
                        )

                    [_terms:XSDocument:private] => 
                    [_texts:XSDocument:private] => 
                    [_charset:XSDocument:private] => UTF-8
                    [_meta:XSDocument:private] => Array
                        (
                            [docid] => 1
                            [rank] => 1
                            [ccount] => 0
                            [percent] => 100
                            [weight] => 1.1440536975861
                        )

                )

        )

    [hot] => Array
        (
        )

    [count] => 1
    [total] => 5
    [corrected] => Array
        (
        )

    [related] => Array
        (
        )

    [search_cost] => 0.00080204010009766
    [total_cost] => 0.004767894744873
)
 */

```

## License

MIT
