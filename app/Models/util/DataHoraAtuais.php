<?php

namespace App\Models\util;

class DataHoraAtuais
{
    public $data;
    public $hora;

    public function __construct()
    {
        $this->data = date('Y-m-d');
        $this->hora = date('H:i:s');
    }

    public function getData()
    {
        return $this->data;
    }

    public function getHora()
    {
        return $this->hora;
    }
}
