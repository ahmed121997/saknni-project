<?php

namespace App\Providers;

use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //bind the interface to the implementation
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

    }
}
