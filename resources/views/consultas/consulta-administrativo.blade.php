@extends('consultas.consulta-layout')
@section('content')

<div id="visual_administrativo">
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Cavalo</th>
            <th scope="col" class="no-wrap">Carreta</th>
            <th scope="col" class="no-wrap">Comissão</th>
            <th scope="col" class="no-wrap">Razão Social</th>
            <th scope="col" class="no-wrap">Fornecedor</th>
            <th scope="col" class="no-wrap">Cliente</th>
            <th scope="col" class="no-wrap">Motorista</th>
            <th scope="col" class="no-wrap">Banco</th>
            <th scope="col" class="no-wrap">Agência</th>
            <th scope="col" class="no-wrap">Conta bancária</th>
            <th scope="col" class="no-wrap">Tipo conta</th>
            <th scope="col" class="no-wrap">Titularidade</th>
            <th scope="col" class="no-wrap">Pix</th>
            <th scope="col" class="no-wrap">Telefone</th>
            <th scope="col" class="no-wrap">CNPJ</th>
            <th scope="col" class="no-wrap">Insc. Estadual</th>
            <th scope="col" class="no-wrap">Nome responsável</th>
            <th scope="col" class="no-wrap">Email 1</th>
            <th scope="col" class="no-wrap">Email 2</th>
            <th scope="col" class="no-wrap">Telefone 1</th>
            <th scope="col" class="no-wrap">Telefone 2</th>
            <th scope="col" class="no-wrap">Contador</th>
            <th scope="col" class="no-wrap">Email 1</th>
            <th scope="col" class="no-wrap">Email 2</th>
            <th scope="col" class="no-wrap">Telefone 1</th>
            <th scope="col" class="no-wrap">Telefone 2</th>
            <th scope="col" class="no-wrap">Situação</th>
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
                <td class="no-wrap">{{ $item->transportadoras->codigo_fornecedor }}</td>
                <td class="no-wrap">{{ $item->transportadoras->codigo_cliente }}</td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->nome }} - {{ $motorista->codigo_senior }}<br>

                    @endforeach
                </td>

                <td class="no-wrap">{{ $item->nome_banco_validado }}</td>
                <td class="no-wrap">{{ $item->agencia_validado }}</td>
                <td class="no-wrap">{{ $item->numero_conta_bancaria_validado }}</td>
                <td class="no-wrap">{{ $item->tipo_conta_validado }}</td>
                <td class="no-wrap">{{ $item->titularidade_validado }}</td>
                <td class="no-wrap" id="pix_cavalo">{{ $item->pix_validado }}</td>

                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    <a href="wa.me/55{{ $motorista->telefone }}">
                        {{ $motorista->telefone }}<br>
                    </a>
                    @endforeach

                </td>
                <td class="no-wrap">{{ $item->transportadoras->cnpj }}</td>
                <td class="no-wrap">{{ $item->transportadoras->inscricao_estadual }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->nome }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->email_1 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->email_2 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->telefone_1 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->telefone_2 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->contador->nome }}</td>
                <td class="no-wrap">{{ $item->transportadoras->contador->email_1 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->contador->email_2 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->contador->telefone_1 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->contador->telefone_2 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->situacao }}</td>

            </tr>
            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection