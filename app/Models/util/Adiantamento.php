<?php

namespace App\Models\util;

use App\Models\pessoas\Motorista;
use App\Models\empresas\Transportadora;
use App\Models\empresas\Posto;
use App\Models\veiculos\Cavalo;
use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adiantamento extends Model
{
    use HasFactory;

    protected $id_cavalo;
    protected $id_posto;
    protected $id_motorista;
    protected $id_transportadora;
    protected $id_user;
    protected $id_email;
    protected $rota;
    protected $data_carregamento;
    protected $observacao;
    protected $valor;
    protected $tipo;
    protected $status;
    protected $em_maos;
    protected $guarded = [];

    public function getIdUserAttribute()
    {
        return $this->attributes['id_user'];
    }

    public function getIdCavaloAttribute()
    {
        return $this->attributes['id_cavalo'];
    }

    public function getDataCarregamentoAttribute()
    {
        return $this->attributes['data_carregamento'];
    }

    public function getIdPostoAttribute()
    {
        return $this->attributes['id_posto'];
    }

    public function getIdMotoristaAttribute()
    {
        return $this->attributes['id_motorista'];
    }

    public function getIdTransportadoraAttribute()
    {
        return $this->attributes['id_transportadora'];
    }

    public function getRotaAttribute()
    {
        return $this->attributes['rota'];
    }

    public function getObservacaoAttribute()
    {
        return $this->attributes['observacao'];
    }

    public function getValorAttribute()
    {
        return $this->attributes['valor'];
    }

    public function getIdEmailAttribute()
    {
        return $this->id_email;
    }

    public function getDataAttribute()
    {
        $trataDadosService = new TrataDadosService();
        $data = $trataDadosService->tratarDatas($this->created_at);
    }

    public function getTipoAttribute()
    {
        return $this->attributes['tipo'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'];
    }

    public function getEmMaosAttribute()
    {
        return $this->attributes['em_maos'];
    }


    public function setIdUserAttribute($id_user)
    {
        $this->attributes['id_user'] = $id_user;
    }

    public function setIdCavaloAttribute($id_cavalo)
    {
        $this->attributes['id_cavalo'] = $id_cavalo;
    }

    public function setDataCarregamentoAttribute($data_carregamento)
    {
        $this->attributes['data_carregamento'] = $data_carregamento;
    }

    public function setIdPostoAttribute($id_posto)
    {
        $this->attributes['id_posto'] = $id_posto;
    }

    public function setIdMotoristaAttribute($id_motorista)
    {
        $this->attributes['id_motorista'] = $id_motorista;
    }

    public function setIdTransportadoraAttribute($id_transportadora)
    {
        $this->attributes['id_transportadora'] = $id_transportadora;
    }

    public function setRotaAttribute($rota)
    {
        $this->attributes['rota'] = $rota;
    }

    public function setObservacaoAttribute($observacao)
    {
        $this->attributes['observacao'] = $observacao;
    }

    public function setValorAttribute($valor)
    {
        $this->attributes['valor'] = $valor;
    }

    public function setIdEmailAttribute($id_email)
    {
        $this->id_email = $id_email;
    }

    public function setTipoAttribute($tipo)
    {
        $this->attributes['tipo'] = $tipo;
    }

    public function setStatusAttribute($status)
    {
        $this->attributes['status'] = $status;
    }

    public function setEmMaosAttribute($em_maos)
    {
        $this->attributes['em_maos'] = $em_maos;
    }

    public function transportadora()
    {
        return $this->belongsTo(Transportadora::class,   'id_transportadora', 'id');
    }

    public function motorista()
    {
        return $this->hasOne(Motorista::class, 'id', 'id_motorista');
    }

    public function cavalo()
    {
        return $this->hasOne(Cavalo::class, 'id', 'id_cavalo');
    }

    public function posto()
    {
        return $this->hasOne(Posto::class, 'id', 'id_posto');
    }
}
