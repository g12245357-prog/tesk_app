<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioCadastroTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_ser_cadastrado_com_sucesso(): void
    {
        $response = $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Maria Silva',
            'email' => 'maria@example.com',
            'senha' => 'senha123',
            'senha_confirmation' => 'senha123',
            'cpf' => '12345678909',
            'data_nascimento' => '1990-01-15',
        ]);

        $response->assertOk();
        $response->assertJsonPath('erro', 'n');
    }
}
