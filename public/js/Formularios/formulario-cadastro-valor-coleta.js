const labels = document.querySelectorAll('label');

labels.forEach(label => {
    // Verifica se a label contém um *
    if (label.textContent.includes('*')) {
        const labelContent = label.textContent;
        const updatedContent = labelContent.replace('*', '');
        const newContent = `<span style="color: yellow">*</span>`;

        label.innerHTML = updatedContent + newContent;
    }
});

function preencherFormulario(dados) {

    $.ajax({
        url: "/cadastro-valor-coleta/" + dados,
        type: "GET",

        success: function (response) {
            if (response.data) {
                try {
                    $('#id_valor_coleta').val(response.data.id);
                    $('#valor').val(response.data.valor);
                } catch {

                }
            }
        },
        error: function () {
            $('#id_valor_coleta').val('');
            $('#valor').val('');
        }
    });
}

$(document).ready(function () {

    $('#id_terminal_baixa').on('select2:close', function (e) {
        var id_butuca = $('#id_butuca').val();
        var id_terminal_coleta = $('#id_terminal_coleta').val();
        var id_terminal_baixa = $('#id_terminal_baixa').val();
        var dados = id_butuca + '...' + id_terminal_coleta + '...' + id_terminal_baixa;

        preencherFormulario(dados);
    });



});









