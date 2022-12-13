<?php
declare(strict_types=1);

namespace Database;

use PDO;

class DatabaseConnection {
	private ?PDO $database = null;

	public function getConnection(): PDO {
		if ($this->database === null) $this->database = new PDO('mysql:host=localhost;dbname=instachat', 'root', '',
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
			]);

		return $this->database;
	}
}
