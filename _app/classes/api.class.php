<?php

class Api {
    private $usuarios;

    function __construct() {

        $this->usuarios = [
            1 => new Usuario(1, 'João da Silva'),
            2 => new Usuario(2, 'Maria Oliveira'),
        ];
  
    }

    public function handleRequest() {
        try {
            switch ($_SERVER['REQUEST_METHOD']):
                case 'GET':
                    $this->handleGet();
                break;
                case 'POST':
                    $this->handlePost();
                    break;
                case 'PUT':
                    $this->handlePut();
                    break;
                case 'DELETE':
                    $this->handleDelete();
                break;
                default:
                    throw new InvalidArgumentException('Método não permitido');
                break;
            endswitch;
        } catch (InvalidArgumentException $e) {
            Response::error($e);
        }
    }

    private function handleGet() {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if ($id !== null && isset($this->usuarios[$id])) {
            Response::success([$id => $this->usuarios[$id]->toArray()]);
        } elseif ($id === null) {
            $usuariosArray = [];
            foreach ($this->usuarios as $usuario) {
                $usuariosArray[$usuario->getId()] = $usuario->toArray();
            }
            Response::success($usuariosArray);
        } else {
            throw new InvalidArgumentException('Usuário não encontrado');
        }
    }

    private function handlePost() {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!isset($dados['nome'])) {
            throw new InvalidArgumentException('Nome não fornecido');
        }

        try {
            $novoId = max(array_keys($this->usuarios)) + 1;
            $novoUsuario = new Usuario($novoId, $dados['nome']);
            $this->usuarios[$novoId] = $novoUsuario;

            $usuariosArray = [];
            foreach ($this->usuarios as $usuario) {
                $usuariosArray[$usuario->getId()] = $usuario->toArray();
            }

            Response::success('Usúario inserido com sucesso!', $usuariosArray);
        } catch (InvalidArgumentException $e) {
            Response::error($e);
        }
    }

    private function handlePut(){ 
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        if (isset($this->usuarios[$id])) {
            $this->usuarios[$id] = ['nome' => $dados['nome']];
            Response::success('Usuário atualizado com sucesso', null);
        } else {
            throw new InvalidArgumentException('Usuário não encontrado.');
        }
    }

    private function handleDelete(){
        $id = $_GET['id'];
        if (isset($this->usuarios[$id])) {
            unset($this->usuarios[$id]);
            Response::success('Usuário excluído com sucesso.', null);
        } else {
            throw new InvalidArgumentException('Usuário não encontrado.');
        }
    }
}