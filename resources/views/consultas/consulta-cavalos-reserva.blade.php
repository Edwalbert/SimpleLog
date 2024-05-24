@extends('consultas.consulta-layout')
@section('content')

<div id="visual_cavalos_reserva">
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Placa</th>
            <th scope="col" class="no-wrap">Status</th>
            <th scope="col" class="no-wrap">Grupo</th>
            <th scope="col" class="no-wrap">Transportadora</th>
            <th scope="col" class="no-wrap">Vencimento T.F.</th>
            <th scope="col" class="no-wrap">Vencimento Cron.</th>
            <th scope="col" class="no-wrap">Vencimento Op. Minerva</th>
            <th scope="col" class="no-wrap">Vencimento Op. Aliança</th>
            <th scope="col" class="no-wrap">Vencimento Op. Seara</th>
            <th scope="col" class="no-wrap">Checklist Aliança</th>
            <th scope="col" class="no-wrap">Checklist Minerva</th>
            <th scope="col" class="no-wrap">Brasil Risk Klabin</th>
            <th scope="col" class="no-wrap">Id Rastreador</th>
            <th scope="col" class="no-wrap">Tecnologia</th>
            <th scope="col" class="no-wrap">Tipo Pedágio</th>
            <th scope="col" class="no-wrap">Id Pedágio</th>
            <th scope="col" class="no-wrap">RNTRC</th>
            <th scope="col" class="no-wrap">Login Tecnologia</th>
            <th scope="col" class="no-wrap">Senha Tecnologia</th>
            <th scope="col" class="no-wrap">Certificado Cron.</th>
            <th scope="col" class="no-wrap">Motivo Desligamento</th>
        </thead>
        <tbody>
            @php
            $indice = 1;
            @endphp
            @foreach ($result as $item)
            <tr>
                <td class="no-wrap"><b>{{ $indice }}</b></td>
                <td class="no-wrap">{{ $item->placa }}</td>
                <td class="no-wrap">{{ $item->status }}</td>
                <td class="no-wrap">{{ $item->grupo }}</td>
                <td class="no-wrap">{{ $item->razao_social }}</td>
                <td class="no-wrap">{{ $item->vencimento_teste_fumaca }}</td>
                <td class="no-wrap">{{ $item->vencimento_cronotacografo }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_minerva }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_alianca }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_seara }}</td>
                <td class="no-wrap">{{ $item->checklist_alianca }}</td>
                <td class="no-wrap">{{ $item->checklist_minerva }}</td>
                <td class="no-wrap">{{ $item->brasil_risk_klabin }}</td>
                <td class="no-wrap">{{ $item->id_rastreador }}</td>
                <td class="no-wrap">{{ $item->tecnologia }}</td>
                <td class="no-wrap">{{ $item->tipo_pedagio }}</td>
                <td class="no-wrap">{{ $item->id_pedagio }}</td>
                <td class="no-wrap">{{ $item->rntrc }}</td>
                <td class="no-wrap">{{ $item->login_tecnologia }}</td>
                <td class="no-wrap">{{ $item->senha_tecnologia }}</td>
                <td class="no-wrap">{{ $item->certificado_cronotacografo }}</td>
                <td class="no-wrap">{{ $item->motivo_desligamento }}</td>
            </tr>
            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection