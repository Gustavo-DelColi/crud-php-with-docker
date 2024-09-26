<?php
class ControllerPerson {
    private $model_person;


    public function index() {
        $this->setHeaders(); 

        // Responda a solicitações OPTIONS
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $data = [
            'success' => [],
            'data' => [] // Array para armazenar os dados das pessoas
        ];

        // Chama o método do modelo para buscar as pessoas

        // Populando o array 'data' com os resultados
        foreach ($results as $result) {
            $data['data'][] = [
                'id'    => $result['person_id'],
                'name'  => $result['person_name'],
                'phone' => $result['person_phone'],
                'email' => $result['person_email'],
            ];  
        }

        $data['success'][] = 'Cadastro realizado com sucesso.';
        
        // Retorna a resposta em formato JSON
        header('Content-Type: application/json'); // Assegure-se que o cabeçalho está correto
        echo json_encode($data);
    }

    private function setHeaders() {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
    }
}

// Verifique se o arquivo é chamado corretamente
$controller = new ControllerPerson();
$controller->index(); // Chama o método index
