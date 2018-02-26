<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Component\Groupon;

use Illuminate\Support\ServiceProvider;

class GrouponServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerMigrations();
        }

        $this->publishes([
            __DIR__.'/../config/groupon.php' => config_path('ibrand/groupon.php'),
        ]);
    }

    /**
     * Register Passport's migration files.
     */
    protected function registerMigrations()
    {
        return $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {

        // merge configs
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'ibrand.groupon'
        );


        $this->app->make('iBrand\Scheduling\ScheduleList')->add(Schedule::class);

    }
}
