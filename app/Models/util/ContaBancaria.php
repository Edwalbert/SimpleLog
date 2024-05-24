<?php

namespace App\Models\util;

use App\Models\Audit;
use Illuminate\Database\Eloquent\Model;
use App\Models\util\Banco;

class ContaBancaria extends Model
{
    protected $numero_conta_bancaria;
    protected $agencia;
    protected $codigo_banco;
    protected $titularidade;
    protected $tipo_conta;
    protected $pix;
    protected $chave_pix;
    protected $nome_banco;
    protected $guarded = [];

    public function getNomeBancoAttribute()
    {
        return $this->attributes['nome_banco'];
    }

    public function getNumeroContaBancariaAttribute()
    {
        return $this->attributes['numero_conta_bancaria'];
    }

    public function getAgenciaAttribute()
    {
        return $this->attributes['agencia'];
    }

    public function getCodigoBancoAttribute()
    {
        return $this->attributes['codigo_banco'];
    }

    public function getTitularidadeAttribute()
    {
        return $this->attributes['titularidade'];
    }

    public function getTipoContaAttribute()
    {
        return $this->attributes['tipo_conta'];
    }

    public function getPixAttribute()
    {
        return $this->attributes['pix'];
    }

    public function getChavePixAttribute()
    {
        return $this->attributes['chave_pix'];
    }


    public function setNomeBancoAttribute($nome_banco)
    {
        $this->attributes['nome_banco'] = $nome_banco;
    }

    public function setNumeroContaBancariaAttribute($numero_conta_bancaria)
    {
        $this->attributes['numero_conta_bancaria'] = $numero_conta_bancaria;
    }

    public function setAgenciaAttribute($agencia)
    {
        $this->attributes['agencia'] = $agencia;
    }

    public function setCodigoBancoAttribute($codigo_banco)
    {
        $this->attributes['codigo_banco'] = $codigo_banco;
    }

    public function setTitularidadeAttribute($titularidade)
    {
        $this->attributes['titularidade'] = $titularidade;
    }

    public function setTipoContaAttribute($tipo_conta)
    {
        $this->attributes['tipo_conta'] = $tipo_conta;
    }

    public function setPixAttribute($pix)
    {
        $this->attributes['pix'] = $pix;
    }

    public function setChavePixAttribute($chave_pix)
    {
        $this->attributes['chave_pix'] = $chave_pix;
    }

    public function save(array $options = [])
    {
        parent::save($options);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'codigo_banco', 'id');
    }

    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
