@extends('consultas.consulta-layout')
@section('content')

<div id="visual_vencimentos">

    <table class="table table-striped table-bordered table-bg" id="vencimentos_motoristas" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">Nome</th>
            <th scope="col" class="no-wrap">Doc.</th>
            <th scope="col" class="no-wrap">Vencimento</th>
            <th scope="col" class="no-wrap">Dias p/ Vencer</th>
        </thead>
        <tbody>
            @foreach ($resultMotoristas as $motorista)
            <tr>
                <td class="no-wrap">{{ $motorista->nome }}</td>
                <td class="no-wrap">{{ $motorista->doc }}</td>
                <td class="no-wrap">{{ $motorista->vencimento_aso }}</td>
                @if($motorista->contagem_dias['status'] == 'Vencido')
                <td class="no-wrap" style="color: red;"><b>{{ $motorista->contagem_dias['vencimento'] }}</b></td>
                @else
                <td class="no-wrap">{{ $motorista->contagem_dias['vencimento'] }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table table-striped table-bordered table-bg" id="vencimentos_veiculos" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">Placa</th>
            <th scope="col" class="no-wrap">Tipo</th>
            <th scope="col" class="no-wrap">Doc.</th>
            <th scope="col" class="no-wrap">Vencimento</th>
            <th scope="col" class="no-wrap">Dias p/ Vencer</th>
        </thead>
        <tbody>
            @foreach ($resultVeiculos as $veiculo)
            <tr>
                <td class="no-wrap">{{ $veiculo->placa }}</td>
                <td class="no-wrap">{{ $veiculo->tipo }}</td>
                <td class="no-wrap">{{ $veiculo->doc }}</td>
                <td class="no-wrap">{{ $veiculo->vencimento_crlv }}</td>
                @if($veiculo->contagem_dias['status'] == 'Vencido')
                <td class="no-wrap" style="color: red;"><b>{{ $veiculo->contagem_dias['vencimento']}}</b></td>
                @else
                <td class="no-wrap">{{ $veiculo->contagem_dias['vencimento']}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection