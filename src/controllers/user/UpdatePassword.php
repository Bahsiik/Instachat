<?php
declare(strict_types=1);

namespace Controllers\User;

use Model\User;
use Model\UserRepository;
use RuntimeException;
use function Lib\Utils\redirect;

class UpdatePassword {
	public function execute(User $connected_user, array $input): void {
		$old_password = $input['old-password'] ?? throw new RuntimeException('Invalid input');
		$new_password = $input['new-password'] ?? throw new RuntimeException('Invalid input');
		$confirm_password = $input['confirm-password'] ?? throw new RuntimeException('Invalid input');

		if ($new_password !== $confirm_password) {
			throw new RuntimeException('Passwords do not match');
		}

		if (!password_verify($old_password, $connected_user->password)) {
			throw new RuntimeException('Invalid password');
		}

		$new_user = clone $connected_user;
		$new_user->password = password_hash($new_password, PASSWORD_DEFAULT);

		(new UserRepository())->updateUser($new_user);

		redirect('/options');
	}
}
