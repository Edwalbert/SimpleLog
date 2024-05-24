<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\veiculos\Cavalo;
use Illuminate\Support\Facades\Auth;

class CavaloObserver
{
    public function created(Cavalo $cavalo): void
    {
        $this->logAuditoria('created', $cavalo);
    }

    public function updated(Cavalo $cavalo): void
    {
        $this->logAuditoria('updated', $cavalo);
    }

    public function deleted(Cavalo $cavalo): void
    {
        $this->logAuditoria('deleted', $cavalo);
    }

    public function restored(Cavalo $cavalo): void
    {
        $this->logAuditoria('restored', $cavalo);
    }

    public function forceDeleted(Cavalo $cavalo): void
    {
        $this->logAuditoria('forceDeleted', $cavalo);
    }

    private function logAuditoria(string $action, Cavalo $cavalo): void
    {
        // $user_id = Auth::id();
        // $request = request(); // Obter a instância atual da requisição, se necessário para url, ip_address, etc.

        // $audit = new Audit;

        // // Usando os setters para definir os valores
        // $audit->setUserIdAttribute($user_id);
        // $audit->setEventAttribute($action);
        // $audit->setAuditableTypeAttribute(get_class($cavalo));
        // $audit->setAuditableIdAttribute($cavalo->id);
        // $audit->setOldValuesAttribute(json_encode($cavalo->getOriginal()));
        // $audit->setNewValuesAttribute(json_encode($cavalo->getAttributes()));
        // $audit->setUrlAttribute($request->url());
        // $audit->setIpAddressAttribute($request->ip());
        // $audit->setUserAgentAttribute($request->userAgent());
        // $audit->setTagsAttribute('');

        // $audit->save();
    }
}
