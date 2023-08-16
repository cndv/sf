<?php
namespace addons\litestore\controller\api;

use app\common\controller\Api;
use addons\litestore\model\Litestoreorder;

use addons\third\model\Third;
use EasyWeChat\Factory as WXPAY_APP;

class Order extends Api
{
	protected $noNeedRight = ['*'];
    protected $noNeedLogin = ['callback_for_wxapp','callback_for_wxgzh'];

	public function _initialize()
    {
        parent::_initialize();
        $this->user_id = $this->auth->id;
        $this->model = new Litestoreorder;

    }

    public function buyNow()
    {
        $goods_id = $this->request->request('goods_id');
        $goods_num = $this->request->request('goods_num');
        $goods_sku_id = $this->request->request('goods_sku_id');

        $order = $this->model->getBuyNow($this->user_id, $goods_id, $goods_num, $goods_sku_id);

        return $this->success('获取成功',$order);
    }

    public function buyNow_pay(){
        $goods_id = $this->request->request('goods_id');
        $goods_num = $this->request->request('goods_num');
        $goods_sku_id = $this->request->request('goods_sku_id');

        $order = $this->model->getBuyNow($this->user_id, $goods_id, $goods_num, $goods_sku_id);

        if ($this->model->hasError()) {
            return $this->error($this->model->getError());
        }

         // 创建订单
        if ($this->model->order_add($this->user_id, $order)) {
            // 发起微信支付
            if($this->request->request('type')&&$this->request->request('type')=='gzh'){
                if($this->init_wx_pay_for_gzh(true) == false){
                    return $this->error('请正确填写微信商户号的对应的key');
                }
                $this->make_wx_pay('wechat');
            }else{
                $this->init_wx_pay_for_wxapp();
                $this->make_wx_pay('wxapp');
            }
        }
        $error = $this->model->getError() ?: '订单创建失败';
        return $this->error($error);

    }

    public function Get_order_num(){
        $NoPayNum = $this->model->where(['user_id' => $this->user_id, 'pay_status' => '10', 'freight_status' => '10', 'order_status' => '10', 'receipt_status' => '10'])->count();
        $NoFreightNum = $this->model->where(['user_id' => $this->user_id, 'pay_status' => '20', 'freight_status' => '10', 'order_status' => '10', 'receipt_status' => '10'])->count();
        $NoReceiptNum = $this->model->where(['user_id' => $this->user_id, 'pay_status' => '20', 'freight_status' => '20', 'order_status' => '10', 'receipt_status' => '10'])->count();
        return $this->success('',['NoPayNum'=>$NoPayNum,'NoFreightNum'=>$NoFreightNum,'NoReceiptNum'=>$NoReceiptNum]);
    }

    public function my(){
        $list = $this->model->getList($this->user_id);
        return $this->success('',$list);
    }

    public function detail(){
        $id = $this->request->request('id');
        $order = $this->model->getOrderDetail($id, $this->user_id);
        return $this->success('',['order' => $order]);
    }

	public function cart_pay()
    {
        $order = $this->model->getCart($this->user_id);
  
        // 创建订单
        if ($this->model->order_add($this->user_id, $order)) {
            // 清空购物车
            $this->model->CarclearAll($this->user_id);
           
            // 发起微信支付
            if($this->request->request('type')&&$this->request->request('type')=='gzh'){
                if($this->init_wx_pay_for_gzh(true) == false){
                    return $this->error('请正确填写微信商户号的对应的key');
                }
                $this->make_wx_pay('wechat');
            }else{
                $this->init_wx_pay_for_wxapp();
                $this->make_wx_pay('wxapp');
            }
        }
        $this->error($this->model->getError() ?: '订单创建失败');
    }

    public function finish(){
        $id = $this->request->post("id");
        $order = $this->model;
        if ($order->finish($this->user_id,$id)) {
            return $this->success('');
        }
        return $this->error($order->getError());
    }

    public function cancel(){
        $id = $this->request->post("id");
        $order = $this->model->getOrderDetail($id, $this->user_id);

        if ($order->cancel($this->user_id,$id)) {
            return $this->success('');
        }
        return $this->error($order->getError());
    }

    public function order_pay(){
         $id = $this->request->post("id");
         $order = $this->model->getOrderDetail($id, $this->user_id);
         if (!$order->checkGoodsStatusFromOrder($order['goods'])) {
            return $this->error($order->getError());
         }
         $this->model = $order;
         // 发起微信支付
         if($this->request->post('type')&&$this->request->post('type')=='gzh'){
             if($this->init_wx_pay_for_gzh(true) == false){
                 return $this->error('请正确填写微信商户号的对应的key');
             }
             $this->make_wx_pay('wechat');
         }else{
             $this->init_wx_pay_for_wxapp();
             $this->make_wx_pay('wxapp');
         }
    }

    private function init_wx_pay_for_gzh($Ischeck=false){
        //这里首先判断 此用户是否绑定了微信公众号
        if($Ischeck){
            $third = Third::where(['user_id' => $this->user_id, 'platform' => 'wechat'])->find();
            if(!$third){
                //从这里自动绑定微信公众号的账户
                $this->error('您未绑定微信号',null,1008);
            }
        }

        $config = get_addon_config('litestore');
        
        $third_config = get_addon_config('third');
        $third_options = array_intersect_key($third_config, array_flip(['wechat']));
        $third_options = $third_options['wechat'];
        if(strlen($config['APIKEYGZH']) != 32){
            return false;
        }

        $options = [
            'debug' => true,
            'log' => [
                'level' => 'debug',
                'file' => '/tmp/easywechat.log',
            ],
            'app_id' => $third_options['app_id'],
            'mch_id' => $config['MCHIDGZH'],
            'key' => $config['APIKEYGZH'],
            'notify_url' => \think\Request::instance()->domain().addon_url('litestore/api.order/callback_for_wxgzh'),

        ];
        $this->wxapp = WXPAY_APP::payment($options);
        return true;
    }

    private function init_wx_pay_for_wxapp(){
        $config = get_addon_config('litestore');
        $options = [
            'debug' => true,
            'log' => [
                'level' => 'debug',
                'file' => '/tmp/easywechat.log',
            ],
            'app_id' => $config['AppID'],
            'mch_id' => $config['MCHID'],
            'key' => $config['APIKEY'],
            'notify_url' => \think\Request::instance()->domain().addon_url('litestore/api.order/callback_for_wxapp'),

        ];
        $this->wxapp = WXPAY_APP::payment($options);
    }

    private function make_wx_pay($platform){
    	$third = Third::where(['user_id' => $this->user_id, 'platform' => $platform])->find();

        $payment = $this->wxapp;

        $attributes = [
		    'trade_type'       => 'JSAPI',
		    'body'             => $this->model['order_no'],
		    'detail'           => 'OrderID:'.$this->model['id'],
		    'out_trade_no'     => $this->model['order_no'],
		    //'total_fee'        => $this->model['pay_price'] * 100, // 单位：分
            'total_fee'        => 1, // 单位：分
		    'openid'           => $third['openid'],
		];
        $result = $payment->order->unify($attributes);
		if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $prepayId = $result['prepay_id'];
            $config = $payment->jssdk->sdkConfig($prepayId);
			return $this->success('预支付成功',$config);
		}
		return $this->error('微信支付调用失败',$result);
    }

    public function callback_for_wxgzh(){
        $this->init_wx_pay_for_gzh(false);
        $response = $this->wxapp->handlePaidNotify(function ($message, $fail) {
            $order = $this->model->payDetail($message['out_trade_no']);

            if (empty($order)) { // 如果订单不存在
                return true;
                //return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            if ($message['return_code'] === 'SUCCESS') {
                if ($message['result_code']=== 'SUCCESS') {
                    $order->updatePayStatus($message['transaction_id']);
                }
            }

            return true; // 返回处理完成
        });

        $response->send();
    }

    public function callback_for_wxapp(){
        $this->init_wx_pay_for_wxapp();
        $response = $this->wxapp->handlePaidNotify(function ($message, $fail) {
            $order = $this->model->payDetail($message['out_trade_no']);

            if (empty($order)) { // 如果订单不存在
                return true;
                //return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            if ($message['return_code'] === 'SUCCESS') {
                if ($message['result_code']=== 'SUCCESS') {
                    $order->updatePayStatus($message['transaction_id']);
                }
            }

            return true; // 返回处理完成
        });

        $response->send();
    }

}
