<?php
declare(strict_types=1);

namespace Controllers\User;

use Model\UserRepository;

class DeleteUser {
	public function execute(array $input): void {
		$user_id = (float)$input['user_id'];
		(new UserRepository())->deleteUserById($user_id);
	}
}
