<?php

namespace addons\litestore;

use app\common\library\Menu;
use think\Addons;

/**
 * 插件
 */
class Litestore extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [
            [
               'name'    => 'litestore',
               'title'   => '移动端商城',
               'icon'    => 'fa fa-shopping-basket',
               'sublist' => [
                                [
                                    'name'    => 'litestore/litestorenews',
                                    'title'   => '首页banner',
                                    'icon'    => 'fa fa-image',
                                    'sublist' => [
                                        ['name' => 'litestore/litestorenews/index', 'title' => '查看'],
                                        ['name' => 'litestore/litestorenews/add', 'title' => '添加'],
                                        ['name' => 'litestore/litestorenews/edit', 'title' => '修改'],
                                        ['name' => 'litestore/litestorenews/del', 'title' => '删除'],
                                        ['name' => 'litestore/litestorenews/multi', 'title' => '批量更新'],
                                    ]
                                ],
                                [
                                    'name'    => 'litestore/litestoregoods',
                                    'title'   => '商品设置',
                                    'icon'    => 'fa fa-gift',
                                    'sublist' => [
                                        ['name' => 'litestore/litestoregoods/index', 'title' => '查看'],
                                        ['name' => 'litestore/litestoregoods/add', 'title' => '添加'],
                                        ['name' => 'litestore/litestoregoods/edit', 'title' => '修改'],
                                        ['name' => 'litestore/litestoregoods/del', 'title' => '删除'],
                                        ['name' => 'litestore/litestoregoods/multi', 'title' => '批量更新'],
                                        ['name' => 'litestore/litestoregoods/addSpec', 'title' => '增加规格'],
                                        ['name' => 'litestore/litestoregoods/addSpecValue', 'title' => '增加规格值'],
                                    ]
                                ],
                                [
                                    'name'    => 'litestore/litestorecategory',
                                    'title'   => '商品分类',
                                    'icon'    => 'fa fa-th',
                                    'sublist' => [
                                        ['name' => 'litestore/litestorecategory/index', 'title' => '查看'],
                                        ['name' => 'litestore/litestorecategory/add', 'title' => '添加'],
                                        ['name' => 'litestore/litestorecategory/edit', 'title' => '修改'],
                                        ['name' => 'litestore/litestorecategory/del', 'title' => '删除'],
                                        ['name' => 'litestore/litestorecategory/multi', 'title' => '批量更新'],
                                    ]
                                ],
                                [
                                    'name'    => 'litestore/litestorefreight',
                                    'title'   => '运费模板设置',
                                    'icon'    => 'fa fa-train',
                                    'sublist' => [
                                        ['name' => 'litestore/litestorefreight/index', 'title' => '查看'],
                                        ['name' => 'litestore/litestorefreight/add', 'title' => '添加'],
                                        ['name' => 'litestore/litestorefreight/edit', 'title' => '修改'],
                                        ['name' => 'litestore/litestorefreight/del', 'title' => '删除'],
                                        ['name' => 'litestore/litestorefreight/multi', 'title' => '批量更新'],
                                    ]
                                ],
                                [
                                    'name'    => 'litestore/litestoreorder',
                                    'title'   => '订单管理',
                                    'icon'    => 'fa fa-tasks',
                                    'sublist' => [
                                        ['name' => 'litestore/litestoreorder/index', 'title' => '查看'],
                                        ['name' => 'litestore/litestoreorder/add', 'title' => '添加'],
                                        ['name' => 'litestore/litestoreorder/edit', 'title' => '修改'],
                                        ['name' => 'litestore/litestoreorder/del', 'title' => '删除'],
                                        ['name' => 'litestore/litestoreorder/multi', 'title' => '批量更新'],
                                        ['name' => 'litestore/litestoreorder/detail', 'title' => '订单详情'],
                                    ]
                                ],
                             ]
            ]
        ];
        Menu::create($menu);        
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete('litestore');
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable('litestore');
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable('litestore');
        return true;
    }

    public function GetCfg(){
        return $this->getConfig();
    }

}
