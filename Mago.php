<?php
require_once 'Personagem.php';
require_once 'PersonagemException.php';

class Mago extends Personagem {
    const CUSTO_ENERGIA_ESPECIAL = 20;

    public function __construct(string $nome) {
        // Atributos ofensivos: menor vida, pouca defesa, alto ataque e muita energia
        parent::__construct($nome, "Mago", 80, 28, 4, 50);
    }

    public function usarHabilidadeEspecial(Personagem $oponente): string {
        if ($this->energia < self::CUSTO_ENERGIA_ESPECIAL) {
            throw new PersonagemException("Energia insuficiente para usar a habilidade especial! Você precisa de " . self::CUSTO_ENERGIA_ESPECIAL . " de energia.");
        }

        $this->energia -= self::CUSTO_ENERGIA_ESPECIAL;
        $danoBrutoEspecial = 50; 
        $danoCausado = $oponente->receberDano($danoBrutoEspecial);

        return "{$this->nome} conjurou uma [Explosão Arcana] devastadora em {$oponente->getNome()}, causando {$danoCausado} de dano! {$oponente->getNome()} resta com {$oponente->getVida()} HP.";
    }
}
?>