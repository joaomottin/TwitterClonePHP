<?php
$dsn = "mysql:host=localhost;port=3306;charset=utf8";
$user = "root"; $pass = "";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar o banco
    $pdo->exec("CREATE DATABASE IF NOT EXISTS Twitterclone CHARACTER SET utf8 COLLATE utf8_general_ci");
    $pdo->exec("USE Twitterclone");

    // Criar tabelas
    $pdo->exec("DROP TABLE IF EXISTS likes, comentarios, tweets, contatos, users");

    $pdo->exec("CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        cpf VARCHAR(14) NOT NULL,
        data_nascimento DATE NOT NULL
    )");

    $pdo->exec("CREATE TABLE tweets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        texto TEXT NOT NULL,
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX (user_id)
    )");

    $pdo->exec("CREATE TABLE comentarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tweet_id INT NOT NULL,
        user_id INT NOT NULL,
        texto TEXT NOT NULL,
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX (tweet_id),
        INDEX (user_id)
    )");

    $pdo->exec("CREATE TABLE likes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tweet_id INT NOT NULL,
        user_id INT NOT NULL,
        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_like (tweet_id, user_id),
        INDEX (tweet_id),
        INDEX (user_id)
    )");

    $pdo->exec("CREATE TABLE contatos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        assunto VARCHAR(100) NOT NULL,
        mensagem TEXT NOT NULL,
        data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Inserir dados
    $senha1 = password_hash('123456', PASSWORD_DEFAULT);
    $senha2 = password_hash('654321', PASSWORD_DEFAULT);

    $pdo->exec("INSERT INTO users (id, nome, email, senha, cpf, data_nascimento) VALUES
        (1, 'João Pedro', 'joao@gmail.com', '$senha1', '123.456.789-00', '2000-01-01'),
        (2, 'Kauan Lima Ferreira', 'kauanlima@gmail.com', '$senha2', '097.249.133-39', '2006-07-31')
    ");

    $pdo->exec("INSERT INTO tweets (id, user_id, texto) VALUES
        (1, 1, 'Primeiro tweet!'),
        (2, 1, 'Salve!'),
        (3, 2, 'Olá, que tal nos followarmos?')
    ");

    $pdo->exec("INSERT INTO comentarios (id, tweet_id, user_id, texto) VALUES
        (1, 2, 2, 'Olá!!'),
        (2, 2, 1, 'Pois é!')
    ");

    $pdo->exec("INSERT INTO likes (id, tweet_id, user_id) VALUES
        (1, 1, 2),
        (2, 2, 1),
        (3, 3, 1)
    ");

    $pdo->exec("INSERT INTO contatos (id, nome, email, assunto, mensagem) VALUES
        (1, 'Kauan Lima', 'kauanlima@gmail.com', 'Teste!', 'Testando V1')
    ");

    // Adicionar chaves estrangeiras
    $pdo->exec("ALTER TABLE tweets
        ADD CONSTRAINT tweets_ibfk_1 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ");

    $pdo->exec("ALTER TABLE comentarios
        ADD CONSTRAINT comentarios_ibfk_1 FOREIGN KEY (tweet_id) REFERENCES tweets(id) ON DELETE CASCADE,
        ADD CONSTRAINT comentarios_ibfk_2 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ");

    $pdo->exec("ALTER TABLE likes
        ADD CONSTRAINT likes_ibfk_1 FOREIGN KEY (tweet_id) REFERENCES tweets(id) ON DELETE CASCADE,
        ADD CONSTRAINT likes_ibfk_2 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ");

    echo "Banco de dados e tabelas criados com sucesso!";
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>
