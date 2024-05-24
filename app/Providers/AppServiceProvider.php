<?php

namespace App\Providers;

use App\Models\documentos\Crlv;
use App\Models\empresas\Transportadora;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\pessoas\Motorista;
use App\Models\util\ContaBancaria;
use App\Models\util\Contato;
use App\Models\veiculos\Carreta;
use App\Models\veiculos\Cavalo;
use App\Observers\CarretaObserver;
use App\Observers\CavaloObserver;
use App\Observers\ContaBancariaObserver;
use App\Observers\ContatoObserver;
use App\Observers\CrlvObserver;
use App\Observers\MotoristaObserver;
use App\Observers\TransportadoraObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Transportadora::observe(TransportadoraObserver::class);
        Motorista::observe(MotoristaObserver::class);
        Cavalo::observe(CavaloObserver::class);
        Carreta::observe(CarretaObserver::class);
        Crlv::observe(CrlvObserver::class);
        Contato::observe(ContatoObserver::class);
        ContaBancaria::observe(ContaBancariaObserver::class);
    }
}
