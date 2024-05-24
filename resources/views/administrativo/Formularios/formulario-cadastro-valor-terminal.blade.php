@extends('cadastro.Formularios.layout')
@section('content')

<section class="section">
    <form method="POST" action="/cadastro-valor-terminal" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Cadastro de Valor Terminal</b></legend>
                <input type="hidden" name="id_valor_terminal" id="id_valor_terminal" value="">
                <br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="id_butuca" class="labelDropDown" style="color: white;">Terminal *</label>
                    <select class="selectJs" name="id_butuca" id="id_butuca" style="width: 180px;" required>
                        <option value="" selected></option>
                        @foreach($terminais as $id => $terminal)
                        <option value="{{ $id }}">{{ $terminal }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="div-form inputBox" style="color: black; margin-left:50px;">
                    <label for="tipo_container" class="labelDropDown" style="color: white;">Tipo Container *</label>
                    <select class="selectJs" name="tipo_container" id="tipo_container" style="width: 180px;" required>
                        <option value="" selected></option>
                        <option value="40HC">40HC</option>
                        <option value="40RH">40RH</option>
                        <option value="20HC">20HC</option>
                        <option value="20RH">20RH</option>
                    </select>
                </div>
                <div class="div-form inputBox" style="margin-left:50px;">
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
<script src="{{ asset('js/Formularios/formulario-cadastro-valor-terminal.js') }}"></script>
@endsection