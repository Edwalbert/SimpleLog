function calcularAdiantamento(rota, id_cavalo) {
    var novaRota = rota.replace(/\//g, '...');
    $.ajax({
        url: "/verificar-registro/util/Rota/rota/" + novaRota,
        type: "GET",
        success: function (response) {
            var frete = response.data.frete;
            var seguro = response.data.seguro;
            $.ajax({
                url: "/verificar-registro/veiculos/Cavalo/id/" + id_cavalo,
                type: "GET",
                success: function (response1) {
                    var id_transportadora = response1.data.id_transportadora;

                    $.ajax({
                        url: "/verificar-registro/empresas/Transportadora/id/" + id_transportadora,
                        type: "GET",
                        success: function (response2) {
                            var comissao = response2.data.comissao;
                            var comissao_percentual = (100 - comissao) / 100;
                            var frete_liquido = frete * comissao_percentual - seguro;
                            var total_adiantamento = frete_liquido * 0.7;
                            var total_adiantamento_inteiro = Math.ceil(total_adiantamento / 100) * 100;

                            $('#valor').val(total_adiantamento_inteiro);

                            $('#valor').on('blur', function () {
                                var valor_formulario = $('#valor').value;
                                observacao = document.getElementById('observacao')
                                if (valor_formulario > total_adiantamento_inteiro) {
                                    observacao.setAttribute('required', true);
                                    observacao.setAttribute('placeholder', 'Justifique o valor 70%+');
                                    alert("Adiantamento maior que o autorizado!\n\nJustifique no campo 'Observação'.");
                                } else {
                                    observacao.removeAttribute('required');
                                    observacao.removeAttribute('placeholder');
                                }
                            });
                        },
                        error: function () {
                        }
                    });
                },
                error: function () {
                }
            });
        },
        error: function () {

        }
    });
}


function desabilitarSubmit() {
    var form = document.querySelector('form');
    var submitButton = document.getElementById('submit');
    var localCarregamento = document.getElementById('local_carregamento').value;
    var localColeta = document.getElementById('local_coleta').value;
    var localEntrega = document.getElementById('local_entrega').value;
    var posto = document.getElementById('id_posto').value;
    var placa = document.getElementById('id_cavalo').value;
    var dataCarregamento = document.getElementById('data_carregamento').value;
    var valor = document.getElementById('valor').value;
    if (
        localCarregamento &&
        localColeta &&
        localEntrega &&
        posto &&
        placa &&
        dataCarregamento &&
        valor
    ) {
        setTimeout(function () {
            submitButton.setAttribute('disabled', 'true');
        }, 10);
    } else {
        alert('Preencha todos os campos obrigatórios!')
    }
}



$(document).ready(function () {


    $('#id_cavalo').on('blur', function () {
        var coleta = $('#local_coleta').value;
        var carregamento = $('#local_carregamento').value;
        var entrega = $('#local_entrega').value;
        var id_cavalo = $('#id_cavalo').value;
        calcularAdiantamento(coleta + '/' + carregamento + '/' + entrega, id_cavalo);
    });
    $('#submit').on('click', function () {
        desabilitarSubmit();
    });
});