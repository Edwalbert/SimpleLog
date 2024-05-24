<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosDeTelemetria extends Model
{
    use HasFactory;
  
    protected $data_hora;
    protected $veiculo;
    protected $motorista;
    protected $descricao_evento;
    protected $nome_cerca;
    protected $velocidade;
    protected $hodometro;
    protected $duracao;
    protected $guarded = [];  
    protected $table = 'telemetria';

    public function getDataHoraAttribute()
    {
        return $this->attributes['data_hora'];
    }

    public function getVeiculoAttribute()
    {
        return $this->attributes['veiculo'];
    }

    public function getMotoristaAttribute()
    {
        return $this->attributes['motorista'];
    }

    public function getDescricaoEventoAttribute()
    {
        return $this->attributes['descricao_evento'];
    }

    public function getNomeCercaAttribute()
    {
        return $this->attributes['nome_cerca'];
    }

    public function getVelocidadeAttribute()
    {
        return $this->attributes['velocidade'];
    }

    public function getHodometroAttribute()
    {
        return $this->attributes['hodometro'];
    }

    public function getDuracaoAttribute()
    {
        return $this->attributes['duracao'];
    }


    public function setDataHoraAttribute($data_hora)
    {
        $this->attributes['data_hora'] = $data_hora;
    }

    public function setVeiculoAttribute($veiculo)
    {
        $veiculo = substr($veiculo,0,7);
        $this->attributes['veiculo'] = $veiculo;
    }

    public function setMotoristaAttribute($motorista)
    {
        $this->attributes['motorista'] = $motorista;
    }

    public function setDescricaoEventoAttribute($descricao_evento)
    {
        $this->attributes['descricao_evento'] = $descricao_evento;
    }

    public function setNomeCercaAttribute($nome_cerca)
    {
        $this->attributes['nome_cerca'] = $nome_cerca;
    }

    public function setVelocidadeAttribute($velocidade)
    {
        $this->attributes['velocidade'] = $velocidade;
    }

    public function setHodometroAttribute($hodometro)
    {
        $this->attributes['hodometro'] = $hodometro;
    }

    public function setDuracaoAttribute($duracao)
    {
        $this->attributes['duracao'] = $duracao;
    }
    
}
