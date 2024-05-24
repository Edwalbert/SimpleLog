@extends('cadastro.Formularios.layout')

@section('content')


<section class="section">
    <form method="POST" action="/solicitar-retirada" enctype="multipart/form-data">
        @csrf
        <div class="div-form box" id="formulario_principal">
            <fieldset>
                <legend id="legend"><b>Solicitar Retirada</b></legend>
                <br>
                <input type="hidden" name="id_retirada" id="id_retirada" class="inputUser">
                <input type="hidden" name="status" id="id_retirada" class="inputUser" value="Criado">
                <br>
                <div class="div-form inputDate" style="margin-left:15px;">
                    <input type="date" name="data_retirada" id="data_retirada" class="vctos" required>
                    <label for="data_retirada" class="labelvctos">Data</label>
                </div>
                <div class="div-form inputBox" style="color: black; margin-left:-80px;">
                    <label for="id_cliente" class="labelDropDown" style="color: white;">Cliente *</label>
                    <select class="selectJs" name="id_cliente" id="cliente" style="width: 180px;">
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->razao_social }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" id="div_nome_select" style="color: black; margin-left:10px;">
                    <label for="id_butuca" class="labelDropDown" style="color: white;">Butuca *</label>
                    <option value="0"></option>
                    <select class="selectJs" name="id_butuca" id="id_butuca" style="width: 180px;" required>
                        @foreach($butucas as $id => $butuca)
                        <option value="{{ $id }}">{{ $butuca }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="rota" class="labelDropDown" style="color: white;">Rota *</label>
                    <select class="selectJs" name="rota" id="rota" style="width: 200px;">

                    </select>
                </div>
                <div class="div-form inputBox" style="color: black;">
                    <label for="tipo_container" class="labelDropDown" style="color: white;">Tipo *</label>
                    <select class="selectJs" name="tipo_container" id="tipo_container" style="width: 110px;">
                        <option value="" selected></option>
                        <option value="40HC">40HC</option>
                        <option value="40RH">40RH</option>
                        <option value="20HC">20HC</option>
                        <option value="20RH">20RH</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="numero_container" id="numero_container" class="inputUser" style="width:180px;" required maxlength="11" minlength="11">
                    <label for="numero_container" class="labelInput">Container *</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="valor_butuca" id="valor_butuca" class="inputUser" style="width:100px;" readonly>
                    <label for="valor_butuca" class="labelInput" style="top: -20px;font-size: 12px;color: #75c58e;">Valor Butuca*</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="valor_terminal" id="valor_terminal" class="inputUser" style="width:100px;" readonly>
                    <label for="valor_terminal" class="labelInput" style="top: -20px;font-size: 12px;color: #75c58e;">Valor Terminal*</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="valor_desconto" id="valor_desconto" class="inputUser" style="width:100px;" required>
                    <label for="valor_desconto" class="labelInput">Valor Desconto*</label>
                </div>
                <div class="div-form inputBox" id=" div_observacao">
                    <input type="text" name="observacao" id="observacao" class="inputUser" style="width:200px;">
                    <label for="observacao" class="labelInput">OBS *</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>

    </form>
</section>
<script>
    window.onload = function() {
        var hoje = new Date();
        var dia = hoje.getDate().toString().padStart(2, '0');
        var mes = (hoje.getMonth() + 1).toString().padStart(2, '0');
        var ano = hoje.getFullYear();
        var dataFormatada = ano + '-' + mes + '-' + dia;
        document.getElementById('data_retirada').value = dataFormatada;
    };
</script>

<script src="{{ asset('js/Formularios/formulario-solicitar-retirada.js') }}"></script>
@endsection