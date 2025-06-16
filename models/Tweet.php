<?php

require_once __DIR__ . '/../config/db.php';

class Tweet {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllWithUser() {
        $stmt = $this->db->query('
            SELECT t.id, t.texto, u.nome, t.criado_em 
            FROM tweets t 
            JOIN users u ON u.id = t.user_id 
            ORDER BY t.id DESC
        ');
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare('
            SELECT t.id, t.texto, u.nome, t.criado_em,
            (SELECT COUNT(*) FROM likes WHERE tweet_id = t.id) AS likes_count
            FROM tweets t 
            JOIN users u ON u.id = t.user_id 
            WHERE t.id = ?
        ');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function create($user_id, $texto) {
        $stmt = $this->db->prepare('INSERT INTO tweets(user_id, texto) VALUES (?, ?)');
        return $stmt->execute([$user_id, $texto]);
    }

    public function update($id, $user_id, $texto) {
        $stmt = $this->db->prepare('UPDATE tweets SET texto = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$texto, $id, $user_id]);
        return $stmt->rowCount();
    }

    public function delete($id, $user_id) {
        $stmt = $this->db->prepare('DELETE FROM tweets WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $user_id]);
        return $stmt->rowCount();
    }

    public function findByIdAndUser($id, $user_id) {
        $stmt = $this->db->prepare('SELECT * FROM tweets WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $user_id]);
        return $stmt->fetch();
    }

    public function findByUserId($user_id) {
    $stmt = $this->db->prepare('SELECT texto, criado_em FROM tweets WHERE user_id = ? ORDER BY id DESC');
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function userLikedTweet($tweet_id, $user_id) {
        $stmt = $this->db->prepare('SELECT 1 FROM likes WHERE tweet_id = ? AND user_id = ? LIMIT 1');
        $stmt->execute([$tweet_id, $user_id]);
        return $stmt->fetch() !== false;
    }
}
