<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = Usuario::count();

        // contabiliza solicitações pendentes (aprovado = false)
        $pending = 0;
        if (Schema::hasColumn('usuario', 'aprovado')) {
            $pending = Usuario::where('aprovado', false)->count();
        } else {
            // fallback: usuários criados nos últimos 7 dias
            $pending = Usuario::where('created_at', '>=', now()->subDays(7))->count();
        }

        // contar tokens pessoais (se estiver usando Laravel Sanctum)
        $activeSessions = 0;
        if (DB::getSchemaBuilder()->hasTable('personal_access_tokens')) {
            $activeSessions = DB::table('personal_access_tokens')->count();
        }

        return view('bem_vindos', compact('totalUsers', 'pending', 'activeSessions'));
    }

    public function painel()
    {
        return view('painel');
    }
}
