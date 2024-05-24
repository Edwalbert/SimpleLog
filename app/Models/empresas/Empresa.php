<?php

namespace App\Models\empresas;

class Empresa
{
    protected $cartao_cnpj;
    protected $contato;

    public function getCartaoCnpj()
    {
        return $this->cartao_cnpj;
    }

    public function getContato()
    {
        return $this->contato;
    }


    public function setCartaoCnpj($cartao_cnpj)
    {
        $this->cartao_cnpj = $cartao_cnpj;
    }

    public function setContato($contato)
    {
        $this->cartao_cnpj = $contato;
    }
}
