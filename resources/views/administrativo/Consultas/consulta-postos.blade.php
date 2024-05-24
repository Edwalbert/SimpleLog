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
            <th scope="col" class="no-wrap">Nome</th>
            <th scope="col" class="no-wrap">Telefones</th>
            <th scope="col">Email</th>
            <th scope="col" class="no-wrap">Endereço</th>
        </thead>
        <tbody>
            @php
            $indice = 1;
            @endphp
            @foreach ($postos as $posto)
            <tr>
                <td class="no-wrap">{{$indice}}</td>
                <td class="no-wrap">{{$posto['nome_posto']}}</td>
                <td class="no-wrap">{{$posto->contatoPosto->telefone_1}} {{$posto->contatoPosto->telefone_2}} {{$posto->contatoPosto->telefone_3}} {{$posto->contatoPosto->telefone_4}}</td>
                <td>{{$posto->contatoPosto->email_1 }} {{$posto->contatoPosto->email_2}} {{$posto->contatoPosto->email_3}} {{$posto->contatoPosto->email_4}}</td>
                <td class="no-wrap">{{$posto->enderecoPosto->rua }} {{$posto->enderecoPosto->numero }} {{$posto->enderecoPosto->bairro }} {{$posto->enderecoPosto->cidade }}-{{$posto->enderecoPosto->uf }} </td>
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