<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/Consultas/consultas.css') }}">
    <div class="topo_tabela"></div>
    <form method="POST" action="{{ route('consulta') }}" id="consultaForm">
        @csrf
        <div class="box-search">
            <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar" name="pesquisar">
            <button type="submit" class="btn btn-primary btn-search" id="css1" onclick="clickVisualSearch()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
        </div>

        <div class="box">

            @csrf
            <fieldset>
                <select class="select-visual" name="visual" id="visual" onchange="submitForm()">
                    <option value="administrativo" onclick="submitForm()" {{ $visual == 'adm' ? 'selected' : '' }}><b>Administrativo</b></option>
                    <option value="cte" {{ $visual == 'cte' ? 'selected' : '' }}><b>CTE</b></option>
                    <option value="monitoramento" {{ $visual == 'monitoramento' ? 'selected' : '' }}><b>Monitoramento</b></option>
                    <option value="operacao" {{ $visual == 'operacao' ? 'selected' : '' }}><b>Operação</b></option>
                    <option value="ssma" {{ $visual == 'ssma' ? 'selected' : '' }}><b>SSMA</b></option>
                    <option value="senhas" {{ $visual == 'senhas' ? 'selected' : '' }}><b>Senhas</b></option>
                    <option value="vencimentos" {{ $visual == 'vencimentos' ? 'selected' : '' }}><b>Vencimentos</b></option>
                    <option value="motorista_reserva" {{ $visual == 'motorista_reserva' ? 'selected' : '' }}><b>Mot. Reserva</b></option>
                    <option value="cavalos_reserva" {{ $visual == 'cavalos_reserva' ? 'selected' : '' }}><b>Cavalos Reserva</b></option>
                </select>
                </select>
                <br>
        </div>
    </form>


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
    <script>
        var campoPesquisar = document.getElementById('pesquisar');
        var filtroCookie = getCookie('filtroCookie');

        campoPesquisar.value = filtroCookie;
        console.log(filtroCookie);

        function getCookie(name) {
            var cookieValue = null;
            if (document.cookie && document.cookie !== '') {
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i].trim();
                    // Verifica se o cookie começa com o nome desejado
                    if (cookie.substring(0, name.length + 1) === (name + '=')) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        break;
                    }
                }
            }
            return cookieValue;
        }
    </script>
</x-app-layout>