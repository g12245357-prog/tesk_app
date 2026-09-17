<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\TokenUsuario;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_SEED_EMAIL', 'admin@example.com');
        $tokenValue = env('ADMIN_TOKEN', 'admintoken');

        // Create or update admin user
        $admin = Usuario::updateOrCreate(
            ['email' => $email],
            [
                'nome' => env('ADMIN_SEED_NAME', 'Admin'),
                'senha' => md5(env('ADMIN_SEED_PASSWORD', 'password')),
                'cpf' => env('ADMIN_SEED_CPF', '00000000000'),
                'data_nascimento' => env('ADMIN_SEED_DOB', '1990-01-01'),
                'aprovado' => true,
                'is_admin' => true,
            ]
        );

        // Create or update token
        TokenUsuario::updateOrCreate(
            ['usuario_id' => $admin->id],
            [
                'token' => $tokenValue,
                'valido_ate' => Carbon::now()->addYear(),
            ]
        );
    }
}
