<?php

namespace App\Providers;

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
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapUserApiRoutes();

        $this->mapTransporterApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapShopApiRoutes();

        $this->mapShopRoutes();

        $this->mapTransporterRoutes();

        $this->mapUserRoutes();
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin', 'auth:admin'],
            'prefix' => 'admin',
            'as' => 'admin.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/admin.php');
        });
    }

    /**
     * Define the "shop" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapShopRoutes()
    {
        Route::group([
            'middleware' => ['web', 'shop', 'auth:shop'],
            'prefix' => 'shop',
            'as' => 'shop.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/shop.php');
        });
    }

    /**
     * Define the "transporter" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapTransporterRoutes()
    {
        Route::group([
            'middleware' => ['web', 'transporter', 'auth:transporter'],
            'prefix' => 'transporter',
            'as' => 'transporter.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/transporter.php');
        });
    }

    /**
     * Define the "user" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapUserRoutes()
    {
        Route::group([
            'middleware' => ['web', 'user', 'auth:user'],
            'as' => 'user.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/user.php');
        });
    }

    /**
     * Define the "dispute" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapDisputeRoutes()
    {
        Route::group([
            'middleware' => ['web', 'dispute', 'auth:dispute'],
            'prefix' => 'dispute',
            'as' => 'dispute.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/dispute.php');
        });
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
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapUserApiRoutes()
    {
        Route::prefix('api/user')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api/user.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapTransporterApiRoutes()
    {
        Route::prefix('api/transporter')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api/transporter.php'));
    }
    
    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapShopApiRoutes()
    {
        Route::prefix('api/shop')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api/shop.php'));
    }
}
