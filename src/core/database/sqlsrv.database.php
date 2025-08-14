<?php

class Database {

	public static function connect() {

		try {

			$host = 'localhost\SQLEXPRESS';//$_ENV('DB_HOST');
			$dbname = 'pharmacared';//$_ENV('DB_NAME');
			$user = 'pharmacared';//$_ENV('DB_USER');
			$password = 'lambda73';//$_ENV('DB_PASSWORD');
			//$charset = $_ENV('DB_CHARSET');

			$dsn = "sqlsrv:Server=$host;Database=$dbname";
			return new PDO($dsn, $user, $password);

		} catch (PDOException $e) {

			die("Error: " . $e->getMessage());
			throw $e;

		}

		return null;

	}

}

?>