<?php

namespace App\Models\util;

use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorColeta extends Model
{
    use HasFactory;

    protected $id_butuca;
    protected $id_terminal_coleta;
    protected $id_terminal_baixa;
    protected $valor;
    protected $guarded = [];

    public function getIdButucaAttribute()
    {
        return $this->attributes['id_butuca'];
    }

    public function getIdTerminalColetaAttribute()
    {
        return $this->attributes['id_terminal_coleta'];
    }

    public function getIdTerminalBaixaAttribute()
    {
        return $this->attributes['id_terminal_baixa'];
    }

    public function getValorAttribute()
    {
        return $this->tratarFloat($this->attributes['valor']);
    }


    public function setIdButucaAttribute($id_butuca)
    {
        $this->attributes['id_butuca'] = $id_butuca;
    }

    public function setIdTerminalColetaAttribute($id_terminal_coleta)
    {
        $this->attributes['id_terminal_coleta'] = $id_terminal_coleta;
    }

    public function setIdTerminalBaixaAttribute($id_terminal_baixa)
    {
        $this->attributes['id_terminal_baixa'] = $id_terminal_baixa;
    }

    public function setValorAttribute($valor)
    {
        $this->attributes['valor'] = $this->converterParaFloat($valor);
    }


    public function converterParaFloat($valor)
    {
        $trataDados = new TrataDadosService;
        return $trataDados->converterParaFloat($valor);
    }

    public function tratarFloat($valor)
    {
        $trataDados = new TrataDadosService;
        return $trataDados->tratarFloat($valor);
    }
}
