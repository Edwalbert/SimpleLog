<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\util\Contato;
use Illuminate\Support\Facades\Auth;

class ContatoObserver
{
    public function created(Contato $contato): void
    {
        $this->logAuditoria('created', $contato);
    }

    public function updated(Contato $contato): void
    {
        $this->logAuditoria('updated', $contato);
    }

    public function deleted(Contato $contato): void
    {
        $this->logAuditoria('deleted', $contato);
    }

    public function restored(Contato $contato): void
    {
        $this->logAuditoria('restored', $contato);
    }

    public function forceDeleted(Contato $contato): void
    {
        $this->logAuditoria('forceDeleted', $contato);
    }

    private function logAuditoria(string $action, Contato $contato): void
    {
        // $user_id = Auth::id();
        // $request = request(); // Obter a instância atual da requisição, se necessário para url, ip_address, etc.

        // $audit = new Audit();

        // // Usando os setters para definir os valores
        // $audit->setUserIdAttribute($user_id);
        // $audit->setEventAttribute($action);
        // $audit->setAuditableTypeAttribute(get_class($contato));
        // $audit->setAuditableIdAttribute($contato->id);
        // $audit->setOldValuesAttribute(json_encode($contato->getOriginal()));
        // $audit->setNewValuesAttribute(json_encode($contato->getAttributes()));
        // $audit->setUrlAttribute($request->url());
        // $audit->setIpAddressAttribute($request->ip());
        // $audit->setUserAgentAttribute($request->userAgent());
        // $audit->setTagsAttribute('');

        // $audit->save();
    }
}
