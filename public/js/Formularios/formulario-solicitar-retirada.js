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

// function preencherFormulario(id_butuca) {

//     $.ajax({
//         url: "/buscar-valor-coleta/" + id_butuca,
//         type: "GET",

//         success: function (response) {
//             if (response.data) {
//                 try {

//                     $('#rota').empty();

//                     $('#rota').append($('<option>', {
//                         value: '',
//                         text: ''
//                     }));

//                     $.each(response.data, function (index, item) {
//                         $('#rota').append($('<option>', {
//                             value: item.id,
//                             text: item.terminal_coleta + ' -> ' + item.terminal_baixa
//                         }));
//                     });
//                 } catch {

//                 }
//             }
//         },
//         error: function () {
//             $('#id_valor_coleta').val('');
//             $('#valor').val('');
//         }
//     });


// }

function obterRota(id_butuca) {

    $.ajax({
        url: "/buscar-valor-coleta/id_butuca/" + id_butuca,
        type: "GET",

        success: function (response) {
            if (response.data) {
                try {
                    $('#rota').empty();
                    $('#rota').append($('<option>', {
                        value: '',
                        text: ''
                    }));
                    response.data.original.data.forEach(item => {
                        $('#rota').append($('<option>', {
                            value: item.id,
                            text: item.nome_depot + ' -> ' + item.nome_terminal_baixa
                        }));
                    });
                } catch {

                }
            }
        },
        error: function () {
            $('#id_valor_coleta').val('');
            $('#valor_butuca').val('');
        }
    });
}

function obterValorButuca(id, tipo_container) {
    $.ajax({
        url: "/buscar-valor-coleta/id/" + id,
        type: "GET",

        success: function (response2) {
            if (response2.data) {
                try {
                    var stringValor = response2.data.original.data[0].valor;
                    var valor = parseFloat(stringValor.replace(',', '.'));
                    $('#valor_butuca').val(valor);
                    var id_terminal = response2.data.original.data[0].id_terminal;

                } catch {

                }
            }


            $.ajax({
                url: "/cadastro-valor-terminal/" + id_terminal + '...' + tipo_container,
                type: "GET",

                success: function (response3) {

                    if (response3.data) {

                        try {
                            var valor_terminal = response3.data.valor
                            $('#valor_terminal').val(valor_terminal);

                            var total = valor + valor_terminal;
                            $('#valor_desconto').val(total);
                        } catch {

                        }
                    }
                },
                error: function () {
                    $('#valor_terminal').val('');
                }
            });

        },
        error: function () {

            $('#valor_butuca').val('');

        }
    });
}

function verificarDesconto(valor_desconto) {
    var valor_butuca = parseFloat($('#valor_butuca').val());
    var valor_terminal = parseFloat($('#valor_terminal').val());
    var total = parseFloat(valor_butuca + valor_terminal);
    var desconto = parseFloat($('#valor_desconto').val());


    if (desconto < total) {
        alert("Desconto menor do que o valor total\n\nJustifique no campo 'Observação'.");
        var campoObservacao = document.getElementById('observacao');
        campoObservacao.setAttribute('required', true);
    } else {
        campoObservacao.removeAttribute('required');
    }
}

$(document).ready(function () {

    $('#id_butuca').on('select2:close', function (e) {
        var id_butuca = $('#id_butuca').val();
        obterRota(id_butuca);
    });

    $('#rota').on('select2:close', function (e) {
        var id_rota = $('#rota').val();
        var tipo_container = $('#tipo_container').val();
        obterValorButuca(id_rota, tipo_container);
    });

    $('#tipo_container').on('select2:close', function (e) {
        var id_rota = $('#rota').val();
        var tipo_container = $('#tipo_container').val();
        obterValorButuca(id_rota, tipo_container);
    });

    $('#valor_desconto').on('blur', function (e) {
        var valor_desconto = $('#valor_desconto').val();
        verificarDesconto();
    });

});









