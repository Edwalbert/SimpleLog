<?php

namespace App\Models\util;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $rua;
    protected $numero;
    protected $bairro;
    protected $cidade;
    protected $uf;
    protected $cep;
    protected $complemento;
    protected $guarded = [];

    public function getRuaAttribute()
    {
        return $this->attributes['rua'];
    }

    public function getNumeroAttribute()
    {
        return $this->attributes['numero'];
    }

    public function getBairroAttribute()
    {
        return $this->attributes['bairro'];
    }

    public function getCidadeAttribute()
    {
        return $this->attributes['cidade'];
    }

    public function getUfAttribute()
    {
        return $this->attributes['uf'];
    }

    public function getCepAttribute()
    {
        return $this->attributes['cep'];
    }

    public function getComplementoAttribute()
    {
        return $this->attributes['complemento'];
    }


    public function setRuaAttribute($rua)
    {
        $this->attributes['rua'] = ucwords(strtolower($rua));
    }

    public function setNumeroAttribute($numero)
    {
        $this->attributes['numero'] = $numero;
    }

    public function setBairroAttribute($bairro)
    {
        $this->attributes['bairro'] = ucwords(strtolower($bairro));
    }

    public function setCidadeAttribute($cidade)
    {
        $this->attributes['cidade'] = $cidade;
    }

    public function setUfAttribute($uf)
    {
        $this->attributes['uf'] = strtoupper($uf);
    }

    public function setCepAttribute($cep)
    {
        $this->attributes['cep'] = $cep;
    }

    public function setComplementoAttribute($complemento)
    {
        $this->attributes['complemento'] = ucfirst(strtolower($complemento));
    }

    public function save(array $options = [])
    {
        parent::save($options);
    }

    public function enderecoPosto()
    {
        return $this->belongsTo(Posto::class);
    }
}
