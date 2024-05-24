<x-app-layout>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/NavBar/nav-bar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Formularios/formularios-cadastro.css') }}">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.css">
        <script src="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>

    <body>
        @yield('content')
    </body>

    <script>
        $('.selectJs').on('select2:open', function() {
            const input = document.querySelector('body > span > span > span.select2-search.select2-search--dropdown > input');
            input.focus();

        });

        $(document).ready(function() {

            $('.selectJs').select2({
                placeholder: 'Selecione uma opção',
                allowClear: true,
            });

            const select2Element = $('.selectJs');
        });
    </script>
</x-app-layout>