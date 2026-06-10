<?php
require_once 'Guerreiro.php';
require_once 'Mago.php';
require_once 'PersonagemException.php';

function limparTela() {
    // Executa a limpeza de tela sugerida
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}

function obterEntradaValida(string $mensagem, array $opcoesValidas): string {
    while (true) {
        echo $mensagem;
        $entrada = trim(fgets(STDIN));
        if (in_array($entrada, $opcoesValidas)) {
            return $entrada;
        }
        echo "Opção inválida! Tente novamente.\n";
    }
}

// ==========================================
// TELA DE SELEÇÃO DE PERSONAGENS
// ==========================================
limparTela();
echo "=============================================\n";
echo "       BEM-VINDO À ARENA DE COMBATE          \n";
echo "=============================================\n\n";

$jogadores = [];

for ($i = 1; $i <= 2; $i++) {
    echo "--- Jogador {$i} ---\n";
    echo "Digite o seu nome: ";
    $nome = trim(fgets(STDIN));
    if (empty($nome)) { $nome = "Jogador {$i}"; }

    echo "\nEscolha sua classe:\n";
    echo "1. Guerreiro (Vida: 120, Ataque: 20, Defesa: 8) - Habilidade: Cura\n";
    echo "2. Mago      (Vida: 80,  Ataque: 28, Defesa: 4) - Habilidade: Dano Massivo\n";
    
    $classeEscolhida = obterEntradaValida("Digite o número da classe: ", ["1", "2"]);

    if ($classeEscolhida === "1") {
        $jogadores[$i] = new Guerreiro($nome);
    } else {
        $jogadores[$i] = new Mago($nome);
    }
    echo "\n=> {$nome} escolheu " . $jogadores[$i]->getTipo() . "!\n\n";
}

echo "Pressione ENTER para iniciar o combate...";
fgets(STDIN);

// ==========================================
// LOOP PRINCIPAL DO COMBATE (POLIMÓRFICO)
// ==========================================
$turnoGeral = 1;
$feedbackAcao = "O combate começou! Que vença o melhor.";

while ($jogadores[1]->estaVivo() && $jogadores[2]->estaVivo()) {
    // Determina dinamicamente quem ataca e quem defende neste turno
    $idAtual = ($turnoGeral % 2 !== 0) ? 1 : 2;
    $idOponente = ($idAtual === 1) ? 2 : 3 - $idAtual;

    /** @var Personagem $atual */
    $atual = $jogadores[$idAtual];
    /** @var Personagem $oponente */
    $oponente = $jogadores[$idOponente];

    // Prepara o turno do combatente da vez (limpa bônus de defesa anterior e recupera mana)
    $atual->prepararNovoTurno();

    $turnoTerminado = false;

    while (!$turnoTerminado) {
        limparTela();
        echo "=========================================================\n";
        echo " RODADA DE COMBATE: TURNO {$turnoGeral}\n";
        echo "=========================================================\n";
        echo "VEZ DE: JOGADOR {$idAtual} - {$atual->getNome()} (As {$atual->getTipo()})\n";
        echo "---------------------------------------------------------\n";
        echo "STATUS DOS COMBATENTES:\n";
        echo "[-] {$jogadores[1]->getNome()} ({$jogadores[1]->getTipo()}): \n    Vida: " . $jogadores[1]->obterBarraVida() . " | Energia: {$jogadores[1]->getEnergia()}\n";
        echo "[-] {$jogadores[2]->getNome()} ({$jogadores[2]->getTipo()}): \n    Vida: " . $jogadores[2]->obterBarraVida() . " | Energia: {$jogadores[2]->getEnergia()}\n";
        echo "---------------------------------------------------------\n";
        echo "ÚLTIMO ACONTECIMENTO:\n> {$feedbackAcao}\n";
        echo "---------------------------------------------------------\n";
        echo "AÇÕES DISPONÍVEIS:\n";
        echo "1. Atacar\n";
        echo "2. Defender\n";
        echo "3. Usar Habilidade Especial\n";
        echo "---------------------------------------------------------\n";

        $acao = obterEntradaValida("Escolha uma ação (1-3): ", ["1", "2", "3"]);

        try {
            // Execução Polimórfica das ações
            switch ($acao) {
                case "1":
                    $feedbackAcao = $atual->atacar($oponente);
                    break;
                case "2":
                    $feedbackAcao = $atual->defender();
                    break;
                case "3":
                    $feedbackAcao = $atual->usarHabilidadeEspecial($oponente);
                    break;
            }
            $turnoTerminado = true;
        } catch (PersonagemException $e) {
            // Captura o erro personalizado de negócio e exige nova decisão sem passar o turno
            $feedbackAcao = "AVISO: " . $e->getMessage();
        }
    }

    $turnoGeral++;
    
    // Pequena pausa para os jogadores verem o desfecho da ação antes da próxima tela
    if ($oponente->estaVivo()) {
        echo "\nPressione ENTER para passar o turno...";
        fgets(STDIN);
    }
}

// ==========================================
// TELA DE VITÓRIA (RESUMO FINAL)
// ==========================================
limparTela();
$vencedor = $jogadores[1]->estaVivo() ? $jogadores[1] : $jogadores[2];
$totalTurnosPartida = $turnoGeral - 1;

echo "=========================================================\n";
echo "                     FIM DE JOGO                         \n";
echo "=========================================================\n";
echo " O grande vencedor é: {$vencedor->getNome()} ({$vencedor->getTipo()})!\n";
echo "---------------------------------------------------------\n";
echo " RESUMO DO CONFRONTO:\n";
echo " -> Duração da partida: {$totalTurnosPartida} turnos.\n";
echo " -> Pontos de vida restantes do vencedor: {$vencedor->getVida()} HP.\n";
echo "=========================================================\n";
?>