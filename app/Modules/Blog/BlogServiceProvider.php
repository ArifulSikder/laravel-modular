<?php
namespace App\Modules\Blog;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // You can register any module-specific services here
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes for the Blog module
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        // Load views for the Blog module
        $this->loadViewsFrom(__DIR__.'/Views', 'blog');
    }
}

