<?php

namespace App\Observers;

use App\User;
use OwenIt\Auditing\Contracts\Auditable;

class UserObserver
{
    public function creating(Auditable $model)
    {
        // Lógica ao criar um registro
    }

    public function updating(Auditable $model)
    {
        // Lógica ao atualizar um registro
    }

    public function deleting(Auditable $model)
    {
        // Lógica ao excluir um registro
    }
}
