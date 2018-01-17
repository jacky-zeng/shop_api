<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //注册 Passport 在访问令牌、客户端、私人访问令牌的发放和吊销过程中一些必要路由。
        Passport::routes();
        //过期时间为15天之后
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        //过期时间为30天之后
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        //
    }
}
