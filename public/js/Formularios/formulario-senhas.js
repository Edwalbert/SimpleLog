function obterId() {
    var url = window.location.href;
    var partesDaURL = url.split('/');
    var id = partesDaURL[partesDaURL.length - 1];

    preencherFormulario(id);
}

function preencherFormulario(id) {
    try {
        $.ajax({
            url: "/verificar-registro/util/Senha/id/" + id,
            type: "GET",
            success: function (response) {
                $('#id_senha').val(response.data.id);
                $('#acesso').val(response.data.acesso);
                $('#sistema').val(response.data.sistema);
                $('#link').val(response.data.link);
                $('#login').val(response.data.login);
                $('#password').val(response.data.password);
                $('#descricao').val(response.data.descricao);
            },
            error: function () {
                console.log('Senha não encontrada');
                document.getElementById("doc_cnh").setAttribute("required", "required");
            }
        });
    } catch (error) {
        console.log('Erro na requisição AJAX: ' + error);
    }
}

$(document).ready(function () {
    obterId();
});