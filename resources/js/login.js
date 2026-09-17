$(document).ready(function() {

    $("#entrar").click(function() {

        $.ajax({
            url: "api/login",
            method: "POST",
            data: {
                email: $("#email").val(),
                senha: $("#senha").val()
            },
            success: function(response) {
                console.log(response);
                if (response['erro'] == 'n') {
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Login realizado com sucesso!'
                    });

                    alert("Token: " + response['token']);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: response['mensagem']
                    });
                }
            }
        });

    });
});