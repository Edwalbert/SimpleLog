<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\pessoas\Motorista;
use Illuminate\Support\Facades\Auth;

class MotoristaObserver
{
    public function created(Motorista $motorista): void
    {
        $this->logAuditoria('created', $motorista);
    }

    public function updated(Motorista $motorista): void
    {
        $this->logAuditoria('updated', $motorista);
    }

    public function deleted(Motorista $motorista): void
    {
        $this->logAuditoria('deleted', $motorista);
    }

    public function restored(Motorista $motorista): void
    {
        $this->logAuditoria('restored', $motorista);
    }

    public function forceDeleted(Motorista $motorista): void
    {
        $this->logAuditoria('forceDeleted', $motorista);
    }

    private function logAuditoria(string $action, Motorista $motorista): void
    {
        // $user_id = Auth::id();
        // $request = request(); 

        // $audit = new Audit;

        // // Usando os setters para definir os valores
        // $audit->setUserIdAttribute($user_id);
        // $audit->setEventAttribute($action);
        // $audit->setAuditableTypeAttribute(get_class($motorista));
        // $audit->setAuditableIdAttribute($motorista->id);
        // $audit->setOldValuesAttribute(json_encode($motorista->getOriginal()));
        // $audit->setNewValuesAttribute(json_encode($motorista->getAttributes()));
        // $audit->setUrlAttribute($request->url());
        // $audit->setIpAddressAttribute($request->ip());
        // $audit->setUserAgentAttribute($request->userAgent());
        // $audit->setTagsAttribute('');
        // $audit->save();
    }
}
