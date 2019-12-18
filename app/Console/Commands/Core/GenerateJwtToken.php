<?php

namespace App\Console\Commands\Core;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateJwtToken extends Command
{
    protected $signature = 'cms:generate-jwt-token';

    protected $description = '快速为用户生成 JWT token';

    public function handle()
    {
        $userId = $this->ask('输入用户 id');

        $user = User::find($userId);

        if (!$user) {
            return $this->error('用户不存在');
        }

        // 一年以后过期
        $ttl = 365*24*60;
        $this->info(auth('api')->setTTL($ttl)->login($user));
    }
}
