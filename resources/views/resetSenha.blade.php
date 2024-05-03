@extends('layouts.main')
@section('corpo')
    @include('layouts.navbar')
    <div class="container mt-5">
        <form class="needs-validation" novalidate>
            @csrf
            <label for="inputSenha" class="form-label">Senha</label>
            <div class="mb-3 input-group">
                <input type="password" class="form-control" id="inputSenha">
                <span class="input-group-text btn btn-light" id="btnVerSenha"><i class="bi bi-eye-fill"></i></span>
            </div>
            <label for="inputSenha2" class="form-label">Repita sua senha</label>
            <div class="mb-3 input-group">
                <input type="password" class="form-control" id="inputSenha2">
                <span class="input-group-text btn btn-light" id="btnVerSenha2"><i class="bi bi-eye-fill"></i></span>
                <div class="valid-feedback">
                    A senhas coincidem!
                </div>
                <div class="invalid-feedback">
                    A senhas não coincidem!
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-end">
                <button class="btn btn-primary" type="button" id="btnResetSenha" disabled>Resetar senha</button>
            </div>
        </form>
    </div>
@endsection
