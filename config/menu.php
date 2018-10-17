<?php


return [
    'Admin'=>[//顶级导航，键名必须和模块目录同名
        'title'=>'系统',//顶级导航名称
        'channel'=>[//左侧菜单
            'home'=>[
                'title'=>'后台首页',//菜单名称
                'type'=>0,//是否有子菜单
                'uses'=>'App\\Http\\Controllers\\Admin\\IndexController@index',//对应的控制器方法
                'url'=>'/admin/index/index',//对应的跳转链接
            ],
            'system'=>[
                'title'=>'系统模块',
                'type'=>1,
                'list'=>[//子菜单列表
                    ['title'=>'用户管理','uses'=>'App\\Http\\Controllers\\Admin\\AdminController@index','url'=>'/admin/admin'],
                    ['title'=>'角色管理','uses'=>'App\\Http\\Controllers\\Admin\\RoleController@index','url'=>'/admin/role'],
                    ['title'=>'节点管理','uses'=>'App\\Http\\Controllers\\Admin\\NodeController@index','url'=>'/admin/node'],
                ],
            ],
            'article'=>[
                'title'=>'文章模块',
                'type'=>1,
                'list'=>[
                    ['title'=>'文章管理','uses'=>'App\\Http\\Controllers\\Admin\\ArticleController@index','url'=>'/admin/article'],
                    ['title'=>'分类管理','uses'=>'App\\Http\\Controllers\\Admin\\CategoryController@index','url'=>'/admin/category'],
                ],
            ],
        ],
    ],
    'Admin2'=>['title'=>'系统2',],
    'Admin3'=>['title'=>'系统3',],
    'Admin4'=>['title'=>'系统4',],
    'Admin5'=>['title'=>'系统5',],
    'Admin6'=>['title'=>'系统6',],
    'Admin7'=>['title'=>'系统7',],
];