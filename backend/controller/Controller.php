<?php


class Controller {
    protected $request;
    protected $response;

    public function __construct() {
        $this->request = json_decode(file_get_contents('php://input'), true);
        $this->response = new Response(); // Certifique-se de que a classe Response está implementada corretamente
    }

    protected function loadModel($model) {
        require_once "model/$model.php"; // Ajuste conforme a estrutura do seu projeto
        $modelName = ucfirst($model);
        $this->$modelName = new $modelName(); // Instancia o modelo
    }
}
