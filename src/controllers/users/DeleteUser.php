<?php
declare(strict_types=1);

namespace Controllers\Users;

use Lib\UserException;
use Models\User;
use Models\UserRepository;
use function Lib\Utils\redirect;

/**
 * Class DeleteUser is a controller that deletes a user
 * @package Controllers\Users
 */
class DeleteUser {
	/**
	 * execute is the function that deletes a user
	 * @param User $user - the user to delete
	 * @param array $input - the input of the request
	 * @return void - redirects to the home page
	 */
	public function execute(User $user, array $input): void {
		$password = $input['password'] ?? throw new UserException('Identifiants manquants', 5);
		$is_valid = (new UserRepository())->checkHash($user->email, $password);
		if (!$is_valid) throw new UserException('Mot de passe incorrect', 5);

		(new UserRepository())->deleteUserById($user->id);
		redirect('/create');
	}
}
