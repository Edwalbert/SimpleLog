/*
      *
      Controle geral de exibição de seções dos formulários
      * 
      */

try {
    document.getElementById("formulario_principal").style.display = "block";
} catch (error) { }

try {
    document.getElementById("formulario_contatos_pessoais").style.display = "none";
} catch (error) { }

try {
    document.getElementById("formulario_documentos").style.display = "none";
} catch (error) { }

try {
    document.getElementById("formulario_conta_bancaria").style.display = "none";
} catch (error) { }
//Exibe seção principal para todos os formulários

function exibirFormularioPrincipal() {

    document.getElementById("exibir_formulario_principal").style.backgroundColor = "gray";
    document.getElementById("exibir_formulario_principal").style.border = "none";

    try {
        document.getElementById("formulario_principal").style.display = "block";
    } catch (error) { }

    try {
        document.getElementById("formulario_contatos_pessoais").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_documentos").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_conta_bancaria").style.display = "none";
    } catch (error) { }
}

//Exibe seção documentos em todos os formulários
function exibirFormularioDocumentos() {
    try {
        document.getElementById("exibir_formulario_documentos_1").style.backgroundColor = "gray";
        document.getElementById("exibir_formulario_documentos_1").style.border = "none";    
    } catch (error) { console.log('Erro ao estilizar botão documentos') }
    try {
        document.getElementById("formulario_documentos").style.display = "block";
    } catch (error) { }

    try {
        document.getElementById("formulario_contatos_pessoais").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_principal").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_conta_bancaria").style.display = "none";
    } catch (error) { }
}

//Exibe seção conta bancária do formulário Cavalo
function exibirFormularioContaBancaria() {

    document.getElementById("exibir_formulario_conta_bancaria_2").style.backgroundColor = "gray";
    document.getElementById("exibir_formulario_conta_bancaria_2").style.border = "none";

    try {
        document.getElementById("formulario_conta_bancaria").style.display = "block";
    } catch (error) { }

    try {
        document.getElementById("formulario_contatos_pessoais").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_principal").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_documentos").style.display = "none";
    } catch (error) { }
}

//Exibe seção contatos pessoais no formulário motorista
function exibirFormularioContatosPessoais() {

    document.getElementById("exibir_formulario_contatos_pessoais_2").style.backgroundColor = "gray";
    document.getElementById("exibir_formulario_contatos_pessoais_2").style.border = "none";

    try {
        document.getElementById("formulario_contatos_pessoais").style.display = "block";
    } catch (error) { }

    try {
        document.getElementById("formulario_documentos").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_principal").style.display = "none";
    } catch (error) { }

    try {
        document.getElementById("formulario_conta_bancaria").style.display = "none";
    } catch (error) { }
}


