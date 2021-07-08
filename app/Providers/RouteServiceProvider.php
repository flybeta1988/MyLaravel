<?php

namespace App\Providers;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\OrderController;
use App\Services\CourseService;
use App\Services\OrderService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->app->bind('foo', OrderService::class);

        //https://zhuanlan.zhihu.com/p/62447326
        $this->app->bind(ServiceInterface::class, CourseService::class);

        $this->app->when(CourseController::class)
            ->needs(ServiceInterface::class)
            ->give(function () {
                return new CourseService();
            });
        $this->app->when(OrderController::class)
            ->needs(ServiceInterface::class)
            ->give(function () {
                return new OrderService();
            });

        $this->app->when('App\Http\Controllers\CourseController')
            ->needs('$type')
            ->give('abc');
        $this->app->when('App\Http\Controllers\OrderController')
            ->needs('$type')
            ->give('efg');


        $this->app->bind('SpeedReport', function () {
            return 'speed';
        });

        $this->app->bind('MemoryReport', function () {
            return 'memory';
        });

        $this->app->tag(['SpeedReport', 'MemoryReport'], 'reports');

        $this->app->when(CourseController::class)
            ->needs('$reports')
            ->giveTagged('reports');
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
