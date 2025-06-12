<?php
class ContatoController {
    public function index() {
        global $pdo;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo->prepare('INSERT INTO contatos(nome,email,assunto,mensagem) VALUES(?,?,?,?)')
                ->execute([$_POST['nome'], $_POST['email'], $_POST['assunto'], $_POST['mensagem']]);
            $message = 'Obrigado pelo contato!';
        }

        require 'views/partials/header.php';
        require 'views/contato/index.php';
        require 'views/partials/footer.php';
    }
}
