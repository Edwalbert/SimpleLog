@extends('consultas.consulta-layout')
@section('content')

<div id="visual_cte">
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Cavalo</th>
            <th scope="col" class="no-wrap">Carreta</th>
            <th scope="col" class="no-wrap">Comissão</th>
            <th scope="col" class="no-wrap">Razão Social</th>
            <th scope="col" class="no-wrap">Nome</th>
        </thead>
        <tbody>
            @php
            $indice = 1;
            @endphp
            @foreach ($result as $item)
            <tr>
                <td class="no-wrap"><b>{{ $indice }}</b></td>
                <td class="no-wrap">{{ $item->placa }}</td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->placa }}
                    @endforeach
                </td>
                <td class="no-wrap">{{ $item->transportadoras->comissao }}</td>
                <td class="no-wrap">{{ $item->transportadoras->razao_social }} - {{ $item->transportadoras->codigo_transportadora }}</td>

                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->nome }} - {{ $motorista->codigo_senior }}<br>
                    @endforeach
                </td>
            </tr>
            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection