<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../csrf/CsrfHelper.php';

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

        $stmt = $db->prepare('SELECT * FROM likes WHERE tweet_id = ? AND user_id = ?');
        $stmt->execute([$tweetId, $userId]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $db->prepare('DELETE FROM likes WHERE tweet_id = ? AND user_id = ?');
            $stmt->execute([$tweetId, $userId]);
        } else {
            $stmt = $db->prepare('INSERT INTO likes (tweet_id, user_id) VALUES (?, ?)');
            $stmt->execute([$tweetId, $userId]);
        }

        header('Location: ?url=tweet/' . $tweetId);
        exit;
    }
}
