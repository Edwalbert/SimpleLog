@extends('cadastro.Formularios.layout')
@section('content')

<section class="section">
    <form method="POST" action="/cadastro-butucas" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de Butuca/Terminal</b></legend>
                <br>
                <div class="form-check" id="div_check_box" style="margin-left: 15px;">
                    <input class="form-check-input" type="checkbox" value="" id="editar" onclick="mudarCampoNome()">
                    <label class="form-check-label" for="editar">
                        Editar.
                    </label>
                </div>
                <div class="div-form inputBox" id="div_nome_select" style="color: black; display:none;">
                    <label for="id_butuca" class="labelDropDown" style="color: white;">Butuca *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="id_butuca" id="id_butuca" style="width: 180px;">
                        @foreach($butucas as $id => $butuca)
                        <option value="{{ $id }}">{{ $butuca }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="div-form inputBox" id="div_nome">
                    <input type="text" name="nome" id="nome" class="inputUser" maxlength="50" required>
                    <label for="nome" id="label_nome" class="labelInput">Nome *</label>
                </div>

                <div class="div-form inputBox" style="color: black;">
                    <label for="uf" class="labelDropDown" style="color: white;">UF *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="uf" id="uf" style="width: 90px;" required>
                        <option value="" selected></option>
                        @foreach($uf as $estado)
                        <option value="{{ $estado['sigla'] }}">{{ $estado['sigla'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black; margin-left:-100px;">
                    <label for="cidade" class="labelDropDown" style="color: white;margin-top:-20px;">Cidade *</label>
                    <select class="selectJs" name="cidade" id="cidade" style="width: 260px;" required>

                    </select>
                </div>
                <div class="div-form inputBox" style="margin-left:80px;">
                    <input type="email" name="email" id="email" class="inputUser">
                    <label for="email" class="labelInput">Email</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="numero_conta_bancaria" id="numero_conta_bancaria" class="inputUser" maxlength="10">
                    <label for="numero_conta_bancaria" class="labelInput">Número conta</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="codigo_banco" id="codigo_banco" class="inputUser">
                    <label for="codigo_banco" class="labelInput">Código do banco</label>
                </div>
                <div class="div-form inputBox" style="color: black; display:none;" id="div_nome_banco">
                    <label for="nome_banco" class="labelDropDown" style="color: white;">Cooperativa *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="nome_banco" id="nome_banco" style="width: 200px;">
                        <option value="" selected></option>
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
                    <input type="text" name="agencia" id="agencia" class="inputUser">
                    <label for="agencia" class="labelInput">Agência</label>
                </div>
                <br><br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="tipo_conta" class="labelDropDown" style="color: white;">Tipo Conta *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="tipo_conta" id="tipo_conta" style="width: 90px;">
                        <option value="" selected></option>
                        <option value="CC">CC</option>
                        <option value="CI">CI</option>
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="titularidade" class="labelDropDown" style="color: white;">Titularidade *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="titularidade" id="titularidade" style="width: 90px;">
                        <option value="" selected></option>
                        <option value="PJ">PJ</option>
                        <option value="PF">PF</option>
                    </select>
                </div>
                <label></label>
                <div class="div-form inputBox" style="color: black;">
                    <label for="pix" class="labelDropDown" style="color: white;">Pix *</label>
                    <select class="selectJs" name="pix" id="pix" style="width: 120px;">
                        <option value=""></option>
                        <option value="CPF">CPF</option>
                        <option value="CNPJ">CNPJ</option>
                        <option value="TELEFONE">Telefone</option>
                        <option value="EMAIL">Email</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="chave_pix" id="chave_pix" class="inputUser">
                    <label for="chave_pix" id="label_chave_pix" class="labelInput">Chave Pix</label>
                </div>
                <div class="div-form inputBox">
                    <label for="depot" class="labelDropDown" style="margin-top:12px">Depot</label>
                    <input type="checkbox" id="depot" name="depot" style="width: 60px;height:20px;border-radius:8px;margin-top:20px">
                </div>
                <div class="div-form inputBox">
                    <label for="butuca" class="labelDropDown" style="margin-top:12px">Butuca</label>
                    <input type="checkbox" id="butuca" name="butuca" style="width: 60px;height:20px;border-radius:8px;margin-top:20px">
                </div>
                <div class="div-form inputBox">
                    <label for="terminal" class="labelDropDown" style="margin-top:12px">Terminal</label>
                    <input type="checkbox" id="terminal" name="terminal" style="width: 60px;height:20px;border-radius:8px;margin-top:20px" onclick="mostrarCamposTerminal()">
                </div>

              
                <br><br>
                <input type="submit" name="submit" id="submit" class="submit">
            </fieldset>
        </div>
    </form>
    </div>
</section>
<script>

</script>
<script src="{{ asset('js/Formularios/formulario-cadastro-butuca.js') }}"></script>
@endsection