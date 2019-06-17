<?php
namespace App\Http\Controllers\Text;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class TestController extends  Controller{
    public function alipay(){
        $app_id='';
        $alipay='https://openapi.alipaydev.com/gateway.do';
//        请求参数
        $biz_cont=[
            'subject'      =>"测试订单".mt_rand(11111,99999).time(),
            'out_trade_no' =>'1810_'.mt_rand(11111,99999).time(),
            'total_amount' =>mt_rand(1,10),
            'product_code' =>'QUICK_WAP_WAY',
        ];
        $data=[
            'app_id'     =>'2016092500596105',
            'method'     =>'alipay.trade.wap.pay',
            'charset'    =>'utf-8',
            'sign_type'  =>'RSA2',
            'sign'       =>'',
            'timastamp'  =>date('Y-m-d H:i:s'),
            'version'    =>'1.0',
            'biz_content' =>json_encode($biz_cont)
        ];
//        生成签名

    }
}
?>