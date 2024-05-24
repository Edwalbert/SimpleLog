<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\empresas\Transportadora;
use Illuminate\Support\Facades\Auth;

class TransportadoraObserver
{
    public function created(Transportadora $transportadora): void
    {
        $this->logAuditoria('created', $transportadora);
    }

    public function updated(Transportadora $transportadora): void
    {
        $this->logAuditoria('updated', $transportadora);
    }

    public function deleted(Transportadora $transportadora): void
    {
        $this->logAuditoria('deleted', $transportadora);
    }

    public function restored(Transportadora $transportadora): void
    {
        $this->logAuditoria('restored', $transportadora);
    }

    public function forceDeleted(Transportadora $transportadora): void
    {
        $this->logAuditoria('forceDeleted', $transportadora);
    }

    private function logAuditoria(string $action, Transportadora $transportadora): void
    {
        // $user_id = Auth::id();
        // $request = request(); // Obter a instância atual da requisição, se necessário para url, ip_address, etc.

        // $audit = new Audit();

        // // Usando os setters para definir os valores
        // $audit->setUserIdAttribute($user_id);
        // $audit->setEventAttribute($action);
        // $audit->setAuditableTypeAttribute(get_class($transportadora));
        // $audit->setAuditableIdAttribute($transportadora->id);
        // $audit->setOldValuesAttribute(json_encode($transportadora->getOriginal()));
        // $audit->setNewValuesAttribute(json_encode($transportadora->getAttributes()));
        // $audit->setUrlAttribute($request->url());
        // $audit->setIpAddressAttribute($request->ip());
        // $audit->setUserAgentAttribute($request->userAgent());
        // $audit->setTagsAttribute('');

        // $audit->save();
    }
}