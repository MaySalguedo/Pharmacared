<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/common/models/entity.model.php';

class Pharmaceutical extends Entity {

	public string $name;

	public string $description;

	public float $price;

	public string $expiresAt;

	public function __construct(){}

}

?>