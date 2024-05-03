@extends('layouts.main')
@section('corpo')
    @include('layouts.navbar')
    <div class="container mt-5">
        <form class="row g-3" action="/categoria">
            <div class="col-md-10">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo">
            </div>
            <div class="d-flex justify-content-end col-md-2 mt-5">
                <button type="submit" class="btn btn-success" id="btnBuscarCategoria">Buscar categoria</button>
            </div>
        </form>
        <div class="d-flex justify-content-end mb-4 mt-3">
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                data-bs-target="#modalCriarCategoria">Criar categoria</button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titulo</th>
                        @can('admin')
                            <th scope="col">&nbsp;</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <th scope="row">{{ $categoria->id }}</th>
                            <td>{{ $categoria->titulo }}</td>
                            @can('admin')
                                <td class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="editaCategoria({{ $categoria->id }}, '{{ $categoria->titulo }}')">Editar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="deletaCategoria({{ $categoria->id }}, '{{ $categoria->titulo }}')">Excluir</button>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalCriarCategoria" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="h1TituloModal">Criar nova categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        @csrf
                        <div class="col-md-12">
                            <label for="inputTituloModal" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="inputTituloModal">
                            <input type="hidden" class="form-control" id="inputIdModal">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnCriarCategoria">Criar categoria</button>
                    <button type="button" class="btn btn-success d-none" id="btnEditarCategoria">Editar categoria</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
