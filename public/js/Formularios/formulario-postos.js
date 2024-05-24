function fornecerCpfEdicao() {
    const url = window.location.href;
    const segments = url.split('/');
    const cpf = segments[segments.length - 1];
    const campoCpf = document.getElementById('cpf');
    if (!isNaN(cpf)) {
        campoCpf.value = cpf;
        preencherFormulario(cpf)
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

function preencherFormulario(cpf) {
    try {
        $.ajax({
            url: "/verificar-registro/pessoas/Motorista/cpf/" + cpf,
            type: "GET",
            success: function (response) {
                $('#id_motorista').val(response.data.id);
                $('#nome').val(response.data.nome);
                $('#numero_rg').val(response.data.numero_rg);
                $('#nome_pai').val(response.data.nome_pai);
                $('#nome_mae').val(response.data.nome_mae);
                $('#espelho_cnh').val(response.data.espelho_cnh);
                $('#uf_nascimento').val(response.data.uf_nascimento);
                $('#data_nascimento').val(response.data.data_nascimento);
                $('#emissao_cnh').val(response.data.emissao_cnh);
                $('#vencimento_cnh').val(response.data.vencimento_cnh);
                $('#primeira_cnh').val(response.data.primeira_cnh);
                $('#registro_cnh').val(response.data.registro_cnh);
                $('#renach').val(response.data.renach);
                $('#uf_cnh').val(response.data.uf_cnh);
                $('#categoria_cnh').val(response.data.categoria_cnh);
                $('#ear').val(response.data.ear);
                $('#id_local_residencia').val(response.data.id_local_residencia);
                $('#vincular_cavalo').val(response.data.id_cavalo);
                $('#codigo_senior').val(response.data.codigo_senior);
                $('#telefone').val(response.data.telefone);
                $('#id_transportadora').val(response.data.id_transportadora);
                $('#admissao').val(response.data.admissao);
                $('#integracao_cotramol').val(response.data.integracao_cotramol);
                $('#vencimento_aso').val(response.data.vencimento_aso);
                $('#vencimento_tdd').val(response.data.vencimento_tdd);
                $('#vencimento_tox').val(response.data.vencimento_tox);
                $('#vencimento_opentech_brf').val(response.data.vencimento_opentech_brf);
                $('#vencimento_opentech_alianca').val(response.data.vencimento_opentech_alianca);
                $('#vencimento_opentech_minerva').val(response.data.vencimento_opentech_minerva);
                $('#vencimento_opentech_seara').val(response.data.vencimento_opentech_seara);
                $('#brasil_risk_klabin').val(response.data.brasil_risk_klabin);
                $('#contato_pessoal_1_parentesco').val(response.data.contato_pessoal_1_parentesco);
                $('#contato_pessoal_2_parentesco').val(response.data.contato_pessoal_2_parentesco);
                $('#contato_pessoal_3_parentesco').val(response.data.contato_pessoal_3_parentesco);
                $('#status').val(response.data.status);

                buscarMunicipioNascimento(response.data.uf_nascimento, response.data.municipio_nascimento);
                buscarMunicipioCNH(response.data.uf_cnh, response.data.municipio_cnh);


                document.getElementById('div_status').style.display = "inline-block";
                document.getElementById("doc_cnh").removeAttribute("required");

                //Chama funções que devem ser executadas junto com a recuperação dos dados dos motoristas.
                buscarEndereco(response.data.id_local_residencia);
                buscarContatosPessoais(response.data.id_contato_pessoal_1, response.data.id_contato_pessoal_2, response.data.id_contato_pessoal_3);

                formatarLegends();
                formatarFieldsets();
                formatarSubmits();
                visualizarArquivos(response);
                exibirCamposInativos(response.data.status, response.data.rescisao, response.data.motivo_desligamento, response.data.obs_desligamento);
                carregarFotos(response.data.cpf, response.data.placa);
            },
            error: function () {
                console.log('Motorista não encontrado');
                document.getElementById("doc_cnh").setAttribute("required", "required");
            }
        });
    } catch (error) {
        console.log('Erro na requisição AJAX: ' + error);
    }
}

function buscarCEP(cep) {
    try {
        if (cep !== '') {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + cep + '/json/',
                dataType: 'json',
                success: function (data) {
                    if (!data.hasOwnProperty('erro')) {
                        $('#uf').val(data.uf);
                        $('#rua').val(data.logradouro);
                        $('#bairro').val(data.bairro);

                        buscarCidade(data.uf, data.localidade);
                    }
                },
                error: function () {
                    console.log('Erro ao consultar o CEP');
                }
            });
        }
    } catch (error) {
        console.log('Erro na requisição AJAX para buscar CEP: ' + error);
    }

}

function buscarEndereco(id_local_residencia) {
    try {
        $.ajax({
            url: "/verificar-registro/util/Endereco/id/" + id_local_residencia,
            type: "GET",
            success: function (response1) {
                if (response1.data) {
                    $('#cep').val(response1.data.cep);
                    $('#rua').val(response1.data.rua);
                    $('#numero').val(response1.data.numero);
                    $('#bairro').val(response1.data.bairro);

                    $('#uf').val(response1.data.uf);
                    $('#uf').blur();

                    buscarCidade(response1.data.uf, response1.data.cidade);
                }
            },
        });
    } catch (error) {
        console.log('Erro na requisição AJAX para buscar endereço do motorista: ' + error);
    }
}

function buscarContatosPessoais(id_1, id_2, id_3) {
    try {
        $.ajax({
            url: "/verificar-registro/util/Contato/id/" + id_1,
            type: "GET",

            success: function (response2) {

                if (response2.data) {
                    $('#id_contato_pessoal_1').val(response2.data.id);
                    $('#contato_pessoal_1').val(response2.data.telefone_1);
                    $('#contato_pessoal_1_nome').val(response2.data.nome);
                }

            },
        });

        $.ajax({
            url: "/verificar-registro/util/Contato/id/" + id_2,
            type: "GET",

            success: function (response3) {
                if (response3.data) {
                    $('#id_contato_pessoal_2').val(response3.data.id);
                    $('#contato_pessoal_2').val(response3.data.telefone_1);
                    $('#contato_pessoal_2_nome').val(response3.data.nome);
                }

            },
        });

        $.ajax({
            url: "/verificar-registro/util/Contato/id/" + id_3,
            type: "GET",

            success: function (response4) {
                if (response4.data) {
                    $('#id_contato_pessoal_3').val(response4.data.id);
                    $('#contato_pessoal_3').val(response4.data.telefone_1);
                    $('#contato_pessoal_3_nome').val(response4.data.nome);
                }

            },
        });
    } catch (error) {
        console.log('Erro na requisição AJAX para buscar contatos pessoais: ' + error);
    }
}

function buscarMunicipioNascimento(uf, municipio_nascimento) {
    try {
        $.ajax({
            url: '/consultar-municipios/' + uf,
            dataType: 'json',
            success: function (data) {
                if (!data.hasOwnProperty('erro')) {

                    $('#municipio_nascimento').empty();

                    for (var i = 0; i < data.length; i++) {
                        var municipio = data[i].nome;
                        var option = $('<option>').text(municipio).val(municipio);
                        $('#municipio_nascimento').append(option);

                    }
                    $('#municipio_nascimento').val(municipio_nascimento);
                }

            },
            error: function () {
                console.log('Erro ao consultar municípios de nascimento');
            }
        });
    } catch (error) {
        console.log('Erro na requisição AJAX para buscar municípios de nascimento: ' + error);
    }
}



function buscarCidade(uf, cidade) {
    try {

        if (cidade !== undefined) {
            $.ajax({
                url: '/consultar-municipios/' + uf,
                dataType: 'json',
                success: function (data) {
                    if (!data.hasOwnProperty('erro')) {
                        $('#cidade').empty();

                        for (var i = 0; i < data.length; i++) {
                            var municipio = data[i].nome;
                            var option = $('<option>').text(municipio).val(municipio);
                            $('#cidade').append(option);
                        }

                        $('#cidade').val(cidade);
                    }
                },
                error: function () {
                    console.log('Erro ao consultar cidade de residencia');
                }
            });
        } else {
            $.ajax({
                url: '/consultar-municipios/' + uf,
                dataType: 'json',
                success: function (data) {
                    if (!data.hasOwnProperty('erro')) {
                        $('#cidade').empty();

                        for (var i = 0; i < data.length; i++) {
                            var municipio = data[i].nome;
                            var option = $('<option>').text(municipio).val(municipio);
                            $('#cidade').append(option);
                        }
                    }
                },
                error: function () {
                    console.log('Erro ao consultar cidade de residencia');
                }
            });
        }
    } catch (error) {
        console.log('Erro na requisição AJAX para buscar municípios de residência: ' + error);
    }
}


function buscarMunicipioCNH(uf, municipio_cnh) {
    try {
        $.ajax({
            url: '/consultar-municipios/' + uf,
            dataType: 'json',
            success: function (data) {
                if (!data.hasOwnProperty('erro')) {

                    $('#municipio_cnh').empty();

                    for (var i = 0; i < data.length; i++) {
                        var municipio = data[i].nome;
                        var option = $('<option>').text(municipio).val(municipio);
                        $('#municipio_cnh').append(option);
                    }
                    $('#municipio_cnh').val(municipio_cnh);
                }

            },
            error: function () {
                console.log('Erro ao consultar municípios da CNH');
            }
        });
    } catch (error) {
        console.log('Erro na requisição AJAX para buscar municípios da CNH: ' + error);
    }
}

function searchCavalo(id) {
    try {
        $.ajax({
            url: "/verificar-registro/veiculos/cavalo/id/" + id,
            type: "GET",
            success: function (cavalo) {
                if (cavalo.data) {
                    $('#id_transportadora').val(cavalo.data.id_transportadora);
                }
            },
        });
    } catch (error) {
        console.log('Erro na requisição AJAX para buscar dados do cavalo: ' + error);
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


function carregarFotos(cpf) {

    if (cpf !== null) {
        var div_foto_motorista = document.getElementById('foto-perfil-motorista');
        div_foto_motorista.style.display = "none";

        var foto_motorista = document.getElementById('foto-motorista');
        foto_motorista.src = '/storage/documents/motoristas/foto-motorista/' + cpf + '-foto-motorista.jpeg';

        foto_motorista.onload = function () {
            div_foto_motorista.style.display = "inline-block";
        };
        foto_motorista.onerror = function () {
            console.log('Imagem não encontrada.');
        };
    } else {
        var div_foto_motorista = document.getElementById('foto-perfil-motorista');
        div_foto_motorista.style.display = "none";
    }

    var selectedValue = $('#vincular_cavalo').val();
    var placa = $('#vincular_cavalo option[value="' + selectedValue + '"]').text();

    if (placa !== null) {
        var div_foto_cavalo = document.getElementById('foto-perfil-cavalo');
        div_foto_cavalo.style.display = "none";

        var foto_cavalo = document.getElementById('foto-cavalo');
        foto_cavalo.src = 'storage/documents/veiculos/foto-cavalo/' + placa + '-foto.jpeg';

        foto_cavalo.onload = function () {
            div_foto_cavalo.style.display = "inline-block";
        };

        foto_cavalo.onerror = function () {
            console.log('Imagem não encontrada.');
        };
    } else {
        var div_foto_cavalo = document.getElementById('foto-perfil-cavalo');
        div_foto_cavalo.style.display = "none";
    }



}

function visualizarArquivos(response) {
    try {


        //CNH: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_cnh !== null && response.data.path_cnh !== '/') {
            $('#nome_arquivo_cnh').val(response.data.nome + '-CNH.pdf');

            var path_cnh = response.data.path_cnh;
            var path_cnh_new = path_cnh.replace(/\//g, '...');
            link_cnh.setAttribute('href', 'download/' + path_cnh_new);
        }

        //Foto do Motorista: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_foto_motorista !== null && response.data.path_foto_motorista !== '/') {
            $('#nome_arquivo_foto_motorista').val(response.data.nome + '-Foto.jpeg');

            var path_foto_motorista = response.data.path_foto_motorista;
            var path_foto_motorista_new = path_foto_motorista.replace(/\//g, '...');
            link_foto_motorista.setAttribute('href', 'download/' + path_foto_motorista_new);
        }

        //Ficha de Registro: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_ficha_registro !== null && response.data.path_ficha_registro !== '/') {
            $('#nome_arquivo_ficha_registro').val(response.data.nome + '-Ficha Registro.pdf');

            var path_ficha_registro = response.data.path_ficha_registro;
            var path_ficha_registro_new = path_ficha_registro.replace(/\//g, '...');
            link_ficha_registro.setAttribute('href', 'download/' + path_ficha_registro_new);
        }

        //ASO: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_aso !== null && response.data.path_aso !== '/') {
            $('#nome_arquivo_aso').val(response.data.nome + '-ASO.pdf');

            var path_aso = response.data.path_aso;
            var path_aso_new = path_aso.replace(/\//g, '...');
            link_aso.setAttribute('href', 'download/' + path_aso_new);
        }

        //TOX: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_tox !== null && response.data.path_tox !== '/') {
            $('#nome_arquivo_tox').val(response.data.nome + '-TOX.pdf');

            var path_tox = response.data.path_tox;
            var path_tox_new = path_tox.replace(/\//g, '...');
            link_tox.setAttribute('href', 'download/' + path_tox_new);
        }

        //TDD: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_tdd !== null && response.data.path_tdd !== '/') {
            $('#nome_arquivo_tdd').val(response.data.nome + '-TDD.pdf');

            var path_tdd = response.data.path_tdd;
            var path_tdd_new = path_tdd.replace(/\//g, '...');
            link_tdd.setAttribute('href', 'download/' + path_tdd_new);
        }

        //Integração BRF: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_integracao_brf !== null && response.data.path_integracao_brf !== '/') {
            $('#nome_arquivo_integracao_brf').val(response.data.nome + '-Integração BRF.pdf');

            var path_integracao_brf = response.data.path_integracao_brf;
            var path_integracao_brf_new = path_integracao_brf.replace(/\//g, '...');
            link_integracao_brf.setAttribute('href', 'download/' + path_integracao_brf_new);
        }

        //Comprovante de Residência: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_comprovante_residencia !== null && response.data.path_comprovante_residencia !== '/') {
            $('#nome_arquivo_comprovante_residencia').val(response.data.nome + '-Comprovante Residência.pdf');

            var path_comprovante_residencia = response.data.path_comprovante_residencia;
            var path_comprovante_residencia_new = path_comprovante_residencia.replace(/\//g, '...');
            link_comprovante_residencia.setAttribute('href', 'download/' + path_comprovante_residencia_new);
        }

        //Treinamento Anti Tombamento: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_treinamento_anti_tombamento !== null && response.data.path_treinamento_anti_tombamento !== '/') {
            $('#nome_arquivo_treinamento_anti_tombamento').val(response.data.nome + '-Treinamento A.T.pdf');

            var path_treinamento_anti_tombamento = response.data.path_treinamento_anti_tombamento;
            var path_treinamento_anti_tombamento_new = path_treinamento_anti_tombamento.replace(/\//g, '...');
            link_treinamento_anti_tombamento.setAttribute('href', 'download/' + path_treinamento_anti_tombamento_new);
        }

        //Treinamento Percepção de risco Antigo 3ps: Trata o path do arquivo e atribui o downlaod
        if (response.data.path_treinamento_3ps !== null && response.data.path_treinamento_3ps !== '/') {
            $('#nome_arquivo_treinamento_3ps').val(response.data.nome + '-Treinamento 3Ps.pdf');

            var path_treinamento_3ps = response.data.path_treinamento_3ps;
            var path_treinamento_3ps_new = path_treinamento_3ps.replace(/\//g, '...');
            link_treinamento_3ps.setAttribute('href', 'download/' + path_treinamento_3ps_new);
        }
    } catch {
        console.log('Erro no tratamento dos arquivos para download!')
    }
}

function exibirCamposInativos(status, rescisao, motivo_desligamento, obs_desligamento) {

    if (status == 'Inativo') {
        try {
            document.getElementById('div_motivo_desligamento').style.display = "inline-block";
            document.getElementById('div_rescisao').style.display = "inline-block";
            document.getElementById('div_obs_desligamento').style.display = "inline-block";

            document.getElementById("motivo_desligamento").setAttribute("required", "required");
            document.getElementById("rescisao").setAttribute("required", "required");

            $('#rescisao').val(rescisao);
            $('#motivo_desligamento').val(motivo_desligamento);
            $('#obs_desligamento').val(obs_desligamento);
        } catch {
            console.log('erro ao mostrar Motivo desligamento');
        }

    } else {
        try {
            document.getElementById('div_motivo_desligamento').style.display = "none";
            document.getElementById('div_rescisao').style.display = "none";
            document.getElementById('div_obs_desligamento').style.display = "none";

            document.getElementById("#admissao").removeAttribute("required");
            document.getElementById("#motivo_desligamento").removeAttribute("required");
            document.getElementById("#rescisao").removeAttribute("required");
        } catch {
            console.log('Erro ao esconder campo motivo_desligamento');
        }
    }
}

function searchTransportadora(id) {
    if (id !== '') {
        console.log(id);
        $.ajax({
            url: "/verificar-registro/veiculos/cavalo/id/" + id,
            type: "GET",

            success: function (cavalo) {
                if (cavalo.data) {
                    $('#id_transportadora').val(cavalo.data.id_transportadora);
                }
            },
            error: function () {
                $('#id_transportadora').val('');
            }
        });
    }
}

$(document).ready(function () {

    $('#cep').on('blur', function () {
        buscarCEP($('#cep').val());
    });


    $('#uf').on('blur', function () {
        buscarCidade($('#uf').val());
    });

});