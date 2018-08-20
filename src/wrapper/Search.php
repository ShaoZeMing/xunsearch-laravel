<?php
/**
 * Created by PhpStorm.
 * User: 4d4k
 * Date: 2017/2/10
 * Time: 17:30
 */

namespace shaozeming\xunsearch;

/**
 * 封装所有功能类
 *
 * @author szm19920426@gmail.com
 * @link http://www.4d4k.com/
 * @version $Id$
 */
class Search extends \XS
{
    protected $config = [
        'flushIndex'     => true,       //立即刷新索引
        'setFuzzy'       => true,       //开启模糊搜索
        'autoSynonyms'   => true,       //开启自动同义词搜索功能
    ];

    public function __construct($file, array $config = [])
    {
        parent::__construct($file);

        if(!empty($config)){
            $this->config = array_merge($this->config,$config);
        }
    }

    /**
     * 设置配置属性
     *
     * @author szm19920426@gmail.com
     * $data string  设置配置属性键名
     * $value bool   设置是否开启
     * @return mixed
     */
     public function setConfig($attr,$value){
         if(isset($this->config[$attr])){
             $this->config[$attr]=$value;
             return $this;
         }else{
             return false;
         }
     }


    /**
     * 添加索引数据
     *
     * @author szm19920426@gmail.com
     * $data array  一维||二维
     * @return mixed
     */
    public function addIndex(array $data)
    {
        if (!array($data)) {
            die('参数错误！');
        }
        if (count($data) == count($data, 1)) {
            // 一维数组
            $this->getIndex()->add(new \XSDocument($data));
        } else {
            // 多维数组
            foreach ($data as $v) {
                $this->getIndex()->add(new \XSDocument($v));
            }
        }

        //索引是否立即生效
        if ($this->config['flushIndex']) {
            $this->getIndex()->flushIndex();
        }

        return $this->getIndex();
    }
    
    
        /**
     * 更新索引数据
     *
     * @author szm19920426@gmail.com
     * $data array  一维
     * @return mixed
     */
    public function updateIndexOne(array $data)
    {
        if (!array($data)) {
            die('参数错误！');
        }
        if (count($data) == count($data, 1)) {
            // 一维数组
            $this->getIndex()->update(new \XSDocument($data));
        } 

        //索引是否立即生效
        if ($this->config['flushIndex']) {
            $this->getIndex()->flushIndex();
        }

        return $this->getIndex();
    }
    
    

    /**
     * 搜索方法
     *
     * @author szm19920426@gmail.com
     * $string string
     * @return mixed
     */
    public function searchAll($string)
    {
        if (!is_string($string)) {
            die('参数错误！');
        }
        // other variable maybe used in tpl
        $count = $total = $search_cost = 0;
        $doc = $related = $corrected = $hot = [];
        $total_begin = microtime(true);
        $search = $this->getSearch();

        //热门词汇
        $hot = $search->getHotQuery();

        // fuzzy search 模糊搜索
        $search->setFuzzy($this->config['setFuzzy']);

        // synonym search
        $search->setAutoSynonyms($this->config['autoSynonyms']);

        // set query
        $search->setQuery($string);

        // get the result
        $search_begin = microtime(true);
        $doc = $search->search();
        $search_cost = microtime(true) - $search_begin;

        // get other result
        $count = $search->getLastCount();    //最近一次搜索结果数
        $total = $search->getDbTotal();      //数据库总数

//            $corrected = $this->getSearch()->getCorrectedQuery();      //模糊词搜索
//            if (count($doc) < 10) {
//                foreach ($corrected as $v) {
//                    $doc = array_merge($doc, $this->getSearch()->search($v));
//                }
//

        // try to corrected, if resul too few
        if ($count < 1 || $count < ceil(0.001 * $total)) {
            $corrected = $search->getCorrectedQuery();
        }
        // get related query
        $related = $search->getRelatedQuery();
        $total_cost = microtime(true) - $total_begin;

        return [
            'doc'           => $doc,                    //搜索数据结果文档
            'hot'           => $hot,                    //热门词汇
            'count'         => $count,                  //搜索结果统计
            'total'         => $total,                  //数据库总数据
            'corrected'     => $corrected,             //搜索提示
            'related'       => $related,               //相关搜索
            'search_cost'   => $search_cost,          //搜索所用时间
            'total_cost'    => $total_cost,           //页面所用时间
        ];


    }
}
