<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use \App\Models\M_CategoryTransactions;
use \App\Models\User;
use \Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer("Layout.navbar", function($view){
            $reminder_category = M_CategoryTransactions::whereColumn("amount_kini", ">=", "amount_target")->select("amount_target", "amount_kini", "category")->get();
            $count_reminder = count($reminder_category);
            $user = User::where("id", Auth::id());
            $view->with(["reminder_category" => $reminder_category, "count_reminder" => $count_reminder, "user" => $user->first()]);
        });
    }
}
