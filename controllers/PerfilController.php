<?php
class PerfilController {
    public function index() {
        global $pdo;
        $stmt=$pdo->prepare('SELECT texto, criado_em FROM tweets WHERE user_id=? ORDER BY id DESC');
        $stmt->execute([$_SESSION['user_id']]);
        $meustweets=$stmt->fetchAll(PDO::FETCH_ASSOC);
        require 'views/partials/header.php';
        require 'views/perfil/index.php';
        require 'views/partials/footer.php';
    }
}
