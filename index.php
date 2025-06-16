<?php
require 'config/db.php';
require 'csrf/CsrfHelper.php';
require 'controllers/AuthController.php';
require 'controllers/TweetController.php';
require 'controllers/PerfilController.php';
require 'controllers/ContatoController.php';
require 'controllers/ComentarioController.php';
require 'controllers/LikeController.php';

session_start();

$url = $_GET['url'] ?? 'login';

$auth = new AuthController();
$tweet = new TweetController();
$perfil = new PerfilController();
$contato = new ContatoController();
$comentario = new ComentarioController();
$like = new LikeController();

switch (true) {
    case $url === 'login':
        $auth->login();
        break;

    case $url === 'register':
        $auth->register();
        break;

    case $url === 'recover':
        $auth->recover();
        break;

    case $url === 'contato':
        $contato->index();
        break;

    case $url === 'logout':
        session_destroy();
        header('Location: ?url=login');
        exit;

    default:
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }

        switch (true) {
            case $url === 'home':
                $tweet->timeline();
                break;

            case $url === 'perfil':
                $perfil->index();
                break;

            case $url === 'perfil/atualizar':
                $perfil->atualizar();
                break;

            case $url === 'perfil/excluir':
                $perfil->excluir();
                break;

            case preg_match("#^tweet/(\d+)$#", $url, $m):
                $tweet->viewTweet($m[1]);
                break;

            case preg_match("#^tweet/editar/(\d+)$#", $url, $m):
                $tweet->editar($m[1]);
                break;

            case preg_match("#^tweet/atualizar/(\d+)$#", $url, $m):
                $tweet->atualizar($m[1]);
                break;

            case preg_match("#^tweet/excluir/(\d+)$#", $url, $m):
                $tweet->excluir($m[1]);
                break;

            case preg_match("#^like/toggle/(\d+)$#", $url, $m):
                $like->toggleLike($m[1]);
                break;

            case preg_match("#^comentario/editar/(\d+)$#", $url, $m):
                $comentario->editar($m[1]);
                break;

            case preg_match("#^comentario/atualizar/(\d+)$#", $url, $m):
                $comentario->atualizar($m[1]);
                break;

            case preg_match("#^comentario/excluir/(\d+)$#", $url, $m):
                $comentario->excluir($m[1]);
                break;

            default:
                $auth->login();
                break;
        }
        break;
}