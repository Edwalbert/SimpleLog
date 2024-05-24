@extends('consultas.consulta-layout')
@section('content')

<div id="visual_monitoramento">
    <table class=" table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Nome</th>
            <th scope="col" class="no-wrap">CPF</th>
            <th scope="col" class="no-wrap">Telefone</th>
            <th scope="col" class="no-wrap">Cavalo</th>
            <th scope="col" class="no-wrap">Carreta</th>
            <th scope="col" class="no-wrap">Tecnologia</th>
            <th scope="col" class="no-wrap">Id Antena</th>
            <th scope="col" class="no-wrap">Login</th>
            <th scope="col" class="no-wrap">Senha</th>
            <th scope="col" class="no-wrap">Status Clientes</th>
            <th scope="col" class="no-wrap">Razão Social</th>
            <th scope="col" class="no-wrap">Nome responsável</th>
            <th scope="col" class="no-wrap">Email 1</th>
            <th scope="col" class="no-wrap">Email 2</th>
            <th scope="col" class="no-wrap">Telefone 1</th>
            <th scope="col" class="no-wrap">Telefone 2</th>
        </thead>
        <tbody>
            @php
            $indice = 1;
            @endphp
            @foreach ($result as $item)
            <tr>
                <td class="no-wrap"><b>{{ $indice }}</b></td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->nome }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->cpf }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    @php
                    $telefoneSemFormatacao = preg_replace('/[^0-9]/', '', $motorista->telefone );
                    @endphp
                    <a href="https://wa.me/55{{$telefoneSemFormatacao}}" target="_blank">
                        {{ $motorista->telefone }}<br>
                    </a>
                    @endforeach
                </td>
                <td class="no-wrap">{{ $item->placa }}</td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->placa }}
                    @endforeach
                </td>
                @if ($item->tecnologia == 'Sascar')
                <td class="no-wrap"><a href="https://sascar.com.br/" target="_blank">{{ $item->tecnologia }}</a></td>
                @elseif ($item->tecnologia == 'Omnilink')
                <td class="no-wrap"><a href="https://omnilink.com.br" target="_blank">{{ $item->tecnologia }}</a></td>
                @elseif ($item->tecnologia == 'Onixsat')
                <td class="no-wrap"><a href="https://newrastreamentoonline.com.br/new/login.aspx?ReturnUrl=%2fnew%2f" target="_blank">{{ $item->tecnologia }}</a></td>
                @else
                <td class="no-wrap">{{ $item->tecnologia }}</td>
                @endif
                <td class="no-wrap">{{ $item->id_rastreador }}</td>
                <td class="no-wrap">{{ $item->login_tecnologia }}</td>
                <td class="no-wrap">{{ $item->senha_tecnologia }}</td>

                <td class="no-wrap">
                    <div style="display: inline-block;">
                        <b>
                            @php
                            @endphp
                            @if ($motorista->status_brf == 10 && $item->status_brf == 10 && $carreta->status_brf == 10)
                            <div style="border-radius:3px; background-color:#caf2ca; color: green;display:inline-block;" class="hover-brf"><a href="/consulta-externa" target="_blank">BRF</a></div>
                            @elseif ($motorista->status_brf == 0 || $item->status_brf == 0 || $carreta->status_brf == 0)
                            <div style="border-radius:3px; background-color:#faeaf9; color: red; display:inline-block;" class="hover-brf"><a href="/consulta-externa" target="_blank" data-toggle="tooltip" data-placement="top" title="{{$item->motoristas[0]->status_demarco}}. {{$item->motoristas[0]->motivo_bloqueio}}">BRF</a></div>
                            @elseif ($motorista->status_brf == 5)
                            <div style="background-color:lightgoldenrodyellow; color: orange; display:inline-block;" class="hover-brf"><a href="/consulta-externa" target="_blank">BRF</a></div>
                            @endif
                        </b>

                        <a href="consulta">
                            <b>
                                @if ($motorista->status_minerva == 10 && $item->status_minerva == 10 && $carreta->status_minerva == 10)
                                <div style="border-radius:3px; background-color:#caf2ca; color: green; display:inline-block;">MIN</div>
                                @elseif ($motorista->status_minerva == 0 || $item->status_minerva == 0 || $carreta->status_minerva == 0)
                                <div style="border-radius:3px; background-color:#faeaf9; color: red; display:inline-block;">MIN</div>
                                @elseif ($motorista->status_minerva == 5 || $item->status_minerva == 5 || $carreta->status_minerva == 5)
                                <div style="background-color:lightgoldenrodyellow; color: orange; display:inline-block;">MIN</div>
                                @endif
                            </b>
                        </a>
                        <a href="consulta">
                            <b>
                                @if ($motorista->status_seara == 10 && $item->status_seara == 10 && $carreta->status_seara == 10)
                                <div style="border-radius:3px; background-color:#caf2ca; color: green; display:inline-block;">SEA</div>
                                @elseif ($motorista->status_seara == 0 || $item->status_seara == 0 || $carreta->status_seara == 0)
                                <div style="border-radius:3px; background-color:#faeaf9; color: red; display:inline-block;">SEA</div>
                                @elseif ($motorista->status_seara == 5 || $item->status_seara == 5 || $carreta->status_seara == 5)
                                <div style="background-color:lightgoldenrodyellow; color: orange; display:inline-block;">SEA</div>
                                @endif
                            </b>
                        </a>

                    </div>
                    <div class="tooltip">
                        <p>Motivo bloqueio: {{ $motorista->motivo_bloqueio }}</p>
                    </div>
                </td>
                <td class="no-wrap">{{ $item->transportadoras->razao_social }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->nome }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->email_1 }}</td>
                <td class="no-wrap">{{ $item->transportadoras->responsavel->email_2 }}</td>
                <td class="no-wrap">
                    @php
                    $telefoneSemFormatacao = preg_replace('/[^0-9]/', '', $item->transportadoras->responsavel->telefone_1 );
                    @endphp
                    <a href="https://wa.me/55{{$telefoneSemFormatacao}}" target="_blank">
                        {{ $item->transportadoras->responsavel->telefone_1 }}<br>
                    </a>
                </td>
                <td class="no-wrap">
                    @php
                    $telefoneSemFormatacao = preg_replace('/[^0-9]/', '', $item->transportadoras->responsavel->telefone_2 );
                    @endphp
                    <a href="https://wa.me/55{{$telefoneSemFormatacao}}" target="_blank">
                        {{ $item->transportadoras->responsavel->telefone_2 }}<br>
                    </a>
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