<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/entities/user.entity.php';

class Account extends User {

	public $email;

	public $password;

	public function __construct(?User $user){

		if ($user){

			$this->id = $user->id;
			$this->name = $user->name;
			$this->picture = $user->picture;
			$this->admin = $user->admin;
			$this->state = $user->state;
			$this->updatedAt = $user->updatedAt;
			$this->createdAt = $user->createdAt;

		}

	}

}

?>