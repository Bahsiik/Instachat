<?php
declare(strict_types=1);

namespace Controllers\Users;

require_once 'src/models/User.php';

use Lib\UserException;
use Models\UserRepository;
use function Lib\Utils\redirect;

/**
 * Class CreateUser is a controller that creates a user
 * @package Controllers\Users
 */
class CreateUser {
	/**
	 * execute is the function that creates a user
	 * @param array $input - the input of the request
	 * @return void - redirects to the home page
	 */
	public function execute(array $input): void {
		if (!isset($input['username'], $input['email'], $input['password'], $input['gender'], $input['birthdate'])) throw new UserException('Identifiants manquants', 1);

		$user_exist = (new UserRepository())->isUserAlreadyRegistered($input['email'], $input['username']);
		if ($user_exist) throw new UserException('Un utilisateur avec ce nom ou cet email existe déjà', 1);

		$birth_date = date_create($input['birthdate']);
		(new UserRepository())->createUser($input['username'], $input['email'], $input['password'], $input['gender'], $birth_date);
		redirect('/login');
	}
}
