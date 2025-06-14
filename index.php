<?php
require 'config/config.php';
require 'csrf/CsrfHelper.php';
require 'controllers/AuthController.php';
require 'controllers/TweetController.php';
require 'controllers/PerfilController.php';
require 'controllers/ContatoController.php';

session_start();

$url = $_GET['url'] ?? 'login';

$auth = new AuthController();
$tweet = new TweetController();
$perfil = new PerfilController();
$contato = new ContatoController();

function precisaLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ?url=login');
        exit;
    }
}

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

    case $url === 'logout':
        session_destroy();
        header('Location: ?url=login');
        exit;

    case $url === 'home':
        precisaLogin();
        $tweet->timeline();
        break;

    case $url === 'perfil':
        precisaLogin();
        $perfil->index();
        break;

    case $url === 'contato':
        $contato->index();
        break;

    case preg_match('#^tweet/(\d+)$#', $url, $m):
        precisaLogin();
        $tweet->viewTweet($m[1]);
        break;

    case preg_match('#^tweet/editar/(\d+)$#', $url, $m):
        precisaLogin();
        $tweet->editar($m[1]);
        break;

    case preg_match('#^tweet/atualizar/(\d+)$#', $url, $m):
        precisaLogin();
        $tweet->atualizar($m[1]);
        break;

    case preg_match('#^tweet/excluir/(\d+)$#', $url, $m):
        precisaLogin();
        $tweet->excluir($m[1]);
        break;

    default:
        $auth->login();
        break;
}
