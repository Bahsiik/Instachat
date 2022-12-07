<?php
declare(strict_types=1);

namespace Src\Controllers\Users;

use Src\Models\User;
use Src\Models\UserRepository;

class DeleteUser {
	public function execute(User|float $input): void {
		$user_id = $input instanceof User ? $input->id : $input;
		(new UserRepository())->deleteUserById($user_id);
	}
}
