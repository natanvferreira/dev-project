$(document).ready(function () {
    $("#btnEnviarToken").on("click", function () {
        let email = $("#inputEmail").val();

        if (email === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "E-mail não pode estar vazio!"
            });
        } else {
            let url = "/email";
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: token,
                    email: email
                },
                beforeSend: function () {
                    loading();
                },
                success: function (response) {
                    $("#inputEmail").attr("readonly", true);
                    $("#inputEmail").attr("disabled", true);
                    $("#btnEnviarToken").addClass("d-none");

                    Swal.fire({
                        icon: "success",
                        title: response.mensagem,
                        showConfirmButton: true,
                        timer: 1500
                    }).then((result) => {
                        $("#divInputToken").removeClass("d-none");
                        $("#btnValidaToken").removeClass("d-none");
                    });
                },
                error: function (response) {
                    Swal.fire({
                        icon: "error",
                        title: response.responseJSON.mensagem,
                        showConfirmButton: false,
                    });
                },
                complete: function (response) {
                    unloading();
                }
            })
        }
    })

    $("#btnValidaToken").on("click", function () {
        let tokenEmail = $("#inputToken").val();

        if (tokenEmail === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Token não pode estar vazio!"
            });
        } else {
            let url = "/token";
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: token,
                    token: tokenEmail
                },
                beforeSend: function () {
                    loading();
                },
                success: function (response) {
                    $("#inputToken").attr("readonly", true);
                    $("#inputToken").attr("disabled", true);
                    $("#btnEnviarToken").addClass("d-none");
                    $("#btnValidaToken").addClass("d-none");

                    Swal.fire({
                        icon: "success",
                        title: response.mensagem,
                        showConfirmButton: true,
                        timer: 1500
                    }).then((result) => {
                        $("#divInputSenhas").removeClass("d-none");
                        $("#btnResetarSenha").removeClass("d-none");
                    });
                },
                error: function (response) {
                    Swal.fire({
                        icon: "error",
                        title: response.responseJSON.mensagem,
                        showConfirmButton: false,
                    });
                },
                complete: function (response) {
                    unloading();
                }
            })
        }
    })

    $("#btnResetarSenha").on("click", function () {
        let email = $("#inputEmail").val();
        let senha = $("#inputSenha1").val();
        let senha2 = $("#inputSenha2").val();

        if (senha === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "A primeira senha não pode estar vazia!"
            });
        } else if (senha2 === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "A segunda senha não pode estar vazia!"
            });
        } else if (senha !== senha2) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "As senhas não são iguais!"
            });
        } else {
            let url = "/reset";
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: token,
                    email: email,
                    senha: senha
                },
                beforeSend: function () {
                    loading();
                },
                success: function (response) {

                    Swal.fire({
                        icon: "success",
                        title: response.mensagem,
                        showConfirmButton: true,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/login";
                    });
                },
                error: function (response) {
                    Swal.fire({
                        icon: "error",
                        title: response.responseJSON.mensagem,
                        showConfirmButton: false,
                    });
                },
                complete: function (response) {
                    unloading();
                }
            })
        }
    })
})