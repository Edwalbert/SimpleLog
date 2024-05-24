/*
*
Responsável por buscar o registro da placa cavalo no banco de dados.
Caso haja algum, ele preenche todos os dados tornando-se um formulário de edição.
* 
*/

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

$('#tipo_pedagio').val('');
$('#grupo').val('');

try {
    var chave_pix = document.getElementById('chave_pix');
    var label_chave_pix = document.getElementById('label_chave_pix');
    chave_pix.style.display = ('none');
    label_chave_pix.style.display = ('none');

} catch { }

$(document).ready(function () {
    $('#placa').on('blur', function () {
        var placa = $(this).val();
        preencherFormulario(placa);
    });

    function preencherFormulario(placa) {
        // Faça uma requisição AJAX para verificar a existência do registro no banco de dados

        $.ajax({
            url: "/verificar-registro/veiculos/Cavalo/placa/" + placa,
            type: "GET",

            success: function (response) {
                var link_crlv = document.getElementById('link_crlv');
                var link_rntrc = document.getElementById('link_rntrc');
                var link_cronotacografo = document.getElementById('link_cronotacografo');
                var link_teste_fumaca = document.getElementById('link_teste_fumaca');

                if (response.data) {
                    try {
                        $('#id_cavalo').val(response.data.id);
                        $('#placa').val(response.data.placa);
                        $('#rntrc').val(response.data.rntrc);
                        $('#id_transportadora').val(response.data.id_transportadora);
                        $('#tecnologia').val(response.data.tecnologia);
                        $('#telemetria').val(response.data.telemetria);
                        $('#id_rastreador').val(response.data.id_rastreador);
                        $('#tipo_pedagio').val(response.data.tipo_pedagio);
                        $('#id_pedagio').val(response.data.id_pedagio);
                        $('#grupo').val(response.data.grupo);
                        $('#login_tecnologia').val(response.data.login_tecnologia);
                        $('#senha_tecnologia').val(response.data.senha_tecnologia);
                        $('#certificado_cronotacografo').val(response.data.certificado_cronotacografo);
                        $('#vencimento_cronotacografo').val(response.data.vencimento_cronotacografo);
                        $('#vencimento_teste_fumaca').val(response.data.vencimento_teste_fumaca);
                        $('#vencimento_opentech_minerva').val(response.data.vencimento_opentech_minerva);
                        $('#vencimento_opentech_alianca').val(response.data.vencimento_opentech_alianca);
                        $('#vencimento_opentech_seara').val(response.data.vencimento_opentech_seara);
                        $('#checklist_alianca').val(response.data.checklist_alianca);
                        $('#checklist_minerva').val(response.data.checklist_minerva);
                        $('#brasil_risk_klabin').val(response.data.brasil_risk_klabin);
                        $('#status').val(response.data.status);
                        $('.selectJs').trigger('change');
                    } catch {

                    }

                    try {
                        document.getElementById('div_status').style.display = "inline-block";

                        // Obter o elemento placa pelo id
                        var labelPlaca = document.getElementById("label_placa");
                        var placaInput = document.getElementById("placa");

                        labelPlaca.style.top = "-20px";
                        labelPlaca.style.fontSize = "12px";
                        labelPlaca.style.color = "#75c58e";

                        // Obter o texto da opção selecionada
                        var placa = placaInput.value;

                        document.getElementById('foto-perfil-cavalo').style.display = "inline-block";
                        document.getElementById('foto-cavalo').src = 'storage/documents/veiculos/foto-cavalo/' + placa + '-FOTO-CAVALO.jpeg';
                    } catch {
                        console.log('Erro!')
                    }


                    try {
                        //RNTRC: Trata o path do arquivo e atribui o downlaod
                        if (response.data.path_rntrc !== null && response.data.path_rntrc !== '/') {
                            $('#nome_arquivo_rntrc').val(response.data.placa + '-RNTRC.pdf');

                            var path_rntrc = response.data.path_rntrc;
                            var path_rntrc_new = path_rntrc.replace(/\//g, '...');
                            link_rntrc.setAttribute('href', 'download/' + path_rntrc_new);
                        }

                        //TESTE FUMAÇA: Trata o path do arquivo e atribui o downlaod
                        if (response.data.path_teste_fumaca !== null && response.data.path_teste_fumaca !== '/') {
                            $('#nome_arquivo_teste_fumaca').val(response.data.placa + '-TF.pdf');

                            var path_teste_fumaca = response.data.path_teste_fumaca;
                            var path_teste_fumaca_new = path_teste_fumaca.replace(/\//g, '...');
                            link_teste_fumaca.setAttribute('href', 'download/' + path_teste_fumaca_new);
                        }

                        //FOTO: Trata o path da foto do cavalo e atribui o downlaod
                        if (response.data.path_foto_cavalo !== null && response.data.path_foto_cavalo !== '/') {
                            $('#nome_arquivo_foto_cavalo').val(response.data.placa + '-FOTO.jpeg');

                            var path_foto_cavalo = response.data.path_foto_cavalo;
                            var path_foto_cavalo_new = path_foto_cavalo.replace(/\//g, '...');
                            link_foto_cavalo.setAttribute('href', 'download/' + path_foto_cavalo_new);
                        }
                    } catch {
                        console.log('Erro ao tratar arquivos para download!')
                    }
                }

                //Busca por conta bancária
                var id_conta_bancaria = response.data.id_conta_bancaria;
                $.ajax({
                    url: "/verificar-registro/util/ContaBancaria/id/" + id_conta_bancaria,
                    type: "GET",

                    success: function (response3) {
                        document.cookie = "registro_existente=true;";

                        if (response3.data) {
                            $('#id_conta_bancaria').val(response.data.id_conta_bancaria);
                            $('#numero_conta_bancaria').val(response3.data.numero_conta_bancaria);
                            $('#codigo_banco').val(response3.data.codigo_banco);
                            $('#agencia').val(response3.data.agencia);
                            $('#tipo_conta').val(response3.data.tipo_conta);
                            $('#titularidade').val(response3.data.titularidade);
                            $('#pix').val(response3.data.pix);
                            $('#chave_pix').val(response3.data.chave_pix);

                            document.getElementById('chave_pix').style.display = 'block';
                            document.getElementById('label_chave_pix').style.display = 'block';
                        }
                    },
                });


                //Busca por crlv

                var id_crlv = response.data.id_crlv;
                $.ajax({
                    url: "/verificar-registro/documentos/Crlv/id/" + id_crlv,
                    type: "GET",

                    success: function (response1) {
                        document.cookie = "registro_existente=true;";

                        if (response1.data) {
                            try {
                                $('#id_crlv').val(id_crlv);
                                $('#renavam').val(response1.data.renavam);
                                $('#ano_fabricacao').val(response1.data.ano_fabricacao);
                                $('#ano_modelo').val(response1.data.ano_modelo);
                                $('#numero_crv').val(response1.data.numero_crv);
                                $('#cnpj_crlv').val(response1.data.cnpj_crlv);
                                $('#cpf_crlv').val(response1.data.cpf_crlv);
                                $('#codigo_seguranca_cla').val(response1.data.codigo_seguranca_cla);
                                $('#codigo_seguranca_cla').val(response1.data.codigo_seguranca_cla);
                                $('#modelo').val(response1.data.modelo);
                                $('#cor').val(response1.data.cor);
                                $('#chassi').val(response1.data.chassi);
                                $('#emissao_crlv').val(response1.data.emissao_crlv);
                                $('#vencimento_crlv').val(response1.data.vencimento_crlv);

                                if (response1.data.path_crlv !== '/' && response1.data.path_crlv !== null) {
                                    $('#nome_arquivo_crlv').val(response.data.placa + '-CRLV.pdf');
                                }
                            } catch { console.log('erro crlv'); }

                            var cidade = response.data.cidade;

                            $.ajax({
                                url: '/consultar-municipios/' + response.data.uf,
                                dataType: 'json',
                                success: function (data) {

                                    $('#cidade').val(response.data.cidade);

                                },
                                error: function () {
                                    console.log('Erro ao consultar municípios');
                                }
                            });


                            try {
                                var path_crlv = response1.data.path_crlv;
                                var path_crlv_new = path_crlv.replace(/\//g, '...');
                                link_crlv.setAttribute('href', 'download/' + path_crlv_new);
                                document.getElementById('doc_crlv').removeAttribute('required');
                            } catch {
                                console.log('busca por crlv falhou!');
                            }
                        }

                        //Busca por endereço
                        var id_endereco = response1.data.id_endereco;
                        $.ajax({
                            url: "/verificar-registro/util/Endereco/id/" + id_endereco,
                            type: "GET",

                            success: function (response2) {
                                document.cookie = "registro_existente=true;";
                                if (response2.data) {
                                    $('#id_endereco_crlv').val(response2.data.id);
                                    $('#uf').val(response2.data.uf);
                                    $('#cidade').val(response2.data.cidade);
                                    $('.selectJs').trigger('change');
                                    var cidade = response2.data.cidade;

                                    $.ajax({
                                        url: '/consultar-municipios/' + response2.data.uf,
                                        dataType: 'json',
                                        success: function (data) {
                                            if (!data.hasOwnProperty('erro')) {
                                                // Limpar o select antes de adicionar as novas opções
                                                $('#cidade').empty();

                                                // Adicionar as novas opções no select
                                                for (var i = 0; i < data.length; i++) {
                                                    var municipio = data[i].nome;
                                                    var option = $('<option>').text(municipio).val(municipio);
                                                    $('#cidade').append(option);
                                                }

                                                $('#cidade').val(cidade);
                                            }
                                        },
                                        error: function () {
                                            console.log('Erro ao consultar municípios');
                                        }
                                    });

                                }
                            },
                        });
                    },
                });


                try {

                    var legendElement = document.getElementById('legend');
                    var legendText = legendElement.innerText;
                    var novoTexto = legendText.replace('Cadastro', 'Edição');
                    legendElement.innerText = novoTexto;

                    var legendElements = document.querySelectorAll('legend');
                    legendElements.innerText = novoTexto;
                } catch {
                    console.log('Erro ao modificar legendas de Cadastro para Edição!');
                }

                var fieldsetElements = document.querySelectorAll('fieldset');

                var submit = document.getElementById('submit');
                var submit1 = document.getElementById('submit1');
                var submit2 = document.getElementById('submit2');

                submit.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
                submit1.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
                submit2.style.background = 'linear-gradient(to left, #FFFF00, #008000)';

                for (var i = 0; i < legendElements.length; i++) {
                    var legendElement = legendElements[i];
                    legendElement.style.border = '2px solid black';
                    legendElement.style.padding = '3px';
                    legendElement.style.textAlign = 'center';
                    legendElement.style.background = 'linear-gradient(to right, #008000, #FFFF00)';
                    legendElement.style.backgroundColor = '';
                    legendElement.style.borderRadius = '10px';
                    legendElement.style.color = '#001D00';
                    legendElement.style.width = '30%';
                    legendElement.style.fontSize = '20px';


                }

                function reloadPage() {
                    location.reload(); // Recarrega a página quando a imagem é clicada
                }

                for (var i = 0; i < fieldsetElements.length; i++) {
                    var fieldsetElement = fieldsetElements[i];
                    fieldsetElement.style.borderImage = 'linear-gradient(to left, #FFFF00, #008000) 1';
                }
            },
        });
    }
});


$(document).ready(function () {
    $('#emissao_crlv').on('blur', function () {
        var placa = $('#placa').val();
        var emissao_crlv = $('#emissao_crlv').val();
        calcularVencimentoCrlv(placa, emissao_crlv);
    });

    function calcularVencimentoCrlv(placa, emissao_crlv) {
        var final_placa = placa.charAt(placa.length - 1);

        var emissaoParts = emissao_crlv.split('-');
        var emissaoAno = parseInt(emissaoParts[0]);
        var emissaoMes = parseInt(emissaoParts[1]);
        var emissaoDia = parseInt(emissaoParts[2]);
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
    }

    function padZero(number) {
        return number.toString().padStart(2, '0');
    }
});


$(document).ready(function () {
    $('#id_transportadora').on('blur', function () {
        var placa = $('#placa').val();
        var emissao_crlv = $('#emissao_crlv').val();
    });
});

$(document).ready(function () {

    $('#uf').on('select2:close', function (e) {
        var uf = $(this).val();

        if (uf !== '') {
            console.log(uf);
            $.ajax({
                url: '/consultar-municipios/' + uf,
                dataType: 'json',
                success: function (data) {
                    if (!data.hasOwnProperty('erro')) {
                        // Limpar o select antes de adicionar as novas opções
                        $('#cidade').empty();

                        // Adicionar as novas opções no select
                        for (var i = 0; i < data.length; i++) {
                            var municipio = data[i].nome;
                            var option = $('<option>').text(municipio).val(municipio);
                            $('#cidade').append(option);
                        }
                    }
                },
                error: function () {
                    console.log('Erro ao consultar municípios');
                }
            });
        }
    });
});

$(document).ready(function () {
    $('#pix').on('blur', function () {
        var pix = $('#pix').val();
        var chave_pix = document.getElementById('chave_pix');
        var label_chave_pix = document.getElementById('label_chave_pix');

        if (pix !== 'NÃO') {
            chave_pix.style.display = 'block';
            label_chave_pix.style.display = 'block';
            chave_pix.setAttribute('required', true);
            chave_pix.setAttribute('maxlength', false);
            chave_pix.setAttribute('minlength', false);

            switch (pix) {
                case 'CNPJ':
                    chave_pix.setAttribute('type', 'text');
                    chave_pix.setAttribute('maxlength', 14);
                    chave_pix.setAttribute('minlength', 14);
                    break;
                case 'Email 1':
                    chave_pix.setAttribute('type', 'email');
                    chave_pix.setAttribute('maxlength', 100);
                    break;
                case 'Email 2':
                    chave_pix.setAttribute('type', 'email');
                    chave_pix.setAttribute('maxlength', 100);
                    break;
                case 'Tel 1':
                    chave_pix.setAttribute('type', 'text');
                    chave_pix.setAttribute('maxlength', 11);
                    chave_pix.setAttribute('minlength', 11);
                    break;
                case 'Tel 2':
                    chave_pix.setAttribute('type', 'text');
                    chave_pix.setAttribute('maxlength', 11);
                    chave_pix.setAttribute('minlength', 11);
                    break;
            }
        } else {
            chave_pix.style.display = 'none';
            label_chave_pix.style.display = 'none';
            chave_pix.setAttribute('required', false);
        }
    });
});









