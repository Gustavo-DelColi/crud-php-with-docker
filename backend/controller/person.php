<?php
require_once('../model/person.php');
require_once('../config.php');
class ControllerPerson {
    private $model_person;
    private $error = array();
    public function __construct($pdo) {
        $this->model_person = new ModelPerson($pdo); 
    }

    public function index() {
   		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $results = $this->model_person->readPersons();
            foreach ($results as $result){
                $data[] = array(
                    'id'                 => $result['person_id'],
                    'name'               => $result['person_name'],
                    'phone'              => $result['person_phone'],
                    'email'              => $result['person_email']
                );
            }
            	
		}

        header('Content-Type: application/json'); // Assegure-se que o cabeçalho está correto
        echo json_encode($data);
    }


}

// Verifique se o arquivo é chamado corretamente
$controller = new ControllerPerson($pdo);
$controller->index(); // Chama o método index
