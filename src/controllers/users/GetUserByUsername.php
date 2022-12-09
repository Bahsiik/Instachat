<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\User;
use Models\UserRepository;

class GetUserByUsername {
	public function execute(string $username): ?User {
		return (new UserRepository())->getUserByUsername($username);
	}
}