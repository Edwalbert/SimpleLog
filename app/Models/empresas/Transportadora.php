<?php

namespace App\Models\empresas;

use App\Models\Audit;
use App\Models\Util\Adiantamento;
use App\Models\util\ContaBancaria;
use App\Models\util\Contato;
use App\Models\util\Endereco;
use App\Models\veiculos\Cavalo;
use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transportadora extends Model
{
    protected $cnpj;
    protected $razao_social;
    protected $inscricao_estadual;
    protected $codigo_transportadora;
    protected $codigo_cliente;
    protected $codigo_fornecedor;
    protected $nome_responsavel;
    protected $rntrc;

    protected $situacao;
    protected $comissao;
    protected $id_responsavel;
    protected $id_endereco;
    protected $id_conta_bancaria;
    protected $id_contador;
    protected $status;
    protected $motivo_desligamento;
    protected $path_cnpj;
    protected $path_rntrc;
    protected $guarded = [];

    public function getCnpjAttribute()
    {
        return $this->attributes['cnpj'];
    }

    public function getRazaoSocialAttribute()
    {
        return $this->attributes['razao_social'];
    }

    public function getInscricaoEstadualAttribute()
    {
        return $this->attributes['inscricao_estadual'];
    }

    public function getCodigoTransportadoraAttribute()
    {
        return $this->attributes['codigo_transportadora'];
    }

    public function getCodigoClienteAttribute()
    {
        return $this->attributes['codigo_cliente'];
    }

    public function getCodigoFornecedorAttribute()
    {
        return $this->attributes['codigo_fornecedor'];
    }

    public function getNomeResponsavelAttribute()
    {
        return $this->attributes['nome_responsavel'];
    }

    public function getRntrcAttribute()
    {
        return $this->attributes['rntrc'];
    }

    public function getSituacaoAttribute()
    {
        return $this->attributes['situacao'];
    }

    public function getComissaoAttribute()
    {
        $trataDadosService = new TrataDadosService();
        return $trataDadosService->tratarFloat($this->attributes['comissao']) . '%';
    }
    public function getIdResponsavelAttribute()
    {
        return $this->attributes['id_responsavel'];
    }

    public function getIdEnderecoAttribute()
    {
        return $this->attributes['id_endereco'];
    }

    public function getIdContaBancariaAttribute()
    {
        return $this->attributes['id_conta_bancaria'];
    }

    public function getIdContadorAttribute()
    {
        return $this->attributes['id_contador'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'];
    }

    public function getMotivoDesligamentoAttribute()
    {
        return $this->attributes['motivo_desligamento'];
    }

    public function getPathCnpjAttribute()
    {
        return $this->attributes['path_cnpj'];
    }

    public function getPathRntrcAttribute()
    {
        return $this->attributes['path_rntrc'];
    }


    public function setCnpjAttribute($value)
    {
        $this->attributes['cnpj'] = $value;
    }

    public function setRazaoSocialAttribute($razao_social)
    {
        $this->attributes['razao_social'] = \strtoupper($razao_social);
    }

    public function setInscricaoEstadualAttribute($value)
    {
        $this->attributes['inscricao_estadual'] = $value;
    }

    public function setCodigoTransportadoraAttribute($value)
    {
        $this->attributes['codigo_transportadora'] = $value;
    }

    public function setCodigoClienteAttribute($value)
    {
        $this->attributes['codigo_cliente'] = $value;
    }

    public function setCodigoFornecedorAttribute($value)
    {
        $this->attributes['codigo_fornecedor'] = $value;
    }

    public function setRntrcAttribute($value)
    {
        $this->attributes['rntrc'] = $value;
    }

    public function setSituacaoAttribute($value)
    {
        $this->attributes['situacao'] = $value;
    }

    public function setComissaoAttribute($value)
    {
        $this->attributes['comissao'] = $value;
    }

    public function setIdResponsavelAttribute($id_responsavel)
    {
        $this->attributes['id_responsavel'] = $id_responsavel;
    }

    public function setIdEnderecoAttribute($id_endereco)
    {
        $this->attributes['id_endereco'] = $id_endereco;
    }

    public function setIdContaBancariaAttribute($id_conta_bancaria)
    {
        $this->attributes['id_conta_bancaria'] = $id_conta_bancaria;
    }

    public function setIdContadorAttribute($id_contador)
    {
        $this->attributes['id_contador'] = $id_contador;
    }

    public function setStatusAttribute($status)
    {
        $this->attributes['status'] = $status;
    }

    public function setMotivoDesligamentoAttribute($motivo_desligamento)
    {
        $this->attributes['motivo_desligamento'] = $motivo_desligamento;
    }

    public function setPathCnpjAttribute($path_cnpj)
    {
        $this->attributes['path_cnpj'] = $path_cnpj;
    }

    public function setPathRntrcAttribute($path_rntrc)
    {
        $this->attributes['path_rntrc'] = $path_rntrc;
    }

    public function contaBancaria()
    {
        return $this->hasOne(ContaBancaria::class, 'id', 'id_conta_bancaria');
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id', 'id_endereco');
    }

    public function cavalos()
    {
        return $this->hasMany(Cavalo::class);
    }

    public function responsavel()
    {
        return $this->hasOne(Contato::class, 'id', 'id_responsavel');
    }

    public function contador()
    {
        return $this->hasOne(Contato::class, 'id', 'id_contador');
    }

    public function adiantamentos()
    {
        return $this->hasMany(Adiantamento::class, 'id_transportadora', 'id');
    }

    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
