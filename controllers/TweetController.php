<?php

require_once __DIR__ . '/../models/Tweet.php';
require_once __DIR__ . '/../models/Comentario.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../csrf/CsrfHelper.php';

class TweetController {

    public function timeline()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $tweetModel = new Tweet(Conexao::getConexao());
            $tweetModel->create($_SESSION['user_id'], $_POST['texto']);

            header('Location:?url=home'); 
            exit;
        }

        $tweetModel = new Tweet(Conexao::getConexao());
        $tweets = $tweetModel->getAllWithUser();

        require 'views/partials/header.php';
        require 'views/timeline.php';
        require 'views/partials/footer.php';
    }

    public function viewTweet($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $comentarioModel = new Comentario(Conexao::getConexao());
            $comentarioModel->create($id, $_SESSION['user_id'], $_POST['comentario']);

            header('Location:?url=tweet/' . $id);
            exit;
        }

        $tweetModel = new Tweet(Conexao::getConexao());
        $tweet = $tweetModel->findById($id);

        $comentarioModel = new Comentario(Conexao::getConexao());
        $comentarios = $comentarioModel->findByTweetId($id);

        $userLiked = $tweetModel->userLikedTweet($id, $_SESSION['user_id']);

        require 'views/partials/header.php';
        require 'views/tweet.php';
        require 'views/partials/footer.php';
    }

    public function editar($id)
    {
        $tweetModel = new Tweet(Conexao::getConexao());
        $tweet = $tweetModel->findByIdAndUser($id, $_SESSION['user_id']);

        if (!$tweet) {
            header('Location: ?url=home');
            exit;
        }

        require 'views/partials/header.php';
        require 'views/tweet_editar.php';
        require 'views/partials/footer.php';
    }

    public function atualizar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $texto = trim($_POST['texto'] ?? '');
            if ($texto === '') {
                echo "Texto não pode ser vazio.";
                exit;
            }

            $tweetModel = new Tweet(Conexao::getConexao());
            $rowCount = $tweetModel->update($id, $_SESSION['user_id'], $texto);

            if ($rowCount === 0) {
                echo "Você não tem permissão para atualizar este tweet.";
                exit;
            }
        }

        header('Location: ?url=home');
        exit;
    }

    public function excluir($id)
    {
        $tweetModel = new Tweet(Conexao::getConexao());
        $rowCount = $tweetModel->delete($id, $_SESSION['user_id']);

        if ($rowCount === 0) {
            echo "Você não tem permissão para excluir este tweet.";
            exit;
        }

        header('Location: ?url=home');
        exit;
    }
}
