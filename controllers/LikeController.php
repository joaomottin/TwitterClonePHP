<?php

require_once __DIR__ . '/../models/Like.php';

class LikeController {
    public function toggleLike($tweetId) {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=tweet/' . $tweetId);
            exit;
        }

        if (!isset($_POST['csrf_token']) || !CsrfHelper::validateToken($_POST['csrf_token'])) {
            die('Erro: Token CSRF inválido.');
        }

        $db = Conexao::getConexao();
        $userId = $_SESSION['user_id'];
        $like = new Like($db);

        if ($like->exists($tweetId, $userId)) {
            $like->delete($tweetId, $userId);
        } else {
            $like->create($tweetId, $userId);
        }

        header('Location: ?url=tweet/' . $tweetId);
        exit;
    }
}
