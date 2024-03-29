<?php

namespace addons\litestore\controller\api;

use app\common\controller\Api;
use addons\litestore\model\Wxlitestoregoods;
use addons\litestore\model\Litestorenews;

class Index extends Api
{
	protected $noNeedLogin = ['*'];

	public function _initialize()
    {
        parent::_initialize();
    }

	public function index()
    {
    	$Temp_litestoregoods = new Wxlitestoregoods();
        $banner = new Litestorenews();
        $bannerdata = $banner->where('status', 'normal')->order('updatetime', 'desc')->limit(10)->select();
        $bannerList = [];
        foreach ($bannerdata as $index => $item) {
            $bannerList[] = ['image' => cdnurl($item['image'], true), 'title' => $item['title'],'id'=> $item['id']];
        }

        $NewList = $Temp_litestoregoods->getNewList();
        foreach ($NewList as $index => $item) {
            $NewList[$index]['ImageFrist'] = cdnurl(explode(",",$item['images'])[0], true);
        }

        $Randomlist = $Temp_litestoregoods->getRandom8();
        foreach ($Randomlist as $index => $item) {
            $Randomlist[$index]['ImageFrist'] = cdnurl(explode(",",$item['images'])[0], true);
        }

    	$this->success('', [
    							'NewList' => $NewList,
								'Randomlist' => $Randomlist,
                                'bannerlist' => $bannerList
    					  ]);
    }

    public function getnew(){
        $new_id = $this->request->request('new_id');
        $newdata = Litestorenews::get($new_id);
        $newdata['image'] =  cdnurl($newdata['image'], true);
        $newdata['updatetime'] = datetime($newdata['updatetime']);
        $this->success('', [
                                'newdata' => $newdata
                          ]);
    }

}


