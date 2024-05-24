<?php

namespace App\Models\empresas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Butuca extends Model
{
    use HasFactory;

    protected $nome;
    protected $id_endereco;
    protected $id_conta_bancaria;
    protected $id_contato;
    protected $terminal;
    protected $depot;
    protected $butuca;
    protected $guarded = [];

    public function getNomeAttribute()
    {
        return $this->attributes['nome'];
    }

    public function getIdEnderecoAttribute()
    {
        return $this->attributes['id_endereco'];
    }

    public function getIdContaBancariaAttribute()
    {
        return $this->attributes['id_conta_bancaria'];
    }

    public function getIdContatoAttribute()
    {
        return $this->attributes['id_contato'];
    }

    public function getButucaAttribute()
    {
        return $this->attributes['butuca'];
    }

    public function getTerminalAttribute()
    {
        return $this->attributes['terminal'];
    }

    public function getDepotAttribute()
    {
        return $this->attributes['depot'];
    }

    public function setNomeAttribute($nome)
    {
        $this->attributes['nome'] = $nome;
    }

    public function setIdEnderecoAttribute($id_endereco)
    {
        $this->attributes['id_endereco'] = $id_endereco;
    }

    public function setIdContaBancariaAttribute($id_conta_bancaria)
    {
        $this->attributes['id_conta_bancaria'] = $id_conta_bancaria;
    }

    public function setIdContatoAttribute($id_contato)
    {
        $this->attributes['id_contato'] = $id_contato;
    }

    public function setButucaAttribute($butuca)
    {
        if ($butuca == 'on') {
            $this->attributes['butuca'] = true;
        } else {
            $this->attributes['butuca'] = false;
        }
    }

    public function setTerminalAttribute($terminal)
    {
        if ($terminal == 'on') {
            $this->attributes['terminal'] = true;
        } else {
            $this->attributes['terminal'] = false;
        }
    }

    public function setDepotAttribute($depot)
    {
        if ($depot == 'on') {
            $this->attributes['depot'] = true;
        } else {
            $this->attributes['depot'] = false;
        }
    }
}
