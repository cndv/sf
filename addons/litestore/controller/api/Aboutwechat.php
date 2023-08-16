<?php
namespace addons\litestore\controller\api;

use app\common\controller\Api;
use addons\third\model\Third;
use EasyWeChat\Factory;

class Aboutwechat extends Api
{
	protected $noNeedRight = ['*'];

    public function get_PhoneNum(){
        $encryptedData = $this->request->post("encryptedData");
        $iv = $this->request->post("iv");

        $third = Third::where(['user_id' => $this->auth->id, 'platform' => 'wxapp'])->find();
        $sessionKey = $third['access_token'];

        $config = get_addon_config('litestore');
        $options = [
            'app_id' => $config['AppID'],
            'secret' => $config['AppSecret'],

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];
        $app = Factory::miniProgram($options);
        $this->miniProgram = $app;
        $this->success('', $this->miniProgram->encryptor->decryptData($sessionKey, $iv, $encryptedData));
    }

}
