<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            throw new \DomainException('Usuário não pode propor dois lances consecutivos');
        }

        $totalLancesUsuario = $this->getQtdLancesUsuario($lance);
        if ($totalLancesUsuario >= 5) {
            throw new \DomainException('Usuário não pode propor mais de cinco lances');
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    private function ehDoUltimoUsuario(Lance $lance) : bool
    {
        $ultimoLance = $this->lances[count($this->lances) - 1];

        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }

    private function getQtdLancesUsuario(Lance $lance) : int
    {
        $usuario = $lance->getUsuario();
        $totalLancesUsuario = array_reduce(
            $this->lances, 
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUsuario() == $usuario) {
                    return $totalAcumulado + 1;
                }

                return $totalAcumulado;
            },
            0
        );

        return $totalLancesUsuario;
    }
}
