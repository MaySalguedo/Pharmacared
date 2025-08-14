<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/entities/user.entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/entities/account.entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/database/sqlsrv.database.php';

class UserService {

	private $pdo = null;

	public function __construct(){

		$this->pdo = Database::connect();

	}

	public function findOneAccount(string $id): ?Account {

		$stmt = $this->pdo->prepare("SELECT * FROM auth.get_account(?);");
		$stmt->execute([$id]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($user)) return null;

		return self::cast_account($user);

	}

	public function findOne(string $id): ?User {

		$stmt = $this->pdo->prepare("SELECT * FROM auth.[user] WHERE id = ?;");
		$stmt->execute([$id]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($user)) return null;

		return self::cast_user($user);

	}

	public function findAll(): array {

		$stmt = $this->pdo->prepare("SELECT * FROM auth.[user] ORDER BY updatedat DESC;");
		$stmt->execute([]);
		$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($user)) return [];

		return self::cast_user_array($user);

	}

	public function findAllAccounts(): array {

		$stmt = $this->pdo->prepare("SELECT * FROM auth.get_account(?);");
		$stmt->execute([null]);
		$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($user)) return [];

		return self::cast_account_array($user);

	}

	public function update_account(Account $account): ?Account {

		$stmt = $this->pdo->prepare("

			EXEC auth.update_account 
				@id = ?,
				@email = ?,
				@password = ?,
				@name = ?,
				@admin = ?,
				@picture = ?;

		");
		$stmt->execute([

			$account->id, $account->email, $account->password, $account->name, $account->admin, $account->picture
	
		]);

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($user)) return null;

		return self::cast_account($user);

	}/**/

	public function create_account(Account $account): ?Account {

		$stmt = $this->pdo->prepare("

			EXEC auth.create_account 
				@email = ?,
				@password = ?,
				@name = ?,
				@admin = ?,
				@picture = ?;

		");
		$stmt->execute([

			$account->email, $account->password, $account->name, $account->admin, $account->picture
	
		]);

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($user)) return null;

		return self::cast_account($user);

	}

	public function toggle(string $id, int $state): void {

		$stmt = $this->pdo->prepare("UPDATE auth.[user] SET state = ? WHERE id = ?");
		$stmt->execute([

			$state, $id

		]);

	}

	public function authenticate(string $email, string $password): ?User {

		$stmt = $this->pdo->prepare("SELECT * FROM auth.authenticate(?, ?)");
		$stmt->execute([$email, $password]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($user)) return null;

		return self::cast_user($user);

	}

	private function cast_user(array $resulSet): User {

		$user = new User();

		$user->id = $resulSet['id'];
		$user->name = $resulSet['name'];
		$user->picture = $resulSet['picture'];
		$user->admin = $resulSet['admin'];
		$user->state = $resulSet['state'];
		$user->updatedAt = $resulSet['updatedat'] ?? $resulSet['updatedAt'];
		$user->createdAt = $resulSet['createdat'] ?? $resulSet['createdAt'];

		return $user;

	}

	private function cast_account(array $resulSet): Account {

		$account = new Account($this->cast_user($resulSet));

		$account->email = $resulSet['email'];
		$account->password = null;

		return $account;

	}

	private function cast_user_array(array $resulSet): array {

		$result = [];
		foreach ($resulSet as $userData) {

			$result[] = $this->cast_user($userData);

		}

		return $result;

	}

	private function cast_account_array(array $resulSet): array {

		$result = [];
		foreach ($resulSet as $accountData) {

			$result[] = $this->cast_account($accountData);

		}

		return $result;

	}

}
/*
$userService = new UserService();

$user = $userService->findOneAccount('c402dbb3-ef35-4bd0-9674-152c4cd90e86');

$user->name = 'Danito';
$user->email = 'danito@gmail.com';
$user->admin = 0;

$user = $userService->create_account($user);

var_dump($user);
/**/
?>