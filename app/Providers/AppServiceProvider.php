<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\tbl_website_setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped('website.settings', function() {
            return tbl_website_setting::find(1) ?? new tbl_website_setting([
                'website_name' => tbl_website_setting::DEFAULT_NAME,
                'website_logo' => tbl_website_setting::DEFAULT_LOGO,
                'favicon' => null
            ]);
        });
    }

    public function boot(): void
    {
        View::composer('*', function($view) {
            $view->with('websiteSettings', app('website.settings'));
        });
    }
}