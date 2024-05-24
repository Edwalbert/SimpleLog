@extends('administrativo.Formularios.layout')

@section('title', $title)

@section('content')


<section class="section">
    <form method="POST" action="/solicitar-adiantamento" enctype="multipart/form-data">
        @csrf
        <div class="div-form" id="formulario_principal">
            <fieldset class="box">
                <legend id="legend"><b>Solicitar adiantamento</b></legend>
                <br>

                <input type="hidden" name="id_adiantamento" id="id_adiantamento" class="inputUser">
                <input type="hidden" name="status" id="status" class="inputUser" value="Criado">
                <input type="hidden" name="tipo" id="tipo" class="inputUser" value="scf">
                <input type="hidden" name="valor_para_validacao" id="valor_para_validacao" class="inputUser">
                <br>
                <div class="div-form inputBox" style="color: black;">
                    <label for="local_carregamento" class="labelDropDown" style="color: white;">Local Carregamento *</label>
                    <select class="selectJs" name="local_carregamento" id="local_carregamento" style="width: 230px;">
                        <option value="" selected></option>
                        @foreach($rotas as $rota)
                        <option value="{{ $rota->rota }}">{{ $rota->rota }} - {{ $rota->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black; margin-left:0px;">
                    <label for="local_coleta" class="labelDropDown" style="color: white;">Local Coleta *</label>
                    <select class="selectJs" name="local_coleta" id="local_coleta" style="width: 100px;" required>
                        <option value="" selected></option>
                        <option value="ITJ">ITJ</option>
                        <option value="NVG">NVG</option>
                        <option value="IOA">IOA</option>
                        <option value="PNG">PNG</option>
                        <option value="GRV">GRV</option>
                        <option value="RGD">RGD</option>
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black; margin-left:-130px;">
                    <label for="local_entrega" class="labelDropDown" style="color: white;">Local Entrega *</label>
                    <select class="selectJs" name="local_entrega" id="local_entrega" style="width: 100px;" required>
                        <option value="" selected></option>
                        <option value="ITJ">ITJ</option>
                        <option value="NVG">NVG</option>
                        <option value="IOA">IOA</option>
                        <option value="PNG">PNG</option>
                        <option value="GRV">GRV</option>
                        <option value="RGD">RGD</option>
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black; margin-left:-130px;">
                    <label for="id_posto" class="labelDropDown" style="color: white;">Posto *</label>
                    <select class="selectJs" name="id_posto" id="id_posto" style="width: 230px;" required>
                        <option value="" selected></option>
                        @foreach($postos as $id => $posto)
                        <option value="{{ $posto->id }}">{{ $posto->nome_posto }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox" style="color: black; margin-left:-5px;">
                    <label for="id_cavalo" class="labelDropDown" style="color: white;">Placa *</label>
                    <select class="selectJs" name="id_cavalo" id="id_cavalo" style="width: 230px;" required>
                        <option value="" selected></option>
                        @foreach($cavalos as $id => $placa)
                        <option value="{{ $id }}">{{ $placa }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label for="em_maos" class="labelDropDown" style="margin-top:12px">Em Mãos</label>
                    <input type="checkbox" id="em_maos" name="em_maos" style="width: 60px;height:20px;border-radius:8px;margin-top:20px">
                </div>

                <div class="div-form inputDate" style="margin-left:-180px;">
                    <input type="date" name="data_carregamento" id="data_carregamento" class="vctos" required>
                    <label for="data_carregamento" class="labelvctos">Data Carreg.</label>
                </div>
                <div class="div-form inputBox">
                    <input type="number" name="valor" id="valor" class="inputUser" required>
                    <label for="valor" class="labelInput">Valor</label>
                </div>
                <div class="div-form inputBox">
                    <input type="text" name="observacao" id="observacao" class="inputUser" maxlength="200">
                    <label for="observacao" class="labelInput">Observacao</label>
                </div>
                <br><br><br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </div>

    </form>
</section>

<script src="{{ asset('js/Formularios/formulario-solicitar-adiantamento.js') }}"></script>

@endsection