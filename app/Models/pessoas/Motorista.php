<?php

namespace App\Models\pessoas;

use App\Models\Audit;
use App\Models\util\Contato;
use App\Models\util\Endereco;
use App\Services\TrataDadosService;
use App\Models\veiculos\Cavalo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    protected $admissao;
    protected $brasil_risk_klabin;
    protected $categoria_cnh;
    protected $codigo_senior; // Id do motorista no sistema Sênior
    protected $contato_pessoal_1_parentesco;
    protected $contato_pessoal_2_parentesco;
    protected $contato_pessoal_3_parentesco;
    protected $cpf;
    protected $data_expedicao;
    protected $data_nascimento;
    protected $ear;
    protected $emissao_cnh;
    protected $espelho_cnh;
    protected $id_cavalo;
    protected $id_contato_pessoal_1;
    protected $id_contato_pessoal_2;
    protected $id_contato_pessoal_3;
    protected $id_local_residencia;
    protected $id_transportadora;
    protected $integracao_cotramol;
    protected $municipio_cnh;
    protected $municipio_nascimento;
    protected $rescisao;
    protected $motivo_desligamento;
    protected $obs_desligamento;
    protected $nome_mae;
    protected $nome_pai;
    protected $nome;
    protected $numero_rg;
    protected $path_aso;
    protected $path_comprovante_residencia;
    protected $path_cnh;
    protected $path_ficha_registro;
    protected $path_foto_motorista;
    protected $path_integracao_brf;
    protected $path_tdd;
    protected $path_tox;
    protected $path_treinamento_3ps;
    protected $path_treinamento_anti_tombamento;
    protected $primeira_cnh;
    protected $registro_cnh;
    protected $renach;
    protected $status;
    protected $telefone;
    protected $uf_cnh;
    protected $uf_nascimento;
    protected $vencimento_aso;
    protected $vencimento_cnh;
    protected $vencimento_opentech_brf;
    protected $vencimento_opentech_alianca;
    protected $vencimento_opentech_minerva;
    protected $vencimento_opentech_seara;
    protected $vencimento_tox;
    protected $vencimento_tdd;
    protected $pontuacao_demarco;
    protected $status_demarco;
    protected $motivo_bloqueio;

    protected $guarded = [];


    public function getPontuacaoDemarcoAttribute()
    {
        return $this->attributes['pontuacao_demarco'];
    }

    public function getAdmissaoAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['admissao']);
    }

    public function getVencimentoOpentechBrfAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_opentech_brf']);
    }

    public function getBrasilRiskKlabinAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['brasil_risk_klabin']);
    }

    public function getCategoriaCnhAttribute()
    {
        return $this->attributes['categoria_cnh'];
    }

    public function getCodigoSenior()
    {
        return $this->attributes['codigo_senior'];
    }

    public function getContatoPessoal1ParentescoAttribute()
    {
        return $this->attributes['contato_pessoal_1_parentesco'];
    }

    public function getContatoPessoal2ParentescoAttribute()
    {
        return $this->attributes['contato_pessoal_2_parentesco'];
    }

    public function getContatoPessoal3ParentescoAttribute()
    {
        return $this->attributes['contato_pessoal_3_parentesco'];
    }

    public function getCpfAttribute()
    {
        return $this->attributes['cpf'];
    }

    public function getDataExpedicaoAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['data_expedicao']);
    }

    public function getDataNascimentoAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['data_nascimento']);
    }

    public function getEarAttribute()
    {
        return $this->attributes['ear'];
    }

    public function getEmissaoCnhAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['emissao_cnh']);
    }

    public function getEspelhoCnhAttribute()
    {
        return $this->attributes['espelho_cnh'];
    }

    public function getIdCavaloAttribute()
    {
        return $this->attributes['id_cavalo'];
    }

    public function getIdContatoPessoal1Attribute()
    {
        return $this->attributes['id_contato_pessoal_1'];
    }

    public function getIdContatoPessoal2Attribute()
    {
        return $this->attributes['id_contato_pessoal_2'];
    }

    public function getIdContatoPessoal3Attribute()
    {
        return $this->attributes['id_contato_pessoal_3'];
    }

    public function getIdLocalResidencia()
    {
        return $this->attributes['id_local_residencia'];
    }

    public function getIdTransportadoraAttribute()
    {
        return $this->attributes['id_transportadora'];
    }

    public function getIntegracaoCotramolAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['integracao_cotramol']);
    }

    public function getMunicipioCnhAttribute()
    {
        return $this->attributes['municipio_cnh'];
    }

    public function getMunicipioNascimentoAttribute()
    {
        return $this->attributes['municipio_nascimento'];
    }

    public function getRescisaoAttribute()
    {
        return $this->attributes['rescisao'];
    }

    public function getMotivoDesligamentoAttribute()
    {
        return $this->attributes['motivo_desligamento'];
    }

    public function getObsDesligamentoAttribute()
    {
        return $this->attributes['obs_desligamento'];
    }

    public function getNomeAttribute()
    {
        return $this->attributes['nome'];
    }

    public function getNomeMaeAttribute()
    {
        return $this->attributes['nome_mae'];
    }

    public function getNomePaiAttribute()
    {
        return $this->attributes['nome_pai'];
    }

    public function getNumeroRgAttribute()
    {
        return $this->attributes['numero_rg'];
    }

    public function getPathAsoAttribute()
    {
        return $this->attributes['path_aso'];
    }

    public function getPathComprovanteResidenciaAttribute()
    {
        return $this->attributes['path_comprovante_residencia'];
    }

    public function getPathCnhAttribute()
    {
        return $this->attributes['path_cnh'];
    }

    public function getPathFichaRegistroAttribute()
    {
        return $this->attributes['path_ficha_registro'];
    }

    public function getPathFotoMotoristaAttribute()
    {
        return $this->attributes['path_foto_motorista'];
    }

    public function getPathIntegracaoBrfAttribute()
    {
        return $this->attributes['path_integracao_brf'];
    }

    public function getPathTddAttribute()
    {
        return $this->attributes['path_tdd'];
    }

    public function getPathToxAttribute()
    {
        return $this->attributes['path_tox'];
    }

    public function getPathTreinamento3psAttribute()
    {
        return $this->attributes['path_treinamento_3ps'];
    }

    public function getPathTreinamentoAntiTombamentoAttribute()
    {
        return $this->attributes['path_treinamento_anti_tombamento'];
    }

    public function getPrimeiraCnhAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['primeira_cnh']);
    }

    public function getRegistroCnhAttribute()
    {
        return $this->attributes['registro_cnh'];
    }

    public function getRenachAttribute()
    {
        return $this->attributes['renach'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'];
    }

    public function getTelefoneAttribute()
    {
        $trataDadosService = new TrataDadosService();
        return $trataDadosService->tratarTelefone($this->attributes['telefone']);
    }

    public function getUfCnhAttribute()
    {
        return $this->attributes['uf_cnh'];
    }

    public function getUfNascimentoAttribute()
    {
        return $this->attributes['uf_nascimento'];
    }

    public function getVencimentoAsoAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_aso']);
    }

    public function getVencimentoCnhAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_cnh']);
    }

    public function getVencimentoOpentechAliancaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_opentech_alianca']);
    }

    public function getVencimentoOpentechMinervaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_opentech_minerva']);
    }

    public function getVencimentoOpentechSearaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_opentech_seara']);
    }

    public function getVencimentoToxAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_tox']);
    }

    public function getVencimentoTddAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_tdd']);
    }

    public function getStatusDemarcoAttribute()
    {
        return $this->attributes['status_demarco'];
    }

    public function getIdadeAttribute()
    {
        $nascimento = $this->attributes['data_nascimento'];
        $dataNascimento = Carbon::parse($nascimento);
        return $dataNascimento->age;
    }

    public function getMotivoBloqueioAttribute()
    {
        $motivoBloqueio = $this->attributes['motivo_bloqueio'];
        $motivoBloqueio = trim($motivoBloqueio);
        return $motivoBloqueio;
    }



    public function setPontuacaoDemarcoAttribute($pontuacao_demarco)
    {
        $this->attributes['pontuacao_demarco'] = $pontuacao_demarco;
    }

    public function setAdmissaoAttribute($admissao)
    {
        $this->attributes['admissao'] = $admissao;
    }

    public function setVencimentoOpentechBrfAttribute($vencimento_opentech_brf)
    {
        $this->attributes['vencimento_opentech_brf'] = $vencimento_opentech_brf;
    }

    public function setBrasilRiskKlabinAttribute($brasil_risk_klabin)
    {
        $this->attributes['brasil_risk_klabin'] = $brasil_risk_klabin;
    }

    public function setCategoriaCnhAttribute($categoria_cnh)
    {
        $this->attributes['categoria_cnh'] = $categoria_cnh;
    }

    public function setCpfAttribute($cpf)
    {
        $this->attributes['cpf'] = $cpf;
    }

    public function setCodigoSeniorAttribute($codigo_senior)
    {
        $this->attributes['codigo_senior'] = ucfirst(strtolower($codigo_senior));
    }

    public function setContatoPessoal1ParentescoAttribute($contato_pessoal_1_parentesco)
    {
        $this->attributes['contato_pessoal_1_parentesco'] = ucfirst(strtolower($contato_pessoal_1_parentesco));
    }

    public function setContatoPessoal2ParentescoAttribute($contato_pessoal_2_parentesco)
    {
        $this->attributes['contato_pessoal_2_parentesco'] = ucfirst(strtolower($contato_pessoal_2_parentesco));
    }

    public function setContatoPessoal3ParentescoAttribute($contato_pessoal_2_parentesco)
    {
        $this->attributes['contato_pessoal_3_parentesco'] = ucfirst(strtolower($contato_pessoal_2_parentesco));
    }

    public function setDataExpedicaoAttribute($data_expedicao)
    {
        $this->attributes['data_expedicao'] = $data_expedicao;
    }

    public function setDataNascimentoAttribute($data_nascimento)
    {
        $this->attributes['data_nascimento'] = $data_nascimento;
    }

    public function setEarAttribute($ear)
    {
        $this->attributes['ear'] = $ear;
    }

    public function setEmissaoCnhAttribute($emissao_cnh)
    {
        $this->attributes['emissao_cnh'] = $emissao_cnh;
    }

    public function setEspelhoCnhAttribute($espelho_cnh)
    {
        $this->attributes['espelho_cnh'] = $espelho_cnh;
    }

    public function setIdCavaloAttribute($id_cavalo)
    {
        $this->attributes['id_cavalo'] = $id_cavalo;
    }

    public function setIdContatoPessoal1Attribute($id_contato_pessoal_1)
    {
        $this->attributes['id_contato_pessoal_1'] = $id_contato_pessoal_1;
    }

    public function setIdContatoPessoal2Attribute($id_contato_pessoal_2)
    {
        $this->attributes['id_contato_pessoal_2'] = $id_contato_pessoal_2;
    }

    public function setIdContatoPessoal3Attribute($id_contato_pessoal_3)
    {
        $this->attributes['id_contato_pessoal_3'] = $id_contato_pessoal_3;
    }

    public function setIdLocalResidencia($id_local_residencia)
    {
        $this->attributes['id_local_residencia'] = $id_local_residencia;
    }

    public function setIdTransportadoraAttribute($id_transportadora)
    {
        $this->attributes['id_transportadora'] = $id_transportadora;
    }

    public function setIntegracaoCotramolAttribute($integracao_cotramol)
    {
        $this->attributes['integracao_cotramol'] = $integracao_cotramol;
    }

    public function setRescisaoAttribute($rescisao)
    {
        $this->attributes['rescisao'] = $rescisao;
    }

    public function setMotivoDesligamentoAttribute($motivo_desligamento)
    {
        $this->attributes['motivo_desligamento'] = $motivo_desligamento;
    }

    public function setObsDesligamentoAttribute($obs_desligamento)
    {
        $this->attributes['obs_desligamento'] = $obs_desligamento;
    }

    public function setMunicipioCnhAttribute($municipio_cnh)
    {
        $this->attributes['municipio_cnh'] = $municipio_cnh;
    }

    public function setMunicipioNascimentoAttribute($municipio_nascimento)
    {
        $this->attributes['municipio_nascimento'] = $municipio_nascimento;
    }

    public function setNomeAttribute($nome)
    {
        $this->attributes['nome'] = ucwords(strtolower($nome));
    }

    public function setNomeMaeAttribute($nome_mae)
    {
        $this->attributes['nome_mae'] = ucwords(strtolower($nome_mae));
    }

    public function setNomePaiAttribute($nome_pai)
    {
        $this->attributes['nome_pai'] = ucwords(strtolower($nome_pai));
    }

    public function setNumeroRgAttribute($numero_rg)
    {
        $this->attributes['numero_rg'] = $numero_rg;
    }

    public function setPathAsoAttribute($path_aso)
    {
        if ($path_aso !== null) {
            $this->attributes['path_aso'] = $path_aso;
        }
    }

    public function setPathComprovanteResidenciaAttribute($path_comprovante_residencia)
    {
        if ($path_comprovante_residencia !== null) {
            $this->attributes['path_comprovante_residencia'] = $path_comprovante_residencia;
        }
    }

    public function setPathCnhAttribute($path_cnh)
    {
        if ($path_cnh !== null) {
            $this->attributes['path_cnh'] = $path_cnh;
        }
    }

    public function setPathFichaRegistroAttribute($path_ficha_registro)
    {
        if ($path_ficha_registro !== null) {
            $this->attributes['path_ficha_registro'] = $path_ficha_registro;
        }
    }

    public function setPathFotoMotoristaAttribute($path_foto_motorista)
    {
        if ($path_foto_motorista !== null) {
            $this->attributes['path_foto_motorista'] = $path_foto_motorista;
        }
    }

    public function setPathIntegracaoBrfAttribute($path_integracao_brf)
    {
        if ($path_integracao_brf !== null) {
            $this->attributes['path_integracao_brf'] = $path_integracao_brf;
        }
    }

    public function setPathTddAttribute($path_tdd)
    {
        if ($path_tdd !== null) {
            $this->attributes['path_tdd'] = $path_tdd;
        }
    }

    public function setPathToxAttribute($path_tox)
    {
        if ($path_tox !== null) {
            $this->attributes['path_tox'] = $path_tox;
        }
    }

    public function setPathTreinamento3psAttribute($path_treinamento_3ps)
    {
        if ($path_treinamento_3ps !== null) {
            $this->attributes['path_treinamento_3ps'] = $path_treinamento_3ps;
        }
    }

    public function setPathTreinamentoAntiTombamentoAttribute($path_treinamento_anti_tombamento)
    {
        if ($path_treinamento_anti_tombamento !== null) {
            $this->attributes['path_treinamento_anti_tombamento'] = $path_treinamento_anti_tombamento;
        }
    }

    public function setPrimeiraCnhAttribute($primeira_cnh)
    {
        $this->attributes['primeira_cnh'] = $primeira_cnh;
    }

    public function setRegistroCnhAttribute($registro_cnh)
    {
        $this->attributes['registro_cnh'] = $registro_cnh;
    }

    public function setRenachAttribute($renach)
    {
        $this->attributes['renach'] = $renach . $this->uf_cnh;
    }

    public function setStatusAttribute($status)
    {
        if ($status == 'Ativo') {
            $this->attributes['status'] = $status;
            $this->attributes['rescisao'] = null;
            $this->attributes['motivo_desligamento'] = null;
            $this->attributes['obs_desligamento'] = null;
        } elseif ($status == 'Inativo') {
            $this->attributes['status'] = $status;
            $this->attributes['id_cavalo'] = 0;
            $this->attributes['id_transportadora'] = 0;
            $this->attributes['codigo_senior'] = 0;
            $this->attributes['admissao'] = null;
            $this->attributes['integracao_cotramol'] = null;
            $this->attributes['vencimento_aso'] = null;
        }
    }

    public function setTelefoneAttribute($telefone)
    {
        $this->attributes['telefone'] = $telefone;
    }

    public function setUfCnhAttribute($uf_cnh)
    {
        $this->attributes['uf_cnh'] = strtoupper($uf_cnh);
    }

    public function setUfNascimentoAttribute($uf_nascimento)
    {
        $this->attributes['uf_nascimento'] = strtoupper($uf_nascimento);
    }

    public function setVencimentoAsoAttribute($aso)
    {
        $this->attributes['vencimento_aso'] = $aso;
    }

    public function setVencimentoCnhAttribute($vencimento_cnh)
    {
        $this->attributes['vencimento_cnh'] = $vencimento_cnh;
    }

    public function setVencimentoOpentechAliancaAttribute($vencimento_opentech_alianca)
    {
        $this->attributes['vencimento_opentech_alianca'] = $vencimento_opentech_alianca;
    }

    public function setVencimentoOpentechMinervaAttribute($vencimento_opentech_minerva)
    {
        $this->attributes['vencimento_opentech_minerva'] = $vencimento_opentech_minerva;
    }

    public function setVencimentoOpentechSearaAttribute($vencimento_opentech_seara)
    {
        $this->attributes['vencimento_opentech_seara'] = $vencimento_opentech_seara;
    }

    public function setVencimentoTddAttribute($vencimento_tdd)
    {
        $this->attributes['vencimento_tdd'] = $vencimento_tdd;
    }

    public function setVencimentoToxAttribute($vencimento_tox)
    {
        $this->attributes['vencimento_tox'] = $vencimento_tox;
    }

    public function setStatusDemarcoAttribute($status_demarco)
    {
        $this->attributes['status_demarco'] = $status_demarco;
    }


    public function cavalo()
    {
        return $this->belongsTo(Cavalo::class);
    }

    public function contatoPessoal1()
    {
        return $this->hasOne(Contato::class, 'id', 'id_contato_pessoal_1');
    }

    public function contatoPessoal2()
    {
        return $this->hasOne(Contato::class, 'id', 'id_contato_pessoal_2');
    }

    public function contatoPessoal3()
    {
        return $this->hasOne(Contato::class, 'id', 'id_contato_pessoal_3');
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id', 'id_local_residencia');
    }

    public function setMotivoBloqueioAttribute($motivo_bloqueio)
    {
        $this->attributes['motivo_bloqueio'] = $motivo_bloqueio;
    }


    public function getStatusBrfAttribute()
    {
        $vencimento = new TrataDadosService();

        $vencimento_aso = $this->attributes['vencimento_aso'];
        $vencimento_opentech_brf = $this->attributes['vencimento_opentech_brf'];
        $vencimento_tdd = $this->attributes['vencimento_tdd'];
        $vencimento_tox = $this->attributes['vencimento_tox'];
        $status_demarco = $this->attributes['status_demarco'];

        $aso = $vencimento->verificarVencimento($vencimento_aso, 5);
        $opentech = $vencimento->verificarVencimento($vencimento_opentech_brf, 1);
        $tdd = $vencimento->verificarVencimento($vencimento_tdd, 20);
        $tox = $vencimento->verificarVencimento($vencimento_tox, 20);

        if ($status_demarco == 'Liberado') {
            $demarco = 2;
        } elseif ($status_demarco == 'Bloqueado') {
            $demarco = -100;
        } else {
            $demarco = -100;
        }

        $pontos = $aso + $tdd + $opentech + $tox + $demarco;

        if ($pontos == 10) {
            $status_brf = 10;
        } elseif ($pontos > 5 && $pontos < 10) {
            $status_brf = 5;
        } else {
            $status_brf = 0;
        }

        return $status_brf;
    }

    public function getStatusAliancaAttribute()
    {
        $vencimento_opentech_alianca = $this->attributes['vencimento_opentech_alianca'];

        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo = $dataAtual->diffInDays(Carbon::parse($vencimento_opentech_alianca));

        if ($vencimento_opentech_alianca > $hoje && $intervalo > 5) {
            $pontos_alianca = 10;
        } elseif ($vencimento_opentech_alianca > $hoje && $intervalo <= 5) {
            $pontos_alianca = 5;
        } else {
            $pontos_alianca = 0;
        }

        return $pontos_alianca;
    }

    public function getStatusMinervaAttribute()
    {
        $vencimento_opentech_minerva = $this->attributes['vencimento_opentech_minerva'];

        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo = $dataAtual->diffInDays(Carbon::parse($vencimento_opentech_minerva));

        if ($vencimento_opentech_minerva > $hoje && $intervalo > 5) {
            $pontos_minerva = 10;
        } elseif ($vencimento_opentech_minerva > $hoje && $intervalo <= 5) {
            $pontos_minerva = 5;
        } else {
            $pontos_minerva = 0;
        }

        return $pontos_minerva;
    }

    public function getStatusSearaAttribute()
    {
        $vencimento_opentech_seara = $this->attributes['vencimento_opentech_seara'];

        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo = $dataAtual->diffInDays(Carbon::parse($vencimento_opentech_seara));

        if ($vencimento_opentech_seara > $hoje && $intervalo > 5) {
            $pontos_seara = 10;
        } elseif ($vencimento_opentech_seara > $hoje && $intervalo <= 5) {
            $pontos_seara = 5;
        } else {
            $pontos_seara = 0;
        }

        return $pontos_seara;
    }

    public function getStatusKlabinAttribute()
    {
        $brasil_risk_klabin = $this->attributes['brasil_risk_klabin'];

        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo = $dataAtual->diffInDays(Carbon::parse($brasil_risk_klabin));

        if ($brasil_risk_klabin > $hoje && $intervalo > 5) {
            $pontos_klabin = 10;
        } elseif ($brasil_risk_klabin > $hoje && $intervalo <= 5) {
            $pontos_klabin = 5;
        } else {
            $pontos_klabin = 0;
        }

        return $pontos_klabin;
    }


    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
