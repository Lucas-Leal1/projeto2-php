
# Arena de Combate RPG - Jogo de Terminal em PHP

Este é um protótipo de um jogo de combate por turnos que corre inteiramente no terminal. O jogo simula uma arena onde dois combatentes humanos se enfrentam num duelo 1 contra 1 no mesmo computador, revezando as suas ações a cada turno.

O projeto foi desenvolvido aplicando os pilares da Programação Orientada a Objetos (POO): **encapsulamento**, **herança**, **polimorfismo** e **abstração**, além do uso de interfaces, classes abstratas, tratamento de exceções e divisão de código em múltiplos arquivos.

---

## 🚀 Como Executar o Jogo

1. Certifique-se de que tem o **PHP** instalado na sua máquina.
2. Guarde todos os arquivos do projeto na mesma pasta com a seguinte estrutura:
   ```text
   ├── PersonagemException.php
   ├── AcoesCombatente.php
   ├── Personagem.php
   ├── Guerreiro.php
   ├── Mago.php
   └── jogo.php
Abra o terminal (Prompt de Comando, PowerShell ou Bash) e navegue até à pasta onde guardou os arquivos.

Execute o seguinte comando para iniciar o jogo:

Bash
php jogo.php
👥 Tipos de Personagens Disponíveis
O jogo disponibiliza duas classes distintas de personagens estrategicamente balanceadas, cada uma com atributos iniciais diferentes e uma habilidade especial única:

1. Guerreiro
Perfil: Uma classe mais defensiva e resiliente (alta durabilidade).

Atributos Iniciais:

Pontos de Vida (HP): 120 (Máximo)

Poder de Ataque: 20

Defesa: 8

Energia (Mana): 30 (Máximo)

Habilidade Especial: [Determinação Cósmica]

O que faz: Consome 15 de energia para curar e recuperar 30 pontos de vida do próprio Guerreiro (limitado ao valor máximo inicial de 120 HP). É ideal para prolongar o combate e frustrar os ataques do adversário.

2. Mago
Perfil: Uma classe puramente ofensiva no estilo "Glass Cannon" (alto dano, mas pouca vida e defesa).

Atributos Iniciais:

Pontos de Vida (HP): 80 (Máximo)

Poder de Ataque: 28

Defesa: 4

Energia (Mana): 50 (Máximo)

Habilidade Especial: [Explosão Arcana]

O que faz: Consome 20 de energia para conjurar um feitiço devastador no oponente, causando um dano bruto de 50 (reduzido apenas pela defesa do adversário). É uma habilidade de finalização rápida.

⚔️ Mecânicas de Jogo e Turnos
A cada turno, o jogador da vez pode escolher exatamente uma de três ações:

Atacar: Realiza um ataque direto baseado no ataque base. O dano final subtraído da vida do oponente nunca será negativo.

Defender: Entra em postura defensiva, dobrando temporariamente a sua defesa base até ao próximo turno para mitigar o dano de um golpe forte previsível.

Usar Habilidade Especial: Executa o poder único de classe se tiver energia suficiente. Caso contrário, o sistema exibe uma mensagem clara de erro através de exceções personalizadas (PersonagemException) e permite escolher outra ação no mesmo turno.

Regeneração de Energia: A cada novo turno, o personagem recupera parcialmente 5 pontos de energia.

🏆 Condição de Vitória
A partida termina imediatamente quando os pontos de vida de um dos personagens chegam a zero ou menos. O sistema limpa o terminal e exibe um resumo detalhado contendo o nome do vencedor, a quantidade total de turnos que a partida durou e os pontos de vida restantes do campeão.# projeto2-php
