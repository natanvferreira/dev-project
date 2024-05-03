$(document).ready(function () {
    $("#btnLogin").on("click", function () {
        let email = $("#inputEmailLogin").val();
        let senha = $("#inputSenhaLogin").val();

        if (email === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "E-mail não pode estar vazio!"
            });
        } else if (!validarEmail(email)) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "E-mail inválido!"
            });
        } else if (senha === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "A senha não pode ser vazia!"
            });
        } else {
            let url = "/login";
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
                        position: "top-end",
                        icon: "success",
                        title: response.mensagem,
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/";
                    });
                },
                error: function (response) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: response.responseJSON.mensagem
                    });
                },
                complete: function (response) {
                    unloading();
                }
            })
        }
    })

    $("#btnCadastro").on("click", function () {
        let nome = $("#inputNomeCadastro").val();
        let email = $("#inputEmailCadastro").val();
        let senha = $("#inputSenhaCadastro").val();

        if (nome === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Nome não pode estar vazio!"
            });
        } else if (email === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "E-mail não pode estar vazio!"
            });
        } else if (!validarEmail(email)) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "E-mail inválido!"
            });
        } else if (senha === "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "A senha não pode ser vazia!"
            });
        } else {
            let url = "/cadastro";
            let token = $("input[name='_token']").val();

            $.ajax({
                url: url,
                type: "post",
                data: {
                    _token: token,
                    nome: nome,
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
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/";
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
    });

    $("a").on("click", function () {
        $("#divCadastro").toggleClass("d-none");
        $("#divLogin").toggleClass("d-none");
    });

    $("#linkReset").on("click", function () {
        loading();
    });
});