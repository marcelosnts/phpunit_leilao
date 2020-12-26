<?php

namespace Alura\Leilao\Tests\Model;

use PHPUnit\Framework\TestCase;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Lance;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        self::expectException(\DomainException::class);
        self::expectExceptionMessage('Usuário não pode propor dois lances consecutivos');

        $leilao = new Leilao('Variante');
     
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 1500));
    }

    public function testLeilaoNaoDeveAceitarMaisDeCincoLancesPorUsuario()
    {
        self::expectException(\DomainException::class);
        self::expectExceptionMessage('Usuário não pode propor mais de cinco lances');

        $leilao = new Leilao('Brasília amarela');

        $joao = new Usuario('Joao');
        $maria = new Usuario('Maria');

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 3000));
        $leilao->recebeLance(new Lance($maria, 3500));
        $leilao->recebeLance(new Lance($joao, 4000));
        $leilao->recebeLance(new Lance($maria, 4500));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($maria, 5500));
        
        $leilao->recebeLance(new Lance($joao, 6000));
    }

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