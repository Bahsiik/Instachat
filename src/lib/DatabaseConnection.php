<?php

namespace Application\Lib\Database;

use PDO;

class DatabaseConnection
{
    private ?PDO $database = null;

    public function getConnection(): PDO
    {
        if ($this->database === null) {
            $this->database = new PDO('mysql:host=localhost;dbname=instachat;charset=utf8', 'root');
        }

        return $this->database;
    }
}