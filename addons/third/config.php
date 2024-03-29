<?php

return [
    [
        'name' => 'qq',
        'title' => 'QQ',
        'type' => 'array',
        'content' => [
            'app_id' => '',
            'app_secret' => '',
            'scope' => 'get_user_info',
        ],
        'value' => [
            'app_id' => 'wxc4765d8f36ce8f08',
            'app_secret' => 'f8a2df4e287ee0f94edbd15775de7d56',
            'scope' => 'get_user_info',
        ],
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'wechat',
        'title' => '微信公众号',
        'type' => 'array',
        'content' => [
            'app_id' => '',
            'app_secret' => '',
            'callback' => '',
            'scope' => 'snsapi_base',
        ],
        'value' => [
            'app_id' => '100000000',
            'app_secret' => '123456',
            'scope' => 'snsapi_userinfo',
        ],
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'weibo',
        'title' => '微博',
        'type' => 'array',
        'content' => [
            'app_id' => '',
            'app_secret' => '',
            'scope' => 'get_user_info',
        ],
        'value' => [
            'app_id' => '100000000',
            'app_secret' => '123456',
            'scope' => 'get_user_info',
        ],
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'bindaccount',
        'title' => '账号绑定',
        'type' => 'radio',
        'content' => [
            1 => '开启',
            0 => '关闭',
        ],
        'value' => '1',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => 'PC端是否开启账号绑定，关闭则自动创建账号',
        'extend' => '',
    ],
    [
        'name' => 'status',
        'title' => 'PC端第三方登录开关',
        'type' => 'checkbox',
        'content' => [
            'qq' => 'QQ',
            'wechat' => '微信',
            'weibo' => '微博',
        ],
        'value' => '',
        'rule' => '',
        'msg' => '',
        'tip' => '',
        'ok' => 'PC端第三方登录开关',
        'extend' => '',
    ],
    [
        'name' => 'rewrite',
        'title' => '伪静态',
        'type' => 'array',
        'content' => [],
        'value' => [
            'index/index' => '/third$',
            'index/connect' => '/third/connect/[:platform]',
            'index/callback' => '/third/callback/[:platform]',
            'index/bind' => '/third/bind/[:platform]',
            'index/unbind' => '/third/unbind/[:platform]',
        ],
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
];
