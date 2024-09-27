<?php
require_once('../model/person.php');
require_once('../config.php');
class ControllerAddPerson {
    private $model_person;
    private $error = array();
    public function __construct($pdo) {
        $this->model_person = new ModelPerson($pdo);
    }
    public function index() {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postData = json_decode(file_get_contents('php://input'), true);
            $data = $this->model_person->createPerson($postData);
            
			$data['request'] = $postData;
			$data['success'] = 'Cadastro realizado com sucesso.';
	
		}

		$data['error'] = false;
		if (count($this->error) > 0) {
			$data['error'] = $this->error;
		}

        
    
        header('Content-Type: application/json');
        echo json_encode($data);
    }


}

// Verifique se o arquivo é chamado corretamente
$controller = new ControllerAddPerson($pdo);
$controller->index(); // Chama o método index
