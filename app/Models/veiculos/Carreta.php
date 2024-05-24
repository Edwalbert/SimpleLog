<?php

namespace App\Models\veiculos;

use App\Models\Audit;
use App\Models\documentos\Crlv;
use App\Models\veiculos\Veiculo;
use App\Services\TrataDadosService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Carreta extends Model
{
    protected $placa;
    protected $rntrc;
    protected $path_rntrc;
    protected $id_transportadora;
    protected $id_cavalo;
    protected $id_crlv;
    protected $vencimento_opentech_alianca;
    protected $vencimento_opentech_minerva;
    protected $vencimento_opentech_seara;
    protected $checklist_alianca;
    protected $checklist_minerva;
    protected $tipo;
    protected $status;
    protected $motivo_desligamento;

    protected $guarded = [];

    public function getPlacaAttribute()
    {
        return $this->attributes['placa'];
    }

    public function getRntrcAttribute()
    {
        return $this->attributes['rntrc'];
    }

    public function getPathRntrcAttribute()
    {
        return $this->attributes['path_rntrc'];
    }

    public function getIdCrlvAttribute()
    {
        return $this->attributes['id_crlv'];
    }

    public function getIdTransportadoraAttribute()
    {
        return $this->attributes['id_transportadora'];
    }

    public function getIdCavalo()
    {
        return $this->attributes['id_cavalo'];
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

    public function getTipoAttribute()
    {
        return $this->attributes['tipo'];
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'];
    }

    public function getMotivoDesligamentoAttribute()
    {
        return $this->attributes['motivo_desligamento'];
    }


    public function setPlacaAttribute($placa)
    {
        $this->attributes['placa'] = strtoupper($placa);
    }

    public function setRntrcAttribute($rntrc)
    {
        $this->attributes['rntrc'] = $rntrc;
    }

    public function setPathRntrcAttribute($path_rntrc)
    {
        if ($path_rntrc !== null) {
            $this->attributes['path_rntrc'] = $path_rntrc;
        }
    }

    public function setIdCrlvAttribute($id)
    {
        $this->attributes['id_crlv'] = $id;
    }

    public function setIdTransportadoraAttribute($id_transportadora)
    {
        $this->attributes['id_transportadora'] = $id_transportadora;
    }

    public function setIdCavalo($id_cavalo)
    {
        $this->attributes['id_cavalo'] = strtoupper($id_cavalo);
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

    public function setChecklistAliancaAttribute($checklist_alianca)
    {
        $this->attributes['checklist_alianca'] = $checklist_alianca;
    }

    public function setChecklistMinervaAttribute($checklist_minerva)
    {
        $this->attributes['checklist_minerva'] = $checklist_minerva;
    }

    public function setTipoAttribute($tipo)
    {
        $this->attributes['tipo'] = $tipo;
    }

    public function setStatusAttribute($status)
    {

        if ($status == 'Ativo') {
            $this->attributes['status'] = $status;
        } elseif ($status == 'Inativo') {
            $this->attributes['status'] = $status;
            $this->attributes['id_cavalo'] = 0;
            $this->attributes['id_transportadora'] = 0;
        }
    }

    public function setMotivoDesligamentoAttribute($motivo_desligamento)
    {
        $this->attributes['motivo_desligamento'] = $motivo_desligamento;
    }


    public function crlv()
    {
        return $this->hasOne(Crlv::class, 'id', 'id_crlv');
    }


    public function getStatusBrfAttribute()
    {
        $id = $this->attributes['id_crlv'];
        $crlv = Crlv::find($id);
        $ano_fabricacao = $crlv->ano_fabricacao;
        $ano_atual = Carbon::now()->year;

        $idade = $ano_atual - $ano_fabricacao;

        if ($idade > 15) {
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

    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
