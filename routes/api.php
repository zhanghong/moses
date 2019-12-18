<?php

use Illuminate\Http\Request;

Route::prefix('v1')
->namespace('Api')
->name('api.v1.')
->group(function () {
    Route::middleware('throttle:' . config('api.rate_limits.sign'))
    ->group(function () {
        Route::post('captchas', 'Core\CaptchasController@store')
        ->name('captchas.store');
        // 短信验证码
        Route::post('verificationCodes', 'Core\VerificationCodesController@store')
        ->name('verificationCodes.store');
        // 用户注册
        Route::post('users', 'Core\UsersController@store')
        ->name('users.store');

        // 第三方登录
        Route::post('socials/{social_type}/authorizations', 'Core\AuthorizationsController@socialStore')
            ->where('social_type', 'weixin')
            ->name('socials.authorizations.store');
    });
});
