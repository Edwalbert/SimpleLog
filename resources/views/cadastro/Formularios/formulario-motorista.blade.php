@extends('cadastro.Formularios.layout')

@section('content')


<link rel="stylesheet" href="{{ asset('css/Formularios/formulario-motorista.css') }}">

<section class="section">
    <form method="POST" id="formulario_motorista" action="/cadastro-motorista" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de motorista</b></legend>
                <div>
                    <button class="tab" id="exibir_formulario_principal" type="button" onclick="exibirFormularioPrincipal()">Formulario Motorista</button>
                    <button class="tab" id="exibir_formulario_documentos" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                    <button class="tab" id="exibir_formulario_contatos_pessoais" type="button" onclick="exibirFormularioContatosPessoais()">Contatos Pessoais</button>
                </div>
                <div id="fotos-perfil" style="float: right; margin-right: 27px;">
                    <div class="div-form foto-perfil" id="foto-perfil-motorista" style="display: none; margin-left:15px; border: 2px solid black; border-radius:5px;">
                        <img id="foto-motorista" src="/" alt="Imagem" width="150" height="150">
                    </div>

                    <div class="div-form foto-perfil" id="foto-perfil-cavalo" style="display: none; margin-left:15px; border: 2px solid black; border-radius:5px;">
                        <img id="foto-cavalo" src="/" alt="Imagem" width="150" height="150">
                    </div>
                    <br>
                </div>
                <br>
                <input type="text" name="id_motorista" id="id_motorista" style="display: none;" value="">
                <input type="text" name="id_local_residencia" id="id_local_residencia" style="display: none;" value="">
                <input type="text" name="id_contato_pessoal_1" id="id_contato_pessoal_1" style="display: none;" value="">
                <input type="text" name="id_contato_pessoal_2" id="id_contato_pessoal_2" style="display: none;" value="">
                <input type="text" name="id_contato_pessoal_3" id="id_contato_pessoal_3" style="display: none;" value="">

                <div class="div-form inputBox">
                    <input type="text" name="cpf" id="cpf" class="inputUser" required maxlength="11" minlength="11">
                    <label for="cpf" id="label_cpf" class="labelInput">CPF *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="numero_rg" id="numero_rg" class="inputUser" required maxlength="11" minlength="5">
                    <label for="numero_rg" class="labelInput">RG *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="nome_pai" id="nome_pai" class="inputUser" required>
                    <label for="nome_pai" class="labelInput">Nome do Pai *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="nome_mae" id="nome_mae" class="inputUser" required>
                    <label for="nome_mae" class="labelInput">Nome da Mãe *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="data_nascimento" id="data_nascimento" class="vctos" required>
                    <label for="data_nascimento" class="labelvctos">Data Nasc. *</label>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="uf_nascimento" class="labelDropDown" style="color: white;">UF Nascimento *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="uf_nascimento" id="uf_nascimento" style="width: 100px;">
                        <option value="0"></option>
                        @foreach($uf as $estado)
                        <option value="{{ $estado['sigla'] }}">{{ $estado['sigla'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="municipio_nascimento" class="labelDropDown" style="color: white;">Cidade Nascimento *</label>
                    <select class="selectJs" name="municipio_nascimento" id="municipio_nascimento" style="width: 260px;">

                    </select>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="emissao_cnh" id="emissao_cnh" class="vctos" required>
                    <label for="emissao_cnh" class="labelvctos">Emissão CNH *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_cnh" id="vencimento_cnh" class="vctos" required>
                    <label for="vencimento_cnh" class="labelvctos">Vencimento CNH *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="primeira_cnh" id="primeira_cnh" class="vctos" required>
                    <label for="primeira_cnh" class="labelvctos">Primeira CNH *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="registro_cnh" id="registro_cnh" class="inputUser" required>
                    <label for="registro_cnh" class="labelInput">N° Registro CNH *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="espelho_cnh" id="espelho_cnh" class="inputUser" required>
                    <label for="espelho_cnh" class="labelInput">Espelho CNH *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="renach" id="renach" class="inputUser" required>
                    <label for="renach" class="labelInput">Renach *</label>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="categoria_cnh" class="labelDropDown" style="color: white;">Cat CNH *</label>
                    <select class="selectJs" name="categoria_cnh" id="categoria_cnh" style="width: 100px;">
                        <option value="" selected></option>
                        <option value="AE">AE</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="uf_cnh" class="labelDropDown" style="color: white;">UF *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="uf_cnh" id="uf_cnh" style="width: 100px;">
                        <option value="0"></option>
                        @foreach($uf as $estado)
                        <option value="{{ $estado['sigla'] }}">{{ $estado['sigla'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="municipio_cnh" class="labelDropDown" style="color: white;">Cidade *</label>
                    <select class="selectJs" name="municipio_cnh" id="municipio_cnh" style="width: 260px;">

                    </select>
                </div>
                <br><br>
                <div class="div-form inputBox">
                    <input type="string" name="codigo_senior" id="codigo_senior" class="inputUser" placeholder="opcional">
                    <label for="codigo_senior" class="labelInput">Cod Senior</label>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="ear" class="labelDropDown" style="color: white;">EAR *</label>
                    <select class="selectJs" name="ear" id="ear" style="width: 100px;">
                        <option value="" selected></option>
                        <option value="SIM">SIM</option>
                        <option value="NÃO">NÃO</option>
                    </select>
                </div>
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
                    <select class="selectJs" name="id_transportadora" id="id_transportadora">
                        <option value="0"></option>
                        @foreach($transportadoras as $id => $transportadora)
                        <option value="{{ $id }}">{{ $transportadora }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="telefone" id="telefone" class="inputUser" maxlength="11" minlength="11" required>
                    <label for="telefone" class="labelInput">Telefone *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="cep" id="cep" class="inputUser" required>
                    <label for="cep" class="labelInput">CEP Resid. *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="rua" id="rua" class="inputUser" required>
                    <label for="rua" class="labelInput">Rua Resid. *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="numero" id="numero" class="inputUser" required>
                    <label for="numero" class="labelInput">N° *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="bairro" id="bairro" class="inputUser" required>
                    <label for="bairro" class="labelInput">Bairro Resid. *</label>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="uf" class="labelDropDown" style="color: white;">UF *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="uf" id="uf" style="width: 100px;">
                        <option value="0"></option>
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
                <br>
                <div class="div-form inputDate">
                    <input type="date" name="admissao" id="admissao" class="vctos" required>
                    <label for="admissaod" class="labelvctos">Admissão *</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="integracao_cotramol" id="integracao_cotramol" class="vctos">
                    <label for="integracao_cotramol" class="labelvctos">Integ. Cotramol</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_aso" id="vencimento_aso" class="vctos">
                    <label for="vencimento_aso" class="labelvctos">Vencimento Aso.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_tox" id="vencimento_tox" class="vctos">
                    <label for="vencimento_tox" class="labelvctos">Vencimento. Tox.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_tdd" id="vencimento_tdd" class="vctos">
                    <label for="vencimento_tdd" class="labelvctos">Vencimento DD.</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_brf" id="vencimento_opentech_brf" class="vctos">
                    <label for="vencimento_opentech_brf" class="labelvctos">Opentech BRF</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_alianca" id="vencimento_opentech_alianca" class="vctos">
                    <label for="vencimento_opentech_alianca" class="labelvctos">Opentech Aliança</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_minerva" id="vencimento_opentech_minerva" class="vctos">
                    <label for="vencimento_opentech_minerva" class="labelvctos">Opentech Minerva</label>
                </div>
                <div class="div-form inputDate">
                    <input type="date" name="vencimento_opentech_seara" id="vencimento_opentech_seara" class="vctos">
                    <label for="vencimento_opentech_seara" class="labelvctos">Opentech Seara</label>
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
                <div class="div-form inputBox" id="div_rescisao" style="display:none;">
                    <label>Rescisão</label>
                    <select name="rescisao" id="rescisao" class="municipioSelect" required>
                        <option value="" selected></option>
                        <option value="Motorista pediu demissão" selected>Motorista pediu demissão</option>
                        <option value="Motorista foi demitido">Motorista foi demitido</option>
                    </select>
                </div>
                <div class="div-form inputBox" id="div_motivo_desligamento" style="display:none;">
                    <label>Motivo desligamento</label>
                    <select id="motivo_desligamento" name="motivo_desligamento" class="municipioSelect">
                        <option value="" selected></option>
                        <option value="Novo emprego com maior remuneração">Novo emprego com maior remuneração</option>
                        <option value="Novo emprego mais perto de casa">Novo emprego mais perto de casa</option>
                        <option value="Motorista não se adaptou">Motorista não se adaptou</option>
                        <option value="Mudança de cidade">Mudança de cidade</option>
                        <option value="Incompatibilidade com a empresa">Incompatibilidade com a empresa</option>
                        <option value="Fim de operação">Fim de operação</option>
                        <option value="Venda do veículo">Venda do veículo</option>
                    </select>
                </div>
                <div class="div-form inputBox" id="div_obs_desligamento" style="display:none;">
                    <input type="text" name="obs_desligamento" id="obs_desligamento" class="inputUser" maxlength="200">
                    <label for="obs_desligamento" id="label_obs_desligamento" class="labelInput">OBS Desligamento</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>
        <br><br>

        <div class="div-form box" id="formulario_documentos">
            <fieldset>
                <legend><b>Documentos Motorista</b></legend>
                <button class="tab" id="exibir_formulario_principal_1" type="button" onclick="exibirFormularioPrincipal()">Formulario Motorista</button>
                <button class="tab" id="exibir_formulario_documentos_1" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <button class="tab" id="exibir_formulario_contatos_pessoais_1" type="button" onclick="exibirFormularioContatosPessoais()">Contatos Pessoais</button>
                <br>
                <div class="div-form mb-3 form-grid">
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>CNH *</b></label>
                        <input class="form-control" type="file" id="doc_cnh" name="doc_cnh" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_cnh" href="" target="_blank">
                        <div id="visualizar_cnh" nome="visualizar_cnh">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_cnh" name="nome_arquivo_cnh" disabled value="Nenhum arquivo CNH">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Foto do Motorista</b></label>
                        <input class="form-control" type="file" id="foto_motorista" name="foto_motorista" accept="image/jpeg">
                    </div>
                    <a class="links_visualizacao" id="link_foto_motorista" href="" target="_blank">
                        <div id="visualizar_foto_motorista" nome="visualizar_foto_motorista">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_foto_motorista" name="nome_arquivo_foto_motorista" disabled value="Nenhuma Foto">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Ficha de Registro</b></label>
                        <input class="form-control" type="file" id="doc_ficha_registro" name="doc_ficha_registro" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_ficha_registro" href="" target="_blank">
                        <div id="visualizar_ficha_registro" nome="visualizar_ficha_registro">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_ficha_registro" name="nome_arquivo_ficha_registro" disabled value="Nenhuma Ficha de Registro">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Exame Admissional (ASO)</b></label>
                        <input class="form-control" type="file" id="doc_aso" name="doc_aso" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_aso" href="" target="_blank">
                        <div id="visualizar_aso" nome="visualizar_aso">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_aso" name="nome_arquivo_aso" disabled value="Nenhum Arquivo ASO">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Exame Toxicológico (TOX)</b></label>
                        <input class="form-control" type="file" id="doc_tox" name="doc_tox" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_tox" href="" target="_blank">
                        <div id="visualizar_tox" nome="visualizar_tox">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_tox" name="nome_arquivo_tox" disabled value="Nenhum Arquivo TOX">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Treinamento Direção Defensiva (TDD)</b></label>
                        <input class="form-control" type="file" id="doc_tdd" name="doc_tdd" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_tdd" href="" target="_blank">
                        <div id="visualizar_tdd" nome="visualizar_tdd">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_tdd" name="nome_arquivo_tdd" disabled value="Nenhum Arquivo TDD">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Integração BRF</b></label>
                        <input class="form-control" type="file" id="doc_integracao_brf" name="doc_integracao_brf" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_integracao_brf" href="" target="_blank">
                        <div id="visualizar_integracao_brf" nome="visualizar_integracao_brf">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_integracao_brf" name="nome_arquivo_integracao_brf" disabled value="Nenhuma Integração BRF">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Comprovante Resid.</b></label>
                        <input class="form-control" type="file" id="doc_comprovante_residencia" name="doc_comprovante_residencia" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_comprovante_residencia" href="" target="_blank">
                        <div id="visualizar_comprovante_residencia" nome="visualizar_comprovante_residencia">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_comprovante_residencia" name="nome_arquivo_comprovante_residencia" disabled value="Nenhum Comprovante de Residência">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Treinamento Anti Tombamento</b></label>
                        <input class="form-control" type="file" id="doc_treinamento_anti_tombamento" name="doc_treinamento_anti_tombamento" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_treinamento_anti_tombamento" href="" target="_blank">
                        <div id="visualizar_treinamento_anti_tombamento" nome="visualizar_treinamento_anti_tombamento">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_treinamento_anti_tombamento" name="nome_arquivo_treinamento_anti_tombamento" disabled value="Nenhum Treinamento A.T">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                    <div class="div-form mb-3">
                        <label for="formFile" class="form-label"><b>Percepção de Risco</b></label>
                        <input class="form-control" type="file" id="doc_treinamento_3ps" name="doc_treinamento_3ps" accept="application/pdf">
                    </div>
                    <a class="links_visualizacao" id="link_treinamento_3ps" href="" target="_blank">
                        <div id="visualizar_treinamento_3ps" nome="visualizar_treinamento_3ps">
                            <input Type="text" class="nome_arquivo" id="nome_arquivo_treinamento_3ps" name="nome_arquivo_treinamento_3ps" disabled value="Nenhum treinamento de percepção de risco">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                        </svg>
                    </a>
                    <br>
                </div>
                <br><br>
                <input type="submit" name="submit1" id="submit1">
            </fieldset>
        </div>

        <div class="div-form box" id="formulario_contatos_pessoais">
            <fieldset>
                <legend><b>Contatos Pessoais</b></legend>
                <button class="tab" id="exibir_formulario_principal_2" type="button" onclick="exibirFormularioPrincipal()">Formulario Motorista</button>
                <button class="tab" id="exibir_formulario_documentos_2" type="button" onclick="exibirFormularioDocumentos()">Documentos</button>
                <button class="tab" id="exibir_formulario_contatos_pessoais_2" type="button" onclick="exibirFormularioContatosPessoais()">Contatos Pessoais</button>
                <br><br>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_1" id="contato_pessoal_1" class="inputUser" maxlength="11">
                    <label for="contato_pessoal_1" class="labelInput">Tel. Contato pessoal 1</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_1_nome" id="contato_pessoal_1_nome" class="inputUser">
                    <label for="contato_pessoal_1_nome" class="labelInput">Nome</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_1_parentesco" id="contato_pessoal_1_parentesco" class="inputUser">
                    <label for="contato_pessoal_1_parentesco" class="labelInput">Parentesco</label>
                </div>
                <br>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_2" id="contato_pessoal_2" class="inputUser" maxlength="11">
                    <label for="contato_pessoal_2" class="labelInput">Tel. Contato pessoal 2</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_2_nome" id="contato_pessoal_2_nome" class="inputUser">
                    <label for="contato_pessoal_2_nome" class="labelInput">Nome</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_2_parentesco" id="contato_pessoal_2_parentesco" class="inputUser">
                    <label for="contato_pessoal_2_parentesco" class="labelInput">Parentesco</label>
                </div>
                <br>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_3" id="contato_pessoal_3" class="inputUser" maxlength="11">
                    <label for="contato_pessoal_3" class="labelInput">Tel. Contato pessoal 3</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_3_nome" id="contato_pessoal_3_nome" class="inputUser">
                    <label for="contato_pessoal_3_nome" class="labelInput">Nome</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="contato_pessoal_3_parentesco" id="contato_pessoal_3_parentesco" class="inputUser">
                    <label for="contato_pessoal_3_parentesco" class="labelInput">Parentesco</label>
                </div>
                <br><br>
                <input type="submit" name="submit2" id="submit2">
            </fieldset>
        </div>

    </form>
    </div>
</section>
<script src="{{ asset('js/Formularios/formulario-motorista.js') }}"></script>
@endsection