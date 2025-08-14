<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/pharmaceutical/entities/pharmaceutical.entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/pharmaceutical/pharmaceutical.service.php';

class PharmaceuticalController{

	private ?Pharmaceutical $pharma;
	private PharmaceuticalService $pharmaService;

	public function __construct(array $POST, bool $isPatch=false){

		$this->pharmaService = new PharmaceuticalService();

		try{

			if (count($POST)!=4){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('name', $POST)){

				throw new Exception('Name field missing.');

			}

			if (!array_key_exists('description', $POST)){

				throw new Exception('Description field missing.');

			}

			if (!array_key_exists('price', $POST)){

				throw new Exception('Price field missing.');

			}

			if (!array_key_exists('expiresat', $POST)){

				throw new Exception('Expires at field missing.');

			}

			$name = trim($POST['name']);
			$description = trim($POST['description']);
			$price = trim($POST['price']);
			$expiresat = trim($POST['expiresat']);

			if (empty($name)){

				throw new Exception('Name cannot be empty.');

			}

			if (empty($description)){

				throw new Exception('Description cannot be empty.');

			}

			if (empty($price) || $price<1){

				throw new Exception('Price cannot either be empty nor les than $1.');

			}

			if (empty($expiresat)){

				throw new Exception('Expires at cannot be empty.');

			}

			if (date('Y-m-d', strtotime($expiresat))<=date('Y-m-d')){

				throw new Exception('Expires at cannot lower than today.');

			}

			if (!$isPatch){

				$this->pharma = new Pharmaceutical();

			}else{

				$this->pharma = $this->pharmaService->findOne($_SESSION['updated_pharma']);
				$_SESSION['updated_pharma'] = '';

			}

			$this->pharma->name = $name;
			$this->pharma->description = $description;
			$this->pharma->price = floatval($price);
			$this->pharma->expiresAt = $expiresat;

		}catch(Exception $e){

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'error',
				'message' => $e->getMessage()

			]);

			exit();

		}

	}

	public function insert(): void {

		$this->pharmaService->insert($this->pharma);

	}

	public function update(): void {

		$this->pharmaService->update($this->pharma);

	}

}

try {

	$type = '';
	$state = true;

	if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){

		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		if (!isset($data['id'])){

			throw new Exception('ID paramether is missing.');

		}

		$service = new PharmaceuticalService();

		$state = $service->findOne($data['id'])->state==1 ? 0 : 1;

		$service->toggle($data['id'], $state);

		$type = $state==1 ? 'activate' : 'deactivate';

	} else if ($_SERVER['REQUEST_METHOD']==='POST' && $_SESSION['REAL_METHOD']==='POST') {

		$empController = new PharmaceuticalController($_POST);

		$empController->insert();

		$type = 'inserte';

	}else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['REAL_METHOD']==='PATCH'){

		$empController = new PharmaceuticalController($_POST, true);

		$empController->update();

		$type = 'update';

	}

	header('Content-Type: application/json');

	echo json_encode([

		'type' => $type,
		'status' => 'success',
		'state' => $state,
		'message' => 'Pharmaceutical succesfully '. $type .'d',
		'url' => '/Pharmacared/src/pages/forms/pharmaceutical/pharmaceutical.page.php'

	]);

	exit();

}catch(Exception $e){

	header('Content-Type: application/json');

	echo json_encode([

		'status' => 'error',
		'message' => $e->getMessage()

	]);

	exit();

}

?>