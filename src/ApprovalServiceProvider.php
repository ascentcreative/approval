<?php

namespace AscentCreative\Approval;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;

use Illuminate\Support\Facades\Route;


class ApprovalServiceProvider extends ServiceProvider
{

    public function register() {
        //
    
        $this->mergeConfigFrom(
            __DIR__.'/../config/approval.php', 'approval'
        );


        \Illuminate\Database\Schema\Blueprint::macro('approvals', function() {
            $this->boolean("is_approved")->default(0);
            $this->boolean("is_rejected")->default(0);
        });

        \Illuminate\Database\Schema\Blueprint::macro('dropApprovals', function() {
            $this->dropColumn('is_approved');
            $this->dropColumn('is_rejected');
        });

        \Illuminate\Support\Facades\Route::macro('approval', function($segment, $controller) {
            
            // dd($segment.'.approval.recall');
            Route::get('/' . $segment . '/queue', [$controller, 'approval_queue'])->name($segment . '.approval.queue');
            Route::get('/' . $segment . '/approval/{approval_item}', [$controller, 'approval'])->name($segment . '.approval.recall'); 
            Route::put('/'. $segment . '/approve/{approval_item}', [$controller, 'approve'])->name($segment . '.approval.approve');

            Route::get('/' . $segment . '/reject/{approval_item}', [$controller, 'confirmreject'])->name($segment . '.approval.reject'); 
            Route::post('/' . $segment . '/reject/{approval_item}', [$controller, 'reject'])->name($segment . '.approval.reject'); 
            
            
        });
       

    }

    public function boot() {
        $this->bootComponents();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'approval');

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