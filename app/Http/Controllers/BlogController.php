<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categoria;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->query('titulo'))) {
            $titulo = $request->query('titulo');
            $blogs = Blog::with(['categorias', 'usuario'])
                ->where("status", "aprovado")
                ->where('titulo', 'LIKE', "%$titulo%")
                ->orderBy('updated_at', 'desc')
                ->paginate(1);

            $blogs->appends(['titulo' => $titulo]);
        } else {
            $blogs = Blog::with(['categorias', 'usuario'])
                ->where("status", "aprovado")
                ->orderBy('updated_at', 'desc')
                ->paginate(1);
        }

        return view("index", [
            "blogs" => $blogs
        ]);
    }

    public function lista()
    {
        if (Gate::allowIf("admin")) {
            $blogs = Blog::with('categorias')->get();
        } else {
            $blogs = Blog::with('categorias')->where("user_id", Auth::user()->id)->get();
        }

        $categorias = Categoria::all();

        return view("blog", [
            "arquivo" => "blog",
            "blogs" => $blogs,
            "categorias" => $categorias,
        ]);
    }

    public function criaPost(Request $request)
    {
        if ($request->hasFile('imagem')) {
            $image = $request->file('imagem');
            $caminhoImagem = $image->store('public');
            $post = new Blog();
            $post->user_id = Auth::user()->id;
            $post->titulo = $request->titulo;
            $post->imagem = str_replace("public/", "", $caminhoImagem);
            $post->conteudo = $request->conteudo;
            $post->data_publicacao = Carbon::now('America/Sao_Paulo');
            $post->status = "pendente";

            if ($post->save()) {
                $categorias = explode(',', $request->input('categoria'));

                foreach ($categorias as $categoria) {
                    $post->categorias()->attach($categoria);
                }

                $usersAdmin = User::where("permission", "admin")->get();

                foreach ($usersAdmin as $key => $value) {
                    EmailController::enviaEmail($value->name, $value->email);
                }

                return response()->json([
                    "mensagem" => "Post criado com sucesso, espere um ADM aprova-lo!"
                ], 200);
            }

            return response()->json([
                "mensagem" => "Erro ao criar o post!"
            ], 500);
        } else {
            return response()->json([
                "mensagem" => "Imagem obrigatoria no post!"
            ], 500);
        }
    }

    public function aprovaPost(Request $request)
    {
        if (Gate::allowIf("admin")) {
            $blog = Blog::find($request->id);

            if (!$blog) {
                return response()->json([
                    "mensagem" => "Post não encontrado!"
                ], 404);
            }

            $data = [
                'status' => "aprovado",
            ];

            if ($blog->update($data)) {
                return response()->json([
                    "mensagem" => "Post aprovado com sucesso!"
                ], 200);
            } else {
                return response()->json([
                    "mensagem" => "Erro ao aprovar o post!"
                ], 500);
            }
        } else {
            return response()->json([
                "mensagem" => "Você não tem permissão para aprovar post's!"
            ], 403);
        }
    }

    public function recuperaPost($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                "mensagem" => "Post não encontrado!"
            ], 404);
        }

        if (Gate::allows("update-blog", $blog)) {
            return response()->json([
                "post" => Blog::with('categorias')->find($id)
            ]);
        } else {
            return response()->json([
                "mensagem" => "Você não tem permissão para editar esse post!"
            ], 403);
        }
    }

    public function editaPost(Request $request)
    {
        $blog = Blog::find($request->id);

        if (!$blog) {
            return response()->json([
                "mensagem" => "Post não encontrado!"
            ], 404);
        }

        if (Gate::allows("update-blog", $blog)) {
            if ($request->hasFile('imagem')) {
                $image = $request->file('imagem');
                $caminhoImagem = $image->store('public');
                $blog->imagem = str_replace("public/", "", $caminhoImagem);
            }

            $blog->user_id = Auth::user()->id;
            $blog->titulo = $request->titulo;
            $blog->conteudo = $request->conteudo;

            if ($blog->update()) {
                $categorias = explode(',', $request->input('categoria'));

                $blog->categorias()->detach();

                foreach ($categorias as $categoria) {
                    $blog->categorias()->attach($categoria);
                }

                return response()->json([
                    "mensagem" => "Post atualizado com sucesso!"
                ], 200);
            }

            return response()->json([
                "mensagem" => "Erro ao editar o post!"
            ], 500);
        } else {
            return response()->json([
                "mensagem" => "Você não tem permissão para editar esse post!"
            ], 403);
        }
    }

    public function deletaPost($id)
    {
        $post = Blog::find($id);

        if (!$post) {
            return response()->json([
                "mensagem" => "Post não encontrada!"
            ], 404);
        }

        if (Gate::allows("update-blog", $post)) {
            if ($post->delete()) {
                Storage::delete("public/" . $post->imagem);

                return response()->json([
                    "mensagem" => "Post excluído com sucesso!"
                ], 200);
            }

            return response()->json([
                "mensagem" => "Erro ao excluir o post!"
            ], 500);
        } else {
            return response()->json([
                "mensagem" => "Você não tem permissão para excluir esse post!"
            ], 403);
        }
    }
}
