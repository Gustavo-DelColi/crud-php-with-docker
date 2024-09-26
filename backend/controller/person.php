<?php
class ControllerPerson  {
	
	private $error = array();

	public function index() {
		header("Access-Control-Allow-Origin: http://localhost:3000");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type");
		header("Content-Type: application/json");
	
		// Responda a solicitações OPTIONS
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
			exit;
		}
		// $this->load->model('model/person');
		// $results = $this->model_person->readPersons();
		
		// $data = array();
		// foreach ($results as $result) {
			// 	$data[] = array(
		// 		'id'       			        => $result['person_id'],
		// 		'name'       			        => $result['person_name'],
		// 		'phone'       			        => $result['person_phone'],
		// 		'email'       			        => $result['person_email'],
				
		// 	);	
		
		// }
		// $data['success'][] = 'Cadastro realizado com sucesso.';
		// $this->response->addHeader('Content-Type: application/json');
		// $this->response->setOutput(json_encode($data));

		header('Content-Type: application/json');
		echo json_encode([
    		'success' => 'Cadastro realizado com sucesso.'
		]);

	}

	public function add() {
		$this->load->model('model/person');

		$data['success'] = false;
		$data['person_id'] = false;
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $data = $this->model_person->createPerson($data);
            
			$data['success'][] = 'Cadastro realizado com sucesso.';
	
		}

		$data['error'] = false;
		if (count($this->error) > 0) {
			$data['error'] = $this->error;
		}


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	private function validate() {
		$key_required = ['name','phone','email'];
		foreach ($key_required as $key) {
			if (!array_key_exists($key, $this->request->json)) {
				$this->error[] = 'Dados inválidos, verifique e tente novamente.'.  $key;
				return false;
			} 
		}

		return !$this->error;
	}

	private function format($data) {


		$data_formated = array();

		$partes_nome = explode(' ', $data['receiver']);
		$firstname   = $partes_nome[0];
		$lastname    = implode(' ', array_slice($partes_nome, 1));
	
		$data_formated['firstname']                  = $firstname;
		$data_formated['lastname']	                 = $lastname;
		$data_formated['address_1']	                 = $data['street'];
		$data_formated['address_2']	                 = $data['district'];
		$data_formated['city']	      	             = $data['city'];
		$data_formated['postcode'] 		             = preg_replace('/[^\d]/i', '', $data['cep']);
		$data_formated['country_id']	             = $data['country_id'];
		$data_formated['zone_id']	                 = $data['zone_id'];
		$data_formated['custom_field']['address']	 = array(
			'2' =>  isset($data['number']) ? $data['number'] : '',
			'3' =>  isset($data['complement']) ? $data['complement'] : '',

		);

		return $data_formated;
	}

	public function edit() {
		$this->load->model('account/address');
		$data['success'] = false;
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_person->editAddress($this->request->json['address_id'], $this->format($this->request->json));
			$data['success'][] = 'Cadastro atualizado com sucesso.';
		}

		$data['response'] = $this->request->json;
		$data['error'] = false;
		if (count($this->error) > 0) {
			$data['error'] = $this->error;
		}


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	public function delete() {
		$this->load->model('account/address');
		$data['success'] = false;
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_person->deleteAddress($this->request->json['address_id'], $this->format($this->request->json));
			$data['success'] = 'Endereço excluído.';

		}
		$data['error'] = false;
		if (count($this->error) > 0) {
			$data['error'] = $this->error;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}



	public function getAddressCep() {
		
		if(isset($this->request->json['cep'])) {
			$url = 'https://viacep.com.br/ws/'.$this->request->json['cep'].'/json/';
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			curl_close($curl);

			if ($response == false) {
				$endereco = array();
			} else {
				$endereco = json_decode($response, true);
				$endereco['success'] = true;
			}

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($endereco));
		}
	}	

	public function getZone() {

		$this->load->model('localisation/zone');
		$zone_info = $this->model_localisation_zone->getZonesByCountryId(30);

		$data = array();
		
		foreach ($zone_info as $zone) {
			$data[] = array(
				'uf'				 	=> isset($zone['code']) ? $zone['code'] : '',
				'name'       			=> isset($zone['name']) ? $zone['name'] : '',
				'zone_id'      			=> isset($zone['zone_id']) ? $zone['zone_id'] : '',
				'country_id'       		=> isset($zone['country_id']) ? $zone['country_id'] : '',

			);
		}


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

}