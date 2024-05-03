<nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04"
            aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/blog">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/categoria">Categoria</a>
                </li>
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link active" href="usuarios">Usuários</a>
                    </li>
                @endcan
            </ul>
            <form role="search">
                <a class="btn btn-outline-info" href="/reset" role="button">Resetar senha</a>
                <a class="btn btn-outline-danger" href="/logout" role="button">Sair</a>
            </form>
        </div>
    </div>
</nav>
