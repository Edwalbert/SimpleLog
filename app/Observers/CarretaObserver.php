<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\veiculos\Carreta;
use Illuminate\Support\Facades\Auth;

class CarretaObserver
{
    public function created(Carreta $carreta): void
    {
        $this->logAuditoria('created', $carreta);
    }

    public function updated(Carreta $carreta): void
    {
        $this->logAuditoria('updated', $carreta);
    }

    public function deleted(Carreta $carreta): void
    {
        $this->logAuditoria('deleted', $carreta);
    }

    public function restored(Carreta $carreta): void
    {
        $this->logAuditoria('restored', $carreta);
    }

    public function forceDeleted(Carreta $carreta): void
    {
        $this->logAuditoria('forceDeleted', $carreta);
    }

    private function logAuditoria(string $action, Carreta $carreta): void
    {
        // $user_id = Auth::id();
        // $request = request(); // Obter a instância atual da requisição, se necessário para url, ip_address, etc.

        // $audit = new Audit();

        // // Usando os setters para definir os valores
        // $audit->setUserIdAttribute($user_id);
        // $audit->setEventAttribute($action);
        // $audit->setAuditableTypeAttribute(get_class($carreta));
        // $audit->setAuditableIdAttribute($carreta->id);
        // $audit->setOldValuesAttribute(json_encode($carreta->getOriginal()));
        // $audit->setNewValuesAttribute(json_encode($carreta->getAttributes()));
        // $audit->setUrlAttribute($request->url());
        // $audit->setIpAddressAttribute($request->ip());
        // $audit->setUserAgentAttribute($request->userAgent());
        // $audit->setTagsAttribute('');

        // $audit->save();
    }
}
