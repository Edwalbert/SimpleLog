//Inicia os controles de formulário com a opção Formulário principal destacada
try {
    document.getElementById("exibir_formulario_principal").style.backgroundColor = "gray";
    document.getElementById("exibir_formulario_principal").style.border = "none"
} catch (Exception) {

}

//Define a rota atual para destacar o nav-item atual
var pagina_atual = window.location.href;
rota_atual = pagina_atual.split("/").pop();

if (rota_atual == 'cadastro-cavalo') {
    document.getElementById("nav-cavalo").classList.add("active");
}

if (rota_atual == 'cadastro-motorista') {
    document.getElementById("nav-motorista").classList.add("active");
}

if (rota_atual == 'cadastro-carreta') {
    document.getElementById("nav-carreta").classList.add("active");
}

if (rota_atual == 'cadastro-transportadora') {
    document.getElementById("nav-transportadora").classList.add("active");
}