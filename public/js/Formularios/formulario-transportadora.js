
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
//Zera os valores dos campos do tipo select que devem iniciar zerados
document.getElementById('tipo_conta').selectedIndex = -1;
document.getElementById('titularidade').selectedIndex = -1;
document.getElementById('situacao').selectedIndex = -1;
document.getElementById('comissao').selectedIndex = -1;
document.getElementById('nome_banco').selectedIndex = -1;

//Escolhe a comissão com base na situação Sócio ou Terceiro
$(document).ready(function () {
    $('#situacao').on('blur', function () {
        var situacao = $('#situacao').val();

        if (situacao == 'Sócio') {
            $('#comissao').val(5);
        }

        if (situacao == 'Terceiro') {
            $('#comissao').val(8);
        }
    });
});

//Verifica se o código do banco é Ailos, e caso positivo solicita qual cooperativa de crédito se trata
$(document).ready(function () {
    $('#codigo_banco').on('blur', function () {

        var codigo_banco = $('#codigo_banco').val();

        if (codigo_banco == '085' || codigo_banco == '85') {
            document.getElementById("nome_banco_div").style.display = "block";
            document.getElementById("nome_banco").setAttribute("required", "required");
        } else {
            document.getElementById("#nome_banco_div").style.display = "none";
            document.getElementById("#nome_banco").removeAttribute("required");
        }
    });
});

//Verifica se o status é inativo, caso positivo, exibe a opção motivo desligamento e a torna obrigatória
$(document).ready(function () {
    $('#status').on('blur', function () {

        var status = $('#status').val();

        if (status == 'Inativo') {
            document.getElementById("div_motivo_desligamento").style.display = "block";
            document.getElementById("motivo_desligamento").setAttribute("required", "required");
        } else {
            document.getElementById("div_motivo_desligamento").style.display = "none";
            document.getElementById("motivo_desligamento").removeAttribute("required");
        }
    });
});



//Busca por transportadora no banco de dados
$(document).ready(function () {
    $('#cnpj').on('blur', function () {
        var cnpj = $(this).val();
        preencherFormulario(cnpj);
    });

    function preencherFormulario(cnpj) {
        $('id_transportadora').val('');
        $.ajax({
            url: "/verificar-registro/empresas/Transportadora/cnpj/" + cnpj,
            type: "GET",
            success: function (response) {
                $('#id_transportadora').val(response.data.id);
                $('#id_endereco').val(response.data.id_endereco);
                $('#id_conta_bancaria').val(response.data.id_conta_bancaria);

                $('#id_contador').val(response.data.id_contador);
                $('#id_responsavel').val(response.data.id_responsavel);
                $('#cnpj').val(response.data.cnpj);
                $('#razao_social').val(response.data.razao_social);
                $('#inscricao_estadual').val(response.data.inscricao_estadual);
                $('#codigo_transportadora').val(response.data.codigo_transportadora);
                $('#codigo_cliente').val(response.data.codigo_cliente);
                $('#codigo_fornecedor').val(response.data.codigo_fornecedor);
                $('#rntrc').val(response.data.rntrc);
                $('#situacao').val(response.data.situacao);
                $('#comissao').val(response.data.comissao);
                $('#status').val(response.data.status);
                $('#motivo_desligamento').val(response.data.motivo_desligamento);



                var labelCnpj = document.getElementById("label_cnpj");

                labelCnpj.style.top = "-20px";
                labelCnpj.style.fontSize = "12px";
                labelCnpj.style.color = "#75c58e";

                try {
                    document.getElementById("doc_cnpj").removeAttribute("required");
                    document.getElementById('div_status').style.display = "inline-block";

                    if (response.data.path_cnpj !== null) {
                        $('#nome_arquivo_cnpj').val(response.data.cnpj + '-CNPJ.pdf');


                        var path_cnpj = response.data.path_cnpj;
                        var path_cnpj_new = '...' + path_cnpj.replace(/\//g, '...');
                        link_cnpj.setAttribute('href', 'download/' + path_cnpj_new);
                    }


                    if (response.data.path_rntrc !== null) {
                        $('#nome_arquivo_rntrc').val(response.data.rntrc + '-RNTRC.pdf');

                        var path_rntrc = response.data.path_rntrc;
                        var path_rntrc_new = '...' + path_rntrc.replace(/\//g, '...');
                        link_rntrc.setAttribute('href', 'download/' + path_rntrc_new);
                    }

                } catch {
                    console.log('Erro ao tratar arquivos para download!')
                }


                //Busca por endereço
                var id_endereco = response.data.id_endereco;


                $.ajax({
                    url: "/verificar-registro/util/Endereco/id/" + id_endereco,
                    type: "GET",

                    success: function (response1) {
                        if (response1.data) {
                            $('#cep').val(response1.data.cep);
                            $('#endereco').val(response1.data.rua);
                            $('#numero').val(response1.data.numero);
                            $('#bairro').val(response1.data.bairro);
                            $('#cidade').val(response1.data.cidade);
                            $('#uf').val(response1.data.uf);
                        }
                    },
                });

                //Busca por contato responsável
                var id_responsavel = response.data.id_responsavel;

                $.ajax({
                    url: "/verificar-registro/util/Contato/id/" + id_responsavel,
                    type: "GET",

                    success: function (response2) {
                        if (response2.data) {
                            $('#nome_responsavel').val(response2.data.nome);
                            $('#email_1').val(response2.data.email_1);
                            $('#email_2').val(response2.data.email_2);
                            $('#telefone_1').val(response2.data.telefone_1);
                            $('#telefone_2').val(response2.data.telefone_2);
                        }
                    },
                });

                //Busca por contato contador
                var id_contador = response.data.id_contador;

                $.ajax({
                    url: "/verificar-registro/util/Contato/id/" + id_contador,
                    type: "GET",

                    success: function (response3) {
                        if (response3.data) {
                            $('#contador').val(response3.data.nome);
                            $('#email_contador_1').val(response3.data.email_1);
                            $('#email_contador_2').val(response3.data.email_2);
                            $('#telefone_contador_1').val(response3.data.telefone_1);
                            $('#telefone_contador_2').val(response3.data.telefone_2);
                        }
                    },
                });

                //Busca por conta bancária
                var id_conta_bancaria = response.data.id_conta_bancaria;

                $.ajax({
                    url: "/verificar-registro/util/ContaBancaria/id/" + id_conta_bancaria,
                    type: "GET",

                    success: function (response4) {
                        document.cookie = "registro_existente=true;";

                        if (response4.data) {
                            $('#numero_conta').val(response4.data.numero_conta_bancaria);
                            $('#codigo_banco').val(response4.data.codigo_banco);
                            $('#agencia').val(response4.data.agencia);
                            $('#tipo_conta').val(response4.data.tipo_conta);
                            $('#titularidade').val(response4.data.titularidade);
                            $('#pix').val(response4.data.pix);
                        }
                    },
                });

                try {
                    var legendElement = document.getElementById('legend');
                    var legendText = legendElement.innerText;
                    var novoTexto = legendText.replace('Cadastro', 'Edição');
                    legendElement.innerText = novoTexto;

                    var fieldsetElements = document.querySelectorAll('fieldset');
                    var legendElements = document.querySelectorAll('legend');

                    var submit = document.getElementById('submit');
                    submit.style.background = 'linear-gradient(to left, #FFFF00, #008000)';

                    for (var i = 0; i < legendElements.length; i++) {
                        var legendElement = legendElements[i];
                        legendElement.style.border = '2px solid black';
                        legendElement.style.padding = '3px';
                        legendElement.style.textAlign = 'center';
                        legendElement.style.background = 'linear-gradient(to left, #FFFF00, #008000)';
                        legendElement.style.backgroundColor = '';
                        legendElement.style.borderRadius = '10px';
                        legendElement.style.color = '#001D00';
                        legendElement.style.width = '28%';
                        legendElement.style.fontSize = '20px';

                        var legendText = legendElement.innerText;

                    }

                    function reloadPage() {
                        location.reload(); // Recarrega a página quando a imagem é clicada
                    }

                    for (var i = 0; i < fieldsetElements.length; i++) {
                        var fieldsetElement = fieldsetElements[i];
                        fieldsetElement.style.borderImage = 'linear-gradient(to left, #FFFF00, #008000) 1';
                    }
                } catch {
                    console.log('Erro ao tratar legendas e tema do modo edição!');
                }
            },
            error: function () {
                var cnpj = $('#cnpj').val().replace(/\D/g, '');

                if (cnpj !== '') {
                    $.ajax({
                        url: 'https://api-publica.speedio.com.br/buscarcnpj?cnpj=' + cnpj,
                        dataType: 'json',
                        success: function (data) {


                            if (!data.hasOwnProperty('erro')) {

                                var razaoSocial = data['RAZAO SOCIAL'].toLowerCase().replace(/\b\w/g, function (l) {
                                    return l.toUpperCase();
                                });

                                var cep = data.CEP;
                                var numero = data.NUMERO;

                                var bairro = data.BAIRRO.toLowerCase().replace(/\b\w/g, function (l) {
                                    return l.toUpperCase();
                                });

                                var cidade = data.MUNICIPIO.toLowerCase().replace(/\b\w/g, function (l) {
                                    return l.toUpperCase();
                                });

                                var uf = data.UF.toUpperCase();
                                var tipoLogradouro = data['TIPO LOGRADOURO'];
                                var logradouro = data.LOGRADOURO;
                                var complemento = data.COMPLEMENTO;

                                var enderecoCompleto = (tipoLogradouro + ' ' + logradouro + ' ' + complemento).toLowerCase().replace(/\b\w/g, function (l) {
                                    return l.toUpperCase();
                                });

                                $('#razao_social').val(razaoSocial);
                                $('#cep').val(cep);
                                $('#endereco').val(enderecoCompleto);
                                $('#numero').val(numero);
                                $('#bairro').val(bairro);
                                $('#cidade').val(cidade);
                                $('#uf').val(uf);

                            }
                        },
                        error: function () {
                            console.log('Erro ao consultar o CNPJ');
                        }
                    });
                }
            }
        });
    }
});


$(document).ready(function () {
    $('#status').on('blur', function () {
        var status = $(this).val();

        if (status == 'Inativo') {
            try {
                document.getElementById('motivo_desligamento').style.display = "inline-block";
                document.getElementById("motivo_desligamento").setAttribute("required", "required");
            } catch {
                console.log('erro ao mostrar Motivo desligamento');
            }
        } else {
            try {
                document.getElementById('motivo_desligamento').style.display = "none";
                document.getElementById("#motivo_desligamento").removeAttribute("required");
            } catch {
                console.log('Erro ao esconder campo motivo_desligamento');
            }
        }
    });
});


































// document.getElementById('tipo_conta').selectedIndex = -1;
// document.getElementById('titularidade').selectedIndex = -1;
// document.getElementById('situacao').selectedIndex = -1;
// document.getElementById('comissao').selectedIndex = -1;
// document.getElementById('nome_banco').selectedIndex = -1;

// //Verifica se o código do banco é Ailos, e caso positivo solicita qual cooperativa de crédito se trata
// $(document).ready(function () {
//     $('#codigo_banco').on('blur', function () {

//         var codigo_banco = $('#codigo_banco').val();

//         if (codigo_banco == '085' || codigo_banco == '85') {
//             document.getElementById("nome_banco_div").style.display = "block";
//             document.getElementById("nome_banco").setAttribute("required", "required");
//         } else {
//             document.getElementById("#nome_banco_div").style.display = "none";
//             document.getElementById("#nome_banco").removeAttribute("required");
//         }
//     });
// });

// //Verifica se o status é inativo, caso positivo, exibe a opção motivo desligamento e a torna obrigatória
// $(document).ready(function () {
//     $('#status').on('blur', function () {

//         var status = $('#status').val();

//         if (status == 'Inativo') {
//             document.getElementById("div_motivo_desligamento").style.display = "block";
//             document.getElementById("motivo_desligamento").setAttribute("required", "required");
//         } else {
//             document.getElementById("div_motivo_desligamento").style.display = "none";
//             document.getElementById("motivo_desligamento").removeAttribute("required");
//         }
//     });
// });



// //Busca por transportadora no banco de dados
// $(document).ready(function () {
//     $('#cnpj').on('blur', function () {
//         var cnpj = $(this).val();
//         preencherFormulario(cnpj);

//     });

//     function preencherFormulario(cnpj) {

//         $('id_transportadora').val('');
//         $.ajax({
//             url: "/simplelog-old-transportadora/" + cnpj,
//             type: "GET",
//             success: function (response) {

//                 $('#razao_social').val(response.data[0].r_social);
//                 $('#inscricao_estadual').val(response.data[0].insc_estadual);
//                 $('#codigo_transportadora').val(response.data[0].cod_transp);
//                 $('#codigo_cliente').val(response.data[0].cod_cliente);
//                 $('#codigo_fornecedor').val(response.data[0].cod_fornecedor);

//                 $('#rntrc').val(response.data[0].antt);

//                 $('#situacao').val(response.data[0].situacao);
//                 $('#comissao').val(response.data[0].comissao);
//                 $('#cep').val(response.data[0].cep_transp);
//                 $('#endereco').val(response.data[0].endereco);
//                 $('#numero').val(response.data[0].numero);
//                 $('#bairro').val(response.data[0].bairro_transp);
//                 $('#cidade').val(response.data[0].cidade_transp);
//                 $('#uf').val(response.data[0].uf_transp);
//                 $('#nome_responsavel').val(response.data[0].nome_responsavel);
//                 $('#email_1').val(response.data[0].email_1);
//                 $('#email_2').val(response.data[0].email_2);
//                 $('#telefone_1').val(response.data[0].tel_1);
//                 $('#telefone_2').val(response.data[0].tel_2);
//                 $('#contador').val(response.data[0].contador);
//                 $('#email_contador_1').val(response.data[0].email_contador_1);
//                 $('#email_contador_2').val(response.data[0].email_contador_2);
//                 $('#telefone_contador_1').val(response.data[0].tel_contador_1);
//                 $('#telefone_contador_2').val(response.data[0].tel_contador_2);
//                 $('#numero_conta').val(response.data[0].conta_bancaria);
//                 $('#codigo_banco').val(response.data[0].cod_banco);
//                 $('#agencia').val(response.data[0].agencia);
//                 $('#tipo_conta').val(response.data[0].tipo_conta);
//                 $('#titularidade').val(response.data[0].titularidade);
//                 $('#pix').val(response.data[0].pix);

//                 setTimeout(function () {
//                     $('#submit').click();
//                 }, 2000);
//             },
//             error: function () {
//             }
//         });
//     }
// });
