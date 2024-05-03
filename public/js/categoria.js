$(document).ready(function () {
    $("#btnCriarCategoria").on("click", function () {
        let categoria = $("#inputTituloModal").val();

        if (categoria === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Categoria não pode estar vazia!"
            });
        } else {
            let url = "/categoria";
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: token,
                    categoria: categoria
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
                        window.location.href = "/categoria";
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

    $("#btnEditarCategoria").on("click", function () {
        let id = $("#inputIdModal").val();
        let categoria = $("#inputTituloModal").val();

        if (categoria === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Categoria não pode estar vazia!"
            });
        } else {
            let url = "/categoria";
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "put",
                data: {
                    _token: token,
                    id: id,
                    categoria: categoria
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
                        window.location.href = "/categoria";
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
})

function editaCategoria(categoria, titulo) {
    let modalCategoria = document.getElementById('modalCriarCategoria');
    const modalEditarCategoria = new bootstrap.Modal(modalCategoria);
    $("#h1TituloModal").html("Editar categoria");
    $("#inputIdModal").val(categoria);
    $("#inputTituloModal").val(titulo);
    $("#btnCriarCategoria").addClass("d-none");
    $("#btnEditarCategoria").removeClass("d-none");
    modalEditarCategoria.show();

    modalCategoria.addEventListener('hidden.bs.modal', event => {
        $("#h1TituloModal").html("Criar nova categoria");
        $("#inputIdModal").val("");
        $("#inputTituloModal").val("");
        $("#btnCriarCategoria").removeClass("d-none");
        $("#btnEditarCategoria").addClass("d-none");
    })
}

function deletaCategoria(categoria, titulo) {
    Swal.fire({
        title: `Você deseja realmente apagar a categoria: ${titulo}`,
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            let url = `/categoria/${categoria}`;
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "delete",
                data: {
                    _token: token,
                    categoria: categoria
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
                        window.location.href = "/categoria";
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