<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/HomePages/home.css') }}">
    </head>

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
                        <div class="scale-100 p-6 card-cadastro bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/cadastro.png">
                                </div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Adiantamentos</h2>
                                <a href="/adiantamentos-solicitados" class="scale-100 p-6-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">- Solicitar Adiantamentos</p>
                                </a>
                                <a href="/autorizar-adiantamento" class="scale-100 p-6-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">- Autorizar Adiantamentos</p>
                                </a>
                                <a href="/consulta-adiantamentos" class="scale-100 p-6-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">- Enviar Adiantamentos</p>
                                </a>
                            </div>
                        </div>
                        <div class="scale-100 p-6 card-cadastro bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/ler.png">
                                </div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Consulta</h2>
                                <a href="/historico-adiantamentos" class="scale-100 p-6-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">- Histórico de Adiantamentos</p>
                                </a>
                                <a href="/historico-adiantamentos" class="scale-100 p-6-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">- Diárias</p>
                                </a>
                                <a href="/historico-adiantamentos" class="scale-100 p-6-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">- CTes</p>
                                </a>
                            </div>
                        </div>

                        <div class="scale-100 p-6 card-cadastro bg-black dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                    <img src="storage/images/cadastro.png">
                                </div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Cadastro</h2>
                                <a href="/cadastro-postos" class="scale-100 p-6-2 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">- Postos</p>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>

</x-app-layout>