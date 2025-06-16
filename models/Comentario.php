<?php
require_once __DIR__ . '/../config/db.php';

class Comentario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($tweetId, $userId, $texto) {
        $stmt = $this->db->prepare('INSERT INTO comentarios (tweet_id, user_id, texto) VALUES (?, ?, ?)');
        return $stmt->execute([$tweetId, $userId, $texto]);
    }

    public function findByTweetId($tweetId) {
        $stmt = $this->db->prepare('
            SELECT c.id, c.texto, c.user_id, c.criado_em, u.nome 
            FROM comentarios c 
            JOIN users u ON u.id = c.user_id 
            WHERE c.tweet_id = ? 
            ORDER BY c.criado_em ASC
        ');
        $stmt->execute([$tweetId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByIdAndUser($id, $userId) {
        $stmt = $this->db->prepare('SELECT * FROM comentarios WHERE id = ? AND user_id = ? LIMIT 1');
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public function update($id, $userId, $texto) {
        $stmt = $this->db->prepare('UPDATE comentarios SET texto = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$texto, $id, $userId]);
        return $stmt->rowCount();
    }

    public function delete($id, $userId) {
        $stmt = $this->db->prepare('DELETE FROM comentarios WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        return $stmt->rowCount();
    }
}
