<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/entities/user.entity.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/user.service.php';

class AuthController {

	private ?User $user;
	private UserService $userService;

	public function __construct(array $POST){

		$this->userService = new UserService();

		try{

			if (count($POST)!=2){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('email', $POST)){

				throw new Exception('Email field missing.');

			}

			if (!array_key_exists('password', $POST)){

				throw new Exception('Password field missing.');

			}

			$email = trim($POST['email']);
			$password = trim($POST['password']);

			if (empty($email)){

				throw new Exception('Code field cannot be empty.');

			}

			if (empty($password)){

				throw new Exception('Password field cannot be empty.');

			}

			$this->user = $this->userService->authenticate($email, $password);

		}catch(Exception $e){

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'error',
				'message' => $e->getMessage()

			]);

			exit();

		}

	}

	public function verify(): bool {

		return isset($this->user);;

	}

	public function getUserName(): string {

		return $this->user->name;

	}

	public function getUserID(): string {

		return $this->user->id;

	}

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	try{

		$auth = new AuthController($_POST);

		if (!$auth->verify()){

			throw new Exception('Wrong credentials.');

		}else{

			$name = $auth->getUserName();

			$_SESSION['user_id'] = $auth->getUserID();

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'success',
				'message' => 'Welcome '. $name,
				'url' => '/Pharmacared/src/pages/home/home.page.php'

			]);

			exit();

		}

	}catch(Exception $e){

		header('Content-Type: application/json');

		echo json_encode([

			'status' => 'error',
			'message' => $e->getMessage()

		]);

		exit();

	}

}

?>