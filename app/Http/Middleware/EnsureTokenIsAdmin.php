<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TokenUsuario;
use Carbon\Carbon;

class EnsureTokenIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $token = null;
        $auth = $request->header('Authorization');
        if ($auth && str_starts_with($auth, 'Bearer ')) {
            $token = substr($auth, 7);
        }
        $token = $token ?? $request->header('X-USER-TOKEN') ?? $request->query('token') ?? $request->input('token');

        if (! $token) {
            return response()->json(['erro' => 's', 'mensagem' => 'Token não fornecido'], 401);
        }

        $tk = TokenUsuario::where('token', $token)->where('valido_ate', '>', Carbon::now())->first();
        if (! $tk) {
            return response()->json(['erro' => 's', 'mensagem' => 'Token inválido ou expirado'], 401);
        }

        $usuario = $tk->usuario()->first();
        if (! $usuario || ! $usuario->is_admin) {
            return response()->json(['erro' => 's', 'mensagem' => 'Acesso negado (não é administrador)'], 403);
        }

        // attach user to request
        $request->attributes->set('usuario', $usuario);

        return $next($request);
    }
}
