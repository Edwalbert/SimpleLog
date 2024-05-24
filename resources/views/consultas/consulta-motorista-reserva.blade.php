@extends('consultas.consulta-layout')
@section('content')

<div id="visual_cte">
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            @if(auth()->user()->setor == 'ssma')
            <th scope="col" class="no-wrap">---</th>
            <th scope="col" class="no-wrap">Nome</th>
            @else
            <th scope="col" class="no-wrap">Nome</th>
            @endif
            <th scope="col" class="no-wrap">Transportadora</th>
            <th scope="col" class="no-wrap">Cod Senior</th>
            <th scope="col" class="no-wrap">CPF</th>
            <th scope="col" class="no-wrap">RG</th>
            <th scope="col" class="no-wrap">Município Nasc.</th>
            <th scope="col" class="no-wrap">Data Nascimento</th>
            <th scope="col" class="no-wrap">Idade</th>
            <th scope="col" class="no-wrap">Espelho CNH</th>
            <th scope="col" class="no-wrap">Reg. CNH</th>
            <th scope="col" class="no-wrap">Emissão CNH</th>
            <th scope="col" class="no-wrap">Vcto. CNH</th>
            <th scope="col" class="no-wrap">Categoria</th>
            <th scope="col" class="no-wrap">Renach</th>
            <th scope="col" class="no-wrap">EAR</th>
            <th scope="col" class="no-wrap">Mun. CNH</th>
            <th scope="col" class="no-wrap">Primeira CNH</th>
            <th scope="col" class="no-wrap">Telefone</th>
            <th scope="col" class="no-wrap">Nome do Pai</th>
            <th scope="col" class="no-wrap">Nome da Mãe</th>
            <th scope="col" class="no-wrap">Endereço</th>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Bairro</th>
            <th scope="col" class="no-wrap">Cidade</th>
            <th scope="col" class="no-wrap">UF</th>
            <th scope="col" class="no-wrap">CEP</th>
            <th scope="col" class="no-wrap">Integração Cotramol</th>
            <th scope="col" class="no-wrap">Admissão</th>
            <th scope="col" class="no-wrap">Vcto. ASO</th>
            <th scope="col" class="no-wrap">Vcto. TOX</th>
            <th scope="col" class="no-wrap">Vcto. DD</th>
            <th scope="col" class="no-wrap">Op. BRF</th>
            <th scope="col" class="no-wrap">Op. Aliança</th>
            <th scope="col" class="no-wrap">Op. Minerva</th>
            <th scope="col" class="no-wrap">Op. Seara</th>
            <th scope="col" class="no-wrap">BRK</th>
            <th scope="col" class="no-wrap">Contato Pessoal 1</th>
            <th scope="col" class="no-wrap">Telefone</th>
            <th scope="col" class="no-wrap">Parentesco</th>
            <th scope="col" class="no-wrap">Contato Pessoal 2</th>
            <th scope="col" class="no-wrap">Telefone</th>
            <th scope="col" class="no-wrap">Parentesco</th>
            <th scope="col" class="no-wrap">Contato Pessoal 3</th>
            <th scope="col" class="no-wrap">Telefone</th>
            <th scope="col" class="no-wrap">Parentesco</th>
            <th scope="col" class="no-wrap">Motivo Desligamento</th>
            <th scope="col" class="no-wrap">OBS</th>
        </thead>
        <tbody>
            @php
            $indice = 1;
            @endphp
            @foreach ($result as $item)
            <tr>
                <td class="no-wrap"><b>{{ $indice }}</b></td>

                @if(auth()->user()->setor == 'ssma')
                <td class="no-wrap">
                    <a href="cadastro-motorista/{{ $item->cpf }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16" style="float: right; margin-left: 5px;">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                </td>
                <td class="no-wrap">
                    {{ $item->nome }}
                </td>
                @else
                <td class="no-wrap">{{ $item->nome }}</td>
                @endif

                <td class="no-wrap">{{ $item->razao_social }}</td>
                <td class="no-wrap">{{ $item->codigo_senior }}</td>
                <td class="no-wrap">{{ $item->cpf }}</td>
                <td class="no-wrap">{{ $item->numero_rg }}</td>
                <td class="no-wrap">{{ $item->municipio_nascimento }} - {{ $item->uf_nascimento }}</td>
                <td class="no-wrap">{{ $item->data_nascimento }}</td>
                <td class="no-wrap">{{ $item->idade }}</td>
                <td class="no-wrap">{{ $item->espelho_cnh }}</td>
                <td class="no-wrap">{{ $item->registro_cnh }}</td>
                <td class="no-wrap">{{ $item->emissao_cnh }}</td>
                <td class="no-wrap">{{ $item->vencimento_cnh }}</td>
                <td class="no-wrap">{{ $item->categoria_cnh }}</td>
                <td class="no-wrap">{{ $item->uf_cnh }}{{ $item->renach }}</td>
                <td class="no-wrap">{{ $item->ear }}</td>
                <td class="no-wrap">{{ $item->municipio_cnh }} - {{ $item->uf_cnh }}</td>
                <td class="no-wrap">{{ $item->primeira_cnh }}</td>
                <td class="no-wrap">{{ $item->telefone }}</td>
                <td class="no-wrap">{{ $item->nome_pai }}</td>
                <td class="no-wrap">{{ $item->nome_mae }}</td>
                <td class="no-wrap">{{ $item->endereco->rua }}</td>
                <td class="no-wrap">{{ $item->endereco->numero }}</td>
                <td class="no-wrap">{{ $item->endereco->bairro }}</td>
                <td class="no-wrap">{{ $item->endereco->cidade }}</td>
                <td class="no-wrap">{{ $item->endereco->uf }}</td>
                <td class="no-wrap">{{ $item->endereco->cep }}</td>
                <td class="no-wrap">{{ $item->integracao_cotramol }}</td>
                <td class="no-wrap">{{ $item->admissao }}</td>
                <td class="no-wrap">{{ $item->vencimento_aso }}</td>
                <td class="no-wrap">{{ $item->vencimento_tox }}</td>
                <td class="no-wrap">{{ $item->vencimento_tdd }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_brf }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_alianca }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_minerva }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_seara }}</td>
                <td class="no-wrap">{{ $item->brasil_risk_klabin }}</td>
                <td class="no-wrap">{{ $item->contatoPessoal1->nome ?? null }}</td>
                <td class="no-wrap">{{ $item->contatoPessoal1->telefone_1 }}</td>
                <td class="no-wrap">{{ $item->contato_pessoal_1_parentesco }}</td>
                <td class="no-wrap">{{ $item->contatoPessoal2->nome }}</td>
                <td class="no-wrap">{{ $item->contatoPessoal2->telefone_1 }}</td>
                <td class="no-wrap">{{ $item->contato_pessoal_2_parentesco }}</td>
                <td class="no-wrap">{{ $item->contatoPessoal3->nome }}</td>
                <td class="no-wrap">{{ $item->contatoPessoal3->telefone_1 }}</td>
                <td class="no-wrap">{{ $item->contato_pessoal_3_parentesco }}</td>
                <td class="no-wrap">{{ $item->motivo_desligamento }}</td>
                <td class="no-wrap">{{ $item->obs_desligamento }}</td>
            </tr>
            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection