<?php

namespace Alura\Leilao\Tests\Service;

use PHPUnit\Framework\TestCase;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Service\Avaliador;

class AvaliadorTest extends TestCase
{  

    public function testeUm()
    {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $maiorValor = $leiloeiro->getMaiorValor();

        $this->assertEquals(2500, $maiorValor);
    }
}