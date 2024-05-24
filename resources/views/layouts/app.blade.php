<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <head>
        <title>Simplelog</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/NavBar/nav-bar.css') }}">
        <link rel="icon" href="/storage/images/simplelog.png" type="image/png">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">


        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <style>
        body {
            cursor: url(''), auto;
        }

        .alert-container {
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 10;
            width: 400px;
            animation: fadeOut 1.5s ease-in-out 1.5s forwards;
        }


        /* Classe de estilo personalizado para a animação de sucesso */
        .alert-container.success {
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 10;
            width: 400px;
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }

        #error-alert {
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 1);
            border: 5px solid rgba(255, 0, 0, 0.8);
            border-radius: 10px;
        }

        #success-alert {
            opacity: 1;
            transform: translateY(0);
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 1);
            border: 5px solid rgba(0, 128, 0, 0.5);
            border-radius: 10px;
        }

        #success-alert.slide-out {
            transform: translateY(100%);
            opacity: 0;
        }
    </style>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-black-100 dark:bg-gray-900">
        @include('layouts.navigation')
        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @if(session('error'))
        <div class="alert-container">
            <div id="error-alert" class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <script>
            setTimeout(function() {
                var errorAlert = document.getElementsByClassName('error-alert');
                if (errorAlert) {
                    errorAlert.style.display = 'none';
                }
            }, 9000);
        </script>
        @endif

        @if(session('success'))
        <div class="alert-container success">
            <div id="success-alert" class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
        @endif


        @if(session('success'))
        <script>
            setTimeout(function() {
                var successAlert = document.getElementById('success-alert');
                if (successAlert) {
                    successAlert.classList.add('slide-out');
                }
            }, 9000);
        </script>
        @endif

    </div>
</body>

</html>