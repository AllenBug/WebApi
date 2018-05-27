<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodesRequest;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodesRequest $request, EasySms $easySms)
    {
        $captchaData = \Cache::get($request->captcha_key);

        if(!$captchaData){
            return $this->response->error("图片验证码已失效",422);
        }

        if(!hash_equals($captchaData['code'],$request->captcha_code)){
            \Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized("验证码错误");
        }



        $phone = $request->phone;
        //判断验证码是否存在,判断验证码与缓存保存的是不是一致.

        //生成随机字符串
        $code = str_pad(random_int(1,999),4,0, STR_PAD_LEFT);
        try {
            /*$result = $easySms->send($phone,[
               'content' => "【Allen社区】您的验证码是{$code}。如非本人操作，请忽略本短信"
            ]);*/
        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse();
            $result = json_decode($response->getBody()->getContents(),true);
            return $this->response->errorInternal($result['msg']?? '短信发送异常');

        }

        $key = 'verification_'.str_random(15);
        $expiredAt = now()->addMinutes(15);
        //缓存验证码 10分值过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        //清楚验证码缓存
        \Cache::forget($request->captcha_key);

        return $this->response->array([
             'key' => $key,
            'code' => $code,
            'expired_at' => $expiredAt->toDateString()
        ])->setStatusCode(201);

    }
}
