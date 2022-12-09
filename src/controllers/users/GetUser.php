<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\User;
use Models\UserRepository;

require_once('src/models/User.php');

class GetUser {
	public function execute(float $id): ?User {
		return (new UserRepository())->getUserById($id);
	}
}
