<?php

class ModelPerson {

        // Construtor para garantir que a tabela seja criada ao instanciar a classe
        public function __construct($registry) {
            parent::__construct($registry);
            
            // Verifica e cria a tabela se não existir
            $this->createTable();
        }
    
        // Função para criar a tabela se não existir
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
    
    public function createPerson($data){
        $query = $this->db->query("INSERT INTO people_db SET person_name = '" . $data['name'] ."', person_phone = '" . $data['phone'] ."', person_email = '" . $data['email'] ."', date_added = NOW()");
    }
    public function readPersons(){
        $query = $this->db->query("SELECT * FROM people_db  ");
        return $query->rows;
    }

    public function updatePerson($data){
        $query = $this->db->query("UPDATE people_db SET person_name = '" . $data['name'] ."', person_phone = '" . $data['phone'] ."', person_email = '" . $data['email'] ."', WHERE  person_id = '" . $data['id'] . "' ");
    }
    public function deletePerson($data){
        $query = $this->db->query("DELETE FROM  people_db WHERE person_id = '" . $data['id'] . "' ");
    }

}