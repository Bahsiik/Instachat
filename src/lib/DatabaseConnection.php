<?php
declare(strict_types=1);

namespace Database;

use PDO;

/**
 * Class DatabaseConnection is a class that represents a database connection
 * @package Database
 */
class DatabaseConnection {
	private ?PDO $database = null;

	/**
	 * getConnection is the function that gets the database connection
	 * @return PDO - the database connection
	 */
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
