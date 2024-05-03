<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        return view("login", ["arquivo" => "login"]);
    }

    public function login(Request $request)
    {
        if (User::buscaPeloEmailESenha($request->email, $request->senha)) {
            $this->criaSessaoDeUsuario($request->email);

            return response()->json([
                "mensagem" => "Cadastro encontrado!"
            ], 200);
        } else {
            return response()->json([
                "mensagem" => "Cadastro não encontrado!"
            ], 404);
        }
    }

    public function cadastro(Request $request)
    {
        if (User::buscaPeloEmail($request->email)) {
            return response()->json([
                "mensagem" => "Email já cadastrado!"
            ], 409);
        } else {
            $data = [
                'name' => $request->nome,
                'email' => $request->email,
                'password' => bcrypt($request->senha),
                'permission' => 'user',
            ];

            $user = User::create($data);

            if ($user) {
                EmailController::enviaEmail($user->name, $user->email, true, "Novo usuário", "Um novo usuário se registrou");
                $this->criaSessaoDeUsuario($request->email);
                return response()->json([
                    "mensagem" => "Cadastro realizado com sucesso!"
                ], 200);
            } else {
                return response()->json([
                    "mensagem" => "Erro ao realizar o seu cadastro!"
                ], 500);
            }
        }
    }

    public function criaSessaoDeUsuario($email)
    {
        $usuario = (object)User::buscaPeloEmail($email);
        session()->put("usuario", $usuario);
        auth()->login($usuario);
    }

    public function reset()
    {
        return view("reset", [
            "arquivo" => "reset"
        ]);
    }

    public function validaEmail(Request $request)
    {
        $user = User::buscaPeloEmail($request->email);

        if (!$user) {
            return response()->json([
                "mensagem" => "Email não encontrado"
            ], 404);
        } else {
            $token = Str::random(60);
            $tokenExpiresAt = Carbon::now()->addHours(2);

            $user->verification_token = hash('sha256', $token);
            $user->token_expires_at = $tokenExpiresAt;
            $user->save();

            $html = '
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Redefinir Senha</title>
                </head>
                <body style="font-family: Arial, sans-serif;">
                    <h2>Redefinir Senha</h2>
                    <p>Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.</p>
                    <p>Por favor, insira o token a seguir no campo informado na sua tela: ' . $token . '</p>
                    <p>Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.</p>
                    <p>Obrigado,<br>
                    DevProject</p>
                </body>
            </html>';

            if (EmailController::enviaEmail($user->name, $user->email, true, "Redifinição de senha", $html)) {
                return response()->json([
                    "mensagem" => "Token enviado por e-mail com sucesso!"
                ]);
            } else {
                return response()->json([
                    "mensagem" => "Erro ao enviar o token!"
                ], 500);
            }
        }
    }

    public function validaToken(Request $request)
    {
        $user = User::where("verification_token", hash("sha256", $request->token))->first();

        if ($user) {
            if ($user->token_expires_at && Carbon::now()->gt($user->token_expires_at)) {
                return response()->json([
                    "mensagem" => "Token expirado"
                ], 401);
            }

            $user->verification_token = null;
            $user->token_expires_at = null;
            if ($user->save()) {
                return response()->json([
                    "mensagem" => "Token válido"
                ]);
            } else {
                return response()->json([
                    "mensagem" => "Erro ao salvar o token!"
                ], 401);
            }
        }

        return response()->json([
            "mensagem" => "Token inválido"
        ], 401);
    }

    public function resetaSenha(Request $request)
    {
        $user = User::buscaPeloEmail($request->email);

        if (!$user) {
            return response()->json([
                "mensagem" => "Email não encontrado"
            ], 404);
        } else {
            $user->password = bcrypt($request->senha);

            if ($user->save()) {
                return response()->json([
                    "mensagem" => "Senha resetada com sucesso, faça o login!"
                ]);
            } else {
                return response()->json([
                    "mensagem" => "Erro ao resetar a sua senha!"
                ], 401);
            }
        }
    }

    public function logout()
    {
        session()->flush();
        auth()->logout();
        return redirect("/login");
    }
}
