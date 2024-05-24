<?php

namespace App\Models\pessoas;

use App\Models\documentos\Cnh;
use App\Models\documentos\DocIdentidade;
use App\Models\util\Endereco;
use App\Models\util\Contato;
use DateTime;


class Pessoa
{

    public $nome;
    protected $identidade;
    protected $cnh;
    protected $endereco;
    protected $contato;
    public $idade;


    public function getNome()
    {
        return $this->nome;
    }

    public function getIdade()
    {
        return $this->idade;
    }

    public function getIdentidade()
    {
        return $this->identidade;
    }

    public function getCnh()
    {
        return $this->cnh;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getContato()
    {
        return $this->contato;
    }




    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setIdade()
    {
        $this->idade = $this->calcularIdade();
    }

    public function setIdentidade(DocIdentidade $identidade)
    {
        $this->identidade = $identidade;
    }

    public function setCnh(Cnh $cnh)
    {
        $this->cnh = $cnh;
    }

    public function setEndereco(Endereco $endereco)
    {
        $this->endereco = $endereco;
    }

    public function setContato(Contato $contato)
    {
        $this->contato = $contato;
    }


    public function calcularIdade()
    {
        $aniversario = '';
        $currentDate = new DateTime();
        $aniversario = new DateTime($aniversario);
        $diferenca = $aniversario->diff($currentDate);
        return $diferenca->y;
    }
}
