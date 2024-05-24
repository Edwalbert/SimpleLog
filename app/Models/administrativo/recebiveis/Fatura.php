<?php

namespace App\Models\administrativo\recebiveis;

use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    protected $situacao;
    protected $emissao;
    protected $vencimento;
    protected $valor_total;
    protected $id_cliente;
    protected $conhecimentos_relacionados;
    protected $observacao;
    protected $trataDadosService;
    protected $guarded = [];

    public function getSituacaoAttribute()
    {
        return $this->attributes['situacao'];
    }

    public function getEmissaoAttribute()
    {
        $trataDadosService = new TrataDadosService();
        return $trataDadosService->tratarDatas($this->attributes['emissao']);
    }

    public function getVencimentoAttribute()
    {
        $trataDadosService = new TrataDadosService();
        return $trataDadosService->tratarDatas($this->attributes['vencimento']);
    }

    public function getValorTotalAttribute()
    {
        return $this->attributes['valor_total'];
    }

    public function getIdClienteAttribute()
    {
        return $this->attributes['id_cliente'];
    }

    public function getConhecimentosRelacionadosAttribute()
    {
        return $this->attributes['conhecimentos_relacionados'];
    }

    public function getObservacaoAttribute()
    {
        return $this->attributes['observacao'];
    }

    public function setSituacaoAttribute($situacao)
    {
        $this->attributes['situacao'] = $situacao;
    }

    public function setEmissaoAttribute($emissao)
    {
        $this->attributes['emissao'] = $emissao;
    }

    public function setVencimentoAttribute($vencimento)
    {
        $this->attributes['vencimento'] = $vencimento;
    }

    public function setValorTotalAttribute($valor_total)
    {
        $this->attributes['valor_total'] = $valor_total;
    }

    public function setIdClienteAttribute($id_cliente)
    {
        $this->attributes['id_cliente'] = $id_cliente;
    }

    public function setConhecimentosRelacionadosAttribute($conhecimentos_relacionados)
    {
        $this->attributes['conhecimentos_relacionados'] = $conhecimentos_relacionados;
    }

    public function setObservacaoAttribute($observacao)
    {
        $this->attributes['observacao'] = $observacao;
    }
}
