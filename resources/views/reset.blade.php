@extends('layouts.main')
@section('corpo')
    <div class="container mt-5">
        <h1>Digite seu email</h1>
        @csrf
        <div class="mb-3">
            <input type="email" class="form-control" id="inputEmail" placeholder="email@email.com">
        </div>
        <div class="mb-3 d-none" id="divInputToken">
            <label for="inputToken" class="form-label">Token recebido via e-mail</label>
            <input type="text" class="form-control" id="inputToken">
        </div>
        <div class="mb-3 d-none" id="divInputSenhas">
            <label for="inputSenha1" class="form-label">Digite a senha</label>
            <input type="text" class="form-control" id="inputSenha1">
            <label for="inputSenha2" class="form-label">Digite a senha novamente</label>
            <input type="text" class="form-control" id="inputSenha2">
        </div>
        <div class="d-flex justify-content-between">
            <a href="/login" role="button" class="btn btn-danger">Voltar ao login</a>
            <button type="button" class="btn btn-success" id="btnEnviarToken">Enviar token</button>
            <button type="button" class="btn btn-success d-none" id="btnValidaToken">Validar token</button>
            <button type="button" class="btn btn-success d-none" id="btnResetarSenha">Resetar senha</button>
        </div>
    </div>
@endsection
