<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->query('titulo'))) {
            $titulo = $request->query('titulo');
            $categorias = Categoria::where('titulo', 'LIKE', "%$titulo%")->get();
        } else {
            $categorias = Categoria::all();
        }

        return view("categoria", [
            "arquivo" => "categoria",
            "categorias" => $categorias
        ]);
    }

    public function criaCategoria(Request $request)
    {
        if (Categoria::buscaPeloNome($request->categoria)) {
            return response()->json([
                "mensagem" => "Categoria já cadastrada!"
            ], 409);
        } else {
            $data = [
                'titulo' => $request->categoria,
            ];

            $categoria = Categoria::create($data);

            if ($categoria) {
                return response()->json([
                    "mensagem" => "Categoria cadastrada com sucesso!"
                ], 200);
            } else {
                return response()->json([
                    "mensagem" => "Erro ao cadastrar a categoria!"
                ], 500);
            }
        }
    }

    public function editaCategoria(Request $request)
    {
        if (Categoria::buscaPeloNome($request->categoria)) {
            return response()->json([
                "mensagem" => "Categoria já cadastrada!"
            ], 409);
        } else {
            if (Gate::allows("admin")) {
                $categoria = Categoria::find($request->id);

                if (!$categoria) {
                    return response()->json([
                        "mensagem" => "Categoria não encontrada!"
                    ], 404);
                }

                $data = [
                    'titulo' => $request->categoria,
                ];

                if ($categoria->update($data)) {
                    return response()->json([
                        "mensagem" => "Categoria atualizada com sucesso!"
                    ], 200);
                } else {
                    return response()->json([
                        "mensagem" => "Erro ao atualizar a categoria!"
                    ], 500);
                }
            } else {
                return response()->json([
                    "mensagem" => "Você não tem permissão para editar esta categoria!"
                ], 403);
            }
        }
    }

    public function deletaCategoria($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                "mensagem" => "Categoria não encontrada!"
            ], 404);
        }

        if (Gate::allows("admin")) {
            if ($categoria->delete()) {
                return response()->json([
                    "mensagem" => "Categoria excluída com sucesso!"
                ], 200);
            }

            return response()->json([
                "mensagem" => "Erro ao excluir a categoria!"
            ], 500);
        } else {
            return response()->json([
                "mensagem" => "Você não tem permissão para excluir esta categoria!"
            ], 403);
        }
    }
}
