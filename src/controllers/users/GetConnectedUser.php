<?php
declare(strict_types=1);

namespace Controllers\Users;

require_once('src/models/User.php');

use Models\User;
use Models\UserRepository;

class GetConnectedUser {
	public function execute(array $input): ?User {
		return (new UserRepository())->getUserById($input['user_id'] ?? -1);
	}
}
