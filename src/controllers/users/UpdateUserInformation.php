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
		$username = $input['username'] ?? $connected_user->username;
		$email = $input['email'] ?? $connected_user->email;

		$user_repository = new UserRepository();
		$check = $user_repository->getAlreadyRegisteredUser($email, $username);
		if ($check?->id !== $connected_user->id) {
			throw new RuntimeException('User already registered');
		}


		$new_user = clone $connected_user;
		$new_user->display_name = $display_name;
		$new_user->username = $username;
		$new_user->email = $email;

		$valid = ($user_repository)->updateUser($new_user);
		if ($valid) redirect('/options');
	}
}
