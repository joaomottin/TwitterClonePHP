<?php

require_once __DIR__ . '/../models/Comentario.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../csrf/CsrfHelper.php';

class ComentarioController {

    private function precisaLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }
    }

    public function editar($id) {
        session_start();
        $this->precisaLogin();

        $comentarioModel = new Comentario(Conexao::getConexao());
        $comentario = $comentarioModel->findByIdAndUser($id, $_SESSION['user_id']);

        if (!$comentario) {
            header('Location: ?url=home');
            exit;
        }

        require 'views/partials/header.php';
        require 'views/comentario_editar.php';
        require 'views/partials/footer.php';
    }

    public function atualizar($id) {
        session_start();
        $this->precisaLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=home');
            exit;
        }

        if (!isset($_POST['csrf_token']) || !CsrfHelper::validateToken($_POST['csrf_token'])) {
            die('Invalid CSRF Token');
        }

        $comentarioModel = new Comentario(Conexao::getConexao());
        $rowCount = $comentarioModel->update($id, $_SESSION['user_id'], $_POST['texto']);

        if ($rowCount === 0) {
            echo "Você não tem permissão para atualizar este comentário.";
            exit;
        }

        header('Location: ?url=home');
        exit;
    }

    public function excluir($id) {
        session_start();
        $this->precisaLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=home');
            exit;
        }

        if (!isset($_POST['csrf_token']) || !CsrfHelper::validateToken($_POST['csrf_token'])) {
            die('Invalid CSRF Token');
        }

        $comentarioModel = new Comentario(Conexao::getConexao());
        $rowCount = $comentarioModel->delete($id, $_SESSION['user_id']);

        if ($rowCount === 0) {
            echo "Você não tem permissão para excluir este comentário.";
            exit;
        }

        header('Location: ?url=home');
        exit;
    }
}
