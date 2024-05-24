<?php

use App\Http\Controllers\Administrativo\CteController;
use App\Http\Controllers\Administrativo\FaturaController;
use App\Http\Controllers\Administrativo\RetiradaController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Empresas\ButucaController;
use App\Http\Controllers\Empresas\ClienteController;
use App\Http\Controllers\Pessoas\MotoristaController;
use App\Http\Controllers\Empresas\TransportadoraController;
use App\Http\Controllers\Empresas\PostoController;
use App\Http\Controllers\Util\ExcelController;
use App\Http\Controllers\Util\ApiIbgeController;
use App\Http\Controllers\Util\VerificarRegistroController;
use App\Http\Controllers\Util\DownloadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Veiculos\CavaloController;
use App\Http\Controllers\Veiculos\CarretaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Util\AdiantamentoController;
use App\Http\Controllers\Util\ArquivosController;
use App\Http\Controllers\Util\CadastrosController;
use App\Http\Controllers\Util\ConsultaController;
use App\Http\Controllers\Util\PdfController;
use App\Http\Controllers\Util\SenhaController;
use App\Http\Controllers\Util\ValorColetaController;
use App\Http\Controllers\Util\ValorTerminalController;
use App\Models\Util\Adiantamento;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
    Route::get('/callback', 'AuthController@handleProviderCallback');

    Route::get('/consulta-adiantamentos-dashboard', [AdiantamentoController::class, 'consultaParaDashboard'])->name('consulta-adiantamentos-dashboard');
    Route::get('/consulta-postos', [PostoController::class, 'consultaPostos'])->name('consulta-postos');
    Route::post('/consulta-postos', [PostoController::class, 'consultaPostos'])->name('consulta-postos.post');


    Route::get('/buscar-valor-coleta/{coluna}/{id}', [ValorColetaController::class, 'rotas'])->name('buscar-valor-coleta');
    Route::get('/cadastro-valor-coleta', [ValorColetaController::class, 'chamarIndex'])->name('cadastro-valor-coleta');
    Route::get('/cadastro-valor-coleta/{terminalBaixaColeta}', [ValorColetaController::class, 'index'])->name('cadastro-valor-coleta.index');
    Route::post('/cadastro-valor-coleta', [ValorColetaController::class, 'storeOrUpdate'])->name('cadastro-valor-coleta.post');
    Route::get('/cadastro-butucas', [ButucaController::class, 'chamarIndex'])->name('cadastro-butucas');
    Route::post('/cadastro-butucas', [ButucaController::class, 'storeOrUpdate'])->name('cadastro-butucas.post');
    Route::get('/cadastro-valor-terminal/{terminalTipoContainer}', [ValorTerminalController::class, 'index'])->name('cadastro-valor-terminal');
    Route::get('/cadastro-valor-terminal', [ValorTerminalController::class, 'chamarIndex'])->name('cadastro-valor-terminal');
    Route::post('/cadastro-valor-terminal', [ValorTerminalController::class, 'storeOrUpdate'])->name('cadastro-valor-terminal.post');
    Route::get('/solicitar-retirada', [RetiradaController::class, 'chamarIndex'])->name('solicitar-retirada');
    Route::post('/solicitar-retirada', [RetiradaController::class, 'storeOrUpdate'])->name('solicitar-retirada.post');
    Route::get('/retiradas-solicitadas', [RetiradaController::class, 'consultaRetiradasSolicitadas'])->name('retiradas-solicitadas');


    Route::get('/escrever-cte', function () {
        return view('administrativo.Formularios.formulario-escrever-cte');
    })->name('escrever-cte');
    Route::post('/escrever-cte', [CteController::class, 'main'])->name('escrever-cte.post');

    Route::get('/fatura-abbwood', function () {
        return view('administrativo.Recebiveis.Formularios.formulario-fatura-abbwood');
    })->name('fatura-abbwood');

    Route::post('/fatura-abbwood', [FaturaController::class, 'main'])->name('fatura-abbwood.post');


    Route::get('/atualizar-cadastro-portonave/{tipo}/{identificacao}', [CadastrosController::class, 'cadastroPortonave'])->name('atualizar_cadastro_portonave');

    Route::get('/verificar-registro/{path}/{model}/{coluna}/{id}', [VerificarRegistroController::class, 'verificarExistencia'])->name('verificar-existencia');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/settings', function () {
        return view('settings');
    })->middleware(['auth', 'verified'])->name('settings');

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('dashboard-adiantamentos', function () {
        return view('administrativo.Dashboards.bi-adiantamentos');
    })->name('dashboard-adiantamentos');

    Route::get('/download/{caminho}', [DownloadController::class, 'download'])->name('download');
    Route::get('/download-zip/{cavalo}-{carreta}-{cpf}', [DownloadController::class, 'downloadZip'])->name('download.zip');
    Route::get('/consultar-municipios/{uf}', [ApiIbgeController::class, 'consultarMunicipios'])->name('consultar-municipios');

    Route::get('/consulta', [ConsultaController::class, 'verificarVisual'])->name('consulta');
    Route::post('/consulta', [ConsultaController::class, 'verificarVisual'])->name('consulta.visual');
    Route::get('/consulta-documentos ', [ArquivosController::class, 'listarArquivos'])->name('consultar-crlvs');
    Route::post('/processar-excel', [ExcelController::class, 'escolherMetodo'])->name('processar-excel-vencimentos-demarco');

    Route::get('/detran-sc', function () {
        return view('cadastro.Outros.consulta-detran');
    })->name('detran-sc');
    Route::get('/consulta-externa', function () {
        return view('cadastro.Outros.consulta-externa-demarco');
    })->name('consulta-externa-demarco');

    Route::get('/cadastro-senhas', function () {
        $title = 'Senhas';
        return view('operacao.Formularios.formulario-senhas', compact('title'));
    })->name('cadastro-senhas');
    Route::post('/cadastro-senhas', [SenhaController::class, 'storeOrUpdate'])->name('cadastroSenhas.storeOrUpdate');
    Route::get('/cadastro-senhas/{id}', function () {
        $title = 'Senhas';
        return view('operacao.Formularios.formulario-senhas', compact('title'));
    })->name('cadastro-senhas');
    Route::get('/cadastro-postos', [PostoController::class, 'chamarIndex'])->name('cadastro-postos');
    Route::post('/cadastro-postos', [PostoController::class, 'storeOrUpdate'])->name('cadastroPostos.storeOrUpdate');

    Route::get('/historico-adiantamentos', [AdiantamentoController::class, 'consultaHistoricoAdiantamentos'])->name('historico-adiantamentos');
    Route::post('/historico-adiantamentos', [AdiantamentoController::class, 'consultaHistoricoAdiantamentos'])->name('historico-adiantamentos.post');

    Route::group(['middleware' => ['administrativo']], function () {

        Route::get('/administrativo', function () {
            return view('administrativo.home-administrativo');
        })->name('administrativo');

        Route::get('/recebiveis', function () {
            return view('administrativo.Recebiveis.home-recebiveis');
        })->name('recebiveis');

        Route::get('/emissao-cte', function () {
            return view('administrativo.Formularios.formulario-emissao-cte');
        })->name('formulario-emissao-cte');

        Route::get('/cadastro-clientes-resumido', [ClienteController::class, 'consultaFormularioCliente'])->name('cadastro-clientes-resumido');
        Route::post('/cadastro-clientes-resumido', [ClienteController::class, 'store'])->name('cadastro-clientes-resumido.post');
    });

    Route::group(['middleware' => ['enviar_adiantamento']], function () {
        Route::get('/consulta-adiantamentos', [AdiantamentoController::class, 'consultaAdiantamentos'])->name('consulta-adiantamentos');
        Route::post('/consulta-adiantamentos', [AdiantamentoController::class, 'consultaAdiantamentos'])->name('consulta-adiantamentos.search');
        Route::post('/enviar-adiantamento', [AdiantamentoController::class, 'processarEnvios'])->name('processar-adiantamento.enviar');
        Route::get('/alterar-status-adiantamento/{id}/{status}', [AdiantamentoController::class, 'alterarStatusAdiantamento'])->name('alterar-status-adiantamento');
        Route::get('/cancelar-adiantamento/{id}/{obs}', [AdiantamentoController::class, 'cancelarAdiantamento'])->name('cancelar_adiantamento');
    });

    Route::group(['middleware' => ['autorizar_adiantamento']], function () {
        Route::get('/autorizar-adiantamento', [AdiantamentoController::class, 'chamarIndexAutAdiantamento'])->name('autorizar-adiantamento');
        Route::post('/autorizar-adiantamento', [AdiantamentoController::class, 'processarSolicitacoes'])->name('autorizar-adiantamento.processarSolicitacoes');
    });

    Route::group(['middleware' => ['solicitar_adiantamento']], function () {
        Route::get('/adiantamentos-solicitados', [AdiantamentoController::class, 'consultaAdiantamentosSolicitados'])->name('adiantamentos-solicitados');
        Route::post('/adiantamentos-solicitados', [AdiantamentoController::class, 'consultaAdiantamentosSolicitados'])->name('adiantamento-solicitados.post');
        Route::get('/solicitar-adiantamento', [AdiantamentoController::class, 'chamarIndex'])->name('solicitar-adiantamento');
        Route::get('/solicitar-adiantamento/{id}', [AdiantamentoController::class, 'chamarIndex'])->name('solicitar-adiantamento');
        Route::post('/solicitar-adiantamento', [AdiantamentoController::class, 'processarSolicitacoes'])->name('solicitar-adiantamento.processarSolicitacoes');
        Route::delete('/solicitar-adiantamento/{id}', [AdiantamentoController::class, 'destroy'])->name('adiantamento.destroy');
    });

    Route::group(['middleware' => ['operacao']], function () {
        Route::get('/operacao', function () {
            return view('operacao.home-operacao');
        })->name('operacao');
    });

    Route::group(['middleware' => ['monitoramento']], function () {
        Route::get('/monitoramento', function () {
            return view('monitoramento.home-monitoramento');
        })->name('operacao');
    });

    Route::group(['middleware' => ['cadastro']], function () {
        Route::get('/cadastro', function () {
            return view('cadastro.home-cadastro');
        })->name('cadastro');
        Route::get('/cadastro-cavalo', function () {
            $title = 'Formulario Cavalo';
            return view('cadastro.Formularios.formulario-cavalo', compact('title'));
        })->name('cadastro-cavalo.get');
        Route::get('/cadastro-cavalo', [CavaloController::class, 'chamarIndex'])->name('cadastro-cavalo');
        Route::post('/cadastro-cavalo', [CavaloController::class, 'storeOrUpdate'])->name('cadastro-cavalo.storeOrUpdate');
        Route::get('/cadastro-carreta', function () {
            $title = 'Formulario Carreta';
            return view('cadastro.Formularios.formulario-carreta', compact('title'));
        });
        Route::get('/cadastro-carreta', [CarretaController::class, 'chamarIndex'])->name('cadastro-carreta');
        Route::post('/cadastro-carreta', [CarretaController::class, 'storeOrUpdate'])->name('cadastro-carreta.storeOrUpdate');
        Route::get('/cadastro-motorista/{cpf?}', [MotoristaController::class, 'chamarIndex'])->name('cadastro-motorista');
        Route::post('/cadastro-motorista', [MotoristaController::class, 'storeOrUpdate'])->name('cadastro-motorista.storeOrUpdate');
        Route::get('/cadastro-transportadora', function () {
            $title = 'Formulario Transportadora';
            return view('cadastro.Formularios.formulario-transportadora', compact('title'));
        })->name('cadastro-transportadora');
        Route::post('/cadastro-transportadora', [TransportadoraController::class, 'storeOrUpdate'])->name('cadastro-transportadora.storeOrUpdate');

        Route::get('/importar-demarco', function () {
            $title = 'Importar Dados Demarco';
            return view('cadastro.Formularios.importar-demarco', compact('title'));
        })->name('importar-demarco');

        Route::get('/historico-cadastro', [AuditController::class, 'historicoMotorista'])->name('historico-cadastro');
        Route::post('/historico-cadastro', [AuditController::class, 'historicoMotorista'])->name('historico-cadastro.post');
    });
});
require __DIR__ . '/auth.php';
