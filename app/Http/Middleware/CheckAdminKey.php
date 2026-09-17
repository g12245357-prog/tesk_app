<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminKey
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('X-ADMIN-KEY') ?? $request->query('admin_key') ?? $request->input('admin_key');
        $expected = env('ADMIN_KEY');
        if (! $expected || ! $key || $key !== $expected) {
            return response()->json(['erro' => 's', 'mensagem' => 'Acesso negado (admin key inválida)'], 403);
        }
        return $next($request);
    }
}
