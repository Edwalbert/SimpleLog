<?php

namespace App\Models\util;

use App\Models\Audit;
use App\Models\empresas\Posto;
use App\Models\pessoas\Motorista;
use Illuminate\Database\Eloquent\Model;
use App\Services\TrataDadosService;

class Contato extends Model
{
    protected $nome;
    protected $id_empresa;
    protected $cargo;
    protected $telefone_1;
    protected $telefone_2;
    protected $telefone_3;
    protected $telefone_4;
    protected $email_1;
    protected $email_2;
    protected $email_3;
    protected $email_4;
    protected $guarded = [];

    public function getIdEmpresaAttribute()
    {
        return $this->attributes['id_empresa'];
    }

    public function getCargoAttribute()
    {
        return $this->attributes['cargo'];
    }

    public function getTelefone1Attribute()
    {
        $tratarTelefone = new TrataDadosService;
        return $tratarTelefone->tratarFixoOuCelular($this->attributes['telefone_1']);
    }

    public function getTelefone2Attribute()
    {
        $tratarTelefone = new TrataDadosService;
        return $tratarTelefone->tratarFixoOuCelular($this->attributes['telefone_2']);
    }

    public function getTelefone3Attribute()
    {
        $tratarTelefone = new TrataDadosService;
        return $tratarTelefone->tratarFixoOuCelular($this->attributes['telefone_3']);
    }

    public function getTelefone4Attribute()
    {
        $tratarTelefone = new TrataDadosService;
        return $tratarTelefone->tratarFixoOuCelular($this->attributes['telefone_4']);
    }

    public function getEmail1Attribute()
    {
        return $this->attributes['email_1'];
    }

    public function getEmail2Attribute()
    {
        return $this->attributes['email_2'];
    }

    public function getEmail3Attribute()
    {
        return $this->attributes['email_3'];
    }

    public function getEmail4Attribute()
    {
        return $this->attributes['email_4'];
    }

    public function getNomeAttribute()
    {
        return $this->attributes['nome'];
    }

    public function setIdEmpresaAttribute($id_empresa)
    {
        $this->attributes['id_empresa'] = $id_empresa;
    }

    public function setCargoAttribute($cargo)
    {
        $this->attributes['cargo'] = $cargo;
    }

    public function setTelefone1Attribute($telefone1)
    {
        $this->attributes['telefone_1'] = $telefone1;
    }

    public function setTelefone2Attribute($telefone2)
    {
        $this->attributes['telefone_2'] = $telefone2;
    }

    public function setTelefone3Attribute($telefone3)
    {
        $this->attributes['telefone_3'] = $telefone3;
    }

    public function setTelefone4Attribute($telefone4)
    {
        $this->attributes['telefone_4'] = $telefone4;
    }

    public function setEmail1Attribute($email1)
    {
        $this->attributes['email_1'] = strtolower($email1);
    }

    public function setEmail2Attribute($email2)
    {
        $this->attributes['email_2'] = strtolower($email2);
    }

    public function setEmail3Attribute($email3)
    {
        $this->attributes['email_3'] = strtolower($email3);
    }

    public function setEmail4Attribute($email4)
    {
        $this->attributes['email_4'] = strtolower($email4);
    }

    public function setNomeAttribute($nome)
    {
        $this->attributes['nome'] = ucwords(strtolower($nome));
    }

    public function contatoPessoal()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function contatoPosto()
    {
        return $this->belongsTo(Posto::class);
    }

    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
