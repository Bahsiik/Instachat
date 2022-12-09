<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\User;
use Models\UserRepository;
use RuntimeException;
use function Lib\Utils\redirect;

class UpdateUserInformation {
	public function execute(User $connected_user, array $input) {
		$display_name = $input['display-name'] ?? $connected_user->display_name;
		$email = $input['email'] ?? $connected_user->email;
		$username = $input['username'] ?? $connected_user->username;

		$user_repository = new UserRepository();
		if ($email !== $connected_user->email) {
			$check_email = $user_repository->getUserByEmail($email);
			if ($check_email) {
				throw new RuntimeException('Email already registered');
			}
		}

		if ($username !== $connected_user->username) {
			$check_username = $user_repository->getUserByUsername($username);
			if ($check_username) {
				throw new RuntimeException('Username already registered');
			}
		}

		$new_user = clone $connected_user;
		$new_user->display_name = $display_name;
		$new_user->username = $username;
		$new_user->email = $email;

		$valid = ($user_repository)->updateUser($new_user);
		if ($valid) redirect('/options');
	}
}
