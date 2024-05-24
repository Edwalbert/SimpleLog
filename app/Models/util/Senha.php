<?php

namespace App\Models\Util;

use App\Models\User;
use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Senha extends Model
{
    use HasFactory;

    protected $acesso;
    protected $sistema;
    protected $link;
    protected $login;
    protected $password;
    protected $descricao;
    protected $id_user;
    protected $guarded = [];

    public function getUpdatedAtAttribute()
    {
        $trataDados = new TrataDadosService();
        return $trataDados->tratarDataHora($this->attributes['updated_at']);
    }

    public function getAcessoAttribute()
    {
        return $this->attributes['acesso'];
    }

    public function getSistemaAttribute()
    {
        return $this->attributes['sistema'];
    }

    public function getLinkAttribute()
    {
        return $this->attributes['link'];
    }

    public function getLoginAttribute()
    {
        return $this->attributes['login'];
    }

    public function getPasswordAttribute()
    {
        return $this->attributes['password'];
    }

    public function getDescricaoAttribute()
    {
        return $this->attributes['descricao'];
    }

    public function getIdUserAttribute()
    {
        return $this->attributes['id_user'];
    }



    public function setAcessoAttribute($acesso)
    {
        $this->attributes['acesso'] = $acesso;
    }

    public function setSistemaAttribute($sistema)
    {
        $this->attributes['sistema'] = $sistema;
    }

    public function setLinkAttribute($link)
    {
        $this->attributes['link'] = \strtolower($link);
    }

    public function setLoginAttribute($login)
    {
        $this->attributes['login'] = $login;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = $password;
    }

    public function setDescricaoAttribute($descricao)
    {
        $this->attributes['descricao'] = $descricao;
    }

    public function setIdUserAttribute($id_user)
    {
        $this->attributes['id_user'] = $id_user;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
