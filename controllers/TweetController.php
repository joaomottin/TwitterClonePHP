<?php
class TweetController {

    public function timeline() {
        global $pdo;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['texto'])) {
            $stmt = $pdo->prepare('INSERT INTO tweets(user_id, texto) VALUES (?, ?)');
            $stmt->execute([$_SESSION['user_id'], $_POST['texto']]);
            header('Location:?url=home');
            exit;
        }

        $stmt = $pdo->query('
            SELECT t.id, t.texto, u.nome, t.criado_em 
            FROM tweets t 
            JOIN users u ON u.id = t.user_id 
            ORDER BY t.id DESC
        ');
        $tweets = $stmt->fetchAll();

        require 'views/partials/header.php';
        require 'views/timeline.php';
        require 'views/partials/footer.php';
    }

    public function viewTweet($id) {
        global $pdo;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comentario'])) {
            $stmt = $pdo->prepare('INSERT INTO comentarios(tweet_id, user_id, texto) VALUES (?, ?, ?)');
            $stmt->execute([$id, $_SESSION['user_id'], $_POST['comentario']]);
            header('Location:?url=tweet/' . $id);
            exit;
        }

        $stmt = $pdo->prepare('
            SELECT t.texto, u.nome, t.criado_em 
            FROM tweets t 
            JOIN users u ON u.id = t.user_id 
            WHERE t.id = ?
        ');
        $stmt->execute([$id]);
        $tweet = $stmt->fetch();

        $stmt = $pdo->prepare('
            SELECT c.texto, u.nome, c.criado_em 
            FROM comentarios c 
            JOIN users u ON u.id = c.user_id 
            WHERE c.tweet_id = ? 
            ORDER BY c.id
        ');
        $stmt->execute([$id]);
        $comentarios = $stmt->fetchAll();

        require 'views/partials/header.php';
        require 'views/tweet.php';
        require 'views/partials/footer.php';
    }
}
