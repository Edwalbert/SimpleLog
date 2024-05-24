<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/NavBar/nav-bar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Formularios/formularios-cadastro.css') }}">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.css">
        <script src="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.js"></script>
    </head>

    <body>
        @yield('content')
    </body>
</x-app-layout>