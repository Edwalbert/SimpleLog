<x-app-layout>

    
    <link rel="stylesheet" href="{{ asset('css/Consultas/consultas.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <form method="POST" action="" id="consultaForm">
        @csrf

        <div class="box-search">
            <a href="solicitar-adiantamento">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" style="margin-right:150px;" fill="white" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                </svg>
            </a>
            <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar" name="pesquisar">
            <button type="submit" class="btn btn-primary btn-search" id="css1" onclick="clickVisualSearch()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
        </div>
    </form>

    <div class="topo_tabela"></div>
    <main>
        @yield('content')
    </main>

    <script>
        function teste() {
            const elementoClicavel = document.getElementById('elementoClicavel');


            elementoClicavel.addEventListener('click', function() {
                const textoParaCopiar = elementoClicavel.textContent;
                const item = new ClipboardItem({
                    "text/plain": new Blob([textoParaCopiar], {
                        type: "text/plain"
                    })
                });

                navigator.clipboard.write([item]).then(function() {
                    alert('Texto copiado para a área de transferência: ' + textoParaCopiar);
                }).catch(function(err) {
                    console.error('Erro ao copiar para a área de transferência:', err);
                });
            });
        }


        function submitForm() {
            document.getElementById("consultaForm").submit();
            setCookie("clickVisualSearch", "visual", 10);
        }

        function clickVisualSearch() {
            setCookie("clickVisualSearch", "search", 10);
        }
    </script>
</x-app-layout>