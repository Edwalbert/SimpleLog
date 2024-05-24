<?php

namespace App\Models\util;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $nome_banco;
    protected $guarded = [];

    public function getNomeBancoAttribute()
    {
        return $this->attributes['nome_banco'];
    }

    public function setNomeBancoAttribute($nome_banco)
    {
        $this->attributes['nome_banco'] = $nome_banco;
    }

    public function contasBancarias()
    {
        return $this->hasMany(ContaBancaria::class, 'codigo_banco', 'id');
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'codigo_banco', 'id');
    }
}
