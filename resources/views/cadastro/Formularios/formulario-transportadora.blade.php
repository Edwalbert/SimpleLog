@extends('cadastro.Formularios.layout')

@section('title', $title)

@section('content')


<section class="section">
    <form method="POST" action="/cadastro-transportadora" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de transportadora</b></legend>
                <button class="tab" id="exibir_formulario_principal" type="button" onclick="exibirFormularioPrincipal()">Formulario Transp.</button>
                <button class="tab" id="exibir_formulario_documentos" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <br>
                <input type="text" name="id_transportadora" id="id_transportadora" style="display: none;" value="">
                <input type="text" name="id_endereco" id="id_endereco" style="display: none;" value="">
                <input type="text" name="id_conta_bancaria" id="id_conta_bancaria" style="display: none;" value="">
                <input type="text" name="id_contador" id="id_contador" style="display: none;" value="">
                <input type="text" name="id_responsavel" id="id_responsavel" style="display: none;" value="">

                <div class="div-form inputBox">
                    <input type="text" name="cnpj" id="cnpj" class="inputUser" required maxlength="14" minlength="14">
                    <label for="cnpj" id="label_cnpj" class="labelInput">CNPJ *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="razao_social" id="razao_social" class="inputUser" required maxlength="100">
                    <label for="razao_social" class="labelInput">Razão Social *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="cep" id="cep" class="inputUser" required>
                    <label for="cep" class="labelInput">CEP *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="numero" id="numero" class="inputUser" required>
                    <label for="numero" class="labelInput">N° *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="bairro" id="bairro" class="inputUser" required>
                    <label for="bairro" class="labelInput">Bairro *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="uf" id="uf" class="inputUser uf" required maxlength="2">
                    <label for="uf" class="labelInput">UF *</label>
                </div>

                <div class="div-form inputBox">
                    <input type="text" name="inscricao_estadual" id="inscricao_estadual" class="inputUser" required>
                    <label for="inscricao_estadual" class="labelInput">Insc. Estadual *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="codigo_transportadora" id="codigo_transportadora" class="inputUser" required>
                    <label for="codigo_transportadora" class="labelInput">Cod. Transp. *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="codigo_cliente" id="codigo_cliente" class="inputUser" required>
                    <label for="codigo_cliente" class="labelInput">Cod. Cliente *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="codigo_fornecedor" id="codigo_fornecedor" class="inputUser" required>
                    <label for="codigo_fornecedor" class="labelInput">Cod. Fornecedor *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="rntrc" id="rntrc" class="inputUser" required>
                    <label for="rntrc" class="labelInput">RNTRC *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="nome_responsavel" id="nome_responsavel" class="inputUser" required>
                    <label for="nome_responsavel" class="labelInput">Nome Responsável *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="email_1" id="email_1" class="inputUser" required>
                    <label for="email_1" class="labelInput">Email 1 *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="email_2" id="email_2" class="inputUser" placeholder="opcional">
                    <label for="email_2" class="labelInput">Email 2</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="telefone_1" id="telefone_1" class="inputUser" required>
                    <label for="telefone_1" class="labelInput">Telefone 1 *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="telefone_2" id="telefone_2" class="inputUser" placeholder="opcional">
                    <label for="telefone_2" class="labelInput">Telefone 2</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="contador" id="contador" class="inputUser" required>
                    <label for="contador" class="labelInput">Contador *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="email_contador_1" id="email_contador_1" class="inputUser" required>
                    <label for="email_contador_1" class="labelInput">Email Contador 1 *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="email_contador_2" id="email_contador_2" class="inputUser" placeholder="opcional">
                    <label for="email_contador_2" class="labelInput">Email Contador 2</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="telefone_contador_1" id="telefone_contador_1" class="inputUser" required>
                    <label for="telefone_contador_1" class="labelInput">Telefone Contador 1 *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="telefone_contador_2" id="telefone_contador_2" class="inputUser" placeholder="opcional">
                    <label for="telefone_contador_2" class="labelInput">Telefone Contador 2</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="numero_conta" id="numero_conta" class="inputUser" required maxlength="10">
                    <label for="numero_conta" class="labelInput">Número conta *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="codigo_banco" id="codigo_banco" class="inputUser" required>
                    <label for="codigo_banco" class="labelInput">Código do banco *</label>
                </div>
                <div class="div-form inputBox" style="display:none;" id="nome_banco_div">
                    <label>Cooperativa *</label>
                    <select class="inputSelect" name="nome_banco" id="nome_banco">
                        <option value="Acentra">Acentra</option>
                        <option value="Acredicoop">Acredicoop</option>
                        <option value="Civia">Civia</option>
                        <option value="Credelesc">Credelesc</option>
                        <option value="Credifoz">Credifoz</option>
                        <option value="CredCrea">CredCrea</option>
                        <option value="Credicomin">Credicomin</option>
                        <option value="Crevisc">Crevisc</option>
                        <option value="Evolua">Evolua</option>
                        <option value="Transpocred">Transpocred</option>
                        <option value="Únilos">Únilos</option>
                        <option value="Viacredi">Viacredi</option>
                        <option value="Viacredi Alto Vale">Viacredi Alto Vale</option>
                    </select>
                </div>

                <div class="div-form inputBox">
                    <input type="text" name="agencia" id="agencia" class="inputUser" required>
                    <label for="agencia" class="labelInput">Agência *</label>
                </div>
                <div class="div-form inputBox">
                    <label>Tipo Conta *</label>
                    <select name="tipo_conta" id="tipo_conta" class="inputSelect">
                        <option value="CC">CC</option>
                        <option value="CI">CI</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label>Titularidade *</label>
                    <select name="titularidade" id="titularidade" class="inputSelect">
                        <option value="PJ">PJ</option>
                        <option value="PF">PF</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label>Pix *</label>
                    <select name="pix" id="pix" class="inputSelect" value=>
                        <option value="">Não</option>
                        <option value="CNPJ">CNPJ</option>
                        <option value="Email 1">Email 1</option>
                        <option value="Email 2">Email 2</option>
                        <option value="Tel 1">Tel 1</option>
                        <option value="Tel 2">Tel 2</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label>Situação *</label>
                    <select name="situacao" id="situacao" class="inputSelect">
                        <option value="Sócio">Sócio</option>
                        <option value="Terceiro">Terceiro</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label>Comissão</label>
                    <select id="comissao" name=" comissao" class="inputSelect">
                        <option value="5">5%</option>
                        <option value="8">8%</option>
                    </select>
                </div>
                <div class="div-form inputBox" id="div_status" style="display: none;">
                    <label>Status</label>
                    <select id="status" name=" status" class="inputSelect">
                        <option value="Ativo" selected>Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="div-form inputBox" id="div_motivo_desligamento" style="display:none;">
                    <label>Motivo desligamento</label>
                    <select id="motivo_desligamento" name="motivo_desligamento" class="inputSelect">

                        <option value=""></option>
                    </select>
                </div>
                <br><br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>

        <div class="div-form box" id="formulario_documentos">
            <fieldset>
                <legend><b>Documentos Transportadora</b></legend>
                <button class="tab" id="exibir_formulario_principal" type="button" onclick="exibirFormularioPrincipal()">Formulario Transp.</button>
                <button class="tab" id="exibir_formulario_documentos_1" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <br><br>
                <div class="div-form mb-3 form-grid">
                    <div class="div-form mb-3">
                        <label for="formFile" id="label_doc_cnpj" class="form-label">Cartão CNPJ *</label>
                        <input class="form-control" type="file" id="doc_cnpj" name="doc_cnpj" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_cnpj" href="" target="_blank">
                        <div id="visualizar_cnpj" nome="visualizar_cnpj">
                            <input type="text" id="nome_arquivo_cnpj" class="nome_arquivo" name="nome_arquivo_cnpj" disabled value="Nenhum arquivo CNPJ">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" id="label_doc_rntrc" class="form-label">RNTRC</label>
                        <input class="form-control" type="file" id="doc_rntrc" name="doc_rntrc" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_rntrc" href="" target="_blank">
                        <div id="visualizar_rntrc" nome="visualizar_rntrc">
                            <input type="text" id="nome_arquivo_rntrc" class="nome_arquivo" name="nome_arquivo_rntrc" disabled value="Nenhum arquivo RNTRC">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>

    </form>
</section>

<script src="{{ asset('js/Formularios/formulario-transportadora.js') }}"></script>

@endsection