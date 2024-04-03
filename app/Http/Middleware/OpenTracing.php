<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Kkday\Tracing\Tracing;
use Kkday\Tracing\Tracing\Span;
use Symfony\Component\HttpFoundation\Response;

class OpenTracing
{
    /**
     * rootSpan
     * Notice: using static $rootSpan
     */
    protected static Span $rootSpan;

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        static::$rootSpan = Tracing::startSpan(
            $request->getMethod() . ' ' . Route::current()->uri(),
            function (Span $span) use ($request) {
                $span->setStartMicroTime(LARAVEL_START);
                $span->setTag('http.method', $request->getMethod());
                $span->setTag('http.host', $request->getHost());
                $span->setTag('http.url', $request->getRequestUri());
            }
        );

        return $next($request);
    }

    /**
     * @param Request $request
     * @param $response
     */
    public function terminate(Request $request, $response)
    {
        if ($response instanceof Response) {
            if (null !== static::$rootSpan) {
                static::$rootSpan->setTag('http.status_code', $response->getStatusCode());
                if ($response->isServerError()) {
                    static::$rootSpan->setTag('error', true);
                }
            }
        }
    }
}
