@extends('cadastro.Formularios.layout')
@section('content')

<section class="section">
    <form method="POST" action="/cadastro-valor-coleta" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de Valor Coleta</b></legend>
                <input type="hidden" name="id_valor_coleta" id="id_valor_coleta" value="">
                <br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="id_butuca" class="labelDropDown" style="color: white;">Butuca *</label>
                    <select class="selectJs" name="id_butuca" id="id_butuca" style="width: 180px;" required>
                        <option value="" selected></option>
                        @foreach($butucas as $id => $butuca)
                        <option value="{{ $id }}">{{ $butuca }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="div-form inputBox" style="color: black;">
                    <label for="id_terminal_coleta" class="labelDropDown" style="color: white;">Terminal Coleta *</label>
                    <select class="selectJs" name="id_terminal_coleta" id="id_terminal_coleta" style="width: 180px;" required>
                        <option value="" selected></option>
                        @foreach($depots as $id => $depot)
                        <option value="{{ $id }}">{{ $depot }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="id_terminal_baixa" class="labelDropDown" style="color: white;">Terminal Baixa *</label>
                    <select class="selectJs" name="id_terminal_baixa" id="id_terminal_baixa" style="width: 180px;" required>
                        <option value="" selected></option>
                        @foreach($terminais as $id => $terminal)
                        <option value="{{ $id }}">{{ $terminal }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="valor" id="valor" class="inputUser">
                    <label for="valor" id="label_valor" class="labelInput">Valor *</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit" class="submit">
            </fieldset>
        </div>
    </form>
    </div>
</section>
<script src="{{ asset('js/Formularios/formulario-cadastro-valor-coleta.js') }}"></script>
@endsection