<?php

namespace App\Models\documentos;

use App\Models\Audit;
use App\Models\util\Endereco;
use App\Services\TrataDadosService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Crlv extends Model
{

    protected $renavam;
    protected $ano_fabricacao;
    protected $ano_modelo;
    protected $numero_crv;
    protected $codigo_seguranca_cla;
    protected $modelo;
    protected $cor;
    protected $chassi;
    protected $cnpj_crlv;
    protected $cpf_crlv;
    protected $emissao_crlv;
    protected $vencimento_crlv;
    protected $id_endereco;
    protected $path_crlv;

    protected $guarded = [];


    public function getRenavamAttribute()
    {
        return $this->attributes['renavam'];
    }

    public function getAnoFabricacaoAttribute()
    {
        return $this->attributes['ano_fabricacao'];
    }

    public function getAnoModeloAttribute()
    {
        return $this->attributes['ano_modelo'];
    }

    public function getNumeroCrvAttribute()
    {
        return $this->attributes['numero_crv'];
    }

    public function getCodigoSegurancaClaAttribute()
    {
        return $this->attributes['codigo_seguranca_cla'];
    }

    public function getModeloAttribute()
    {
        return $this->attributes['modelo'];
    }

    public function getCorAttribute()
    {
        return $this->attributes['cor'];
    }

    public function getChassiAttribute()
    {
        return $this->attributes['chassi'];
    }

    public function getIdEnderecoAttribute()
    {
        return $this->attributes['id_endereco'];
    }

    public function getCnpjCrlvAttribute()
    {
        return $this->attributes['cnpj_crlv'];
    }

    public function getCpfCrlvAttribute()
    {
        return $this->attributes['cpf_crlv'];
    }

    public function getEmissaoCrlvAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['emissao_crlv']);
    }

    public function getVencimentoCrlvAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_crlv']);
    }

    public function getPathCrlvAttribute()
    {
        return $this->attributes['path_crlv'];
    }

    public function getIdadeAttribute()
    {
        $fabricacao = $this->attributes['ano_fabricacao'];
        $anoAtual = Carbon::now()->format('Y');
        $idade = $anoAtual - $fabricacao;
        return $idade;
    }


    public function setRenavamAttribute($renavam)
    {
        $this->attributes['renavam'] = str_replace(' ', '', $renavam);
    }

    public function setAnoFabricacaoAttribute($ano_fabricacao)
    {
        $this->attributes['ano_fabricacao'] = $ano_fabricacao;
    }

    public function setAnoModeloAttribute($ano_modelo)
    {
        $this->attributes['ano_modelo'] = $ano_modelo;
    }

    public function setNumeroCrvAttribute($numero_crv)
    {
        $this->attributes['numero_crv'] = str_replace(' ', '', $numero_crv);
    }

    public function setCodigoSegurancaClaAttribute($codigo_seguranca_cla)
    {
        $this->attributes['codigo_seguranca_cla'] = str_replace(' ', '', $codigo_seguranca_cla);
    }

    public function setModeloAttribute($modelo)
    {
        $this->attributes['modelo'] = strtoupper($modelo);
    }

    public function setCorAttribute($cor)
    {
        $this->attributes['cor'] = ucfirst(strtolower($cor));
    }

    public function setChassiAttribute($chassi)
    {
        $this->attributes['chassi'] = str_replace(' ', '', strtoupper($chassi));
    }

    public function setIdEnderecoAttribute($id_endereco)
    {
        $this->attributes['id_endereco'] = $id_endereco;
    }

    public function setCnpjCrlvAttribute($cnpj_crlv)
    {
        $this->attributes['cnpj_crlv'] = str_replace(' ', '', $cnpj_crlv);
    }

    public function setCpfCrlvAttribute($cpf_crlv)
    {
        $this->attributes['cpf_crlv'] = str_replace(' ', '', $cpf_crlv);
    }

    public function setEmissaoCrlvAttribute($emissao_crlv)
    {
        $this->attributes['emissao_crlv'] = $emissao_crlv;
    }

    public function setVencimentoCrlvAttribute($vencimento_crlv)
    {
        $this->attributes['vencimento_crlv'] = $vencimento_crlv;
    }

    public function setPathCrlvAttribute($path_crlv)
    {
        if ($path_crlv !== null) {
            $this->attributes['path_crlv'] =  '/' . $path_crlv;
        }
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id', 'id_endereco');
    }

    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
