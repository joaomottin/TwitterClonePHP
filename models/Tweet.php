<?php

require_once __DIR__ . "/../config/db.php";

class Tweet {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll(){
        $stmt = $this->db->query("SELECT * FROM Tweets ORDER BY created_at DESC");

        return $stmt->fetchAll();
    }

    // Outros métodos serão acrescentados conforme a necessidade
}

