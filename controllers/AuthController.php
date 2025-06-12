<?php
class AuthController {
    public function login() {
        global $pdo;
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$_POST['email']]);
            $u = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($u && password_verify($_POST['senha'], $u['senha'])) {
                $_SESSION['user_id'] = $u['id'];
                $_SESSION['user_nome'] = $u['nome'];
                header('Location:?url=home'); exit;
            }
            $error = 'Credenciais inválidas';
        }
        require 'views/partials/header.php';
        require 'views/login.php';
        require 'views/partials/footer.php';
    }

    public function register() {
        global $pdo;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (nome, email, cpf, data_nascimento, senha) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$_POST['nome'], $_POST['email'], $_POST['cpf'], $_POST['data_nascimento'], $hash]);
            header('Location:?url=login'); exit;
        }
        require 'views/partials/header.php';
        require 'views/register.php';
        require 'views/partials/footer.php';
    }

    public function recover() {
        global $pdo;
        $error = '';
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND cpf = ? AND data_nascimento = ?');
            $stmt->execute([$_POST['email'], $_POST['cpf'], $_POST['data_nascimento']]);
            if ($u = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $new = '123456'; 
                $h = password_hash($new, PASSWORD_DEFAULT);
                $pdo->prepare('UPDATE users SET senha = ? WHERE id = ?')->execute([$h, $u['id']]);
                $message = 'Nova senha: ' . $new;
            } else {
                $error = 'Dados incorretos';
            }
        }
        require 'views/partials/header.php';
        require 'views/recover.php';
        require 'views/partials/footer.php';
    }
}
