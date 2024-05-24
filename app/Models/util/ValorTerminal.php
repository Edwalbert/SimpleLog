<?php

namespace App\Models\util;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorTerminal extends Model
{
    use HasFactory;

    protected $id_butuca;
    protected $tipo_container;
    protected $valor;
    protected $table = 'valor_terminais';
    protected $guarded = [];

    public function getIdButucaAttribute()
    {
        return $this->attributes['id_butuca'];
    }

    public function getTipoContainerAttribute()
    {
        return $this->attributes['tipo_container'];
    }

    public function getValorAttribute()
    {
        return $this->attributes['valor'];
    }


    public function setIdButucaAttribute($id_butuca)
    {
        $this->attributes['id_butuca'] = $id_butuca;
    }

    public function setTipoContainerAttribute($tipo_container)
    {
        $this->attributes['tipo_container'] = $tipo_container;
    }

    public function setValorAttribute($valor)
    {
        $this->attributes['valor'] = $valor;
    }
}
