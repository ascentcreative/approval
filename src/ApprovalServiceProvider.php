<?php

namespace AscentCreative\Approval;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;


class ApprovalServiceProvider extends ServiceProvider
{

    public function register() {
        //
    
        $this->mergeConfigFrom(
            __DIR__.'/../config/approval.php', 'approval'
        );


        \Illuminate\Database\Schema\Blueprint::macro('approvals', function($table) {
            $table->integer("is_approved");
        });

        \Illuminate\Database\Schema\Blueprint::macro('dropApprovals()', function($table) {
            $table->dropColumn('is_approved');
        });

    }

    public function boot() {
        $this->bootComponents();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sandbox');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }


    // register the components
    public function bootComponents() {
      
    }


    public function bootPublishes() {

      $this->publishes([
        __DIR__.'/Assets' => public_path('vendor/ascentcreative/approval'),
    
      ], 'public');

      $this->publishes([
        __DIR__.'/config/approval.php' => config_path('approval.php'),
      ]);

    }



}