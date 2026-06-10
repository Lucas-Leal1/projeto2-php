<?php
require_once 'AcoesCombatente.php';

abstract class Personagem implements AcoesCombatente {
    // Constantes de Classe conforme solicitado
    const MIN_DANO = 0;
    const RECUPERACAO_ENERGIA_TURNO = 5;

    protected string $nome;
    protected string $tipo;
    protected int $vidaMax;
    protected int $vida;
    protected int $ataqueBase;
    protected int $defesaBase;
    protected int $energiaMax;
    protected int $energia;
    protected int $defesaBonusModificador = 0;

    public function __construct(string $nome, string $tipo, int $vidaMax, int $ataqueBase, int $defesaBase, int $energiaMax) {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->vidaMax = $vidaMax;
        $this->vida = $vidaMax;
        $this->ataqueBase = $ataqueBase;
        $this->defesaBase = $defesaBase;
        $this->energiaMax = $energiaMax;
        $this->energia = $energiaMax;
    }

    // Getters e Setters para encapsulamento seguro
    public function getNome(): string { return $this->nome; }
    public function getTipo(): string { return $this->tipo; }
    public function getVida(): int { return $this->vida; }
    public function getVidaMax(): int { return $this->vidaMax; }
    public function getEnergia(): int { return $this->energia; }

    public function estaVivo(): bool {
        return $this->vida > 0;
    }

    public function prepararNovoTurno(): void {
        // Remove bônus de defesa temporário do turno anterior
        $this->defesaBonusModificador = 0;
        // Regeneração parcial de energia por turno
        $this->energia = min($this->energiaMax, $this->energia + self::RECUPERACAO_ENERGIA_TURNO);
    }

    public function receberDano(int $danoBruto): int {
        $defesaTotal = $this->defesaBase + $this->defesaBonusModificador;
        $danoFinal = $danoBruto - $defesaTotal;

        if ($danoFinal < self::MIN_DANO) {
            $danoFinal = self::MIN_DANO;
        }

        $this->vida -= $danoFinal;
        if ($this->vida < 0) {
            $this->vida = 0;
        }

        return $danoFinal;
    }

    public function atacar(Personagem $oponente): string {
        $danoCausado = $oponente->receberDano($this->ataqueBase);
        return "{$this->nome} ({$this->tipo}) atacou {$oponente->getNome()} causando {$danoCausado} de dano! {$oponente->getNome()} agora tem {$oponente->getVida()} HP.";
    }

    public function defender(): string {
        // Aplica o bônus temporário de defesa (dobra a defesa base para o próximo turno do oponente)
        $this->defesaBonusModificador = $this->defesaBase;
        return "{$this->nome} ({$this->tipo}) assumiu uma postura defensiva, aumentando sua defesa temporariamente!";
    }

    // Método abstrato que força os filhos a implementarem habilidades únicas
    abstract public function usarHabilidadeEspecial(Personagem $oponente): string;

    // Função auxiliar para gerar a barra de vida visual (Desafio extra incluso!)
    public function obterBarraVida(): string {
        $tamanhoBarra = 15;
        $proporcao = $this->vidaMax > 0 ? ($this->vida / $this->vidaMax) : 0;
        $preenchido = (int)round($proporcao * $tamanhoBarra);
        $vazio = $tamanhoBarra - $preenchido;

        return "[" . str_repeat("#", $preenchido) . str_repeat("-", $vazio) . "] ({$this->vida}/{$this->vidaMax})";
    }
}
?>