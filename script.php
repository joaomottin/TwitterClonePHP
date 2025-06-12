<?php
$dsn = "mysql:host=localhost;port=3306;charset=utf8";
$user = "root"; $pass = "";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS Twitterclone CHARACTER SET utf8 COLLATE utf8_general_ci");
    $pdo->exec("USE Twitterclone");
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        cpf VARCHAR(14) NOT NULL,
        data_nascimento DATE NOT NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS tweets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        texto TEXT NOT NULL,
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS comentarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tweet_id INT NOT NULL,
        user_id INT NOT NULL,
        texto TEXT NOT NULL,
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (tweet_id) REFERENCES tweets(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS contatos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        assunto VARCHAR(100) NOT NULL,
        mensagem TEXT NOT NULL,
        data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    $hash = password_hash('123456', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (nome,email,senha,cpf,data_nascimento) VALUES
        ('João Pedro','joao@example.com','$hash','123.456.789-00','2000-01-01')");
    $userId = $pdo->query("SELECT id FROM users WHERE email='joao@example.com'")->fetchColumn();
    $pdo->exec("INSERT IGNORE INTO tweets (user_id,texto) VALUES ($userId,'Primeiro tweet!')");
    echo 'Configuração completa!';
} catch(PDOException $e) {
    die('Erro: '.$e->getMessage());
}
