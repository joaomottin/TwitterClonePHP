<?php
abstract class Conexao {
    private static $pdo;

    public static function getConexao() {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO("mysql:host=localhost;port=3306;dbname=Twitterclone;charset=utf8", "root", "");
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>