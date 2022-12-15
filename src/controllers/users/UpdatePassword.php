<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\User;
use Models\UserRepository;
use RuntimeException;
use function Lib\Utils\redirect;

class UpdatePassword {
	public function execute(User $connected_user, array $input): void {
		$old_password = $input['old-password'] ?? throw new RuntimeException('Invalid input');
		$new_password = $input['new-password'] ?? throw new RuntimeException('Invalid input');
		$confirm_password = $input['confirm-password'] ?? throw new RuntimeException('Invalid input');

		$is_password_valid = (new UserRepository())->checkHash($connected_user->username, $old_password);

		if (!$is_password_valid) {
			throw new RuntimeException('Invalid password');
		}

		if ($new_password !== $confirm_password) {
			throw new RuntimeException('Passwords do not match');
		}

		$new_user = clone $connected_user;
		$new_user->password = password_hash($new_password, PASSWORD_DEFAULT);

		(new UserRepository())->updateUser($new_user);

		redirect('/options');
	}
}
