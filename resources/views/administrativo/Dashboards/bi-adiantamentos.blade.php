<x-app-layout>
    @section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <style>
        .kpi-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            background-color: #f2f2f2;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            z-index: 5;
        }

        .kpi-item {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
        }

        .kpi-total-adiantamentos-title {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .kpi-total-adiantamentos-value {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }

        .kpi-valor-total-adiantamentos-value {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>




    <div class="kpi-container">
        <div class="kpi-container-total-adiantamentos kpi-item">
            <form>
                <label class="kpi-total-adiantamentos-title"><b>Data Início</b></label>
                <input type="date" name="data_inicio" style="border-radius: 5px;">
                <br>
            </form>
        </div>
        <div class="kpi-container-total-adiantamentos kpi-item">
            <form>
                <label class="kpi-total-adiantamentos-title"><b>Data Fim</b></label>
                <input type="date" name="data_inicio" style="border-radius: 5px;">
                <br>
            </form>
        </div>
        <div class="kpi-container-total-adiantamentos kpi-item">
            <div class="kpi-total-adiantamentos-title"><b>Total de Adtos</b></div>
            <div class="kpi-total-adiantamentos-value" id="kpi-total-adiantamentos-value">0</div>
        </div>
        <div class="kpi-container-valor-total-adiantamentos kpi-item">
            <div class="kpi-total-adiantamentos-title"><b>Valor Adtos</b></div>
            <div class="kpi-total-adiantamentos-value" id="kpi-valor-total-adiantamentos-value">0</div>
        </div>
        <div class="kpi-container-total-cancelado kpi-item">
            <div class="kpi-total-adiantamentos-title"><b>Adtos Cancelados</b></div>
            <div class="kpi-total-adiantamentos-value" id="kpi-total-adiantamentos-cancelados-value">0</div>
        </div>
        <div class="kpi-container-valor-total-adiantamentos kpi-item">
            <div class="kpi-total-adiantamentos-title"><b>Valor Cancelado</b></div>
            <div class="kpi-total-adiantamentos-value" id="kpi-valor-total-adiantamentos-cancelados-value">0</div>
        </div>

    </div>


    <div style="margin-top:10px; z-index:10;">
        <canvas id="myChart" width="470px"></canvas>
    </div>




    <script>
        $.ajax({
            url: '/consulta-adiantamentos-dashboard',
            dataType: 'json',
            success: function(dados) {

                const adiantamentosGraficoPizza = dados.adiantamentosGraficoPizza;
                var adiantamentos = dados.adiantamentos;
                const labels = adiantamentosGraficoPizza.map(item => item.rede || 'Não Informado');

                const dataValues = adiantamentosGraficoPizza.map(item => {
                    return parseInt(item.valor_total);
                });

                var somaTotalStatus = adiantamentos.reduce(function(acumulador, item) {
                    return acumulador + parseFloat(item.total_status);
                }, 0);

                var somaValorTotalAdiantamentos = adiantamentos.reduce(function(acumulador, item) {
                    return acumulador + parseFloat(item.valor_total);
                }, 0);

                var valorTotalAdiantamentosFormatado = somaValorTotalAdiantamentos.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                var totalCancelados = adiantamentos
                    .filter(function(item) {
                        return item.status === 'Cancelado'; // Filtra apenas itens com status 'Cancelado'
                    }).reduce(function(acumulador, item) {
                        return acumulador + parseFloat(item.total_status); // Soma os valores de total_status
                    }, 0);


                var somaValorTotalAdiantamentosCancelados = adiantamentos
                    .filter(function(item) {
                        return item.status === 'Cancelado'; // Filtra apenas itens com status 'Cancelado'
                    }).reduce(function(acumulador, item) {
                        return acumulador + parseFloat(item.valor_total);
                    }, 0);

                var valorTotalCanceladosFormatado = somaValorTotalAdiantamentosCancelados.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2, // Garante duas casas decimais
                    maximumFractionDigits: 2 // Limita a duas casas decimais
                });

                document.getElementById('kpi-total-adiantamentos-value').textContent = somaTotalStatus;
                document.getElementById('kpi-total-adiantamentos-cancelados-value').textContent = totalCancelados;
                document.getElementById('kpi-valor-total-adiantamentos-value').textContent = 'R$ ' + valorTotalAdiantamentosFormatado;
                document.getElementById('kpi-valor-total-adiantamentos-cancelados-value').textContent = 'R$ ' + valorTotalCanceladosFormatado;

                // Configura o gráfico
                const config = {
                    type: 'doughnut', // Alterado para 'doughnut'
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Distribuição por Posto',
                            data: dataValues,
                            backgroundColor: [
                                'rgba(0, 100, 0, 0.2)', // Verde escuro
                                'rgba(107, 142, 35, 0.2)', // Verde oliva escuro
                                'rgba(85, 107, 47, 0.2)', // Verde oliva
                                'rgba(34, 139, 34, 0.2)', // Verde da primavera
                                'rgba(124, 252, 0, 0.2)', // Grama verde
                                'rgba(218, 165, 32, 0.2)', // Dourado
                                'rgba(255, 215, 0, 0.2)', // Ouro
                                'rgba(189, 183, 107, 0.2)', // Caqui escuro
                                'rgba(240, 230, 140, 0.2)', // Caqui
                                'rgba(255, 223, 0, 0.2)' // Dourado brilhante
                            ],
                            borderColor: [
                                'rgba(0, 100, 0, 1)', // Verde escuro
                                'rgba(107, 142, 35, 1)', // Verde oliva escuro
                                'rgba(85, 107, 47, 1)', // Verde oliva
                                'rgba(34, 139, 34, 1)', // Verde da primavera
                                'rgba(124, 252, 0, 1)', // Grama verde
                                'rgba(218, 165, 32, 1)', // Dourado
                                'rgba(255, 215, 0, 1)', // Ouro
                                'rgba(189, 183, 107, 1)', // Caqui escuro
                                'rgba(240, 230, 140, 1)', // Caqui
                                'rgba(255, 223, 0, 1)' // Dourado brilhante
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            datalabels: {
                                color: 'black', // Cor do texto dos rótulos
                                display: true, // Garante que os rótulos estarão sempre visíveis
                                font: {
                                    weight: 'bold' // Peso da fonte
                                },
                                formatter: (value, ctx) => {
                                    // Personalize o texto do rótulo aqui, se necessário
                                    let label = ctx.chart.data.labels[ctx.dataIndex];
                                    return label + ': ' + value;
                                },
                            }
                        }
                    }
                };

                // Cria o gráfico
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, config);
            },
            error: function() {
                console.log('Erro ao consultar postos');
            }
        });
        // Cria um elemento canvas no HTML para o gráfico
        const ctx = document.getElementById('myChart').getContext('2d');

        // Cria o gráfico
        const myChart = new Chart(ctx, config);
    </script>



</x-app-layout>