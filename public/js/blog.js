$(document).ready(function () {
    $("#btnCriarPost").on("click", function () {
        let url = "/blog";
        let token = $("input[name='_token']").val();
        let titulo = $("#inputTituloModal").val();
        let categoria = $("#inputCategoriaModal").val();
        let conteudo = $("#inputConteudoModal").val();
        let imagem = $('#inputArquivoModal')[0].files[0];

        var formData = new FormData();

        formData.append('_token', token);
        formData.append('titulo', titulo);
        formData.append('categoria', categoria);
        formData.append('conteudo', conteudo);
        formData.append('imagem', imagem);

        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                loading()
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: response.mensagem,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.href = "/blog";
                });
            },
            error: function (response) {
                Swal.fire({
                    icon: "error",
                    title: response.responseJSON.mensagem,
                    showConfirmButton: true,
                });
            },
            complete: function (response) {
                unloading();
            }
        });
    })

    $("#btnEditarPost").on("click", function () {
        let id = $("#inputIdModal").val();
        let url = `/blog/${id}`;
        let token = $("input[name='_token']").val();
        
        let titulo = $("#inputTituloModal").val();
        let categoria = $("#inputCategoriaModal").val();
        let conteudo = $("#inputConteudoModal").val();
        let imagem = $('#inputArquivoModal')[0].files[0];

        var formData = new FormData();

        formData.append('_token', token);
        formData.append('id', id);
        formData.append('titulo', titulo);
        formData.append('categoria', categoria);
        formData.append('conteudo', conteudo);
        formData.append('imagem', imagem);

        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                loading()
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: response.mensagem,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.href = "/blog";
                });
            },
            error: function (response) {
                Swal.fire({
                    icon: "error",
                    title: response.responseJSON.mensagem,
                    showConfirmButton: true,
                });
            },
            complete: function (response) {
                unloading();
            }
        });
    })
})

function aprovaPost(id) {
    let url = "/blog/aprova";
    let token = $("input[name='_token']").val();

    $.ajax({
        url: url,
        type: "put",
        data: {
            _token: token,
            id: id,
        },
        beforeSend: function () {
            loading()
        },
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: response.mensagem,
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.href = "/blog";
            });
        },
        error: function (response) {
            Swal.fire({
                icon: "error",
                title: response.responseJSON.mensagem,
                showConfirmButton: true,
            });
        },
        complete: function (response) {
            unloading()
        }
    })
}

function editaPost(id) {
    let url = `/blog/${id}`;

    $.ajax({
        url: url,
        type: "get",
        beforeSend: function () {
            loading()
        },
        success: function (response) {
            let modalPost = document.getElementById('modalCriarPost');
            const modalEditaPost = new bootstrap.Modal(modalPost);
            $("#h1TituloModal").html("Editar post");
            $("#inputIdModal").val(response.post.id);
            $("#inputTituloModal").val(response.post.titulo);
            $("#inputConteudoModal").val(response.post.conteudo);
            $.each(response.post.categorias, function (index, categoria) {
                $('#inputCategoriaModal option[value="' + categoria.id + '"]').prop('selected', true);
            });
            $("#btnCriarPost").addClass("d-none");
            $("#btnEditarPost").removeClass("d-none");
            modalEditaPost.show();

            modalPost.addEventListener('hidden.bs.modal', event => {
                $("#h1TituloModal").html("Criar novo post");
                $("#inputIdModal").val("");
                $("#inputTituloModal").val("");
                $("#inputConteudoModal").val("");
                $.each(response.post.categorias, function (index, categoria) {
                    $('#inputCategoriaModal option[value="' + categoria.id + '"]').prop('selected', false);
                });
                $("#btnCriarPost").removeClass("d-none");
                $("#btnEditarPost").addClass("d-none");
            })
        },
        error: function (response) {
            Swal.fire({
                icon: "error",
                title: response.responseJSON.mensagem,
                showConfirmButton: true,
            });
        },
        complete: function (response) {
            unloading()
        }
    })
}

function deletaPost(id, titulo) {
    Swal.fire({
        title: `Você deseja realmente apagar o post: ${titulo}`,
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            let url = `/blog/${id}`;
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "delete",
                data: {
                    _token: token,
                    id: id
                },
                beforeSend: function () {
                    loading();
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: response.mensagem,
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/blog";
                    });
                },
                error: function (response) {
                    Swal.fire({
                        icon: "error",
                        title: response.responseJSON.mensagem,
                        showConfirmButton: true,
                    });
                },
                complete: function (response) {
                    unloading();
                }
            })
        }
    });
}