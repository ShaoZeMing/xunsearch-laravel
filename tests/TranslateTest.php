<?php
/**
 *  TestSms.php
 *
 * @author szm19920426@gmail.com
 * $Id: TestSms.php 2017-08-17 上午10:08 $
 */

namespace ShaoZeMing\LaravelTranslate\Test;
use PHPUnit\Framework\TestCase;
use ShaoZeMing\Translate\TranslateService;
use ShaoZeMing\Xunsearch\XunsearchService;


class TranslateTest extends TestCase
{
    protected $instance;

    public function setUp()
    {

        $file =  dirname(__DIR__) .'/config/xunsearch.ini';
        $this->instance = new XunsearchService($file);
    }


    public function testPushManager()
    {
        $this->assertInstanceOf(XunsearchService::class, $this->instance);
    }


    public function testSearch()
    {
        echo PHP_EOL . "添加索引中...." . PHP_EOL;
        try {

            $data = $this->gieData();
//            print_r($data);

//            $result =  $this->instance->addIndex($data);
            $result = $this->instance->search('泽明邵');
//            $result =  $this->instance->delIndex('3');
//            $result =  $this->instance->cleanIndex();

            print_r($result);
            return $result;
        } catch (\Exception $e) {
            $err = "Error : 错误：" . $e->getMessage();
            echo $err . PHP_EOL;

        }
    }


    /**
     * User: ZeMing Shao
     * Email: szm19920426@gmail.com
     * @return array
     */
    public function gieData()
    {
        $data =[
            ['id' => 1, 'email' => '928240096@qq.com', 'name' => 'Shao ZeMing 邵泽明 邵澤明', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，','desc'=>'我是谁，我在哪儿，我要做什么，我不告诉你'],
            ['id' => 2, 'email' => '12315@qq.com', 'name' => 'Chris Dong 董胜君  董勝君', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，演講辯論，speech debate，演讲辩论','desc'=>'如果有一天，我走了，你应该知道我去了哪儿'],
            ['id' => 3, 'email' => 'shao-ze-ming@outlook.com', 'name' => '二傻子 Two fools', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，','desc'=>'最近头发掉的厉害，我该怎么办好呀'],
            ['id' => 4, 'email' => 'szm19920426@qq.com', 'name' => '君莫笑 jun mo xiao 君莫笑', 'lesson' => '写作批改,writing correction,寫作批改,国学经典,National Classics,國學經典','desc'=>'哎呀，脑壳疼，脑壳疼，脑壳疼'],
            ['id' => 5, 'email' => '1270912585@qq.com', 'name' => '李四，li si 李四', 'lesson' => '朗诵主持,Reciting Hosting,朗誦主持，演講辯論，speech debate，演讲辩论，国学经典,National Classics,國學經典','desc'=>'你知道我对你不静静是喜欢'],
        ];
        return $data;
    }
}
