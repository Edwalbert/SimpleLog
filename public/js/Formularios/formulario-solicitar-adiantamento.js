function formatarLabels() {
    const labels = document.querySelectorAll('label');
    labels.forEach((label) => {
        if (label.textContent.includes('*')) {
            const labelContent = label.textContent;
            const updatedContent = labelContent.replace('*', '');
            const newContent = `<span style="color: yellow">*</span>`;
            label.innerHTML = updatedContent + newContent;
        }
    });
}

function preencherFormulario(id) {
    try {
        $.ajax({
            url: "/verificar-registro/util/Adiantamento/id/" + id,
            type: "GET",
            success: function (response) {
                var rota = response.data.rota;
                var partes = rota.split('/');
                if (partes.length === 3) {
                    var coleta = partes[0];
                    var carregamento = partes[1];
                    var entrega = partes[2];
                }
                $('#local_coleta').val(coleta);
                $('#local_carregamento').val(carregamento);
                $('#local_entrega').val(entrega);
                $('#id_cavalo').val(response.data.id_cavalo);
                $('#valor').val(response.data.valor);
                $('#id_posto').val(response.data.id_posto);
                $('#data_carregamento').val(response.data.data_carregamento);
                $('#observacao').val(response.data.observacao);
                $('#id_adiantamento').val(response.data.id);
                $('.selectJs').trigger('change');
                if (response.data.em_maos == 'on') {
                    $('#em_maos').prop('checked', true);
                }
            },
            error: function () {
            }
        });
    } catch (error) {
        console.log('Erro na requisição AJAX: ' + error);
    }
}


function formatarLegends() {
    try {
        var legendElement = document.getElementById('legend');
        var legendText = legendElement.innerText;
        var novoTexto = legendText.replace('Cadastro', 'Edição');
        legendElement.innerText = novoTexto;

        var legendElements = document.querySelectorAll('legend');

        for (var i = 0; i < legendElements.length; i++) {
            var legendElement = legendElements[i];
            legendElement.style.border = '2px solid black';
            legendElement.style.padding = '3px';
            legendElement.style.textAlign = 'center';
            legendElement.style.background = 'linear-gradient(to right, #008000, #FFFF00)';
            legendElement.style.backgroundColor = '';
            legendElement.style.borderRadius = '10px';
            legendElement.style.color = '#001D00';
            legendElement.style.width = '25%';
            legendElement.style.fontSize = '20px';
            var legendText = legendElement.innerText;
            var reloadText = legendText;
            legendElement.innerHTML = reloadText;
        }

        function reloadPage() {
            location.reload();
        }

    } catch (error) {
        console.log('Erro ao formatar as legendas: ' + error);
    }
}

function formatarFieldsets() {
    try {
        var fieldsetElements = document.querySelectorAll('fieldset');
        for (var i = 0; i < fieldsetElements.length; i++) {
            var fieldsetElement = fieldsetElements[i];
            fieldsetElement.style.borderImage = 'linear-gradient(to left, #FFFF00, #008000) 1';
        }
    } catch (error) {
        console.log('Erro ao formatar os fieldsets: ' + error);
    }
}

function formatarSubmits() {
    try {
        var submit = document.getElementById('submit');
        var submit1 = document.getElementById('submit1');
        var submit2 = document.getElementById('submit2');
        submit.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
        submit1.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
        submit2.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
    } catch (error) {
        console.log('Erro ao formatar os submits: ' + error);
    }
}

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
                                var valor_formulario = $('#valor').val();
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

    var url = window.location.href;
    var regex = /\/solicitar-adiantamento\/(\d+)/;
    var match = url.match(regex);

    if (match) {
        var id = match[1];
    }
    preencherFormulario(id);

    $('#id_cavalo').on('select2:close', function (e) {
        var coleta = $('#local_coleta').val();
        var carregamento = $('#local_carregamento').val();
        var entrega = $('#local_entrega').val();
        var id_cavalo = $('#id_cavalo').val();
        calcularAdiantamento(coleta + '/' + carregamento + '/' + entrega, id_cavalo);
    });

    $('#submit').on('click', function () {
        desabilitarSubmit();
    });

    $('#local_carregamento').on('blur', function (e) {
        console.log('teste');
    });

    $('.selectJs').select2();


    $(document).on('focus', '.select2', function (e) {
        $(this).siblings('select').select2('open');
    });

});

