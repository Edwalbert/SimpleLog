@extends('cadastro.Formularios.layout')
@section('title', $title)
@section('content')

<section class="section">
    <form method="POST" action="/cadastro-cavalo" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de Cavalo</b></legend>
                <button class="tab" id="exibir_formulario_principal" type="button" onclick="exibirFormularioPrincipal()">Formulario Cavalo</button>
                <button class="tab" id="exibir_formulario_documentos" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <button class="tab" id="exibir_formulario_conta_bancaria" type="button" onclick="exibirFormularioContaBancaria()">Conta Bancaria</button>
                <div id="fotos-perfil" style="float: right; margin-right: 27px;">
                    <div class="div-form foto-perfil" id="foto-perfil-cavalo" style="display: none; margin-left:15px; border: 2px solid black; border-radius:5px;">
                        <img id="foto-cavalo" src="" alt="Imagem" width="150" height="150">
                    </div>
                    <br>
                </div>
                <br>
                <input type="text" name="id_cavalo" id="id_cavalo" style="display: none;" value="">
                <input type="text" name="id_crlv" id="id_crlv" style="display: none;" value="">
                <input type="text" name="id_conta_bancaria" id="id_conta_bancaria" style="display: none;" value="">
                <input type="text" name="id_endereco_crlv" id="id_endereco_crlv" style="display: none;" value="">
                <br>
                <div class="div-form inputBox">
                    <input type="text" name="placa" id="placa" class="inputUser" required maxlength="7" minlength="7">
                    <label for="placa" id="label_placa" class="labelInput">Placa *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="renavam" id="renavam" class="inputUser" required maxlength="11" minlength="11">
                    <label for="renavam" class="labelInput">Renavam *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="ano_fabricacao" id="ano_fabricacao" class="inputUser" required min="1970" max="{{ date('Y') }}">
                    <label for="ano_fabricacao" class="labelInput">Ano Fabricação *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="ano_modelo" id="ano_modelo" class="inputUser" required min="1970" max="{{ date('Y') + 1 }}">
                    <label for="ano_modelo" class="labelInput">Ano Modelo *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="numero_crv" id="numero_crv" class="inputUser" required>
                    <label for="numero_crv" class="labelInput">Número CRV *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="codigo_seguranca_cla" id="codigo_seguranca_cla" class="inputUser" required>
                    <label for="codigo_seguranca_cla" class="labelInput">Código de Segurança CLA *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="modelo" id="modelo" class="inputUser" required>
                    <label for="modelo" class="labelInput">Modelo *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="cor" id="cor" class="inputUser" required>
                    <label for="cor" class="labelInput">Cor *</label>
                </div>

                <div class="div-form inputBox">
                    <input type="text" name="chassi" id="chassi" class="inputUser" required maxlength="17">
                    <label for="chassi" class="labelInput">Chassi *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="rntrc" id="rntrc" class="inputUser" required>
                    <label for="rntrc" class="labelInput">RNTRC *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="cnpj_crlv" id="cnpj_crlv" class="inputUser" maxlength="14" minlength="14">
                    <label for="cnpj_crlv" class="labelInput">CNPJ CRLV *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="cpf_crlv" id="cpf_crlv" class="inputUser" maxlength="11" minlength="11">
                    <label for="cpf_crlv" class="labelInput">CPF CRLV *</label>
                </div>
                <br><br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="uf" class="labelDropDown" style="color: white;">UF *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="uf" id="uf" style="width: 190px;">
                        @foreach($uf as $estado)
                        <option value="{{ $estado['sigla'] }}">{{ $estado['sigla'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="cidade" class="labelDropDown" style="color: white;">Cidade *</label>
                    <select class="selectJs" name="cidade" id="cidade" style="width: 260px;">

                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="tecnologia" class="labelDropDown" style="color: white;">Tecnologia *</label>
                    <select class="selectJs" name="tecnologia" id="tecnologia" style="width: 190px;">
                        <option value="" selected></option>
                        <option value="Sascar">Sascar</option>
                        <option value="Onixsat">Onixsat</option>
                        <option value="Omnilink">Omnilink</option>
                        <option value="Autotrac">Autotrac</option>
                        <option value="Control Loc">Control Loc</option>
                        <option value="Km Rastreamento">Km Rastreamento</option>
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="telemetria" class="labelDropDown" style="color: white;">Telemetria *</label>
                    <select class="selectJs" name="telemetria" id="telemetria" style="width: 190px;">
                        <option value="1">Sim</option>
                    </select>
                </div>
                <br><br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="tipo_pedagio" class="labelDropDown" style="color: white;">Tipo Pedágio *</label>
                    <select class="selectJs" name="tipo_pedagio" id="tipo_pedagio" style="width: 190px;">
                        <option value="" selected></option>
                        <option value="TAG">TAG</option>
                        <option value="Cartão">Cartão</option>
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="grupo" class="labelDropDown" style="color: white;">Grupo *</label>
                    <select class="selectJs" name="grupo" id="grupo" style="width: 190px;">
                        <option value="Frota" selected>Frota</option>
                        <option value="Aliança">Aliança</option>
                        <option value="Capinzal">Capinzal</option>
                        <option value="Interno">Interno</option>
                        <option value="Serafina">Serafina</option>
                        <option value="Toledo">Toledo</option>
                        <option value="Vibra">Vibra</option>
                        <option value="GO/MT">GO/MT</option>
                        <option value="Spot">Spot</option>
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="id_transportadora" class="labelDropDown" style="color: white;">Vincular transportadora *</label>
                    <select class="selectJs" name="id_transportadora" id="id_transportadora">
                        <option value="0"></option>
                        @foreach($transportadoras as $id => $transportadora)
                        <option value="{{ $id }}">{{ $transportadora }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="id_rastreador" id="id_rastreador" class="inputUser" required>
                    <label for="id_rastreador" class="labelInput">Id Rastreador *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="login_tecnologia" id="login_tecnologia" class="inputUser" required>
                    <label for="login_tecnologia" class="labelInput">Login Tecnologia *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="senha_tecnologia" id="senha_tecnologia" class="inputUser" required>
                    <label for="senha_tecnologia" class="labelInput">Senha Tecnologia *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="id_pedagio" id="id_pedagio" class="inputUser" required>
                    <label for="id_pedagio" class="labelInput">Id Pedágio *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="certificado_cronotacografo" id="certificado_cronotacografo" class="inputUser" required>
                    <label for="certificado_cronotacografo" class="labelvctos">Certificado Cron. *</label>
                </div>
                <br>
                <div class="div-form inputDate">
                    <input type="date" name="emissao_crlv" id="emissao_crlv" class="vctos">
                    <label for="emissao_crlv" class="labelvctos">Emissão CRLV *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_crlv" id="vencimento_crlv" class="vctos" required>
                    <label for="vencimento_crlv" class="labelvctos">Vencimento CRLV *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_teste_fumaca" id="vencimento_teste_fumaca" class="vctos">
                    <label for="vencimento_teste_fumaca" class="labelvctos">Vcto T. Fumaça</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_cronotacografo" id="vencimento_cronotacografo" class="vctos">
                    <label for="vencimento_cronotacografo" class="labelvctos">Vcto Cron.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_minerva" id="vencimento_opentech_minerva" class="vctos">
                    <label for="vencimento_opentech_minerva" class="labelvctos">Vcto Op Minerva.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_alianca" id="vencimento_opentech_alianca" class="vctos">
                    <label for="vencimento_opentech_alianca" class="labelvctos">Vcto Op Aliança.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_seara" id="vencimento_opentech_seara" class="vctos">
                    <label for="vencimento_opentech_seara" class="labelvctos">Vcto Op Seara.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="checklist_alianca" id="checklist_alianca" class="vctos">
                    <label for="checklist_alianca" class="labelvctos">Check Aliança.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="checklist_minerva" id="checklist_minerva" class="vctos">
                    <label for="checklist_minerva" class="labelvctos">Check Minerva.</label>
                </div>

                <div class="div-form inputDate">
                    <input type="date" name="brasil_risk_klabin" id="brasil_risk_klabin" class="vctos">
                    <label for="brasil_risk_klabin" class="labelvctos">BRK</label>
                </div>
                <div class="div-form inputBox" id="div_status" style="display:none;">
                    <label>Status</label>
                    <select name="status" id="status" class="inputSelect" required>
                        <option value="Ativo" selected>Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit" class="submit">
            </fieldset>
        </div>
        <br><br>
        <div class="div-form box formulario_documentos" id="formulario_documentos">
            <fieldset>
                <legend><b>Documentos Cavalo</b></legend>
                <button class="tab" id="exibir_formulario_principal_1" type="button" onclick="exibirFormularioPrincipal()">Formulario Cavalo</button>
                <button class="tab" id="exibir_formulario_documentos_1" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <button class="tab" id="exibir_formulario_conta_bancaria_1" type="button" onclick="exibirFormularioContaBancaria()">Conta Bancaria</button>
                <br><br><br>
                <div class="div-form mb-3 form-grid">
                    <div class="div-form mb-3">
                        <label for="formFile" id="label_doc_crlv" class="form-label"><b>CRLV *<b></label>
                        <input class="form-control" type="file" id="doc_crlv" name="doc_crlv" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao div-form visualizar_arquivos" id="link_crlv" href="" target="_blank">
                        <div id="visualizar_crlv" nome="visualizar_crlv">
                            <input type="text" class="nome_arquivo" id="nome_arquivo_crlv" name="nome_arquivo_crlv" disabled value="Nenhum arquivo CRLV">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br><br>
                    <div class="div-form mb-3">
                        <label for="formFile" id="label_doc_rntrc" class="form-label"><b>RNTRC</b></label>
                        <input class="form-control" type="file" id="doc_rntrc" name="doc_rntrc" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao div-form visualizar_arquivos" id="link_rntrc" href="" target="_blank">
                        <div id="visualizar_rntrc" nome="visualizar_rntrc">
                            <input class="nome_arquivo" type="text" class="input_visualizacao" id="nome_arquivo_rntrc" name="nome_arquivo_rntrc" disabled value="Nenhum arquivo RNTRC">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br><br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Teste de Fumaça</b></label>
                        <input class="form-control" type="file" id="doc_teste_fumaca" name="doc_teste_fumaca" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao div-form visualizar_arquivos" id="link_teste_fumaca" href="" target="_blank">
                        <div id="visualizar_teste_fumaca" nome="visualizar_teste_fumaca">
                            <input class="nome_arquivo" type="text" class="input_visualizacao" id="nome_arquivo_teste_fumaca" name="nome_arquivo_teste_fumaca" disabled value="Nenhum arquivo T. F.">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br><br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Foto Frontal Cavalo</b></label>
                        <input class="form-control" type="file" id="doc_foto_cavalo" name="doc_foto_cavalo" accept="image/jpeg">
                    </div>
                    <a class="links_visualizacao div-form visualizar_arquivos" id="link_foto_cavalo" href="" target="_blank">
                        <div id="visualizar_foto_cavalo" nome="visualizar_foto_cavalo">
                            <input class="nome_arquivo" type="text" class="input_visualizacao" id="nome_arquivo_foto_cavalo" name="nome_arquivo_foto_cavalo" disabled value="Nenhuma foto">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit1" class="submit">
        </div>
        <div class="div-form box" id="formulario_conta_bancaria">
            <fieldset>
                <legend>Conta Bancária</legend>
                <button class="tab" id="exibir_formulario_principal_2" type="button" onclick="exibirFormularioPrincipal()">Formulario Cavalo</button>
                <button class="tab" id="exibir_formulario_documentos_2" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <button class="tab" id="exibir_formulario_conta_bancaria_2" type="button" onclick="exibirFormularioContaBancaria()">Conta Bancaria</button>
                <br><br><br>
                <div class="div-form inputBox">
                    <input type="text" name="numero_conta_bancaria" id="numero_conta_bancaria" class="inputUser" maxlength="10">
                    <label for="numero_conta_bancaria" class="labelInput">Número conta</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="codigo_banco" id="codigo_banco" class="inputUser">
                    <label for="codigo_banco" class="labelInput">Código do banco</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="agencia" id="agencia" class="inputUser">
                    <label for="agencia" class="labelInput">Agência</label>
                </div>
                <label>Tipo Conta</label>
                <select name="tipo_conta" id="tipo_conta" class="inputSelect">
                    <option value="" selected>n/s</option>
                    <option value="CC">CC</option>
                    <option value="CI">CI</option>
                </select>
                <br><br><br>
                <label>Titularidade</label>
                <select name="titularidade" id="titularidade" class="inputSelect">
                    <option value="">n/s</option>
                    <option value="PJ">PJ</option>
                    <option value="PF">PF</option>
                </select>
                <label>Pix</label>
                <select name="pix" id="pix" class="inputSelect" value=>
                    <option value="">Não</option>
                    <option value="CNPJ">CNPJ</option>
                    <option value="Email 1">Email 1</option>
                    <option value="Email 2">Email 2</option>
                    <option value="Tel 1">Tel 1</option>
                    <option value="Tel 2">Tel 2</option>
                </select>
                <div class="div-form inputBox">
                    <input type="text" name="chave_pix" id="chave_pix" class="inputUser">
                    <label for="chave_pix" id="label_chave_pix" class="labelInput">Chave Pix</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit2" class="submit">
        </div>
        </fieldset>
    </form>
    </div>
</section>
<script src="{{ asset('js/Formularios/formulario-cavalo.js') }}"></script>
@endsection