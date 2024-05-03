@extends('layouts.main')
@section('corpo')
    @include('layouts.navbar')
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-4 mt-3">
            <a href="{{ route('exportar.csv') }}" class="btn btn-outline-primary">Exportar dados em
                csv</a>

        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Permissão</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <th scope="row">{{ $usuario->id }}</th>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->permission }}</td>
                            <td class="d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="recuperaUsuario({{ $usuario->id }})">Editar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalEditarUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="h1TituloModal">Editar usuário</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="inputNome" class="form-label">Nome</label>
                            <input type="hidden" name="inputId" id="inputId">
                            <input type="text" class="form-control" id="inputNome" disabled readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Permissão</label>
                            <br>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="inputPermissao" id="administrador"
                                    value="admin">
                                <label class="form-check-label" for="administrador">Administrador</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inputPermissao" id="usuario"
                                    value="user">
                                <label class="form-check-label" for="usuario">Usuário</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="inputEmail" disabled readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnEditarUsuario">Editar usuário</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
