$(document).ready(function (){

    $("#cadastro_usuario").click(function (){

        
        $.ajax({
            url: "api/cadastro_usuario",
            method: "POST",
            data: {
                nome: $("#nome").val(),
                email: $("#email").val(),
                senha: $("#senha").val(),
                data_nascimento: $("#data_nascimento").val(),
                cpf: $("#cpf").val(),
            },
            success: function (response) {
                console.log(response);
                console.log(response['erro']);
                if(response['erro'] == 'n'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Cadastro realizado com sucesso!'
                    });
                }else{
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