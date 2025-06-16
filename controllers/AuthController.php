<?php

require_once __DIR__ . "/../config/db.php";

class AuthController {
    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }
                $pdo = Conexao::getConexao();

                $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
                $email = $_POST['email'] ?? null;
                    if (!$email) {
                        $error = '';
                    } else {
                        $stmt->execute([$email]);
                                    $u = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($u && password_verify($_POST['senha'], $u['senha'])) {
                    $_SESSION['user_id'] = $u['id'];
                    $_SESSION['user_nome'] = $u['nome'];
                    header('Location:?url=home'); 
                    exit;
                } else {
                    $error = 'Credenciais inválidas';
                }
            }
        }
        require 'views/partials/header.php';
        require 'views/login.php';
        require 'views/partials/footer.php';
    }

    public function register()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $pdo = Conexao::getConexao();

            $hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (nome, email, cpf, data_nascimento, senha) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                $_POST['nome'], 
                $_POST['email'], 
                $_POST['cpf'], 
                $_POST['data_nascimento'], 
                $hash
            ]);
            header('Location:?url=login'); 
            exit;
        }
        require 'views/partials/header.php';
        require 'views/register.php';
        require 'views/partials/footer.php';
    }

    public function recover()
    {
        $error = '';
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateToken($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $pdo = Conexao::getConexao();

            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND cpf = ? AND data_nascimento = ? LIMIT 1');
            $stmt->execute([
                $_POST['email'], 
                $_POST['cpf'], 
                $_POST['data_nascimento']
            ]);
            $u = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($u) {
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

