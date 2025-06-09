<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $data = [];
        $data["app_name"] = get_settings('app.app_name') ?? config('app.name');
        $data['fav_icon'] = Storage::url(get_settings('app.app_favicon'));
        $data['logo'] = Storage::url(get_settings('app.app_logo'));
        View::share('appData', $data);
    }
}
