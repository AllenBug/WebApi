<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TestService;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //使用singleton绑定单例
        $this->app->singleton('App\Contracts\TestContract','App\Services\TestService');
        //使用bind绑定实例到接口以便依赖注入
        $this->app->bind('App\Services\TestService',function(){
            return new TestService();
        });
    }
}
