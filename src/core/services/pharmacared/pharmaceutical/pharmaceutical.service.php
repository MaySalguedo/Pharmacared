<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/pharmaceutical/entities/pharmaceutical.entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/database/sqlsrv.database.php';

class PharmaceuticalService {

	private $pdo = null;

	public function __construct(){

		$this->pdo = Database::connect();

	}

	public function findOne(string $id): ?Pharmaceutical {

		$stmt = $this->pdo->prepare("SELECT * FROM pharma.pharmaceutical WHERE id = ?;");
		$stmt->execute([$id]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($user)) return null;

		return self::cast_pharmaceutical($user);

	}

	public function findAll(): array {

		$stmt = $this->pdo->prepare("SELECT * FROM pharma.pharmaceutical ORDER BY updatedat DESC;");
		$stmt->execute([]);
		$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($user)) return [];

		return self::cast_pharmaceutical_array($user);

	}

	public function insert(Pharmaceutical $pharma): void {

		$stmt = $this->pdo->prepare("

			INSERT INTO pharma.pharmaceutical (

				name, description, price, expiresat

			) VALUES (

				?, ?, ?, ?

			);

		");

		$stmt->execute([

			$pharma->name, $pharma->description, $pharma->price, $pharma->expiresAt

		]);

	}

	public function update(Pharmaceutical $pharma): void {

		$stmt = $this->pdo->prepare("

			UPDATE pharma.pharmaceutical SET

				name = ?,
				description = ?,
				price = ?,
				expiresat = ?

			WHERE id = ?;

		");

		$stmt->execute([

			$pharma->name, $pharma->description, $pharma->price, $pharma->expiresAt, $pharma->id

		]);

	}

	public function toggle(string $id, int $state): void {

		$stmt = $this->pdo->prepare("UPDATE pharma.pharmaceutical SET state = ? WHERE id = ?");
		$stmt->execute([

			$state, $id

		]);

	}

	private function cast_pharmaceutical(array $resultSet): Pharmaceutical {

		$pharma = new Pharmaceutical();

		$pharma->id = $resultSet['id'];
		$pharma->name = $resultSet['name'];
		$pharma->description = $resultSet['description'];
		$pharma->price = floatval($resultSet['price']);
		$pharma->state = $resultSet['state'];
		$pharma->expiresAt = $resultSet['expiresat'] ?? $resultSet['expiresAt'];
		$pharma->updatedAt = $resultSet['updatedat'] ?? $resultSet['updatedAt'];
		$pharma->createdAt = $resultSet['createdat'] ?? $resultSet['createdAt'];

		return $pharma;

	}

	private function cast_pharmaceutical_array(array $resultSet): array {

		$result = [];
		foreach ($resultSet as $pharmaData) {

			$result[] = $this->cast_pharmaceutical($pharmaData);

		}

		return $result;

	}

}