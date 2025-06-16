<?php

require_once __DIR__ . '/../config/db.php';

class ContatoController {

    public function index() {
        $pdo = Conexao::getConexao();
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $pdo->prepare('INSERT INTO contatos(nome,email,assunto,mensagem) VALUES(?,?,?,?)');
            $stmt->execute([$_POST['nome'], $_POST['email'], $_POST['assunto'], $_POST['mensagem']]);
            $message = 'Obrigado pelo contato!';
        }

        require 'views/partials/header.php';
        require 'views/contato/index.php';
        require 'views/partials/footer.php';
    }
}
