<?php
declare(strict_types=1);

namespace Controllers\Users;

use Lib\UserException;
use Models\User;
use Models\UserRepository;
use function Lib\Utils\redirect;

/**
 * Class UpdatePassword is a controller that updates the password of a user
 * @package Controllers\Users
 */
class UpdatePassword {
	/**
	 * execute is the function that updates the password of a user
	 * @param User $connected_user - the user to update
	 * @param array $input - the input of the request
	 * @return void - redirects to the home page
	 */
	public function execute(User $connected_user, array $input): void {
		$old_password = $input['old-password'] ?? throw new UserException('Ancien mot de passe manquant', 1);
		$new_password = $input['new-password'] ?? throw new UserException('Nouveau mot de passe manquant', 1);
		$confirm_password = $input['confirm-password'] ?? throw new UserException('Confirmation du mot de passe manquante', 1);

		$is_password_valid = (new UserRepository())->checkHash($connected_user->username, $old_password);

		if (!$is_password_valid) throw new UserException('Ancien mot de passe incorrect', 1);
		if ($new_password !== $confirm_password) throw new UserException('Les mots de passe ne correspondent pas', 1);

		$new_user = clone $connected_user;
		$new_user->password = password_hash($new_password, PASSWORD_DEFAULT);

		(new UserRepository())->updateUser($new_user);

		redirect('/options');
	}
}
