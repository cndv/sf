<?php

return [
    [
        'name' => 'LiteName',
        'title' => '小程序名称',
        'type' => 'string',
        'content' => [],
        'value' => 'Fa商城微信小程序',
        'rule' => 'required',
        'msg' => '',
        'tip' => '小程序顶部展示标题',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'TopTextColor',
        'title' => '小程序标题颜色',
        'type' => 'radio',
        'content' => [
            10 => '黑色',
            20 => '白色',
        ],
        'value' => '20',
        'rule' => 'required',
        'msg' => '',
        'tip' => '顶部导航文字颜色',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'BackgroundColor',
        'title' => '小程序导航',
        'type' => 'color',
        'content' => [],
        'value' => '#6d189e',
        'rule' => 'required',
        'msg' => '',
        'tip' => '顶部背景色',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'Indexotice',
        'title' => '首页通知栏',
        'type' => 'string',
        'content' => [],
        'value' => '欢迎使用Fastadmin移动端商城插件，在这里您将得到最优质的体验...',
        'rule' => '',
        'msg' => '',
        'tip' => '首页顶部通知栏文字',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'AppID',
        'title' => '小程序ID',
        'type' => 'string',
        'content' => [],
        'value' => 'wx33XXXXXX2',
        'rule' => 'required',
        'msg' => '',
        'tip' => '关联小程序AppID',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'AppSecret',
        'title' => '小程序密钥',
        'type' => 'string',
        'content' => [],
        'value' => '879eb4bbb1XXXXXX32b3a',
        'rule' => 'required',
        'msg' => '',
        'tip' => '关联小程序AppSecret',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'MCHID',
        'title' => '小程序商户号',
        'type' => 'string',
        'content' => [],
        'value' => '1449xxxxXX',
        'rule' => '',
        'msg' => '',
        'tip' => '小程序的微信支付商户号',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'APIKEY',
        'title' => '小程序支付密钥',
        'type' => 'string',
        'content' => [],
        'value' => 'yuzzzzwXXXXXxxzzzxxxx',
        'rule' => '',
        'msg' => '',
        'tip' => '小程序的微信支付密钥',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'MCHIDGZH',
        'title' => '公众号商户号',
        'type' => 'string',
        'content' => [],
        'value' => '144xxzzz',
        'rule' => '',
        'msg' => '',
        'tip' => '公众号的微信支付商户号',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'APIKEYGZH',
        'title' => '公众号支付密钥',
        'type' => 'string',
        'content' => [],
        'value' => 'xxzexxxzzzx',
        'rule' => '',
        'msg' => '',
        'tip' => '公众号的微信支付密钥',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'freight',
        'title' => '运费组合设置',
        'type' => 'radio_text',
        'content' => [
            10 => '叠加',
            20 => '以最低运费结算',
            30 => '以最高运费结算',
        ],
        'value' => '10',
        'rule' => 'required',
        'msg' => '',
        'tip' => [
            10 => '订单中有多个运费时，取每个商品的运费之和为总运费',
            20 => '订单中有多个运费时，取订单中运费最少的商品的运费为总运费',
            30 => '订单中有多个运费时，取订单中运费最多的商品的运费为总运费',
        ],
        'ok' => '',
        'extend' => '',
    ],
    [
        'type' => 'string',
        'name' => '__tips__',
        'title' => '温馨提示',
        'value' => '公众号的用户关联的AppSecret和AppSecret，请在第三方登录插件中，配置。',
        'content' => '',
        'tip' => '',
        'rule' => '',
        'extend' => '',
    ],
];