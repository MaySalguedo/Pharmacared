<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/common/models/entity.model.php';

class User extends Entity {

	public $name;

	public $picture;

	public $admin;

	public function __construct(){}

}

?>