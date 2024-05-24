<?php

namespace App\Models\pessoas;

class Read extends Pessoa
{
    protected $cpf;
    protected $nome;
    protected $senha;
    protected $email;
    protected $setor;
    protected $search;
    protected $guarded = [];
}
