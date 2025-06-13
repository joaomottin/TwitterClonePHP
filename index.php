<?php
require 'config/config.php';
require 'controllers/AuthController.php';
require 'controllers/TweetController.php';
require 'controllers/PerfilController.php';
require 'controllers/ContatoController.php';

session_start();

$url = $_GET['url'] ?? 'login';

switch (true) {
    case $url === 'login':
        (new AuthController())->login();
        break;

    case $url === 'register':
        (new AuthController())->register();
        break;

    case $url === 'recover':
        (new AuthController())->recover();
        break;

    case $url === 'logout':
        session_destroy();
        header('Location: ?url=login');
        exit;

    case $url === 'home':
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }
        (new TweetController())->timeline();
        break;

    case $url === 'perfil':
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }
        (new PerfilController())->index();
        break;

    case $url === 'contato':
        (new ContatoController())->index();
        break;

    case preg_match('#^tweet/(\d+)$#', $url, $m) === 1:
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }
        (new TweetController())->viewTweet($m[1]);
        break;

    case preg_match('#^tweet/editar/(\d+)$#', $url, $m) === 1:
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }
        (new TweetController())->editar($m[1]);
        break;

    case preg_match('#^tweet/atualizar/(\d+)$#', $url, $m) === 1:
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }
        (new TweetController())->atualizar($m[1]);
        break;

    case preg_match('#^tweet/excluir/(\d+)$#', $url, $m) === 1:
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }
        (new TweetController())->excluir($m[1]);
        break;

    default:
        echo '404 Página não encontrada';
}
