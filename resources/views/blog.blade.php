@extends('layouts.main')
@section('corpo')
    @include('layouts.navbar')
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-4 mt-3">
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalCriarPost">Criar
                post</button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Data Publicação</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Status</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                        <tr>
                            <th scope="row">{{ $blog->id }}</th>
                            <td>{{ $blog->titulo }}</td>
                            <td>{{ date('d/m/y H:i:s', strtotime($blog->data_publicacao)) }}</td>
                            <td>
                                @foreach ($blog->categorias as $categoria)
                                    {{ $categoria->titulo }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ ucfirst($blog->status) }}</td>
                            <td class="d-flex justify-content-end">
                                @can('admin')
                                    @if ($blog->status === 'pendente')
                                        <button type="button" class="btn btn-outline-info"
                                            onclick="aprovaPost({{ $blog->id }})">Aprovar post</button>
                                        &nbsp;
                                    @endif
                                @endcan
                                @can('update-blog', $blog)
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="editaPost({{ $blog->id }})">Editar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="deletaPost({{ $blog->id }}, '{{ $blog->titulo }}')">Excluir</button>
                                @else
                                    &nbsp;
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalCriarPost" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="h1TituloModal">Criar novo post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="inputTituloModal" class="form-label">Titulo</label>
                            <input type="hidden" name="inputIdModal" id="inputIdModal">
                            <input type="text" class="form-control" id="inputTituloModal">
                        </div>
                        <div class="col-md-6">
                            <label for="inputCategoriaModal" class="form-label">Categoria</label>
                            <select id="inputCategoriaModal" class="form-select" name="inputCategoriaModal[]" multiple>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->titulo }}</option>
                                @endforeach
                            </select>
                            <small>Segure CRTL para selecionar mais de uma categoria</small>
                        </div>
                        <div class="col-12">
                            <label for="inputConteudoModal" class="form-label">Conteúdo</label>
                            <textarea class="form-control" id="inputConteudoModal"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="inputArquivoModal" class="form-label">Imagem</label>
                            <input type="file" accept="image/*" class="form-control" id="inputArquivoModal">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnCriarPost">Criar post</button>
                    <button type="button" class="btn btn-success d-none" id="btnEditarPost">Editar post</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
