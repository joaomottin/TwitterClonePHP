<?php

require_once __DIR__ . '/../config/db.php';

class Like {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($tweetId, $userId) {
        // Previne likes duplicados
        if ($this->exists($tweetId, $userId)) {
            return false;
        }
        $stmt = $this->db->prepare('INSERT INTO likes (tweet_id, user_id) VALUES (?, ?)');
        return $stmt->execute([$tweetId, $userId]);
    }

    public function delete($tweetId, $userId) {
        $stmt = $this->db->prepare('DELETE FROM likes WHERE tweet_id = ? AND user_id = ?');
        $stmt->execute([$tweetId, $userId]);
        return $stmt->rowCount();
    }

    public function countByTweetId($tweetId) {
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM likes WHERE tweet_id = ?');
        $stmt->execute([$tweetId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function exists($tweetId, $userId) {
        $stmt = $this->db->prepare('SELECT * FROM likes WHERE tweet_id = ? AND user_id = ? LIMIT 1');
        $stmt->execute([$tweetId, $userId]);
        return $stmt->fetch() !== false;
    }
}
