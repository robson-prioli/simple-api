<?php

class Usuario {
    private $id;
    private $nome;

    function __construct($id, $nome) {
        $this->id = $id;
        $this->setNome($nome);
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        if (strlen($nome) < 3) {
            throw new InvalidArgumentException('O nome deve ter pelo menos 3 caracteres.', 400);
        }
        $this->nome = $nome;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
        ];
    }
}