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
        url: "/cadastro-valor-terminal/" + dados,
        type: "GET",

        success: function (response) {
            if (response.data) {
                try {
                    $('#id_valor_terminal').val(response.data.id);
                    $('#valor').val(response.data.valor);
                } catch {

                }
            }
        },
        error: function () {
            $('#id_valor_terminal').val('');
            $('#valor').val('');

        }
    });
}

$(document).ready(function () {

    $('#tipo_container').on('select2:close', function (e) {
        var id_butuca = $('#id_butuca').val();
        var tipo_container = $('#tipo_container').val();
        var dados = id_butuca + '...' + tipo_container;

        preencherFormulario(dados);
    });



});









