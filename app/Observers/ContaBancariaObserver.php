<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\util\ContaBancaria;
use Illuminate\Support\Facades\Auth;

class ContaBancariaObserver
{
    public function created(ContaBancaria $conta_bancaria): void
    {
        $this->logAuditoria('created', $conta_bancaria);
    }

    public function updated(ContaBancaria $conta_bancaria): void
    {
        $this->logAuditoria('updated', $conta_bancaria);
    }

    public function deleted(ContaBancaria $conta_bancaria): void
    {
        $this->logAuditoria('deleted', $conta_bancaria);
    }

    public function restored(ContaBancaria $conta_bancaria): void
    {
        $this->logAuditoria('restored', $conta_bancaria);
    }

    public function forceDeleted(ContaBancaria $conta_bancaria): void
    {
        $this->logAuditoria('forceDeleted', $conta_bancaria);
    }

    private function logAuditoria(string $action, ContaBancaria $conta_bancaria): void
    {
        // $user_id = Auth::id();
        // $request = request(); // Obter a instância atual da requisição, se necessário para url, ip_address, etc.

        // $audit = new Audit();

        // // Usando os setters para definir os valores
        // $audit->setUserIdAttribute($user_id);
        // $audit->setEventAttribute($action);
        // $audit->setAuditableTypeAttribute(get_class($conta_bancaria));
        // $audit->setAuditableIdAttribute($conta_bancaria->id);
        // $audit->setOldValuesAttribute(json_encode($conta_bancaria->getOriginal()));
        // $audit->setNewValuesAttribute(json_encode($conta_bancaria->getAttributes()));
        // $audit->setUrlAttribute($request->url());
        // $audit->setIpAddressAttribute($request->ip());
        // $audit->setUserAgentAttribute($request->userAgent());
        // $audit->setTagsAttribute('');

        // $audit->save();
    }
}
