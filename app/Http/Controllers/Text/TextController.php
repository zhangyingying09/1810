<?php
namespace App\Http\Controllers\Text;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
class TextController extends Controller{
    public function curl1(){
//        访问的地址
        $url='https://www.baidu.com/';
//    1.  初始化
        $ch=curl_init($url);
//    2.  设置参数
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);//控制浏览器输出
//    3.  执行
        curl_exec($ch);
//    4.   关闭
        curl_close($ch);
    }

    /*
     * 获取微信接口的access_token
     * */
    public function curl2(){
        $appid='wx5b67a51f6392dbad';
        $appsecret='64cf2f8942c519ad5a1dca23fcc4c134';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
//        1.初始化
            $ch=curl_init($url);
//        2.设置参数
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
//        3.执行
            $data=curl_exec($ch);
//        4.关闭
            curl_close($ch);
//        5.处理数据
//         echo $data;

           $arr=json_decode($data,true);
//           echo '<pre>';print_r($arr['access_token']);echo '</pre>';
           return $arr['access_token'];
    }


    public function curl3(){
        echo '<pre>';print_r($_POST);echo '</pre>';
    }
    public function form1(){
        return view('text.form1');
    }
    public function form1post(){
//        echo __METHOD__;
//        echo '<pre>';print_r($_POST);echo '</pre>';
        echo file_get_contents("php://input");
    }
    public function curl4(){
//       $access_token=$this->curl2();
//        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
////        dd($url);
//        $post_data='{
//            "button":[
//                 {
//                     "type":"click",
//                      "name":"今日歌曲",
//                      "key":"V1001_TODAY_MUSIC"
//                  },
//                  {
//                     "type":"click",
//                      "name":"今日新闻",
//                      "key":"NEW"
//                  }
//                  ]';
//        $ch=curl_init($url);
//
//        curl_setopt($ch, CURLOPT_URL,$url);
//        //设置获取的信息以文件流的形式返回，而不是直接输出。
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        //设置post方式提交
//        curl_setopt($ch, CURLOPT_POST, 1);
//        //设置post数据
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
//        $data=curl_exec($ch);
//        dd($data);
        echo '<pre>';print_r($_POST);echo '</pre>';
    }
    public function form2(){
        return view('text.form2');
    }
    public function form2post(Request $request)
    {
        $img = $request->img;
//        dd($img);
        if ($request->hasfile('img')) {
            if ($request->file('img')->isValid()){
                $photo = $request->file('img');
//                dd($photo);
                 $extension = $photo->getClientOriginalExtension();//获取后缀
//                dd($extension);
            $store_result = $photo->storeAs('uploads/' . date('Ymd'), date('Ymd').rand(100, 999) . '.' . $extension);
//                dd($store_result);
             }
      }
//        dd($store_result);
        $img=$store_result;
        $file=public_path()."/uploads/".$img;
//        dd($file);
        $url="http://www.1810api.com/text/uploads";
        $ch=curl_init($url);
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
//        curl_setopt($ch,CURLOPT_POST,true);
//        curl_setopt($ch,CURLOPT_POSTFIELDS,$file);
//        $data=curl_exec($ch);
//        dd($data);



        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($ch,CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        //执行命令
        $data = curl_exec($ch);
dd($data);
        curl_close($ch);
        $arr=json_decode($data,true);
//        echo $arr;die;
        return $arr;
    }
    public function uploads(){
        echo '<pre>';print_r($_POST);echo '</pre>';
    }
//加密
    public function add(){
        $data='hello';
        $data=base64_encode($data);
//        dd($data);
        $client=new Client();

        $url="http://www.luman.com/text/decrypt1";

//        $r=$client->request('POST',$url,[
//            'body' =>
//        ])
        $r=$client->request('POST',$url,[
            'body'=>$data
        ]);
        echo  $r->getBody();
    }
//对称加密
    public function add1(){
        $str='hello luman';  //待加密数据
        $key='password';   //加密密钥
        $iv='MGDZYYLSYZSYZDMI';        //初始向量

//        使用对称加密
        $enc_data=openssl_encrypt($str,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
        $client=new Client();
        $api="http://www.luman.com/text/decrypt2";
        $r=$client->request('POST',$api,[
            'body'=>base64_encode($enc_data)
        ]);
        echo  $r->getBody();
    }
//    非对称加密
    public function add2(){
        $data='asdfghjkl';
//        非对称加密   使用私钥加密
        $key=public_path("keys/priv.pem");
//        dd($key);
        $private_key=openssl_get_privatekey("file://".$key);
        dd($private_key);
        openssl_private_encrypt($data,$enc_data,$private_key);
        var_dump($enc_data);echo '<br>';

        $client=new Client();
        $api="http://www.luman.com/text/decrypt3";
        $r=$client->request('POST',$api,[
            'body'=>$enc_data
        ]);

        echo  $r->getBody();


    }
//    签名
     public function sign(){
         $key='signsuccessly';
         $iv='VMUSTLIQUANXINGL';
         $data='验证签名';
         $data1=openssl_encrypt($data,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
//        dd($data1);
         $key=storage_path("keys/priv.pem");
         $private_key=openssl_get_privatekey("file://".$key);
         $sign=openssl_sign($data,$signatrue,$private_key);
         $info=[
             'data'=>$data1,
             'body'=>$signatrue
         ];

         $info=serialize($info);
         //print_r($info);die;
//         dd($info);
         $client=new Client();
//         dd($client);
         $api="http://www.luman.com/text/sign";
         $r=$client->request('POST',$api,[
             'body'=>$info
         ]);
         echo  $r->getBody();
     }
     public function sign1(){
//        echo 111111;die;
         $method='AES-128-CBC';
         $key='signsuccessly';
         $iv='VMUSTLIQUANXINGL';
         $data=unserialize(file_get_contents("php://input"));
//         dd($data);
         $da1=$data['data'];
         $dec_data=openssl_decrypt($da1,$method,$key,OPENSSL_RAW_DATA,$iv);
//        var_dump($da1);die;
         //$dec_data=openssl_decrypt($da1,$method,$key,OPENSSL_RAW_DATA,$iv);
//         dd($dec_data);
         $sign=$data['body'];
//         dd($sign);
         $pub_key=openssl_get_publickey("file://".storage_path("keys/pub1.key"));

//         dd($pub_key);
//         验签
         $sign1=openssl_verify($dec_data,$sign,$pub_key,OPENSSL_ALGO_SHA256);
//         dd($sign1);
//         print_r($sign1);die;

//         dd($sign1);
         if($sign1=='1') {
                echo  '验证签名成功';echo "<br>";
                echo $dec_data;
         }else{
             echo  '验证签名失败1';
         }
     }
//     测试支付
    public function o1(){
//        1原始数据
        $data=[
            'order_id'       =>123456,
            'order_amount'   =>300,
            'add_time'       =>1342354553,
            'uid'            =>34
        ];
        echo "<pre>";print_r($data);echo "</pre>";echo "<hr>";
        ksort($data);
        echo "<pre>";print_r($data);echo "</pre>";echo "<hr>";

//        2.拼接 带签名字符串
        $str="";
        foreach ($data as $k=>$v){
            $str .=$k."=".$v."&";
        }
        $str1=rtrim($str,'&');
        echo $str1;echo "<hr>";
        //        3.私钥签名
        openssl_sign($str1,$signature,openssl_get_privatekey("file://".storage_path("keys/priv.pem")));
        echo $signature;echo "<hr>";
        $signature=base64_encode($signature);
        $data['signature']=$signature;
        echo "<pre>";echo print_r($data);echo "</pre>";echo "<hr>";
        $client=new Client();
        $url="http://www.luman.com/text/o1";
        $r=$client->request('post',$url,[
           'form_params'=>$data
        ]);
        echo $r->getBody();
    }


}
?>