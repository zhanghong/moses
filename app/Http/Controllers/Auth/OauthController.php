<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OauthController extends Controller
{
    public function wechat(Request $request)
    {
        return \Socialite::with('weixin')->redirect();
    }
}
