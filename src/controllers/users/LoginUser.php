<?php
declare(strict_types=1);

namespace Controllers\Users;

require_once 'src/models/User.php';

use Models\UserRepository;
use RuntimeException;
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
		$log_in = ['email', 'password'];
		foreach ($log_in as $value) {
			if (!isset($input[$value])) throw new RuntimeException('Invalid input');
		}

		$user_id = (new UserRepository())->loginUser($input['email'], $input['password']);
		if ($user_id !== null) {
			$_SESSION['user_id'] = $user_id->id;
			redirect('/');
		} else {
			redirect('/create');
		}
	}
}
