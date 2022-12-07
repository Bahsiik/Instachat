<?php

namespace Controllers\User;

require_once('src/model/User.php');

use Exception;
use Model\UserRepository;
use RuntimeException;
use function Lib\Utils\redirect;

class LoginUser {
	/**
	 * @throws Exception
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
