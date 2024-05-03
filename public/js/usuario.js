$(document).ready(function () {
    $("#btnEditarUsuario").on("click", function () {
        let id = $("#inputId").val();
        let permissao = $('input[type="radio"][name="inputPermissao"]:checked').val();

        let url = "/usuario";
        let token = $("input[name='_token']").val();

        $.ajax({
            url: url,
            type: "post",
            data: {
                _token: token,
                id: id,
                permissao: permissao
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
                    window.location.href = "/usuarios";
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
    });
})

function recuperaUsuario(id) {
    let url = `/usuario/${id}`;

    $.ajax({
        url: url,
        type: "get",
        beforeSend: function () {
            loading();
        },
        success: function (response) {
            let modalUsuario = document.getElementById('modalEditarUsuario');
            const modalEditaUsuario = new bootstrap.Modal(modalUsuario);
            $("#inputId").val(response.usuario.id);
            $("#inputNome").val(response.usuario.name);
            $(`input[type="radio"][name="inputPermissao"][value="${response.usuario.permission}"]`).prop('checked', true);
            $("#inputEmail").val(response.usuario.email);
            modalEditaUsuario.show();
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