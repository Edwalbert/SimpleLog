@extends('cadastro.Formularios.layout')

@section('title', $title)

@section('content')

<section class="section">
    <form method="POST" action="/cadastro-senhas" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro Senhas</b></legend>
                <br>
                <input type="hidden" id="id_senha" name="id_senha">
                <div class="div-form inputBox" id="div_acesso">
                    <label>Visualizar</label>
                    <select name="acesso" id="acesso" class="inputSelect">
                        <option value="todos">Todos</option>
                        <option value="administrativo">Administrativo</option>
                        <option value="operacao">Operação</option>
                        <option value="monitoramento">Monitoramento</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="sistema" id="sistema" class="inputUser" required>
                    <label for="sistema" id="label_sistema" class="labelInput">Sistema</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="link" id="link" class="inputUser" required>
                    <label for="link" id="label_link" class="labelInput">Link</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="login" id="login" class="inputUser" required>
                    <label for="login" id="label_login" class="labelInput">Login</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="password" id="password" class="inputUser" required>
                    <label for="password" id="label_password" class="labelInput">Senha</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="descricao" id="descricao" class="inputUser" required>
                    <label for="descricao" id="label_descricao" class="labelInput">Descrição</label>
                </div>

                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>
    </form>
</section>

<script src="{{ asset('js/Formularios/formulario-senhas.js') }}"></script>

@endsection