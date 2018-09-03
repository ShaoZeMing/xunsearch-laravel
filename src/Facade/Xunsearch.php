<?php

namespace ShaoZeMing\LaravelXunsearch\Facade;



use Illuminate\Support\Facades\Facade;
use ShaoZeMing\Xunsearch\XunsearchService;


/**
 * Class Facade
 * @package Shaozeming\GeTui
 */
class Xunsearch extends Facade
{
    public static function getFacadeAccessor()
    {
        return XunsearchService::class;
    }
}