@extends('consultas.consulta-layout')
@section('content')
<div id="visual_ssma">
    <table class="table table-striped table-bordered table-bg">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            @if(auth()->user()->setor == 'ssma')
            <th scope="col" class="no-wrap">---</th>
            <th scope="col" class="no-wrap">Nome</th>
            @else
            <th scope="col" class="no-wrap">Nome</th>
            @endif
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
            <th scope="col" class="no-wrap">Contato pessoal 1</th>
            <th scope="col" class="no-wrap">Nome</th>
            <th scope="col" class="no-wrap">Parentesco</th>
            <th scope="col" class="no-wrap">Contato pessoal 2</th>
            <th scope="col" class="no-wrap">Nome</th>
            <th scope="col" class="no-wrap">Parentesco</th>
            <th scope="col" class="no-wrap">Contato pessoal 3</th>
            <th scope="col" class="no-wrap">Nome</th>
            <th scope="col" class="no-wrap">Parentesco</th>

            <th scope="col" class="no-wrap"><b>---</b></th>

            <th scope="col" class="no-wrap">Cavalo</th>
            <th scope="col" class="no-wrap">Renavam</th>
            <th scope="col" class="no-wrap">Ano Fab.</th>
            <th scope="col" class="no-wrap">Ano Mod.</th>
            <th scope="col" class="no-wrap">Idade</th>
            <th scope="col" class="no-wrap">N° CRV</th>
            <th scope="col" class="no-wrap">Cod. Segurança</th>
            <th scope="col" class="no-wrap">Modelo</th>
            <th scope="col" class="no-wrap">Cor</th>
            <th scope="col" class="no-wrap">Chassi</th>
            <th scope="col" class="no-wrap">Cidade</th>
            <th scope="col" class="no-wrap">CNPJ CRLV</th>
            <th scope="col" class="no-wrap">CPF CRLV</th>
            <th scope="col" class="no-wrap">Emissão CRLV</th>
            <th scope="col" class="no-wrap">Vencimento CRLV</th>
            <th scope="col" class="no-wrap">RNTRC</th>
            <th scope="col" class="no-wrap">Vencimento T. F.</th>
            <th scope="col" class="no-wrap">Opentech Minerva.</th>
            <th scope="col" class="no-wrap">Opentech Aliança.</th>
            <th scope="col" class="no-wrap">Opentech Seara.</th>
            <th scope="col" class="no-wrap">Checklist Aliança.</th>
            <th scope="col" class="no-wrap">Checklist Minerva.</th>
            <th scope="col" class="no-wrap">Vencimento Cron.</th>
            <th scope="col" class="no-wrap">Certificado Cron.</th>
            <th scope="col" class="no-wrap">Grupo</th>
            <th scope="col" class="no-wrap">Tecnologia</th>
            <th scope="col" class="no-wrap">Id Antena</th>
            <th scope="col" class="no-wrap">Login</th>
            <th scope="col" class="no-wrap">Senha</th>
            <th scope="col" class="no-wrap">Tipo Pedágio</th>
            <th scope="col" class="no-wrap">Id Pedágio</th>

            <th scope="col" class="no-wrap"><b>---</b></th>

            <th scope="col" class="no-wrap">Carreta</th>
            <th scope="col" class="no-wrap">Renavam</th>
            <th scope="col" class="no-wrap">Ano Fab.</th>
            <th scope="col" class="no-wrap">Ano Mod.</th>
            <th scope="col" class="no-wrap">Idade</th>
            <th scope="col" class="no-wrap">N° CRV</th>
            <th scope="col" class="no-wrap">Cod. Segurança</th>
            <th scope="col" class="no-wrap">Modelo</th>
            <th scope="col" class="no-wrap">Cor</th>
            <th scope="col" class="no-wrap">Chassi</th>
            <th scope="col" class="no-wrap">Cidade</th>
            <th scope="col" class="no-wrap">CNPJ CRLV</th>
            <th scope="col" class="no-wrap">CPF CRLV</th>
            <th scope="col" class="no-wrap">Emissão CRLV</th>
            <th scope="col" class="no-wrap">Vencimento CRLV</th>
            <th scope="col" class="no-wrap">RNTRC</th>
            <th scope="col" class="no-wrap">Opentech Minerva</th>
            <th scope="col" class="no-wrap">Opentech Aliança</th>
            <th scope="col" class="no-wrap">Opentech Seara</th>
            <th scope="col" class="no-wrap">Checklist Aliança</th>
            <th scope="col" class="no-wrap">Checklist Minerva</th>

            <th scope="col" class="no-wrap"><b>---</b></th>

            <th scope="col" class="no-wrap">Razão Social</th>
            <th scope="col" class="no-wrap">Cliente</th>
            <th scope="col" class="no-wrap">Fornecedor</th>
            <th scope="col" class="no-wrap">CNPJ</th>
            <th scope="col" class="no-wrap">Insc. Estadual</th>
            <th scope="col" class="no-wrap">Endereço</th>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Bairro</th>
            <th scope="col" class="no-wrap">Cidade</th>
            <th scope="col" class="no-wrap">CEP</th>
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
            <th scope="col" class="no-wrap">Banco</th>
            <th scope="col" class="no-wrap">Agência</th>
            <th scope="col" class="no-wrap">Conta bancária</th>
            <th scope="col" class="no-wrap">Tipo conta</th>
            <th scope="col" class="no-wrap">Titularidade</th>
            <th scope="col" class="no-wrap">Pix</th>
            <th scope="col" class="no-wrap">RNTRC</th>
            <th scope="col" class="no-wrap">Situação</th>
            <th scope="col" class="no-wrap">Comissão</th>
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
                    @foreach ($item->motoristas as $motorista)
                    <a href="cadastro-motorista/{{ $motorista->cpf }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16" style="float: right; margin-left: 5px;">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>
                    </a>
                    @endforeach
                </td>

                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->nome }} - {{ $motorista->codigo_senior }}<br>
                    @endforeach
                </td>
                </td>
                @else
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->nome }} - {{ $motorista->codigo_senior }}<br>
                    @endforeach
                </td>
                @endif
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->cpf }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->numero_rg }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->municipio_nascimento }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->data_nascimento }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->idade }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->espelho_cnh }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->registro_cnh }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->emissao_cnh }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_cnh }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->categoria_cnh }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->uf_cnh }}{{ $motorista->renach }}<br>
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->ear }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->municipio_cnh }} - {{ $motorista->uf_cnh }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->primeira_cnh }}
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
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->nome_pai }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->nome_mae }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->endereco->rua }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->endereco->numero }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->endereco->bairro }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->endereco->cidade }} - {{ $motorista->endereco->uf }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->endereco->cep }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->integracao_cotramol }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->admissao }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_aso }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_tox }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_tdd }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_opentech_brf }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_opentech_alianca }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_opentech_minerva }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->vencimento_opentech_seara }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->brasil_risk_klabin }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contatoPessoal1->nome ?? '' }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contatoPessoal1->telefone_1 ?? ''}}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contato_pessoal_1_parentesco ?? '' }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contatoPessoal2->nome ?? '' }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contatoPessoal2->telefone_1 ?? ''}}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contato_pessoal_2_parentesco ?? '' }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contatoPessoal3->nome ?? '' }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contatoPessoal3->telefone_1 ?? ''}}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->motoristas as $motorista)
                    {{ $motorista->contato_pessoal_3_parentesco ?? '' }}
                    @endforeach
                </td>

                <td class="no-wrap">
                    ---
                </td>

                <td class="no-wrap">{{ $item->placa }}</td>
                <td class="no-wrap">{{ $item->crlv->renavam }}</td>
                <td class="no-wrap">{{ $item->crlv->ano_fabricacao }}</td>
                <td class="no-wrap">{{ $item->crlv->ano_modelo }}</td>
                <td class="no-wrap">{{ $item->crlv->idade }}</td>
                <td class="no-wrap">{{ $item->crlv->numero_crv }}</td>
                <td class="no-wrap">{{ $item->crlv->codigo_seguranca_cla }}</td>
                <td class="no-wrap">{{ $item->crlv->modelo }}</td>
                <td class="no-wrap">{{ $item->crlv->cor }}</td>
                <td class="no-wrap">{{ $item->crlv->chassi }}</td>
                <td class="no-wrap">{{ $item->crlv->endereco->cidade }} - {{ $item->crlv->endereco->uf }}</td>
                <td class="no-wrap">{{ $item->crlv->cnpj_crlv }}</td>
                <td class="no-wrap">{{ $item->crlv->cpf_crlv }}</td>
                <td class="no-wrap">{{ $item->crlv->emissao_crlv }}</td>
                <td class="no-wrap">{{ $item->crlv->vencimento_crlv }}</td>
                <td class="no-wrap">{{ $item->rntrc }}</td>
                <td class="no-wrap">{{ $item->vencimento_teste_fumaca }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_minerva }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_alianca }}</td>
                <td class="no-wrap">{{ $item->vencimento_opentech_seara }}</td>
                <td class="no-wrap">{{ $item->checklist_alianca }}</td>
                <td class="no-wrap">{{ $item->checklist_minerva }}</td>
                <td class="no-wrap">{{ $item->vencimento_cronotacografo }}</td>
                <td class="no-wrap">{{ $item->certificado_cronotacografo }}</td>
                <td class="no-wrap">{{ $item->grupo }}</td>
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
                <td class="no-wrap">{{ $item->tipo_pedagio }}</td>
                <td class="no-wrap">{{ $item->id_pedagio }}</td>

                <td class="no-wrap">---</td>

                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->placa }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->renavam }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->ano_fabricacao }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->ano_modelo }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->idade }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->numero_crv }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->codigo_seguranca_cla }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->modelo }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->cor }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->chassi }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->endereco->cidade }} - {{ $carreta->crlv->endereco->uf }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->cnpj_crlv }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->cpf_crlv }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->emissao_crlv }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->crlv->vencimento_crlv }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->rntrc }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->vencimento_opentech_minerva }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->vencimento_opentech_alianca }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->vencimento_opentech_seara }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->checklist_alianca }}
                    @endforeach
                </td>
                <td class="no-wrap">
                    @foreach ($item->carretas as $carreta)
                    {{ $carreta->checklist_alianca }}
                    @endforeach
                </td>

                <td class="no-wrap">---</td>

                <td class="no-wrap">{{ $item->transportadoras->razao_social }} - {{ $item->transportadoras->codigo_transportadora }}</td>
                <td class="no-wrap">{{ $item->transportadoras->codigo_cliente }}</td>
                <td class="no-wrap">{{ $item->transportadoras->codigo_fornecedor }}</td>
                <td class="no-wrap">{{ $item->transportadoras->cnpj }}</td>
                <td class="no-wrap">{{ $item->transportadoras->inscricao_estadual }}</td>
                <td class="no-wrap">{{ $item->transportadoras->endereco->rua }}</td>
                <td class="no-wrap">{{ $item->transportadoras->endereco->numero }}</td>
                <td class="no-wrap">{{ $item->transportadoras->endereco->bairro }}</td>
                <td class="no-wrap">{{ $item->transportadoras->endereco->cidade }} - {{ $item->transportadoras->endereco->uf }}</td>
                <td class="no-wrap">{{ $item->transportadoras->endereco->cep }}</td>
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

                <td class="no-wrap">{{ $item->nome_banco_validado }}</td>
                <td class="no-wrap">{{ $item->agencia_validado }}</td>
                <td class="no-wrap">{{ $item->numero_conta_bancaria_validado }}</td>
                <td class="no-wrap">{{ $item->tipo_conta_validado }}</td>
                <td class="no-wrap">{{ $item->titularidade_validado }}</td>
                <td class="no-wrap" id="pix_cavalo">{{ $item->pix_validado }}</td>

                <td class="no-wrap">{{ $item->transportadoras->rntrc }}</td>
                <td class="no-wrap">{{ $item->transportadoras->situacao }}</td>
                <td class="no-wrap">{{ $item->transportadoras->comissao }}</td>
            </tr>
            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection