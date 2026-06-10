<?php
class PersonagemException extends Exception {
    public function __construct($message = "Erro no jogo", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
?>