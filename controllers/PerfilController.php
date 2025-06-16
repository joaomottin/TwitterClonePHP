<?php
require_once __DIR__ . '/../models/Tweet.php';
require_once __DIR__ . '/../config/db.php';

class PerfilController {
    private $tweetModel;

    public function __construct() {
        $this->tweetModel = new Tweet(Conexao::getConexao());
    }

    public function index() {
        $meustweets = $this->tweetModel->findByUserId($_SESSION['user_id']);

        require 'views/partials/header.php';
        require 'views/perfil/index.php';
        require 'views/partials/footer.php';
    }
}
