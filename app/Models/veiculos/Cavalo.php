<?php

namespace App\Models\veiculos;

use App\Models\Audit;
use App\Models\documentos\Crlv;
use App\Models\empresas\Transportadora;
use App\Models\pessoas\Motorista;
use App\Models\Util\Adiantamento;
use App\Models\util\ContaBancaria;
use App\Services\TrataDadosService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cavalo extends Model
{
    protected $placa;
    protected $id_transportadora;
    protected $id_crlv;
    protected $id_conta_bancaria;
    protected $rntrc;
    protected $tecnologia;
    protected $id_rastreador;
    protected $tipo_pedagio;
    protected $id_pedagio;
    protected $grupo;
    protected $login_tecnologia;
    protected $senha_tecnologia;
    protected $certificado_cronotacografo;
    protected $vencimento_teste_fumaca;
    protected $vencimento_cronotacografo;
    protected $vencimento_opentech_minerva;
    protected $vencimento_opentech_alianca;
    protected $vencimento_opentech_seara;
    protected $checklist_alianca;
    protected $checklist_minerva;
    protected $brasil_risk_klabin;
    protected $status;
    protected $motivo_desligamento;
    protected $path_cronotacografo;
    protected $path_rntrc;
    protected $path_teste_fumaca;
    protected $path_foto_cavalo;
    protected $telemetria;

    protected $guarded = [];

    public function getPlacaAttribute()
    {
        return $this->attributes['placa'];
    }
    public function getIdTransportadoraAttribute()
    {
        return $this->attributes['id_transportadora'];
    }

    public function getIdCrlvAttribute()
    {
        return $this->attributes['id_crlv'];
    }

    public function getIdContaBancariaAttribute()
    {
        return $this->attributes['id_conta_bancaria'];
    }

    public function getRntrcAttribute()
    {
        return $this->attributes['rntrc'];
    }

    public function getTecnologiaAttribute()
    {
        return $this->attributes['tecnologia'];
    }

    public function getIdRastreadorAttribute()
    {
        return $this->attributes['id_rastreador'];
    }

    public function getTipoPedagioAttribute()
    {
        return $this->attributes['tipo_pedagio'];
    }

    public function getIdPedagioAttribute()
    {
        return $this->attributes['id_pedagio'];
    }

    public function getGrupoAttribute()
    {
        return $this->attributes['grupo'];
    }

    public function getLoginTecnologiaAttribute()
    {
        return $this->attributes['login_tecnologia'];
    }

    public function getSenhaTecnologiaAttribute()
    {
        return $this->attributes['senha_tecnologia'];
    }

    public function getCertificadoCronotacografoAttribute()
    {
        return $this->attributes['certificado_cronotacografo'];
    }

    public function getVencimentoTesteFumacaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_teste_fumaca']);
    }

    public function getVencimentoCronotacografoAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_cronotacografo']);
    }

    public function getVencimentoOpentechMinervaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_opentech_minerva']);
    }

    public function getVencimentoOpentechAliancaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_opentech_alianca']);
    }

    public function getVencimentoOpentechSearaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['vencimento_opentech_seara']);
    }

    public function getChecklistAliancaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['checklist_alianca']);
    }

    public function getChecklistMinervaAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['checklist_minerva']);
    }

    public function getBrasilRiskKlabinAttribute()
    {
        $tratarDatas = new TrataDadosService();
        return $tratarDatas->tratarDatas($this->attributes['brasil_risk_klabin']);
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'];
    }

    public function getMotivoDesligamentoAttribute()
    {
        return $this->attributes['motivo_desligamento'];
    }

    public function getPathRntrcAttribute()
    {
        return $this->attributes['path_rntrc'];
    }

    public function getPathTesteFumacaAttribute()
    {
        return $this->attributes['path_teste_fumaca'];
    }

    public function getPathFotoCavaloAttribute()
    {
        return $this->attributes['path_foto_cavalo'];
    }

    public function getTelemetriaAttribute()
    {
        return $this->attributes['telemetria'];
    }


    public function setPlacaAttribute($placa)
    {
        $this->attributes['placa'] = strtoupper($placa);
    }

    public function setIdTransportadoraAttribute($id)
    {
        $this->attributes['id_transportadora'] = $id;
    }

    public function setIdCrlvAttribute($id)
    {
        $this->attributes['id_crlv'] = $id;
    }

    public function setIdContaBancariaAttribute($id)
    {
        $this->attributes['id_conta_bancaria'] = $id;
    }

    public function setRntrcAttribute($rntrc)
    {
        $this->attributes['rntrc'] = str_replace(' ', '', $rntrc);
    }

    public function setTecnologiaAttribute($tecnologia)
    {
        $this->attributes['tecnologia'] = trim(ucfirst(strtolower($tecnologia)));
    }

    public function setIdRastreadorAttribute($id_rastreador)
    {
        $this->attributes['id_rastreador'] = str_replace(' ', '', $id_rastreador);
    }

    public function setTipoPedagioAttribute($tipo_pedagio)
    {
        $this->attributes['tipo_pedagio'] = $tipo_pedagio;
    }

    public function setIdPedagioAttribute($id_pedagio)
    {
        $this->attributes['id_pedagio'] = str_replace(' ', '', $id_pedagio);
    }

    public function setGrupoAttribute($grupo)
    {
        $this->attributes['grupo'] = $grupo;
    }

    public function setLoginTecnologiaAttribute($login_tecnologia)
    {
        $this->attributes['login_tecnologia'] = str_replace(' ', '', $login_tecnologia);
    }

    public function setSenhaTecnologiaAttribute($senha_tecnologia)
    {
        $this->attributes['senha_tecnologia'] = str_replace(' ', '', $senha_tecnologia);
    }

    public function setCertificadoCronotacografoAttribute($certificado_cronotacografo)
    {
        $this->attributes['certificado_cronotacografo'] = str_replace(' ', '', $certificado_cronotacografo);
    }

    public function setVencimentoTesteFumacaAttribute($vencimento_teste_fumaca)
    {
        $this->attributes['vencimento_teste_fumaca'] = $vencimento_teste_fumaca;
    }

    public function setVencimentoCronotacografoAttribute($vencimento_cronotacografo)
    {
        $this->attributes['vencimento_cronotacografo'] = $vencimento_cronotacografo;
    }

    public function setVencimentoOpentechMinervaAttribute($vencimento_opentech_minerva)
    {
        $this->attributes['vencimento_opentech_minerva'] = $vencimento_opentech_minerva;
    }

    public function setVencimentoOpentechAliancaAttribute($vencimento_opentech_alianca)
    {
        $this->attributes['vencimento_opentech_alianca'] = $vencimento_opentech_alianca;
    }

    public function setVencimentoOpentechSearaAttribute($vencimento_opentech_seara)
    {
        $this->attributes['vencimento_opentech_seara'] = $vencimento_opentech_seara;
    }

    public function setChecklistAliancaAttribute($checklist_alianca)
    {
        $this->attributes['checklist_alianca'] = $checklist_alianca;
    }

    public function setChecklistMinervaAttribute($checklist_minerva)
    {
        $this->attributes['checklist_minerva'] = $checklist_minerva;
    }

    public function setBrasilRiskKlabinAttribute($brasil_risk_klabin)
    {
        $this->attributes['brasil_risk_klabin'] = $brasil_risk_klabin;
    }

    public function setStatusAttribute($status)
    {
        if ($status == 'Ativo') {
            $this->attributes['status'] = $status;
        } elseif ($status == 'Inativo') {
            $this->attributes['status'] = $status;
            $this->attributes['id_transportadora'] = 0;
        }
    }

    public function setMotivoDesligamentoAttribute($motivo_desligamento)
    {
        $this->attributes['motivo_desligamento'] = $motivo_desligamento;
    }

    public function setPathCronotacografoAttribute($path_cronotacografo)
    {
        $this->attributes['path_cronotacografo'] = '/' . $path_cronotacografo;
    }

    public function setPathRntrcAttribute($path_rntrc)
    {
        $this->attributes['path_rntrc'] =  '/' . $path_rntrc;
    }

    public function setPathTesteFumacaAttribute($path_teste_fumaca)
    {
        $this->attributes['path_teste_fumaca'] =  '/' . $path_teste_fumaca;
    }

    public function setPathFotoCavaloAttribute($path_foto_cavalo)
    {
        $this->attributes['path_foto_cavalo'] =  '/' . $path_foto_cavalo;
    }

    public function setTelemetriaAttribute($telemetria)
    {
        if ($telemetria == 1) {
            $this->attributes['telemetria'] = $telemetria;
        } else {
            $this->attributes['telemetria'] = false;
        }
    }


    public function crlv()
    {
        return $this->hasOne(Crlv::class, 'id', 'id_crlv');
    }

    public function carretas()
    {
        return $this->hasMany(Carreta::class, 'id_cavalo', 'id');
    }

    public function motoristas()
    {
        return $this->hasMany(Motorista::class, 'id_cavalo', 'id');
    }

    public function contaBancaria()
    {
        return $this->hasOne(ContaBancaria::class, 'id', 'id_conta_bancaria');
    }

    public function transportadoras()
    {
        return $this->belongsTo(Transportadora::class, 'id_transportadora', 'id');
    }

    public function adiantamentos()
    {
        return $this->belongsTo(Adiantamento::class, 'id_transportadora', 'id');
    }

    public function getStatusBrfAttribute()
    {
        $telemetria = $this->attributes['telemetria'];
        $id = $this->attributes['id_crlv'];
        $crlv = Crlv::find($id);
        $ano_fabricacao = $crlv->ano_fabricacao;
        $ano_atual = Carbon::now()->year;

        $idade = $ano_atual - $ano_fabricacao;

        if ($idade > 12 || $telemetria == false) {
            $status_brf = 0;
        } else {
            $status_brf = 10;
        }

        return $status_brf;
    }

    public function getStatusAliancaAttribute()
    {
        $vencimento_opentech_alianca = $this->attributes['vencimento_opentech_alianca'];
        $checklist_alianca = $this->attributes['checklist_alianca'];
        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo_opentech = $dataAtual->diffInDays(Carbon::parse($vencimento_opentech_alianca));
        $intervalo_checklist = $dataAtual->diffInDays(Carbon::parse($checklist_alianca));

        if (($vencimento_opentech_alianca > $hoje && $intervalo_opentech > 10) && ($checklist_alianca > $hoje && $intervalo_checklist > 10)) {
            $pontos_alianca = 10;
        } elseif (($vencimento_opentech_alianca > $hoje && $intervalo_opentech <= 10) || ($checklist_alianca > $hoje && $intervalo_checklist <= 10)) {
            $pontos_alianca = 5;
        } else {
            $pontos_alianca = 0;
        }

        return $pontos_alianca;
    }

    public function getStatusMinervaAttribute()
    {
        $vencimento_opentech_minerva = $this->attributes['vencimento_opentech_minerva'];
        $checklist_minerva = $this->attributes['checklist_minerva'];
        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo_opentech = $dataAtual->diffInDays(Carbon::parse($vencimento_opentech_minerva));
        $intervalo_checklist = $dataAtual->diffInDays(Carbon::parse($checklist_minerva));

        if (($vencimento_opentech_minerva > $hoje && $intervalo_opentech > 10) && ($checklist_minerva > $hoje && $intervalo_checklist > 10)) {
            $pontos_minerva = 10;
        } elseif (($vencimento_opentech_minerva > $hoje && $intervalo_opentech <= 10) || ($checklist_minerva > $hoje && $intervalo_checklist <= 10)) {
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
        $intervalo_opentech = $dataAtual->diffInDays(Carbon::parse($vencimento_opentech_seara));

        if ($vencimento_opentech_seara > $hoje && $intervalo_opentech > 10) {
            $pontos_seara = 10;
        } elseif ($vencimento_opentech_seara > $hoje && $intervalo_opentech <= 10) {
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

        if ($brasil_risk_klabin > $hoje && $intervalo > 10) {
            $pontos_klabin = 10;
        } elseif ($brasil_risk_klabin > $hoje && $intervalo <= 10) {
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
