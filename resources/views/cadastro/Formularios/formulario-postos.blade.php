@extends('cadastro.Formularios.layout')

@section('title', $title)

@section('content')


<section class="section">
    <form method="POST" action="/cadastro-postos" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de Postos</b></legend>
                <input type="text" name="id_posto" id="id_posto" style="display: none;" value="">
                <br>
                <div class="div-form inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" id="label_nome" class="labelInput">Nome</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="rede" id="rede" class="inputUser" required>
                    <label for="rede" id="label_rede" class="labelInput">Rede</label>
                </div>
                <br><br>
                <div class="div-form inputBox">
                    <input type="number" name="telefone_1" id="telefone_1" class="inputUser" required>
                    <label for="telefone_1" class="labelInput">Telefone 1</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="telefone_2" id="telefone_2" class="inputUser">
                    <label for="telefone_2" class="labelInput">Telefone 2</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="telefone_3" id="telefone_3" class="inputUser">
                    <label for="telefone_3" class="labelInput">Telefone 3</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="telefone_4" id="telefone_4" class="inputUser">
                    <label for="telefone_4" class="labelInput">Telefone 4</label>
                </div>
                <div class="div-form inputBox">
                    <input type="email" name="email_1" id="email_1" class="inputUser" required>
                    <label for="email_1" class="labelInput">Email 1</label>
                </div>
                <div class="div-form inputBox">
                    <input type="email" name="email_2" id="email_2" class="inputUser">
                    <label for="email_2" class="labelInput">Email 2</label>
                </div>
                <div class="div-form inputBox">
                    <input type="email" name="email_3" id="email_3" class="inputUser">
                    <label for="email_3" class="labelInput">Email 3</label>
                </div>
                <div class="div-form inputBox">
                    <input type="email" name="email_4" id="email_4" class="inputUser">
                    <label for="email_4" class="labelInput">Email 4</label>
                </div>

                <div class="div-form inputBox">
                    <input type="text" name="cep" id="cep" class="inputUser" required maxlength="8" minlength="8">
                    <label for="cep" class="labelInput">CEP</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="rua" id="rua" class="inputUser" required>
                    <label for="rua" class="labelInput">Rua</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="numero" id="numero" class="inputUser" required>
                    <label for="numero" class="labelInput">N°</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="bairro" id="bairro" class="inputUser" required>
                    <label for="bairro" class="labelInput">Bairro</label>
                </div>
                <div class="div-form inputBox">
                    <label for="uf" class="labelDropDown">UF</label>
                    <select class="inputSelect" id="uf" name="uf">
                        <option value="0"></option>
                        @foreach($uf as $estado)
                        <option value="{{ $estado['sigla'] }}">{{ $estado['sigla'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label for="cidade" class="labelDropDown">Cidade</label>
                    <select class="municipioSelect" id="cidade" name="cidade">
                        <option value="0"></option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="complemento" id="complemento" class="inputUser">
                    <label for="complemento" class="labelInput">Complemento</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>
        <br><br>

    </form>
</section>

<script src="{{ asset('js/Formularios/formulario-postos.js') }}"></script>

@endsection