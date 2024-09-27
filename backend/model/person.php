<?php

class ModelPerson {
    private $db; 

    public function __construct($pdo) {
        $this->db = $pdo;
        $this->createTable();
    }

    private function createTable() {
        $query = "CREATE TABLE IF NOT EXISTS people_db (
            person_id SERIAL PRIMARY KEY,
            person_name VARCHAR(255) NOT NULL,
            person_phone VARCHAR(20) NOT NULL,
            person_email VARCHAR(255) NOT NULL,
            date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->query($query);
    }

    public function createPerson($data) {
        $stmt = $this->db->query("INSERT INTO people_db (person_name, person_phone, person_email, date_added) VALUES('" . $data['name'] . "', '" . $data['phone'] . "', '" . $data['email'] . "', NOW())");

    }

    public function readPersons() {
        $stmt = $this->db->query("SELECT * FROM people_db");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Assume que você está usando PDO
    }

    public function updatePerson($data) {
        $stmt = $this->db->prepare("UPDATE people_db SET person_name = ?, person_phone = ?, person_email = ? WHERE person_id = ?");
        $stmt->execute([$data['name'], $data['phone'], $data['email'], $data['id']]);
    }

    public function deletePerson($data) {
        $stmt = $this->db->prepare("DELETE FROM people_db WHERE person_id = ?");
        $stmt->execute([$data['id']]);
    }
}
