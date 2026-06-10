<?php
require_once 'Personagem.php';
require_once 'PersonagemException.php';

class Guerreiro extends Personagem {
    const CUSTO_ENERGIA_ESPECIAL = 15;

    public function __construct(string $nome) {
        // Atributos equilibrados: alta vida, boa defesa, ataque moderado
        parent::__construct($nome, "Guerreiro", 120, 20, 8, 30);
    }

    public function usarHabilidadeEspecial(Personagem $oponente): string {
        if ($this->energia < self::CUSTO_ENERGIA_ESPECIAL) {
            throw new PersonagemException("Energia insuficiente para usar a habilidade especial! Você precisa de " . self::CUSTO_ENERGIA_ESPECIAL . " de energia.");
        }

        $this->energia -= self::CUSTO_ENERGIA_ESPECIAL;
        $cura = 30;
        $this->vida = min($this->vidaMax, $this->vida + $cura);

        return "{$this->nome} usou [Determinação Cósmica]! Recuperou {$cura} pontos de vida e agora possui {$this->vida} HP.";
    }
}
?>