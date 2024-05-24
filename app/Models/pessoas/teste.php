<?php

namespace App\Models\pessoas;

use App\Models\veiculos\Veiculo;
use App\Models\veiculos\Cavalo;
use App\Models\documentos\Crlv;
use App\Models\util\Endereco;
use App\Models\util\ContaBancaria;

require_once('../veiculos/Veiculo.php');
require_once('../veiculos/Cavalo.php');
require_once('../documentos/Crlv.php');
require_once('../util/Endereco.php');
require_once('../util/ContaBancaria.php');


$veiculo = new Veiculo;
$cavalo = new Cavalo;
$crlv = new Crlv;
$endereco = new Endereco;
$conta_bancaria = new ContaBancaria;

$conta_bancaria->setAgencia(10076);
$conta_bancaria->setPix('Email1');
$conta_bancaria->setCodBanco(123);
$conta_bancaria->setTipoConta('CC');
$conta_bancaria->setNumeroContaBancaria(4564546);

$cavalo->setContaBancaria($conta_bancaria);






$endereco->setCidade('Capinzal');
$endereco->setUf('SC');

$crlv->setEndereco($endereco);
$crlv->setAnoModelo(2020);
$crlv->setAnoFabricacao(2020);
$crlv->setEmissaoCrlv('2022-05-01');
$crlv->setCor('Azul');
$crlv->setRenavam('12312123123');


$veiculo->setPlaca('AUP5B41');
$cavalo->setGrupo('Capinzal');
$cavalo->setRntrc(789456);
$cavalo->setCnpjTransportador(85393783000416);
$cavalo->setIdadeCavalo($crlv->ano_fabricacao);


$veiculo->setCrlv($crlv);



$cavalo->setCrlv($crlv);

var_dump($cavalo);







/*
$pessoa = new Pessoa;

$motorista = new Motorista;

$docIdentidade  = new DocIdentidade();
$docIdentidade->setCpf('10956265901');
$docIdentidade->setDataNascimento('2000-07-08');
$docIdentidade->setNumeroRg('7.114.089');
$docIdentidade->setDataExpedicao('2005-08-12');
$docIdentidade->setOrgaoEmissor('SSPSC');
$docIdentidade->setNomePai('Laercio Fernandes');
$docIdentidade->setNomeMae('Ivane do Amaral Fernandes');
$docIdentidade->setMunicioNascimento('Florianópolis');
$docIdentidade->setuFNascimento('SC');

$motorista->setIdentidade($docIdentidade);



$cnh = new Cnh;
$cnh->setRegistroCnh('12312313');
$cnh->setMunicipioCnh('Itajaí');
$cnh->setUfCnh('SC');

$motorista->setCnh($cnh);


$endereco = new Endereco;
$endereco->setRua('Francisco Petrônio');
$endereco->setNumero(38);
$endereco->setBairro('Hugo de Almeida');
$endereco->setCidade('Navegantes');
$endereco->setUf('SC');
$endereco->setCep('88316300');
$endereco->setComplemento('Casa verde à direita');
$motorista->setEndereco($endereco);

$contato = new Contato;
$contato->setTelefone1('47996398033');
$contato->setEmail1('monitoramento@cotramol.com.br');

$motorista->setContato($contato);

$motorista->setIdade();

var_dump($motorista);
*/