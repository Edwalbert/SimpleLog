<?php

namespace App\Models\documentos;

use App\Models\util\Endereco;

class Cnpj
{
    protected $cnpj;
    protected $inscricao_estadual;
    protected $razao_social;
    protected $endereco;

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function getInscricaoEstadual()
    {
        return $this->inscricao_estadual;
    }

    public function getRazaoSocial()
    {
        return $this->razao_social;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }


    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function setInscricaoEstadual($inscricao_estadual)
    {
        $this->inscricao_estadual = $inscricao_estadual;
    }

    public function setRazaoSocial($razao_social)
    {
        $this->razao_social = ucfirst(strtolower($razao_social));
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }


   
}
