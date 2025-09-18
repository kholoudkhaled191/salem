<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiErrorHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);
            
            // Log API errors
            if ($response->getStatusCode() >= 400) {
                Log::warning('API Error Response', [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'status_code' => $response->getStatusCode(),
                    'user_agent' => $request->userAgent(),
                    'ip' => $request->ip(),
                ]);
            }
            
            return $response;
        } catch (\Exception $e) {
            Log::error('API Exception', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error_code' => 'INTERNAL_ERROR',
            ], 500);
        }
    }
}
