<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\documentos\Crlv;
use Illuminate\Support\Facades\Auth;

class CrlvObserver
{
    public function created(Crlv $crlv): void
    {
        $this->logAuditoria('created', $crlv);
    }

    public function updated(Crlv $crlv): void
    {
        $this->logAuditoria('updated', $crlv);
    }

    public function deleted(Crlv $crlv): void
    {
        $this->logAuditoria('deleted', $crlv);
    }

    public function restored(Crlv $crlv): void
    {
        $this->logAuditoria('restored', $crlv);
    }

    public function forceDeleted(Crlv $crlv): void
    {
        $this->logAuditoria('forceDeleted', $crlv);
    }

    private function logAuditoria(string $action, Crlv $crlv): void
    {
        // $user_id = Auth::id();
        // $request = request(); // Obter a instância atual da requisição, se necessário para url, ip_address, etc.

        // $audit = new Audit();

        // // Usando os setters para definir os valores
        // $audit->setUserIdAttribute($user_id);
        // $audit->setEventAttribute($action);
        // $audit->setAuditableTypeAttribute(get_class($crlv));
        // $audit->setAuditableIdAttribute($crlv->id);
        // $audit->setOldValuesAttribute(json_encode($crlv->getOriginal()));
        // $audit->setNewValuesAttribute(json_encode($crlv->getAttributes()));
        // $audit->setUrlAttribute($request->url());
        // $audit->setIpAddressAttribute($request->ip());
        // $audit->setUserAgentAttribute($request->userAgent());
        // $audit->setTagsAttribute('');

        // $audit->save();
    }
}
