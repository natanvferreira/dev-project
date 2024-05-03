<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    public function index()
    {
        if (Gate::allows("admin")) {
            $usuarios = User::all();
            return view("usuarios", [
                "arquivo" => "usuario",
                "usuarios" => $usuarios
            ]);
        } else {
            return redirect("/");
        }
    }

    public function recuperaUsuario($id)
    {
        if (Gate::allows("admin")) {
            return response()->json([
                "usuario" => User::find($id)
            ]);
        } else {
            return redirect("/");
        }
    }

    public function editaUsuario(Request $request)
    {
        if (Gate::allows("admin")) {
            $usuario = User::find($request->id);

            if (!$usuario) {
                return response()->json([
                    "mensagem" => "Usuário não encontrado!"
                ], 404);
            }

            $data = [
                'permission' => $request->permissao,
            ];

            if ($usuario->update($data)) {
                return response()->json([
                    "mensagem" => "Usuário atualizado com sucesso!"
                ], 200);
            } else {
                return response()->json([
                    "mensagem" => "Erro ao atualizar o usuário!"
                ], 500);
            }
        } else {
            return response()->json([
                "mensagem" => "Você não tem permissão para editar esse usuário!"
            ], 403);
        }
    }

    public function exportarCSV()
    {
        if (Gate::allows("admin")) {
            $dados = User::all();
            $nomeArquivo = 'usuarios.csv';
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$nomeArquivo",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            $callback = function () use ($dados) {
                $arquivo = fopen('php://output', 'w');
                fputcsv($arquivo, array_keys($dados[0]->toArray()));

                foreach ($dados as $linha) {
                    fputcsv($arquivo, $linha->toArray());
                }
                fclose($arquivo);
            };

            return response()->stream($callback, 200, $headers);
        } else {
            return redirect("/");
        }
    }
}
