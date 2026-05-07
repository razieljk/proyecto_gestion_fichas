<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RedirectIfAuthenticated::redirectUsing(function($request) {
            if (Auth::check()) {
                $rol = Auth::user()->rol;
                if ($rol === 'instructor') return route('instructor.dashboard');
                if ($rol === 'admin') return route('admin.dashboard');
                return route('aprendiz.dashboard');
            }
            return '/';
        });
    }
}