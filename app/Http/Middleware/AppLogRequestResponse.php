<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppLogRequestResponse {

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        Log::info('app.request', ['request' => $request->all()]);
        return $next($request);
    }

    public function terminate($request, JsonResponse $response) {
        Log::info('app.response', ['response' => $response->getContent()]);
    }
}
