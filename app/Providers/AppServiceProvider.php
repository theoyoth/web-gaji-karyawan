<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      \Carbon\Carbon::setLocale('id');
        // Get the current local IP address (for example purposes, or use logic to detect IP)
      $ip = request()->ip();

      // Dynamically change the `APP_URL` based on the IP address or environment
      if (App::environment('local')) {
          // Set the URL dynamically for local development
          Config::set('app.url', 'http://' . $ip . ':8000');
      } else {
          // Set the URL for production or staging (hardcoded or from environment)
          Config::set('app.url', env('APP_URL', 'http://gaji-karyawan.com'));
      }

      Paginator::useTailwind();
    }
}
