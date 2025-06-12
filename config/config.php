<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=Twitterclone;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro de conexão: ".$e->getMessage());
}
