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

try {
    var chave_pix = document.getElementById('chave_pix');
    var label_chave_pix = document.getElementById('label_chave_pix');
    chave_pix.style.display = ('none');
    label_chave_pix.style.display = ('none');

} catch { }

function mudarCampoNome() {
    var campoNomeSelect = document.getElementById('div_nome_select');
    var campoCheckBox = document.getElementById('editar')

    if (campoCheckBox.checked) {
        campoNomeSelect.style.display = 'block';
    } else {
        campoNomeSelect.style.display = 'none';
        $(document).ready(function () {
            $('#id_butuca').val('');
            $('#nome').val('');
            $('#uf').val('');
            $('#cidade').val('');
            $('#email').val('');
            $('#id_conta_bancaria').val('');
            $('#numero_conta_bancaria').val('');
            $('#codigo_banco').val('');
            $('#agencia').val('');
            $('#tipo_conta').val('');
            $('#titularidade').val('');
            $('#pix').val('');
            $('#chave_pix').val('');
            $('#butuca').prop('checked', false);
            $('#terminal').prop('checked', false);
            $('#depot').prop('checked', false);
            $('.selectJs').trigger('change');
        });
    }
}
try {

    $(document).ready(function () {
        $('#id_butuca').val('');

        $('#id_butuca').on('select2:close', function (e) {
            var id_butuca = $(this).val();
            preencherFormulario(id_butuca);
        });

        function preencherFormulario(id_butuca) {
            if (id_butuca !== null) {
                $.ajax({
                    url: "/verificar-registro/empresas/Butuca/id/" + id_butuca,
                    type: "GET",

                    success: function (response) {
                        if (response.data) {
                            try {
                                $('#id_butuca').val(response.data.id);
                                $('#nome').val(response.data.nome);
                                $('#butuca').prop('checked', response.data.butuca);
                                $('#terminal').prop('checked', response.data.terminal);
                                $('#depot').prop('checked', response.data.depot);
                            } catch {

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
                                    $('.selectJs').trigger('change');
                                    document.getElementById('chave_pix').style.display = 'block';
                                    document.getElementById('label_chave_pix').style.display = 'block';
                                }
                            },
                        });

                        //Busca por endereço
                        var id_endereco = response.data.id_endereco;
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

                        //Busca por contato
                        var id_contato = response.data.id_contato;
                        $.ajax({
                            url: "/verificar-registro/util/Contato/id/" + id_contato,
                            type: "GET",

                            success: function (response3) {

                                if (response3.data) {
                                    $('#email').val(response3.data.email_1);
                                }
                            },
                        });

                        function reloadPage() {
                            location.reload(); // Recarrega a página quando a imagem é clicada
                        }
                    },
                });
            } else {
                $(document).ready(function () {
                    $('#nome').val('');
                    $('#uf').val('');
                    $('#cidade').val('');
                    $('#email').val('');
                    $('#id_conta_bancaria').val('');
                    $('#numero_conta_bancaria').val('');
                    $('#codigo_banco').val('');
                    $('#agencia').val('');
                    $('#tipo_conta').val('');
                    $('#titularidade').val('');
                    $('#pix').val('');
                    $('#chave_pix').val('');
                    $('.selectJs').trigger('change');
                    $('#butuca').prop('checked', false);
                    $('#terminal').prop('checked', false);
                    $('#depot').prop('checked', false);
                });
            }
        }

    });
} catch {
    console.log('erro');
}
$(document).ready(function () {

    function mostrarCamposTerminal(){
        
    }

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

    $('#pix').on('select2:close', function (e) {
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
                case 'CPF':
                    chave_pix.setAttribute('type', 'text');
                    chave_pix.setAttribute('maxlength', 11);
                    chave_pix.setAttribute('minlength', 11);
                    break;
                case 'TELEFONE':
                    chave_pix.setAttribute('type', 'text');
                    chave_pix.setAttribute('maxlength', 11);
                    chave_pix.setAttribute('minlength', 11);
                    break;
                case 'EMAIL':
                    chave_pix.setAttribute('type', 'email');
                    chave_pix.setAttribute('maxlength', 100);
                    break;
            }
        } else {
            chave_pix.style.display = 'none';
            label_chave_pix.style.display = 'none';
            chave_pix.setAttribute('required', false);
        }
    });


    $('#codigo_banco').on('blur', function () {
        var codigo_banco = $('#codigo_banco').val();
        console.log(codigo_banco);
        var nomeBancoInput = document.getElementById('div_nome_banco');

        if (codigo_banco == '085') {
            nomeBancoInput.style.display = 'block';
        } else {
            nomeBancoInput.style.display = 'none';
            $('#nome_banco').val('');
            $('.selectJs').trigger('change');
        }
    });



    $('#editar').on('click', function (e) {
        mudarCampoNome();
    })

});









