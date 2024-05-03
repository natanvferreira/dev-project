@extends('layouts.main')
@section('corpo')
    <div class="d-flex align-items-center py-4 mt-5">
        <div class="form-signin w-100 m-auto mt-5" id="divLogin">
            <form class="mt-5" id="formLogin">
                @csrf
                <h1 class="h3 mb-3 fw-normal">Faça o login</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" id="inputEmailLogin" placeholder="nome@exemplo.com">
                    <label for="inputEmail">Seu endereço de e-mail</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="inputSenhaLogin" placeholder="Senha">
                    <label for="inputSenha">Sua senha</label>
                </div>
                <div class="form-check text-start my-3">
                    <a href="#" id="linkLogin">Ainda não tem uma conta?</a>
                </div>
                <div class="form-check text-start my-3">
                    <a href="/reset" id="linkReset">Esqueceu a senha?</a>
                </div>
                <button class="btn btn-success w-100 py-2" type="button" id="btnLogin">Entrar</button>
            </form>
        </div>
        <div class="mt-5 row w-100 d-flex justify-content-center d-none" id="divCadastro">
            <form class="col-6 row g-3">
                <div class="col-12">
                    <label for="inputNomeCadastro" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="inputNomeCadastro" name="inputNomeCadastro"
                        autocomplete="off">
                </div>
                <div class="col-md-6">
                    <label for="inputEmailCadastro" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmailCadastro" name="inputEmailCadastro"
                        autocomplete="off">
                </div>
                <div class="col-md-6">
                    <label for="inputSenhaCadastro" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="inputSenhaCadastro" name="inputSenhaCadastro"
                        autocomplete="off">
                </div>
                <div class="form-check text-start my-3">
                    <a href="#" id="linkCadastro">Já tem cadastro?</a>
                </div>
                <div class="col-12">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" type="button" id="btnCadastro">Cadastrar-se</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <p class="mt-5 mb-3 text-body-secondary text-center">© {{ date('Y') }}</p>
@endsection
