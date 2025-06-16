<?php

require_once __DIR__ . "/../config/db.php";

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    // Outros métodos serão acrescentados conforme a necessidade
}

