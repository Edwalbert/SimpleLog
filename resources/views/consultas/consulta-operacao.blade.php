@extends('consultas.consulta-layout')
@section('content')

<div id="visual_operacao" class="table-container">
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <tr class="cabecalho">
                <th scope="col" class="no-wrap">N°</th>
                <th scope="col" class="no-wrap">Nome</th>
                <th scope="col" class="no-wrap">Comissão</th>
                <th scope="col" class="no-wrap">CPF</th>
                <th scope="col" class="no-wrap">RG</th>
                <th scope="col" class="no-wrap">Reg. CNH</th>
                <th scope="col" class="no-wrap">Vcto. CNH</th>
                <th scope="col" class="no-wrap">Status Clientes</th>
                <th scope="col" class="no-wrap">Cat.</th>
                <th scope="col" class="no-wrap">Cavalo</th>
                <th scope="col" class="no-wrap">Carreta</th>
                <th scope="col" class="no-wrap">Grupo</th>
                <th scope="col" class="no-wrap">Docs. </th>
                <th scope="col" class="no-wrap">Id Antena</th>
                <th scope="col" class="no-wrap">Telefone</th>
                <th scope="col" class="no-wrap">Transportador</th>
                <th scope="col" class="no-wrap">Contato pessoal 1</th>
                <th scope="col" class="no-wrap">Nome</th>
                <th scope="col" class="no-wrap">Parentesco</th>
                <th scope="col" class="no-wrap">Contato pessoal 2</th>
                <th scope="col" class="no-wrap">Nome</th>
                <th scope="col" class="no-wrap">Parentesco</th>
                <th scope="col" class="no-wrap">Contato pessoal 3</th>
                <th scope="col" class="no-wrap">Nome</th>
                <th scope="col" class="no-wrap">Parentesco</th>
            </tr>
        </thead>
        <tbody>
            @php
            $indice = 1;
            @endphp
            @foreach ($result as $item)
            <tr>
                <td class="no-wrap"><b>{{ $indice }}</b></td>
                @php
                $motorista = $item->motoristas[0];

                $carreta = $item->carretas[0];
                @endphp
                <td class="no-wrap">{{ $motorista->nome }}</td>
                <td class="no-wrap">{{ $item->transportadoras->comissao }}</td>
                <td class="no-wrap">{{ $motorista->cpf }}</td>
                <td class="no-wrap">{{ $motorista->numero_rg }}</td>
                <td class="no-wrap">{{ $motorista->registro_cnh }}</td>
                <td class="no-wrap">{{ $motorista->vencimento_cnh }}</td>
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
                <td class="no-wrap">{{ $motorista->categoria_cnh }}</td>
                <td class="no-wrap">{{ $item->placa }}</td>
                <td class="no-wrap">{{ $carreta->placa }}</td>
                <td class="no-wrap">{{ $item->grupo }}</td>
                <td class="no-wrap">
                    <b>
                        <a href="download-zip/{{ $item->placa }}-{{ $carreta->placa }}-{{ $motorista->cpf }}">↓↓↓</a>
                    </b>
                </td>
                <td class="no-wrap">{{ $item->id_rastreador }}</td>
                <td class="no-wrap">
                    @php
                    $telefoneSemFormatacao = preg_replace('/[^0-9]/', '', $motorista->telefone );
                    @endphp
                    <a href="https://wa.me/55{{$telefoneSemFormatacao}}" target="_blank">
                        {{ $motorista->telefone }}
                    </a>
                </td>
                <td class="no-wrap">{{ $item->transportadoras->razao_social }}</td>
                <td class="no-wrap">{{ $motorista->contatoPessoal1->nome ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contatoPessoal1->telefone_1 ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contato_pessoal_1_parentesco ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contatoPessoal2->nome ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contatoPessoal2->telefone_1 ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contato_pessoal_2_parentesco ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contatoPessoal3->nome ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contatoPessoal3->telefone_1 ?? '' }}</td>
                <td class="no-wrap">{{ $motorista->contato_pessoal_3_parentesco ?? '' }}</td>
            </tr>

            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>

@endsection