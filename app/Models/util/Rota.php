<?php

namespace App\Models\util;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    use HasFactory;

    protected $rota;
    protected $frete;
    protected $seguro;
    protected $cliente;
    protected $guarded = [];

    public function getRotaAttribute()
    {
        return $this->attributes['rota'];
    }

    public function getFreteAttribute()
    {
        return $this->attributes['frete'];
    }

    public function getSeguroAttribute()
    {
        return $this->attributes['seguro'];
    }

    public function getClienteAttribute()
    {
        return $this->attributes['cliente'];
    }


    public function setRotaAttribute($rota)
    {
        $this->attributes['rota'] = $rota;
    }

    public function setFreteAttribute($frete)
    {
        $this->attributes['frete'] = $frete;
    }

    public function setSeguroAttribute($seguro)
    {
        $this->attributes['seguro'] = $seguro;
    }

    public function setClienteAttribute($cliente)
    {
        $this->attributes['cliente'] = $cliente;
    }
}
