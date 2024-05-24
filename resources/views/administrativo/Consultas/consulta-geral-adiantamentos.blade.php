@extends('administrativo.Consultas.consulta-layout')
@section('content')

<style>
    /* Estilos para o modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        position: absolute;
        top: 45%;
        left: 45%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        margin-left: 80px;
        margin-top: 80px;
        height: 600px;
        width: 800px;
    }

    .close-btn {
        position: absolute;
        top: -10px;
        right: 3px;
        cursor: pointer;
        font-size: 30px;
        color: red;
    }
</style>

<div id="visual_administrativo">

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <iframe id="pdf-viewer" width="100%" height="600px" style="border: none;"></iframe>
        </div>
    </div>

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
            <th scope="col" class="no-wrap">Ini.</th>
            <th scope="col" class="no-wrap">End.</th>
            <th scope="col" class="no-wrap">Enviar</th>
        </thead>
        <tbody>
            @php
            $indice = 1;
            @endphp
            @foreach ($result as $item)
            <tr>
                <td class="no-wrap">{{$indice}}</td>
                @if($item['placa_repetida'] == true)
                <td class="no-wrap" style="color: red;   font-weight: bold;">{{$item['placa']}}</td>
                @else
                <td class="no-wrap">{{$item['placa']}}</td>
                @endif

                <td class="no-wrap">{{$item['data']}}</td>
                <td class="no-wrap">{{$item['codigo_senior_transportadora']}}</td>
                <td class="no-wrap">{{$item['codigo_senior']}}</td>
                <td class="no-wrap">{{$item['rota']}} - {{ $item['data_carregamento'] }}</td>
                <td class="no-wrap">{{$item['nome_posto']}}</td>
                <td class="no-wrap">{{$item['observacao']}}</td>
                <td class="no-wrap">R$ {{$item['valor']}}</td>
                <td class="no-wrap">{{$item['usuario']}}</td>
                <td class="no-wrap" style="align-items:center;">
                    <svg class="play-icon" data-id="{{ $item['id'] }}" xmlns="http://www.w3.org/2000/svg" style="display: none;" width="20" height="20" fill="currentColor" class="bi bi-play-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 1 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" style="display: none;" data-id="{{ $item['id'] }}" class="bi bi-stop-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3z" />
                    </svg>
                </td>
                <td class="no-wrap" style="align-items:center;">
                    <svg class="bookmark-check" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" data-id="{{ $item['id'] }}" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z" />
                    </svg>
                    <svg class="bookmark-check-fill" mlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" style="display: none;" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                    </svg>
                </td>
                <td class="no-wrap">
                    <form action="/enviar-adiantamento" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_adiantamento" name="id_adiantamento" value="{{ $item['id'] }}">
                        <input type="file" id="carta-frete-{{ $item['id'] }}" name="carta-frete[]" accept=".pdf" multiple>

                        <svg style="display:inline-block; margin-right:5px; cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" data-id="{{ $item['id'] }}" onclick="visualizarPDF(this)">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                        </svg>
                        <button type="submit">
                            <svg style="display:inline-block;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @php
            $indice += 1;
            @endphp
            @endforeach
        </tbody>
    </table>

    <script>
        function openModal(itemId) {
            var fileInput = document.getElementById('carta-frete-' + itemId);
            var pdfViewer = document.getElementById('pdf-viewer');
            var modal = document.getElementById('myModal');

            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];

                if (file.type === 'application/pdf') {
                    var pdfURL = URL.createObjectURL(file);
                    pdfViewer.src = pdfURL;

                    modal.style.display = 'block';

                    window.addEventListener('click', function(event) {
                        if (event.target === modal) {
                            closeModal();
                        }
                    });
                } else {
                    alert('O arquivo selecionado não é um PDF.');
                }
            } else {
                alert('Selecione um arquivo antes de visualizar.');
            }
        }

        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }

        function closeOnEscape(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        }


        // ...

        function visualizarPDF(element) {
            var itemId = element.getAttribute('data-id');
            openModal(itemId);
        }
    </script>

    <script>
        document.querySelectorAll('.play-icon').forEach(function(playButton) {

            var id = playButton.getAttribute('data-id');
            var playIcon = playButton;
            var pauseIcon = playButton.nextElementSibling;

            jQuery.ajax({
                url: "verificar-registro/util/Adiantamento/id/" + id,
                type: "GET",
                success: function(response) {

                    if (response.data.status == 'Em andamento') {
                        playIcon.style.display = 'none';
                        pauseIcon.style.display = 'block';
                    } else {
                        playIcon.style.display = 'block';
                        pauseIcon.style.display = 'none';
                    }

                }
            });

            pauseIcon.addEventListener('click', function() {
                jQuery.ajax({
                    url: "alterar-status-adiantamento/" + id + "/Criado",
                    type: "GET",
                    success: function(response) {
                        playIcon.style.display = 'block';
                        pauseIcon.style.display = 'none';
                    }
                });

            });
        });



        document.querySelectorAll('.play-icon').forEach(function(playButton) {
            playButton.addEventListener('click', function() {
                var id = playButton.getAttribute('data-id');
                var playIcon = playButton;
                var pauseIcon = playButton.nextElementSibling;

                jQuery.ajax({
                    url: "alterar-status-adiantamento/" + id + "/Em andamento",
                    type: "GET",
                    success: function(response) {
                        playIcon.style.display = 'none';
                        pauseIcon.style.display = 'block';
                    }
                });

                pauseIcon.addEventListener('click', function() {
                    jQuery.ajax({
                        url: "alterar-status-adiantamento/" + id + "/Criado",
                        type: "GET",
                        success: function(response) {
                            playIcon.style.display = 'block';
                            pauseIcon.style.display = 'none';
                        }
                    });

                });
            });
        });


        document.querySelectorAll('.bookmark-check').forEach(function(bookmarkCheck) {

            var id = bookmarkCheck.getAttribute('data-id');
            var bookmarkIcon = bookmarkCheck;
            var bookmarkFill = bookmarkCheck.nextElementSibling;

            bookmarkCheck.addEventListener('click', function() { // Correção aqui
                jQuery.ajax({
                    url: "alterar-status-adiantamento/" + id + "/Concluido",
                    type: "GET",
                    success: function(response) {
                        bookmarkCheck.style.display = 'none';
                        bookmarkFill.style.display = 'block';
                        location.reload();
                    }
                });
            });
        });
    </script>
</div>

@endsection