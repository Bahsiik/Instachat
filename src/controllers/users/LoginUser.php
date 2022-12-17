<?php
declare(strict_types=1);

namespace Controllers\Users;

require_once 'src/models/User.php';

use Lib\UserException;
use Models\UserRepository;
use function Lib\Utils\redirect;

/**
 * Class LoginUser is a controller that logs in a user
 * @package Controllers\Users
 */
class LoginUser {
	/**
	 * execute is the function that logs in a user
	 * @param array $input - the input of the request
	 * @return void - redirects to the home page
	 */
	public function execute(array $input): void {
		if (!isset($input['email'], $input['password'])) throw new UserException('Identifiants manquants');

		$user_id = (new UserRepository())->loginUser($input['email'], $input['password']);
		if ($user_id !== null) {
			$_SESSION['user_id'] = $user_id->id;
			redirect('/');
		}

		throw new UserException('Mauvais identifiant ou mot de passe');
	}
}
