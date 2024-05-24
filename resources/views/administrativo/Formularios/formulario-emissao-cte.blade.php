@extends('administrativo.Formularios.layout')

@section('content')

<section class="section">
    <form method="POST" action="/solicitar-adiantamento" enctype="multipart/form-data">
        @csrf
        <div class="div-form" id="formulario_principal">
            <fieldset class="box">
                <legend id="legend"><b>Cálculo CTe Vibra</b></legend>
                <br>
                <div class="div-form inputBox">
                    <input type="file" id="xml" name="xml" accept=".xml">
                </div>
                <br><br>
                <div class="div-form inputBox" style="margin-left:60px; width: 80px;">
                    <input type="text" class="inputUser" id="ademe" name="ademe" disabled>
                    <label for="ademe" class="labelDropDown">Ademe</label>
                </div>
                <div class="div-form inputBox" style="width: 100px;">
                    <input type="text" class="inputUser" id="frete_liquido" name="frete_liquido" disabled>
                    <label for="frete_liquido" class="labelDropDown">Frete Liq.</label>
                </div>
                <div class="div-form inputBox" style="width: 100px;">
                    <input type="text" class="inputUser" id="frete_composto" name="frete_composto" disabled>
                    <label for="frete_composto" class="labelDropDown">Frete Comp.</label>
                </div>
                <div class="div-form inputBox" style="width: 100px;">
                    <input type="text" class="inputUser" id="icms" name="icms" disabled>
                    <label for="icms" class="labelDropDown">ICMS</label>
                </div>
                <div class="div-form inputBox" style="width: 80px;">
                    <input type="text" class="inputUser" id="seguro" name="seguro" disabled>
                    <label for="seguro" class="labelDropDown">Seguro</label>
                </div>
                <div class="div-form inputBox" style="width:130px;">
                    <input type="text" class="inputUser" id="peso_bruto" name="peso_bruto" disabled>
                    <label for="peso_bruto" class="labelDropDown">Peso B.</label>
                </div>

                <div class="div-form inputBox">
                    <input type="text" class="inputUser" style="width: 50%;" id="cavalo" name="cavalo">
                    <label for="cavalo" class="labelDropDown">Cavalo</label>
                </div>
                <div class=" div-form inputBox" style="margin-left:-70px;">
                    <input type="text" class="inputUser" style="width: 50%; " id="carreta" name="carreta" disabled>
                    <label for="carreta" class="labelDropDown">Carreta</label>
                </div>
                <div class="div-form inputBox" style="margin-left:-70px;">
                    <input type="text" class="inputUser" style="width: 50%; " id="comissao" name="comissao" disabled>
                    <label for="comissao" class="labelDropDown">Comissao</label>
                </div>
                <div class="div-form inputBox" style="margin-left:-70px;">
                    <input type="text" class="inputUser" style="width: 50%;" id="cod_transportadora" name="cod_transportadora" disabled>
                    <label for="cod_transportadora" class="labelDropDown">Cod. Transportador</label>
                </div>
                <div class="div-form inputBox" style="margin-left:-70px;">
                    <input type="text" class="inputUser" style="width: 50%; " id="cod_motorista" name="cod_motorista" disabled>
                    <label for="cod_motorista" class="labelDropDown">Cod. Motorista</label>
                </div>

                <br><br><br>

                <div class="div-form inputBox" style="margin-top: 100px;margin-bottom:20px;">
                    <input type="text" class="inputUser" id="nome_motorista" name="nome_motorista" disabled>
                    <label for="nome_motorista" class="labelDropDown">Nome Motorista</label>
                </div>
                <div class="div-form inputBox" style="margin-top: 100px;margin-bottom:20px;">
                    <input type="text" class="inputUser" id="razao_social" name="razao_social" disabled>
                    <label for="razao_social" class="labelDropDown">Razão Social</label>
                </div>

                <br>
                <div class="div-form inputBox" style="margin-top: 100px; margin-bottom: 20px;">
                    <textarea class="inputUser" id="obs" name="obs" style="height: 200px; width: 500px; overflow-y: auto; word-wrap: break-word;" disabled></textarea>
                    <label for="obs" class="labelDropDown">OBS</label>
                </div>
            </fieldset>
        </div>
    </form>
</section>

<script src="{{ asset('js/Formularios/formulario-solicitar-adiantamento.js') }}"></script>

<script>
    document.getElementById('xml').addEventListener('change', handleFileSelect);

    function handleFileSelect(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const xmlString = e.target.result;
                const xmlDoc = parseXmlString(xmlString);
                const cnpj = xmlDoc.querySelector('CNPJ').textContent;
                const origem = xmlDoc.querySelector('cMun').textContent;
                const destino = xmlDoc.querySelector('xLocExporta').textContent;
                const origemAbreviada = obterOrigemAbreviada(origem);
                const portoAbreviado = obterPortoAbreviado(destino);
                const rota = `${portoAbreviado}...${origemAbreviada}...${portoAbreviado}`;
                let informacaoComplementar = xmlDoc.querySelector('infCpl').textContent;
                const elementosVProd = xmlDoc.querySelectorAll('vProd');
                const valorProdutos = xmlDoc.querySelector('total ICMSTot vProd').textContent;
                const pesoB = xmlDoc.querySelector('vol pesoB').textContent;
                const ademe = calcularAdeme(valorProdutos);
                let posicaoContainer = informacaoComplementar.indexOf("Container:");
                let posicaoTaxa = informacaoComplementar.indexOf("Taxa:");

                var obs = "CONTRIBUINTE AUTORIZADO A EFETUAR O PAGAMENTO DO IMPOSTO NO PRAZO PREVISTO NO RICMS, APENDICE III, SECAO I, ITEM III, CONFORME CONCESSAO NUMERO 0540190200. " + informacaoComplementar.substring(posicaoContainer, posicaoTaxa).trim() + ' Porto de Embarque: ' + destino;
                console.log(rota);
                $.ajax({
                    url: `/verificar-registro/util/Rota/rota/${rota}`,
                    type: "GET",
                    success: function(response) {
                        const vFrete = response.data.frete;
                        const vFreteComposto = calcularFreteComposto(vFrete, ademe);
                        const icms = calcularIcms(vFreteComposto);
                        const seguro = response.data.seguro;
                        exibirResultadosFormatados(vFreteComposto, icms, ademe, obs, vFrete, seguro, pesoB);
                    },
                    error: function() {}
                });
            };

            reader.readAsText(file);
        }

    }

    function parseXmlString(xmlString) {
        const parser = new DOMParser();
        return parser.parseFromString(xmlString, 'text/xml');
    }

    function calcularAdeme(valorProdutos) {
        function arredondaComPrecisao(numero, casasDecimais) {
            const fatorDeMultiplicacao = Math.pow(10, casasDecimais);
            const numeroArredondado = Math.round(numero * fatorDeMultiplicacao) / fatorDeMultiplicacao;
            return numeroArredondado;
        }

        const ademe = arredondaComPrecisao(valorProdutos * 0.0007, 2);
        return ademe;
    }

    function obterOrigemAbreviada(origem) {
        switch (origem) {
            case '4312807':
                return 'NVA';
            default:
                return '';
        }
    }

    function obterPortoAbreviado(destino) {
        switch (destino) {
            case 'SC - ITAPOÁ':
                return 'IOA';
                break;
            case 'SC - NAVEGANTES':
                return 'NVG';
                break;
            case 'PR - PARANAGUÁ':
                return 'PNG';
                break;
            default:
                return '';
        }
    }

    function calcularFreteComposto(vFrete, ademe) {
        return (vFrete + ademe) / 0.88;
    }

    function calcularIcms(vFreteComposto) {
        return vFreteComposto * 0.12;
    }

    function exibirResultadosFormatados(vFreteComposto, icms, ademe, obs, vFrete, seguro, pesoB) {

        const vFreteCompostoFormatado = formatarNumero(vFreteComposto);
        const vFreteFormatado = formatarNumero(vFrete);
        const icmsFormatado = formatarNumero(icms);
        const ademeFormatado = formatarNumero(ademe);
        const pesoBFormatado = pesoB.replace(/\./g, ",");
        $('#frete_composto').val(vFreteCompostoFormatado);
        $('#frete_liquido').val(vFreteFormatado);
        $('#icms').val(icmsFormatado);
        $('#seguro').val(seguro);
        $('#ademe').val(ademeFormatado);
        $('#peso_bruto').val(pesoBFormatado);
        $('#obs').val(obs);

    }

    function formatarNumero(numero) {
        return numero.toFixed(2).replace('.', ',');
    }

    function buscarDados() {
        var placa = document.getElementById('cavalo').value;
        $.ajax({

            url: "/verificar-registro/veiculos/Cavalo/placa/" + placa,
            type: "GET",
            success: function(response2) {
                var id_cavalo = response2.data.id;
                var id_transportadora = response2.data.id_transportadora;
                $('#cavalo').val(response2.data.placa);
                $.ajax({
                    url: "/verificar-registro/veiculos/Carreta/id_cavalo/" + id_cavalo,
                    type: "GET",
                    success: function(response3) {
                        $('#carreta').val(response3.data.placa);
                    },
                    error: function() {}
                });

                $.ajax({
                    url: "/verificar-registro/pessoas/Motorista/id_cavalo/" + id_cavalo,
                    type: "GET",
                    success: function(response4) {
                        $('#cod_motorista').val(response4.data.codigo_senior);
                        $('#nome_motorista').val(response4.data.nome);
                    },
                    error: function() {}
                });

                $.ajax({
                    url: "/verificar-registro/empresas/Transportadora/id/" + id_transportadora,
                    type: "GET",
                    success: function(response5) {
                        $('#cod_transportadora').val(response5.data.codigo_transportadora);
                        $('#comissao').val(formatarNumero(response5.data.comissao) + '%');
                        $('#razao_social').val(response5.data.razao_social);
                    },
                    error: function() {}
                });

            },
            error: function() {}
        });
    }
    $(document).ready(function() {
        $('#cavalo').on('blur', function() {
            buscarDados();
        });
    });
</script>

@endsection