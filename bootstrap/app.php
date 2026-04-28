<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // Mendaftarkan alias middleware IsAdmin (Perbaikan LOG-04)
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        // 1. Jika belum login mencoba akses halaman dalam, lempar ke form login
        $middleware->redirectGuestsTo('/login');

        // 2. Jika sudah login mencoba buka /login lagi, arahkan ke dashboard masing-masing
        $middleware->redirectUsersTo(function (Request $request) {
            return $request->user()->is_admin 
                ? '/admin/dashboard' 
                : '/donatur/dashboard';
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();