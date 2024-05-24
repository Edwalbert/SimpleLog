@extends('cadastro.Formularios.layout')

@section('title', $title)

@section('content')

<section class="section">
    <form method="POST" action="/autorizar-adiantamento" enctype="multipart/form-data">
        @csrf
        <div class="div-form" id="formulario_principal">
            <fieldset class="box" style="border: 3px solid yellow;">
                <legend id="legend" style="background: yellow; color:red;"><b>Autorizar adiantamento</b></legend>
                <br>
                <input type="hidden" name="id_adiantamento" id="id_adiantamento" class="inputUser">
                <input type="hidden" name="status" id="status" class="inputUser" value="Criado">
                <input type="hidden" name="tipo" id="tipo" class="inputUser" value="acf">
                <input type="hidden" name="valor_para_validacao" id="valor_para_validacao" class="inputUser">
                <div class="div-form inputBox">
                    <label for="local_carregamento" class="labelDropDown">Local Carregamento</label>
                    <select class="municipioSelect" id="local_carregamento" name="local_carregamento">
                        @foreach($rotas as $rota)
                        <option value="{{ $rota->rota }}">{{ $rota->rota }} - {{ $rota->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label for="local_coleta" class="labelDropDown">Local Coleta</label>
                    <select class="municipioSelect" id="local_coleta" name="local_coleta">
                        <option value="ITJ">ITJ</option>
                        <option value="NVG">NVG</option>
                        <option value="IOA">IOA</option>
                        <option value="PNG">PNG</option>
                        <option value="GRV">GRV</option>
                        <option value="RGD">RGD</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label for="local_entrega" class="labelDropDown">Local Entrega</label>
                    <select class="municipioSelect" id="local_entrega" name="local_entrega">
                        <option value="ITJ">ITJ</option>
                        <option value="NVG">NVG</option>
                        <option value="IOA">IOA</option>
                        <option value="PNG">PNG</option>
                        <option value="GRV">GRV</option>
                        <option value="RGD">RGD</option>
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label for="id_posto" class="labelDropDown">Posto</label>
                    <select class="municipioSelect" id="id_posto" name="id_posto">
                        <option value=""></option>
                        @foreach($postos as $id => $posto)
                        <option value="{{ $posto->id }}">{{ $posto->nome_posto }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div-form inputBox">
                    <label for="id_cavalo" class="labelDropDown">Placa</label>
                    <select class="inputSelect" id="id_cavalo" name="id_cavalo">
                        <option value=""></option>
                        @foreach($cavalos as $id => $placa)
                        <option value="{{ $id }}">{{ $placa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="div-form inputDate">
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
                <input type="submit" name="submit" id="submit" style="background:yellow; color:red;">
            </fieldset>
        </div>

    </form>
</section>

<script src="{{ asset('js/Formularios/formulario-autorizar-adiantamento.js') }}"></script>






@endsection