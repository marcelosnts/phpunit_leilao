<?php

require 'vendor/autoload.php';

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Service\Avaliador;

$leilao = new Leilao('Fiat 147 0KM');

$maria = new Usuario('Maria');
$joao = new Usuario('Joao');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);
$maiorValor = $leiloeiro->getMaiorValor();

$valorEsperado = 2500;

if ($maiorValor == $valorEsperado) {
    echo "Teste ok";
} else {
    echo "Teste falhou";
}