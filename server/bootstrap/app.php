<?php

use App\Http\Middleware\CheckJwt;
use App\Http\Middleware\isAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->validateCsrfTokens(
            except: ['*']
        );
        $middleware->encryptCookies(
            except:['jwt-token']
        );
        $middleware->web([
            // CheckJwt::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
