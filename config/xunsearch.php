<?php
return [


    'default' => 'teacher',   //默认搜索库

    'databases' => [

//        老师搜索库
        'teacher' => [
            'project.name' => 'teacher',
            'project.default_charset' => 'utf-8',
            'server.index' => '127.0.0.1:8383',
            'server.search' => '127.0.0.1:8384',
            'id' => [
                'type' => 'id',
            ],
            'email' => [
                'index' => 'mixed',
            ],
            'name' => [
                'index' => 'mixed',
            ],
            'desc' => [
                'index' => 'mixed',
            ],

        ],


        //学生搜索库
        'student' => [
            'project.name' => 'student',
            'project.default_charset' => 'utf-8',
            'server.index' => '127.0.0.1:8383',
            'server.search' => '127.0.0.1:8384',
            'id' => [
                'type' => 'id',
            ],
            'email' => [
                'index' => 'mixed',
            ],
            'name' => [
                'index' => 'mixed',
            ],
            'desc' => [
                'index' => 'mixed',
            ],

        ],


//        更多...
    ],
];




