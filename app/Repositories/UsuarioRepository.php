<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class UsuarioRepository extends Model
{
    protected $table = 'usuarios';

    public function getAll()

    {
        return $this->all();
    }
}
