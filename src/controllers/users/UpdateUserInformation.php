<?php
declare(strict_types=1);

namespace Controllers\Users;

use Lib\UserException;
use Models\User;
use Models\UserRepository;
use function Lib\Utils\redirect;

/**
 * Class UpdateUserInformation is a controller that updates the information of a user
 * @package Controllers\Users
 */
class UpdateUserInformation {
	/**
	 * execute is the function that updates the information of a user
	 * @param User $connected_user - the user to update
	 * @param array $input - the input of the request
	 * @return void - redirects to the home page
	 */
	public function execute(User $connected_user, array $input): void {
		$display_name = $input['display-name'] ?? $connected_user->display_name;
		$email = $input['email'] ?? $connected_user->email;
		$username = $input['username'] ?? $connected_user->username;

		$user_repository = new UserRepository();
		if ($email !== $connected_user->email) {
			$check_email = $user_repository->getUserByEmail($email);
			if ($check_email) throw new UserException('Email déjà utilisé');
		}

		if ($username !== $connected_user->username) {
			$check_username = $user_repository->getUserByUsername($username);
			if ($check_username) throw new UserException("Nom d'utilisateur déjà utilisé");
		}

		if ($display_name === '') $display_name = null;

		$new_user = clone $connected_user;
		$new_user->display_name = $display_name;
		$new_user->username = $username;
		$new_user->email = $email;

		$valid = $user_repository->updateUser($new_user);
		if ($valid) redirect('/options');
	}
}
