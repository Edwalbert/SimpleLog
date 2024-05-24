<?php

namespace App\Models\administrativo\retiradas;

use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retirada extends Model
{
    use HasFactory;

    protected $data;
    protected $id_cliente;
    protected $container;
    protected $id_butuca;
    protected $id_rota;
    protected $valor_butuca;
    protected $valor_terminal;
    protected $id_cavalo;
    protected $valor_desconto;
    protected $id_solicitado;
    protected $observacao;
    protected $status;
    protected $guarded = [];

    public function getDataAttribute()
    {
        return $this->attributes['data'];
    }

    public function getIdClienteAttribute()
    {
        return $this->attributes['id_cliente'];
    }

    public function getContainerAttribute()
    {
        return $this->attributes['container'];
    }

    public function getIdButucaAttribute()
    {
        return $this->attributes['id_butuca'];
    }

    public function getIdRotaAttribute()
    {
        return $this->attributes['id_rota'];
    }

    public function getValorButucaAttribute()
    {
        return $this->tratarFloat($this->attributes['valor_butuca']);
    }

    public function getValorTerminalAttribute()
    {
        return $this->tratarFloat($this->attributes['valor_terminal']);
    }

    public function getIdCavaloAttribute()
    {
        return $this->attributes['id_cavalo'];
    }

    public function getValorDescontoAttribute()
    {
        return $this->attributes['valor_desconto'];
    }

    public function getIdSolicitadoAttribute()
    {
        return $this->attributes['id_solicitado'];
    }

    public function getObservacaoAttribute()
    {
        return $this->attributes['observacao'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'];
    }


    public function setDataAttribute($data)
    {
        $this->attributes['data'] = $data;
    }

    public function setIdClienteAttribute($id_cliente)
    {
        $this->attributes['id_cliente'] = $id_cliente;
    }

    public function setContainerAttribute($container)
    {
        $this->attributes['container'] = strtoupper($container);
    }

    public function setIdButucaAttribute($id_butuca)
    {
        $this->attributes['id_butuca'] = $id_butuca;
    }

    public function setIdRotaAttribute($id_rota)
    {
        $this->attributes['id_rota'] = $id_rota;
    }

    public function setValorButucaAttribute($valor_butuca)
    {
        $this->attributes['valor_butuca'] = $this->converterParaFloat($valor_butuca);
    }

    public function setValorTerminalAttribute($valor_terminal)
    {
        $this->attributes['valor_terminal'] = $this->converterParaFloat($valor_terminal);
    }

    public function setIdCavaloAttribute($id_cavalo)
    {
        $this->attributes['id_cavalo'] = $id_cavalo;
    }

    public function setValorDescontoAttribute($valor_desconto)
    {
        $this->attributes['valor_desconto'] = $this->converterParaFloat($valor_desconto);
    }

    public function setIdSolicitadoAttribute($id_solicitado)
    {
        $this->attributes['id_solicitado'] = $id_solicitado;
    }

    public function setStatusAttribute($status)
    {
        $this->attributes['status'] = $status;
    }

    public function setObservacaoAttribute($observacao)
    {
        $this->attributes['observacao'] = $observacao;
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
