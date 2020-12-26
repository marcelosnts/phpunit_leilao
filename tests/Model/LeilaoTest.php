<?php

namespace Alura\Leilao\Tests\Model;

use PHPUnit\Framework\TestCase;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Lance;

class LeilaoTest extends TestCase
{
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(int $qtdLances, Leilao $leilao, array $valores)
    {
        self::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $key => $valorEsperado) {
            self::assertEquals($valorEsperado, $leilao->getLances()[$key]->getValor());
        }
    }

    public function geraLances()
    {
        $joao = new Usuario('Joao');
        $maria = new Usuario('Maria');

        $leilaoComDoisLances = new Leilao('Fiat 147 0KM');
        $leilaoComDoisLances->recebeLance(new Lance($joao, 1000));
        $leilaoComDoisLances->recebeLance(new Lance($maria, 2000));

        $leilaoComUmLance = new Leilao('Fusca 1972 0KM');
        $leilaoComUmLance->recebeLance(new Lance($maria, 5000));

        return [
            'dois-lances' => [2, $leilaoComDoisLances, [1000, 2000]],
            'um-lance' => [1, $leilaoComUmLance, [5000]]
        ];
    }
}