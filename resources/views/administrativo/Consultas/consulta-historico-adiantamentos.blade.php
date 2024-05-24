@extends('administrativo.Consultas.consulta-layout')
@section('content')


<div>
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Cavalo</th>
            <th scope="col" class="no-wrap">Data</th>
            <th scope="col" class="no-wrap">Transp.</th>
            <th scope="col" class="no-wrap">Mot.</th>
            <th scope="col" class="no-wrap">Carregamento</th>
            <th scope="col" class="no-wrap">Posto</th>
            <th scope="col" class="no-wrap">OBS</th>
            <th scope="col" class="no-wrap">Valor</th>
            <th scope="col" class="no-wrap">Solicitado</th>
            <th scope="col" class="no-wrap">Status</th>
            <th scope="col" class="no-wrap">-</th>
            <th scope="col" class="no-wrap">-</th>
        </thead>
        <tbody>
            @php
            $indice = 1;

            @endphp
            @foreach ($result as $item)

            <tr>
                <td class="no-wrap">{{$item['id']}}</td>
                <td class="no-wrap">{{$item['placa']}}</td>
                <td class="no-wrap">{{$item['data']}}</td>
                <td class="no-wrap">{{$item['codigo_senior_transportadora']}}</td>
                <td class="no-wrap">{{$item['codigo_senior']}}</td>
                <td class="no-wrap">{{$item['rota']}} - {{ $item['data_carregamento'] }}</td>
                <td class="no-wrap">{{$item['nome_posto']}}</td>

                <td class="larguraFixa">{{$item['observacao']}}</td>


                <td class="no-wrap">R$ {{$item['valor']}}</td>
                <td class="no-wrap">{{$item['usuario']}}</td>
                <td class="no-wrap">{{$item['status']}}</td>
                <td class="no-wrap">
                    <svg class="btn-reativar" data-id="{{ $item['id'] }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                        <title>Reativar Adiantamento</title>
                        <path d="M7.5 1v7h1V1h-1z" />
                        <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
                    </svg>
                </td>

                <td class="no-wrap">
                    <svg class="btn-cancelar" data-id="{{ $item['id'] }}" xmlns="http://www.w3.org/2000/svg" width="14" height="16" fill="red" class="bi bi-ban" viewBox="0 0 16 16">
                        <title>Cancelar Adiantamento</title>
                        <path d="M15 8a6.973 6.973 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8ZM2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Z" />
                    </svg>
                </td>
            </tr>
            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>


    <script>
        document.querySelectorAll('.btn-reativar').forEach(function(reativarBtn) {
            reativarBtn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                console.log('ID da linha:', id);

                jQuery.ajax({
                    url: "alterar-status-adiantamento/" + id + "/Criado",
                    type: "GET",
                    success: function(response) {
                        alert('Reativado!')
                    }
                });
            });
        });

        document.querySelectorAll('.btn-cancelar').forEach(function(cancelarBtn) {
            cancelarBtn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                do {
                    var carta_frete = prompt("Por favor, digite o N° da Carta Frete!");
                } while (carta_frete === null || carta_frete.trim() === "");

                jQuery.ajax({
                    url: "cancelar-adiantamento/" + id + '/' + 'N° Carta Frete. ' + carta_frete,
                    type: "GET",
                    success: function(response) {
                        console.log('ID da linha:', response);
                        jQuery.ajax({

                            type: "GET",
                            success: function(response1) {
                                window.location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>





    @endsection