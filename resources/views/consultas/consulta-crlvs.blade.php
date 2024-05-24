@extends('consultas.consulta-layout')
@section('content')

<div style="display: inline-block;">

    <div id="crlv" style="display: inline-block;">
        <table class="table table-striped table-bordered table-bg" style="width: 300px;">
            <thead>
                <th scope=" col" class="no-wrap" style="width: 30px;">Placa</th>
                <th scope=" col" class="no-wrap">CRLV</th>
                <th scope=" col" class="no-wrap">RNTRC</th>
                <th scope=" col" class="no-wrap">TF</th>
                <th scope=" col" class="no-wrap">Foto Frontal</th>
            </thead>
            <tbody>
                @foreach ($result as $veiculo)
                <tr>
                    <td class=" no-wrap">{{ $veiculo->placa }}</td>
                    @if($veiculo->crlv->path_crlv !== null && $veiculo->crlv->path_crlv !== '/...')
                    <td class="no-wrap"><a href="download{{ $veiculo->crlv->path_crlv }}">Download</a></td>
                    @else
                    <td class="no-wrap"><a href=""></a></td>
                    @endif

                    @if($veiculo->path_rntrc !== null && $veiculo->path_rntrc !=='/...')
                    <td class="no-wrap"><a href="download{{ $veiculo->path_rntrc }}">Download</a></td>
                    @else
                    <td class="no-wrap"><a href=""></a></td>
                    @endif

                    @if($veiculo->path_teste_fumaca !== null && $veiculo->path_teste_fumaca !== '/...')
                    <td class="no-wrap"><a href="download{{ $veiculo->path_teste_fumaca }}">Download</a></td>
                    @else
                    <td class="no-wrap"><a href=""></a></td>
                    @endif

                    @if($veiculo->path_foto_cavalo !== null && $veiculo->path_foto_cavalo !== '/...')
                    <td class="no-wrap"><a href="download{{ $veiculo->path_foto_cavalo }}">Download</a></td>
                    @else
                    <td class="no-wrap"><a href=""></a></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection