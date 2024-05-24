

function configurarCamposAno() {
    const inputAnoFabricacao = document.getElementById('ano_fabricacao');
    const inputAnoModelo = document.getElementById('ano_modelo');
    const anoAtual = new Date().getFullYear();
    inputAnoFabricacao.setAttribute('max', anoAtual);
    inputAnoModelo.setAttribute('max', anoAtual + 1);
}


function formatarLegend() {
    try {
        var legendElements = document.querySelectorAll('legend');
        var legendElement = document.getElementById('legend');
        var legendText = legendElement.innerText;
        var novoTexto = legendText.replace('Cadastro', 'Edição');
        legendElement.innerText = novoTexto;

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
    } catch (error) {
        console.log('Erro ao formatar Legends');
    }
}

function reloadPage() {
    location.reload();
}

function formatarSubmit() {
    var submit = document.getElementById('submit');
    var submit1 = document.getElementById('submit1');

    submit.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
    submit1.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
}

function formatarFieldset() {
    var fieldsetElements = document.querySelectorAll('fieldset');

    for (var i = 0; i < fieldsetElements.length; i++) {
        var fieldsetElement = fieldsetElements[i];
        fieldsetElement.style.borderImage = 'linear-gradient(to left, #FFFF00, #008000) 1';
    }
}

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

function preencherFormulario(placa) {
    $.ajax({
        url: "/verificar-registro/veiculos/Carreta/placa/" + placa,
        type: "GET",
        success: function (response) {
            try {
                if (response.data) {
                    $('#id_carreta').val(response.data.id);
                    $('#placa').val(response.data.placa);
                    $('#rntrc').val(response.data.rntrc);
                    $('#id_transportadora').val(response.data.id_transportadora);
                    $('#vincular_cavalo').val(response.data.id_cavalo);
                    $('#vencimento_opentech_alianca').val(response.data.vencimento_opentech_alianca);
                    $('#vencimento_opentech_minerva').val(response.data.vencimento_opentech_minerva);
                    $('#vencimento_opentech_seara').val(response.data.vencimento_opentech_seara);
                    $('#checklist_alianca').val(response.data.checklist_alianca);
                    $('#checklist_minerva').val(response.data.checklist_minerva);
                    $('#categoria_cnh').val(response.data.categoria_cnh);
                    $('#status').val(response.data.status);
                    $('#tipo').val(response.data.tipo);
                    $('.selectJs').trigger('change');
                    document.getElementById('div_status').style.display = "inline-block";
                    document.getElementById('doc_crlv').removeAttribute('required');

                }

                buscarCrlv(response);
                buscarRntrc(response);
                formatarLegend();
                formatarSubmit();
                formatarFieldset();

            } catch (error) {
                console.log('Erro ao preencher dados da carreta' + error);
            }
        }
    });
}

function buscarRntrc(response) {
    try {
        if (response.data.path_rntrc !== null && response.data.path_rntrc !== '/') {

            $('#nome_arquivo_rntrc').val(response.data.placa + '-RNTRC.pdf');

            var path_rntrc = response.data.path_rntrc;
            var path_rntrc_new = '...' + path_rntrc.replace(/\//g, '...');
            link_rntrc.setAttribute('href', 'download/' + path_rntrc_new);
        }

    } catch {
        console.log('Erro ao tratar rntrc!');
    }
}

function buscarCrlv(response) {
    var id_crlv = response.data.id_crlv;

    $.ajax({
        url: "/verificar-registro/documentos/Crlv/id/" + id_crlv,
        type: "GET",
        success: function (response1) {

            try {
                if (response1 && response1.data) {
                    $('#id_crlv').val(response1.data.id);
                    $('#renavam').val(response1.data.renavam);
                    $('#ano_fabricacao').val(response1.data.ano_fabricacao);
                    $('#ano_modelo').val(response1.data.ano_modelo);
                    $('#numero_crv').val(response1.data.numero_crv);
                    $('#codigo_seguranca_cla').val(response1.data.codigo_seguranca_cla);
                    $('#modelo').val(response1.data.modelo);
                    $('#cor').val(response1.data.cor);
                    $('#chassi').val(response1.data.chassi);
                    $('#cnpj_crlv').val(response1.data.cnpj_crlv);
                    $('#cpf_crlv').val(response1.data.cpf_crlv);
                    $('#emissao_crlv').val(response1.data.emissao_crlv);
                    $('#vencimento_crlv').val(response1.data.vencimento_crlv);
                    buscarEnderecoCrlv(response1);

                    if (response.data.path_crlv !== null && response.data.path_crlv !== '/') {
                        $('#nome_arquivo_crlv').val(response.data.placa + '-CRLV.pdf');

                        var path_crlv = response1.data.path_crlv;
                        var path_crlv_new = path_crlv.replace(/\//g, '...');
                        link_crlv.setAttribute('href', 'download/' + path_crlv_new);
                    }
                }
            } catch (error) {
                console.log('Erro ao preencher dados do CRLV! ' + error);
            }
        },
    });
}

function buscarEnderecoCrlv(response1) {
    var id_endereco = response1.data.id_endereco;
    $.ajax({
        url: "/verificar-registro/util/Endereco/id/" + id_endereco,
        type: "GET",
        success: function (response2) {
            if (!response2.hasOwnProperty('erro')) {
                $('#id_endereco_crlv').val(id_endereco);
                $('#uf').val(response2.data.uf);

                $('#cidade').empty();
                buscarCidades(response2.data.uf, response2.data.cidade);
                $('#cidade').val(response2.data.cidade)
                $('.selectJs').trigger('change');
            }
        },
    });
}

function calcularVencimentoCrlv(placa, emissao_crlv) {
    var final_placa = placa.charAt(placa.length - 1);

    var emissaoParts = emissao_crlv.split('-');
    var emissaoAno = parseInt(emissaoParts[0]);
    var ano_vencimento = emissaoAno + 1;
    if (final_placa == 0) {
        var vencimentoAno = ano_vencimento;
        var vencimentoMes = 12;
        var vencimentoDia = 15;
    } else {
        var vencimentoAno = ano_vencimento;
        var vencimentoMes = parseInt(final_placa) + 2;
        var vencimentoDia = new Date(vencimentoAno, vencimentoMes, 0).getDate();
    }

    var vencimentoCrlv = vencimentoAno + '-' + padZero(vencimentoMes) + '-' + padZero(vencimentoDia);

    $('#vencimento_crlv').val(vencimentoCrlv);

    function padZero(number) {
        return number.toString().padStart(2, '0');
    }
}

function buscarCidades(uf, cidade) {

    if (uf !== '') {
        $.ajax({
            url: '/consultar-municipios/' + uf,
            dataType: 'json',
            success: function (data) {
                if (!data.hasOwnProperty('erro')) {
                    for (var i = 0; i < data.length; i++) {
                        var municipio = data[i].nome;
                        var option = $('<option>').text(municipio).val(municipio);
                        $('#cidade').append(option);
                    }
                    $('#uf').val(uf);
                    $('#cidade').val(cidade);
                    $('.selectJs').trigger('change');
                }
            },
            error: function () {
                console.log('Erro ao consultar municípios');
            }
        });
    }
}

function buscarTransportadora(id_cavalo) {
    if (id_cavalo !== '') {
        $.ajax({
            url: "/verificar-registro/veiculos/cavalo/id/" + id_cavalo,
            type: "GET",
            success: function (cavalo) {
                if (cavalo.data) {
                    $('#id_transportadora').val(cavalo.data.id_transportadora);
                }
            },
        });
    }
}

function verificarStatus(status) {
    if (status === 'Inativo') {
        $('#vincular_cavalo').val('');
    }
}

$(document).ready(function () {
    configurarCamposAno();
    formatarLabels();

    $('#placa').on('blur', function () {
        var placa = $(this).val();
        preencherFormulario(placa);
    });

    $('#emissao_crlv').on('blur', function () {
        var placa = $('#placa').val();
        var emissao_crlv = $('#emissao_crlv').val();
        calcularVencimentoCrlv(placa, emissao_crlv);
    });
    $('#uf').on('select2:close', function (e) {

        var uf = $(this).val();
        buscarCidades(uf, '');
    });

    $('#status').on('blur', function () {
        var status = $(this).val();
        verificarStatus(status);
    });
});






























// function preencherFormulario(placa) {
//     $.ajax({
//         url: "/simplelog-old-carreta/" + placa,
//         type: "GET",
//         success: function (response) {
//             try {
//                 if (response) {

//                     $('#placa').val(response.data[0].placa_cr);
//                     $('#rntrc').val(response.data[0].rntrc_cr);
//                     $('#vencimento_opentech_alianca').val(response.data[0].op_alianca_cr);
//                     $('#vencimento_opentech_minerva').val(response.data[0].op_minerva_cr);
//                     $('#vencimento_opentech_seara').val(response.data[0].op_seara_cr);
//                     $('#checklist_alianca').val(response.data[0].check_alianca_cr);
//                     $('#checklist_minerva').val(response.data[0].check_minerva_cr);
//                     $('#renavam').val(response.data[0].renavam_cr);
//                     $('#ano_fabricacao').val(response.data[0].ano_fabricacao_cr);
//                     $('#ano_modelo').val(response.data[0].ano_modelo_cr);
//                     $('#numero_crv').val(response.data[0].n_crv_cr);
//                     $('#codigo_seguranca_cla').val(response.data[0].cod_seguranca_cla_cr);
//                     $('#modelo').val(response.data[0].modelo_cr);
//                     $('#cor').val(response.data[0].cor_cr);
//                     $('#chassi').val(response.data[0].chassi_cr);
//                     $('#cnpj_crlv').val(response.data[0].cnpj_crlv_cr);
//                     $('#cpf_crlv').val(response.data[0].cpf_crlv_cr);
//                     $('#vencimento_crlv').val(response.data[0].data_crlv_cr);
//                     $('#uf').val(response.data[0].uf_cr);
//                     $('#cidade').val(response.data[0].cidade_cr);

//                     $('#uf').blur();

//                     var vincular_cavalo = document.getElementById('vincular_cavalo');

//                     for (var i = 0; i < vincular_cavalo.options.length; i++) {
//                         if (vincular_cavalo.options[i].text === response.data[0].cavalo_cr) {
//                             vincular_cavalo.value = vincular_cavalo.options[i].value;
//                             break;
//                         }
//                     }

//                     setTimeout(function () {
//                         $('#cidade').val(response.data[0].cidade_cr);
//                     }, 1500);

//                     $.ajax({
//                         url: "/verificar-registro/empresas/Transportadora/cnpj/" + response.data[0].cnpj_transp_cr,
//                         type: "GET",
//                         success: function (response1) {

//                             $('#id_transportadora').val(response1.data.id);

//                         },
//                         error: function () {
//                         }
//                     });



//                     setTimeout(function () {
//                         $('#submit').click();
//                     }, 2300);
//                 }

//             } catch (error) {
//                 console.log('Erro ao preencher dados da carreta' + error);
//             }
//         }
//     });
// }

// function buscarCidades(uf, cidade) {

//     if (uf !== '') {
//         $.ajax({
//             url: '/consultar-municipios/' + uf,
//             dataType: 'json',
//             success: function (data) {
//                 if (!data.hasOwnProperty('erro')) {

//                     $('#cidade').empty();

//                     for (var i = 0; i < data.length; i++) {
//                         var municipio = data[i].nome;
//                         var option = $('<option>').text(municipio).val(municipio);
//                         $('#cidade').append(option);
//                     }
//                     $('#cidade').val(cidade);
//                 }
//             },
//             error: function () {
//                 console.log('Erro ao consultar municípios');
//             }
//         });
//     }
// }


// $(document).ready(function () {

//     $('#placa').on('blur', function () {
//         var placa = $(this).val();
//         preencherFormulario(placa);
//     });

//     $('#emissao_crlv').on('blur', function () {
//         var placa = $('#placa').val();
//         var emissao_crlv = $('#emissao_crlv').val();
//         calcularVencimentoCrlv(placa, emissao_crlv);
//     });

//     $('#uf').on('blur', function () {
//         var uf = $(this).val();
//         buscarCidades(uf, '');
//     });


// });







