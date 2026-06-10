<?php
interface AcoesCombatente {
    public function atacar(Personagem $oponente): string;
    public function defender(): string;
    public function usarHabilidadeEspecial(Personagem $oponente): string;
}
?>