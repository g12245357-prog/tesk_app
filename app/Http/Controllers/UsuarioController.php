<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\TokenUsuario;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioAprovado;

class UsuarioController extends Controller
{
    public function cadastro_usuario_html(Request $request){
        return view('cadastro_usuario');
    }

    public function cadastro_usuario(Request $request){

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required',
            'senha' => 'required|string|min:6',
            'cpf' => 'required|string|max:11',
            'data_nascimento' => 'required',
        ]);

        $usuario = new Usuario();

        if($usuario->where('email', "=", $request->email)->exists()){
            return response()->json(['erro' => 's','mensagem' => 'Email já cadastrado'], 200);
        }

        try {
            $usuario->nome = $request->nome;
            $usuario->email = $request->email;
            $usuario->senha = md5($request->senha);
            $usuario->cpf = $request->cpf;
            $usuario->data_nascimento = $request->data_nascimento;
            $usuario->aprovado = false;
            $usuario->save();

            return response()->json(['erro' => 'n','mensagem' => 'Usuário cadastrado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['erro' => 's','mensagem' => 'Erro ao cadastrar usuário: ' . $e->getMessage()], 200);
        }

    }

    public function aprovar_usuario(Request $request, $id)
    {
        // middleware EnsureTokenIsAdmin already validated token and attached user
        $usuario = Usuario::find($id);
        if (! $usuario) {
            return response()->json(['erro' => 's', 'mensagem' => 'Usuário não encontrado'], 404);
        }

        $usuario->aprovado = true;
        $usuario->save();

        // enviar e-mail de aprovação
        try {
            Mail::to($usuario->email)->send(new UsuarioAprovado($usuario));
        } catch (\Exception $e) {
            // log error but still return success
        }

        return response()->json(['erro' => 'n', 'mensagem' => 'Usuário aprovado e notificado por e-mail'], 200);
    }

    public function listar_solicitacoes(Request $request)
    {
        $pending = Usuario::where('aprovado', false)->get();
        return view('admin.solicitacoes', compact('pending'));
    }
}
