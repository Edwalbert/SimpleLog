<?php

namespace App\Models\empresas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $razao_social;
    protected $cnpj;
    protected $inscricao_estadual;
    protected $id_contato;
    protected $id_endereco;
    protected $status;

    public function getRazaoSocialAttribute()
    {
        return $this->attributes['razao_social'];
    }

    public function getCnpjAttribute()
    {
        return $this->attributes['cnpj'];
    }

    public function getInscricaoEstadualAttribute()
    {
        return $this->attributes['inscricao_estadual'];
    }

    public function getIdContatoAttribute()
    {
        return $this->attributes['id_contato'];
    }

    public function getIdEnderecoAttribute()
    {
        return $this->attributes['id_endereco'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'];
    }



    public function setRazaoSocialAttribute($razao_social)
    {
        $this->attributes['razao_social'] = $razao_social;
    }

    public function setCnpjAttribute($cnpj)
    {
        $this->attributes['cnpj'] = $cnpj;
    }

    public function setInscricaoEstadualAttribute($inscricao_estadual)
    {
        $this->attributes['inscricao_estadual'] = $inscricao_estadual;
    }

    public function setIdContatoAttribute($id_contato)
    {
        $this->attributes['id_contato'] = $id_contato;
    }

    public function setIdEnderecoAttribute($id_endereco)
    {
        $this->attributes['id_endereco'] = $id_endereco;
    }

    public function setStatusAttribute($status)
    {
        $this->attributes['status'] = $status;
    }
}
