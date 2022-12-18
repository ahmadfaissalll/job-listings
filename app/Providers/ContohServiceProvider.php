<?php

namespace App\Providers;

use App\Data\Contoh;
use Illuminate\Support\ServiceProvider;

class ContohServiceProvider extends ServiceProvider
{


  // public $bindings = [
  //   Contoh::class
  // ];

  // public $singletons = [
  //   Contoh::class
  // ];

  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    // $contoh = new Contoh('faisal');
    
    $this->app->bind(Contoh::class, Contoh::class);
    // $this->app->singleton(Contoh::class, Contoh::class);
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
