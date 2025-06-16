<?php
class PerfilController {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

    public function index() {
        $userId = $_SESSION['user_id'];

        $stmt = $this->pdo->prepare('SELECT id, nome, email FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt2 = $this->pdo->prepare('SELECT texto, criado_em FROM tweets WHERE user_id = ? ORDER BY criado_em DESC');
        $stmt2->execute([$userId]);
        $meustweets = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        require 'views/partials/header.php';
        require 'views/perfil/index.php';
        require 'views/partials/footer.php';
    }

    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=perfil');
            exit;
        }
        if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
            die('Invalid CSRF Token');
        }

        $userId = $_SESSION['user_id'];
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senhaNova = $_POST['senha'] ?? '';

        $stmt = $this->pdo->prepare('UPDATE users SET nome = ?, email = ? WHERE id = ?');
        $stmt->execute([$nome, $email, $userId]);

        if (!empty($senhaNova)) {
            $hash = password_hash($senhaNova, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare('UPDATE users SET senha = ? WHERE id = ?');
            $stmt->execute([$hash, $userId]);
        }

        header('Location: ?url=perfil');
        exit;
    }

    public function excluir() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=perfil');
            exit;
        }
        if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
            die('Invalid CSRF Token');
        }

        $userId = $_SESSION['user_id'];

        $stmt = $this->pdo->prepare('DELETE FROM tweets WHERE user_id = ?');
        $stmt->execute([$userId]);

        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$userId]);

        session_destroy();
        header('Location: ?url=login');
        exit;
    }
}
