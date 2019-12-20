<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\Core\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallbackController extends Controller
{
    public function wechat(Request $request)
    {
        $driver = \Socialite::driver('weixin');

        try {
            if ($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
                $token = Arr::get($response, 'access_token');
            } else {
                $token = $request->access_token;

                $driver->setOpenId($request->openid);
            }

            $oauthUser = $driver->userFromToken($token);
        } catch (\Exception $e) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }

        $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;

        if ($unionid) {
            $user = User::where('weixin_unionid', $unionid)->first();
        } else {
            $user = User::where('weixin_openid', $oauthUser->getId())->first();
        }

	if (!$user) {
            $user = User::create([
                    'name' => $oauthUser->getNickname(),
                    'avatar' => $oauthUser->getAvatar(),
                    'weixin_openid' => $oauthUser->getId(),
                    'weixin_unionid' => $unionid,
            ]);
        }
        Auth::login($user);
        // dd(\Auth::user());
        return redirect('/');
    }
}
