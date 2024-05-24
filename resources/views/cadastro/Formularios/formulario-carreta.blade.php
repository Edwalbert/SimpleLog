@extends('cadastro.Formularios.layout')

@section('title', $title)

@section('content')


<section class="section">
    <form method="POST" action="/cadastro-carreta" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de carreta</b></legend>
                <button class="tab" id="exibir_formulario_principal" type="button" onclick="exibirFormularioPrincipal()">Formulario Carreta</button>
                <button class="tab" id="exibir_formulario_documentos" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>

                <input type="text" name="id_carreta" id="id_carreta" style="display: none;" value="">
                <input type="text" name="id_crlv" id="id_crlv" style="display: none;" value="">
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
                    <input type="number" name="ano_fabricacao" id="ano_fabricacao" class="inputUser" required min="1950">
                    <label for="ano_fabricacao" class="labelInput">Ano Fabricação *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="ano_modelo" id="ano_modelo" class="inputUser" required min="1950">
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
                    <input type="text" name="chassi" id="chassi" class="inputUser" required maxlength="17" minlength="8">
                    <label for="chassi" class="labelInput">Chassi *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="cnpj_crlv" id="cnpj_crlv" class="inputUser" maxlength="14" minlength="14">
                    <label for="cnpj_crlv" class="labelInput">CNPJ CRLV *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="cpf_crlv" id="cpf_crlv" class="inputUser" maxlength="11" minlength="11">
                    <label for="cpf_crlv" class="labelInput">CPF Crlv</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="rntrc" id="rntrc" class="inputUser" required>
                    <label for="rntrc" class="labelInput">RNTRC *</label>
                </div>
                <br><br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="uf" class="labelDropDown" style="color: white;">UF *</label>
                    <select class="selectJs" name="uf" id="uf" style="width: 190px;">
                        <option value="0"></option>
                        @foreach($uf as $estado)
                        <option value="{{ $estado['sigla'] }}">{{ $estado['sigla'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="cidade" class="labelDropDown" style="color: white;">Cidade *</label>
                    <select class="selectJs" name="cidade" id="cidade" style="width: 260px;">
                        <option value="0"></option>
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="tipo" class="labelDropDown" style="color: white;">Tipo Carreta *</label>
                    <select class="selectJs" name="tipo" id="tipo" style="width: 160px;">
                        <option value="container">Container</option>
                        <option value="sider">Sider</option>
                    </select>
                </div>
                <br><br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="vincular_cavalo" class="labelDropDown" style="color: white;">Vincular cavalo *</label>
                    <select class="selectJs" name="vincular_cavalo" id="vincular_cavalo" style="width: 160px;">
                        <option value="0"></option>
                        @foreach($cavalos as $id => $placa)
                        <option value="{{ $id }}">{{ $placa }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="id_transportadora" class="labelDropDown" style="color: white;">Vincular transportadora *</label>
                    <select class="selectJs" name="id_transportadora" id="id_transportadora" style="width: 460px;">
                        <option value="0"></option>
                        @foreach($transportadoras as $id => $transportadora)
                        <option value="{{ $id }}">{{ $transportadora }}</option>
                        @endforeach
                    </select>
                </div>
                <br><br>
                <div class="div-form inputDate">
                    <input type="date" name="emissao_crlv" id="emissao_crlv" class="vctos">
                    <label for="emissao_crlv" class="labelvctos">Emissão CRLV *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_crlv" id="vencimento_crlv" class="vctos" required>
                    <label for="vencimento_crlv" class="labelvctos">Vencimento CRLV *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_alianca" id="vencimento_opentech_alianca" class="vctos">
                    <label for="vencimento_opentech_alianca" class="labelvctos">Vcto Op Aliança</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_minerva" id="vencimento_opentech_minerva" class="vctos">
                    <label for="vencimento_opentech_minerva" class="labelvctos">Vcto Op Minerva</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_seara" id="vencimento_opentech_seara" class="vctos">
                    <label for="vencimento_opentech_seara" class="labelvctos">Vcto Op Seara</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="checklist_alianca" id="checklist_alianca" class="vctos">
                    <label for="checklist_alianca" class="labelvctos">Check. Aliança</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="checklist_minerva" id="checklist_minerva" class="vctos">
                    <label for="checklist_minerva" class="labelvctos">Check. Minerva</label>
                </div>
                <div class="div-form inputBox" id="div_status" style="display:none;">
                    <label>Status</label>
                    <select name="status" id="status" class="inputSelect">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>
        <br><br>
        <div class="div-form box" id="formulario_documentos">
            <fieldset>
                <legend id="legend"><b>Documentos Carreta</b></legend>
                <button class="tab" id="exibir_formulario_principal_1" type="button" onclick="exibirFormularioPrincipal()">Formulario Carreta</button>
                <button class="tab" id="exibir_formulario_documentos_1" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <br><br><br>
                <div class="div-form mb-3 form-grid">
                    <div class="div-form mb-3">
                        <label for="formFile" id="label_doclv" class="form-label"><b>CRLV *<b></label>
                        <input class="form-control" type="file" id="doc_crlv" name="doc_crlv" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_crlv" href="" target="_blank">
                        <div id="visualizar_crlv" nome="visualizar_crlv">
                            <input class="nome_arquivo" type="text" id="nome_arquivo_crlv" name="nome_arquivo_crlv" disabled value="Nenhum arquivo CRLV">
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
                    <a class="links_visualizacao" id="link_rntrc" href="" target="_blank">
                        <div id="visualizar_rntrc" nome="visualizar_rntrc">
                            <input class="nome_arquivo" type="text" id="nome_arquivo_rntrc" name="nome_arquivo_rntrc" disabled value="Nenhum arquivo RNTRC">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <div class="div-form mb-3">
                    </div>
                    <br>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit1" class="submit">
            </fieldset>
        </div>
    </form>
</section>

<script src="{{ asset('js/Formularios/formulario-carreta.js') }}"></script>

@endsection