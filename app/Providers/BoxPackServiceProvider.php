<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\BoxPack;

class BoxPackServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BoxPack::class, function ($app) {
            $boxPacker = new BoxPack();
            $boxConfigurations = config('box-pack.boxes', [
                ['name' => 'BOXA', 'length' => 20, 'width' => 15, 'height' => 10, 'weight_limit' => 5],
                ['name' => 'BOXB', 'length' => 30, 'width' => 25, 'height' => 20, 'weight_limit' => 10],
                ['name' => 'BOXC', 'length' => 60, 'width' => 55, 'height' => 50, 'weight_limit' => 50],
                ['name' => 'BOXD', 'length' => 50, 'width' => 45, 'height' => 40, 'weight_limit' => 30],
                ['name' => 'BOXE', 'length' => 40, 'width' => 35, 'height' => 30, 'weight_limit' => 20],
            ]);
            $boxPacker->setBoxes($boxConfigurations);
            return $boxPacker;
        });
    }   

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'box-pack-result');

        $this->publishes([
            __DIR__.'/../../config/box-pack.php' => config_path('box-pack.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/box-pack'),
        ], 'views');
    }
}