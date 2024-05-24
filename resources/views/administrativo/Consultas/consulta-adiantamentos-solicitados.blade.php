@extends('administrativo.Consultas.consulta-layout')
@section('content')

<div id="visual-adiantamentos-solicitados">
    <table class="table table-striped table-bordered table-bg" style="width: 10px;">
        <thead>
            <th scope="col" class="no-wrap">N°</th>
            <th scope="col" class="no-wrap">Data</th>
            <th scope="col" class="no-wrap">Cavalo</th>
            <th scope="col" class="no-wrap">Motorista</th>
            <th scope="col" class="no-wrap">Carregamento</th>
            <th scope="col" class="no-wrap">Posto</th>
            <th scope="col" class="no-wrap">Valor</th>
            <th scope="col" class="no-wrap">OBS</th>
            <th scope="col" class="no-wrap">---</th>
            <th scope="col" class="no-wrap">---</th>
        </thead>
        <tbody>
            @php
            $indice = 1;

            @endphp
            @foreach ($result as $item)
            @if($item['status'] == 'Concluido')
            <tr>
                <td class="no-wrap" style="background-color: gray; color:white;">{{$indice}}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">{{$item['data']}}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">{{$item['placa']}}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">{{$item['nome']}}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">{{$item['rota']}} - {{ $item['data_carregamento'] }}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">{{$item['nome_posto']}}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">R$ {{$item['valor']}}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">{{$item['observacao']}}</td>
                <td class="no-wrap" style="background-color: gray; color:white;">
                    <a href="solicitar-adiantamento/{{$item['id']}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </a>
                </td>
                <td class="no-wrap" style="background-color: gray; color:white;">
                    <form action="{{ route('adiantamento.destroy', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @elseif($item['status'] == 'Cancelado')
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">{{$indice}}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">{{$item['data']}}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">{{$item['placa']}}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">{{$item['nome']}}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">{{$item['rota']}} - {{ $item['data_carregamento'] }}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">{{$item['nome_posto']}}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">R$ {{$item['valor']}}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">{{$item['observacao']}}</td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">
                <a href="solicitar-adiantamento/{{$item['id']}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                    </svg>
                </a>
            </td>
            <td class="no-wrap" style="background-color: #ffd9eb; color:red;">
                <form action="{{ route('adiantamento.destroy', ['id' => $item['id']]) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                        </svg>
                    </button>
                </form>
            </td>
            </tr>
            @else
            <tr>
                <td class="no-wrap">{{$indice}}</td>
                <td class="no-wrap">{{$item['data']}}</td>
                <td class="no-wrap">{{$item['placa']}}</td>
                <td class="no-wrap">{{$item['nome']}}</td>
                <td class="no-wrap">{{$item['rota']}} - {{ $item['data_carregamento'] }}</td>
                <td class="no-wrap">{{$item['nome_posto']}}</td>
                <td class="no-wrap">R$ {{$item['valor']}}</td>
                <td class="no-wrap">{{$item['observacao']}}</td>
                <td class="no-wrap">
                    <a href="solicitar-adiantamento/{{$item['id']}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </a>
                </td>
                <td class="no-wrap">
                    <form action="{{ route('adiantamento.destroy', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endif

            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>



@endsection