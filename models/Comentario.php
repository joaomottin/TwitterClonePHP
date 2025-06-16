<?php

require_once __DIR__ . '/../config/db.php';

class Comentario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($tweet_id, $user_id, $texto) {
        $stmt = $this->db->prepare('INSERT INTO comentarios(tweet_id, user_id, texto) VALUES (?, ?, ?)');
        return $stmt->execute([$tweet_id, $user_id, $texto]);
    }

    public function findByTweetId($tweet_id) {
        $stmt = $this->db->prepare('
            SELECT c.texto, u.nome, c.criado_em 
            FROM comentarios c 
            JOIN users u ON u.id = c.user_id 
            WHERE c.tweet_id = ? 
            ORDER BY c.id
        ');
        $stmt->execute([$tweet_id]);
        return $stmt->fetchAll();
    }
}
