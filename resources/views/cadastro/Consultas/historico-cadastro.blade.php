@extends('cadastro.Consultas.consulta-layout')
@section('content')


<div>
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Usuario</th>
            <th scope="col" class="no-wrap">Data/hora</th>
            <th scope="col" class="no-wrap">Nome/Placa</th>
            <th scope="col" class="no-wrap">Coluna alterada</th>
            <th scope="col" class="no-wrap">Valor Antigo</th>
            <th scope="col" class="no-wrap">Novo Valor</th>
        </thead>
        <tbody>
            @foreach ($audits as $item)
            <tr>
                <td class="no-wrap">{{$item['id']}}</td>
                <td class="no-wrap">{{$item['quem_alterou']}}</td>
                <td class="no-wrap">{{$item['quando_alterou']}}</td>
                <td class="no-wrap">{{$item['nome_placa']}}</td>
                <td class="no-wrap">{{$item['coluna']}}</td>
                <td class="no-wrap">{{$item['valor_antigo']}}</td>
                <td class="no-wrap">{{$item['novo_valor']}}</td>
            </tr>

            @endforeach
        </tbody>
    </table>



    <tr>

    </tr>



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