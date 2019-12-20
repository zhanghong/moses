<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Events\Wechat\ScanLogin;
use App\Http\Controllers\Controller;
use EasyWeChat\Kernel\Messages\Message as WechatMessage;

class IndexController extends Controller
{
    public function serve()
    {
        $app = app('wechat.official_account');

        $app->server->push(function ($message) {
            if ($message['Event'] === 'SCAN') {
                $openid = $message['FromUserName'];

                $user = User::where('weixin_openid', $openid)->first();

                if ($user) {
                    // TODO: 这里根据情况加入其它鉴权逻辑

                    // 使用 laravel-passport 的个人访问令牌
                    // $token = $user->createToken($user->name)->accessToken;
                    $token = $user->id. '-' . time();

                    // 广播扫码登录的消息，以便前端处理
                    event(new ScanLogin($token));

                    \Log::info('haha login');
                    return '登录成功！';
                }

                return '失败鸟';
            } else {
                // TODO： 用户不存在时，可以直接回返登录失败，也可以创建新的用户并登录该用户再返回
                return '登录失败';
            }
        }, WechatMessage::EVENT);

        return $app->server->serve();
    }
}
