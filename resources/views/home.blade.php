<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/HomePages/home.css') }}">


    <body class="antialiased">


        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">
            @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endif
                @endauth
            </div>
            @endif


            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="/cadastro" class="scale-100 p-6 bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/cadastro.png">
                                </div>
                                <img src="storage/images/seta-direita.png" style="display:inline-block; position:relative; top:-50px; right:-240px;">
                                <h2 class="mt-6 text-xl font-semibold text-gold dark:text-white">Cadastro</h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Área destinada ao setor de Cadastro.
                                </p>
                            </div>
                        </a>
                        <a href="operacao" class="scale-100 p-6 bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/operacao.png">
                                </div>
                                <img src="storage/images/seta-direita.png" style="display:inline-block; position:relative; top:-50px; right:-240px;">
                                <h2 class="mt-6 text-xl font-semibold text-gold dark:text-white">Operação</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Área destinada ao setor de operações.
                                </p>
                            </div>
                        </a>

                        <a href="administrativo" class="scale-100 p-6 bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/administrativo.png">
                                </div>
                                <img src="storage/images/seta-direita.png" style="display:inline-block; position:relative; top:-50px; right:-240px;">
                                <h2 class="mt-6 text-xl font-semibold text-gold dark:text-white">Administrativo</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Área destinada ao setor administrativo.
                                </p>
                            </div>
                        </a>

                        <a href="/monitoramento" class="scale-100 p-6 bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/monitoramento.png">
                                </div>
                                <img src="storage/images/seta-direita.png" style="display:inline-block; position:relative; top:-50px; right:-240px;">
                                <h2 class="mt-6 text-xl font-semibold text-gold dark:text-white">Monitoramento</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Área destinada ao setor de monitoramento.
                                </p>
                            </div>
                        </a>

                        <a href="/dashboard-adiantamentos" class="scale-100 p-6 bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/monitoramento.png">
                                </div>
                                <img src="storage/images/seta-direita.png" style="display:inline-block; position:relative; top:-50px; right:-240px;">
                                <h2 class="mt-6 text-xl font-semibold text-gold dark:text-white">Dashboards</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">

                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </body>
</x-app-layout>