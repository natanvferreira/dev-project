@extends('layouts.main')
@section('corpo')
    @include('layouts.navbar')
    <div class="container mt-4">
        <form class="row g-3 mb-4" action="/">
            <div class="col-md-10">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo">
            </div>
            <div class="d-flex justify-content-end col-md-2 mt-5">
                <button type="submit" class="btn btn-success" id="btnBuscarCategoria">Buscar post</button>
            </div>
        </form>
        <div class="row mb-2">
            @foreach ($blogs as $blog)
                <div class="col-md-6">
                    <div
                        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <h3 class="mb-0">{{ $blog->titulo }}</h3>
                            <div class="mb-1 text-body-secondary">
                                {{ $blog->usuario->name }} - {{ date('d/m/y', strtotime($blog->data_publicacao)) }}</div>
                            <small class="text-body-secondary">
                                @foreach ($blog->categorias as $categoria)
                                    {{ $categoria->titulo }}@if (!$loop->last)
                                        -
                                    @endif
                                @endforeach
                            </small>
                            <p class="card-text mb-auto mt-2">
                                {{ Illuminate\Support\Str::limit($blog->conteudo, $limite = 80, $terminator = '...') }}
                            </p>
                            <a href="#" class="icon-link gap-1 icon-link-hover stretched-link">
                                Continue reading
                            </a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img src="{{ asset("storage/$blog->imagem") }}" width="250" height="250">
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $blogs->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
