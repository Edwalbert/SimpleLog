<?php

namespace App\Models\empresas;

use App\Models\Util\Adiantamento;
use App\Models\util\Contato;
use App\Models\util\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posto extends Model
{
    use HasFactory;

    protected $nome_posto;
    protected $id_contato;
    protected $id_endereco;
    protected $rede;

    protected $guarded = [];

    public function getNomePostoAttribute()
    {
        return $this->attributes['nome_posto'];
    }

    public function getIdContatoAttribute()
    {
        return $this->attributes['id_contato'];
    }

    public function getIdEnderecoAttribute()
    {
        return $this->attributes['id_endereco'];
    }

    public function getRedeAttribute()
    {
        return $this->attributes['rede'];
    }


    public function setNomePostoAttribute($nome_posto)
    {
        $this->attributes['nome_posto'] = ucwords(strtolower($nome_posto));
    }

    public function setIdContatoAttribute($id_contato)
    {
        $this->attributes['id_contato'] = $id_contato;
    }

    public function setIdEnderecoAttribute($id_endereco)
    {
        $this->attributes['id_endereco'] = $id_endereco;
    }

    public function setRedeAttribute($rede)
    {
        $this->attributes['rede'] = $rede;
    }


    public function contatoPosto()
    {
        return $this->hasOne(Contato::class, 'id', 'id_contato');
    }

    public function enderecoPosto()
    {
        return $this->hasOne(Endereco::class, 'id', 'id_endereco');
    }

    public function adiantamentos()
    {
        return $this->belongsTo(Adiantamento::class, 'id_transportadora', 'id');
    }
}
