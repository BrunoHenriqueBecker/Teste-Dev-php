<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ClienteRepositoryInterface;
use App\Repositories\ClienteRepository;

class AppServiceProvider extends ServiceProvider
{
  
   public function register()
    {
        $this->app->bind(
            \App\Repositories\ClienteRepositoryInterface::class,
            \App\Repositories\ClienteRepository::class
        );
    }



    
    public function boot(): void
    {
        //
    }
}
