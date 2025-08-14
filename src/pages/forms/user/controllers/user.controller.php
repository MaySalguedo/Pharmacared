<?php

	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/entities/account.entity.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/user.service.php';

class UserController{

	private ?Account $user;
	private UserService $userService;

	public function __construct(array $POST, bool $isPatch=false){

		$this->userService = new UserService();

		try{

			if (count($POST)!=4){

				throw new Exception('Number of fields are incongruent.');

			}

			if (!array_key_exists('name', $POST)){

				throw new Exception('Name field missing.');

			}

			if (!array_key_exists('email', $POST)){

				throw new Exception('Email field missing.');

			}

			if (!array_key_exists('password', $POST)){

				throw new Exception('Password field missing.');

			}

			if (!array_key_exists('admin', $POST)){

				throw new Exception('Admin field is missing.');

			}

			$name = trim($POST['name']);
			$email = trim($POST['email']);
			$password = trim($POST['password']);
			$adminBackup = strtolower(trim($POST['admin']));

			if (empty($name)){

				throw new Exception('Name cannot be empty.');

			}

			if (empty($email)){

				throw new Exception('Email cannot be empty.');

			}

			if (empty($password)){

				throw new Exception('DNI cannot be empty.');

			}

			if (empty($adminBackup)){

				throw new Exception('Admin cannot be empty.');

			}

			$isTrue = $adminBackup==='true';
			$isFalse = $adminBackup==='false';

			if (!$isTrue && !$isFalse){

				throw new Exception('Admin field values are incorrect');

			}

			$admin = $isTrue ? 1 : 0;

			if (!$isPatch){

				$this->user = new Account(null);

			}else{

				$this->user = $this->userService->findOneAccount($_SESSION['updated_user']);
				$_SESSION['updated_user'] = '';

			}

			$this->user->name = $name;
			$this->user->email = $email;
			$this->user->password = $password;
			$this->user->admin = $admin;
			$this->user->picture = 'https://avatars.githubusercontent.com/u/'.rand([1, 131812793]).'?v=4';

		}catch(Exception $e){

			header('Content-Type: application/json');

			echo json_encode([

				'status' => 'error',
				'message' => $e->getMessage()

			]);

			exit();

		}

	}

	public function insert(): ?Account{

		return $this->userService->create_account($this->user);

	}

	public function update(): ?Account{

		return $this->userService->update_account($this->user);

	}

}

try{

	$type = '';
	$state = true;

	if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){

		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		if (!isset($data['id'])){

			throw new Exception('ID paramether is missing.');

		}

		$user = User::find_by_dni($data['id']);

		if (!isset($user)){

			throw new Exception('User with id '. $dni .' not found');

		}

		$state = $user->state = !$user->state;

		$user->save();

		$type = 'update';

	} else if ($_SERVER['REQUEST_METHOD']==='POST' && $_SESSION['REAL_METHOD']==='POST') {

		$empController = new UserController($_POST);

		if (!$empController->insert()){

			throw new Exception('Error while inserting');

		}

		$type = 'insert';

	}else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['REAL_METHOD']==='PATCH'){

		$empController = new UserController($_POST, true);

		if (!$empController->update()){

			throw new Exception('Error while updating');

		}

		$type = 'update';

	}

	header('Content-Type: application/json');

	echo json_encode([

		'type' => $type,
		'status' => 'success',
		'state' => $state,
		'message' => 'User succesfully '. $type .'d',
		'url' => '/PurchaseSystem/src/pages/Forms/User/User.page.php'

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